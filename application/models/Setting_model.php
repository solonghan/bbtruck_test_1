<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends Base_Model {
	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

	//輪播圖
	public function banner_list($type, $relation_id = FALSE){
		$banner = array();
		$syntax = array("type"=>$type, "is_delete"=>0);
		if ($relation_id !== FALSE) {
			$syntax['relation_id'] = $relation_id;
		}
		foreach ($this->db->order_by("sort DESC")->get_where($this->media_table, $syntax)->result_array() as $b) {
			$banner[] = array(
				"id"	=>	$b['id'],
				"thumb"	=>	(strpos($b['thumb_url'], 'http') !== FALSE)?$b['thumb_url']:base_url().$b['thumb_url'],
				"path"	=>	(strpos($b['normal_url'], 'http') !== FALSE)?$b['normal_url']:base_url().$b['normal_url'],
				"link"	=>	$b['link']
			);
		}
		return $banner;
	}

	//排行榜
	public function leaderboard_list($tribe, $type, $iam){
		$list = $this->db->select("L.user_id, L.type, L.rank, L.value, U.*")
						 ->from($this->leaderboard_table." L")
						 ->join($this->user_table." U", "U.id = L.user_id", "left")
						 ->where(array("L.tribe"=>$tribe, "L.type"=>$type, "U.is_delete"=>0))
						 ->order_by("L.create_date DESC, L.rank ASC")
						 // ->group_by("L.type, L.tribe")
						 ->get()->result_array();
		$data = array();
		$mine = array(
			"user"  =>	$this->User_model->get_user_formatted($iam['id'], $iam),
			"rank"  =>	"-",
			"value" =>	"-"
		);
		foreach ($list as $item) {
			$value = $item['value'];
			$rank = $item['rank'];
			if ($value == 0) continue;
			if ($item['type'] == "elder") $value = date("Y/m/d", strtotime($item['register_date']));
			if ($value ) {
				// code...
			}
			$data[] = array(
				"user"  => $this->User_model->get_user_formatted($item['user_id'], $item),
				"rank"  => $rank,
				"value" => $value
			);

			if ($item['user_id'] == $iam['id']) {
				$mine['rank'] = $rank;
				$mine['value'] = $value;
			}
		}
		return array(
			"list" => $data,
			"mine" => $mine
		);
	}

	public function leaderboard(){
		$today = date("Y-m-d");
		$refresh_time = intval(str_replace(":", "", $this->config->config['leader_board_refresh_time']));
		if (intval(str_replace(":", "", date("H:i"))) < $refresh_time) {
			$today = date("Y-m-d", strtotime('- 1 day', strtotime($today)));
		}
		$list = $this->db->select("L.user_id, L.type, L.value, U.*")
						 ->from($this->top_leaderboard_table." L")
						 ->join($this->user_table." U", "U.id = L.user_id", "left")
						 ->where(array("L.date"=>$today, "L.value<>"=>0, "U.is_delete"=>0))
						 ->order_by("L.create_date DESC, L.tribe ASC")
						 // ->group_by("L.type, L.tribe")
						 ->get()->result_array();
		$data = array();
		foreach ($list as $item) {
			if (!array_key_exists($item['type'], $data)) $data[$item['type']] = array();
			$value = $item['value'];
			if ($item['type'] == "elder") $value = date("Y/m/d", strtotime($item['register_date']));
			$data[$item['type']][] = array(
				"user"  => $this->User_model->get_user_formatted($item['user_id'], $item),
				"value" => $value
			);
		}
		return $data;
	}

	//bulletin 大聲公
	public function get_bulletin_list($page = 1, $page_count = 10){
		$emergency = $this->db->select("id, content, create_date")->get_where($this->bulletin_table, array("type"=>"emergency", "is_delete"=>0))->result_array();

		$system = $this->db->select("id, content, create_date")->get_where($this->bulletin_table, array("type"=>"system", "is_delete"=>0))->result_array();

		$syntax = array("T.type"=>"user", "T.is_delete"=>0);
		$list = $this->db->select("
							T.id as bulletin_id, T.user_id, T.content, T.create_date, T.reply_to, T.reply_to_user, U.*,
							IF(T.reply_to_user > 0, 
								(SELECT TT.content FROM ".$this->bulletin_table." TT WHERE TT.id = T.reply_to LIMIT 1)
							,'') as reply_to_content
							")
						 ->from($this->bulletin_table." T")
						 ->join($this->user_table." U", "U.id = T.user_id", "left")
						 ->where($syntax)
						 ->limit($page_count, ($page-1)*$page_count)
						 ->order_by("T.create_date DESC")
						 ->get()->result_array();
		$data = array();
		foreach ($list as $item) {
			$reply_to_user = array();
			if ($item['reply_to_user'] > 0) {
				$reply_to_user = $this->User_model->get_user_formatted($item['reply_to_user']);
			}
			$data[] = array(
				"id"               =>	$item['bulletin_id'],
				"content"          =>	$item['content'],
				"create_date"      =>	$this->dateStr($item['create_date']),
				"user"             =>	$this->User_model->get_user_formatted($item['user_id'], $item),
				"reply_to_user"    =>	$reply_to_user,
				"reply_to_content" =>	$item['reply_to_content']
			);
		}

		$total = $this->db->select("count(*) as cnt")->where($syntax)->get($this->bulletin_table." T")->row()->cnt;
		$total_page = ($total % $page_count == 0) ? floor(($total)/$page_count) : floor(($total)/$page_count) + 1;

		return array(
			"data"       =>	$data,
			"page"       =>	$page,
			"total_page" =>	$total_page,
			"emergency"  =>	$emergency,
			"system"     =>	$system
		);
	}

	public function add_bulletin($data){
		if ($data['reply_to'] > 0) {
			$reply_b = $this->get_bulletin($data['reply_to']);
			if($reply_b != null) $data['reply_to_user'] = $reply_b['user_id'];
		}
		if($this->db->insert($this->bulletin_table, $data)){
			return $this->db->insert_id();
		}
		return FALSE;
	}

	public function get_bulletin($id){
		return $this->db->get_where($this->bulletin_table, array("id"=>$id))->row_array();
	}

	//

	public function get_level_str($level){
		if ($level < 4) return "新手";
		return $this->db->order_by("level DESC")->limit(1)->get_where($this->medal_table, array("type"=>"level", "level<="=>$level))->row()->name;
	}

	//medal
	public function earn_medal($user_id, $medal_id = FALSE){
		$has_medal = array();
		foreach ($this->db->get_where($this->user_medal_related_table, array("user_id"=>$user_id))->result_array() as $m) {
			$has_medal[] = $m['medal_id'];
		}
		$user = $this->User_model->get_data($user_id);

		$syntax = "is_delete = 0";
		if ($medal_id === FALSE) {
			$syntax .= " AND level <= '".$user['level']."'";
			if (count($has_medal) > 0) {
				$has_medal = json_encode($has_medal);
				$has_medal = str_replace("[", "(", $has_medal);
				$has_medal = str_replace("]", ")", $has_medal);
				$syntax .= " AND id NOT IN ".$has_medal;
			}
		}else{
			if (!in_array($medal_id, $has_medal))
				$syntax .= " AND id = '".$medal_id."'";
			else
				return FALSE;
		}

		foreach ($this->db->get_where($this->medal_table, $syntax)->result_array() as $medal) {
			$this->db->insert($this->user_medal_related_table, array(
				"user_id"	=>	$user_id,
				"medal_id"	=>	$medal['id']
			));
		}
		return TRUE;
	}

	public function get_user_medal($user_id){
		$list = $this->db->select("M.id, M.name as alt, CONCAT('".base_url()."', `img`) as img")
						 ->from($this->user_medal_related_table." R")
						 ->join($this->medal_table." M", "M.id = R.medal_id", "left")
						 ->where(array("R.user_id"=>$user_id, "M.is_delete"=>0))
						 ->get()->result_array();
		return $list;
	}

	//hobby
	public function update_user_hobby($user_id, $data){
		$this->db->delete($this->user_hobby_related_table, array("user_id"=>$user_id));
		foreach ($data as $hobby_id) {
			$this->db->insert($this->user_hobby_related_table, array(
				"user_id"	=>	$user_id,
				"hobby_id"	=>	$hobby_id
			));
		}
		return TRUE;
	}

	public function get_user_hobby($user_id){
		$list = $this->db->select("H.id, H.text")
						 ->from($this->user_hobby_related_table." R")
						 ->join($this->hobby_table." H", "H.id = R.hobby_id", "left")
						 ->where(array("R.user_id"=>$user_id, "H.is_delete"=>0))
						 ->get()->result_array();
		return $list;
	}

	public function get_hobby_list(){
		return $this->db->select("id, text")->get_where($this->hobby_table, array("is_delete"=>0))->result_array();
	}
}