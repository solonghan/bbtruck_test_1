<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends Base_Model {
	private $comment_page_count = 20;
	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

	public function post_view($post_id){
		$post = $this->get_post($post_id);
		$viewed = intval($post['viewed']) + 1;
		$this->edit_post($post_id, array("viewed"=>$viewed));

		if ($post['post_at'] == 'club') $this->Club_model->discuss_hot($post['relation_id']);
	}

	public function post_active($post_id){
		return $this->edit_post($post_id, array("last_active_time"=>date("Y-m-d H:i:s")));
	}

	public function check_user_today_post($user_id){
		$today = date("Y-m-d");
		return $this->db->select("COUNT(*) as sum")->like("create_date", $today)->get_where($this->post_table, array("user_id"=>$user_id, "post_at<>"=>"day"))->row()->sum;
	}

	public function check_user_post_num($user_id, $post_at = 'all'){
		$syntax = array("user_id"=>$user_id);
		if ($post_at != 'all') {
			$syntax['post_at'] = $post_at;
		}
		return $this->db->select("COUNT(*) as sum")->get_where($this->post_table, $syntax)->row()->sum;	
	}

	//留言
	public function edit_comment($comment_id, $data){
		return $this->db->where(array("id"=>$comment_id))->update($this->post_comment_table, $data);
	}

	public function add_comment($data){
		if($this->db->insert($this->post_comment_table, $data))
			return $this->db->insert_id();
		return FALSE;
	}

	public function get_comment($comment_id){
		return $this->db->get_where($this->post_comment_table, array("id"=>$comment_id))->row_array();
	}

	public function get_comment_temperature($comment_id){
		return $this->db->get_where($this->user_comment_temperature_table, array("comment_id"=>$comment_id))->num_rows();
	}
	
	public function comment_fire($comment_id, $user_id){
		$syntax = array("comment_id"=>$comment_id, "user_id"=>$user_id);
		if ($this->db->get_where($this->user_comment_temperature_table, $syntax)->num_rows() <= 0) {
			$this->db->insert($this->user_comment_temperature_table, $syntax);
		}
		return TRUE;
	}

	public function comment_disfire($comment_id, $user_id){
		$syntax = array("comment_id"=>$comment_id, "user_id"=>$user_id);
		if ($this->db->get_where($this->user_comment_temperature_table, $syntax)->num_rows() > 0) {
			$this->db->delete($this->user_comment_temperature_table, $syntax);
		}
		return TRUE;
	}

	public function comment_photo($comment_id, $data){
		$this->load->model("Pic_model");
		foreach ($data as $p) {
			if (array_key_exists('action', $p) && $p['action'] == 'delete') {
				$this->db->where(array("id"=>$p['id']))->update($this->media_table, array("is_delete"=>1));
			}else{
				if (!array_key_exists('path', $p) || $p['path'] == "") continue;
				$thumb_url = str_replace(".", "_m.", $p['path']);
				if (!file_exists($thumb_url)) {
					$thumb_url = $this->Pic_model->create_thumb($p['path']);
				}
				$this->db->insert($this->media_table, array(
					"type"        =>	"comment",
					"relation_id" =>	$comment_id,
					"name"        =>	"",
					"description" =>	$p['description'],
					"normal_url"  =>	$p['path'],
					"thumb_url"   =>	$thumb_url
				));
			}
		}
	}

	public function get_comment_cnt($post_id, $is_only_parent = TRUE){
		$syntax = array("post_id"=>$post_id);
		if ($is_only_parent) $syntax['parent_id'] = 0;
		return $this->db->get_where($this->post_comment_table, $syntax)->num_rows();
	}

	public function get_comment_list($post_id, $seen_user_id, $next_token = '', $only_see = ''){
		$syntax = "C.is_delete = 0 AND C.post_id = '{$post_id}' AND C.parent_id = 0";
		if ($only_see != '') {
			$post = $this->get_post($post_id);
			if ($only_see == 'author') $syntax .= " AND C.user_id = '".$post['user_id']."'";
			if ($only_see == 'me') $syntax .= " AND C.user_id = '{$seen_user_id}'";
		}
		if ($next_token != '') {
			$next_token = $this->custom_encrypt($next_token, 'D');
			$syntax = "C.id < '{$next_token}'";
		}
		$list = $this->db->select("U.*, C.user_id, C.id, type, content, C.create_date, (R.comment_id IS NOT NULL) AS temperature_fire")
						 ->from($this->post_comment_table." C")
						 ->join($this->user_comment_temperature_table." R", "R.comment_id = C.id AND R.user_id = '{$seen_user_id}'", "left")
						 ->join($this->user_table." U", "U.id = C.user_id", "left")
						 ->where($syntax)
						 ->limit($this->comment_page_count)
						 ->order_by("C.id DESC, C.create_date DESC")
						 ->get()->result_array();
		$data = array();
		foreach ($list as $comment) {
			$data[] = $this->comment_format($comment, $seen_user_id);
		}

		$last_id = (count($list)>0)?$list[count($list) - 1]['id']:0;
        $next_token = "";
        $first_id = $this->db->order_by("C.id asc")->limit(1)->get_where($this->post_comment_table." C", $syntax)->row_array();
        if ($first_id != null && $first_id['id'] != $last_id) $next_token = $this->custom_encrypt($last_id, 'E');

		return array(
			"data"       =>	$data,
			"next_token" =>	$next_token
		);
	}

	public function comment_format($data, $seen_user_id){
		$comment = array(
				"id"                 =>	$data['id'],
				"user_id"            =>	$data['user_id'],
				"type"               =>	$data['type'],
				"content"            =>	$data['content'],
				"create_date"        =>	$this->dateStr($data['create_date']),
				"create_date_detail" =>	$data['create_date'],
				"temperature_fire"   =>	boolval($data['temperature_fire']),
				"user"               =>	$this->User_model->get_user_formatted($data['user_id'], array(
					"nickname" =>	$data['nickname'],
					"atid"     =>	$data['atid'],
					"tribe"    =>	$data['tribe'],
					"vip"      =>	$data['vip'],
					"level"    =>	$data['level'],
					"avatar"   =>	$data['avatar'],
				))
		);

		$syntax = "C.is_delete = 0 AND C.parent_id = '".$data['id']."'";
		$list = $this->db->select("U.*, C.user_id, C.id, type, content, C.create_date, (R.comment_id IS NOT NULL) AS temperature_fire")
						 ->from($this->post_comment_table." C")
						 ->join($this->user_comment_temperature_table." R", "R.comment_id = C.id AND R.user_id = '{$seen_user_id}'", "left")
						 ->join($this->user_table." U", "U.id = C.user_id", "left")
						 ->where($syntax)
						 ->order_by("C.id DESC, C.create_date DESC")
						 ->get()->result_array();
		$comment['photo'] = $this->db->select("id, description, CONCAT('".base_url()."', `normal_url`) as path, CONCAT('".base_url()."', `thumb_url`) as thumb")->get_where($this->media_table, array("type"=>"comment", "relation_id"=>$data['id'], "normal_url<>"=>"","is_delete"=>0))->result_array();
		$comment['reply_comment'] = array();
		foreach ($list as $c) {
			$comment['reply_comment'][] = $this->comment_format($c, $seen_user_id);
		}

		return $comment;
	}

	//分享
	public function get_share_cnt($post_id, $is_only_share_to_diary = FALSE){
		$syntax = array("post_id"=>$post_id);
		if ($is_only_share_to_diary) $syntax['share_to'] = 'my_diary';
		return $this->db->get_where($this->post_share_table, $syntax)->num_rows();	
	}

	public function share_post($user_id, $post_id, $share_to){
		$this->db->insert($this->post_share_table, array(
			"user_id"	=>	$user_id,
			"post_id"	=>	$post_id,
			"share_to"	=>	$share_to
		));
		$ps_id = $this->db->insert_id();

		if ($share_to == "my_diary") {
			$post = $this->get_post($post_id);
			$data = array(
				"user_id"    =>	$user_id,
				"share_from" =>	$post_id,
				"post_at"    =>	"",
				"title"      =>	"SHARE: ".$post['title'],
				"summary"    =>	"",
				"status"     =>	"publish"
			);
			$share_post_id = $this->add_post($data);
			if ($share_post_id !== FALSE) {
				$this->db->where(array("id"=>$ps_id))->update($this->post_share_table, array("target_id"=>$share_post_id));
			}
		}
		return TRUE;
	}

	//收藏
	public function get_collect_post_id($user_id, $type = 'array'){
		$data = array();
		if ($type == "syntax") $data = "";
		foreach ($this->db->get_where($this->post_collect_table, array("user_id"=>$user_id))->result_array() as $item) {
			if ($type == "syntax") {
				if ($data != "") $data .= ",";
				$data .= $item['post_id'];
			}else{
				$data[] = $item['post_id'];
			}
		}
		return $data;
	}

	public function del_collect($user_id, $post_id){
		$syntax = array("post_id"=>$post_id, "user_id"=>$user_id);
		if ($this->db->get_where($this->post_collect_table, $syntax)->num_rows() >= 0) {
			$this->db->delete($this->post_collect_table, $syntax);
		}
		return TRUE;
	}
	public function add_collect($user_id, $post_id){
		$syntax = array("post_id"=>$post_id, "user_id"=>$user_id);
		if ($this->db->get_where($this->post_collect_table, $syntax)->num_rows() <= 0) {
			$this->db->insert($this->post_collect_table, $syntax);
		}
		return TRUE;
	}

	//按讚
	public function post_disfire($post_id, $user_id){
		$syntax = array("post_id"=>$post_id, "user_id"=>$user_id);
		if ($this->db->get_where($this->user_post_temperature_table, $syntax)->num_rows() > 0) {
			$this->db->delete($this->user_post_temperature_table, $syntax);
			
			$post = $this->get_post($post_id);
			$temperature = intval($post['temperature']) - 1;
			$temperature = ($temperature <= 0)?0:$temperature;
			$this->db->where(array("id"=>$post_id))->update($this->post_table, array("temperature"=>$temperature));
		}
		return TRUE;
	}

	public function post_fire($post_id, $user_id){
		$syntax = array("post_id"=>$post_id, "user_id"=>$user_id);
		if ($this->db->get_where($this->user_post_temperature_table, $syntax)->num_rows() <= 0) {
			$this->db->insert($this->user_post_temperature_table, $syntax);

			$post = $this->get_post($post_id);
			$temperature = intval($post['temperature']) + 1;
			$this->db->where(array("id"=>$post_id))->update($this->post_table, array("temperature"=>$temperature));
		}
		return TRUE;
	}

	public function get_post($post_id, $is_user_seen = FALSE, $seen_user_id = FALSE){
		if ($is_user_seen && $seen_user_id !== FALSE) {
			$post = $this->db->select("P.*, (R.post_id IS NOT NULL) AS temperature_fire, (C.post_id IS NOT NULL) AS is_collect, CD.classify_id, CC.classify_id as club_classify_id")
						 	 ->from($this->post_table." P")
						 	 ->join($this->user_post_temperature_table." R", "R.post_id = P.id AND R.user_id = '{$seen_user_id}'", "left")
							 ->join($this->post_collect_table." C", "C.post_id = P.id AND C.user_id = '{$seen_user_id}'", "left")
							 ->join($this->post_classify_at_diary_table." CD", "CD.post_id = P.id", "left")
							 ->join($this->post_classify_at_club_table." CC", "CC.post_id = P.id", "left")
						 	 ->where(array("id"=>$post_id, "is_delete"=>0))
						 	 ->get()->row_array();
			if ($post == null) return FALSE;

			$post['temperature_fire'] = boolval($post['temperature_fire']);
			return $post;
		}else{
			return $this->db->get_where($this->post_table, array("id"=>$post_id, "is_delete"=>0))->row_array();	
		}
	}

	//club post classify 話題類型
	public function update_post_club_classify($post_id, $user_id, $club_id, $classify_id){
		$syntax = array(
			"user_id" =>	$user_id,
			"club_id" =>	$club_id,
			"post_id" =>	$post_id
		);	
		if ($this->db->get_where($this->post_classify_at_club_table, $syntax)->num_rows() > 0) {
			$this->db->where($syntax)->update($this->post_classify_at_club_table, array(
				"classify_id"	=>	$classify_id
			));
		}else{
			$syntax['classify_id'] = $classify_id;
			$this->db->insert($this->post_classify_at_club_table, $syntax);	
		}
		return TRUE;
	}

	//diary classify
	public function update_post_diary_classify($post_id, $classify_id){
		$syntax = array("post_id"=>$post_id);
		if ($this->db->get_where($this->post_classify_at_diary_table, $syntax)->num_rows() > 0) {
			foreach ($this->db->get_where($this->post_classify_at_diary_table, $syntax)->result_array() as $item) {
				$classify = $this->get_diary_classify($item['classify_id']);
				$cnt = intval($classify['cnt']) - 1;
				if ($cnt <= 0) $cnt = 0;
				
				$this->edit_diary_classify($item['classify_id'], array("cnt"=>$cnt));
			}
			$this->db->delete($this->post_classify_at_diary_table, $syntax);
		}

		$this->db->insert($this->post_classify_at_diary_table, array("classify_id"=>$classify_id, "post_id"=>$post_id));
		
		$classify = $this->get_diary_classify($classify_id);
		
		$cnt = intval($classify['cnt']) + 1;
		
		$this->edit_diary_classify($classify_id, array("cnt"=>$cnt));


		return TRUE;
	}

	public function edit_diary_classify($classify_id, $data){
		return $this->db->where(array("id"=>$classify_id))->update($this->diary_classify_table, $data);
	}

	public function get_diary_classify($classify_id){
		return $this->db->select("id, title, cnt")->get_where($this->diary_classify_table, array("id"=>$classify_id))->row_array();
	}

	public function get_diary_classify_post_cnt($classify_id){
		return $this->db->get_where($this->post_classify_at_diary_table, array("classify_id"=>$classify_id))->num_rows();
	}

	public function del_diary_classify($classify_id){
		return $this->db->delete($this->diary_classify_table, array("id"=>$classify_id));
	}

	public function add_diary_classify($user_id, $title){
		$this->db->insert($this->diary_classify_table, array(
			"user_id" =>	$user_id,
			"title"   =>	$title
		));
		return $this->db->insert_id();
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

	public function post_photo($post_id, $data){
		$this->load->model("Pic_model");
		foreach ($data as $p) {
			$thumb_url = str_replace(".", "_m.", $p['path']);
			if (!file_exists($thumb_url)) {
				$thumb_url = $this->Pic_model->create_thumb($p['path']);
			}
			$this->db->insert($this->media_table, array(
				"type"        =>	"post",
				"relation_id" =>	$post_id,
				"name"        =>	"",
				"description" =>	$p['description'],
				"normal_url"  =>	$p['path'],
				"thumb_url"   =>	$thumb_url
			));
		}
	}

	public function edit_post_photo($data){
		foreach ($data as $p) {
			if (!array_key_exists("id", $p)) continue;
			if ($p['action'] == 'edit') {
				$this->db->where(array("id"=>$p['id']))->update($this->media_table, array("description"=>$p['description']));
			}else if ($p['action'] == 'delete') {
				$this->db->where(array("id"=>$p['id']))->update($this->media_table, array("is_delete"=>1));
			}
		}	
	}

	public function edit_post($post_id, $data){
		return $this->db->where(array("id"=>$post_id))->update($this->post_table, $data);
	}

	public function edit_post_detail($post_id, $data){
		$syntax = array("post_id"=>$post_id);
		if ($this->db->get_where($this->post_detail_table, $syntax)->num_rows() > 0) {
			return $this->db->where($syntax)->update($this->post_detail_table, $data);
		}else{
			return $this->db->insert($this->post_detail_table, $data);
		}
	}

	public function get_post_detail($post_id, $seen_user_id){
		$post = $this->get_post($post_id, TRUE, $seen_user_id);
		$detail = $this->db->get_where($this->post_detail_table, array("post_id"=>$post_id))->row_array();

		$post = $this->post_format($post, FALSE, $seen_user_id);
		$post['content'] = $detail['content'];

		return $post;
	}

	public function add_post($data){
		if ($this->db->insert($this->post_table, $data)) return $this->db->insert_id();
		return FALSE;
	}

	public function get_list($seen_user_id, $syntax, $page = 1, $order_by = "P.create_date DESC", $page_count = 20){
		if ($page == "" || $page == null) $page = 1;
		$total = $this->db->from($this->post_table." P")
						 ->join($this->user_table." U", "U.id = P.user_id", "left")
						 ->join($this->post_classify_at_club_table." CC", "CC.post_id = P.id", "left")
						 ->where($syntax)->get()->num_rows();
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

		$comment_cnt = $this->get_comment_cnt($post['id'], FALSE);
		$share_cnt = $this->get_share_cnt($post['id']);
		
		$photo = $this->db->select("id, description, CONCAT('".base_url()."', `normal_url`) as path, CONCAT('".base_url()."', `thumb_url`) as thumb")->get_where($this->media_table, array("type"=>"post", "relation_id"=>$post['id'], "is_delete"=>0))->result_array();

		$user = $this->User_model->get_user_formatted($post['user_id']);

		$data = array(
			"id"                  =>	$post['id'],
			"temperature_fire"    =>	boolval($post['temperature_fire']),
			"is_collect"          =>	boolval($post['is_collect']),
			"share_from"          =>	$post['share_from'],
			"post_at"             =>	$post['post_at'],
			"relation_id"         =>	$post['relation_id'],
			"title"               =>	$post['title'],
			"summary"             =>	$post['summary'],
			"temperature"         =>	$post['temperature'],
			"create_date"         =>	$post['create_date'],
			"comment_cnt"         =>	$comment_cnt,
			"share_cnt"           =>	$share_cnt,
			"photo"               =>	$photo,
			"user"                =>	$user,
			"myself"              =>	($post['user_id'] == $seen_user_id)?TRUE:FALSE,
			"badge"               =>	"",
			"badge_bg"            =>	"",
			"viewed"              =>	intval($post['viewed']),
			"offiicial_recommend" => $post['offiicial_recommend']
		);

		if ($post['post_at'] == "lottery" && $post['relation_id'] > 0) {
			$data['event_title'] = $post['event_title'];
			$data['event_prize_title'] = $post['event_prize_title'];
			$data['post_at_title'] = $post['event_title'];
		}else if ($post['post_at'] == "club" && $post['relation_id'] > 0) {
			$club = $this->Club_model->get_data($post['relation_id']);
			$data['post_at_title'] = $club['name'];
		}else if ($post['post_at'] == "day") {
			$data['post_at_title'] = "蹭溫度";
		}else{
			$data['post_at_title'] = "無";
		}

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
}