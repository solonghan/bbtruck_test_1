<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Medical extends Base_Controller
{

	/* for <thead></thead> - Start */
	private $local_th_title         = ['#', '公告名稱', '公告內容','上傳者', '動作'];
	private $local_th_width         = ['', '', '250px', '', '', '150px'];
	private $local_order_column     = ['id', '', '', '', ''];
	private $local_can_order_fields = [0,];

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
	private $param = [
		//																							md 		sm
		["公告名稱",		 	"name", 			"text", 			"", 		TRUE, 	"", 	4, 		12],
		//["獵場顯示名稱",		"show_name", 			"text", 			"", 		TRUE, 	"", 	4, 		12],
		["公告圖片",		 	"banner", 			"img_multi_without_crop", 			"", 		TRUE, 	"", 	12, 		12, 2 / 1],
		//["獵場代表圖",		 	"cover", 			"img", 			"", 		TRUE, 	"", 	12, 		12, 1],
		//["獵場類別",		 	"category", 		"select", 			"", 		TRUE, 	"", 	4, 		12, ['id', 'title']],
		//["獵場類別",		 	"classify", 		"select", 			"", 		TRUE, 	"", 	4, 		12, ['id', 'title']],
		["公告內容",		 	"content", 			"textarea", 			"", 		TRUE, 	"", 	12, 		12],
		["公告是否公開",	 	"is_private", 			"select", 			"", 		TRUE, 	"", 	4, 		12, ['id', 'title']],
		/*["審核機制",		 	"header", 			"header", 			"", 		TRUE, 	"", 	12, 		12],
		["審核問題1",		 	"q1",	 			"text", 			"", 		FALSE, 	"", 	12, 		12],
		["審核問題2",		 	"q2",	 			"text", 			"", 		FALSE, 	"", 	12, 		12],
		["審核問題3",		 	"q3",	 			"text", 			"", 		FALSE, 	"", 	12, 		12],*/
	];
/*
	private $hobby_param = [
		//																							md 		sm
		["獵場名稱",		 	"name", 			"text", 			"", 		TRUE, 	"", 	4, 		12],
		["獵場顯示名稱",		"show_name", 			"text", 			"", 		TRUE, 	"", 	4, 		12],
		["獵場封面圖",		 	"banner", 			"img_multi_without_crop", 			"", 		TRUE, 	"", 	12, 		12, 2 / 1],
		["獵場代表圖",		 	"content", 			"text", 			"", 		TRUE, 	"", 	12, 		12, 1],
		["獵場類別",		 	"category", 		"select", 			"", 		TRUE, 	"", 	4, 		12, ['id', 'title']],
		["獵場類別",		 	"classify", 		"select", 			"", 		TRUE, 	"", 	4, 		12, ['id', 'title']],
		["獵場規則",		 	"rule", 			"textarea", 			"", 		TRUE, 	"", 	12, 		12],
		["獵場是否公開",	 	"is_private", 			"select", 			"", 		TRUE, 	"", 	4, 		12, ['id', 'title']],
		["審核機制",		 	"header", 			"header", 			"", 		TRUE, 	"", 	12, 		12],
		["審核問題1",		 	"q1",	 			"text", 			"", 		FALSE, 	"", 	12, 		12],
		["審核問題2",		 	"q2",	 			"text", 			"", 		FALSE, 	"", 	12, 		12],
		["審核問題3",		 	"q3",	 			"text", 			"", 		FALSE, 	"", 	12, 		12],
	];*/

	public function __construct()
	{
		parent::__construct();
		$this->is_mgr_login();
		$this->load->model('Medical_model');

		$this->data['active'] = 'medical';
		$this->action = base_url() . 'mgr/medical/';
	}

	// ---------------------------------------------------------------------活動列表 start
	public function local()
	{
		$this->data = array_merge($this->data, array(
			'sub_active'              => 'MEDICAL_LOCAL',
			'parent'                  => '',
			// 'parent_link'             => base_url() . 'mgr/event/main',
			'custom_del_url'          => base_url() . 'mgr/medical/local_del',
			'title'                   => '政策列表',
			'action'                  => $this->action,
			'th_title'                => $this->local_th_title,
			'th_width'                => $this->local_th_width,
			'can_order_fields'        => $this->local_can_order_fields,
			'default_order_column'    => 0,
			'default_order_direction' => 'ASC',
			'tool_btns'               => [
				// ['新增抽獎活動', base_url() . 'mgr/event/list_add', 'btn-primary'],
			],
		));

		$this->load->view('mgr/template_list', $this->data);
	}

	public function data()
	{
		$page        = ($this->input->post("page")) ? $this->input->post("page") : 1;
		$search      = ($this->input->post("search")) ? $this->input->post("search") : "";
		$order       = ($this->input->post("order")) ? $this->input->post("order") : 0;
		$direction   = ($this->input->post("direction")) ? $this->input->post("direction") : "ASC";

		$order_column = $this->local_order_column;
		$canbe_search_field = ["id", "title", "rule", "start_datetime", "end_datetime", "create_date"];

		$syntax = "is_delete=0 AND type='local'";
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

		$data = $this->Medical_model->get_local_list($syntax, $order_by, $page, $this->page_count);
		$html = "";
		foreach ($data['list'] as $item) {
			$html .= $this->load->view("mgr/items/medical_local_item", array(
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

	public function local_edit($id)
	{
		$medical = $this->Medical_model->get_data($id);
		require('C:/xampp/htdocs/wundoo/vendors/autoload.php');
		if ($_POST) {
			$data = $this->process_post_data($this->param);
			//TODO: 新欄位還沒串
			$banner = explode(';', $this->input->post('banner'));
			array_pop($banner);
			$banner_del = explode(',', $this->input->post('picdeleted_banner'));
			array_pop($banner_del);

			$banner_data = array();
			foreach ($banner as $item) {
				array_push($banner_data, array(
					'type'        => 'medical_banner',
					'relation_id' => $id,
					'name'        => $item,
					'normal_url'  => $item,
					'thumb_url'   => str_replace('.', '_s.', $item),
				));
			}

			$banner_del_syntax = '';
			$index = 0;
			foreach ($banner_del as $item) {
				$banner_del_syntax .= ($index > 0) ? ' OR ' : '';
				$banner_del_syntax .= "`name`='$item'";
				$index++;
			}
			// !d($this->input->post());
			// !d(!$banner_data);
			// !d(!$banner_del_syntax);
			// exit;
			if ($this->Medical_model->edit($id, $data)) {
				if ($banner_data)
					$this->Medical_model->add_banner($banner_data);
				if ($banner_del_syntax)
					$this->Medical_model->del_banner($banner_del_syntax);
				$this->js_output_and_redirect("編輯成功", base_url() . "mgr/medical/$medical[type]/");
			} else {
				$this->js_output_and_back("發生錯誤");
			}
		} else {
			$this->data['pics'] = $this->Medical_model->get_banner($id);
			$this->data['type'] = 'edit';
			$this->data['param'] = $this->set_data_to_param($this->param, $medical);
			$this->data['title'] = '編輯公告【' . $medical['name'] . '】';
			$this->data['sub_active'] = 'MEDICAL_LOCAL' ;

			$this->data['parent'] = '公告列表';
			$this->data['parent_link'] = base_url() . "mgr/medical/local";

			$this->data['action'] = base_url() . "mgr/medical/local_edit/" . $id;
			$this->data['submit_txt'] = "確認編輯";

			//$this->data['select']['category'] = $this->Medical_model->get_hobby_Medical_classify();
			//$this->data['classify'] = json_encode($this->data['select']['category']);
			$this->data['select']['is_private'] = array(['id' => 1, 'title' => '公開'], ['id' => 0, 'title' => '不公開']);
			// TODO: 新欄位還沒串
			// !d($this->data);
			// exit;
			$this->load->view("mgr/medical_form", $this->data);
		}
	}

	public function local_del()
	{
		$id = $this->input->post('id');
		if (!is_numeric($id)) $this->output(FALSE, '發生錯誤');
		if ($this->Medical_model->edit($id, array('is_delete' => 1))) {
			$this->output(TRUE, 'success');
		} else {
			$this->output(FALSE, 'fail');
		}
	}
	// ----------------------------------------------------------------活動列表 end

	// ----------------------------------------------------------------文章列表 start
	public function post_list($Medical_id)
	{
		$Medical = $this->Medical_model->get_data($Medical_id);
		$this->data = array_merge($this->data, array(
			'sub_active'              => 'MADICAL_LOCAL',
			'parent'                  => '文章列表' ,
			'parent_link'             =>  base_url() . 'mgr/medical/local' ,
			'custom_data_url'          => base_url() . 'mgr/medical/post_data/' . $Medical_id,
			'title'                   => '【' . $Medical['name'] . '】的文章列表',
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

	public function post_data($Medical_id)
	{
		$page        = ($this->input->post("page"))			? $this->input->post("page")		: 1;
		$search      = ($this->input->post("search"))		? $this->input->post("search")		: '';
		$order       = ($this->input->post("order"))		? $this->input->post("order")		: 0;
		$direction   = ($this->input->post("direction"))	? $this->input->post("direction") 	: 'DESC';
		$status  	 = ($this->input->post("status"))		? $this->input->post("status")		: 'ALL';
		$user_id     = ($this->input->post("user_id"))		? $this->input->post("user_id")		: 0;

		$Medical = $this->Medical_model->get_data($Medical_id);

		$syntax	= "P.is_delete=0 AND post_at='Medical' AND relation_id='$Medical_id'";
		if ($status != 'ALL')
			$syntax .= " AND ( P.`status` = '" . $status . "' )";

		// set SQL : ORDER BY
		$order_by = ' P.`create_date` DESC';
		if ($this->hobby_order_column[$order] != '')
			$order_by = '`' . $this->hobby_order_column[$order] . '` ' . $direction . ', ' . $order_by;

		$lists = $this->Medical_model->get_post_list($syntax, $order_by, intval($page), $page_count = 20);

		// Combine item html
		$html = '';

		if ($search !== '') {
			$lists['data'] = &$this->set_search_lists($search, $lists['data'], $this->post_canbe_search_field);
		}

		foreach ($lists['list'] as $item) {
			$html .= $this->load->view("mgr/items/medical_post_item", array(
				'item' => $item,
				'Medical' => $Medical,
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
			'sub_active'              => 'medical_HOBBY',
			'parent'                  => '',
			// 'parent_link'             => base_url() . 'mgr/event/main',
			'custom_data_url'          => base_url() . 'mgr/medical/hobby_data',
			'custom_del_url'          => base_url() . 'mgr/medical/hobby_del',
			'title'                   => '同好獵場列表',
			'action'                  => $this->action,
			'th_title'                => $this->hobby_th_title,
			'th_width'                => $this->hobby_th_width,
			'can_order_fields'        => $this->hobby_can_order_fields,
			'default_order_column'    => 0,
			'default_order_direction' => 'ASC',
			'tool_btns'               => [
				['新增同好獵場', base_url() . 'mgr/medical/hobby_add', 'btn-primary'],
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

		$data = $this->Medical_model->get_local_list($syntax, $order_by, $page, $this->page_count);
		$html = "";
		foreach ($data['list'] as $item) {
			$html .= $this->load->view("mgr/items/Medical_local_item", array(
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
			if ($this->Medical_model->edit($id, $data)) {
				$this->js_output_and_redirect("編輯成功", base_url() . "mgr/medical/local/");
			} else {
				$this->js_output_and_back("發生錯誤");
			}
		} else {
			$this->data['title'] = '新增獵場';
			$this->data['sub_active'] = 'medical_HOBBY';

			$this->data['parent'] = '同好獵場列表';
			$this->data['parent_link'] = base_url() . "mgr/medical/hobby";

			$this->data['action'] = base_url() . "mgr/medical/hobby_add";
			$this->data['submit_txt'] = "新增";
			$this->data['param'] = $this->hobby_param;
			$this->data['select']['category'] = $this->Medical_model->get_hobby_Medical_classify();
			$this->data['classify'] = json_encode($this->data['select']['category']);
			$this->data['select']['is_private'] = array(['id' => 1, 'title' => '公開'], ['id' => 0, 'title' => '不公開']);

			$this->load->view("mgr/Medical_form", $this->data);
		}
	}

	// ----------------------------------------------------------------同好獵場 end
}
