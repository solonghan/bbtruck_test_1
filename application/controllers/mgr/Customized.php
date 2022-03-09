<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customized extends Base_Controller
{

    /* for <thead></thead> - Start */
    private $local_th_title         = ['#', '路徑', '圖片', '上傳時間', '動作'];
    private $local_th_width         = ['100px', '1000px', '', '',  '200px'];
    private $local_order_column     = ['id',  '',  '', '', ''];
    private $local_can_order_fields = [0,];

    private $type                   = ['all_collection', 'ready_to_wear', 'customize', 'shop', 'customized'];


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
        //["分類",		 	"type", 			"select", 			"", 		TRUE, 	"", 	4, 		12, ['id', 'title']],
        ["圖片1",             "img1",             "img_multi_without_crop",             "",         FALSE,     "",     12,         12, 2 / 1],
        ["圖片2",             "img2",             "img_multi_without_crop",             "",         FALSE,     "",     12,         12, 2 / 1],
       
        ["引言",             "quote",             "textarea_plain",             "",         FALSE,     "",     12,         12, 2 / 1],
        ["內文",             "content",             "textarea_plain",             "",         FALSE,     "",     12,         12, 2 / 1],
       
        ["四步驟標題",             "online_title",             "text",             "",         FALSE,     "",     12,         12, 2 / 1],
        ["四步驟1",             "online_step1",             "textarea_plain",             "",         FALSE,     "",     12,         12, 2 / 1],
        ["四步驟2",             "online_step2",             "textarea_plain",             "",         FALSE,     "",     12,         12, 2 / 1],
        ["四步驟3",             "online_step3",             "textarea_plain",             "",         FALSE,     "",     12,         12, 2 / 1],
        ["四步驟4",             "online_step4",             "textarea_plain",             "",         FALSE,     "",     12,         12, 2 / 1],
        
        

        ["步驟一圖片",             "step1_img",             "img_multi_without_crop",             "",         FALSE,     "",     12,         12, 2 / 1],
        //["步驟一文字圖片",             "step1_text_img",             "img_multi_without_crop",             "",         FALSE,     "",     12,         12, 2 / 1],
       
        ["步驟一文字標題",             "step1_title",             "text",             "",         FALSE,     "",     12,         12, 2 / 1],
        ["步驟一內文",             "step1_content",             "textarea_plain",             "",         FALSE,     "",     12,         12, 2 / 1],
        
        ["步驟二圖片",             "step2_img",             "img_multi_without_crop",             "",         FALSE,     "",     12,         12, 2 / 1],
        //["步驟二文字圖片",             "step2_text_img",             "img_multi_without_crop",             "",         FALSE,     "",     12,         12, 2 / 1],
       
        ["步驟二文字標題",             "step2_title",             "text",             "",         FALSE,     "",     12,         12, 2 / 1],
        ["步驟二內文",             "step2_content",             "textarea_plain",             "",         FALSE,     "",     12,         12, 2 / 1],
        
        ["步驟三圖片",             "step3_img",             "img_multi_without_crop",             "",         FALSE,     "",     12,         12, 2 / 1],
       // ["步驟三文字圖片",             "step3_text_img",             "img_multi_without_crop",             "",         FALSE,     "",     12,         12, 2 / 1],
       
        ["步驟三文字標題",             "step3_title",             "text",             "",         FALSE,     "",     12,         12, 2 / 1],
        ["步驟三內文",             "step3_content",             "textarea_plain",             "",         FALSE,     "",     12,         12, 2 / 1],
        

      
        ["背景圖",             "background",             "img_multi_without_crop",             "",         FALSE,     "",     12,         12, 1],
         //["獵場類別",		 	"category", 		"select", 			"", 		TRUE, 	"", 	4, 		12, ['id', 'title']],
        //["獵場類別",		 	"classify", 		"select", 			"", 		TRUE, 	"", 	4, 		12, ['id', 'title']],
        //["公告內容",		 	"content", 			"textarea", 			"", 		TRUE, 	"", 	12, 		12],
        //	["公告是否公開",	 	"is_private", 			"select", 			"", 		TRUE, 	"", 	4, 		12, ['id', 'title']],
        /*["審核機制",		 	"header", 			"header", 			"", 		TRUE, 	"", 	12, 		12],
		["審核問題1",		 	"q1",	 			"text", 			"", 		FALSE, 	"", 	12, 		12],
		["審核問題2",		 	"q2",	 			"text", 			"", 		FALSE, 	"", 	12, 		12],
		["審核問題3",		 	"q3",	 			"text", 			"", 		FALSE, 	"", 	12, 		12],*/
    ];

    private $hobby_param = [
        //																							md 		sm
        ["獵場名稱",             "name",             "text",             "",         TRUE,     "",     4,         12],
        ["獵場顯示名稱",        "show_name",             "text",             "",         TRUE,     "",     4,         12],
        ["獵場封面圖",             "banner",             "img_multi_without_crop",             "",         TRUE,     "",     12,         12, 2 / 1],
        ["獵場代表圖",             "content",             "text",             "",         TRUE,     "",     12,         12, 1],
        ["獵場類別",             "category",         "select",             "",         TRUE,     "",     4,         12, ['id', 'title']],
        ["獵場類別",             "classify",         "select",             "",         TRUE,     "",     4,         12, ['id', 'title']],
        ["獵場規則",             "rule",             "textarea",             "",         TRUE,     "",     12,         12],
        ["獵場是否公開",         "is_private",             "select",             "",         TRUE,     "",     4,         12, ['id', 'title']],
        ["審核機制",             "header",             "header",             "",         TRUE,     "",     12,         12],
        ["審核問題1",             "q1",                 "text",             "",         FALSE,     "",     12,         12],
        ["審核問題2",             "q2",                 "text",             "",         FALSE,     "",     12,         12],
        ["審核問題3",             "q3",                 "text",             "",         FALSE,     "",     12,         12],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->is_mgr_login();
        $this->load->model('Customized_model');

        $this->data['active'] = 'CUSTOMIZED';
        $this->action = base_url() . 'mgr/customized/';
    }

    // ---------------------------------------------------------------------活動列表 start
    public function index()
    {
        require('./vendors/autoload.php');
        //require('C:/xampp/htdocs/new_wedding/vendors/autoload.php');
        $customized = $this->Customized_model->get_data(1);
        
        $this->data = array_merge($this->data, array(
            'sub_active'              => 'CUSTOMIZED',
            'parent'                  => '',
            // 'parent_link'             => base_url() . 'mgr/event/main',
            'custom_del_url'          => base_url() . 'mgr/customized/local_del',
            'title'                   => '圖片列表',
            'action'                  => $this->action,
            'th_title'                => $this->local_th_title,
            'th_width'                => $this->local_th_width,
            'can_order_fields'        => $this->local_can_order_fields,
            'default_order_column'    => 0,
            'default_order_direction' => 'ASC',
           
            'tool_btns'               => [

                //['add img', base_url() . 'mgr/customized/add', 'btn-primary'],
            ],
        ));
        
        if ($_POST) {
            $data = $this->process_post_data($this->param);
           
            
            //exit;
            if($data['quote']==''||$data['online_title']==''||$data['online_step1']==''||$data['online_step2']==''||$data['online_step3']==''||$data['online_step4']==''|| $data['step1_title']==''|| $data['step2_title']==''|| $data['step3_title']==''|| $data['step3_title']=='')
                $this->js_output_and_back("內文不得為空");
            if ($this->Customized_model->edit(1, $data)) {

                $this->js_output_and_redirect("編輯成功", base_url() . "mgr/customized/");
            } else {
                $this->js_output_and_back("發生錯誤");
            }
        } else {
            //var_dump($customized);
            //exit;
            //$this->data['pics'] = $this->Customized_model->get_banner($id);
            $this->data['type'] = 'edit';
            $this->data['param'] = $this->set_data_to_param($this->param, $customized);
            $this->data['title'] = '編輯照片';
            $this->data['sub_active'] =  'CUSTOMIZED';

            $this->data['parent'] = '圖片列表';
            $this->data['parent_link'] = base_url() . "mgr/customized/";

            $this->data['action'] = base_url() . "mgr/customized/" ;
            $this->data['submit_txt'] = "確認編輯";


            //$this->data['select']['type'] = array(['id' => 'all_collection', 'title' => 'all_collection'], ['id' => 'ready_to_wear', 'title' => 'ready_to_wear'],['id' => 'customize', 'title' => 'customize'],['id' => 'shop', 'title' => 'shop'], ['id' => 'customized', 'title' => 'customized']);
            // TODO: 新欄位還沒串

        }

        $this->load->view('mgr/template_form', $this->data);
    }

    public function data()
    {

       
        $page        = ($this->input->post("page")) ? $this->input->post("page") : 1;
        $search      = ($this->input->post("search")) ? $this->input->post("search") : "";
        $order       = ($this->input->post("order")) ? $this->input->post("order") : 0;
        $direction   = ($this->input->post("direction")) ? $this->input->post("direction") : "ASC";

        $order_column = $this->local_order_column;
        $canbe_search_field = ["id", "title", "create_date"];

        $syntax = "is_delete= 0  ";
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

        $data = $this->Home_model->get_local_list($syntax, $order_by, $page, $this->page_count);
        $html = "";
        foreach ($data['list'] as $item) {
            $html .= $this->load->view("mgr/items/customized_local_item", array(
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


    public function add()
    {
        require('./vendors/autoload.php');
        //require('C:/xampp/htdocs/new_wedding/vendors/autoload.php');
        if ($_POST) {
            $data = $this->process_post_data($this->param);




            if ($this->Home_model->add($data) !== FALSE) {


                $this->js_output_and_redirect("編輯成功", base_url() . "mgr/customized/index/");
            } else {
                $this->js_output_and_back("發生錯誤");
            }
        } else {
            //$this->data['pics'] = $this->Bulletin_model->get_banner($id);



            $this->data['param'] = $this->param;
            $this->data['title'] = '新增圖片';
            $this->data['sub_active'] =  'CUSTOMIZED';

            $this->data['parent'] = '圖片列表';
            $this->data['parent_link'] = base_url() . "mgr/customized/index/";

            $this->data['action'] = base_url() . "mgr/customized/add/";
            $this->data['submit_txt'] = "新增";

            //$this->data['select']['type'] = array(['id' => 'all_collection', 'title' => 'all_collection'], ['id' => 'ready_to_wear', 'title' => 'ready_to_wear'],['id' => 'customize', 'title' => 'customize'],['id' => 'shop', 'title' => 'shop'], ['id' => 'customized', 'title' => 'customized']);
            // TODO: 新欄位還沒串


            $this->load->view("mgr/customized_form", $this->data);
        }
    }

    public function edit($id)
    {

        require('./vendors/autoload.php');
        //require('C:/xampp/htdocs/new_wedding/vendors/autoload.php');
        $customized = $this->Home_model->get_data($id);
        //var_dump($customized);
        //exit;
        if ($_POST) {
            $data = $this->process_post_data($this->param);

            if ($this->Home_model->edit($id, $data)) {

                $this->js_output_and_redirect("編輯成功", base_url() . "mgr/customized/");
            } else {
                $this->js_output_and_back("發生錯誤");
            }
        } else {
            //$this->data['pics'] = $this->Customized_model->get_banner($id);
            $this->data['type'] = 'edit';
            $this->data['param'] = $this->set_data_to_param($this->param, $customized);
            $this->data['title'] = '編輯照片';
            $this->data['sub_active'] =  'CUSTOMIZED';

            $this->data['parent'] = '圖片列表';
            $this->data['parent_link'] = base_url() . "mgr/customized/";

            $this->data['action'] = base_url() . "mgr/customized/edit/" . $id;
            $this->data['submit_txt'] = "確認編輯";
            //$this->data['select']['type'] = array(['id' => 'all_collection', 'title' => 'all_collection'], ['id' => 'ready_to_wear', 'title' => 'ready_to_wear'],['id' => 'customize', 'title' => 'customize'],['id' => 'customized', 'title' => 'customized']);
            // TODO: 新欄位還沒串
            //$this->data['select']['category'] = $this->Customized_model->get_hobby_customized_classify();
            //$this->data['classify'] = json_encode($this->data['select']['category']);
            //$this->data['select']['is_private'] = array(['id' => 1, 'title' => '公開'], ['id' => 0, 'title' => '不公開']);
            // TODO: 新欄位還沒串
            // !d($this->data);
            // exit;

            //var_dump($this->data);
            //exit;
            $this->load->view("mgr/customized_form", $this->data);
        }
    }

    public function local_del($id)
    {
        //$id = $this->input->post('id');

        // var_dump($id);
        if (!is_numeric($id)) $this->output(FALSE, '發生錯誤');
        if ($this->Customized_model->edit($id, array('is_delete' => 1))) {
            //$this->output(TRUE, 'success');
            $this->js_output_and_redirect("刪除成功", base_url() . "mgr/customized/");
        } else {
            $this->output(FALSE, 'fail');
        }
    }
    // ----------------------------------------------------------------活動列表 end

    // ----------------------------------------------------------------文章列表 start
    public function post_list($customized_id)
    {
        $customized = $this->customized_model->get_data($customized_id);
        $this->data = array_merge($this->data, array(
            'sub_active'              => 'CUSTOMIZED_MGR_LOCAL',
            'parent'                  => ($customized['type'] == 'local') ? '在地獵場列表' : '同好獵場',
            'parent_link'             => ($customized['type'] == 'local') ? base_url() . 'mgr/huntground/local' : base_url() . 'mgr/huntground/hobby',
            'custom_data_url'          => base_url() . 'mgr/customized/post_data/' . $customized_id,
            'title'                   => '【' . $customized['name'] . '】的文章列表',
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

        $this->load->view('mgr/home_template_list', $this->data);
    }

    public function post_data($customized_id)
    {
        $page        = ($this->input->post("page"))            ? $this->input->post("page")        : 1;
        $search      = ($this->input->post("search"))        ? $this->input->post("search")        : '';
        $order       = ($this->input->post("order"))        ? $this->input->post("order")        : 0;
        $direction   = ($this->input->post("direction"))    ? $this->input->post("direction")     : 'DESC';
        $status       = ($this->input->post("status"))        ? $this->input->post("status")        : 'ALL';
        $user_id     = ($this->input->post("user_id"))        ? $this->input->post("user_id")        : 0;

        $customized = $this->customized_model->get_data($customized_id);

        $syntax    = "P.is_delete=0 AND post_at='customized' AND relation_id='$customized_id'";
        if ($status != 'ALL')
            $syntax .= " AND ( P.`status` = '" . $status . "' )";

        // set SQL : ORDER BY
        $order_by = ' P.`create_date` DESC';
        if ($this->hobby_order_column[$order] != '')
            $order_by = '`' . $this->hobby_order_column[$order] . '` ' . $direction . ', ' . $order_by;

        $lists = $this->customized_model->get_post_list($syntax, $order_by, intval($page), $page_count = 20);

        // Combine item html
        $html = '';

        if ($search !== '') {
            $lists['data'] = &$this->set_search_lists($search, $lists['data'], $this->post_canbe_search_field);
        }

        foreach ($lists['list'] as $item) {
            $html .= $this->load->view("mgr/items/huntground_post_item", array(
                'item' => $item,
                'customized' => $customized,
            ), TRUE);
        }

        $this->output(TRUE, '資料取得成功', array(
            'html'             => $html,
            'page'             => $page,
            'total_page'     => $lists['total_page'],
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

        $data = $this->customized_model->get_local_list($syntax, $order_by, $page, $this->page_count);
        $html = "";
        foreach ($data['list'] as $item) {
            $html .= $this->load->view("mgr/items/customized_local_item", array(
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
            if ($this->customized_model->edit($id, $data)) {
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
            $this->data['select']['category'] = $this->customized_model->get_hobby_customized_classify();
            $this->data['classify'] = json_encode($this->data['select']['category']);
            $this->data['select']['is_private'] = array(['id' => 1, 'title' => '公開'], ['id' => 0, 'title' => '不公開']);

            $this->load->view("mgr/customized_form", $this->data);
        }
    }

    // ----------------------------------------------------------------同好獵場 end
}
