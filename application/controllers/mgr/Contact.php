<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contact extends Base_Controller
{

    /* for <thead></thead> - Start */
    private $local_th_title         = ['#', 'Name', 'Phone', 'Email', 'Wedding Date','Appointment Date','Subject','Message','Create Date','Option'];
    private $local_th_width         = ['100px', '', '', '',  '200px','','','','',''];
    private $local_order_column     = ['id',  '',  '', '', ''];
    private $local_can_order_fields = [0,];

    private $type                   = ['all_collection', 'ready_to_wear', 'customize', 'shop', 'contact'];


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
        //["獵場顯示名稱",		"show_name", 			"text", 			"", 		TRUE, 	"", 	4, 		12],
         ["Banner",             "banner",             "img",             "",         TRUE,     "",     3,         12],
        // ["Email",             "email",             "text",             "",         TRUE,     "",     4,         12],
       
        // ["Banner",             "banner",             "img",             "",         FALSE,     "",     12,         12, 2 / 1],
      
        // ["Phone",             "phone",             "text",             "",         TRUE,     "",     4,         12],
        // ["Subject",            "subject",             "text",             "",         FALSE,     "",     12,         12, 2 / 1],
        // ["Wedding Date",      "wedding_date",             "day",             "",         TRUE,     "",     4,         12],

        // ["Appointment Date",  "appointment_date",             "day",             "",         TRUE,     "",     12,         12, 2 / 1],
        // ["Message",             "massage",             "text",             "",         FALSE,     "",     4,         12],
 //       ["文字3",             "content3",             "text",             "",         TRUE,     "",     4,         12,],

        //["背景圖",             "cover",             "img_multi_without_crop",             "",         FALSE,     "",     12,         12, 1],
        //["獵場類別",		 	"category", 		"select", 			"", 		TRUE, 	"", 	4, 		12, ['id', 'title']],
        //["獵場類別",		 	"classify", 		"select", 			"", 		TRUE, 	"", 	4, 		12, ['id', 'title']],
        //["公告內容",		 	"content", 			"textarea", 			"", 		TRUE, 	"", 	12, 		12],
        //	["公告是否公開",	 	"is_private", 			"select", 			"", 		TRUE, 	"", 	4, 		12, ['id', 'title']],
        ["Content",		 	"content", 			"textarea_plain", 			"", 		TRUE, 	"", 	12, 		12],
		/*["審核問題1",		 	"q1",	 			"text", 			"", 		FALSE, 	"", 	12, 		12],
		["審核問題2",		 	"q2",	 			"text", 			"", 		FALSE, 	"", 	12, 		12],
		["審核問題3",		 	"q3",	 			"text", 			"", 		FALSE, 	"", 	12, 		12],*/
    ];

    private $form_param = [
        //																							md 		sm
        ["Name",                "name",             "text",             "",         TRUE,     "",     4,         12],
        ["Phone",               "phone",             "text",             "",         TRUE,     "",     4,         12],
       // ["獵場封面圖",             "banner",             "img_multi_without_crop",             "",         TRUE,     "",     12,         12, 2 / 1],
        // ["獵場代表圖",             "content",             "text",             "",         TRUE,     "",     12,         12, 1],
        // ["獵場類別",             "category",         "select",             "",         TRUE,     "",     4,         12, ['id', 'title']],
        ["Email ",             "email",         "text",             "",         TRUE,     "",     4,         12, ['id', 'title']],
        ["Wedding Date",       "wedding_date",             "datetime",             "",         TRUE,     "",     12,         12],
        ["Appointment Date",   "appointment_date",             "datetime",             "",         TRUE,     "",     4,         12, ['id', 'title']],
        ["Subject",             "subject",             "text",             "",         TRUE,     "",     12,         12],
        ["Message",             "message",                 "textarea_plain",             "",         FALSE,     "",     12,         12],
        // ["審核問題2",             "q2",                 "text",             "",         FALSE,     "",     12,         12],
        // ["審核問題3",             "q3",                 "text",             "",         FALSE,     "",     12,         12],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->is_mgr_login();
        $this->load->model('Contact_model');

        $this->data['active'] = 'CONTACT';
        $this->action = base_url() . 'mgr/contact/';
    }

    // ---------------------------------------------------------------------活動列表 start
    public function index()
    {
        require('./vendors/autoload.php');
        //require('C:/xampp/htdocs/new_wedding/vendors/autoload.php');
        // $contact = $this->Contact_model->get_data(1);
        
        $this->data = array_merge($this->data, array(
            'sub_active'              => 'CONTACT',
            'parent'                  => '',
            // 'parent_link'             => base_url() . 'mgr/event/main',
            'custom_del_url'          => base_url() . 'mgr/contact/local_del',
            'title'                   => '圖片列表',
            'action'                  => $this->action,
            'th_title'                => $this->local_th_title,
            'th_width'                => $this->local_th_width,
            'can_order_fields'        => $this->local_can_order_fields,
            'default_order_column'    => 0,
            'default_order_direction' => 'ASC',
           
            'tool_btns'               => [

                //['add img', base_url() . 'mgr/contact/add', 'btn-primary'],
            ],
        ));
        
        

        $this->load->view('mgr/template_list', $this->data);
    }

    public function data()
    {

       
        $page        = ($this->input->post("page")) ? $this->input->post("page") : 1;
        $search      = ($this->input->post("search")) ? $this->input->post("search") : "";
        $order       = ($this->input->post("order")) ? $this->input->post("order") : 0;
        $direction   = ($this->input->post("direction")) ? $this->input->post("direction") : "DESC";
        $direction   ="DESC";
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

        $order_by = "id DESC";
        if ($order_column[$order] != "") {
            $order_by = $order_column[$order] . " " . $direction . ", " . $order_by;
        }

        $data = $this->Contact_model->get_local_list($syntax, $order_by, $page, $this->page_count);
        $html = "";
        foreach ($data['list'] as $item) {
            $html .= $this->load->view("mgr/items/contact_local_item", array(
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




            if ($this->Contact_model->add($data) !== FALSE) {


                $this->js_output_and_redirect("編輯成功", base_url() . "mgr/contact/index/");
            } else {
                $this->js_output_and_back("發生錯誤");
            }
        } else {
            //$this->data['pics'] = $this->Bulletin_model->get_banner($id);



            $this->data['param'] = $this->param;
            $this->data['title'] = '新增圖片';
            $this->data['sub_active'] =  'CONTACT';

            $this->data['parent'] = '圖片列表';
            $this->data['parent_link'] = base_url() . "mgr/contact/index/";

            $this->data['action'] = base_url() . "mgr/contact/add/";
            $this->data['submit_txt'] = "新增";

            //$this->data['select']['type'] = array(['id' => 'all_collection', 'title' => 'all_collection'], ['id' => 'ready_to_wear', 'title' => 'ready_to_wear'],['id' => 'customize', 'title' => 'customize'],['id' => 'shop', 'title' => 'shop'], ['id' => 'contact', 'title' => 'contact']);
            // TODO: 新欄位還沒串


            $this->load->view("mgr/template_form", $this->data);
        }
    }

    public function edit($id)
    {

        require('./vendors/autoload.php');
        //require('C:/xampp/htdocs/new_wedding/vendors/autoload.php');
        $contact = $this->Contact_model->get_data($id);
        //var_dump($contact);
        //exit;
        if ($_POST) {
            $data = $this->process_post_data($this->form_param);

            if ($this->Contact_model->edit($id, $data)) {

                $this->js_output_and_redirect("編輯成功", base_url() . "mgr/contact/");
            } else {
                $this->js_output_and_back("發生錯誤");
            }
        } else {
            //$this->data['pics'] = $this->Our_service_model->get_banner($id);
            $this->data['type'] = 'edit';
            $this->data['param'] = $this->set_data_to_param($this->form_param, $contact);
            $this->data['title'] = '編輯照片';
            $this->data['sub_active'] =  'CONTACT';

            $this->data['parent'] = '圖片列表';
            $this->data['parent_link'] = base_url() . "mgr/contact/";

            $this->data['action'] = base_url() . "mgr/contact/edit/" . $id;
            $this->data['submit_txt'] = "確認編輯";
            //$this->data['select']['type'] = array(['id' => 'all_collection', 'title' => 'all_collection'], ['id' => 'ready_to_wear', 'title' => 'ready_to_wear'],['id' => 'customize', 'title' => 'customize'],['id' => 'contact', 'title' => 'contact']);
            // TODO: 新欄位還沒串
            //$this->data['select']['category'] = $this->Our_service_model->get_hobby_contact_classify();
            //$this->data['classify'] = json_encode($this->data['select']['category']);
            //$this->data['select']['is_private'] = array(['id' => 1, 'title' => '公開'], ['id' => 0, 'title' => '不公開']);
            // TODO: 新欄位還沒串
            // !d($this->data);
            // exit;

            //var_dump($this->data);
            //exit;
            $this->load->view("mgr/template_form", $this->data);
        }
    }

    public function local_del($id)
    {
        //$id = $this->input->post('id');

        // var_dump($id);
        if (!is_numeric($id)) $this->output(FALSE, '發生錯誤');
        if ($this->Contact_model->edit($id, array('is_delete' => 1))) {
            //$this->output(TRUE, 'success');
            $this->js_output_and_redirect("刪除成功", base_url() . "mgr/contact/");
        } else {
            $this->output(FALSE, 'fail');
        }
    }
    // ----------------------------------------------------------------活動列表 end

    // ----------------------------------------------------------------文章列表 start
    public function post_list($contact_id)
    {
        $contact = $this->contact_model->get_data($contact_id);
        $this->data = array_merge($this->data, array(
            'sub_active'              => 'CONTACT_MGR_LOCAL',
            'parent'                  => ($contact['type'] == 'local') ? '在地獵場列表' : '同好獵場',
            'parent_link'             => ($contact['type'] == 'local') ? base_url() . 'mgr/huntground/local' : base_url() . 'mgr/huntground/hobby',
            'custom_data_url'          => base_url() . 'mgr/contact/post_data/' . $contact_id,
            'title'                   => '【' . $contact['name'] . '】的文章列表',
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

    public function post_data($contact_id)
    {
        $page        = ($this->input->post("page"))            ? $this->input->post("page")        : 1;
        $search      = ($this->input->post("search"))        ? $this->input->post("search")        : '';
        $order       = ($this->input->post("order"))        ? $this->input->post("order")        : 0;
        $direction   = ($this->input->post("direction"))    ? $this->input->post("direction")     : 'DESC';
        $status       = ($this->input->post("status"))        ? $this->input->post("status")        : 'ALL';
        $user_id     = ($this->input->post("user_id"))        ? $this->input->post("user_id")        : 0;

        $contact = $this->contact_model->get_data($contact_id);

        $syntax    = "P.is_delete=0 AND post_at='contact' AND relation_id='$contact_id'";
        if ($status != 'ALL')
            $syntax .= " AND ( P.`status` = '" . $status . "' )";

        // set SQL : ORDER BY
        $order_by = ' P.`create_date` DESC';
        if ($this->hobby_order_column[$order] != '')
            $order_by = '`' . $this->hobby_order_column[$order] . '` ' . $direction . ', ' . $order_by;

        $lists = $this->contact_model->get_post_list($syntax, $order_by, intval($page), $page_count = 20);

        // Combine item html
        $html = '';

        if ($search !== '') {
            $lists['data'] = &$this->set_search_lists($search, $lists['data'], $this->post_canbe_search_field);
        }

        foreach ($lists['list'] as $item) {
            $html .= $this->load->view("mgr/items/huntground_post_item", array(
                'item' => $item,
                'contact' => $contact,
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

        $data = $this->contact_model->get_local_list($syntax, $order_by, $page, $this->page_count);
        $html = "";
        foreach ($data['list'] as $item) {
            $html .= $this->load->view("mgr/items/contact_local_item", array(
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
            if ($this->contact_model->edit($id, $data)) {
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
            $this->data['select']['category'] = $this->contact_model->get_hobby_contact_classify();
            $this->data['classify'] = json_encode($this->data['select']['category']);
            $this->data['select']['is_private'] = array(['id' => 1, 'title' => '公開'], ['id' => 0, 'title' => '不公開']);

            $this->load->view("mgr/contact_form", $this->data);
        }
    }

    // ----------------------------------------------------------------同好獵場 end
}
