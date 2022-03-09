<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends Base_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Flow_record_model');
		$this->Flow_record_model->set_flow_record("contact", $this->get_client_ip());
		
		$this->load->model('Collection_model');
		$this->load->model('Contact_model');
	}

	public function index()
	{
		$this->data = array_merge($this->data, array(
			//'collection_years'  => $this->Collection_model->get_open_years(),
			'data'			=>	$this->Contact_model->get_view_data(),
			'category' 		=> 	$this->Collection_model->get_collection_category(),
			'badge'			=>	"<a href='../../contact'  style='color:#966067;font-weight:400;'>CONTACT</a>",
		));

		$this->load->view('contact',$this->data);
	}

	public function post()
	{
		if ($this->input->post())
		{
			$data['name']        	= ($this->input->post("name"))			? $this->input->post("name")		: ''		;
			$data['email']     		= ($this->input->post("email"))			? $this->input->post("email")		: ''		;
			$data['phone']       	= ($this->input->post("phone"))			? $this->input->post("phone")		: ''		;
			$data['subject']   		= ($this->input->post("demand"))		? $this->input->post("demand") 		: ''		;
			$data['wedding_date'] 	= ($this->input->post("wedding_date"))	? $this->input->post("wedding_date"): ''		;
			$data['appointment_date'] 	= ($this->input->post("appoint_date"))	? $this->input->post("appoint_date"): ''		;
			$data['message']   		= ($this->input->post("message"))		? $this->input->post("message") 	: ''		;
			//$data['send_ip'] 		= $this->get_client_ip();

			foreach ($data as $key => $value)
			{
				// !d($value);
				// !d($key);
				//exit;
				if ($data[$key] == '')
				{
					$this->js_output_and_back($key . '此欄位不得為空');
				}
			}

			// 確認此 ip 在 5 分鐘內沒有寄件超多 2 次才給傳送。
			// if ($this->Contact_model->is_ip_can_send($data['send_ip']) < 2)
			// {
			// 	if ($this->Contact_model->set_post($data))
			// 	{
			// 		$this->Contact_model->send_contact($data);
			// 		$this->load->view('sended');
			// 	}
			// 	else
			// 	{
			// 		$this->js_output_and_redirect(output_msg('form_50'), base_url());
			// 	}
			// }
			// else
			// {
			// 	$this->js_output_and_redirect(output_msg('contact_002'), base_url());
			// }

				// !d($data);
				// exit;
			if ($this->Contact_model->set_post($data)){
				
				$this->Contact_model->send_contact($data);
				$this->load->view('sended');
			}
			else{
					$this->js_output_and_redirect(output_msg('form_50'), base_url());
			}
			
		}
	}
}
