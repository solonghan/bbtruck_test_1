<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Priv extends Base_Controller {
	private $th_title = ["#", "群組名稱", "建立日期", "動作"]; //, "置頂"
	private $th_width = ["44px", "", "", "95px", "80px"];
	private $order_column = ["id", "", "","create_date", ""];
	private $can_order_fields = [0, 3];

	private $param;
	private $action;

	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();
		$this->data['active'] = "priv";
		$this->data['sub_active'] = 'priv';

		$this->load->model("Priv_model");
		
		$this->action = base_url()."mgr/priv/";
		$this->param = [
				["姓名",		 		"name", 			"text", 					"", 		TRUE, 	""],
				["權限",		 		"privilege",		"select", 					"", 		TRUE, 	"", ["id", "text"]],
				["大頭照",	 		"avatar", 			"img",	 					"", 		FALSE, 	"", 1/1],
                ["帳號email",		"email",	 		"text", 					"", 		TRUE, 	""],
                ["密碼",				"password",			"password",					"", 		TRUE, 	""],
                ["再次輸入密碼",		"password_confirm",	"password",					"", 		TRUE, 	""],
                ["聯絡電話",			"phone",			"text",						"", 		FALSE, 	""],
            ];
	}

	public function index(){
		$this->data['title'] = '帳號管理';

		$this->data['action'] = $this->action;
		$this->data['parent'] = '帳號權限管理';
		$this->data['parent_link'] = base_url()."mgr/member/";
		$this->data['th_title'] = $this->th_title;
		$this->data['th_width'] = $this->th_width;
		$this->data['can_order_fields'] = $this->can_order_fields;
		$this->data['tool_btns'] = [
			['新增權限', base_url()."mgr/priv/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 0;
		$this->data['default_order_direction'] = 'DESC';

		$this->load->view('mgr/template_list', $this->data);
	}

	public function add(){
		
		if ($_POST) {
			$data = $this->process_post_data($this->param);
			
			if ($data['password_confirm'] != $data['password']) {
				$this->js_output_and_back("兩次輸入的密碼不相同");
			}
			unset($data['password_confirm']);

			if ($this->Priv_model->add($data) !== FALSE) {
				$this->js_output_and_redirect("新增成功", base_url()."mgr/priv");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			$this->data['title'] = '新增權限';
			$this->data['sub_active'] = 'priv/add';
			// $this->data['sub_title'] = '新增';

			$this->data['parent'] = '權限管理';
			$this->data['parent_link'] = base_url()."mgr/priv";

			$this->data['action'] = base_url()."mgr/priv/add";
			$this->data['submit_txt'] = "新增";
			$this->data['sub_active'] = "priv/add";

			//column
			// $this->data['select']['privilege'] = $this->privilege_columns;

			$this->data['param'] = $this->param;
			// $this->load->view("mgr/template_form", $this->data);
			$this->load->view("mgr/priv_detail_temp", $this->data);
		}
	}

	public function edit_temp(){
		

			$this->data['title'] = '編輯權限';
			$this->data['sub_active'] = 'priv/add';
			

			$this->data['parent'] = '權限管理';
			$this->data['parent_link'] = base_url()."mgr/priv";

			$this->data['action'] = base_url()."mgr/priv/add";
			$this->data['submit_txt'] = "新增";
			$this->data['sub_active'] = "priv/add";

			//column
			// $this->data['select']['privilege'] = $this->privilege_columns;

			$this->data['param'] = $this->param;
			// $this->load->view("mgr/template_form", $this->data);
			$this->load->view("mgr/priv_detail_temp", $this->data);
		
	}	

	public function switch_toggle(){
		$id     = $this->input->post("id");
		$status = $this->input->post("status");

		if ($this->Priv_model->edit($id, array("status"=>$status))) {
			$this->output(TRUE, "success");
		}else{
			$this->output(FALSE, "fail");
		}
	}

	public function del(){
		$id = $this->input->post("id");
		if (!is_numeric($id)) show_404();

		if ($this->Priv_model->edit($id, array("is_delete"=>1))) {
			$this->output(TRUE, "success");
		}else{
			$this->output(FALSE, "fail");
		}
	}

	public function edit(){//$id){
		// if (!is_numeric($id)) show_404();

		if ($_POST) {
			$data = $this->process_post_data($this->param);

			if ($data['password'] != "") {
				if ($data['password_confirm'] != $data['password']) {
					$this->js_output_and_back("兩次輸入的密碼不相同");
				}	
			}else{
				unset($data['password']);
			}
			unset($data['password_confirm']);	
			

			if ($this->Priv_model->edit($id, $data)) {
				$this->js_output_and_redirect("編輯成功", base_url()."mgr/priv");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			// $data = $this->Priv_model->get_data($id);
			$this->data['title'] = '編輯權限 【最高權限】';//.$data['name'];
			$this->data['sub_active'] = 'priv';
			$this->data['action'] = $this->action;

			$this->data['th_title'] = $this->th_title;
			$this->data['th_width'] = $this->th_width;
			$this->data['can_order_fields'] = [];
			$this->data['tool_btns'] = [
				['儲存變更', base_url()."mgr/priv/add", "btn-primary"]
			];
			$this->data['default_order_column'] = 0;
			$this->data['default_order_direction'] = 'DESC';
			$this->data['parent'] = '權限管理';
			$this->data['parent_link'] = base_url()."mgr/priv";

			$this->data['action'] = base_url()."mgr/priv/edit/";//.$data['id'];
			$this->data['submit_txt'] = "確認編輯";

			//column
			// $this->data['select']['privilege'] = $this->privilege_columns;
			
			//get exist data to param
			// $this->data['param'] = $this->set_data_to_param($this->param, $data);

			$this->load->view("mgr/priv_detail", $this->data);
		}
	}

	public function data(){
		$html = "";
		for ($i=0; $i < 2; $i++) { 
			$html .= $this->load->view("mgr/items/priv_item", array(
				"item"  =>	array()
			), TRUE);
		}

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	1,
			"total_page" =>	10
		));
		return;

		$page        = ($this->input->post("page"))?$this->input->post("page"):1;
		$search      = ($this->input->post("search"))?$this->input->post("search"):"";
        $order       = ($this->input->post("order"))?$this->input->post("order"):0;
        $direction   = ($this->input->post("direction"))?$this->input->post("direction"):"ASC";

        $order_column = $this->order_column;
		$canbe_search_field = ["name", "days"];

		$syntax = "is_delete = 0 AND (privilege = 'mgr' OR privilege = 'saler')";
		if ($search != "") {
			$syntax .= " AND (";
			$index = 0;
			foreach ($canbe_search_field as $field) {
				if ($index > 0) $syntax .= " OR ";
				$syntax .= $field." LIKE '%".$search."%'";
				$index++;
			}
			$syntax .= ")";
		}
		
		$order_by = "create_date DESC";
        if ($order_column[$order] != "") {
            $order_by = $order_column[$order]." ".$direction.", ".$order_by;
        }

		$data = $this->Priv_model->get_list($syntax, $order_by, TRUE, $page, $this->page_count);

		$html = "";
		foreach ($data['list'] as $item) {
			$html .= $this->load->view("mgr/items/priv_item", array(
				"item"  =>	$item
			), TRUE);
		}
		if($search!="") $html = preg_replace('/'.$search.'/i', '<mark data-markjs="true">'.$search.'</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	$page,
			"total_page" =>	$data['total_page']
		));
	}

	
}
