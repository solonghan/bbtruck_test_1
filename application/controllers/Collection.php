<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Collection extends Base_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Flow_record_model');
		$this->Flow_record_model->set_flow_record("collection", $this->get_client_ip());

		$this->load->model('Collection_model');
	}

	public function index($year = 'bridal-gowns')
	{
	
		// $this->Collection_model->check_year_menu_is_on($year);
		// if ($this->Collection_model->check_year_menu_is_on($year) === FALSE)
		// 	$this->js_output_and_redirect(output_msg('collection_005'), base_url());
		$tmp=strtoupper($year);

		$this->data = array_merge($this->data, array(
			'badge' 	=> "<a style='font-weight:400;'>COLLECTION /</a><a href='../../collection/'$tmp   style='color:#966067;font-weight:400;'> &nbsp&nbsp$tmp</a>",
			'category'  => $this->Collection_model->get_collection_category(),
			//'collection_years' => $this->Collection_model->get_open_years(),
			'lists'		=> $this->Collection_model->get_post($year),
		));

		$this->load->view('collection',$this->data);
	}

	public function detail($id = '1')
	{
		$item = $this->Collection_model->get_post_detail($id);

		// $year = $this->Collection_model->get_year_by_year_id($item['year_id']);
		// if ($this->Collection_model->check_year_menu_is_on($year) === FALSE)
		// 	$this->js_output_and_redirect(output_msg('collection_005'), base_url());
		$tmp=$item['name'];
		$this->data = array_merge($this->data, array(
			// 'year' => $this->Collection_model->get_year_by_year_id($item['year_id']),
			'category'  => $this->Collection_model->get_collection_category(),
			'badge'	=>	"<a style='font-weight:400;'>COLLECTION /&nbsp&nbsp</a><a href='../../collection/$tmp'  style='color:#966067;font-weight:400;'> $tmp</a>",
			// 'collection_years' => $this->Collection_model->get_open_years(),
			'item' => $item,
		));

		$this->load->view('collection_detail',$this->data);
	}
	public function rtw($id = '1')
	{
		$item = $this->Collection_model->get_post_detail($id);

		$year = $this->Collection_model->get_year_by_year_id($item['year_id']);
		if ($this->Collection_model->check_year_menu_is_on($year) === FALSE)
			$this->js_output_and_redirect(output_msg('collection_005'), base_url());

		$this->data = array_merge($this->data, array(
			'category'  => $this->Collection_model->get_collection_category(),
			'year' => $this->Collection_model->get_year_by_year_id($item['year_id']),
			'collection_years' => $this->Collection_model->get_open_years(),
			'item' => $item,
		));
		$this->load->view('readytowear');
	}
}
