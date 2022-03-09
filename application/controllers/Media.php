<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends Base_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Flow_record_model');
		$this->Flow_record_model->set_flow_record("media", $this->get_client_ip());
		$this->load->model('Media_model');
		$this->load->model('Collection_model');
	}

	public function index()
	{
		$this->data = array_merge($this->data, array(
				'category' => $this->Collection_model->get_collection_category(),
				'badge'		=>	"<a href='../../media/'  style='color:#966067;font-weight:400;'>MEDIA</a>",
				'post'		=>	$this->Media_model->get_all_post(),
		));

		$this->load->view('media',$this->data);
	}
}