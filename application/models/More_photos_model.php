<?php defined('BASEPATH') OR exit('No direct script access allowed');

class More_photos_model extends Base_Model {
	protected $page_count = 18;
	private $member_page_count = 20;
	private $report_page_count = 20;

	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

	

	

	public function dropout_home($home_id, $user_id){
		$syntax = array(
			"home_id"	=>	$home_id,
			"user_id"	=>	$user_id
		);
		$this->dropout_log($syntax, "myself");
		return $this->db->delete($this->user_home_related_table, $syntax);
	}

	

	//guard apply
	public function review_guard_apply($apply_id, $status){
		$apply_data = $this->db->get_where($this->home_guard_apply_table, array("id"=>$apply_id))->row_array();
		if ($apply_data == null) return FALSE;
		if ($status != 'success' && $status != 'reject') return FALSE;

		if ($this->db->where(array("id"=>$apply_id))->update($this->home_guard_apply_table, array("status"=>$status))) {
			if ($status == 'success') {
				return $this->db->where(array(
					"home_id"	=>	$apply_data['home_id'],
					"user_id"	=>	$apply_data['user_id']
				))->update($this->user_home_related_table, array(
					"role"	=>	$apply_data['role']
				));
			}
		}
		return TRUE;
	}

	public function apply_guard_list($home_id){
		$list = $this->db->select("U.*, G.id as apply_id, G.social_exp, G.reason, G.role")
						 ->from($this->home_guard_apply_table." G")
						 ->join($this->user_table." U", "U.id = G.user_id", "left")
						 ->where(array("G.home_id"=>$home_id, "G.status"=>"pending"))
						 ->get()->result_array();
		$data = array();
		foreach ($list as $item) {
			$data[] = array(
				"apply_id"   =>	$item['apply_id'],
				"social_exp" =>	$item['social_exp'],
				"reason"     =>	$item['reason'],
				"role"       =>	$item['role'],
				"user"       =>	$this->User_model->get_user_formatted($item['id'], $item)
			);
		}
		return $data;
	}

	public function apply_guard($home_id, $user_id, $data){
		$syntax = array(
			"home_id"	=>	$home_id,
			"user_id"	=>	$user_id
		);
		if ($this->db->get_where($this->home_guard_apply_table, $syntax)->num_rows() > 0) return FALSE;
		$data = array_merge($data, $syntax);
		return $this->db->insert($this->home_guard_apply_table, $data);
	}

