<?php defined('BASEPATH') OR exit('No direct script access allowed');


class  Base_Model  extends  CI_Model  {
    private $page_count = 9; 
    
    protected $user_table = "user";
    protected $user_club_related_table = "user_club_related";
    protected $hobby_table = "hobby";
    protected $user_hobby_related_table = "user_hobby_related";
    protected $medal_table = "medal";
    protected $user_medal_related_table = "user_medal_related";
    protected $user_post_temperature_table = "user_post_temperature";

    protected $friends_table = "friend";
    protected $subscribe_table = "subscribe";
    protected $bulletin_table = "bulletin";
    protected $notification_table = "notification";
    protected $push_token_table = "push_token";

    protected $event_table = "event";
    protected $event_prize_table = "event_prize";
    protected $event_prize_level_table = "event_prize_level";
    protected $user_event_prize_related_table = "user_event_prize_related";

    protected $club_table = "club";
    protected $club_category_table = "club_category";
    protected $club_classify_table = "club_classify";
    protected $club_classify_related_table = "club_classify_related";
    protected $club_guard_apply_table = "club_guard_apply";
    protected $user_club_dropout_table = "user_club_dropout";

    protected $adv_classify_table = "adv_classify";
    protected $adv_addon_table = "adv_addon";
    protected $adv_table = "adv";
    protected $adv_plan_table = "adv_plan";
    protected $adv_plan_option_table = "adv_plan_option";
    protected $adv_coupon_table = "adv_coupon";
    protected $adv_coupon_use_table = "adv_coupon_use";
    protected $adv_explosure_table = "adv_explosure";
    protected $adv_classify_related_table = "adv_classify_related";
    protected $adv_common_store_table = "adv_common_store";
    protected $adv_record_table = "adv_record";

    protected $promote_code_table = "promote_code";
    protected $promote_code_use_table = "promote_code_use";
    protected $order_table = "orders";
    
    protected $user_club_apply_table = "user_club_apply";
    protected $club_user_report_table = "club_user_report";

    protected $post_table = "post";
    protected $post_detail_table = "post_detail";
    protected $post_classify_at_club_table = "post_classify_at_club";
    protected $post_classify_at_diary_table = "post_classify_at_diary";
    protected $diary_classify_table = "diary_classify";
    protected $post_collect_table = "post_collect";
    protected $post_share_table = "post_share";
    protected $club_post_classify_table = "club_post_classify";
    protected $club_discuss_log_table = "club_discuss_log";

    protected $post_comment_table = "post_comment";
    protected $user_comment_temperature_table = "user_comment_temperature";

    protected $media_table = "media";
    protected $priv_menu_table = "privilege_menu";
    protected $priv_table = "privilege";
    protected $member_table = "member";

    protected $shop_product_table = "shop_product";
    protected $shop_menu_table = "shop_menu";

    protected $checkin_reward_table = "checkin_reward";
    protected $checkin_log_table = "checkin_log";
    protected $task_table = "task";
    protected $task_completed_table = "task_completed";

    protected $top_leaderboard_table = "top_leaderboard";
    protected $leaderboard_table = "leaderboard";
    protected $seminar_table = "seminar";
    protected $seminar_category_table="seminar_category";
    protected $seminar_classify_table="seminar_classify";

    protected $acdemic_table="acdemic";
    protected $acdemic_category_table="acdemic_category";
    protected $acdemic_classify_table="acdemic_classify";

    protected $medical_table="medical";
    protected $medical_category_table="medical_category";
    protected $medical_classify_table="medical_classify";

    protected $home_table='home';
    protected $home_text_table='home_text';
    protected $our_service_table='our_service';
    protected $designer_table='designer';
    protected $timeline_table='timeline';
    protected $more_photos_table='more_photos';

    protected $brand_table='brand';
    protected $customized_table='customized';
    protected $collection_table='collection';
//
protected $collection_category_table='collection_category';
//
    protected $ready_carousel_top_table='ready_carousel_top';
    protected $ready_text_table='ready_text';

