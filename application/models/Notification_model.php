<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends Base_Model {
	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

    public function add_system_data($user_id, $content, $type = '', $relation_id = 0){
        $this->db->insert($this->notification_table, array(
            "classify"        =>  "system",
            "sender"          =>  0,
            "user_id"         =>  $user_id,
            "preview_content" =>  "",
            "content"         =>  $content,
            "type"            =>  $type,
            "relation_id"     =>  $relation_id
        ));
        $insert_id = $this->db->insert_id();

        $url = "";
        if ($type == 'task') {
            $url = $this->config->config['frontend_url']."missionpage";
        }

        $this->send_user_push($user_id, $content, array("url"=>$url));

        return $insert_id;
    }

	public function add_data($user_id, $type = 'text', $sender = 0, $relation_id = 0, $preview_content = '', $content = '', $data = FALSE){
		$this->db->insert($this->notification_table, array(
            "classify"        =>  "user",
            "sender"          =>  $sender,
            "user_id"         =>  $user_id,
            "preview_content" =>  $preview_content,
            "content"         =>  $content,
            "type"            =>  $type,
            "relation_id"     =>  $relation_id
        ));
        $insert_id = $this->db->insert_id();

        $user = $this->User_model->get_data($sender);
        $url = "";
        $content = '';//$item['content'];
        // $content = '<a href="'.$this->config->config['frontend_url'].'#/membercenter/'.$item['sender_atid'].'">'.$item['sender_name'].'</a>';
        if ($type == "reply_post") {
            $content .= $user['nickname'].' 回應您的日記：「'.$preview_content.'」';
            $url = $this->config->config['frontend_url'].'article/'.$relation_id;
        }else if ($type == "reply_comment") {
            $content .= $user['nickname'].' 回應您的留言：「'.$preview_content.'」';
            $url = $this->config->config['frontend_url'].'article/'.$relation_id;
        }else if ($type == "like_post") {
            $content .= $user['nickname'].' 為您的日記加溫：「'.$preview_content.'」';
            $url = $this->config->config['frontend_url'].'article/'.$relation_id;
        }else if ($type == "reply_bulletin") {
            $content .= $user['nickname'].' 大聲對您說：「'.$preview_content.'」';
        }else if ($type == "add_friend") {
            $content .= $user['nickname'].' 向您發出好友申請';
            $url = $this->config->config['frontend_url'].'membercenter/'.$user['atid'];
        }else if ($type == "reply_friend") {
            $content .= $user['nickname'].' 已成為您的好友';
            $url = $this->config->config['frontend_url'].'membercenter/'.$user['atid'];
        }

        $this->send_user_push($user_id, $content, array("url"=>$url));

        return $insert_id;
	}

    public function add_multidata($user_array, $data = FALSE){
        //classify user under os and get their token
        $android_user = array();
        $ios_user = array();
        for ($i=0; $i < count($user_array); $i++) { 
            $user = $this->db->select("L.os, L.push_token")
                         ->from($this->user_table." U")
                         ->join($this->push_token_table." L", "L.user_id = U.id", "left")
                         ->where(array("U.id"=>$user_array[$i]["id"]))
                         ->get()->last_row("array");
            if ($user['os'] != null && $user['push_token'] != "") {
                if($user['os']=="android"){
                    array_push($android_user, $user['push_token']);
                }elseif($user['os']=="ios"){
                    array_push($ios_user, $user['push_token']);
                }
            }
            $this->db->insert($this->notification_table, array(
                "user_id"       =>  $user_array[$i]["id"],
                "group_id"      =>  $data["group_id"],
                "title"         =>  $data["title"],
                "content"       =>  $data["content"],
                "type"          =>  $data["type"],
                "relation_id"   =>  $data["relation_id"],
            ));
        }
        //send push twice(android,ios)
        $msg = array(
            "title"     =>  $data["title"],
            "content"   =>  $data["content"]
        );
        $other = array(
            "type"  =>  $data["type"],
            "id"    =>  $data["relation_id"]
        );
        if(count($android_user)!=0) $res = $this->send_push("android", $android_user, $msg, $other);
        if(count($ios_user)!=0) $res = $this->send_push("ios", $ios_user, $msg, $other);

        return $res;
    }

	public function get_data($user_id){
		return $this->db->select("id, title, content, type, relation_id, create_date, IF(is_read = 1, 'true', 'false') as is_read")
						->from($this->notification_table)
						->where(array("user_id"=>$user_id, "is_delete"=>0))
						->order_by("create_date DESC")
						->get()->result_array();
	}

	public function has_notification_unread($user_id){
		$exist = $this->db->get_where($this->notification_table, array("user_id"=>$user_id, "is_read"=>0))->num_rows();
		if ($exist > 0) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function all_data_read($user_id){
		return $this->db->where(array("user_id"=>$user_id))->update($this->notification_table, array("is_read"=>1));
	}

	public function send_user_push($user_id, $msg, $data = FALSE){
		$user = $this->db->select("L.os, L.push_token")
						 ->from($this->user_table." U")
						 ->join($this->push_token_table." L", "L.user_id = U.id", "left")
						 ->where(array("U.id"=>$user_id))
                         ->order_by("L.create_date DESC")
                         ->limit(1)
						 ->get()->row_array();
		if ($user['os'] != null && $user['push_token'] != "") $this->send_push($user['os'], $user['push_token'], $msg, $data);
	}

	public function send_push($os, $registatoin_ids, $message, $data = FALSE) {
        // if ($os == "android") {
    	$url = 'https://fcm.googleapis.com/fcm/send';
    	$title = "溫度部落";
    	if(is_array($registatoin_ids)){
            $fields = array('registration_ids' => $registatoin_ids);
        }else{
            $fields = array('to' => $registatoin_ids);
        }
        
        //皆為 firebase 平台
        if ($os == "android") {
        	$fields['data'] = array(
				'title'   =>	$title,
				'message' =>	$message
        	);
			if ($data !== FALSE) {
	        	$fields['data'] = array_merge($fields['data'], $data);
	        }        	
        }else if($os == "ios"){
        	$fields['notification'] = array(
				'title' =>	$title , 
				'text'  =>	$message,
                'sound' =>  "default"
        	);
        	if ($data !== FALSE) {
	        	$fields['notification'] = array_merge($fields['notification'], $data);
	        }    
        }else{
            $fields['data'] = array(
                'title'   =>    $title,
                'message' =>    $message
            );
            if ($data !== FALSE) {
                $fields['data'] = array_merge($fields['data'], $data);
            }   
        }

        // if ($data !== FALSE) {
        // 	$fields = array_merge($fields, $data);
        // }
 		// echo json_encode($fields);
        $headers = array(
            'Authorization: key=AAAAJWnrDK0:APA91bGSp49mQGFvs3YSBWOCH_4H292FQn5DWWiNPng_qDc_laCXg2T4rf8qwY3LqXJbYbfVupTmo4pUUlanvx63Cf5HSSxL14do-7cTA035WzafANdP1nlO5e2xkyFmybA8jVJEMJCo',
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        // echo "[".$result."]";
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        
        $result = json_decode($result, true);

        return $result;
    }

    //bulletin 大聲公
    public function get_list($user_id, $page = 1, $page_count = 20, $classify = 'all'){
        $output = array();

        if ($classify == 'all' || $classify == 'system') {
            
            $syntax = array("user_id"=>$user_id, "T.classify"=>"system", "T.is_delete"=>0);
            $list = $this->db->select("T.*")
                             ->from($this->notification_table." T")
                             ->where($syntax)
                             ->limit($page_count, ($page-1)*$page_count)
                             ->order_by("T.create_date DESC")
                             ->get()->result_array();
            $data = array();
            foreach ($list as $item) {
                $url = "";
                if ($item['type'] == "task") {
                    $url = $this->config->config['frontend_url']."missionpage";
                }
                $data[] = array(
                    "id"          =>  $item['id'],
                    "content"     =>  $item['content'],
                    "create_date" =>  $this->dateStr($item['create_date']),
                    "is_read"     =>  $item['is_read'],
                    "url"         =>  $url
                );
            }

            $total = $this->db->select("count(*) as cnt")->where($syntax)->get($this->notification_table." T")->row()->cnt;
            $total_page = ($total % $page_count == 0) ? floor(($total)/$page_count) : floor(($total)/$page_count) + 1;

            $output['system'] = array(
                "data"       =>  $data,
                "total_page" =>  $total_page,
                "page"       =>  intval($page)
            );
        }

        if ($classify == 'all' || $classify == 'user') {
            
            $syntax = array("T.user_id"=>$user_id, "T.classify"=>"user", "T.is_delete"=>0);
            $list = $this->db->select("T.*, U.nickname as sender_name, U.atid as sender_atid")
                             ->from($this->notification_table." T")
                             ->join($this->user_table." U", "U.id = T.sender", "left")
                             ->where($syntax)
                             ->limit($page_count, ($page-1)*$page_count)
                             ->order_by("T.create_date DESC")
                             ->get()->result_array();
            $data = array();
            foreach ($list as $item) {
                $is_addfriend_btn_enable = FALSE;
                $url = "";
                $content = '';//$item['content'];
                // $content = '<a href="'.$this->config->config['frontend_url'].'#/membercenter/'.$item['sender_atid'].'">'.$item['sender_name'].'</a>';
                if ($item['type'] == "reply_post") {
                    $content .= $item['sender_name'].' 回應您的日記：「'.$item['preview_content'].'」';
                    $url = $this->config->config['frontend_url'].'article/'.$item['relation_id'];
                }else if ($item['type'] == "reply_comment") {
                    $content .= $item['sender_name'].' 回應您的留言：「'.$item['preview_content'].'」';
                    $url = $this->config->config['frontend_url'].'article/'.$item['relation_id'];
                }else if ($item['type'] == "like_post") {
                    $content .= $item['sender_name'].' 為您的日記加溫：「'.$item['preview_content'].'」';
                    $url = $this->config->config['frontend_url'].'article/'.$item['relation_id'];
                }else if ($item['type'] == "reply_bulletin") {
                    $content .= $item['sender_name'].' 大聲對您說：「'.$item['preview_content'].'」';
                }else if ($item['type'] == "add_friend") {
                    $content .= $item['sender_name'].' 向您發出好友申請';
                    $is_addfriend_btn_enable = TRUE;
                    $url = $this->config->config['frontend_url'].'membercenter/'.$item['sender_atid'];
                }else if ($item['type'] == "reply_friend") {
                    $content .= $item['sender_name'].' 已成為您的好友';
                    $url = $this->config->config['frontend_url'].'membercenter/'.$item['sender_atid'];
                }
                
                if ($content == "") $content = $item['content'];

                $data[] = array(
                    "id"                      =>  $item['id'],
                    "sender"                  =>  $item['sender'],
                    "sender_name"             =>  $item['sender_name'],
                    "content"                 =>  $content,
                    "create_date"             =>  $this->dateStr($item['create_date']),
                    "is_read"                 =>  $item['is_read'],
                    "is_addfriend_btn_enable" =>  $is_addfriend_btn_enable,
                    "url"                     =>  $url
                );
            }

            $total = $this->db->select("count(*) as cnt")->where($syntax)->get($this->notification_table." T")->row()->cnt;
            $total_page = ($total % $page_count == 0) ? floor(($total)/$page_count) : floor(($total)/$page_count) + 1;

            $output['user'] = array(
                "data"       =>  $data,
                "total_page" =>  $total_page,
                "page"       =>  intval($page)
            );
        }

        return $output;
    }
}