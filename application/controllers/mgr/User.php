<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Base_Controller {

/* for <thead></thead> - Start */
	private $index_th_title 		  = ['#', '獵人資訊', '暱稱', '帳號/手機', '獵人資產', '獵人吸引度', '榮譽勳章', '所屬部落', '在地獵場','操作'];
	private $index_th_width 		  = ['','','','','','','','','',''];
	private $index_order_column 	  = ['id','','tribe','level','',''];
	private $index_can_order_fields   = [0,2,3,4,6,7,8,10];
	private $index_canbe_search_field = ['id','atid', 'nickname', 'email', 'mobile', 'tribe', 'level'];

	private $post_th_title 		  	  = ['#', '文章URL', '獵人', '日記分類', '分享地點', '標題', '公開類型', '溫度/留言/分享數', '發文時間', '最後修改時間'];
	private $post_th_width 		  	  = ['','','','','','','','','',''];
	private $post_order_column 		  = ['id','','','classify_str','post_at','status','create_date','update_date'];
	private $post_can_order_fields    = [0,3,4,6,8,9];
	private $post_canbe_search_field  = ['id', 'classify_str', 'post_at', 'title', 'status'];

	private $friends_th_title 		  	 = ['#', '獵人資訊', '暱稱', '帳號/手機', '獵人資產', '獵人吸引度', '榮譽勳章', '所屬部落', '在地獵場','操作'];
	private $friends_th_width 		  	 = ['','','','','','','','','',''];
	private $friends_order_column 		 = ['id','','tribe','level','',''];
	private $friends_can_order_fields    = [0,1,2,3,5,6,7,9];
	private $friends_canbe_search_field  = ['id','atid', 'nickname', 'email', 'mobile', 'tribe', 'level'];

	private $h_club_th_title 		  	 = ['#', '@ID', '獵場擁有者','獵場標題','獵場全名','背景圖','獵場討論度','參與人數','創建日期','操作'];
	private $h_club_th_width 		  	 = ['','','','','','','','','',''];
	private $h_club_order_column 		 = ['id','discuss_hot','people'];
	private $h_club_can_order_fields     = [0,7,8];
	private $h_club_canbe_search_field   = ['id','code', 'show_name', 'name', 'discuss_hot', 'people'];
/* for <thead></thead> - End */

	private $param = [
			//																							md 		sm
			["廣告設定",			"",						"header", 			"",			TRUE, 	"", 	12, 	12],
			["廣告類型",		 	"adv_type", 			"select", 			"", 		TRUE, 	"", 	4, 		12],
			["聯絡人Line ID", 	"company", 				"text", 			"", 		TRUE, 	"", 	3, 		12],
			["公司簡介", 		"company", 				"textarea_plain", 	"", 		TRUE, 	"", 	12, 	12],
			["廣告起迄日期-迄", 	"tax_id", 				"day",		 		"", 		TRUE, 	"", 	4,	 	12],
			["預計商品數量", 		"tax_id", 				"number",			"", 		TRUE, 	"", 	3,	 	12],
			["本次市售總定價", 	"tax_id", 				"plain",		 	"$0", 		TRUE, 	"", 	3,	 	12],
			["體驗方式",			"experienc_type", 		"checkbox_multi", 	"", 		TRUE, 	"", 	12, 	12],
    ];

	public function __construct()
	{
		parent::__construct();
		$this->is_mgr_login();
		$this->load->model('User_mgr_model');

		$this->data['active'] 	  = 'USER_LIST';
	}


	public function index()
	{
		$this->data = array_merge($this->data, array(
				'active'					=> 'USER',
				'sub_active'				=> 'USER_LIST',
				'parent'					=> '會員管理',
				'parent_link'				=> base_url().'mgr/user/index',
				'title'						=> '會員列表',
				'action'					=> base_url().'mgr/user/index_',
				'th_title'					=> $this->index_th_title,
				'th_width'					=> $this->index_th_width,
				'can_order_fields'			=> $this->index_can_order_fields,
				'default_order_column'		=> 0,
				'default_order_direction'	=> 'DESC',
				'tool_btns'					=> [
						['dd', base_url().'', 'btn-warning'],
						['dd', base_url().'', 'btn-primary'],
				],
				'default_status'			=> 'ALL',
				'status_btn'				=> [
						['1', '高山部落'],
						['2', '平原部落'],
						['3', '海洋部落'],
				],
		));

		$this->load->view('mgr/user_list', $this->data);
	}

	// 查看獵人日記
	public function posts($id)
	{
		$user = $this->User_mgr_model->get_user_formatted($id);
		$this->data = array_merge($this->data, array(
				'user_id' 					=> $id,
				'active'					=> 'USER',
				'sub_active'				=> 'USER_LIST',
				'parent'					=> '會員管理 / 會員列表',
				'parent_link'				=> base_url().'mgr/user/index',
				'title'						=> $user['nickname'] . '[@' . $user['atid'] . ']' . ' 的獵人日記',
				'action'					=> base_url().'mgr/user/posts_',
				'th_title'					=> $this->post_th_title,
				'th_width'					=> $this->post_th_width,
				'can_order_fields'			=> $this->post_can_order_fields,
				'default_order_column'		=> 0,
				'default_order_direction'	=> 'DESC',
				'tool_btns'					=> [
						['dd', base_url().'', 'btn-warning'],
						['dd', base_url().'', 'btn-primary'],
				],
				'default_status'			=> 'ALL',
				'status_btn'				=> [
						['publish', '公開'],
						['privacy', '私有'],
						['draft',   '草案'],
				],
		));

		$this->load->view('mgr/user_list', $this->data);
	}

	// 查看好友清單
	public function friends($id)
	{
		$user = $this->User_mgr_model->get_user_formatted($id);
		$this->data = array_merge($this->data, array(
				'user_id' 					=> $id,
				'active'					=> 'USER',
				'sub_active'				=> 'USER_LIST',
				'parent'					=> '會員管理 / 會員列表',
				'parent_link'				=> base_url().'mgr/user/index',
				'title'						=> $user['nickname'] . '[@' . $user['atid'] . ']' . ' 的好友清單',
				'action'					=> base_url().'mgr/user/friends_',
				'th_title'					=> $this->friends_th_title,
				'th_width'					=> $this->friends_th_width,
				'can_order_fields'			=> $this->friends_can_order_fields,
				'default_order_column'		=> 0,
				'default_order_direction'	=> 'DESC',
				'tool_btns'					=> [
						['dd', base_url().'', 'btn-warning'],
						['dd', base_url().'', 'btn-primary'],
				],
				'default_status'			=> 'ALL',
				'status_btn'				=> [
						['1', '高山部落'],
						['2', '平原部落'],
						['3', '海洋部落'],
				],
		));

		$this->load->view('mgr/user_list', $this->data);
	}

	// 查看加入的同好獵場
	public function h_club($id)
	{
		$user = $this->User_mgr_model->get_user_formatted($id);
		$this->data = array_merge($this->data, array(
				'user_id' 					=> $id,
				'active'					=> 'USER',
				'sub_active'				=> 'USER_LIST',
				'parent'					=> '會員管理 / 會員列表',
				'parent_link'				=> base_url().'mgr/user/index',
				'title'						=> $user['nickname'] . '[@' . $user['atid'] . ']' . ' 加入的同好獵場',
				'action'					=> base_url().'mgr/user/h_club_',
				'th_title'					=> $this->h_club_th_title,
				'th_width'					=> $this->h_club_th_width,
				'can_order_fields'			=> $this->h_club_can_order_fields,
				'default_order_column'		=> 0,
				'default_order_direction'	=> 'DESC',
				'tool_btns'					=> [
						['dd', base_url().'', 'btn-warning'],
						['dd', base_url().'', 'btn-primary'],
				],
		));

		$this->load->view('mgr/user_list', $this->data);
	}
	

	// ---------------------------------------------------------------------

/* For ajax - Start */

	public function index_data()
	{
		$page        = ($this->input->post("page"))			? $this->input->post("page")		: 1			;
		$search      = ($this->input->post("search"))		? $this->input->post("search")		: ''		;
		$order       = ($this->input->post("order"))		? $this->input->post("order")		: 0			;
		$direction   = ($this->input->post("direction"))	? $this->input->post("direction") 	: 'DESC'	;
		$status  	 = ($this->input->post("status"))		? $this->input->post("status")		: 'ALL'		;

		$syntax	= 'U.`is_delete` = 0 AND U.`status` = "on" ';
		if ($status != 'ALL')
			$syntax .= " AND ( U.`tribe` = '" . $status . "' )";

		// For count total page number
		$total 		 = $this->User_mgr_model->get_all_user_num($syntax);
		$total_page  = $this->User_mgr_model->compute_total_page($total);

		// set SQL : ORDER BY
		$order_by = ' U.`register_date` DESC';
		if ($this->index_order_column[$order] != '')
			$order_by = '`' . $this->index_order_column[$order] . '` ' . $direction . ', ' . $order_by;

		$lists = $this->User_mgr_model->get_page_users($syntax, $order_by, $page);

		// Combine item html
		$html = '';

		if ($search !== '')
		{
			$lists =& $this->set_search_lists($search, $lists, $this->index_canbe_search_field);
		}

		// do something data tf
		$lists = $this->_index_tf_db_field($lists);

		foreach ($lists as $item)
		{
			$html .= $this->load->view("mgr/items/user_info_item", array(
					'item'  =>  $item,
			), TRUE);
		}

		$this->output(TRUE, '資料取得成功', array(
				'html' 			=> $html,
				'page' 			=> $page,
				'total_page' 	=> $total_page
		));
	}

	public function posts_data()
	{
		$page        = ($this->input->post("page"))			? $this->input->post("page")		: 1			;
		$search      = ($this->input->post("search"))		? $this->input->post("search")		: ''		;
		$order       = ($this->input->post("order"))		? $this->input->post("order")		: 0			;
		$direction   = ($this->input->post("direction"))	? $this->input->post("direction") 	: 'DESC'	;
		$status  	 = ($this->input->post("status"))		? $this->input->post("status")		: 'ALL'		;
		$user_id     = ($this->input->post("user_id"))		? $this->input->post("user_id")		: 0			;

		$syntax	= 'P.`is_delete` = 0 AND P.`user_id` = "' . $user_id . '"';
		if ($status != 'ALL')
			$syntax .= " AND ( P.`status` = '" . $status . "' )";

		// set SQL : ORDER BY
		$order_by = ' P.`create_date` DESC';
		if ($this->post_order_column[$order] != '')
			$order_by = '`' . $this->post_order_column[$order] . '` ' . $direction . ', ' . $order_by;

		$lists = $this->User_mgr_model->get_list($user_id, $syntax, $page, $order_by);

		// Combine item html
		$html = '';

		if ($search !== '')
		{
			$lists['data'] =& $this->set_search_lists($search, $lists['data'], $this->post_canbe_search_field);
		}

		foreach ($lists['data'] as $item)
		{
			$html .= $this->load->view("mgr/items/user_post_item", array(
					'item'  =>  $item,
			), TRUE);
		}

		$this->output(TRUE, '資料取得成功', array(
				'html' 			=> $html,
				'page' 			=> $lists['page'],
				'total_page' 	=> $lists['total_page'],
		));
	}

	public function friends_data()
	{
		$page        = ($this->input->post("page"))			? $this->input->post("page")		: 1			;
		$search      = ($this->input->post("search"))		? $this->input->post("search")		: ''		;
		$order       = ($this->input->post("order"))		? $this->input->post("order")		: 0			;
		$direction   = ($this->input->post("direction"))	? $this->input->post("direction") 	: 'DESC'	;
		$status  	 = ($this->input->post("status"))		? $this->input->post("status")		: 'ALL'		;
		$user_id     = ($this->input->post("user_id"))		? $this->input->post("user_id")		: 0			;

		$syntax	= 'U.`is_delete` = 0 AND U.`status` = "on" AND F.status = "normal" AND F.user_id = "'.$user_id.'" ';
		if ($status != 'ALL')
			$syntax .= " AND ( U.`tribe` = '" . $status . "' )";

		// For count total page number
		$total 		 = $this->User_mgr_model->get_all_friends_num($syntax);
		$total_page  = $this->User_mgr_model->compute_total_page($total);

		// set SQL : ORDER BY
		$order_by = ' F.`create_date` DESC';
		if ($this->friends_order_column[$order] != '')
			$order_by = '`' . $this->friends_order_column[$order] . '` ' . $direction . ', ' . $order_by;

		$lists = $this->User_mgr_model->get_all_friends($syntax, $order_by, $page);

		// Combine item html
		$html = '';

		if ($search !== '')
		{
			$lists =& $this->set_search_lists($search, $lists, $this->friends_canbe_search_field);
		}

		// do something data tf
		$lists = $this->_index_tf_db_field($lists);

		foreach ($lists as $item)
		{
			$html .= $this->load->view("mgr/items/user_info_item", array(
					'item'  =>  $item,
			), TRUE);
		}

		$this->output(TRUE, '資料取得成功', array(
				'html' 			=> $html,
				'page' 			=> $page,
				'total_page' 	=> $total_page
		));
	}

	public function h_club_data()
	{
		$page        = ($this->input->post("page"))			? $this->input->post("page")		: 1			;
		$search      = ($this->input->post("search"))		? $this->input->post("search")		: ''		;
		$order       = ($this->input->post("order"))		? $this->input->post("order")		: 0			;
		$direction   = ($this->input->post("direction"))	? $this->input->post("direction") 	: 'DESC'	;
		$status  	 = ($this->input->post("status"))		? $this->input->post("status")		: 'ALL'		;
		$user_id     = ($this->input->post("user_id"))		? $this->input->post("user_id")		: 0			;

		$syntax	= 'C.`is_delete` = 0 AND R.`user_id` = "' . $user_id . '" AND C.`type` = "hobby" ';

		// For count total page number
		$total 		 = $this->User_mgr_model->get_all_h_club_num($syntax);
		$total_page  = $this->User_mgr_model->compute_total_page($total);

		// set SQL : ORDER BY
		$order_by = ' C.`create_date` DESC';
		if ($this->h_club_order_column[$order] != '')
			$order_by = '`' . $this->h_club_order_column[$order] . '` ' . $direction . ', ' . $order_by;

		$lists = $this->User_mgr_model->get_all_h_club($syntax, $order_by, $page);

		// Combine item html
		$html = '';

		if ($search !== '')
		{
			$lists =& $this->set_search_lists($search, $lists, $this->h_club_canbe_search_field);
		}

		foreach ($lists as $item)
		{
			$owner = $this->User_mgr_model->get_user_formatted($item['owner']);
			$item['owner'] = $owner['nickname'] . '[@' . $owner['atid'] . ']';
			$html .= $this->load->view("mgr/items/user_h_club_item", array(
					'item'  =>  $item,
			), TRUE);
		}

		$this->output(TRUE, '資料取得成功', array(
				'html' 			=> $html,
				'page' 			=> $page,
				'total_page' 	=> $total_page
		));
	}
/* For ajax - End */

	// 暫時寫在這裡
	private function _index_tf_db_field($lists)
	{
		foreach ($lists as $key => $value)
		{
			$lists[$key]['login_type'] = array();

			// 綁定社群帳號資訊
			if ( ! empty($value['g_id']))
			{
				$lists[$key]['login_type']['G'] = 'Google 綁定';
			}
			if ( ! empty($value['line_id']))
			{
				$lists[$key]['login_type']['L'] = 'Line 綁定';
			}
			if ( ! empty($value['fb_id']))
			{
				$lists[$key]['login_type']['F'] = 'FB 綁定';
			}

			// 所屬部落
			if ($value['tribe'] == 1)
			{
				$lists[$key]['tribe'] = '高山部落';
			}
			elseif ($value['tribe'] == 2)
			{
				$lists[$key]['tribe'] = '平原部落';
			}
			elseif ($value['tribe'] == 3)
			{
				$lists[$key]['tribe'] = '海洋部落';
			}

			// 在地獵場
			$lists[$key]['local_club_name'] = json_decode($value['local_club_name'], TRUE);

			// 榮譽勳章
			$lists[$key]['medal_name'] = json_decode($value['medal_name'], TRUE);
		}
		return $lists;
	}
}