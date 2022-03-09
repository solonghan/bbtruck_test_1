<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ready_carousel extends Base_Controller
{

	/* for <thead></thead> - Start */
	private $local_th_title         = ['#', '圖片路徑','圖片','建立日期', '動作'];
	private $local_th_width         = ['', '250px','800px' ,'', '150px'];
	private $local_order_column     = ['id', '','','', ''];
	private $local_can_order_fields = [0,];

    private $type=['top','bottom'];
	private $category='';
	private $post_th_title         = ['#', '公告名稱', '獵場', '獵人', '公開類型', '發文時間', '最後修改時間'];
	private $post_th_width         = ['', '', '', '', '',  '', '150px'];
	private $post_order_column     = ['id', '', '', '', '', '', ''];
	private $post_can_order_fields = [0];

	private $hobby_th_title         = ['#', '獵場名稱', '獵場封面', '獵場人數', '討論熱度', '動作'];
	private $hobby_th_width         = ['', '', '', '', '', '150px'];
	private $hobby_order_column     = ['id', '', '', '', '', ''];
	private $hobby_can_order_fields = [0];

	/* for <thead></thead> - End */


	//編輯文章參數
	private $top_param = [
		//																							md 		sm
		["類型",	 	"type", 			"select", 			"", 		TRUE, 	"",  2, 		12, ['id', 'title']],
		
		["圖片",		 	"img", 			"img", 			"", 		TRUE, 	"", 	2, 		12],
		//["獵場顯示名稱",		"show_name", 			"text", 			"", 		TRUE, 	"", 	4, 		12],
		//["公告圖片",		 	"banner", 			"img_multi_without_crop", 			"", 		TRUE, 	"", 	12, 		12, 2 / 1],
		//["獵場代表圖",		 	"cover", 			"img", 			"", 		TRUE, 	"", 	12, 		12, 1],
		//["獵場類別",		 	"category", 		"select", 			"", 		TRUE, 	"", 	4, 		12, ['id', 'title']],
		//["獵場類別",		 	"classify", 		"select", 			"", 		TRUE, 	"", 	4, 		12, ['id', 'title']],
		//["公告內容",		 	"content", 			"textarea", 			"", 		TRUE, 	"", 	12, 		12],
		/*["審核機制",		 	"header", 			"header", 			"", 		TRUE, 	"", 	12, 		12],
		["審核問題1",		 	"q1",	 			"text", 			"", 		FALSE, 	"", 	12, 		12],
		["審核問題2",		 	"q2",	 			"text", 			"", 		FALSE, 	"", 	12, 		12],
		["審核問題3",		 	"q3",	 			"text", 			"", 		FALSE, 	"", 	12, 		12],*/
	];

	private $bottom_param = [
		//																							md 		sm
		["類型",	 	"type", 			"select", 			"", 		TRUE, 	"",  2, 		12, ['id', 'title']],
		
		["圖片",		 	"img", 			"img", 			"", 		TRUE, 	"", 	0.66, 		12],
	];

	public function __construct()
	{
		parent::__construct();
		$this->is_mgr_login();
		$this->load->model('Ready_carousel_top_model');

		$this->data['active'] = 'READY';
		$this->action = base_url() . 'mgr/ready_carousel/';
	}

	// ---------------------------------------------------------------------活動列表 start
	public function index()
	{
		$this->data = array_merge($this->data, array(
			'sub_active'              => 'READY_CAROUSEL',
			'parent'                  => '',
			// 'parent_link'             => base_url() . 'mgr/event/main',
			'custom_del_url'          => base_url() . 'mgr/ready_carousel/local_del',
			'title'                   => '圖片列表',
			'action'                  => $this->action,
			'th_title'                => $this->local_th_title,
			'th_width'                => $this->local_th_width,
			'can_order_fields'        => $this->local_can_order_fields,
			'default_order_column'    => 0,
			'default_order_direction' => 'ASC',
            'category'                => $this->type,  
			'tool_btns'               => [
			     ['新增輪播圖片', base_url() . 'mgr/ready_carousel/add', 'btn-primary'],
			],
		));

		$this->load->view('mgr/ready_carousel_list', $this->data);
	}

	public function data()
	{
		if(!isset($_POST['data_type'])){

			$data_type='top';
			$_SESSION['category']='top';
		}
			
		else	{
			$data_type=$_POST['data_type'];	

			$_SESSION['category']=$data_type;
			
		}
			
			

		$page        = ($this->input->post("page")) ? $this->input->post("page") : 1;
		$search      = ($this->input->post("search")) ? $this->input->post("search") : "";
		$order       = ($this->input->post("order")) ? $this->input->post("order") : 0;
		$direction   = ($this->input->post("direction")) ? $this->input->post("direction") : "ASC";

		$order_column = $this->local_order_column;
		$canbe_search_field = ["id"];

		$syntax = "is_delete=0 and type ='$data_type' ";
		if ($search != "") {
			$syntax .= " AND (";
			$index = 0;
			foreach ($canbe_search_field as $field) {
				if (
					$index > 0
				) $syntax .= " OR ";
				$syntax .= $field . " LIKE '%" . $search . "%'";
				$index++;
			}
			$syntax .= ")";
		}

		$order_by = "id ASC";
		if ($order_column[$order] != "") {
			$order_by = $order_column[$order] . " " . $direction . ", " . $order_by;
		}

		$data = $this->Ready_carousel_top_model->get_local_list($syntax, $order_by, $page, $this->page_count);
		$html = "";
        //var_dump($data);

		foreach ($data['list'] as $item) {
			$html .= $this->load->view("mgr/items/ready_carousel_top_local_item", array(
				"item" =>    $item,
			), TRUE);
		}
        // var_dump($html);
        // exit;
		if ($search != "") $html = preg_replace('/' . $search . '/i', '<mark data-markjs="true">' . $search . '</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>    $html,
			"page"       =>    $page,
			"total_page" =>    $data['total_page']
		));
	}
    public function add()
	{
		//$ready_carousel_top = $this->Ready_carousel_top_model->get_data($id);
		//!d($_SESSION['category']);
		
		require('./vendors/autoload.php');
		//require('C:/xampp/htdocs/new_wedding/vendors/autoload.php');
		if ($_POST) {
			// exit;
			if($_SESSION['category']=='top')
				$data = $this->process_post_data($this->top_param);
			else
				$data=$this->process_post_data($this->bottom_param);

				if ($this->Ready_carousel_top_model->add($data)) {
		
				$this->js_output_and_redirect("新增成功", base_url() . "mgr/ready_carousel/");
			} else {
				$this->js_output_and_back("發生錯誤");
			}
		} else {
			//$this->data['pics'] = $this->Ready_carousel_top_model->get_banner($id);
			$this->data['type'] = 'edit';
			if($_SESSION['category']=='top')
				$this->data['param'] = $this->top_param;
			else
				$this->data['param'] = $this->bottom_param;
			$this->data['title'] = '新增圖片';
			$this->data['sub_active'] =  'READY_CAROUSEL';

			$this->data['parent'] = '圖片列表';
			$this->data['parent_link'] = base_url() . "mgr/ready_carousel";

			$this->data['action'] = base_url() . "mgr/ready_carousel/add" ;
			$this->data['submit_txt'] = "確認新增";

			//$this->data['select']['category'] = $this->Ready_carousel_top_model->get_hobby_ready_carousel_top_classify();
			//$this->data['classify'] = json_encode($this->data['select']['category']);
			$this->data['select']['type'] = array(['id' => 'top', 'title' => 'top'], ['id' => 'bottom', 'title' => 'bottom']);
		
			$this->load->view("mgr/template_form", $this->data);
		}
	}
	public function edit($id)
	{
		require('./vendors/autoload.php');	
		//require('C:/xampp/htdocs/new_wedding/vendors/autoload.php');
		$ready_carousel_top = $this->Ready_carousel_top_model->get_data($id);
		if ($_POST) {
			
			if($_SESSION['category']=='top')
			$data = $this->process_post_data($this->top_param);
		else
			$data=$this->process_post_data($this->bottom_param);
			
			
			if ($this->Ready_carousel_top_model->edit($id, $data)) {
				
				$this->js_output_and_redirect("編輯成功", base_url() . "mgr/ready_carousel/");
			} else {
				$this->js_output_and_back("發生錯誤");
			}
		} else {
			//$this->data['pics'] = $this->Ready_carousel_top_model->get_banner($id);
			$this->data['type'] = 'edit';

			if($_SESSION['category']=='top')
				$this->data['param'] = $this->set_data_to_param($this->top_param, $ready_carousel_top);
			else
				$this->data['param'] =$this->set_data_to_param($this->bottom_param,$ready_carousel_top);
			$this->data['title'] = '編輯圖片';
			$this->data['sub_active'] =  'READY_CAROUSEL';

			$this->data['parent'] = '圖片列表';
			$this->data['parent_link'] = base_url() . "mgr/ready_carousel/";

			$this->data['action'] = base_url() . "mgr/ready_carousel/edit/" . $id;
			$this->data['submit_txt'] = "確認編輯";

			//$this->data['select']['category'] = $this->Ready_carousel_top_model->get_hobby_ready_carousel_top_classify();
			//$this->data['classify'] = json_encode($this->data['select']['category']);
			$this->data['select']['type'] = array(['id' => 'top', 'title' => 'top'], ['id' => 'bottom', 'title' => 'bottom']);
			// var_dump($this->data);
			// exit;
			$this->load->view("mgr/template_form", $this->data);
		}
	}

	public function local_del()
	{
		$id = $this->input->post('id');
		if (!is_numeric($id)) $this->output(FALSE, '發生錯誤');
		if ($this->ready_carousel_top_model->edit($id, array('is_delete' => 1))) {
			$this->output(TRUE, 'success');
		} else {
			$this->output(FALSE, 'fail');
		}
	}
	// ----------------------------------------------------------------活動列表 end

	// ----------------------------------------------------------------文章列表 start
	public function post_list($ready_carousel_top_id)
	{
		$ready_carousel_top = $this->ready_carousel_top_model->get_data($ready_carousel_top_id);
		$this->data = array_merge($this->data, array(
			'sub_active'              => 'ACDEMIC_LOCAL',
			'parent'                  => ($ready_carousel_top['type'] == 'local') ? '在地獵場列表' : '同好獵場',
			'parent_link'             => ($ready_carousel_top['type'] == 'local') ? base_url() . 'mgr/huntground/local' : base_url() . 'mgr/huntground/hobby',
			'custom_data_url'          => base_url() . 'mgr/ready_carousel_top/post_data/' . $ready_carousel_top_id,
			'title'                   => '【' . $ready_carousel_top['name'] . '】的文章列表',
			'action'                  => $this->action,
			'th_title'                => $this->post_th_title,
			'th_width'                => $this->post_th_width,
			'can_order_fields'        => $this->post_can_order_fields,
			'default_order_column'    => 0,
			'default_order_direction' => 'ASC',
			'tool_btns'               => [
				// ['新增抽獎活動', base_url() . 'mgr/event/list_add', 'btn-primary'],
			],
		));

		$this->load->view('mgr/template_list', $this->data);
	}

	public function post_data($ready_carousel_top_id)
	{
		$page        = ($this->input->post("page"))			? $this->input->post("page")		: 1;
		$search      = ($this->input->post("search"))		? $this->input->post("search")		: '';
		$order       = ($this->input->post("order"))		? $this->input->post("order")		: 0;
		$direction   = ($this->input->post("direction"))	? $this->input->post("direction") 	: 'DESC';
		$status  	 = ($this->input->post("status"))		? $this->input->post("status")		: 'ALL';
		$user_id     = ($this->input->post("user_id"))		? $this->input->post("user_id")		: 0;

		$ready_carousel_top = $this->ready_carousel_top_model->get_data($ready_carousel_top_id);

		$syntax	= "P.is_delete=0 AND post_at='ready_carousel_top' AND relation_id='$ready_carousel_top_id'";
		if ($status != 'ALL')
			$syntax .= " AND ( P.`status` = '" . $status . "' )";

		// set SQL : ORDER BY
		$order_by = ' P.`create_date` DESC';
		if ($this->hobby_order_column[$order] != '')
			$order_by = '`' . $this->hobby_order_column[$order] . '` ' . $direction . ', ' . $order_by;

		$lists = $this->ready_carousel_top_model->get_post_list($syntax, $order_by, intval($page), $page_count = 20);

		// Combine item html
		$html = '';

		if ($search !== '') {
			$lists['data'] = &$this->set_search_lists($search, $lists['data'], $this->post_canbe_search_field);
		}

		foreach ($lists['list'] as $item) {
			$html .= $this->load->view("mgr/items/huntground_post_item", array(
				'item' => $item,
				'ready_carousel_top' => $ready_carousel_top,
			), TRUE);
		}

		$this->output(TRUE, '資料取得成功', array(
			'html' 			=> $html,
			'page' 			=> $page,
			'total_page' 	=> $lists['total_page'],
		));
	}

	// ----------------------------------------------------------------文章列表 end

	// ----------------------------------------------------------------同好獵場 start
	public function hobby()
	{
		$this->data = array_merge($this->data, array(
			'sub_active'              => 'HUNTGROUND_HOBBY',
			'parent'                  => '',
			// 'parent_link'             => base_url() . 'mgr/event/main',
			'custom_data_url'          => base_url() . 'mgr/huntground/hobby_data',
			'custom_del_url'          => base_url() . 'mgr/huntground/hobby_del',
			'title'                   => '同好獵場列表',
			'action'                  => $this->action,
			'th_title'                => $this->hobby_th_title,
			'th_width'                => $this->hobby_th_width,
			'can_order_fields'        => $this->hobby_can_order_fields,
			'default_order_column'    => 0,
			'default_order_direction' => 'ASC',
			'tool_btns'               => [
				['新增同好獵場', base_url() . 'mgr/huntground/hobby_add', 'btn-primary'],
			],
		));

		$this->load->view('mgr/template_list', $this->data);
	}

	public function hobby_data()
	{
		$page        = ($this->input->post("page")) ? $this->input->post("page") : 1;
		$search      = ($this->input->post("search")) ? $this->input->post("search") : "";
		$order       = ($this->input->post("order")) ? $this->input->post("order") : 0;
		$direction   = ($this->input->post("direction")) ? $this->input->post("direction") : "ASC";

		$order_column = $this->local_order_column;
		$canbe_search_field = ["id", "title", "rule", "start_datetime", "end_datetime", "create_date"];

		$syntax = "is_delete=0 AND type='hobby'";
		if ($search != "") {
			$syntax .= " AND (";
			$index = 0;
			foreach ($canbe_search_field as $field) {
				if (
					$index > 0
				) $syntax .= " OR ";
				$syntax .= $field . " LIKE '%" . $search . "%'";
				$index++;
			}
			$syntax .= ")";
		}

		$order_by = "id ASC";
		if ($order_column[$order] != "") {
			$order_by = $order_column[$order] . " " . $direction . ", " . $order_by;
		}

		$data = $this->ready_carousel_top_model->get_local_list($syntax, $order_by, $page, $this->page_count);
		$html = "";
		foreach ($data['list'] as $item) {
			$html .= $this->load->view("mgr/items/ready_carousel_top_local_item", array(
				"item" =>    $item,
			), TRUE);
		}
		if ($search != "") $html = preg_replace('/' . $search . '/i', '<mark data-markjs="true">' . $search . '</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>    $html,
			"page"       =>    $page,
			"total_page" =>    $data['total_page']
		));
	}

	public function hobby_add()
	{
		if ($_POST) {
			require('./vendor/autoload.php');
			$data = $this->process_post_data($this->hobby_param);
			// TODO: 新欄位還沒串
			if ($this->ready_carousel_top_model->edit($id, $data)) {
				$this->js_output_and_redirect("編輯成功", base_url() . "mgr/huntground/local/");
			} else {
				$this->js_output_and_back("發生錯誤");
			}
		} else {
			$this->data['title'] = '新增獵場';
			$this->data['sub_active'] = 'HUNTGROUND_HOBBY';

			$this->data['parent'] = '同好獵場列表';
			$this->data['parent_link'] = base_url() . "mgr/huntground/hobby";

			$this->data['action'] = base_url() . "mgr/huntground/hobby_add";
			$this->data['submit_txt'] = "新增";
			$this->data['param'] = $this->hobby_param;
			$this->data['select']['category'] = $this->ready_carousel_top_model->get_hobby_ready_carousel_top_classify();
			$this->data['classify'] = json_encode($this->data['select']['category']);
			$this->data['select']['is_private'] = array(['id' => 1, 'title' => '公開'], ['id' => 0, 'title' => '不公開']);

			$this->load->view("mgr/ready_carousel_top_form", $this->data);
		}
	}

	// ----------------------------------------------------------------同好獵場 end
}
