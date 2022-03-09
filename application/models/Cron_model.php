<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_model extends Base_Model {

	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

	public function club_whether_is_hot(){
		$day = 7;
		$discuss_limit = 700;
		$date = date("Y-m-d", strtotime("- ".($day+1)." day", strtotime("Y-m-d")));

		$list = $this->db->select("C.id, (SELECT SUM(club_discuss) FROM ".$this->club_discuss_log_table." L WHERE L.club_id = C.id AND L.date>='{$date}') as hot_log")
						 ->from($this->club_table." C")
						 ->where(array("C.type"=>"hobby"))
						 ->get()->result_array();
		foreach ($list as $item) {
			if ($item['hot_log'] >= $discuss_limit) {
				echo $item['id']." HOT<br>";
				$this->db->where(array("id"=>$item['id']))->update($this->club_table, array("is_hot"=>1));
			}else{
				$this->db->where(array("id"=>$item['id']))->update($this->club_table, array("is_hot"=>0));
			}
		}
	}

	public function task_clear(){
		foreach($this->db->get_where($this->user_table, array("cumulative_time>"=>0))->result_array() as $user){
			// echo $user['id']." => ".$user['cumulative_time']."<br>";
			$this->User_model->edit($user['id'], array(
				"total_cumulative_time" =>	intval($user['total_cumulative_time']) + intval($user['cumulative_time']),
				"cumulative_time"       =>	0
			));
		}

		$task = $this->db->get_where($this->task_table, array("type"=>"daily"))->result_array();
		$syntax = "";
		foreach ($task as $t) {
		    if ($syntax != "") $syntax .= ",";
		    $syntax .= $t['id'];
		}
		$syntax = "task_id IN (".$syntax.")";
		$list = $this->db->get_where($this->task_completed_table, $syntax)->result_array();
		foreach($list as $t){
			$this->db->where(array("id"=>$t['id']))->update($this->task_completed_table, array("is_reset"=>1));
		}
	}

	public function generate_leaderboard($tribe = 1){
		$list = $this->db->select("U.id, U.register_date, U.level,
				(SELECT COUNT(*) FROM ".$this->post_table." P WHERE P.user_id = U.id) as post_cnt,
				(SELECT COUNT(*) FROM ".$this->post_comment_table." C WHERE C.user_id = U.id) as comment_cnt,
				(SELECT COUNT(*) FROM ".$this->subscribe_table." S WHERE S.target_id = U.id) as subscribe_cnt,
			")
						 ->from($this->user_table." U")
						 ->where(array("U.is_delete"=>0, "U.tribe"=>$tribe))
						 ->order_by("U.level DESC, U.register_date ASC")
						 ->get()->result_array();
		
		$this->backup_and_del_leaderboard($tribe);
		
		//elder
		$this->save_leaderboard($tribe, "elder", $list);

		//comment
		$list = $this->reorder_data($list, 'comment_cnt');
		$this->save_leaderboard($tribe, "comment", $list);

		//post
		$list = $this->reorder_data($list, 'post_cnt');
		$this->save_leaderboard($tribe, "post", $list);

		//kol
		$list = $this->reorder_data($list, 'subscribe_cnt');
		$this->save_leaderboard($tribe, "kol", $list);
	}

	private function save_leaderboard($tribe, $type, $list){
		$today = date("Y-m-d");
		$refresh_time = intval(str_replace(":", "", $this->config->config['leader_board_refresh_time']));
		if (intval(str_replace(":", "", date("H:i"))) < $refresh_time) {
			$today = date("Y-m-d", strtotime('- 1 day', strtotime($today)));
		}

		$save_key = "level";
		if ($type == "comment") {
			$save_key = "comment_cnt";
		}else if ($type == "post") {
			$save_key = "post_cnt";
		}else if ($type == "kol") {
			$save_key = "subscribe_cnt";
		}

		$top_syntax = array(
			"date"    => $today,
			"type"    => $type,
			"tribe"   => $tribe,
		);
		if($this->db->get_where($this->top_leaderboard_table, $top_syntax)->num_rows() > 0)
			$this->db->delete($this->top_leaderboard_table, $top_syntax);
		$this->db->insert($this->top_leaderboard_table, array(
			"date"    => $today,
			"type"    => $type,
			"tribe"   => $tribe,
			"user_id" => $list[0]['id'],
			"value"   => $list[0][$save_key]
		));

		$data = array();
		foreach ($list as $index => $item) {
		    $data[] = array(
				"user_id" => $item['id'],
				"type"    => $type,
				"tribe"   => $tribe,
				"rank"    => ($index + 1),
				"value"   => $item[$save_key]
		    );
		}

		if (count($data) > 0) $this->db->insert_batch($this->leaderboard_table, $data);
	}

	private function reorder_data($list, $key, $direction = "DESC"){
		usort($list,function($first, $second) use($key, $direction){
			if ($direction == 'ASC') {
				return $first[$key] > $second[$key];
			}else{
				return $first[$key] < $second[$key];
			}
		});	
		return $list;
	}

	private function backup_and_del_leaderboard($tribe){
		$file_content = "";
		$leaderboard = $this->db->order_by("FIELD(type, 'elder', 'comment', 'post', 'kol'), rank ASC")->get_where($this->leaderboard_table, array("tribe"=>$tribe))->result_array();
		if (count($leaderboard) > 0) {
			$current_type = "";
			foreach ($leaderboard as $item) {
				if ($current_type != $item['type']) {
					if ($file_content != "") $file_content .= "\n";
					$file_content .= "Type: ".$item['type']."\n";
					$current_type = $item['type'];
				}

				$file_content .= $item['rank']."\tU[".$item['user_id']."]\tV[".$item['value']."]\n";
			}
			//將舊有資料存檔
			$file_name = "tribe_".$tribe."_rank_".date("YmdHis");
			$f = fopen("rank/".$file_name.".txt", "a+");
			fwrite($f, $file_content);
			fclose($f);	
		}

		$this->db->delete($this->leaderboard_table, array("tribe"=>$tribe));
	}
}