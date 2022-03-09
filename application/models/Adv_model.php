<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Adv_model extends Base_Model {
	
	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

	public function today_adv_seen_cnt($user_id){
		//今日看過幾則廣告
		return $this->db->select("adv_id")
						->from($this->adv_record_table)
						->where("user_id = '{$user_id}' AND create_date LIKE '".date("Y-m-d")."%'")
						->group_by("adv_id")
						->get()->num_rows();
	}

	public function adv_record($adv_id, $user_id){
		$res = $this->db->insert($this->adv_record_table, array(
			"adv_id"  =>	$adv_id,
			"user_id" =>	$user_id,
			"ip"      =>	$this->get_client_ip()
		));
		if ($res) {
			if ($this->today_adv_seen_cnt($user_id) >= 10) {
				$this->load->model("Task_model");
				$this->Task_model->complete_task($user_id, 8);
			}	
			return TRUE;
		}
		return FALSE;
	}

	public function check_promote_code($promote_code){
		$c = $this->db->get_where($this->promote_code_table, array("code"=>$promote_code))->row_array();
		$status = FALSE;
		$msg = "";
		$data = array();
		if ($c == null){
			$msg = "查無此折扣碼";
		}else{
			$used = $this->db->get_where($this->promote_code_use_table, array("code_id"=>$c['id']))->num_rows();
			if ($c['limit'] - $used <= 0) {
				$msg = "此折扣碼無法使用";
			}else if (strtotime($c['expired_date']) < strtotime(date("Y-m-d H:i:s"))) {
				$msg = "此折扣碼已過期";
			}else{
				$status = TRUE;
				$msg = "此折扣碼可使用";
				$data = array(
					"id"       =>	$c['id'],
					"type"     =>	$c['type'],
					"discount" =>	$c['discount']
				);
			}
		}

		return array(
			"status" =>	$status,
			"msg"    =>	$msg,
			"data"   => $data
		);
	}

	//common store
	public function update_common_store($adv_id, $data){
		if ($this->db->get_where($this->adv_common_store_table, array("adv_id"=>$adv_id))->num_rows() > 0) {
			return $this->db->where(array("adv_id"=>$adv_id))->update($this->adv_common_store_table, $data);
		}else{
			$data['adv_id'] = $adv_id;
			return $this->db->insert($this->adv_common_store_table, $data);
		}
	}

	public function get_common_store($user_id){
		return $this->db->select("id, store_name, store_type, city, dist, business_hour, web_url, store_intro")
						->from($this->adv_common_store_table)
						->where(array("user_id"=>$user_id))
						->get()->result_array();
	}

	//coupon

	public function use_my_coupon($coupon_use_id){
		return $this->db->where(array("id"=>$coupon_use_id))->update($this->adv_coupon_use_table, array(
			"status"	=>	"used",
			"used_date"	=>	date("Y-m-d H:i:s")
		));
	}

	public function get_my_coupon_use($coupon_use_id){
		$item = $this->db->select("USE.*, C.path, A.store_name, A.store_phone, A.store_addr")
						 ->from($this->adv_coupon_use_table." USE")
						 ->join($this->adv_coupon_table." C", "C.id = USE.coupon_id", "left")
						 ->join($this->adv_table." A", "A.id = USE.adv_id", "left")
						 ->where("USE.id = '{$coupon_use_id}'")
						 ->order_by("USE.id DESC")
						 ->get()->row_array();
		$content = "";
		$content .= "優惠店家：".$item['store_name']."<br>";
		$content .= "優惠內容：".$item['content']."<br>";
		$content .= "優惠券序號：".$item['no']."<br>";
		$content .= "使用期限：".date("Y-m-d", strtotime($item['start_date']))." ~ ".date("Y-m-d", strtotime($item['end_date']))."<br>";
		if ($item['store_phone'] != "")
			$content .= "店家電話：<a href='tel:".$item['store_phone']."'>".$item['store_phone']."</a><br>";
		if ($item['store_phone'] != "")
			$content .= "店家地址：<a target='_blank' href='https://www.google.com.tw/maps/search/".$item['store_addr']."'>".$item['store_addr']."</a><br>";

		return array(
			"type"      =>	"coupon",
			"serial_no" =>	$item['no'],
			"coupon"    =>	base_url().$item['path'],
			"content"   =>	$content,
			"is_used"	=>	($item['status'] == "normal")?FALSE:TRUE,
			"used_date"	=>	$item['used_date']
		);
	}

	public function get_my_coupon($user_id){
		$list = $this->db->select("USE.*, C.path, A.store_name")
						 ->from($this->adv_coupon_use_table." USE")
						 ->join($this->adv_coupon_table." C", "C.id = USE.coupon_id", "left")
						 ->join($this->adv_table." A", "A.id = USE.adv_id", "left")
						 ->where("USE.user_id = '{$user_id}'")
						 ->order_by("USE.id DESC")
						 ->get()->result_array();
		$data = array();
		foreach ($list as $item) {
			$enabled = TRUE;
			$btns = array(
				array(
					"title"      =>	"贈送",
					"bg_color"   =>	"#036EB8",
					"text_color" =>	"#FFFFFF",
					"function"   =>	"gift"
				),
				array(
					"title"      =>	"使用",
					"bg_color"   =>	"#DC131A",
					"text_color" =>	"#FFFFFF",
					"function"   =>	"tribe"
				)
			);
			if ($item['status'] != "normal") {
				$enabled = FALSE;
				$btns = array(
					array(
						"title"      =>	"已使用",
						"bg_color"   =>	"#DC131A",
						"text_color" =>	"#FFFFFF",
						"function"   =>	"coupon"
					)
				);
			}
			$data[] = array(
				"cover"     =>	base_url().$item['path'],//."assets/images/icon_coupon_img.png",
				"id"        =>	"coupon_".$item['id'],
				"title"     =>	$item['title'],
				"sub_title" =>	$item['store_name'],
				"des"       =>	"使用期限：".$item['end_date']."前",
				"deadline"  =>	"剩1日",
				"cnt"       =>	1,
				"can_del"   =>	TRUE,
				"enabled"   =>	$enabled,
				"btns"      =>	$btns
			);
		}
		return $data;
	}

	public function get_coupon($coupon_id){
		return $this->db->get_where($this->adv_coupon_table, array("id"=>$coupon_id))->row_array();
	}

	public function take_coupon($adv_id, $user_id){
		$adv = $this->get_data($adv_id);
		$c = $this->get_adv_coupon($adv_id, "on");
		if (count($c) <= 0) return TRUE;
		$coupon = array();
		foreach ($c as $item) {
			for ($i=0; $i < $item['remaining']; $i++) { 
				$coupon[] = $item['id'];
			}
		}

		$you_take = $coupon[rand(0, count($coupon) - 1)];
		$chosen_coupon = $this->get_coupon($you_take);

		$data = array(
			"adv_id"     =>	$adv_id,
			"coupon_id"  =>	$you_take,
			"user_id"    =>	$user_id,
			"start_date" =>	$chosen_coupon['start_date'],
			"end_date"   =>	$chosen_coupon['end_date'],
			"title"      =>	$adv['title'],
			"content"    =>	$chosen_coupon['content'],
			"status"     =>	"normal"
		);

		if ($this->db->insert($this->adv_coupon_use_table, $data)) {
			$id = $this->db->insert_id();
			$coupon_cnt = $this->db->get_where($this->adv_coupon_use_table, array("coupon_id"=>$you_take))->num_rows();
			$no = str_pad($id, 6, '0', STR_PAD_LEFT).str_pad(($coupon_cnt), 4, '0', STR_PAD_LEFT);
			$this->db->where(array("id"=>$id))->update($this->adv_coupon_use_table, array("no"=>$no));
			$data['no'] = $no;

			return $data;
		}else{
			return FALSE;
		}
	}

	public function check_is_take_coupon($adv_id, $user_id){
		return ($this->db->get_where($this->adv_coupon_use_table, array("adv_id"=>$adv_id, "user_id"=>$user_id))->num_rows() > 0)?TRUE:FALSE;
	}

	public function get_adv_coupon($adv_id, $status = FALSE, $check_user_take = FALSE, $user_id = FALSE){
		$syntax = array("C.adv_id"=>$adv_id);
		if ($status !== FALSE) {
			$syntax['C.status'] = $status;
		}
		$select_user_take = "";
		if ($check_user_take && $user_id !== FALSE) {
			$select_user_take = ", (SELECT COUNT(id) FROM `".$this->adv_coupon_use_table."` WHERE coupon_id = C.id AND user_id = '{$user_id}') as take_cnt";
		}
		
		$list = $this->db->select("C.*, (SELECT COUNT(id) FROM `".$this->adv_coupon_use_table."` WHERE coupon_id = C.id) as cnt".$select_user_take)
						 ->from($this->adv_coupon_table." C")
						 ->where($syntax)
						 ->get()->result_array();
		$adv = $this->get_data($adv_id);

		$data = array();
		if ($check_user_take) {
			$data['coupon'] = array();
			$data['user_take'] = FALSE;
		}
		foreach ($list as $item) {
			$obj = array(
				"id"         =>	$item['id'],
				"title"      =>	$adv['store_name'],
				"content"    =>	$item['content'],
				"start_date" =>	$item['start_date'],
				"end_date"   =>	$item['end_date'],
				"count"      =>	$item['limit'],
				"path"       =>	base_url().$item['path'],
				"remaining"  =>	intval($item['limit']) - intval($item['cnt']),
				"status"     =>	$item['status']
			);

			if($check_user_take){
				$data['coupon'][] = $obj;
				if ($item['take_cnt'] > 0) $data['user_take'] = TRUE;
			}else{
				$data[] = $obj;
			}
		}
		return $data;
	}

	public function update_adv_coupon($adv_id, $data, $delete_before_action = FALSE){
		if ($delete_before_action) $this->db->delete($this->adv_coupon_table, array("adv_id"=>$adv_id));

		if (count($data) <= 0) return;
		foreach ($data as $c) {
			if (!array_key_exists('action', $c)) continue;
			if ($c['action'] == "add") {
				$this->db->insert($this->adv_coupon_table, array(
					"adv_id"     =>	$adv_id,
					"start_date" =>	$c['start_date'],
					"end_date"   =>	$c['end_date'],
					"limit"      =>	$c['count'],
					"content"    =>	$c['content'],
					"path"       =>	$c['path'],
					"status"     =>	($c['status'] == "on")?"on":"off"
				));
			}else if ($c['action'] == "edit") {
				$this->db->where(array("id"=>$c['id']))->update($this->adv_coupon_table, array(
					"start_date" =>	$c['start_date'],
					"end_date"   =>	$c['end_date'],
					"limit"      =>	$c['count'],
					"content"    =>	$c['content'],
					"path"       =>	$c['path'],
					"status"     =>	($c['status'] == "on")?"on":"off"
				));
			}else if ($c['action'] == "del") {
				$this->db->where(array("id"=>$c['id']))->update($this->adv_coupon_table, array(
					"is_delete"	=>	1
				));
			}
		}
	}

	public function get_adv_explosure_club($adv_id){
		return $this->db->select("C.id, C.code, C.name, C.show_name, CONCAT('".base_url()."', C.cover) as cover")
						->from($this->adv_explosure_table." R")
						->join($this->club_table." C", "C.id = R.club_id", "left")
						->where(array("R.adv_id"=>$adv_id))
						->get()->result_array();
	}

	public function update_adv_explosure_club($adv_id, $clubs){
		$this->db->delete($this->adv_explosure_table, array("adv_id"=>$adv_id));
		foreach ($clubs as $c) {
			$this->db->insert($this->adv_explosure_table, array(
				"adv_id"	=>	$adv_id,
				"club_id"	=>	$c
			));
		}
	}

	public function get_selected_adv_classify($adv_id){
		return $this->db->select("C.id, C.title")
						->from($this->adv_classify_related_table." R")
						->join($this->adv_classify_table." C", "C.id = R.classify_id", "left")
						->where(array("R.adv_id"=>$adv_id))
						->get()->result_array();
	}

	public function update_adv_classify($adv_id, $data){
		$this->db->delete($this->adv_classify_related_table, array("adv_id"=>$adv_id));
		foreach ($data as $c) {
			$this->db->insert($this->adv_classify_related_table, array(
				"adv_id"      =>	$adv_id,
				"classify_id" =>	$c
			));
		}
	}

	public function get_adv_addon($type, $addon_id = FALSE){
		if ($addon_id !== FALSE) return $this->db->get_where($this->adv_addon_table, array("id"=>$addon_id))->row_array();
		return $this->db->get_where($this->adv_addon_table, array("type"=>$type,"status"=>"on", "is_delete"=>0))->result_array();
	}

	public function get_plan($is_array = FALSE){
		$list = $this->db->select("P.*, O.id as option_id, O.title as option_title, O.price")
						 ->from($this->adv_plan_table." P")
						 ->join($this->adv_plan_option_table." O", "O.plan_id = P.id", "left")
						 ->where(array("P.status"=>"on", "P.is_delete"=>0, "O.status"=>"on", "O.is_delete"=>0))
						 ->get()->result_array();

		$start_date = date("Y/m/d", strtotime("+ 1 day", strtotime(date("Y-m-d"))));
		
		$data = array();
		foreach ($list as $item) {
			if (!array_key_exists($item['id'], $data)) {
				$data[$item['id']] = array(
					"id"          =>	$item['id'],
					"title"       =>	$item['title'],
					"layout"      =>	$item['layout'],
					"sub_title"   =>	$item['sub_title'],
					"notice"      =>	$item['notice'],
					"size_w"      =>	$item['size_w'],
					"size_h"      =>	$item['size_h'],
					"sticket"	  =>	$item['sticket'],
					"option"	  =>	array(),
					"description" =>	array(
						"reward"               =>	"小獵券x".$item['sticket']."張",
						"publish_period"       =>	"刊登時間：".$item['publish_day']."日",
						"expected_publication" =>	$start_date."-".date("Y/m/d", strtotime("+ ".$item['publish_day']." days", strtotime($start_date)))
					)
				);
			}

			$option = array(
				"id"	=>	$item['option_id'],
				"title"	=>	$item['option_title'],
				"price"	=>	$item['price']
			);
			if ($is_array) {
				$data[$item['id']]['option'][] = $option;
			}else{
				$data[$item['id']]['option'][$item['option_id']] = $option;
			}
		}

		if ($is_array) return array_values($data);
		return $data;
	}

	public function get_location($city, $is_filter = FALSE){
		$data = array();

		if ($is_filter) {
			$data[] = array("id"=>0, "title"=>"全部");
		}

        $controllerInstance = & get_instance();
        $city_data = $controllerInstance->get_zipcode()['city'];

        foreach ($city_data[$city - 1]['dist'] as $dist) {
        	$data[] = array("id"=>$dist['c3'], "title"=>$dist['name']);
        }

        return $data;
	}

	public function get_adv_classify($is_filter = FALSE){
		$data = array();

		if ($is_filter) {
			$data[] = array("id"=>0, "title"=>"全部");
			$data[] = array("id"=>-1, "title"=>"外縣市、連鎖店");
		}

		$list = $this->db->select("id,title")->get($this->adv_classify_table)->result_array();

		return array_merge($data, $list);
	}

	public function add($data){
		if($this->db->insert($this->adv_table, $data)){
			return $this->db->insert_id();
		}else{
			return FALSE;
		}
	}
	public function edit($adv_id, $data){
		if($this->db->where(array("id"=>$adv_id))->update($this->adv_table, $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function del($adv_id){
		if($this->db->where(array("id"=>$adv_id))->update($this->adv_table, array("is_delete"=>1))){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function get_data($id){
		return $this->db->get_where($this->adv_table, array("id"=>$id))->row_array();
	}

	public function get_list($syntax, $order_by, $page = 1, $page_count = 20){
		// $syntax .= " AND show_type = 'T'";
		$total = $this->db->where($syntax)->get($this->adv_table." A")->num_rows();
		$total_page = ($total % $page_count == 0) ? floor(($total)/$page_count) : floor(($total)/$page_count) + 1;

		$this->db->select("A.*")
				 ->from($this->adv_table." A")
				 ->where($syntax)
				 ->order_by($order_by);
		if ($page != 'all') {
			$this->db->limit($page_count, ($page-1)*$page_count);
		}
		$list = $this->db->get()->result_array();
						 
		return array(
			"page"       =>	$page,
			"total"      =>	$total,
			"total_page" =>	$total_page,
			"list"       =>	$list
		);
	}

	public function get_public_list($my_id, $club_id, $syntax, $order_by, $is_take = FALSE, $page = 1, $page_count = 20){
		// $total = $this->db->where($syntax)->get($this->adv_table." A")->num_rows();
		// $total_page = ($total % $page_count == 0) ? floor(($total)/$page_count) : floor(($total)/$page_count) + 1;
		$having = "";//"E.club_id = '{$club_id}'";
		if ($is_take != "") {
			$having = "coupon_no <> ''";
		}
		$this->db->select("A.*, IFNULL(USE.no, '') as coupon_no, E.club_id")
				 ->from($this->adv_table." A")
				 ->join($this->adv_explosure_table." E", "E.club_id = A.club_id", "left")
				 ->join($this->adv_classify_related_table." C", "C.adv_id = A.id", "left")
				 ->join($this->adv_coupon_use_table." USE", "USE.adv_id = A.id AND USE.user_id = '{$my_id}'", "left")
				 ->where($syntax)
				 ->group_by("A.id")
				 ->order_by($order_by);
		if ($having != "") $this->db->having($having);
		// if ($page != 'all') {
		// 	$this->db->limit($page_count, ($page-1)*$page_count);
		// }
		$list = $this->db->get()->result_array();
		
		$total = count($list);
		$total_page = ($total % $page_count == 0) ? floor(($total)/$page_count) : floor(($total)/$page_count) + 1;

		$data = array();

		for ($i=($page-1)*$page_count; $i < $page*$page_count && $i < $total; $i++) { 
			$item = $list[$i];
			$data[] = $this->adv_format($item);
		}
						 
		return array(
			"page"       =>	$page,
			"total"      =>	$total,
			"total_page" =>	$total_page,
			"data"       =>	$data
		);
	}

	public function adv_format($adv){
		$col = "col-lg-2 col-xs-4";
		if ($adv['layout'] == 2) {
			$col = "col-lg-4 col-xs-8";
		}else if ($adv['layout'] == 3) {
			$col = "col-lg-6 col-xs-12";
		}else if ($adv['layout'] == 6) {
			$col = "col-lg-12 col-xs-12";
		}

		return array(
			"id"         =>	$adv['id'],
			"media_type" =>	$adv['media_type'],
			"dist"       =>	$adv['dist_str'],
			"title"      =>	$adv['title'],
			"remaining"  =>	"剩餘 100 / 100張",
			"coupon"     =>	"買一送一 剩餘 10 / 10張",
			"cover"      =>	base_url().$adv['cover'],
			"layout"     =>	intval($adv['layout']),
			"col"        =>	$col,
			"link"       =>	base_url()."adv/".$adv['id'],
			"is_receive" =>	FALSE
		);
	}
}