<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bulletin_model extends Base_Model {
	protected $page_count = 18;
	private $member_page_count = 20;
	private $report_page_count = 20;

	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

	
/*

	public function club_add_header_post($club_id){
		//建立獵場時，必加入 獵場公告 和 部落規定
		$club = $this->get_data($club_id);

		$this->load->model("Post_model");
		$post_id = $this->Post_model->add_post(array(
			"user_id"     =>	$club['owner'],
			"post_at"     =>	"club",
			"relation_id" =>	$club_id,
			"title"       =>	"獵場公告",
			"summary"     =>	"獵場公告",
			"status"      =>	"public",
			"club_sort"   =>	999
		));
		$this->Post_model->edit_post_detail($post_id, array(
			"post_id"	=>	$post_id,
			"content"	=>	"獵場公告"
		));

		$post_id = $this->Post_model->add_post(array(
			"user_id"     =>	$club['owner'],
			"post_at"     =>	"club",
			"relation_id" =>	$club_id,
			"title"       =>	"部落規定",
			"summary"     =>	"部落規定",
			"status"      =>	"public",
			"club_sort"   =>	998
		));
		$this->Post_model->edit_post_detail($post_id, array(
			"post_id"	=>	$post_id,
			"content"	=>	"部落規定"
		));
	}

	

	

	

	public function review_user($user_id, $club_id, $status){
		$syntax = array(
			"user_id"	=>	$user_id,
			"club_id"	=>	$club_id
		);
		$res = $this->db->where($syntax)->update($this->user_club_apply_table, array("status"=>$status));
		if ($res) {
			if ($status == 'success') $this->user_join_club($user_id, array($club_id));
			return TRUE;
		}else{
			return FALSE;
		}
	}

	

	
*/
	

	public function update_club_banner($club_id, $banner){
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
						"type"        =>	"club_banner",
						"relation_id" =>	$club_id,
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

	

	public function update_club_classify($club_id, $category_id, $classify_id){
		if ($this->db->get_where($this->club_classify_related_table, array("club_id"=>$club_id))->num_rows() > 0) {
			return $this->db->where(array("club_id"=>$club_id))->update($this->club_classify_related_table, array(
				"category_id"	=>	$category_id,
				"classify_id"	=>	$classify_id
			));
		}else{
			return $this->db->insert($this->club_classify_related_table, array(
				"club_id"     =>	$club_id,
				"category_id" =>	$category_id,
				"classify_id" =>	$classify_id
			));
		}
	}

	public function edit($club_id, $data){
		return $this->db->where(array("id"=>$club_id))->update($this->club_table, $data);
	}

	public function add($data){
		$res = $this->db->insert($this->club_table, $data);
		if (!$res) return FALSE;
		$club_id = $this->db->insert_id();
		$this->club_add_header_post($club_id);
		return $club_id;
	}

	public function club_code_to_id($code){
		$c = $this->db->get_where($this->club_table, array("code"=>$code))->row_array();
		if ($c == null) return FALSE;
		return $c['id'];
	}

	public function get_club_detail($id, $code = "", $user_id = ""){
		$syntax = array();
		if ($id != "") {
			$syntax['id'] = $id;
		}else{
			$syntax['code'] = $code;
		}

		$data = $this->db->select("C.*")
						 ->from($this->club_table." C")
						 ->where($syntax)
						 ->get()->row_array();
		if ($data['is_delete'] == 1) return FALSE;

		$question = array();
		$question['q1'] = $data['q1'];
		$question['q2'] = $data['q2'];
		$question['q3'] = $data['q3'];

		$banner = $this->Setting_model->banner_list("club_banner", $data['id']);
		
		$cc = $this->db->select("CA.title as category, CA.id as category_id, CL.title as classify, CL.id as classify_id")
					   ->from($this->club_classify_related_table." R")
					   ->join($this->club_category_table." CA", "CA.id = R.category_id", "left")
					   ->join($this->club_classify_table." CL", "CL.id = R.classify_id", "left")
					   ->where(array("R.club_id"=>$id))
					   ->get()->row_array();

		$club = array(
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
			"data"       =>	$club, 
			"classify"   =>	$this->Club_model->get_club_post_classify_list($club['id']),
			"btns"       =>	$this->Club_model->get_club_privilege_btns($club['id'], $user_id),
			"rule"       =>	$data['rule'],
			"question"   =>	$question,
			"is_private" =>	($data['is_private'])?TRUE:FALSE
		);
	}

	public function get_club_list($user_id, $syntax, $order_by, $page = 1, $page_count = ''){
		if($page_count == '') $page_count = $this->page_count;
		if ($page <= 0) $page = 1;
		$list = $this->db->select("id, code, name as full_name, show_name as name, IF(`cover` = '', '' ,CONCAT('".base_url()."', cover)) as cover, people, C.discuss_hot, category_id, classify_id, is_hot, is_recommend")
						 ->from($this->club_table." C")
						 ->join($this->club_classify_related_table." R", "R.club_id = C.id", "left")
						 ->where($syntax)
						 ->limit($page_count, ($page-1)*$page_count)
						 ->order_by($order_by)
						 ->group_by("C.id")
						 ->get()->result_array();
		
		$total = $this->db->from($this->club_table." C")
						  ->join($this->club_classify_related_table." R", "R.club_id = C.id", "left")
						  ->where($syntax)->get()->num_rows();
		$total_page = ($total % $page_count == 0) ? floor(($total)/$page_count) : floor(($total)/$page_count) + 1;


		return array(
			"data"       =>	$list,
			"total"      =>	$total,
			"total_page" =>	$total_page,
			"page"       =>	intval($page)
		);
	}

	public function get_hobby_club_classify(){
		$data = array();
		$data[] = array(
			"id"       =>	0,
			"title"    =>	"全部",
			"classify" =>	array()
		);
		foreach ($this->db->order_by("sort DESC, create_date ASC")->get_where($this->club_category_table, array("status"=>"on"))->result_array() as $category) {
			$classify = array();
			$classify[] = array(
				"id"	=>	0,
				"title"	=>	"全部"
			);
			foreach ($this->db->order_by("sort DESC, create_date ASC")->get_where($this->club_classify_table, array("status"=>"on", "category_id"=>$category['id']))->result_array() as $c) {
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

	public function get_data($club_id){
		return $this->db->get_where($this->club_table, array("id"=>$club_id))->row_array();
	}

	//取得所有在地獵場
	public function get_all_local_club(){
		return $this->db->select("id, code, name as full_name, show_name as name, IF(`cover` = '', '' ,CONCAT('".base_url()."', cover)) as cover")
						->from($this->club_table)
						->where(array("type"=>"local", "is_delete"=>0))
						->get()->result_array();
	}

	//--------------------------------------------------------------後臺用
	public function get_local_list($syntax, $order_by, $page, $page_count)
	{
		$total = $this->db->select()->from($this->club_table)->where($syntax)->get()->num_rows();
		$total_page = ceil($total / $page_count);

		$list = $this->db->select()
			->from($this->club_table)
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
		->join($this->post_classify_at_club_table . " PC", "P.id=PC.post_id", "left")
		->join($this->post_classify_at_diary_table . " PD", "P.id=PD.post_id", "left")
		->join($this->club_post_classify_table . " PCC", "PC.club_id=PCC.club_id AND PC.classify_id=PCC.id", "left")
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

	public function get_banner($club_id)
	{
		$banner = array();
		foreach ($this->db->get_where($this->media_table, array("type" => "club_banner", "relation_id" => $club_id, "is_delete" => 0))->result_array() as $b) {
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
}