	public function get_home_member_report_list($home_id, $page = 1, $search = ""){
		$syntax = "R.home_id = '{$home_id}' AND T.is_delete = 0";
		if ($search != "") {
			$field = ["T.atid", "T.email", "T.mobile", "T.username", "T.nickname", "U.username", "U.nickname"];
			$search_syntax = "";
			foreach ($field as $f) {
				if ($search_syntax != "") $search_syntax .= " OR ";
				$search_syntax .= $f." LIKE '%".$search."%'";
			}
			if ($search_syntax != "") $syntax .= " AND (".$search_syntax.")";
		}
		$list = $this->db->select("R.id as report_id, R.type, R.post_id, R.reason, R.create_date, R.status as report_status, U.id as user_id, T.*,
						IF(R.post_id > 0, 
							(SELECT title FROM ".$this->post_table." P WHERE P.id = R.post_id)
						, '') as post_title
			")
						 ->from($this->home_user_report_table." R")
						 ->join($this->user_table." U", "U.id = R.user_id", "left")
						 ->join($this->user_table." T", "T.id = R.target_id", "left")
						 ->where($syntax)
						 ->order_by("R.create_date DESC")
						 ->limit($this->report_page_count, ($page - 1)*$this->report_page_count)
						 ->get()->result_array();
		$data = array();
		foreach ($list as $item) {
			$user = $this->User_model->get_user_formatted($item['user_id']);
			$target_user = $this->User_model->get_user_formatted($item['id'], $item);
			
			$post = array("id"=>0, "title"=>"");
			$url = $this->config->config['frontend_url'];
			if ($item['type'] == "user") {
				$url .= "membercenter/".$target_user['atid'];
			}else if ($item['type'] == "post") {
				$url .= "article/".$item['post_id'];
				$post['id'] = $item['post_id'];
				$post['title'] = $item['post_title'];
			}
			$data[] = array(
				"id"          =>	$item['report_id'],
				"type"        =>	$item['type'],
				"user"        =>	$user,
				"target_user" =>	$target_user,
				"reason"      =>	$item['reason'],
				"create_date" =>	$item['create_date'],
				"url"         =>	$url,
				"article"     =>	$post,
				"status"      =>	$item['report_status']
			);
		}

		$total = $this->db->select("R.*")
						  ->from($this->user_home_related_table." R")
						  ->join($this->user_table." U", "U.id = R.user_id", "left")
						  ->join($this->user_table." T", "T.id = R.user_id", "left")
						  ->where($syntax)
						  ->get()->num_rows();
		$total_page = ($total % $this->member_page_count == 0) ? floor(($total)/$this->member_page_count) : floor(($total)/$this->member_page_count) + 1;

		return array(
			"data"       =>	$data,
			"page"       =>	$page,
			"total_page" =>	$total_page
		);
	}

	public function home_report_action($report_id, $action){
		return $this->db->where(array("id"=>$report_id))->update($this->home_user_report_table, array("status"=>$action));
	}

	public function report_member($user_id, $target_id, $home_id, $reason){
		return $this->db->insert($this->home_user_report_table, array(
			"type"      =>	"user",
			"user_id"   =>	$user_id,
			"target_id" =>	$target_id,
			"home_id"   =>	$home_id,
			"reason"    =>	$reason
		));
	}

	public function report_home_post($user_id, $post_id, $home_id, $reason){
		$this->load->model("Post_model");
		$post = $this->Post_model->get_post($post_id);
		return $this->db->insert($this->home_user_report_table, array(
			"type"      =>	"post",
			"user_id"   =>	$user_id,
			"target_id" =>	$post['user_id'],
			"post_id"	=>	$post_id,
			"home_id"   =>	$home_id,
			"reason"    =>	$reason
		));
	}

	public function home_kickoff_member($user_id, $home_id){
		$syntax = array(
			"user_id" =>	$user_id,
			"home_id" =>	$home_id
		);
		$this->dropout_log($syntax, "home");
		return $this->db->delete($this->user_home_related_table, $syntax);
	}

	public function check_user_home_role($user_id, $home_id, $role){
		$syntax = array(
			"user_id" =>	$user_id,
			"home_id" =>	$home_id
		);
		$data = $this->db->get_where($this->user_home_related_table, $syntax)->row_array();
		if ($data['role'] == 'manager') return TRUE;
		if ($role == 'guard' && $role == $data['role']) return TRUE;
		return FALSE;
	}

	public function change_user_role($user_id, $home_id, $role){
		$syntax = array(
			"user_id"	=>	$user_id,
			"home_id"	=>	$home_id
		);
		if ($this->db->get_where($this->user_home_related_table, $syntax)->num_rows() > 0) {
			return $this->db->where($syntax)->update($this->user_home_related_table, array("role"=>$role));
		}else{
			return FALSE;
		}
	}

	public function change_user_muted($user_id, $home_id, $is_muted, $date, $reason){
		$syntax = array(
			"user_id"	=>	$user_id,
			"home_id"	=>	$home_id
		);
		if ($this->db->get_where($this->user_home_related_table, $syntax)->num_rows() > 0) {
			return $this->db->where($syntax)->update($this->user_home_related_table, array("is_muted"=>$is_muted));
		}else{
			return FALSE;
		}
	}
/*
	public function check_user_can_speak($home_id, $user_id){
		$syntax = array(
			"user_id"	=>	$user_id,
			"home_id"	=>	$home_id
		);
		$r = $this->db->get_where($this->user_home_related_table, $syntax)->row_array();
		if ($r == null) return FALSE;

		if ($r['is_muted'] == 0) {
			return TRUE;
		}else{
			if (strtotime($r['muted_date']) < strtotime(date("Y-m-d H:i:s"))) {
				$this->db->where($syntax)->update($user_home_related_table, array("is_muted"=>0));
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}*/

	public function get_home_member($home_id, $page = 1, $search = ""){
		$syntax = "R.home_id = '{$home_id}' AND U.is_delete = 0";
		if ($search != "") {
			$field = ["U.atid", "U.email", "U.mobile", "U.username", "U.nickname"];
			$search_syntax = "";
			foreach ($field as $f) {
				if ($search_syntax != "") $search_syntax .= " OR ";
				$search_syntax .= $f." LIKE '%".$search."%'";
			}
			if ($search_syntax != "") $syntax .= " AND (".$search_syntax.")";
		}
		$list = $this->db->select("R.role, R.create_date as join_date, R.is_muted, U.*")
						 ->from($this->user_home_related_table." R")
						 ->join($this->user_table." U", "U.id = R.user_id", "left")
						 ->where($syntax)
						 ->order_by("FIELD(R.role, 'manager', 'guard', 'normal'), R.create_date DESC")
						 ->limit($this->member_page_count, ($page - 1)*$this->member_page_count)
						 ->get()->result_array();
		$data = array();
		foreach ($list as $item) {
			$user = $this->User_model->get_user_formatted($item['id'], $item);
			$data[] = array(
				"user"      =>	$user,
				"role"      =>	$item['role'],
				"join_date" =>	$item['join_date'],
				"is_muted" =>	($item['is_muted']==1)?TRUE:FALSE
			);
		}

		$total = $this->db->select("R.*")
						  ->from($this->user_home_related_table." R")
						  ->join($this->user_table." U", "U.id = R.user_id", "left")
						  ->where($syntax)
						  ->get()->num_rows();
		$total_page = ($total % $this->member_page_count == 0) ? floor(($total)/$this->member_page_count) : floor(($total)/$this->member_page_count) + 1;

		return array(
			"data"       =>	$data,
			"page"       =>	$page,
			"total_page" =>	$total_page
		);
	}

	public function get_unreview_member($home_id, $search){
		$syntax = "R.status = 'pending' AND R.home_id = '{$home_id}' and U.is_delete = 0";
		if ($search != "") {
			$field = ["U.atid", "U.email", "U.mobile", "U.username", "U.nickname"];
			$search_syntax = "";
			foreach ($field as $f) {
				if ($search_syntax != "") $search_syntax .= " OR ";
				$search_syntax .= $f." LIKE '%".$search."%'";
			}
			if ($search_syntax != "") $syntax .= " AND (".$search_syntax.")";
		}
		$list = $this->db->select("U.*, R.*")
						 ->from($this->user_home_apply_table." R")
						 ->join($this->user_table." U", "U.id = R.user_id", "left")
						 ->where($syntax)
						 ->order_by("R.create_date DESC")
						 ->get()->result_array();
		$data = array();
		foreach ($list as $item) {
			$user = $this->User_model->get_user_formatted($item['id'], $item);
			$data[] = array(
				"user"       =>	$user,
				"answer1"    =>	$item['answer1'],
				"answer2"    =>	$item['answer2'],
				"answer3"    =>	$item['answer3'],
				"apply_date" =>	$item['create_date']
			);
		}
		return $data;
	}

	public function join_home_for_waiting_review($user_id, $home_id, $data){
		$syntax = array(
			"user_id"	=>	$user_id,
			"home_id"	=>	$home_id
		);
		if ($this->db->get_where($this->user_home_apply_table, $syntax)->num_rows() <= 0) {
			$data = array_merge($data, $syntax);
			return $this->db->insert($this->user_home_apply_table, $data);
		}else{
			// $data = $this->db->get_where($this->user_home_apply_table, $syntax)->row_array();
			// if ($data['status'] == 'reject') return FALSE;
			$data = array_merge($data, $syntax);
			$data['status'] = 'pending';
			return $this->db->where($syntax)->update($this->user_home_apply_table, $data);
		}
	}

	public function home_add_header_post($home_id){
		//建立獵場時，必加入 獵場公告 和 部落規定
		$home = $this->get_data($home_id);

		$this->load->model("Post_model");
		$post_id = $this->Post_model->add_post(array(
			"user_id"     =>	$home['owner'],
			"post_at"     =>	"home",
			"relation_id" =>	$home_id,
			"title"       =>	"獵場公告",
			"summary"     =>	"獵場公告",
			"status"      =>	"public",
			"home_sort"   =>	999
		));
		$this->Post_model->edit_post_detail($post_id, array(
			"post_id"	=>	$post_id,
			"content"	=>	"獵場公告"
		));

		$post_id = $this->Post_model->add_post(array(
			"user_id"     =>	$home['owner'],
			"post_at"     =>	"home",
			"relation_id" =>	$home_id,
			"title"       =>	"部落規定",
			"summary"     =>	"部落規定",
			"status"      =>	"public",
			"home_sort"   =>	998
		));
		$this->Post_model->edit_post_detail($post_id, array(
			"post_id"	=>	$post_id,
			"content"	=>	"部落規定"
		));
	}
/*
	public function get_home_privilege_btns($home_id, $user_id){
		$join_home = $this->user_has_join_home($user_id, $home_id);

		$manager_privilege = $this->check_user_home_role($user_id, $home_id, "manager");
		$guard_privilege = $this->check_user_home_role($user_id, $home_id, "guard");

		$add_post_btn_enabled = TRUE;
		$add_post_btn_text = "我要發文";
		if($join_home == "joined"){
			if (!$this->check_user_can_speak($home_id, $user_id)) {
				$add_post_btn_enabled = FALSE;
				$add_post_btn_text = "我要發文(已被禁文)";
			}
		}else{
			$add_post_btn_enabled = FALSE;
		}
		
		$add_post = array(
			"enabled" =>	$add_post_btn_enabled,
			"hidden"  =>	($join_home == "joined")?FALSE:TRUE,
			"text"    =>	$add_post_btn_text
		);
		$setting = array(
			"enabled" =>	($manager_privilege)?TRUE:FALSE,
			"hidden"  =>	($manager_privilege)?FALSE:TRUE,
			"text"    =>	"獵場設定"
		);
		$rule = array(
			"enabled" =>	($manager_privilege)?TRUE:FALSE,
			"hidden"  =>	($manager_privilege)?FALSE:TRUE,
			"text"    =>	"獵場規則"
		);
		$member_manage = array(
			"enabled" =>	true,//($manager_privilege || $guard_privilege)?TRUE:FALSE,
			"hidden"  =>	false,//($manager_privilege || $guard_privilege)?FALSE:TRUE,
			"text"    =>	"成員列表"
		);
		$apply_guard = array(
			"enabled" =>	($manager_privilege || $guard_privilege)?FALSE:TRUE,
			"hidden"  =>	($manager_privilege || $guard_privilege)?TRUE:FALSE,
			"text"    =>	"申請成為守衛"
		);
		$apply_join = array(
			"enabled" =>	TRUE,
			"hidden"  =>	FALSE,
			"text"    =>	"申請加入獵場"
		);
		if ($join_home == "joined") {
			$apply_join['enabled'] = FALSE;
			$apply_join['hidden'] = TRUE;
		}else if ($join_home == "pending") {
			$apply_join['enabled'] = FALSE;
			$apply_join['hidden'] = FALSE;
			$apply_join['text'] = "審核中";
		}else if ($join_home == "reject") {
			$apply_join['enabled'] = FALSE;
			$apply_join['hidden'] = TRUE;
		}

		$dropout = array(
			"enabled" =>	($join_home == "joined")?TRUE:FALSE,
			"hidden"  =>	($join_home == "joined")?FALSE:TRUE,
			"text"    =>	"退出此獵場"
		);

		return array(
			"add_post"      =>	$add_post,
			"setting"       =>	$setting,
			"rule"          =>	$rule,
			"member_manage" =>	$member_manage,
			"apply_guard"   =>	$apply_guard,
			"apply_join"    =>	$apply_join,
			"dropout"       =>	$dropout
		);
	}
*/
	public function get_home_post_classify_list($home_id, $id_as_key = FALSE){
		$syntax = array("is_delete" => 0);
		if ($home_id != "") {
			$syntax['home_id'] = $home_id;
		}
		if ($id_as_key) {
			return $this->db->get_where($this->home_post_classify_table, $syntax)->result_array("id");	
		}
		$data = $this->db->select("id, title, can_edit")->get_where($this->home_post_classify_table, $syntax)->result_array();
		array_unshift($data, array(
			"id"       =>	0,
			"title"    =>	"全部",
			"can_edit" =>	0
		));
		return $data;
	}

	public function get_iam_join_home($user_id, $type = ''){
		$data = array();
		$syntax = array("R.user_id"=>$user_id, "C.is_delete"=>0);
		if ($type != "") {
			$syntax['C.type'] = $type;
		}
		$list = $this->db->select("C.*")
						 ->from($this->user_home_related_table." R")
						 ->join($this->home_table." C", "C.id = R.home_id", "left")
						 ->where($syntax)
						 ->order_by("C.type DESC, C.create_date DESC")
						 ->get()->result_array();
		foreach ($list as $home) {
			$data[] = array(
				"id"          =>	$home['id'],
				"code"        =>	$home['code'],
				"title"       =>	$home['show_name'],
				"full_name"   =>	$home['name'],
				"cover"       =>	base_url().$home['cover'],
				"myself"      =>	($home['owner'] == $user_id)?TRUE:FALSE,
				"people_cnt"  =>	$home['people'],
				"discuss_hot" =>	$home['discuss_hot']
			);
		}
		return $data;
	}

	public function review_user($user_id, $home_id, $status){
		$syntax = array(
			"user_id"	=>	$user_id,
			"home_id"	=>	$home_id
		);
		$res = $this->db->where($syntax)->update($this->user_home_apply_table, array("status"=>$status));
		if ($res) {
			if ($status == 'success') $this->user_join_home($user_id, array($home_id));
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function user_has_join_home($user_id, $home_id){
		//joined pending reject none
		$joined = $this->db->get_where($this->user_home_related_table, array("user_id"=>$user_id, "home_id"=>$home_id))->row_array();
		if ($joined != null) return "joined";

		$apply = $this->db->get_where($this->user_home_apply_table, array("user_id"=>$user_id, "home_id"=>$home_id))->row_array();
		if ($apply != null) {
			return $apply['status'];
		}else{
			return "none";
		}
	}

	public function user_join_home($user_id, $home_arr){
		$data = array();
		foreach ($home_arr as $c) {
			$c_related = array(
				"user_id"	=>	$user_id,
				"home_id"	=>	$c
			);
			if ($this->db->get_where($this->user_home_related_table, $c_related)->num_rows() <= 0) {
				$data[] = $c_related;
				$this->update_home_people($c, 1, 'plus');
			}
		}
		if(count($data) > 0) $this->db->insert_batch($this->user_home_related_table, $data);
		return TRUE;
	}

	public function update_home_people($home_id, $cnt, $action = 'plus'){
		$home = $this->db->get_where($this->home_table, array("id"=>$home_id))->row_array();
		$people = intval($home['people']);
		if ($action == "plus") {
			$people++;
		}else if ($action == "minus") {
			$people--;
		}
		if ($people <= 0) $people = 0;

		$this->db->where(array("id"=>$home_id))->update($this->home_table, array("people"=>$people));
	}

	public function update_home_banner($home_id, $banner){
		$msg = "";
		foreach ($banner as $item) {
			if (!array_key_exists('action', $item)) continue;
			if ($item['action'] == "delete") {
				$r = $this->db->where(array("id"=>$item['id']))->update($this->media_table, array("is_delete"=>1));
				if (!$r) $msg .= "輪播圖刪除失敗\n";
			}else if ($item['action'] == "add") {
				if (file_exists($item['path'])) {
					$this->load->model("Pic_model");
					$thumb_url = $this->Pic_model->create_thumb($item['path'], 600);
					$r = $this->db->insert($this->media_table, array(
						"type"        =>	"home_banner",
						"relation_id" =>	$home_id,
						"name"        =>	$item['path'],
						"normal_url"  =>	$item['path'],
						"thumb_url"   =>	$thumb_url
					));	
					if (!$r) $msg .= "輪播圖新增失敗\n";
				}
			}
		}
		return $msg;
	}

	public function update_home_post_classify($home_id, $classify){
		$msg = "";
		foreach ($classify as $item) {
			if (!array_key_exists('action', $item)) continue;
			if ($item['action'] == "add") {
				$r = $this->db->insert($this->home_post_classify_table, array(
					"home_id"  =>	$home_id,
					"title"    =>	$item['title'],
					"can_edit" =>	1
				));
				if (!$r) $msg .= "類別:".$item['title']." 新增失敗\n";
			}else if ($item['action'] == "edit") {
				$c = $this->db->get_where($this->home_post_classify_table, array("id"=>$item['id']))->row_array();
				if ($c['can_edit'] == 1) {
					$r= $this->db->where(array("id"=>$item['id']))->update($this->home_post_classify_table, array(
						"title"	=>	$item['title']
					));
					if (!$r) $msg .= "類別:".$item['title']." 更新失敗\n";
				}
			}else if ($item['action'] == "delete") {
				$c = $this->db->get_where($this->home_post_classify_table, array("id"=>$item['id']))->row_array();
				if ($c['can_edit'] == 1) {
					$r= $this->db->where(array("id"=>$item['id']))->update($this->home_post_classify_table, array(
						"is_delete"	=>	1
					));
					if (!$r) $msg .= "類別:".$item['title']." 刪除失敗\n";
				}
			}
		}	
		return $msg;
	}

    

	public function update_home_classify($home_id, $category_id, $classify_id){
		if ($this->db->get_where($this->home_classify_related_table, array("home_id"=>$home_id))->num_rows() > 0) {
			return $this->db->where(array("home_id"=>$home_id))->update($this->home_classify_related_table, array(
				"category_id"	=>	$category_id,
				"classify_id"	=>	$classify_id
			));
		}else{
			return $this->db->insert($this->home_classify_related_table, array(
				"home_id"     =>	$home_id,
				"category_id" =>	$category_id,
				"classify_id" =>	$classify_id
			));
		}
	}

	public function edit($home_id, $data){
		return $this->db->where(array("id"=>$home_id))->update($this->more_photos_table, $data);
	}

	public function add($data){

       // var_dump($data['type']);
        
		$res = $this->db->insert($this->more_photos_table, $data);
	    
       
        if (!$res) return FALSE;
      
        
		$home_id = $this->db->insert_id();

       
		//$this->home_add_header_post($home_id);
		return $home_id;
	}

	public function home_code_to_id($code){
		$c = $this->db->get_where($this->home_table, array("code"=>$code))->row_array();
		if ($c == null) return FALSE;
		return $c['id'];
	}

	public function get_home_detail($id, $code = "", $user_id = ""){
		$syntax = array();
		if ($id != "") {
			$syntax['id'] = $id;
		}else{
			$syntax['code'] = $code;
		}

		$data = $this->db->select("C.*")
						 ->from($this->home_table." C")
						 ->where($syntax)
						 ->get()->row_array();
		if ($data['is_delete'] == 1) return FALSE;

		$question = array();
		$question['q1'] = $data['q1'];
		$question['q2'] = $data['q2'];
		$question['q3'] = $data['q3'];

		$banner = $this->Setting_model->banner_list("home_banner", $data['id']);
		
		$cc = $this->db->select("CA.title as category, CA.id as category_id, CL.title as classify, CL.id as classify_id")
					   ->from($this->home_classify_related_table." R")
					   ->join($this->home_category_table." CA", "CA.id = R.category_id", "left")
					   ->join($this->home_classify_table." CL", "CL.id = R.classify_id", "left")
					   ->where(array("R.home_id"=>$id))
					   ->get()->row_array();

		$home = array(
			"id"          =>	$data['id'],
			"type"        =>	$data['type'],
			"code"        =>	$data['code'],
			"full_name"   =>	$data['name'],
			"name"        =>	$data['show_name'],
			"cover"       =>	base_url().$data['cover'],
			"people"      =>	$data['people'],
			"discuss_hot" =>	$data['discuss_hot'],
			"create_date" =>	$data['create_date'],
			"banner"      =>	$banner,
			"owner"       =>	$this->User_model->get_user_formatted($data['owner']),
			"category"    =>	array("id"=>$cc['category_id'], "title"=>$cc['category']),
			"classify"    =>	array("id"=>$cc['classify_id'], "title"=>$cc['classify'])
		);

		return array(
			"data"       =>	$home, 
			"classify"   =>	$this->home_model->get_home_post_classify_list($home['id']),
			"btns"       =>	$this->home_model->get_home_privilege_btns($home['id'], $user_id),
			"rule"       =>	$data['rule'],
			"question"   =>	$question,
			"is_private" =>	($data['is_private'])?TRUE:FALSE
		);
	}

	public function get_home_list($user_id, $syntax, $order_by, $page = 1, $page_count = ''){
		if($page_count == '') $page_count = $this->page_count;
		if ($page <= 0) $page = 1;
		$list = $this->db->select("id, code, name as full_name, show_name as name, IF(`cover` = '', '' ,CONCAT('".base_url()."', cover)) as cover, people, C.discuss_hot, category_id, classify_id, is_hot, is_recommend")
						 ->from($this->home_table." C")
						 ->join($this->home_classify_related_table." R", "R.home_id = C.id", "left")
						 ->where($syntax)
						 ->limit($page_count, ($page-1)*$page_count)
						 ->order_by($order_by)
						 ->group_by("C.id")
						 ->get()->result_array();
		
		$total = $this->db->from($this->home_table." C")
						  ->join($this->home_classify_related_table." R", "R.home_id = C.id", "left")
						  ->where($syntax)->get()->num_rows();
		$total_page = ($total % $page_count == 0) ? floor(($total)/$page_count) : floor(($total)/$page_count) + 1;


		return array(
			"data"       =>	$list,
			"total"      =>	$total,
			"total_page" =>	$total_page,
			"page"       =>	intval($page)
		);
	}

	public function get_hobby_home_classify(){
		$data = array();
		$data[] = array(
			"id"       =>	0,
			"title"    =>	"全部",
			"classify" =>	array()
		);
		foreach ($this->db->order_by("sort DESC, create_date ASC")->get_where($this->home_category_table, array("status"=>"on"))->result_array() as $category) {
			$classify = array();
			$classify[] = array(
				"id"	=>	0,
				"title"	=>	"全部"
			);
			foreach ($this->db->order_by("sort DESC, create_date ASC")->get_where($this->home_classify_table, array("status"=>"on", "category_id"=>$category['id']))->result_array() as $c) {
				$classify[] = array(
					"id"	=>	$c['id'],
					"title"	=>	$c['title']
				);
			}
			$data[] = array(
				"id"       =>	$category['id'],
				"title"    =>	$category['title'],
				"classify" =>	$classify
			);
		}
		return $data;
	}

	public function get_data($home_id){
		return $this->db->get_where($this->more_photos_table, array("id"=>$home_id))->row_array();
	}

	//取得所有在地獵場
	public function get_all_local_home(){
		return $this->db->select("id, code, name as full_name, show_name as name, IF(`cover` = '', '' ,CONCAT('".base_url()."', cover)) as cover")
						->from($this->home_table)
						->where(array("type"=>"local", "is_delete"=>0))
						->get()->result_array();
	}

	//--------------------------------------------------------------後臺用
	public function get_local_list($syntax, $order_by, $page, $page_count)
	{
		$total = $this->db->select()->from($this->more_photos_table)->where($syntax)->get()->num_rows();
		$total_page = ceil($total / $page_count);


        
		$list = $this->db->select()
			->from($this->more_photos_table)
			->where($syntax)
			->limit($page_count, ($page - 1) * $page_count)
			->order_by($order_by)
			->get()
			->result_array();



		return array(
			'total'      => $total,
			'total_page' => $total_page,
			'list'       => $list,
		);
	}

	public function get_post_list($syntax, $order_by, $page, $page_count)
	{
		$total = $this->db->select()->from($this->post_table . " P")->where($syntax)->get()->num_rows();
		$total_page = ceil($total / $page_count);

		$list = $this->db->select("P.*, U.nickname, PCC.title AS PC_title, DC.title AS PD_title")
		->from($this->post_table . " P")
		->join($this->user_table . " U", "U.id=P.user_id", "left")
		->join($this->post_classify_at_home_table . " PC", "P.id=PC.post_id", "left")
		->join($this->post_classify_at_diary_table . " PD", "P.id=PD.post_id", "left")
		->join($this->home_post_classify_table . " PCC", "PC.home_id=PCC.home_id AND PC.classify_id=PCC.id", "left")
		->join($this->diary_classify_table . " DC", "PD.classify_id=DC.id", "left")
		->where($syntax)
		->limit($page_count, ($page - 1) * $page_count)
		->order_by($order_by)
		->get()
		->result_array();

		foreach ($list as $key => $post) {
			$list[$key]['comment_cnt'] = $this->db->select()
				->from($this->post_comment_table)
				->where(array(
					'post_id'   => $post['id'],
					'is_delete' => 0
				))->get()->num_rows();

			$list[$key]['share_cnt'] = $this->db->select()
				->from($this->post_share_table)
				->where(array(
					'post_id'   => $post['id'],
				))->get()->num_rows();
		}

		return array(
			'total'      => $total,
			'total_page' => $total_page,
			'list'       => $list
		);
	}

	public function get_banner($home_id)
	{
		$banner = array();
		foreach ($this->db->get_where($this->media_table, array("type" => "home_banner", "relation_id" => $home_id, "is_delete" => 0))->result_array() as $b) {
			$banner[] = array(
				"id"    => $b['id'],
				"thumb" => $b['thumb_url'],
				"path"  => $b['normal_url'],
				"url"   => $b['normal_url'],
				"link"  => $b['link']
			);
		}
		return $banner;
	}

	public function add_banner($data)
	{
		return $this->db->insert_batch($this->media_table, $data);
	}

	public function del_banner($syntax)
	{
		return $this->db->where($syntax)->update($this->media_table, array('is_delete' => 1));
	}

	public function get_carousel(){

		$str="select * from more_photos where is_delete=0 ";
		$res=$this->db->query($str)->result_array();


		// !d($res);
		return $res;
	}
}