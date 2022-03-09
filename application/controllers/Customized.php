<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customized extends Base_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Flow_record_model');
		$this->Flow_record_model->set_flow_record("customized", $this->get_client_ip());

		$this->load->model('Collection_model');
		$this->load->model('Customized_model');
	}

	public function index()
	{
		$this->data = array_merge($this->data, array(
			'badge' => "<a href ='../../customized'  style='color:#966067;font-weight:400;' > CUSTOMIZED</a>",
			'data'	=>	$this->Customized_model->get_customized_view(),
			'category' => $this->Collection_model->get_collection_category(),
		));

		$this->load->view('custom',$this->data);
	}
}
