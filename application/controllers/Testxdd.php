<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testxdd extends Base_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Flow_record_model');
		$this->Flow_record_model->set_flow_record($this->data['active'], $this->get_client_ip());
		
		$this->data['active'] = 'Testxdd';

		$this->load->model('Member_info_model');
		$this->load->model('Member_menu_model');
		$this->load->model('Member_verify_model');
		$this->load->model('Contact_model');
	}

	public function index()
	{
		// test code
		// $this->data = array_merge($this->data, array(
	 //      		'title' => 'collections manage',
	 //      				'tool_btns' => [
		// 	            	['新增年度', base_url()."mgr/collections_mgr/add_year", "btn-primary"]
		// 	    		]
		// ));
		// var_dump($this->data);
		// $this->load->helper(array('email'));
		// $this->load->library('email');
		// $config['protocol'] = 'sendmail';
		// $config['mailpath'] = '/usr/sbin/sendmail';
		// // $config['charset'] = 'iso-8859-1';
		// // $config['wordwrap'] = TRUE;
		// $config['protocol']     = 'smtp';
		// $config['smtp_host']    = 'smtp.gmail.com';
		// $config['smtp_port']    = '587';
		// $config['smtp_timeout'] = '30';
		// $config['smtp_user']    = 'anbonbackend2021@gmail.com';    // 填 Google App Domain Mail 也可以
		// $config['smtp_pass']    = 'Pass82962755';
		// $config['charset']      = 'utf-8';
		// $config['newline']      = "\r\n";
		// $config['mailtype']     = 'html';
		// $config['wordwrap']     = true;

		// $this->email->initialize($config);

		// $this->email->from('anbonbackend2021@gmail.com', 'handsome Yang');
		// $this->email->to('chenzenyang2021@gmail.com');
		// // $this->email->cc('anbonbackend2021@gmail.com');
		// // $this->email->bcc('anbonbackend2021@gmail.com');

		// $this->email->subject('ada11221');
		// $this->email->message('ad112sadas');

		// $this->email->send();
		echo "sadjklsdka";
		// $this->Contact_model->send_mail("chenzenyang0905@gmail.com", "測試寄信");
	}
}