<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bride extends Base_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Flow_record_model');
		$this->Flow_record_model->set_flow_record("bride", $this->get_client_ip());
		
		$this->load->model('Collection_model');
		$this->load->model('Bride_model');
		$this->load->helper('datas_transform');
	}

	public function index()
	{
		$this->data = array_merge($this->data, array(
			'badge'		=>	"<a href='../../bride'  style='color:#966067;font-weight:400;'>BRIDE</a>",
			'category' => $this->Collection_model->get_collection_category(),
			'lists'	=> $this->Bride_model->get_posts(),
		));

		$this->load->view('bride',$this->data);
	}

	public function detail($id)
	{
		$is_id_ok = $this->Bride_model->is_post_delete($id);
		if ($is_id_ok === NULL)
		{
			$this->js_output_and_redirect(output_msg('bride_001'), base_url().'bride/');
		}
		elseif ($is_id_ok == '1')
		{
			$this->js_output_and_redirect(output_msg('bride_001'), base_url().'bride/');
		}

		$lists = $this->Bride_model->get_post_detail($id);
		$imgs = json_decode($lists['imgs'], TRUE);

		$row_html = '';
		foreach ($imgs as $key => $value)
		{
			switch ($value['type'])
			{
				case '1':
					$view_str = 'items/bride_detail_item1';
					break;
				case '2':
					$view_str = 'items/bride_detail_item2';
					break;
				case '3':
					$view_str = 'items/bride_detail_item3';
					break;
				case '4':
					$view_str = 'items/bride_detail_item4';
					break;

				default:

					break;
			}

			for ($i = 0; $i < bride_type_to_btn_num($value['type']); $i++)
			{
				$data['img'][$i] = $value['img'][$i];
			}
			$row_html .= $this->load->view($view_str, $data, TRUE);
		}
		$tmp=$lists['title'];	
		//!d($lists);
		//exit;
		$this->data = array_merge($this->data, array(
			'category' => $this->Collection_model->get_collection_category(),
			'badge'		=>	"<a style='font-weight:400;'>BRIDE /&nbsp&nbsp</a><a href='../../bride'  style='color:#966067;font-weight:400;'> $tmp</a>",
			'row_html'			=> $row_html,
		));

		$this->load->view('bride_detail',$this->data);
	}	

}