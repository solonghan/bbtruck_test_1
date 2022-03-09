<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('memory_limit', '1600M');
class Cron extends Base_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Cron_model");
	}

	public function index(){
		die();
	}

	public function hour_cron($force = FALSE){
		$hour = date("H");
		$minute = date("i");

		if ($this->Base_model->time_permit(["00:00"])) $this->Cron_model->task_clear();

		if ($this->Base_model->time_permit([$this->config->config['leader_board_refresh_time']]) || $force) $this->Cron_model->generate_leaderboard(1);
		if ($this->Base_model->time_permit([$this->config->config['leader_board_refresh_time']]) || $force) $this->Cron_model->generate_leaderboard(2);
		if ($this->Base_model->time_permit([$this->config->config['leader_board_refresh_time']]) || $force) $this->Cron_model->generate_leaderboard(3);

		if ($this->Base_model->time_permit(["00:30"]) || $force) $this->Cron_model->club_whether_is_hot();
	}

	public function club_whether_is_hot(){
		$this->Cron_model->club_whether_is_hot();
	}
}
