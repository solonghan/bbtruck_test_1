<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Webex_model extends Base_Model {
	private $access_token = 'YTAyYmFlZmYtZjAxMS00Njc0LTkzNGMtYWE5Zjk2MGM3YmNkNGVhNTZhNjQtYzVj_P0A1_26c6afb5-7759-412b-b8f2-0cbf9ecd8407';
	// private $access_token = 'Y2NmY2NhYTMtMjhiOC00N2RlLTk4MDYtOGVmOGFkY2UxNTAzZDY3YjQwYjYtYjI4_P0A1_e17d95f6-983e-4a99-b9a1-94f51d8e72bb';
	private $api_url = 'https://webexapis.com/v1/';
	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

	public function create_meeting($title, $start, $end, $timezone = 'Asia/Taipei'){
		$password = rand(100000,999999);
		$field = array(
			"enabledAutoRecordMeeting" =>	true,
			"allowAnyUserToBeCoHost"   =>	true,
			"title"                    =>	$title,
			"password"                 =>	$password,
			"timezone"                 =>	$timezone,
			"start"                    =>	date("Y-m-d\TH:i:s", strtotime($start)),
			"end"                      =>	date("Y-m-d\TH:i:s", strtotime($end))
		);
		
		//發邀請信
		$invitees = array();
		$invitees[] = array(
			"email"       =>	"easy10168@gmail.com",
			"displayName" =>	"zylin",
			"coHost"      =>	false
		);
		$invitees[] = array(
			"email"       =>	"anbon@anbon.tw",
			"displayName" =>	"anbon",
			"coHost"      =>	false
		);
		if (count($invitees) > 0) {
			$field['invitees'] = $invitees;
		}

		$res = $this->go_url($this->api_url."meetings", "POST", $field);
		
		return $res;
	}

	public function get_meeting_list(){
		$res = $this->go_url($this->api_url."meetings", "GET");
		return $res;
	}

	protected function go_url($url, $method = 'POST', $curlPost = array()){
		$ch = curl_init();
		$header = array(
			"Content-Type: application/json",
			"Authorization: Bearer ".$this->access_token
		);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_URL, $url);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		// curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		if ($method == "POST") {
			curl_setopt($ch, CURLOPT_POST, 1);
		}else if ($method == "GET") {
			curl_setopt($ch, CURLOPT_POST, 0);
		}
		if (count($curlPost) > 0) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($curlPost));
		}
		
		$data = curl_exec($ch);
		if(curl_errno($ch)){   
		    echo 'Curl error: ' . curl_error($ch);
		}
		$data = json_decode($data, true);

		return $data;
	}
}