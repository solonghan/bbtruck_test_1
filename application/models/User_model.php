<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends Base_Model {
	private $user_identify_key = "email";

	private $fb_app_id = '2502322560038825';
	private $fb_app_secret = 'ea032ac4128c4be5ac995df8b71319a4';
	private $fb_version = 'v5.0';
	private $fb_callback = 'member/fb_callback';

	private $g_CLIENT_ID = '16568070192-on37ujqtbr9muklp0ti63shepps9e8fg.apps.googleusercontent.com';
	private $g_CLIENT_SECRET = 'KncEd8x4zDTMpdGKXcELBJEA';
	private $g_CLIENT_REDIRECT_URL = 'member/g_callback';

	private $loginpage = 'login';


	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

	public function update_push_token($user_id, $push_token, $os){
		$syntax = array(
			"user_id"    =>	$user_id,
			"push_token" =>	$push_token,
			"os"         =>	$os
		);
		if ($this->db->get_where($this->push_token_table, array("user_id"=>$user_id))->num_rows() > 0) {
			$this->db->delete($this->push_token_table, array("user_id"=>$user_id));
		}
		$this->db->insert($this->push_token_table, $syntax);
	}

	public function user_reward($user_id, $point = 0, $shell = 0, $sticket = 0, $bticket = 0, $coin = 0){
		$user = $this->get_data($user_id);
		$update_data = array();
		//anbon
		if ($point > 0) {
			$update_data['exp'] = $user['exp'] + intval($point);
		}

		if ($shell > 0) {
			$update_data['shell'] = $user['shell'] + intval($shell);	
		}

		if ($sticket > 0) {
			$update_data['sticket'] = $user['sticket'] + intval($sticket);
		}

		if ($bticket > 0) {
			$update_data['bticket'] = $user['bticket'] + intval($bticket);
		}

		if ($coin > 0) {
			$update_data['coin'] = $user['coin'] + intval($coin);
		}

		if (count($update_data) > 0) {
			return $this->edit($user_id, $update_data);
		}else{
			return FALSE;
		}
	}

	//subscribe
	public function add_subscribe($user_id, $target_id){
		$data = array(
			"user_id"	=>	$user_id,
			"target_id"	=>	$target_id
		);
		if ($this->db->get_where($this->subscribe_table, $data)->num_rows() <= 0) {
			return $this->db->insert($this->subscribe_table, $data);
		}
		return TRUE;
	}

	public function del_subscribe($user_id, $target_id){
		$data = array(
			"user_id"	=>	$user_id,
			"target_id"	=>	$target_id
		);
		if ($this->db->get_where($this->subscribe_table, $data)->num_rows() > 0) {
			return $this->db->delete($this->subscribe_table, $data);
		}
		return TRUE;
	}

	public function check_subscribe($user_id, $target_id){
		$data = array(
			"user_id"	=>	$user_id,
			"target_id"	=>	$target_id
		);
		if ($this->db->get_where($this->subscribe_table, $data)->num_rows() > 0) return TRUE;
		return FALSE;
	}

	//friends
	public function check_friend_status($user_id, $target_id){
		$syntax = array(
			"user_id"	=>	$user_id,
			"target_id"	=>	$target_id
		);
		$a = $this->db->get_where($this->friends_table, $syntax)->row_array();
		if ($a != null) {
			if ($a['status'] == 'normal') return 'friend';
			if ($a['status'] == 'pending') return 'waiting_for_apply';
		}
		$syntax = array(
			"user_id"	=>	$target_id,
			"target_id"	=>	$user_id
		);
		$b = $this->db->get_where($this->friends_table, $syntax)->row_array();
		if ($b != null) {
			if ($b['status'] == 'normal') return 'friend';
			if ($b['status'] == 'pending') return 'waiting_your_apply';
		}
		return 'nothing';
	}
	public function edit_friend($user_id, $target_id, $data){
		$syntax = array(
			"user_id"	=>	$user_id,
			"target_id"	=>	$target_id
		);
		if ($this->db->get_where($this->friends_table, $syntax)->num_rows() <= 0) return FALSE;
		return $this->db->where($syntax)->update($this->friends_table, $data);
	}

	public function add_friend($user_id, $target_id, $status = 'pending'){
		$data = array(
			"user_id"	=>	$user_id,
			"target_id"	=>	$target_id
		);

		if ($this->db->get_where($this->friends_table, $data)->num_rows() <= 0) {
			$data['status'] = $status;
			$this->db->insert($this->friends_table, $data);
		}
		return TRUE;
	}

	public function del_friend($user_id, $target_id){
		$data = array(
			"user_id"	=>	$user_id,
			"target_id"	=>	$target_id
		);

		if ($this->db->get_where($this->friends_table, $data)->num_rows() > 0) {
			$this->db->delete($this->friends_table, $data);
			$this->db->delete($this->friends_table, array(
				"user_id"	=>	$target_id,
				"target_id"	=>	$user_id
			));
		}
		return TRUE;
	}

	public function get_friend($user_id, $target_id){
		$data = array(
			"F.user_id"   =>	$user_id,
			"F.target_id" =>	$target_id
		);
		if ($this->db->get_where($this->friends_table." F", $data)->num_rows() <= 0) return FALSE;

		return $this->db->select("U.*")
						->from($this->friends_table." F")
						->join($this->user_table." U", "F.target_id = U.id", "left")
						->where($data)
						->get()->row_array();
	}

	public function get_friends_id($user_id){
		return $this->db->get_where($this->friends_table, array("user_id"=>$user_id, "status"=>"normal"))->result_array('target_id');
	}

	public function get_friends_detail($user_id, $search = "", $page = 1, $page_count = 24){
		$syntax = "F.user_id = '{$user_id}' AND F.target_id > 0";
		if ($search != "") {
			$syntax .= " AND (U.username LIKE '%".$search."%' OR U.nickname Like '%".$search."%')";
		}

		$total = $this->db->select("U.*")
						 ->from($this->friends_table." F")
						 ->join($this->user_table." U", "F.target_id = U.id", "left")
						 ->where($syntax)
						 ->group_by("U.id")
						 ->get()->num_rows();
		$total_page = ($total % $page_count == 0) ? floor(($total)/$page_count) : floor(($total)/$page_count) + 1;

		$list = $this->db->select("U.*")
						 ->from($this->friends_table." F")
						 ->join($this->user_table." U", "F.target_id = U.id", "left")
						 ->where($syntax)
						 ->limit($page_count, ($page-1)*$page_count)
						 ->order_by("F.create_date DESC")
						 ->group_by("U.id")
						 ->get()->result_array();
		for ($i=0; $i < count($list); $i++) { 
			$list[$i] = $this->User_model->get_user_formatted($list[$i]['id'], $list[$i]);
		}
		return array(
			"page"       =>	$page,
			"total_page" =>	$total_page,
			"total"      =>	$total,
			"data"       =>	$list,
			"search"     =>	$search
		);
	}

	public function check_user_atid_exist($atid, $user_id = FALSE){
		$data = array("atid"=>$atid);
		if ($user_id !== FALSE) $data['id<>']=$user_id;
		return ($this->db->get_where($this->user_table, $data)->num_rows() > 0)?TRUE:FALSE;
	}

	public function generate_user_atid($user_id){
		$atid = "";
		$exist_atid = $this->db->get($this->user_table)->result_array("atid");
		do{
			$atid = strtolower($this->generate_code(6));
		}while(array_key_exists($atid, $exist_atid));

		$this->edit($user_id, array("atid"=>$atid));
	}

	//user
	public function get_all_user(){
		return $this->db->get_where($this->user_table, array("is_delete"=>0))->result_array();
	}

	public function get_user_formatted($user_id, $user = FALSE){
		if ($user === FALSE) $user = $this->get_data($user_id);

		return array(
			"id"        =>	$user_id,
			"nickname"  =>	$user['nickname'],
			"atid"      =>	$user['atid'],
			"tribe"     =>	$user['tribe'],
			"vip"       =>	$user['vip'],
			"level"     =>	$user['level'],
			"level_str" =>	$this->Setting_model->get_level_str($user['level'])." Lv.".$user['level'],
			"avatar"    =>	($user['avatar']!="")?base_url().$user['avatar']:base_url()."cat/cat_counter.png",
			"medal"     =>	$this->Setting_model->get_user_medal($user_id)
		);
	}
	
	public function get_data($user_id, $fields = "*"){
		$this->db->select($fields);
		$this->db->from($this->user_table);
		$this->db->where(
			array("id"=>$user_id)
		);
		return $this->db->get()->row_array();
	}

	public function get_data_by_identify($user_identify_key, $fields = "*"){
		$this->db->select($fields);
		$this->db->from($this->user_table);
		$this->db->where(
			array($this->user_identify_key=>$user_identify_key)
		);
		return $this->db->get()->row_array();
	}

	public function get_data_by_key($key, $value, $fields = "*"){
		$this->db->select($fields);
		$this->db->from($this->user_table);
		$this->db->where(
			array($key=>$value)
		);
		return $this->db->get()->row_array();
	}

	public function get_data_by_social_id($social_type, $social_id, $fields = "*"){
		$key = "";
		if ($social_type == 'fb') {
			$key = 'fb_id';
		}else if ($social_type == 'google') {
			$key = 'g_id';
		}else if ($social_type == 'apple') {
			$key = 'apple_id';
		}else if ($social_type == 'line') {
			$key = 'line_id';
		}
		$this->db->select($fields);
		$this->db->from($this->user_table);
		$this->db->where(
			array($key=>$social_id)
		);
		return $this->db->get()->row_array();
	}

	public function social_account_exist($social_type, $social_id, $email = ''){
		$key = "";
		$value = $social_id;
		if ($email != "") {
			$key = "email";
			$value = $email;
		}else if ($social_type == 'fb') {
			$key = 'fb_id';
		}else if ($social_type == 'google') {
			$key = 'g_id';
		}else if ($social_type == 'apple') {
			$key = 'apple_id';
		}else if ($social_type == 'line') {
			$key = 'line_id';
		}
		$this->db->select("*");
		$this->db->from($this->user_table);
		$this->db->where(
			array($key=>$value)
		);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
			// if ($email != '') {
			// 	if ($social_type == 'fb') {
			// 		$key = 'fb_id';
			// 	}else if ($social_type == 'google') {
			// 		$key = 'g_id';
			// 	}else if ($social_type == 'apple') {
			// 		$key = 'apple_id';
			// 	}else if ($social_type == 'line') {
			// 		$key = 'line_id';
			// 	}
			// 	$this->edit($r->id, array($key=>$social_id));
			// }
			return TRUE;
		}
	}

	public function social_bind($user_id, $social_type, $social_id){
		if ($social_type == 'fb') {
			$key = 'fb_id';
		}else if ($social_type == 'google') {
			$key = 'g_id';
		}else if ($social_type == 'apple') {
			$key = 'apple_id';
		}else if ($social_type == 'line') {
			$key = 'line_id';
		}
		if($this->db->where(array("id"=>$user_id))->update($this->user_table, array($key=>$social_id))){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function account_exist($user_identify_key){
		$this->db->select("*");
		$this->db->from($this->user_table);
		$this->db->where(
			array($this->user_identify_key=>$user_identify_key)
		);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function pwd_confirm($pwd_md5encrypt, $user_identify_key){
		$this->db->select("*");
		$this->db->from($this->user_table);
		$this->db->where(
			array($this->user_identify_key=>$user_identify_key)
		);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
			if ($this->encryption->decrypt($r->password) == $pwd_md5encrypt) {
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}


	public function edit($id, $data){
		return $this->db->where(array("id"=>$id))->update($this->user_table, $data);
	}


	public function can_send_sms($phone){
		$this->db->select("*");
		$this->db->from("sms_log");
		$this->db->where("phone = '{$phone}' AND create_date > '".date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) - 60*3)."'");
		if($this->db->get()->num_rows() > 0){
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function exsit_check($phone){
		$exsit = $this->db->get_where($this->user_table, array("phone"=>$phone))->row();
		if ($exit) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function verify_check($phone, $code){
		$this->db->select("*");
		$this->db->from($this->user_table);
		$this->db->where(
			array("phone"=>$phone, "verify_code"=>$code)
		);
		$r = $this->db->get()->row();
		if($r == null){
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function send_sms($phone, $destName, $msg){
		$username = "82955186";
		$password = "iwish82955186";
		// $username = "50875169";
		// $password = "Pass82962755";
		
		$encoding = "UTF8";
		$dlvtime = "";			//預約簡訊YYYYMMDDHHNNSS，若為空則為即時簡訊
		$vldtime = "3600";		//簡訊有效時間YYYYMMDDHHNNSS，整數值為幾秒後內有限，不可超過24hr
		$smsbody = $msg;
								//簡訊內容，空白直接空白即可，換行請使用 chr(6)
		$response = "";			//簡訊狀態回報網址
		$ClientID = "";			//用於避免重複發送(不太會用到)

		$url = "https://smsapi.mitake.com.tw/api/mtk/SmSend?username=".$username."&password=".$password."&dstaddr=".$phone."&encoding=".$encoding."&DestName=".$destName."&dlvtime=".$dlvtime."&vldtime=".$vldtime."&smbody=".$smsbody."&response=".$response."&ClientID=".$ClientID;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

		$r=curl_exec($ch);
		curl_close($ch);
		// echo $r;
		$this->db->insert("sms_log", array("phone"=>$phone, "content"=>$msg));
	}

	public function send_mail($email, $body, $subject = ""){
		$mail = new PHPMailer();

		$mail->IsSMTP();
		
		$mail->SMTPDebug = 2;
		// $mail->Host = "localhost";
		$mail->CharSet = "utf-8";
		  
		//Google 寄信
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465;
		$mail->Username = "anbon.tw@gmail.com";
		$mail->Password = "vxtseczukfobscgb";
		
		$mail->From = "anbon.tw@gmail.com";
		$mail->FromName = "ANBONTW";
			  
		$mail->Subject = $subject;
		  
		$mail->IsHTML(true);
		$mail->AddAddress($email, $email);
		$mail->Body = $body;

		if($mail->Send()) {
			return array("status"=>TRUE);
		} else {
			return array("status"=>FALSE, "msg"=>$mail->ErrorInfo);
		}
		$mail->ClearAddresses(); 
	}


	//Login


	public function login($data){
		$data["isLogin"] = $this->encryption->encrypt(md5("uLogIn"));

		$data['id'] = $this->encryption->encrypt($data['id']);

		$this->session->set_userdata($data);
	}

	public function check_login(){
		if ($this->session->isLogin && $this->encryption->decrypt($this->session->isLogin) == md5("uLogIn")) {
			return $this->get_data($this->encryption->decrypt($this->session->id));
		}else{
			return FALSE;
		}
	}

	public function is_login(){
		if (!($this->session->isLogin && $this->encryption->decrypt($this->session->isLogin) == md5("uLogIn"))) {
			header("Location: ".base_url());
		}
	}

	public function register($data, $is_exist = FALSE){
		if ($is_exist) {
			$this->db->where(array($this->user_identify_key=>$data[$this->user_identify_key]));
			return $this->db->update($this->user_table, $data);
		}else{
			$this->db->insert($this->user_table, $data);
			return $this->db->insert_id();
		}
	}

	/*
	GOOGLE LOGIN
	 */
	
	public function g_login(){
		$login_url = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me') . '&redirect_uri=' . urlencode($this->g_CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . $this->g_CLIENT_ID . '&access_type=online';

		header("Location: ".$login_url);
	}

	public function g_callback(){
		if($this->input->get("code")) {
			try {
				// Get the access token 
				$data = $this->g_GetAccessToken($this->g_CLIENT_ID, $this->g_CLIENT_REDIRECT_URL, $this->g_CLIENT_SECRET, $this->input->get("code"));
				$user_info = $this->g_GetUserProfileInfo($data['access_token']);
				return array(
					"name"	=>	$user_info['displayName'],
					"id"	=>	$user_info['id'],
					"email"	=>	$user_info['emails'][0]['value'],
					"pic"	=>	$user_info['image']['url']
				);
			}
			catch(Exception $e) {
				echo $e->getMessage();
				exit();
			}
		}
	}

	private function g_GetAccessToken($client_id, $redirect_uri, $client_secret, $code) {	
		$url = 'https://accounts.google.com/o/oauth2/token';			
		
		$curlPost = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code='. $code . '&grant_type=authorization_code';
		$ch = curl_init();		
		curl_setopt($ch, CURLOPT_URL, $url);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		
		curl_setopt($ch, CURLOPT_POST, 1);		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);	
		$data = json_decode(curl_exec($ch), true);
		$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);		
		if($http_code != 200) 
			throw new Exception('Error : Failed to receieve access token');
			
		return $data;
	}

	private function g_GetUserProfileInfo($access_token) {	
		$url = 'https://www.googleapis.com/plus/v1/people/me';			
		
		$ch = curl_init();		
		curl_setopt($ch, CURLOPT_URL, $url);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token));
		$data = json_decode(curl_exec($ch), true);
		
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);		
		if($http_code != 200) 
			throw new Exception('Error : Failed to get user information');
			
		return $data;
	}

	/*
	FB LOGIN
	 */
	
	public function fb_login(){
		if (!session_id()) {
		    session_start();
		}
		$fb = new Facebook\Facebook([
            'app_id' => $this->fb_app_id,
		    'app_secret' => $this->fb_app_secret,
		    'default_graph_version' => $this->fb_version,
        ]);

        $helper = $fb->getRedirectLoginHelper();

		$permissions = ['public_profile','email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl(base_url().$this->fb_callback, $permissions);
        header("Location: ".$loginUrl);
	}

	public function fb_callback(){
		$fb = new Facebook\Facebook([
            'app_id' => $this->fb_app_id,
		    'app_secret' => $this->fb_app_secret,
		    'default_graph_version' => $this->fb_version,
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
        	//嚴格模式下，要代入callback的url
        	$accessToken = $helper->getAccessToken(base_url().$this->fb_callback);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
	        echo 'Graph returned an error: ' . $e->getMessage();
	        header("Location: ".base_url().$this->loginpage);
	        exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
        	echo 'Facebook SDK returned an error: ' . $e->getMessage();
        	header("Location: ".base_url().$this->loginpage);
        	exit;
        }

        if (! isset($accessToken)) {
	        if ($helper->getError()) {
	            header('HTTP/1.0 401 Unauthorized');
	            echo "Error: " . $helper->getError() . "\n";
	            echo "Error Code: " . $helper->getErrorCode() . "\n";
	            echo "Error Reason: " . $helper->getErrorReason() . "\n";
	            echo "Error Description: " . $helper->getErrorDescription() . "\n";
	            header("Location: ".base_url().$this->loginpage);
	        } else {
	            header('HTTP/1.0 400 Bad Request');
	            echo 'Bad request';
	        }
	        exit;
        }

		$response = $fb->get('/me?fields=id,name,email,picture.type(large)', $accessToken->getValue());
		$user = $response->getGraphUser();
		return $user;
		// $user['name'];
		// $user['id'];
		// $user['email'];
	}
}