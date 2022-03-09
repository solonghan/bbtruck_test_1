<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_mgr_model extends Base_Model {

private $sub_medal = <<<USER_LIST_MEDAL
( SELECT CONCAT( '[', GROUP_CONCAT( CONCAT('{"medal_name":"', M.img,'"}') ), ']' ) FROM `user_medal_related` as Um LEFT JOIN `medal` as M ON M.id = Um.medal_id WHERE Um.user_id = U.id AND M.type = 'honer' ) as medal_name
USER_LIST_MEDAL;

private $sub_local_club = <<<USER_LIST_LOCAL_CLUB
( SELECT CONCAT( '[', GROUP_CONCAT( CONCAT('{"local_club_name":"', C.show_name,'"}') ),']' ) FROM `club` as C LEFT JOIN `user_club_related` as Uc ON Uc.club_id = C.id WHERE Uc.user_id = U.id AND C.type = 'local') as local_club_name
USER_LIST_LOCAL_CLUB;

	private $page_count = 9;
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

	public function get_page_users($syntax, $order_by, $page)
	{
		return $this->db->select('U.*, ' . $this->sub_medal . ', ' . $this->sub_local_club)
						->from($this->user_table . ' as U')
						->where($syntax)
        				->group_by('U.id')
						->order_by($order_by)
        				->limit($this->page_count, ($page-1)*$this->page_count)
        				->get()
        				->result_array();
	}

	public function get_all_user_num($syntax)
	{
		return $this->db->select('U.id')
						->from($this->user_table . ' as U')
						->where($syntax)
						->get()
						->num_rows();
	}

	public function get_all_friends_num($syntax)
	{
		return $this->db->select('U.id')
						->from($this->friends_table . ' as F')
						->join($this->user_table . ' as U', 'F.target_id = U.id', 'left')
						->where($syntax)
						->get()
						->num_rows();
	}

	public function get_all_friends($syntax, $order_by, $page)
	{
		return $this->db->select('U.*, ' . $this->sub_medal . ', ' . $this->sub_local_club)
						->from($this->friends_table . ' as F')
						->join($this->user_table . ' as U', 'F.target_id = U.id', 'left')
						->where($syntax)
        				->group_by('U.id')
						->order_by($order_by)
        				->limit($this->page_count, ($page-1)*$this->page_count)
						->get()
						->result_array();
	}

	public function get_all_h_club_num($syntax)
	{
		return $this->db->select('C.*')
						->from($this->user_club_related_table . ' as R')
						->join($this->club_table . ' as C', 'C.id = R.club_id', 'left')
						->where($syntax)
						->get()
						->num_rows();
	}

	public function get_all_h_club($syntax, $order_by, $page)
	{
		return $this->db->select('C.*')
						->from($this->user_club_related_table . ' as R')
						->join($this->club_table . ' as C', 'C.id = R.club_id', 'left')
						->where($syntax)
						->order_by($order_by)
        				->limit($this->page_count, ($page-1)*$this->page_count)
						->get()
						->result_array();
	}

	// ---------------------------------------------------------------------------------------

	public function get_all_user(){
		return $this->db->get_where($this->user_table, array("is_delete"=>0))->result_array();
	}

	public function get_list($seen_user_id, $syntax, $page = 1, $order_by = "create_date DESC", $page_count = 20){
		if ($page == "" || $page == null) $page = 1;
		$total = $this->db->where($syntax)->get($this->post_table." P")->num_rows();
		$total_page = ($total % $page_count == 0) ? floor(($total)/$page_count) : floor(($total)/$page_count) + 1;

		$list = $this->db->select("P.*, (R.post_id IS NOT NULL) AS temperature_fire, (C.post_id IS NOT NULL) AS is_collect, CD.classify_id, CC.classify_id as club_classify_id")
						 ->from($this->post_table." P")
						 ->join($this->user_table." U", "U.id = P.user_id", "left")
						 ->join($this->user_post_temperature_table." R", "R.post_id = P.id AND R.user_id = '{$seen_user_id}'", "left")
						 ->join($this->post_collect_table." C", "C.post_id = P.id AND C.user_id = '{$seen_user_id}'", "left")
						 ->join($this->post_classify_at_diary_table." CD", "CD.post_id = P.id", "left")
						 ->join($this->post_classify_at_club_table." CC", "CC.post_id = P.id", "left")
						 ->where($syntax)
						 ->order_by($order_by)
						 ->limit($page_count, ($page-1)*$page_count)
						 ->get()->result_array();
		$data = array();
		foreach ($list as $key => $obj) {
			$data[] = $this->post_format($obj, FALSE, $seen_user_id);
		}

		$has_next = FALSE;
		$has_pre = FALSE;
		if ($page != 1) $has_pre = TRUE;
		if ($page != $total_page) $has_next = TRUE;

		return array(
			"total"      =>	$total,
			"total_page" =>	$total_page,
			"data"       =>	$data,
			"page"       =>	$page,
			"has_pre"    =>	$has_pre,
			"has_next"   =>	$has_next
		);
	}

	public function post_format($post, $is_shared_post = FALSE, $seen_user_id = FALSE){
		static $classify_list = null;
		if (is_null($classify_list)) $classify_list = $this->get_diary_classify_list('', TRUE);
		static $club_classify_list = null;
		if (is_null($club_classify_list)) {
			$this->load->model("Club_model");
			$club_classify_list = $this->Club_model->get_club_post_classify_list('', TRUE);
		}

		$comment_cnt = $this->get_comment_cnt($post['id']);
		$share_cnt = $this->get_share_cnt($post['id']);
		
		$photo = $this->db->select("id, description, CONCAT('".base_url()."', `normal_url`) as path, CONCAT('".base_url()."', `thumb_url`) as thumb")->get_where($this->media_table, array("type"=>"post", "relation_id"=>$post['id'], "is_delete"=>0))->result_array();

		$user = $this->User_model->get_user_formatted($post['user_id']);

		$data = array(
			"id"               =>	$post['id'],
			"temperature_fire" =>	boolval($post['temperature_fire']),
			"is_collect"       =>	boolval($post['is_collect']),
			"share_from"       =>	$post['share_from'],
			"post_at"          =>	$post['post_at'],
			"relation_id"      =>	$post['relation_id'],
			"title"            =>	$post['title'],
			"summary"          =>	$post['summary'],
			"temperature"      =>	$post['temperature'],
			"create_date"      =>	$post['create_date'],
			"comment_cnt"      =>	$comment_cnt,
			"share_cnt"        =>	$share_cnt,
			"photo"            =>	$photo,
			"user"             =>	$user,
			"status"           =>	$post['status'],
			"update_date"      =>	$post['update_date'],
			"myself"           =>	($post['user_id'] == $seen_user_id)?TRUE:FALSE
		);

		if (!$is_shared_post) {
			$classify = 0;
			$classify_str = "未分類";
			if(array_key_exists('classify_id', $post) && !is_null($post['classify_id']) && $post['classify_id'] != null && array_key_exists($post['classify_id'], $classify_list)){
				$classify = intval($post['classify_id']);
				$classify_str = $classify_list[$post['classify_id']]['title'];
			}

			$data['classify'] = $classify;
			$data['classify_str'] = $classify_str;

			$club_classify = 0;
			$club_classify_str = "未分類";
			if ($post['club_sort'] == "999") {
				$club_classify = -1;
				$club_classify_str = "獵場公告";
			}else if ($post['club_sort'] == "998") {
				$club_classify = -2;
				$club_classify_str = "部落規定";
			}else if(array_key_exists('club_classify_id', $post) && !is_null($post['club_classify_id']) && $post['club_classify_id'] != null && array_key_exists($post['club_classify_id'], $club_classify_list)){
				$club_classify = intval($post['club_classify_id']);
				$club_classify_str = $club_classify_list[$post['club_classify_id']]['title'];
			}

			$data['club_classify'] = $club_classify;
			$data['club_classify_str'] = $club_classify_str;
		}
		if ($post['share_from'] != "" && intval($post['share_from']) > 0 && $seen_user_id !== FALSE) {
			$share_post = $this->get_post($post['share_from'], TRUE, $seen_user_id);
			$data['share_post'] = $this->post_format($share_post, TRUE, $seen_user_id);
		}

		return $data;
	}

	public function get_diary_classify_list($user_id = '', $id_as_key = FALSE){
		$syntax = array("is_delete" => 0);
		if ($user_id != "") {
			$syntax['user_id'] = $user_id;
		}
		if ($id_as_key) {
			return $this->db->get_where($this->diary_classify_table, $syntax)->result_array("id");	
		}
		$data = $this->db->select("id, title, cnt")->get_where($this->diary_classify_table, $syntax)->result_array();
		$total_cnt = 0;
		foreach ($data as $item) {
			$total_cnt += intval($item['cnt']);
		}
		array_unshift($data, array(
			"id"	=>	0,
			"title"	=>	"全部",
			"cnt"	=>	$total_cnt
		));
		return $data;
	}

	public function get_comment_cnt($post_id, $is_only_parent = TRUE){
		$syntax = array("post_id"=>$post_id);
		if ($is_only_parent) $syntax['parent_id'] = 0;
		return $this->db->get_where($this->post_comment_table, $syntax)->num_rows();
	}

	public function get_share_cnt($post_id, $is_only_share_to_diary = FALSE){
		$syntax = array("post_id"=>$post_id);
		if ($is_only_share_to_diary) $syntax['share_to'] = 'my_diary';
		return $this->db->get_where($this->post_share_table, $syntax)->num_rows();	
	}

	public function get_friends_id($user_id){
		return $this->db->get_where($this->friends_table, array("user_id"=>$user_id, "status"=>"normal"))->result_array('target_id');
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

	public function get_iam_join_club($user_id, $type = ''){
		$data = array();
		$syntax = array("R.user_id"=>$user_id, "C.is_delete"=>0);
		if ($type != "") {
			$syntax['C.type'] = $type;
		}
		$list = $this->db->select("C.*")
						 ->from($this->user_club_related_table." R")
						 ->join($this->club_table." C", "C.id = R.club_id", "left")
						 ->where($syntax)
						 ->order_by("C.type DESC, C.create_date DESC")
						 ->get()->result_array();
		foreach ($list as $club) {
			$data[] = array(
				"id"          =>	$club['id'],
				"title"       =>	$club['show_name'],
				"full_name"   =>	$club['name'],
				"cover"       =>	base_url().$club['cover'],
				"myself"      =>	($club['owner'] == $user_id)?TRUE:FALSE,
				"people_cnt"  =>	$club['people'],
				"discuss_hot" =>	$club['discuss_hot'],
				'create_date' => 	$club['create_date'],
				'owner' 	  => 	$club['owner'],
			);
		}
		return $data;
	}

	// ---------------------------------------------------------------------------------------






















































	
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

	public function social_account_exist($social_type, $social_id){
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
		$this->db->select("*");
		$this->db->from($this->user_table);
		$this->db->where(
			array($key=>$social_id)
		);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
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