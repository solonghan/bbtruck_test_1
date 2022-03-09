<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends Base_Model {

	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

	public function get_event_with_prize($is_draw = TRUE){
		$syntax = "is_delete = 0";
		if ($is_draw) {
			$syntax .= " AND is_drawn = 1";
		}
		$events = $this->get_list($syntax, 'create_date DESC', 1, 100);

		$data = array();
		foreach ($events['data'] as $index => $item) {
			$prize_list = $this->get_prize_list($item['id']);
			$prizes = array();
			foreach ($prize_list as $level) {
				foreach ($level['prize'] as $p) {
					$prizes[] = array(
						"id"	=>	$p['id'],
						"title"	=>	"【".$level['title']."】 ".$p['title']
					);
				}
			}

			$data[] = array(
				"id"	=>	$item['id'],
				"title"	=>	$item['title'],
				"prize"	=>	$prizes
			);
		}
		return $data;
	}

//安邦 尚未完成
	public function get_event_winners($event_id, $prize_level, $my_id){
		$prize = $this->get_prize_list($event_id);
		$data = array();

		$all_user = $this->db->get($this->user_table)->result_array();
		foreach ($prize as $p) {
			if ($prize_level != 'all' && $p['level'] != $prize_level) continue;
			$prize_arr = array();
			foreach ($p['prize'] as $item) {
				$users = array();
				for ($i=0; $i < $item['quota']; $i++) { 
					$user = $all_user[rand(0, count($all_user) - 1)];
					$users[] = $this->User_model->get_user_formatted($user['id'], $user);
				}
				$prize_arr[] = array(
					"title"	=>	$item['title']." / ".$item['quota']."名",
					"users"	=>	$users
				);
			}
			$data[] = array(
				"level"         =>	$p['level'],
				"title"         =>	$p['title'],
				"prize_items"   =>	$prize_arr,
			);
		}
		return $data;
	}

	public function join_lottery($data){
		if($this->db->insert($this->user_event_prize_related_table, $data)){
			$event = $this->get_data($data['event_id']);
			$this->edit($data['event_id'], array("participants"=>intval($event['participants']) + 1));
			$syntax = array(
				"event_id" =>	$data['event_id'],
				"level"    =>	$data['prize_level']
			);
			$epl = $this->db->get_where($this->event_prize_level_table, $syntax)->row_array();
			$this->db->where($syntax)->update($this->event_prize_level_table, array(
				"participants"	=>	intval($epl['participants']) + 1
			));
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function get_prize($event_id, $level){
		return $this->db->get_where($this->event_prize_level_table, array("event_id"=>$event_id, "level"=>$level, "status"=>"on", "is_delete"=>0))->row_array();
	}

	public function get_event_prize_item($prize_id){
		return $this->db->select("P.*, L.title as level_title, L.bticket, L.sticket")
						->from($this->event_prize_table." P")
						->join($this->event_prize_level_table." L", "L.level = P.level", "left")
						->where(array("P.id"=>$prize_id, "P.status"=>"on", "P.is_delete"=>0))
						->get()->row_array();	
	}

	public function iam_join_prize($user_id, $event_id, $level, $return_cnt = FALSE){
		$data = $this->db->get_where($this->user_event_prize_related_table, array(
			"user_id"     =>	$user_id,
			"event_id"    =>	$event_id,
			"prize_level" =>	$level
		))->result_array();

		if ($return_cnt) {
			return count($data);
		}else{
			return $data;
		}
	}

	public function get_prize_list($event_id, $user_id = FALSE){
		$data = array();
		foreach ($this->db->get_where($this->event_prize_level_table, array("event_id"=>$event_id, "status"=>"on", "is_delete"=>0))->result_array() as $item) {
			$data[] = array(
				"level"         =>	$item['level'],
				"title"         =>	$item['title'],
				"img"           =>	base_url().$item['img'],
				"sticket"       =>	intval($item['sticket']),
				"bticket"       =>	intval($item['bticket']),
				// "sticket_times" =>	rand(1,2000),
				// "bticket_times" =>	rand(1,2000),
				"participants"  =>	$item['participants'],
				"prize"         =>	array(),
				"my_times"      =>	($user_id!==FALSE)?$this->iam_join_prize($user_id, $event_id, $item['level'], TRUE):0
			);
		}

		foreach ($this->db->get_where($this->event_prize_table, array("event_id"=>$event_id, "status"=>"on", "is_delete"=>0))->result_array() as $prize) {
			$index = array_search($prize['level'], array_column($data, 'level'));
			if (is_null($index)) continue;

			$data[$index]['layout'] = $prize['layout'];
			$data[$index]['prize'][] = array(
				"id"     =>	$prize['id'],
				"layout" =>	$prize['layout'],
				"cover"  =>	base_url().$prize['cover'],
				"title"  =>	$prize['title'],
				"worth"  =>	$prize['worth'],
				"quota"  =>	$prize['quota'],
				"des"    =>	$prize['des']
			);
		}

		return $data;
	}

	public function edit($id, $data, $is_multi = FALSE){
		if ($is_multi) {
			return $this->db->update_batch($this->event_table, $data, "id");
		}else{
			return $this->db->where(array("id"=>$id))->update($this->event_table, $data);
		}
	}

	public function add($data, $is_multi = FALSE){
		if ($is_multi) {
			return $this->db->insert_batch($this->event_table, $data);
		}else{
			return $this->db->insert($this->event_table, $data);
		}
	}

	public function get_data($id){
		return $this->event_format($this->db->get_where($this->event_table, array("id"=>$id))->row_array());
	}

	public function get_all_list(){
		return $this->db->get_where($this->event_table, array("is_delete"=>0, "status"=>"open"))->result_array();
	}

	public function get_first_event(){
		return $this->db->order_by("start_datetime ASC")->limit(1)->get_where($this->event_table, array("is_delete"=>0))->row_array();
	}

	public function get_list($syntax, $order_by = 'create_date desc', $page = 1, $page_count = 20){
		$total = $this->db->where($syntax)->get($this->event_table)->num_rows();
		$total_page = ($total % $page_count == 0) ? floor(($total)/$page_count) : floor(($total)/$page_count) + 1;

		$list = $this->db->select("*")
						 ->from($this->event_table)
						 ->where($syntax)
						 ->order_by($order_by)
						 ->limit($page_count, ($page-1)*$page_count)
						 ->get()->result_array();
		$data = array();
		foreach ($list as $item) {
			$data[] = $this->event_format($item);
		}
		return array(
			"total_page" =>	$total_page,
			"page"       =>	$page,
			"data"       =>	$data
		);
	}

	private function event_format($item){
		$cover = base_url();
		if ($item['cover'] != "") $cover = base_url().$item['cover'];
		$period = $item['start_datetime']." ~ ".$item['end_datetime'];
		if ($item['start_datetime'] == $item['end_datetime']) $period = $item['start_datetime'];
		
		return array(
			"id"             =>	$item['id'],
			"title"          =>	$item['title'],
			"cover"          =>	$cover,
			"start_datetime" =>	$item['start_datetime'],
			"end_datetime"   =>	$item['end_datetime'],
			"period"         =>	$period,
			"participants"   =>	$item['participants'],
			"rule"           =>	$item['rule'],
			"is_expired"     => $item['is_expired'],
			"is_drawn"       => ($item['is_drawn']==1)?TRUE:FALSE,
			"is_restrict"    =>	($item['type'] == "case")?TRUE:FALSE
		);
	}

	// ----------------------------------------------------------------後臺用
	public function get_list_b($syntax, $order_by, $page, $page_count)
	{
		$total = $this->db->select()->where($syntax)->get($this->event_table)->num_rows();
		$total_page = ceil($total / $page_count);

		$list = $this->db->select()
			->from($this->event_table)
			->where($syntax)
			->limit($page_count, ($page - 1) * $page_count)
			->order_by($order_by)
			->get()->result_array();

		return array(
			'total'       => $total,
			'total_page' => $total_page,
			'list'        => $list,
		);
	}

	public function	add_b($data)
	{
		$this->db->insert($this->event_table, $data);
		$id = $this->db->insert_id();
		return $id;
	}

	public function add_event_level($data)
	{
		return $this->db->insert_batch($this->event_prize_level_table, $data);
	}

	public function add_prize_b($data)
	{
		return $this->db->insert($this->event_prize_table, $data);
	}

	public function get_data_b($event_id)
	{
		return $this->db->get_where($this->event_table, array('id' => $event_id))->row_array();
	}

	public function get_level_list_b($event_id)
	{
		return $this->db->select('level, title, id, img')->order_by('level ASC')->get_where($this->event_prize_level_table, array('event_id' => $event_id, 'is_delete' => 0))->result_array();
	}

	public function get_prize_data($prize_id)
	{
		return $this->db->get_where($this->event_prize_table, array('id' => $prize_id))->row_array();
	}

	public function get_prize_count($event_id, $level)
	{
		return $this->db->select()->from($this->event_prize_table)->where(array('event_id' => $event_id, 'level' => $level))->get()->num_rows();
	}

	public function edit_level($syntax, $data)
	{
		return $this->db->where($syntax)->update($this->event_prize_level_table, $data);
	}

	public function edit_prize($syntax, $data)
	{
		return $this->db->where($syntax)->update($this->event_prize_table, $data);
	}

	public function get_awards_list_b($syntax, $order_by, $page, $page_count)
	{
		$total = $this->db->select()->join($this->event_prize_level_table . " PL", "P.event_id=PL.event_id AND P.level=PL.level AND PL.is_delete=0", "left")->join($this->event_table . " E", "P.event_id=E.id", "left")->get_where($this->event_prize_table . " P", $syntax)->num_rows();
		$total_page = ceil($total / $page_count);

		$list = $this->db->select("P.*, PL.title AS level_title, E.title AS event_title, PL.img AS level_img")
		->from($this->event_prize_table . " P")
		->join($this->event_prize_level_table . " PL", "P.event_id=PL.event_id AND P.level=PL.level AND PL.is_delete=0")
		->join($this->event_table . " E", "P.event_id=E.id")
		->where($syntax)
		->limit($page_count, ($page - 1) * $page_count)
		->order_by($order_by)
			// ->group_by("P.id")
			->get()->result_array();

		return array(
			'total'      => $total,
			'total_page' => $total_page,
			'list'       => $list,
		);
	}
}