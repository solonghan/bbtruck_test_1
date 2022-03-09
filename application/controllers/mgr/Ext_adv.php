<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ext_adv extends Base_Controller {
	private $th_title =  ["展覽代碼", "會議主題", "報名時間", "審核時間", "會議時間", "網站開放時間", "網址", "承辦人資訊", "詳細資訊"]; //, "置頂"
	private $th_width = [ "100px", "200px", "", "", "", "", "","95px", "80px"];
	private $order_column = [ "", "", "", "", "", "", "","", ""]; //, "is_head"
	private $can_order_fields = [];

	private $param = [
		//																									md 		sm
				["廣告設定",			"",						"header", 			"",			TRUE, 	"", 	12, 	12],
				["廣告類型",		 	"adv_type", 			"select", 			"", 		TRUE, 	"", 	4, 		12],
				["廣告方案",		 	"adv_type", 			"select", 			"", 		TRUE, 	"", 	4, 		12],
				["選擇專案",		 	"adv_type", 			"select", 			"", 		TRUE, 	"", 	4, 		12],
				["選擇版位",		 	"adv_type", 			"select", 			"", 		TRUE, 	"", 	4, 		12],

				["商家基本資訊",		"",						"header", 			"",			TRUE, 	"若有商家資訊，key完統編會自動代入", 	12, 	12],
				["統一編號", 		"company", 				"text", 			"", 		TRUE, 	"", 	3, 		12],
				["商家名稱", 		"company", 				"text", 			"", 		TRUE, 	"", 	3, 		12],
				["負責人姓名", 		"company", 				"text", 			"", 		TRUE, 	"", 	3, 		12],
				["品牌名稱", 		"company", 				"text", 			"", 		TRUE, 	"", 	3, 		12],
				["聯絡人姓名", 		"company", 				"text", 			"", 		TRUE, 	"", 	3, 		12],
				["聯絡人電話", 		"company", 				"text", 			"", 		TRUE, 	"", 	3, 		12],
				["聯絡人Line ID", 	"company", 				"text", 			"", 		TRUE, 	"", 	3, 		12],
				["聯絡人電子信箱", 	"company", 				"text", 			"", 		TRUE, 	"", 	3, 		12],
				["公司地址-城市", 	"company", 				"select", 			"", 		TRUE, 	"", 	3, 		12],
				["公司地址-鄉鎮市區", "company", 				"select", 			"", 		TRUE, 	"", 	3, 		12],
				["公司地址", 		"company", 				"text", 			"", 		TRUE, 	"", 	6, 		12],
				["公司屬性", 		"company_type", 		"select", 			"", 		TRUE, 	"", 	2, 		12],
				["公司屬性備註", 		"company_type_else", 	"text", 			"", 		TRUE, 	"", 	3, 		12],
				["產品類別", 		"product_classify", 	"select", 			"", 		TRUE, 	"", 	2, 		12],
				["官方網站或粉絲頁", 	"company", 				"text", 			"", 		TRUE, 	"", 	5, 		12],
				["公司簡介", 		"company", 				"textarea_plain", 	"", 		TRUE, 	"", 	12, 	12],

				["廣告產品資訊",		"",						"header", 			"",			TRUE, 	"", 	12, 	12],

                ["廣告起迄日期-起", 	"tax_id", 				"day",		 		"", 		TRUE, 	"", 	4,	 	12],
                ["廣告起迄日期-迄", 	"tax_id", 				"day",		 		"", 		TRUE, 	"", 	4,	 	12],
				["預計上架次數/檔次", "company", 				"text", 			"", 		TRUE, 	"", 	4, 		12],
                ["商品名稱", 		"tax_id", 				"text",		 		"", 		TRUE, 	"", 	6,	 	12],
                ["商品簡介", 		"tax_id", 				"text",		 		"", 		TRUE, 	"", 	6,	 	12],
                ["產品規格", 		"tax_id", 				"text",		 		"", 		TRUE, 	"", 	3,	 	12],
                ["市售價",	 		"tax_id", 				"number",	 		"", 		TRUE, 	"", 	3,	 	12],
                ["預計商品數量", 		"tax_id", 				"number",			"", 		TRUE, 	"", 	3,	 	12],
                ["本次市售總定價", 	"tax_id", 				"plain",		 	"$0", 		TRUE, 	"", 	3,	 	12],

				["體驗方式",			"experienc_type", 		"checkbox_multi", 	"", 		TRUE, 	"", 	12, 	12],
				["出貨方式",			"product_type", 		"checkbox_multi", 	"", 		TRUE, 	"", 	12, 	12],
				["導流/導購-優惠方案","sales_type", 			"checkbox_multi", 	"", 		TRUE, 	"", 	12, 	12],
				["本次需求目標",		"require_target", 		"select", 			"", 		TRUE, 	"", 	3, 		12],
                ["指定曝光內容或關鍵字","tax_id", 				"text",		 		"", 		TRUE, 	"", 	9,	 	12],
                
                ["業務/代理商資料",	"",						"header", 			"",			TRUE, 	"", 	12, 	12],

				["業務/代理商姓名",	"member",		 		"select", 			"", 		TRUE, 	"", 	6, 		12],
				["業務/代理商電話",	"member",		 		"text", 			"", 		TRUE, 	"", 	6, 		12],
				["業務/代理商優惠減免",	"member",		 		"number", 			"", 		TRUE, 	"", 	6, 		12],

                ["總費用  $0",		"",						"header", 			"",			TRUE, 	"", 	12, 	12],

            ];
    private $product_classify = array("住宿旅遊","速食咖啡","美食飲品","食品百貨","零食點心","美妝沐浴","嬰幼兒與孕婦","寵物","居家清潔","廚房用品","傢俱寢飾","生活百貨","戶外休閒","圖書","家電影音","3C電子","服飾鞋包","配件精品","養身保健","運動休閒","其他");
    private $company_type = array("自產","原廠","代理商","經銷商","進出口商","其他");
    private $experienc_type = [
				['experienc_type', "免費提供", "免費提供", 0],
				['experienc_type', "試用(需回收)", "試用(需回收)", 0],
				['experienc_type', "到店", "到店", 0],
				['experienc_type', "到府服務", "到府服務", 0],
				['experienc_type', "其他", "其他", 0],
			];
    private $product_type = [
    			['product_type', "實體商品", "實體商品", 0],
    			['product_type', "兌換券", "兌換券", 0],
    			['product_type', "兌換碼", "兌換碼", 0],
    			['product_type', "會員禮物櫃", "會員禮物櫃", 0],
    		];
    private $sales_type = [
    			['sales_type', "買1送1", "買1送1", 0],
    			['sales_type', "第2件半價", "第2件半價", 0],
    			['sales_type', "打折/優惠價", "打折/優惠價", 0],
    			['sales_type', "送贈品", "送贈品", 0],
    			['sales_type', "其他", "其他", 0],
    			['sales_type', "暫無", "暫無", 0],
    		];
    private $require_target = array("品牌曝光","增加評價","廣告宣傳","促銷清倉","測試市場","單純銷售","其他");

	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();
		$this->data['active'] = "EXT_ADV";
		$this->data['sub_active'] = 'EXT_ADV';
		$this->load->model("Event_model");
		$this->data['city'] = $this->get_zipcode()['city'];
	}

	public function test_notify(){
		$this->load->model("Line_Notify_model");
		$this->Line_Notify_model->send("測試發送訊息");
	}

	public function index(){
		$this->data['controller'] = "ext_adv";
		$this->data['title'] = '廣告列表';
		$this->data['parent'] = '廣告管理';
		$this->data['parent_link'] = base_url()."mgr/ext_adv/";

		$this->data['action'] = base_url()."mgr/ext_adv/";

		$this->data['th_title'] = $this->th_title;
		$this->data['th_width'] = $this->th_width;
		$this->data['can_order_fields'] = $this->can_order_fields;
		$this->data['tool_btns'] = [
			// ['新增會議', base_url()."mgr/ext_adv/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 0;
		$this->data['default_order_direction'] = 'ASC';

		$this->load->view('mgr/template_list', $this->data);
	}

	public function session($ext_adv = FALSE){
		$this->data['title'] = '會議場次維護';
		$this->data['sub_active'] = 'ext_adv/session';
		$this->data['parent'] = '採洽會議管理';
		$this->data['parent_link'] = base_url()."mgr/ext_adv/";

		$content = array();
		for ($i=0; $i < 5; $i++) { 
			$day = date("Y-m-d", strtotime('+ '.$i.' days', strtotime(date("Y-m-d"))));
			$content[$day] = array("data"=>array(), "status"=>"open");
			for ($j=10; $j <=16 ; $j++) { 
				if ($j >=12 && $j <= 14) {
					$content[$day]['data'][$j.":00"] = array("type"=>"both");
					$content[$day]['data'][$j.":30"] = array("type"=>"both");		
				}else{
					$content[$day]['data'][$j.":00"] = array("type"=>"site");
					$content[$day]['data'][$j.":30"] = array("type"=>"site");	
				}
			}
			if ($i == 4) {
				$content[$day]['status'] = "close";
			}
		}
		$this->data['content'] = $content;
		$this->data['my'] = $this;
		$this->data['ext_adv'] = $this->Event_model->get_all_list();

		$this->load->view("mgr/ext_adv_session", $this->data);
	}

	public function member(){
		$this->data['title'] = '與會人員維護';
		$this->data['sub_active'] = 'ext_adv/member';

		$this->load->view("mgr/schedule_list", $this->data);
	}

	public function time_btn($text, $type, $day, $time){
		echo '&nbsp;<button class="time_btn btn btn-primary '.$type.'" data-day="'.$day.'" data-time="'.$time.'">'.$text.'</button>&nbsp;<a <a href="javascript:void(0)" data-toggle="tooltip" data-html="true" data-original-title="'.date("m/d", strtotime($day))." ".$time.'<br>管理與會人員"><span class="ti-arrow-circle-right" style="color:#AAA;"></span></a>&nbsp;';
	}

	public function date_show($day){
		$w = "日";
        switch (date('w', strtotime($day))) {
            case 0: $w = '日'; break;
            case 1: $w = '一'; break;
            case 2: $w = '二'; break;
            case 3: $w = '三'; break;
            case 4: $w = '四'; break;
            case 5: $w = '五'; break;
            case 6: $w = '六'; break;
        }
        echo date("m/d", strtotime($day)).' ('.$w.')';
	}

	public function create(){
		$this->data['sub_active'] = 'CREATE_EXT_ADV';
		if ($_POST) {
			$data = $this->process_post_data($this->param);
			
			if ($this->Event_model->add($data)) {
				$this->js_output_and_redirect("新增成功", base_url()."mgr/ext_adv");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			$this->data['title'] = '建立廣告訂單';

			$this->data['parent'] = '廣告系統';
			$this->data['parent_link'] = base_url()."mgr/ext_adv";

			$this->data['action'] = base_url()."mgr/ext_adv/create";
			$this->data['submit_txt'] = "建立訂單並預覽合約";

			$this->data['select']['plan'] = array(
				array("id"=>1, "text"=>"$999, 1個月輪播"),
				array("id"=>2, "text"=>"$300, 1周輪播")
			);

			$this->data['select']['product_classify'] = $this->product_classify;
			$this->data['select']['company_type'] = $this->company_type;

			$this->data['checkbox']['experienc_type'] = $this->experienc_type;
			$this->data['checkbox']['product_type'] = $this->product_type;
			$this->data['checkbox']['sales_type'] = $this->sales_type;
			$this->data['select']['require_target'] = $this->require_target;
			




			$this->data['param'] = $this->param;
			$this->load->view("mgr/template_form_complex", $this->data);
		}
	}

	public function switch_toggle(){
		$id     = $this->input->post("id");
		$status = $this->input->post("status");

		if ($this->Event_model->edit($id, array("status"=>$status))) {
			$this->output(TRUE, "success");
		}else{
			$this->output(FALSE, "fail");
		}
	}

	public function del(){
		$id = $this->input->post("id");
		if (!is_numeric($id)) show_404();

		if ($this->Event_model->check_store_exist($id)) $this->output(FALSE, "此展覽下仍有分店資料，請刪除所有店家資料後再刪除此展覽");

		if ($this->Event_model->edit($id, array("is_delete"=>1))) {
			$this->output(TRUE, "success");
		}else{
			$this->output(FALSE, "fail");
		}
	}

	public function edit($id){
		if (!is_numeric($id)) show_404();

		if ($_POST) {
			$data = $this->process_post_data($this->param);

			if ($this->Event_model->edit($id, $data)) {
				$this->js_output_and_redirect("編輯成功", base_url()."mgr/ext_adv");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			

			$data = $this->Event_model->get_data($id);
			$this->data['title'] = '編輯會議 ';

			$this->data['parent'] = '會議管理';
			$this->data['parent_link'] = base_url()."mgr/ext_adv";

			$this->data['action'] = base_url()."mgr/ext_adv/edit/1";
			$this->data['submit_txt'] = "確認編輯";
			
			$this->data['tab'] = [
				["ext_adv", "編輯會議"],
				["buyer", "編輯買主相關設定"],
				["exhibitor", "編輯廠商相關設定"]
			];

			//get exist data to param
			$this->data['param']['ext_adv'] = $this->set_data_to_param($this->param, $data);

			$this->data['param']['buyer'] = [];
			$this->data['param']['exhibitor'] = [];

			$this->data['select']['type'] = array(
				array("id"=>1, "text"=>"現場會議"),
				array("id"=>2, "text"=>"視訊會議"),
				array("id"=>3, "text"=>"現場+視訊會議")
			);

			$this->load->view("mgr/new_ext_adv_form", $this->data);
			
		}
	}

	public function data(){
		$html = "";
		for ($i=0; $i < 5; $i++) { 
			$html .= $this->load->view("mgr/items/ext_adv_item", array(
				"item"  =>	array(
					"avatar"	=>	"",
					"id"	=>	$i,
					"name"	=>	"王大明".($i+1),
					"email"	=>	"test".($i+1)."@test.com",
					"status"	=>	"open",
					"last_action"	=>	"登入系統",
					"last_action_datetime"	=>	date("Y-m-d H:i:s", strtotime('- '.rand(0, 10000)." minutes", strtotime(date("Y-m-d")))),
					"create_date"	=>	date("Y-m-d H:i:s", strtotime('- '.rand(10000, 100000)." minutes", strtotime(date("Y-m-d"))))
				)
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
		$canbe_search_field = ["name", "company", "principal", "email", "phone", "city_str", "dist_str", "address", "code"];

		$syntax = "is_delete = 0";
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

		$data = $this->Event_model->get_list($syntax, $order_by, $page, $this->page_count);

		$html = "";
		foreach ($data['list'] as $item) {
			$html .= $this->load->view("mgr/items/ext_adv_item", array(
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
