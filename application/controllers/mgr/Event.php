<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Event extends Base_Controller
{

	/* for <thead></thead> - Start */
	private $list_th_title         = ['#', '活動名稱', '規則', '累積參加次數', '開始時間/結束時間', '狀態', '新增時間', '動作'];
	private $list_th_width         = ['', '', '', '', '', '60px', '', '150px'];
	private $list_order_column     = ['id', '', '', '', '', '', '', ''];
	private $list_can_order_fields = [0];

	private $awards_th_title         = ['#', '圖片', '獎品名稱', '獎項名稱', '活動名稱', '價值', '數量', '獎項說明', '狀態', '動作'];
	private $awards_th_width         = ['', '150px', '', '', '', '', '', '', '60px', '150px'];
	private $awards_order_column     = ['id', '', '', '', '', '', '', '', '', ''];
	private $awards_can_order_fields = [0];
	/* for <thead></thead> - End */

	private $param = [
		//																							md 		sm
		["抽獎活動設定",			"",				"header", 			"",			TRUE, 	"", 	12, 	12],
		["活動類型",		 	"type", 			"select", 			"", 		TRUE, 	"", 	4, 		12, ['type', 'name']],
		["活動名稱",		 	"title", 			"text", 			"", 		TRUE, 	"", 	4, 		12],
		["活動封面",		 	"cover", 			"img", 			"", 		TRUE, 	"", 	12, 		12, 1440 / 571],
		["活動開始時間",		"start_datetime", 		"datetime", 			"", 		TRUE, 	"", 	4, 		12],
		["活動結束時間",		"end_datetime", 		"datetime", 			"", 		TRUE, 	"", 	4, 		12],
		["活動規則",			"rule", 			"textarea", 			"", 		TRUE, 	"", 	12, 		12],
	];

	private $awards_param = [
		//																							md 		sm
		["獎品分類",		 	"level", 			"select", 			"", 		TRUE, 	"", 	4, 		12, ['level', 'title']],
		["獎品名稱",		 	"title", 			"text", 			"", 		TRUE, 	"", 	4, 		12],
		["獎品價值",		 	"worth", 			"text", 			"", 		TRUE, 	"", 	4, 		12],
		["獎品圖片",		 	"cover", 			"img", 				"", 		TRUE, 	"", 	4, 		12, 1],
		["獎品配額",		 	"quota", 			"text",				"", 		TRUE, 	"", 	4, 		12],
		["獎品說明",		 	"des", 			"textarea",				"", 		TRUE, 	"", 	12, 		12],
	];

	public function __construct()
	{
		parent::__construct();
		$this->is_mgr_login();
		$this->load->model('Event_model');

		$this->data['active'] = 'EVENT';
		$this->action = base_url() . 'mgr/event/';
	}

	// ---------------------------------------------------------------------活動列表 start
	public function list($type = "normal")
	{
		$this->data = array_merge($this->data, array(
			'sub_active'              => 'EVENT_LIST_' . strtoupper($type),
			'parent'                  => '',
			'parent_link'             => base_url() . 'mgr/event/main',
			'custom_data_url'         => base_url() . 'mgr/event/data/' . $type,
			'custom_del_url'          => base_url() . 'mgr/event/list_del',
			'title'                   => ($type == 'normal') ? '部落豐收祭列表' : '專屬豐收祭列表',
			'action'                  => $this->action,
			'th_title'                => $this->list_th_title,
			'th_width'                => $this->list_th_width,
			'can_order_fields'        => $this->list_can_order_fields,
			'default_order_column'    => 0,
			'default_order_direction' => 'DESC',
			'tool_btns'               => [
				['新增豐收祭', base_url() . 'mgr/event/list_add', 'btn-primary'],
			],
		));

		$this->load->view('mgr/template_list', $this->data);
	}

	public function data($type = "normal")
	{
		$page        = ($this->input->post("page")) ? $this->input->post("page") : 1;
		$search      = ($this->input->post("search")) ? $this->input->post("search") : "";
		$order       = ($this->input->post("order")) ? $this->input->post("order") : 0;
		$direction   = ($this->input->post("direction")) ? $this->input->post("direction") : "ASC";

		$order_column = $this->list_order_column;
		$canbe_search_field = ["id", "title", "rule", "start_datetime", "end_datetime", "create_date"];

		$syntax = "is_delete=0 AND type='$type'";
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

		$data = $this->Event_model->get_list_b($syntax, $order_by, $page, $this->page_count);
		$html = "";
		foreach ($data['list'] as $item) {
			$html .= $this->load->view("mgr/items/event_item", array(
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

	public function switch_toggle()
	{
		$id     = $this->input->post("id");
		$status = $this->input->post("status");

		if ($this->Event_model->edit(
			$id,
			array("status" => ($status) ? 'on' : 'off')
		)) {
			$this->output(TRUE, "success");
		} else {
			$this->output(FALSE, "fail");
		}
	}

	public function list_add()
	{
		if ($_POST) {
			$data = $this->process_post_data($this->param);

			if ($id = $this->Event_model->add_b($data)) {
				$prize_data = array();
				for ($i = 1; $i <= $this->input->post('prize_count'); $i++) {
					array_push($prize_data, array(
						'event_id' => $id,
						'level'    => $i,
						'title'    => $this->input->post("prize_level_" . $i),
						'img'      => $this->input->post("prize_photo_" . $i),
					));
				}
				if ($this->Event_model->add_event_level($prize_data)) {
					$this->js_output_and_redirect("新增成功", base_url() . "mgr/event/list/" . $data['type']);
				}
			}
			$this->js_output_and_back("發生錯誤");
		} else {
			$type = (strpos($_SERVER['HTTP_REFERER'], 'normal')) ? 'normal' : 'case';
			$this->data['title'] = '新增豐收祭';
			$this->data['sub_active'] = 'EVENT_LIST_' . strtoupper($type);

			$this->data['parent'] = ($type == 'normal') ? '部落豐收祭列表' : '專屬豐收祭列表';
			$this->data['parent_link'] = base_url() . "mgr/event/list/" . $type;

			$this->data['action'] = base_url() . "mgr/event/list_add";
			$this->data['submit_txt'] = "新增";

			$this->data['select']['type'] = array(
				['type' => 'normal', 'name' => '部落豐收祭'],
				['type' => 'case', 'name' => '專屬豐收祭'],
			);
			$this->data['param'] = $this->param;
			$this->data['param'][1][3] = $type;
			$this->load->view("mgr/event_form", $this->data);
		}
	}

	public function list_edit($id)
	{
		$event = $this->Event_model->get_data_b($id);
		if ($_POST) {
			$data = $this->process_post_data($this->param);
			if ($this->Event_model->edit($id, $data)) {
				$this->Event_model->edit_level(array('event_id' => $id), array('is_delete' => 1));
				$prize_data = array();
				for ($i = 1; $i <= $this->input->post('prize_count'); $i++) {
					array_push($prize_data, array(
						'event_id' => $id,
						'level'    => $i,
						'title'    => $this->input->post("prize_level_" . $i),
						'img'      => $this->input->post("prize_photo_" . $i),
					));
				}
				if ($this->Event_model->add_event_level($prize_data)) {
					$this->js_output_and_redirect("編輯成功", base_url() . "mgr/event/list/" . $data['type']);
				}
			}
			$this->js_output_and_back("發生錯誤");
		} else {
			$this->data['prize_level'] = $this->Event_model->get_level_list_b($id);
			$this->data['param'] = $this->set_data_to_param($this->param, $event);
			$this->data['title'] = '編輯豐收祭';
			$this->data['sub_active'] = 'EVENT_LIST_' . strtoupper($event['type']);

			$this->data['parent'] = ($event['type'] == 'normal') ? '部落豐收祭列表' : '專屬豐收祭列表';
			$this->data['parent_link'] = base_url() . "mgr/event/list/" . $event['type'];

			$this->data['action'] = base_url() . "mgr/event/list_edit/" . $id;
			$this->data['submit_txt'] = "確認編輯";

			$this->data['select']['type'] = array(
				['type' => 'normal', 'name' => '部落豐收祭'],
				['type' => 'case', 'name' => '專屬豐收祭'],
			);

			$this->load->view("mgr/event_form", $this->data);
		}
	}

	public function list_del()
	{
		$id = $this->input->post('id');
		if (!is_numeric($id)) $this->output(FALSE, '發生錯誤');
		if ($this->Event_model->edit($id, array('is_delete' => 1))) {
			$this->output(TRUE, 'success');
		} else {
			$this->output(FALSE, 'fail');
		}
	}
	// ----------------------------------------------------------------活動列表 end

	// ----------------------------------------------------------------獎項管理 start
	public function awards($event_id = '')
	{
		$title = '';
		$tool_btns = array();
		$event = $this->Event_model->get_data_b($event_id);

		if (is_numeric($event_id)) {
			$title = '活動【' . $event['title'] . '】的';
			$tool_btns = [
				['新增獎項', base_url() . 'mgr/event/awards_add/' . $event_id, 'btn-primary'],
			];
		}

		$this->data = array_merge($this->data, array(
			'sub_active'              => 'EVENT_LIST_' . strtoupper($event['type']),
			'parent'                  => ($event['type'] == 'normal') ? '部落豐收祭管理' : '專屬豐收祭管理',
			'parent_link'             => base_url() . 'mgr/event/list/' . $event['type'],
			'custom_data_url'         => base_url() . 'mgr/event/awards_data/' . $event_id,
			'custom_switch_url'       => base_url() . 'mgr/event/awards_switch',
			'custom_del_url'          => base_url() . 'mgr/event/awards_del',
			'switch_on_text'          => '上架',
			'switch_off_text'         => '下架',
			'title'                   => $title . '獎項列表',
			'action'                  => $this->action,
			'th_title'                => $this->awards_th_title,
			'th_width'                => $this->awards_th_width,
			'can_order_fields'        => $this->awards_can_order_fields,
			'default_order_column'    => 0,
			'default_order_direction' => 'DESC',
			'tool_btns'               => $tool_btns,
		));

		$this->load->view('mgr/template_list', $this->data);
	}

	public function awards_data($event_id = '')
	{
		$page        = ($this->input->post("page")) ? $this->input->post("page") : 1;
		$search      = ($this->input->post("search")) ? $this->input->post("search") : "";
		$order       = ($this->input->post("order")) ? $this->input->post("order") : 0;
		$direction   = ($this->input->post("direction")) ? $this->input->post("direction") : "ASC";

		$order_column = $this->awards_order_column;
		$canbe_search_field = [
			"P.id", "P.title", "PL.title", "E.title", "P.worth", "quota", "P.des"
		];

		$syntax = "P.is_delete=0";
		if (is_numeric($event_id)) $syntax .= " AND P.event_id = $event_id";
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

		$data = $this->Event_model->get_awards_list_b($syntax, $order_by, $page, $this->page_count);
		$html = "";
		foreach ($data['list'] as $item) {
			$html .= $this->load->view("mgr/items/prize_item", array(
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

	public function awards_switch()
	{
		$id     = $this->input->post("id");
		$status = $this->input->post("status");

		if ($this->Event_model->edit_prize(
			array('id' => $id),
			array("status" => ($status) ? 'on' : 'off')
		)) {
			$this->output(TRUE, "success");
		} else {
			$this->output(FALSE, "fail");
		}
	}

	public function awards_add($event_id)
	{
		if ($_POST) {
			$data = $this->process_post_data($this->awards_param);
			$prize_count = $this->Event_model->get_prize_count($event_id, $data['level']);
			$data['event_id'] = $event_id;
			$data['layout'] = 12 / ($prize_count + 1);

			if ($this->Event_model->add_prize_b($data)) {
				$this->Event_model->edit_prize(array('event_id' => $event_id, 'level' => $data['level']), array('layout' => $data['layout']));
				$this->js_output_and_redirect("新增成功", base_url() . "mgr/event/awards/" . $event_id);
			} else {
				$this->js_output_and_back("發生錯誤");
			}
		} else {
			$event = $this->Event_model->get_data_b($event_id);
			$this->data['title'] = '新增活動【' . $event['title'] . '】獎品';
			$this->data['sub_active'] = 'EVENT_LIST_' . strtoupper($event['type']);

			$this->data['parent'] = '獎項列表';
			$this->data['parent_link'] = base_url() . "mgr/event/awards/" . $event_id;
			$this->data['action'] = base_url() . "mgr/event/awards_add/" . $event_id;
			$this->data['submit_txt'] = "新增";

			$this->data['select']['level'] = $this->Event_model->get_level_list_b($event_id);
			$this->data['param'] = $this->awards_param;
			$this->load->view("mgr/template_form_complex", $this->data);
		}
	}

	public function awards_edit($prize_id)
	{
		$prize = $this->Event_model->get_prize_data($prize_id);
		$event = $this->Event_model->get_data_b($prize['event_id']);
		if ($_POST) {
			$data = $this->process_post_data($this->awards_param);
			if ($this->Event_model->edit_prize(array('id' => $prize_id), $data)) {
				$this->js_output_and_redirect("編輯成功", base_url() . "mgr/event/awards/" . $prize['event_id']);
			} else {
				$this->js_output_and_back("發生錯誤");
			}
		} else {
			$this->data['param'] = $this->set_data_to_param($this->awards_param, $prize);
			$this->data['title'] = '編輯獎品【' . $prize['title'] . '】';
			$this->data['sub_active'] = 'EVENT_LIST_' . strtoupper($event['type']);

			$this->data['parent'] = '獎項列表';
			$this->data['parent_link'] = base_url() . "mgr/event/awards/" . $prize['event_id'];
			$this->data['action'] = base_url() . "mgr/event/awards_edit/" . $prize_id;
			$this->data['submit_txt'] = "編輯獎品";

			$this->data['select']['level'] = $this->Event_model->get_level_list_b($prize['event_id']);
			$this->load->view("mgr/template_form_complex", $this->data);
		}
	}

	public function awards_del()
	{
		$id = $this->input->post('id');
		if (!is_numeric($id)) $this->output(FALSE, '發生錯誤');
		if ($this->Event_model->edit_prize(array('id' => $id), array('is_delete' => 1))) {
			$this->output(TRUE, 'success');
		} else {
			$this->output(FALSE, 'fail');
		}
	}
	// ----------------------------------------------------------------獎想管理 end
}
