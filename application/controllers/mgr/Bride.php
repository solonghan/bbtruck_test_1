<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bride extends Base_Controller
{

    /* for <thead></thead> - Start */
    private $th_title 			= ['#','排序(前台顯示順序)', 'title',  'subtitle', 'cover img', 'row number', 'create date', ''];
	private $th_width 			= ['','160px', '', '', '', '', '', ''];
	private $order_column		= ['id','', 'title', 'sub_title', '', '', 'create_date', ''];
	private $can_order_fields 	= [0, 1, 2, 5];
	private $canbe_search_field = ['id', 'title', 'sub_title', '', '', 'create_date', ''];
    private $btn_array              =[1,0,0,0];


    private $post_th_title         = ['#', '公告名稱', '獵場', '獵人', '公開類型', '發文時間', '最後修改時間'];
    private $post_th_width         = ['', '', '', '', '',  '', '150px'];
    private $post_order_column     = ['id', '', '', '', '', '', ''];
    private $post_can_order_fields = [0];

 
    /* for <thead></thead> - End */


    //編輯文章參數
    private $param = [
        //																							md 		sm
        //["分類",		 	"type", 			"select", 			"", 		TRUE, 	"", 	4, 		12, ['id', 'title']],
        //["獵場顯示名稱",		"show_name", 			"text", 			"", 		TRUE, 	"", 	4, 		12],
      //  ["版型",             "type",             "img_multi_without_crop",             "",         FALSE,     "",     12,         12, 2 / 1],
        ["新增一列內文版型",     "type",             "select",             "",         TRUE,     "",     4,         12,['id','title']],
        ["Title",             "title",             "text",             "",         TRUE,     "",     4,         12],
       
        ["Subtitle",             "sub_title",             "day",             "",         FALSE,     "",     4,         12],
        ["Cover Image",             "cover_img",             "img",             "",         FALSE,     "",     0.525,         12, 2 / 1],
        // ["文字2",             "content2",             "text",             "",         TRUE,     "",     4,         12],

        // ["圖片3",             "img3",             "img_multi_without_crop",             "",         TRUE,     "",     12,         12, 2 / 1],
        // ["標題3",             "title3",             "text",             "",         FALSE,     "",     4,         12],
        // ["文字3",             "content3",             "text",             "",         TRUE,     "",     4,         12,],

        // ["背景圖",             "cover",             "img_multi_without_crop",             "",         FALSE,     "",     12,         12, 1],
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
        $this->load->model('Bride_model');
        $this->load->helper('datas_transform');
        $this->load->model('Datas_form_model');
        $this->data['active'] = 'BRIDE';
        $this->action = base_url() . 'mgr/bride/';
    }

    // ---------------------------------------------------------------------活動列表 start
    public function index()
    {
        require('./vendors/autoload.php');
        //require('C:/xampp/htdocs/new_wedding/vendors/autoload.php');
        //$bride = $this->Bride_model->get_data(1);
        
        $this->data = array_merge($this->data, array(
            'sub_active'              => 'BRIDE',
            'parent'                  => '',
            // 'parent_link'             => base_url() . 'mgr/event/main',
            'custom_del_url'          => base_url() . 'mgr/bride/local_del',
            'title'                   => '圖片列表',
            'action'                  => $this->action,
            'th_title'                => $this->th_title,
            'th_width'                => $this->th_width,
            'can_order_fields'        => $this->can_order_fields,
            'default_order_column'    => 1,
            'default_order_direction' => 'DESC',
           
            'tool_btns'               => [

                ['New Bride', base_url()."mgr/bride/edit/add", "btn-primary"],
            ],
        ));
        
       
        $this->load->view('mgr/template_list', $this->data);
    }

    public function data()
    {

       
        $page        = ($this->input->post("page"))			? $this->input->post("page")		: 1			;
		$search      = ($this->input->post("search"))		? $this->input->post("search")		: ''		;
		$order       = ($this->input->post("order"))		? $this->input->post("order")		: 0			;
		$direction   = ($this->input->post("direction"))	? $this->input->post("direction") 	: 'DESC'	;

		$syntax	= '`is_delete` = 0 ';

		// For count total page number
		$total = $this->Bride_model->get_all_num($syntax);
		$total_page = $this->Bride_model->compute_total_page($total);

		// set SQL : ORDER BY
		$order_by = ' sort ASC';//`create_date` DESC
		if ($this->order_column[$order] != '')
			$order_by = '`' . $this->order_column[$order] . '` ' . $direction . ', ' . $order_by;

		$lists = $this->Bride_model->get_all_lists($syntax, $order_by, $page);
        $total_all = $this->db->select()->from($this->bride_table)->where("is_delete= 0")->get()->num_rows();
		// Combine item html
		$html = '';

		if ($search !== '')
		{
			$lists =& $this->set_search_lists($search, $lists, $this->canbe_search_field);
		}
        //var_dump($lists);
		foreach ($lists as $item)
		{
			$item['imgs'] = json_decode($item['imgs'], TRUE);
           // var_dump($item['imgs']);
           
			foreach ($item['imgs'] as $key => $value)
			{
				$item['imgs'][$key]['type'] = bride_type_to_string($value['type']);
			}

			$html .= $this->load->view("mgr/items/bride_item", array(
					'item'  =>  $item,
                    "total"=>    $total_all,////
			), TRUE);
		}

		$this->output(TRUE,"取得成功", array(
				'html' 			=> $html,
				'page' 			=> $page,
				'total_page' 	=> $total_page
		));
    }

    ////////////////
    public function sort(){
		$id = $this->input->post("id");
		if (!is_numeric($id)) show_404();
		$sort = $this->input->post("sort");

		$index = 1;
		foreach ($this->db->order_by("sort ASC")->get_where($this->bride_table, array("id<>"=>$id, "is_delete"=>0))->result_array() as $item) {
			if ($index == $sort) $index++;
			$data[] = array(
				"id"	=>	$item['id'],
				"sort"	=>	$index
			);
			$index++;
		}
		$data[] = array(
			"id"         =>	$id,
			"sort"       =>	$sort
		);
		$res = $this->db->update_batch($this->bride_table, $data, "id");
		if ($res) {
			$this->output(TRUE, "成功");
		}else{
			$this->output(FALSE, "失敗");
		}
	}
    ////////////////

    public function add()
    {
        require('./vendors/autoload.php');
        //require('C:/xampp/htdocs/new_wedding/vendors/autoload.php');
        if ($_POST) {
            $data = $this->process_post_data($this->param);



            unset($data['type']);
            if ($this->Bride_model->add($data) !== FALSE) {


                $this->js_output_and_redirect("編輯成功", base_url() . "mgr/bride/index/");
            } else {
                $this->js_output_and_back("發生錯誤");
            }
        } else {
            //$this->data['pics'] = $this->Bulletin_model->get_banner($id);


            $this->data['btn']=$this->btn_array;
            $this->data['param'] = $this->param;
            $this->data['title'] = '新增圖片';
            $this->data['sub_active'] =  'BRIDE';

            $this->data['parent'] = '圖片列表';
            $this->data['parent_link'] = base_url() . "mgr/bride/index/";

            $this->data['action'] = base_url() . "mgr/bride/add/";
            $this->data['submit_txt'] = "新增";

            $this->data['select']['type'] = array(['id' => '1', 'title' => '版型一 一張圖片'], ['id' => '2', 'title' => '版型二，兩張圖片，左窄右寬'],['id' => '3', 'title' => '版型三，兩張圖片，左寬右窄'],['id' => '4', 'title' => '版型四，三張照片']);
            // TODO: 新欄位還沒串

            //var_dump($this->data);
            $this->load->view("mgr/template_form", $this->data);
        }
    }

    public function edit($id)
    {

        if ( ! is_numeric($id) AND $id !== 'add' AND $id !== 'del')
        $this->index();

    if ($this->input->post())
    {
        $is_del = FALSE;

        // 整理 $data
        if ($this->input->post('del_id'))  		// 刪除不可以靠GET(uri)取到的資料
        {
            echo "sdjkdsalkj";
        }
        else  									// 把 $data 整理好
        {
            if (is_numeric($id)) 				// 未查詢到此 bride_id 就掰掰
            {
                $is_id_ok = $this->Bride_model->is_post_delete($id);
                if ($is_id_ok === NULL)
                {
                    $this->js_output_and_redirect(output_msg('bride_001'), base_url().'mgr/bride/');
                }
                elseif ($is_id_ok == '1')
                {
                    $this->js_output_and_redirect(output_msg('bride_001'), base_url().'mgr/bride/');
                }
            }

            $data = $this->process_post_data($this->Datas_form_model->bride_post());
            unset($data['_content_type']);

            $types = explode(',', $data['row_types']);
            $del   = explode(',', $data['row_del']);
            unset($data['row_del']);
            $imgs  = array();
            $count = 0;
            $row_types = '';
            for ($i = 1; $i <= count($types) - 1; $i++)
            {
                if ( ! in_array("$i", $del))
                {
                    $count++ ;
                    $row_phot = array();
                    for ($j = 1; $j <= bride_type_to_btn_num($types[$i]); $j++)
                    {
                        $str = 'row_'."$i".'_photo_'."$j";  				// ex: row_2_photo_1
                        array_push($row_phot, $this->input->post($str));
                    }

                    $imgs = array_merge($imgs, array( 'row_'."$count" => array(
                            'type' 	=> $types[$i],
                            'img'  	=> $row_phot,
                    )));
                    $row_types .= ','.$types[$i];
                }
            }
            $data['row_types'] = $row_types;
            $data['imgs'] =	json_encode($imgs);
        }

        // 將 $data 丟進 DB
        if ($this->Bride_model->set_post_detail($id, $data))
        {
            if ($is_del)  							// del
            {
                echo "kjlsadkjdl";
            }
            elseif ($id === 'add')  				// add
            {
                $this->js_output_and_redirect("成功新增", base_url()."mgr/bride/index/");
            }
            elseif (is_numeric($id))  				// edit
            {
                $this->js_output_and_redirect("成功編輯", base_url()."mgr/bride/index/");
            }
        }
        else
        {
            $this->js_output_and_back('資料更新失敗');
        }
    }
    else
    {
        if (is_numeric($id))
        {
            $item = $this->Bride_model->get_post_detail($id);
            if ($item === NULL)
                $this->js_output_and_redirect('111', base_url().'bride/');

            // imgs 的處理
            $btn_html = '';
            if ($item !== '')
            {
                $imgs = json_decode($item['imgs'], TRUE);
                //var_dump($imgs);
                $count = 0;
                foreach ($imgs as $value)
                {
                    $count++ ;
                    $btn_html .= $this->get_btn_active($count, $value['type'], $value['img']);
                }
            }
        }
        else
            $item = '';
        

        //var_dump($btn_html);    
        
        if(!isset($btn_html))$btn_html='';
        if(!isset($count))$count=0;
        $this->data = array_merge($this->data, array(
                'title'						=>   ' bride',
                'parent'					=> 'Our Bride manage',
                'parent_link'				=> base_url().'mgr/bride/',
                'action'					=> base_url().'mgr/bride/edit/'.$id,
                'submit_txt' 				=> '編輯',
                'select' 					=> [
                '_content_type' 	=> [
                                ['value' => '1', 'string' => bride_type_to_string(1)],
                                ['value' => '2', 'string' => bride_type_to_string(2)],
                                ['value' => '3', 'string' => bride_type_to_string(3)],
                                ['value' => '4', 'string' => bride_type_to_string(4)],
                        ],
                ],
                'btn'                       =>$this->btn_array,
                'param' 					=> $this->Datas_form_model->bride_post($item),
                'btn_html' 					=> $btn_html,
                'max_row' 					=> $count,
        ));

            $this->load->view("mgr/bride_form", $this->data);
        }
    }

    public function local_del($id)
    {
        //$id = $this->input->post('id');

        //  var_dump($id);
        if (!is_numeric($id)) $this->output(FALSE, '發生錯誤');
        if ($this->Bride_model->edit($id, array('is_delete' => 1))) {
            //$this->output(TRUE, 'success');
            $this->js_output_and_redirect("刪除成功", base_url() . "mgr/bride/");
        } else {
            $this->output(FALSE, 'fail');
        }
    }
    // ----------------------------------------------------------------活動列表 end

    // ----------------------------------------------------------------文章列表 start
    public function post_list($bride_id)
    {
        $bride = $this->bride_model->get_data($bride_id);
        $this->data = array_merge($this->data, array(
            'sub_active'              => 'BRIDE_MGR_LOCAL',
            'parent'                  => ($bride['type'] == 'local') ? '在地獵場列表' : '同好獵場',
            'parent_link'             => ($bride['type'] == 'local') ? base_url() . 'mgr/huntground/local' : base_url() . 'mgr/huntground/hobby',
            'custom_data_url'          => base_url() . 'mgr/bride/post_data/' . $bride_id,
            'title'                   => '【' . $bride['name'] . '】的文章列表',
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

    public function post_data($bride_id)
    {
        $page        = ($this->input->post("page"))            ? $this->input->post("page")        : 1;
        $search      = ($this->input->post("search"))        ? $this->input->post("search")        : '';
        $order       = ($this->input->post("order"))        ? $this->input->post("order")        : 0;
        $direction   = ($this->input->post("direction"))    ? $this->input->post("direction")     : 'DESC';
        $status       = ($this->input->post("status"))        ? $this->input->post("status")        : 'ALL';
        $user_id     = ($this->input->post("user_id"))        ? $this->input->post("user_id")        : 0;

        $bride = $this->bride_model->get_data($bride_id);

        $syntax    = "P.is_delete=0 AND post_at='bride' AND relation_id='$bride_id'";
        if ($status != 'ALL')
            $syntax .= " AND ( P.`status` = '" . $status . "' )";

        // set SQL : ORDER BY
        $order_by = ' P.`create_date` DESC';
        if ($this->hobby_order_column[$order] != '')
            $order_by = '`' . $this->hobby_order_column[$order] . '` ' . $direction . ', ' . $order_by;

        $lists = $this->bride_model->get_post_list($syntax, $order_by, intval($page), $page_count = 20);

        // Combine item html
        $html = '';

        if ($search !== '') {
            $lists['data'] = &$this->set_search_lists($search, $lists['data'], $this->post_canbe_search_field);
        }

        foreach ($lists['list'] as $item) {
            $html .= $this->load->view("mgr/items/huntground_post_item", array(
                'item' => $item,
                'bride' => $bride,
            ), TRUE);
        }

        $this->output(TRUE, '資料取得成功', array(
            'html'             => $html,
            'page'             => $page,
            'total_page'     => $lists['total_page'],
        ));
    }

    // ----------------------------------------------------------------文章列表 end

  	// for get new btn
	public function get_btn_active($dyn_row = FALSE, $cont_type = FALSE, $item_img = FALSE)
	{
		if ($dyn_row === FALSE AND $cont_type ===FALSE)  					// ajax 動態新增走這
		{
			// 這是第幾個動態新增的列
			$dynamic_row  = ($this->input->post('dynamic_row')  ? $this->input->post('dynamic_row')  : NULL);
			// 這次新增的列是哪種類型
			$content_type = ($this->input->post('content_type') ? $this->input->post('content_type') : NULL);
			$item_img = array('', '', '', '');
		}
		else 																// for edit 靜態新增走這
		{
			$dynamic_row = $dyn_row;
			$content_type = $cont_type;
		}

		// 類型不符合現有規定則給 content_type = 0, 之後就會輸出 FALSE
		if (($content_type < 1) OR ($content_type > 4) OR ( ! is_numeric($content_type)))
			$content_type = 0;

		$img_type = bride_type_to_btn_types($content_type);

		$btn_html = '<div id="dyn_row_'.$dynamic_row.'"><hr>';
		$data['row'] = FALSE;  												// for 刪除整列按鈕用
		$data['del_grp_id'] = 'dyn_row_'.$dynamic_row;  					// for 刪除整列按鈕用
		for ($i = 1; $i <= bride_type_to_btn_num($content_type); $i++)
		{
			$data['item'] = $this->Datas_form_model->bride_post_dynamic_btn(
				$dynamic_row,
				$i,
				bride_type_to_str_for_form($content_type),
				$img_type[$i - 1],
				$item_img[$i - 1]
			)[0];
			$btn_html .= $this->load->view('mgr/items/bride_dynamic_btn_item', $data, TRUE);
			$data['row'] = TRUE;
		}
		$btn_html .= '</div>';

		if ($dyn_row === FALSE AND $cont_type === FALSE)
		{
			$output_status = TRUE;
			$this->output($output_status, '', array(
				'row' 		=> $dynamic_row,
				'type' 		=> $content_type,
				'btn_html'  => $btn_html,
			));
		}
		else
		{
			return $btn_html;
		}
	}

}
