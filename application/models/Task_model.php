<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Task_model extends Base_Model {
	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");

		$this->load->model("Notification_model");
	}

	public function get_task($task_id){
		return $this->db->get_where($this->task_table, array("id"=>$task_id))->row_array();
	}

	public function complete_task($user_id, $task_id, $success_to_reward = FALSE){
		$task = $this->get_task($task_id);
		if ($task_id >= 1 && $task_id <= 5) {
			if ($this->db->get_where($this->task_completed_table, array("user_id"=>$user_id, "task_id"=>$task_id))->num_rows() <= 0) {
				$this->db->insert($this->task_completed_table, array(
					"user_id"	=>	$user_id,
					"task_id"	=>	$task_id,
					"status"	=>	"success",
					"take_date"	=>	date("Y-m-d H:i:s")
				));
			}

			$complete_task = $this->db->group_by("task_id")->get_where($this->task_completed_table, array("user_id"=>$user_id, "task_id>="=>1, "task_id<="=>5))->num_rows();
			if ($complete_task >= 5 && $this->db->get_where($this->task_completed_table, array("user_id"=>$user_id, "task_id"=>6))->num_rows() <= 0) {
				$this->db->insert($this->task_completed_table, array(
					"user_id"	=>	$user_id,
					"task_id"	=>	6,
					"status"	=>	"pending"
				));	
				$this->Notification_model->add_system_data($user_id, "恭喜您，完成所有新手任務", "task");
			}

			return TRUE;
		}

		if ($task_id == 6) {
			//rookie 完成所有任務
			if ($this->db->get_where($this->task_completed_table, array("user_id"=>$user_id, "task_id"=>6, "status"=>"pending"))->num_rows() > 0) {
				return $this->db->where(array("user_id"=>$user_id, "task_id"=>6))->update($this->task_completed_table, array(
					"status"	=>	"success",
					"take_date"	=>	date("Y-m-d H:i:s")
				));
			}else{
				return FALSE;
			}
		}

		if ($task_id == 7 || $task_id == 8) {
			if ($success_to_reward) {
				if ($this->db->like("create_date", date("Y-m-d"))->get_where($this->task_completed_table, array("user_id"=>$user_id, "task_id"=>$task_id, "status"=>"pending"))->num_rows() > 0) {
					return $this->db->like("create_date", date("Y-m-d"))->where(array("user_id"=>$user_id, "task_id"=>$task_id))->update($this->task_completed_table, array(
						"status"	=>	"success",
						"take_date"	=>	date("Y-m-d H:i:s")
					));
				}else{
					return FALSE;
				}
			}else{
				if($this->db->like("create_date", date("Y-m-d"))->get_where($this->task_completed_table, array("user_id"=>$user_id, "task_id"=>$task_id))->num_rows() <= 0) {
					$this->db->insert($this->task_completed_table, array(
						"user_id"	=>	$user_id,
						"task_id"	=>	$task_id,
						"status"	=>	"pending"
					));	

					$this->Notification_model->add_system_data($user_id, "恭喜您，完成每日任務「".$task['title']."」", "task");

					return TRUE;
				}	
			}
		}

		if ($task_id >= 9 && $task_id <= 13) {
			//累積時間任務
			if ($success_to_reward) {
				if ($this->db->like("create_date", date("Y-m-d"))->get_where($this->task_completed_table, array("user_id"=>$user_id, "task_id"=>$task_id, "status"=>"pending"))->num_rows() > 0) {
					return $this->db->like("create_date", date("Y-m-d"))->where(array("user_id"=>$user_id, "task_id"=>$task_id))->update($this->task_completed_table, array(
						"status"	=>	"success",
						"take_date"	=>	date("Y-m-d H:i:s")
					));
				}else{
					return FALSE;
				}		
			}else{
				if($this->db->like("create_date", date("Y-m-d"))->get_where($this->task_completed_table, array("user_id"=>$user_id, "task_id"=>$task_id))->num_rows() <= 0) {
					$this->db->insert($this->task_completed_table, array(
						"user_id"	=>	$user_id,
						"task_id"	=>	$task_id,
						"status"	=>	"pending"
					));	

					$this->Notification_model->add_system_data($user_id, "恭喜您，完成每日任務「".$task['title']."」", "task");

					return TRUE;
				}	
			}
			
		}
		return FALSE;
	}

	public function task_list($user_id){
		$list = $this->db->select("T.*, C.create_date as task_complete_date, C.status as task_status, C.take_date")
						 ->from($this->task_table." T")
						 ->join($this->task_completed_table." C", "C.task_id = T.id AND C.user_id = '{$user_id}' AND C.is_reset = 0", "left")
						 ->where("T.status = 'on'")
						 ->order_by("T.id ASC, C.id DESC")
						 ->group_by("T.id")
						 ->get()->result_array();
		$task = array("rookie"=>array(),"daily"=>array(),"challenge"=>array());
		$user = $this->User_model->get_data($user_id);

		foreach ($list as $item) {
			$task[$item['type']][] = $this->task_format($user_id, $item, $user);
		}

		$data = array();
		$data[] =array(
			"tasks"     =>	$task['rookie'],
			"title"     =>	"新手任務",
			"sub_title" =>	""
		);
		$data[] = array(
			"tasks"     =>	$task['daily'],
			"title"     =>	"每日任務",
			"sub_title" =>	"每日 0:00 重置"
		);
		$data[] = array(
			"tasks"     =>	$task['challenge'],
			"title"     =>	"挑戰任務",
			"sub_title" =>	""
		);

		return $data;
	}

	private function task_format($user_id, $item, $user = FALSE){
		$percent = 0;
		$reward = "";
		$btn_enable = FALSE;
		$btn_text = "尚未<br>達成";
		$btn_action = "func";
		$btn_action_value = "";
		$finished = FALSE;

		$f_url = $this->config->config['frontend_url'];

		// if ($item['tribe'] > 0) $reward .= (($reward!="")?" + ":"").$this->reward_image_path('tribe', TRUE, TRUE)."×".$item['tribe'];
		// if ($item['bticket'] > 0) $reward .= (($reward!="")?" + ":"").$this->reward_image_path('tribe', TRUE, TRUE)."×".$item['bticket'];
		// if ($item['sticket'] > 0) $reward .= (($reward!="")?" + ":"").$this->reward_image_path('tribe', TRUE, TRUE)."×".$item['sticket'];
		// if ($item['shell'] > 0) $reward .= (($reward!="")?" + ":"").$this->reward_image_path('tribe', TRUE, TRUE)."×".$item['shell'];
		// if ($item['point'] > 0) $reward .= (($reward!="")?" + ":"").$this->reward_image_path('tribe', TRUE, TRUE)."×".$item['point'];

		if ($item['tribe'] > 0) $reward .= (($reward!="")?" + ":"").$this->reward_title('tribe')."×".$item['tribe'];
		if ($item['bticket'] > 0) $reward .= (($reward!="")?" + ":"").$this->reward_title('bticket')."×".$item['bticket'];
		if ($item['sticket'] > 0) $reward .= (($reward!="")?" + ":"").$this->reward_title('sticket')."×".$item['sticket'];
		if ($item['shell'] > 0) $reward .= (($reward!="")?" + ":"").$this->reward_title('shell')."×".$item['shell'];
		if ($item['point'] > 0) $reward .= (($reward!="")?" + ":"").$this->reward_title('point')."×".$item['point'];

		if ($item['task_status'] != null) {
			if ($item['task_status'] == 'success') {
				$finished = TRUE;
				$btn_text = "已完成";
				$btn_enable = FALSE;
			}else{
				$btn_text = "領取<br>獎勵";
				$btn_enable = TRUE;
			}
			$percent = 100;
		}else{
			$btn_action = $item['action'];

			if ($item['action'] == "url") {
				$btn_enable = TRUE;
				$btn_text = "GO";
				$btn_action_value = $f_url.$item['url'];
			}

			$percent = $this->task_percent_calc_without_complete($user_id, $item['function'], $item['action'], $user);
		}
		

		return array(
			"id"               =>	$item['id'],
			"title"            =>	$item['title'],
			"percent"          =>	$percent,
			"reward"           =>	$reward,
			"btn_enable"       =>	$btn_enable,
			"btn_text"         =>	$btn_text,
			"btn_action"       =>	$btn_action,
			"btn_action_value" =>	$btn_action_value,
			"finished"         =>	$finished,
		);
	}

	public function task_percent_calc_without_complete($user_id, $function, $action, $user = FALSE){
		if ($user !== FALSE && substr($function, 0, 7) == 'online_') {
			$time = explode("_", str_replace("online_", "", $function));
			$percent = 0;

			if ($time[1] == 'minute') {
				$percent = round($user['cumulative_time'] / (intval($time[0]) * 60), 3) * 100;
				if ($percent >= 100) $percent = 100;
			}

			return $percent;
		}
		
		switch ($function) {
			case 'add_friend_offical_account':
			case 'post_daily_task':
			case 'share_official_post':
			case 'complete_profile':
			case 'use_bulletin_once':
			case 'watch_tv':{
				return 0;
			}
			case 'watch_club_adv_10':{
				$this->load->model("Adv_model");
				$cnt = $this->Adv_model->today_adv_seen_cnt($user_id);
				$percent = ($cnt >= 10)?100:round($cnt/10, 2)*100;
				return $percent;
			}
			case 'complete_arena_qna_7':{
				return 0;
			}
			case 'complete_arena_survey_7':{
				return 0;
			}
			case 'complete_arena_vote_7':{
				return 0;
			}
			case 'arena_complete':{
				return 0;
			}
		}
	}

	//簽到任務
	public function today_has_checking($user_id){
		$today = date("Y-m-d");
		return ($this->db->like("create_date", $today)->get_where($this->checkin_log_table, array("user_id"=>$user_id))->num_rows() > 0)?TRUE:FALSE;
	}

	public function user_checking_reward($user_id){
		// $this->checking_reward_table
		$last_checking = $this->db->order_by("id DESC")->limit(1)->get_where($this->checkin_log_table, array("user_id"=>$user_id))->row_array();
		$days = 1;
		if ($last_checking != null) $days = intval($last_checking['days']) + 1;

		//實際執行簽到動作
		$this->db->insert($this->checkin_log_table, array("user_id"=>$user_id, "days"=>$days));
		$point = 2;
		$shell = 0;
		$tribe = 0;
		$sticket = 0;
		$bticket = 0;

		$days = $days % $this->config->config['checkin_loop_days'];
		if ($days == 0) $days = 7;

		$data = array();
		$rewards = $this->db->order_by("id asc")->get_where($this->checkin_reward_table, array("status"=>"on"))->result_array();
		foreach ($rewards as $index => $r) {
			$current_index = $index + 1;
			$data[] = array(
				"title"    =>	$r['title'],
				"reward"   =>		array(
					"title"	=>	$this->reward_title($r['reward']),
					"type"	=>	$r['reward'],
					"cnt"	=>	$r['cnt'],
					"icon"	=>	$this->reward_image_path($r['reward'], FALSE)
				),
				"checked"  =>	($current_index <= $days),
				"animated" =>	($current_index == $days)
			);

			if ($current_index == $days) {
				switch ($r['reward']) {
					case 'shell':
						$shell = intval($r['cnt']);
						break;
					case 'point':
						$point = intval($r['cnt']);
						break;
					case 'sticket':
						$sticket = intval($r['cnt']);
						break;
					case 'bticket':
						$bticket = intval($r['cnt']);
						break;
					case 'tribe':
						$tribe = intval($r['cnt']);
						break;
				}
			}
		}

		$is_extra = FALSE;
		if ($days == $this->config->config['checkin_loop_days']) {
			$is_extra = TRUE;
			$bticket = 1;
		}
		$extra_reward = array(
			"title"      =>	"連續七天登入額外贈送",
			"sub_titlte" =>	"還有".($this->config->config['checkin_loop_days'] - $days)."天",
			"reward"     =>	array(
				"title"	=>	"大獵券",
				"type"	=>	"bticket",
				"cnt"	=>	2,
				"icon"	=>	$this->reward_image_path('bticket', FALSE)
			),
			"checked"  =>	$is_extra,
			"animated" =>	$is_extra
		);


		$reward_title = "";
		$reward_sub_title = "";
		$reward_icon = array();
		if ( $point > 0 || $shell > 0 || $tribe > 0 || $sticket > 0 || $bticket > 0) {
			$this->User_model->user_reward($user_id, $point, $shell, $sticket, $bticket, $tribe);
			$reward_title = "簽到獎勵";
			$reward_sub_title = "您已獲得：";
			if ($point > 0) $reward_icon[] = array("type"=>"point","cnt"=>$point);
			if ($shell > 0) $reward_icon[] = array("type"=>"shell","cnt"=>$shell);
			if ($sticket > 0) $reward_icon[] = array("type"=>"sticket","cnt"=>$sticket);
			if ($bticket > 0) $reward_icon[] = array("type"=>"bticket","cnt"=>$bticket);
			if ($tribe > 0) $reward_icon[] = array("type"=>"tribe","cnt"=>$tribe);
		}

		$reward = array(
			"title"     =>	$reward_title,
			"sub_title" =>	$reward_sub_title,
			"reward"    =>	$reward_icon
		);

		return array(
			"data"   =>	$data,
			"extra"  =>	$extra_reward,
			"reward" =>	$reward
		);
	}
}