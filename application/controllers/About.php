<?php
defined('BASEPATH') or exit('No direct script access allowed');

class About extends Base_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Flow_record_model');
		$this->Flow_record_model->set_flow_record("about", $this->get_client_ip());
		$this->load->model('Brand_model');
		$this->load->model('Collection_model');
		$this->load->model('Designer_model');
		$this->load->model('Timeline_model');
		$this->load->model('More_photos_model');
	}

	public function brand()
	{
		$this->data = array_merge($this->data, array(
			'category'  => $this->Collection_model->get_collection_category(),
			'badge'	=>	"<a style ='font-weight :400' >ABOUT </a>&nbsp&nbsp  /  <a href= '../../About/Brand' style='color:#966067;font-weight:400;' > &nbsp&nbsp BRAND</a>",
			'data'	=>	$this->Brand_model->get_view_data()
		));

		$this->load->view('about-brand',$this->data);
	}

	public function designer()
	{
		$this->data = array_merge($this->data, array(
			'category'  => $this->Collection_model->get_collection_category(),
			'badge'		=>	"<a style ='font-weight :400' >ABOUT</a>&nbsp&nbsp / <a href= '../../About/Designer'  style='color:#966067;font-weight:400;'>&nbsp&nbspDESIGNER</a>",
			'data'		=>	$this->Designer_model-> get_designer_view()
		));

		$this->load->view('about-designer',$this->data);
	}

	public function timeline()
	{
		$this->data = array_merge($this->data, array(
			'category'  => $this->Collection_model->get_collection_category(),
			'badge'		=>	"<a style ='font-weight :400' >ABOUT</a> &nbsp&nbsp/ <a href= '../../About/Timeline'  style='color:#966067;font-weight:400;'> &nbsp&nbspTIMELINE</a>",
			'data'		=>	$this->Timeline_model->get_timeline_view(),
			'carousel'	=>	$this->More_photos_model->get_carousel()
		));

		$this->load->view('about-timeline',$this->data);
	}
}