    protected $contact_table='contact_mgr';

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Taipei");
		
	}

    public function time_permit($arr){
        $time = date("H:i");
        if (in_array($time, $arr)) return TRUE;
        return FALSE;
    }

    public function reward_title($type){
        switch ($type) {
            case 'coupon':   return '優惠券';
            case 'shell':   return '貝殼幣';
            case 'point':   return '點數';
            case 'tribe':
            case 'coin':   
                return '部落幣';
            case 'sticket':   return '小糧券';
            case 'bticket':   return '大獵券';
        }
    }

    public function reward_image_path($type, $include_img_tag = TRUE, $include_name = FALSE, $name_position = 'back'){
        $str = base_url()."assets/images/icon_{$type}.svg";
        if ($type == "coin") $type = "tribe";
        if ($type == "coupon") $str = base_url()."assets/images/icon_{$type}.png";
        if ($include_img_tag) $str = "<img src='".$str."' style='width: 32px;'>";

        if ($include_name) {
            if ($name_position == 'back') {
                $str .= " ".$this->reward_title($type);
            }else{
                $str = $this->reward_title($type)." ".$str;
            }
        }
        return $str;
    }

    public function dateStr($date){
        $date = strtotime($date);
        if ((time()-$date)<60*10) {
            //十分鐘內
              return '剛剛';
        } elseif (((time()-$date)<60*60)&&((time()-$date)>=60*10)) {
            //十分鐘~1小時
              $s = floor((time()-$date)/60);
            return  $s."分鐘前";
        } elseif (((time()-$date)<60*60*24)&&((time()-$date)>=60*60)) {
            //1小時～24小時
              $s = floor((time()-$date)/60/60);
            return  $s."小時前";
        } elseif (((time()-$date)<60*60*24*3)&&((time()-$date)>=60*60*24)) {
            //1天~3天
              $s = floor((time()-$date)/60/60/24);
            return $s."天前";
        } else {
            //超过3天
            if (date('Y', strtotime($date)) == date('Y')) {
                //今年
                return date("m/d H:i", $date);
            }else{
                return date("Y/m/d", $date);
            }
        }
    }

	public function send_push($os, $registatoin_ids, $message, $data = FALSE) {
        // if ($os == "android") {
    	$url = 'https://fcm.googleapis.com/fcm/send';
    	$title = "BBTruck";
        $fields = array('to' => $registatoin_ids);

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
				'text'  =>	$message
        	);
        	if ($data !== FALSE) {
	        	$fields['notification'] = array_merge($fields['notification'], $data);
	        }    
        }

        // if ($data !== FALSE) {
        // 	$fields = array_merge($fields, $data);
        // }
 		
        $headers = array(
            'Authorization: key=AAAA9Sg37_w:APA91bFH3jxJe8pkoboujnmqOFGUS1xp0goqlCPvZDzL1KfkFTHUy4wE89UI7inoGv2KZsaI2-1gBIn1qZ1q7mDvHXcR3jV7IoYtv4qyCdX0kl3EDwQbv8SXFxtc9mcHtyByJOtrAeHW',
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

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        
        $result = json_decode($result, true);

        return $result['success'];
    }

    public function custom_encrypt($string,$operation,$key='KeyyE'){
        $replcae_str = "_Sl.";
        if($operation=='D'){
            $string = str_replace($replcae_str, "/", $string);
        }
        $key=md5($key);
        $key_length=strlen($key);
        $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
        $string_length=strlen($string);
        $rndkey=$box=array();
        $result='';
        for($i=0;$i<=255;$i++){
            $rndkey[$i]=ord($key[$i%$key_length]);
            $box[$i]=$i;
        }
        for($j=$i=0;$i<256;$i++){
            $j=($j+$box[$i]+$rndkey[$i])%256;
            $tmp=$box[$i];
            $box[$i]=$box[$j];
            $box[$j]=$tmp;
        }
        for($a=$j=$i=0;$i<$string_length;$i++){
            $a=($a+1)%256;
            $j=($j+$box[$a])%256;
            $tmp=$box[$a];
            $box[$a]=$box[$j];
            $box[$j]=$tmp;
            $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
        }
        if($operation=='D'){
            if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){
                return substr($result,8);
            }else{
                return'';
            }
        }else{
            $encryt_str = str_replace('=','',base64_encode($result));
            $encryt_str = str_replace("/", $replcae_str, $encryt_str);
            return $encryt_str;
        }
    }

    public function compute_total_page($total)
    {

        return ($total % $this->page_count == 0) ? floor(($total)/$this->page_count) : floor(($total)/$this->page_count) + 1;
    }
    
    protected function generate_code($length = 6, $only_degital = FALSE){
        $alphabet_upper = range('A', 'Z');
        $alphabet_lower = range('a', 'z');
        $s = "";
        for ($i=0; $i <=9 ; $i++) $s.= strval($i);
        if (!$only_degital) {
            foreach ($alphabet_upper as $a) $s .= $a;
            // $s .= '_';
            for ($i=0; $i <=9 ; $i++) $s.= strval($i);
            foreach ($alphabet_lower as $a) $s .= $a;
            for ($i=0; $i <=9 ; $i++) $s.= strval($i);
            // $s .= '@';
        }
        
        $cnt = strlen($s);

        $code = "";
        for ($i=0; $i < $length; $i++) { 
            $code .= substr($s, rand(0, $cnt - 1), 1);
        }   
        return $code;
    }

    protected function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}
