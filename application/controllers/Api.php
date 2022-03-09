<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends Base_Controller{
	private $login_url;
	public function __construct(){
		parent::__construct();

		$this->login_url = base_url()."login";

		$this->load->model("Notification_model");
		$this->load->model("Task_model");
	}

	//test
	public function clear_today_task(){
		$this->load->model("Cron_model");
		$this->Cron_model->task_clear();
		echo "已清除";
	}
	public function refresh_leaderboard(){
		$this->load->model("Cron_model");
		$this->Cron_model->generate_leaderboard(1);
		$this->Cron_model->generate_leaderboard(2);
		$this->Cron_model->generate_leaderboard(3);
		echo "已刷新";
	}

	public function reset_checkin(){
		$user = $this->check_user_token();
		$days = $this->post("days", "");

		$c = $this->db->order_by("id desc")->limit(1)->get_where("checkin_log", array("user_id"=>$user['id']))->row_array();
		if ($c == null) echo "查無簽到紀錄";
		if ($days == '') $days = 0; else $days = intval($days) - 1;
		if ($days < 0) $days = 0;
		$res = $this->db->where(array("id"=>$c['id']))->update("checkin_log", array(
			"days"        =>	$days,
			"create_date" =>	date("Y-m-d H:i:s", strtotime('- 1 day', strtotime($c['create_date'])))
		));
		if ($res) {
			echo "重置成功, 累積第".($days+1)."天簽到";
		}else{
			echo "error";
		}
	}
	public function test_send_push(){
		$this->Notification_model->send_push('web', $this->post("token"), $this->post("message"));
	}
	public function add_ticket(){
		$user        = $this->check_user_token();
		$ticket_type = $this->post("ticket_type", "sticket");
		$cnt         = $this->post("cnt", 0);

		$cnt += $user[$ticket_type];
		if($this->User_model->edit($user['id'], array($ticket_type=>$cnt))){
			echo "目前有 ".$cnt." 張 ".(($ticket_type=="sticket")?"小獵券":"大獵券");
		}

	}
	public function change_user_role_in_club(){
		$user    = $this->check_user_token();
		$club_id = $this->post("club_id");
		$role    = $this->post("role", 'normal');

		if ($this->Club_model->change_user_role($user['id'], $club_id, $role)) {
			$this->output(TRUE, "變更成功");
		}else{
			$this->output(FALSE, "變更失敗");
		}
	}

	public function add_user_to_club(){
		$club_id = $this->post("club_id");
		$user_id = $this->post("user_id");

		if ($this->Club_model->user_join_club($user_id, array($club_id))) {
			echo "加入成功";
		}else{
			echo "fail";
		}
	}

	public function get_all_user(){
		$data = array();
		foreach ($this->db->get("user")->result_array() as $u) {
			$data[] = $this->User_model->get_user_formatted($u['id'], $u);
		}
		$this->output(TRUE, "變更成功", array("data"=>$data));
	}

	public function set_level(){
		$user_id = $this->post("user_id");
		$level   = $this->post("level");

		if ($this->User_model->edit($user_id, array("level"=>$level))) {
			$this->output(TRUE, "變更成功", array("data"=>$this->User_model->get_data($user_id)));
		}else{
			echo "fail";
		}
	}

	public function generate_prize(){
		$prize = [
			["GoPro MAX 360度攝影機", "gopromax.jpg"],
			["iphone 11 pro max", "iphone11promax.jpg"],
			["奇華餅家 如意禮盒", "cookie.jpg"],
			["HEAD 海德 筋膜按摩組", "massage.jpg"],
			["鍋寶亮彩不沾湯鍋22cm(玫瑰金)", "pan.jpg"],
			["Panasonic 9公升智能烤箱", "panasonic.jpg"],
			["SAMPO 義式濃縮奶泡咖啡機", "sampo.jpg"],
			["SONY Digital Camera ZV-1", "SONY Digital Camera ZV-1.jpg"],
			["Ethne小風鈴 無線吸塵器", "vacuum.jpg"],
			["ViewSonic口袋投影機", "viewsonic.jpg"]
		];
		foreach ($this->db->get("event")->result_array() as $event) {
			$this->db->insert("event_prize_level", array(
				"event_id"     =>	$event['id'],
				"level"        =>	1,
				"title"        =>	"部落獎",
				"img"          =>	"assets/event/reward1.png",
				"sticket"      =>	rand(600,1000),
				"bticket"      =>	rand(5,10),
				"participants" =>	rand(10, 200)
			));
			for ($i=2; $i <= 5 ; $i++) { 
				$title = "";
				if ($i == 2) {
					$title = "獵場獎";
				}else if ($i == 3) {
					$title = "頂尖獵人獎";
				}else if ($i == 4) {
					$title = "波麗士獎";
				}else if ($i == 5) {
					$title = "全民小確幸獎";
				}
				$this->db->insert("event_prize_level", array(
					"event_id"     =>	$event['id'],
					"level"        =>	$i,
					"title"        =>	$title,
					"img"          =>	"assets/event/reward".$i.".png",
					"sticket"      =>	rand(50,500),
					"bticket"      =>	rand(1,5),
					"participants" =>	rand(100, 2000)
				));
			}
			$this->db->insert("event_prize_level", array(
				"event_id"     =>	$event['id'],
				"level"        =>	6,
				"title"        =>	"特別獎",
				"img"          =>	"assets/event/rewards.png",
				"sticket"      =>	rand(1,50),
				"bticket"      =>	rand(1,2),
				"participants" =>	rand(1000, 5000)
				));

			//level1
			$p1 = rand(0,1);
			$this->db->insert("event_prize", array(
				"event_id"     =>	$event['id'],
				"level"        =>	1,
				"layout"       =>	12,
				"title"        =>	$prize[$p1][0],
				"worth"        =>	rand(15000, 30000),
				"cover"        =>	"uploads/demo/prize/".$prize[$p1][1],
				"quota"        =>	1,
				"des"          =>	"不論是感恩節的火雞、復活節的羊肉或耶誕節的鮮魚，有了PerfectRoast三點探針，都可以準確完美烘烤肉類。高靈敏度的測量點能在烘烤時測量食物的核心溫度，而且精確度絲毫不差。無論您用的是烤箱、微波爐或蒸氣烤箱模式，每次都有完美的成果。<br><br>只要動動手指就能變身烘焙達人。<br><br>烘焙從未如此輕鬆簡單。有了我們獨特精確的PerfectBake烘焙感應器，烤箱能測量糕餅的濕度，進而自動調整熱度、時間與溫度。您只需要從選單中選出正確的食物類別，然後按下「啟動」鍵，烤箱就會為您完成其餘工作。成果：麵包、蛋糕或鹹派都能完美出爐。",
				"status"       =>	"on"
			));

			for ($j=2; $j <= 5 ; $j++) { 
				
				$p2_times = rand(2,4);
				for ($i=0; $i < $p2_times; $i++) { 
					$p2 = rand(1, 9);
					$layout = 12;
					if ($p2_times == 2) {
						$layout = 6;
					}else if ($p2_times == 3) {
						$layout = 4;
					}else if ($p2_times == 4) {
						$layout = 3;
					}
					$this->db->insert("event_prize", array(
						"event_id"     =>	$event['id'],
						"level"        =>	$j,
						"layout"       =>	$layout,
						"title"        =>	$prize[$p2][0],
						"worth"        =>	rand(1000, 10000),
						"cover"        =>	"uploads/demo/prize/".$prize[$p2][1],
						"quota"        =>	rand(1,500),
						"des"          =>	"不論是感恩節的火雞、復活節的羊肉或耶誕節的鮮魚，有了PerfectRoast三點探針，都可以準確完美烘烤肉類。高靈敏度的測量點能在烘烤時測量食物的核心溫度，而且精確度絲毫不差。無論您用的是烤箱、微波爐或蒸氣烤箱模式，每次都有完美的成果。<br><br>只要動動手指就能變身烘焙達人。<br><br>烘焙從未如此輕鬆簡單。有了我們獨特精確的PerfectBake烘焙感應器，烤箱能測量糕餅的濕度，進而自動調整熱度、時間與溫度。您只需要從選單中選出正確的食物類別，然後按下「啟動」鍵，烤箱就會為您完成其餘工作。成果：麵包、蛋糕或鹹派都能完美出爐。",
						"status"       =>	"on"
					));
				}
			}

			$p3 = rand(1, 9);
			for ($i=0; $i < rand(1,4)*4; $i++) { 
				$this->db->insert("event_prize", array(
					"event_id"     =>	$event['id'],
					"level"        =>	6,
					"layout"       =>	3,
					"title"        =>	$prize[$p3][0],
					"worth"        =>	rand(100, 1500),
					"cover"        =>	"uploads/demo/prize/".$prize[$p3][1],
					"quota"        =>	rand(50,1000),
					"des"          =>	"不論是感恩節的火雞、復活節的羊肉或耶誕節的鮮魚，有了PerfectRoast三點探針，都可以準確完美烘烤肉類。高靈敏度的測量點能在烘烤時測量食物的核心溫度，而且精確度絲毫不差。無論您用的是烤箱、微波爐或蒸氣烤箱模式，每次都有完美的成果。<br><br>只要動動手指就能變身烘焙達人。<br><br>烘焙從未如此輕鬆簡單。有了我們獨特精確的PerfectBake烘焙感應器，烤箱能測量糕餅的濕度，進而自動調整熱度、時間與溫度。您只需要從選單中選出正確的食物類別，然後按下「啟動」鍵，烤箱就會為您完成其餘工作。成果：麵包、蛋糕或鹹派都能完美出爐。",
					"status"       =>	"on"
				));
			}
		}
	}
	//test end

	// public function 

	public function event_unlock(){
		$user     = $this->check_user_token();
		$event_id = $this->post("event_id");
		$code     = $this->post("code");

		$this->output(TRUE, "已解鎖此活動", array(
			"redirect_url"	=>	$this->config->config['frontend_url']."wundoolottery/".$this->Base_model->custom_encrypt($event_id, "E")
		));
	}

	public function adv_coupon_take(){
		$user   = $this->check_user_token();
		$adv_id = $this->post("adv_id");

		$this->load->model("Adv_model");
		if ($this->Adv_model->check_is_take_coupon($adv_id, $user['id'])) $this->output(FALSE, "您已領取過此廣告的優惠券囉");

		$reward_title = "成功領取優惠券";
		$reward_icon = array(
			array(
				"type"	=>	"coupon",
				"cnt"	=>	1
			),
			array(
				"type"	=>	"sticket",
				"cnt"	=>	1
			)
		);
		$c = $this->Adv_model->take_coupon($adv_id, $user['id']);
		if ($c !== FALSE) {
			$this->User_model->user_reward($user['id'], 0, 0, 1);

			$reward = array(
				"title"     =>	$reward_title,
				"sub_title" =>	"",				
				"reward"    =>	$reward_icon
			);

			$this->output(TRUE, $reward_title, array(
				
			), $reward);	
		}else{
			$this->output(FALSE, "領取優惠券發生錯誤");
		}
	}

	public function adv_show(){
		$user   = $this->check_user_token();
		$adv_id = $this->post("adv_id");

		$this->load->model("Adv_model");
		$data = $this->Adv_model->get_data($adv_id);
		if ($data == null) $this->output(FALSE, "查無此廣告");

		$adv_coupon = $this->Adv_model->get_adv_coupon($adv_id, 'on', TRUE, $user['id']);
		$data['coupon'] = $adv_coupon['coupon'];

		$data['btns'] = array();
		$data['btns'] = array(
			"enabled" =>	($adv_coupon['user_take'])?FALSE:TRUE,
			"action"  =>	"take",
			"text"    =>	($adv_coupon['user_take'])?"已領取":"我要領取",
		);

		$this->Adv_model->adv_record($adv_id, $user['id']);

		$this->output(TRUE, "取得資料成功", array("data"=>$data));
	}

	public function search_article(){
		$user_id = FALSE;
		if ($this->input->post("token") && $this->input->post("token") != "") {
			$user_id = $this->check_user_token()['id'];
		}
		$type     = $this->post("type", "hot");
		$search   = $this->post("search", "");
		$page     = $this->post("page", 1);
		$order_by = $this->post("order_by", "publish_desc");

		$syntax = "P.is_delete = 0";
		$order_by = "P.offiicial_recommend DESC, P.viewed DESC, P.last_active_time DESC";

		if (strpos($order_by, "_") !== "FALSE") {
			$o = explode("_", $order_by);
			if ($o[0] == "hot") {
				$order_by = "P.viewed";
			}else{
				$order_by = "P.last_active_time";
			}
			if ($o[1] == "asc") {
				$order_by .= " ASC";
			}else{
				$order_by .= " DESC";
			}
		}

		if ($type == "search") {
			$syntax = "P.is_delete = 0";
			if ($search != "") {
				$search_field = ["P.title", "P.summary", "U.username", "U.nickname"];
				$search_syntax = "";
				foreach ($search_field as $field) {
					if ($search_syntax != "") $search_syntax .= " OR ";
					$search_syntax .= $field." LIKE '%{$search}%'";
				}
				$syntax .= " AND ({$search_syntax})";
			}
			// $order_by = "P.create_date DESC";
		}
		
		$data = $this->Post_model->get_list($user_id, $syntax, $page, $order_by);

		$this->output(TRUE, "取得資料成功", $data);
	}

	public function transaction_list(){
		$user  = $this->check_user_token(FALSE);
		$type  = $this->post("type", "depot");
		$page  = $this->post("page", 1);
		$year  = $this->post("year", date("Y"));
		$month = $this->post("month", date("m"));

		$data = array();

		for ($i=1; $i < 20; $i++) { 
			$payment = "";
			$cnt = "";
			if (rand(1,3) * $i % 3 == 0) {
				$payment = "<span style='color: #B6F;'>貝殼幣</span>";
				$cnt = "<span style='color: #F00;'>-1000</span>";
			}else if (rand(1,4) * $i % 3 == 0) {
				$payment = "<span style='color: #59F;'>信用卡</span>";
				$cnt = "<span style='color: #F00;'>-$1500</span>";
			}else{
				$payment = "<span style='color: #A33;'>部落幣</span>";
				$cnt = "<span style='color: #F00;'>-500</span>";
			}
			$data[] = array(
				"id"       =>	$i*rand(100,999),
				"datetime" =>	"2021-08-02",
				"classify" =>	"【倉庫】",
				"content"  =>	"贈送好友VIP會員資格x".rand(7, 31)."天",
				"payment"  =>	$payment,
				"cnt"      =>	$cnt
			);
		}
		

		$this->output(TRUE, "取得資料成功", array(
			"data"       =>	$data,
			"total_page" =>	3,
			"page"       =>	$page
		));
	}

	public function depot_coupon_use(){
		$user   = $this->check_user_token(FALSE);
		$id     = $this->post("id");

		if (substr($id, 0, 6) == 'coupon') {
			$this->load->model("Adv_model");
			if ($this->Adv_model->use_my_coupon(str_replace("coupon_", "", $id))) {
				$this->output(TRUE, "優惠券已使用");	
			}else{
				$this->output(FALSE, "此優惠券無法使用");	
			}
		}else{
			$this->output(FALSE, "查無此優惠券");
		}
	}

	public function depot_action(){
		$user   = $this->check_user_token(FALSE);
		$action = $this->post("action");
		$id     = $this->post("id");

		if ($action == 'use') {
			if (substr($id, 0, 6) == 'coupon') {
				$this->load->model("Adv_model");
				$data = $this->Adv_model->get_my_coupon_use(str_replace("coupon_", "", $id));
				$this->output(TRUE, "取得資料成功", $data);
			}else{
				$this->output(TRUE, "取得資料成功", array(
					"type"         =>	"url",
					"redirect_url" =>	$this->config->config['frontend_url']
				));
			}
		}else if($action == 'del'){
			$this->output(TRUE, "已成功刪除");
		}
		
	}

	public function exchange_gift_code(){
		$user = $this->check_user_token(FALSE);
		$code   = $this->post("code");

		$data = array(
			"cover"     =>	base_url()."assets/images/icon_bulletin.png",
			"id"        =>	"functioncard_1",
			"title"     =>	"部落大聲公",
			"sub_title" =>	"",
			"deadline"  =>	"領取期限：2021/8/31前",
			"cnt"       =>	50
		);

		$this->output(TRUE, "兌換禮物成功", array(
			"data"	=>	$data
		));
	}

	public function receive_my_gift(){
		$user = $this->check_user_token(FALSE);
		$id   = $this->post("id");

		$this->output(TRUE, "領取禮物成功");
	}

	public function my_receive_gift_box(){
		$user    = $this->check_user_token(FALSE);

		$data = array();
		$data[] = array(
			"cover"     =>	base_url()."assets/images/icon_bulletin.png",
			"id"        =>	"functioncard_1",
			"title"     =>	"部落大聲公",
			"sub_title" =>	"",
			"deadline"  =>	"領取期限：2021/8/31前",
			"cnt"       =>	50
		);
		$data[] = array(
			"cover"     =>	base_url()."assets/images/icon_bulletin.png",
			"id"        =>	"coupon_1",
			"title"     =>	"大杯冰美式買一送一",
			"sub_title" =>	"7-11全台店家",
			"deadline"  =>	"領取期限：2021/8/31前",
			"cnt"       =>	500
		);

		$this->output(TRUE, "取得資料成功", array(
			"data"	=>	$data
		));
	}

	public function present_gift_confirm(){
		$user    = $this->check_user_token(FALSE);
		$present_id = $this->post("present_id");

		$this->output(TRUE, "贈送成功");
	}

	public function present_gift(){
		$user    = $this->check_user_token(FALSE);
		$type    = $this->post("type");
		$id      = $this->post("id");
		$cnt     = $this->post("cnt");
		$friends = $this->post("friends");

		if ($type == 'function_card') {
			$this->output(TRUE, "取得資料成功", array(
				"is_pass"   =>	FALSE,
				"title"     =>	"部落幣不夠囉",
				"sub_title" =>	"您可以到「部落商店」購買更多部落幣"
			));
		}else{
			$this->output(TRUE, "取得資料成功", array(
				"present_id" =>	111,
				"is_pass"    =>	TRUE,
				"title"      =>	"確定是否贈送？",
				"data"       =>	array(
					"cover"     =>	base_url()."assets/images/icon_bulletin.png",
					"id"        =>	"functioncard_1",
					"title"     =>	"部落大聲公",
					"sub_title" =>	"贈送 6 位好友 剩餘 44"
				)
			));
		}
	}

	public function present_gift_detail(){
		$user = $this->check_user_token(FALSE);
		$type = $this->post("type");
		$id   = $this->post("id");

		$this->output(TRUE, "取得資料成功", array(
			"my_own"  =>	rand(25,70),
			"can_buy" =>	14,
			"data"    =>	array(
				"cover"     =>	base_url()."assets/images/icon_bulletin.png",
				"id"        =>	"functioncard_1",
				"title"     =>	"部落大聲公",
				"sub_title" =>	""
			)
		));
	}

	public function my_friend_list(){
		$user   = $this->check_user_token(FALSE);
		$page   = $this->post("page", 1);
		$search = $this->post("search", '');

		$data = $this->User_model->get_friends_detail($user['id'], $search, $page);
		$this->output(TRUE, "取得資料成功", $data);
	}

	public function my_depot(){
		$user    = $this->check_user_token();

		$data = array("data"=>array(), "menu"=>array(
			array(
				"id"      =>	"function_card",
				"title"   =>	"功能卡"
			),
			array(
				"id"      =>	"adv_plan",
				"title"   =>	"廣告方案"
			),
			array(
				"id"      =>	"coin", 
				"title"   =>	"戰利品"
			),
			array(
				"id"      =>	"coupon",
				"title"   =>	"商家優惠券"
			),
			array(
				"id"      =>	"sticker",
				"title"   =>	"貼圖"
			)
		));

		$data['data']['function_card'] = array();
		$data['data']['adv_plan'] = array();
		$data['data']['coin'] = array();
		$data['data']['gift'] = array();
		$data['data']['coupon'] = array();
		$data['data']['sticker'] = array();

		$data['data']['function_card'][] = array(
			"cover"     =>	base_url()."assets/images/icon_bulletin.png",
			"id"        =>	"functioncard_1",
			"title"     =>	"部落大聲公",
			"sub_title" =>	"",
			"des"       =>	"",
			"deadline"  =>	"",
			"cnt"       =>	50,
			"can_del"   =>	FALSE,
			"enabled"   =>	TRUE,
			"btns"      =>	array(
				array(
					"title"      =>	"贈送",
					"bg_color"   =>	"#036EB8",
					"text_color" =>	"#FFFFFF",
					"function"   =>	"gift"
				),
				array(
					"title"      =>	"使用1個",
					"bg_color"   =>	"#DC131A",
					"text_color" =>	"#FFFFFF",
					"function"   =>	"tribe"
				)
			)
		);

		$items = ["bticket", "sticket", "coin", "shell"];
		foreach ($items as $c) {
			if ($user[$c] > 0) {
				$data['data']['coin'][] = array(
					"cover"     =>	$this->Base_model->reward_image_path($c, FALSE),
					"id"        =>	"icon_".$c,
					"title"     =>	$this->Base_model->reward_title($c),
					"sub_title" =>	"",
					"des"       =>	"",
					"deadline"  =>	"",
					"cnt"       =>	intval($user[$c]),
					"can_del"   =>	FALSE,
					"enabled"   =>	TRUE,
					"btns"      =>	array()
				);
			}	
		}

		$this->load->model("Adv_model");
		$data['data']['coupon'] = $this->Adv_model->get_my_coupon($user['id']);

		$this->output(TRUE, "取得資料成功", $data);
	}

	public function shop_confirm(){
		$user     = $this->check_user_token();
		$id       = $this->post("id");
		
		$this->output(TRUE, "購買成功");
	}

	public function shop_action(){
		$user     = $this->check_user_token();
		$id       = $this->post("id");
		$function = $this->post("function");

		$selected_id = explode("_", $id);

		if ($function == 'cash') {
			$this->output(TRUE, "成功", array("data" => array(
				"action"       =>	"url",
				"redirect_url" =>	base_url()."pay"
			)));	
		}else{
			$data = array(
				"id"          =>	$id,
				"action"      =>	"modal",
				"modal_title" =>	"確定是否購買",
				"cover"        =>	base_url()."uploads/demo/cat_price.png",
				"title"       =>	"老牙大集合-各式心情節日用語",
				"sub_title"   =>	"溫度部落",
				"des"         =>	'<img src="'.base_url().'assets/images/icon_tribe.svg"> 使用部落幣 &nbsp;&nbsp;&nbsp;&nbsp; 1000 <span class="color:#F00;">→</span> 995'
			);
			$this->output(TRUE, "成功", array("data"=>$data));
		}
	}

	public function shop(){
		$user    = $this->check_user_token(FALSE);

		$data = array("data"=>array(), "menu"=>array(
			array(
				"id"	=>	"function_card",
				"title"	=>	"功能卡"
			),
			array(
				"id"	=>	"adv_plan",
				"title"	=>	"廣告方案"
			),
			array(
				"id"	=>	"tribe_coin",
				"title"	=>	"部落幣"
			),
			array(
				"id"	=>	"coupon",
				"title"	=>	"優惠券"
			),
			// array(
			// 	"id"	=>	"sticker",
			// 	"title"	=>	"貼圖"
			// )
		));

		$data['data']['function_card'] = array();
		$data['data']['adv_plan'] = array();
		$data['data']['tribe_coin'] = array();
		$data['data']['coupon'] = array();
		$data['data']['sticker'] = array();

		$data['data']['function_card'][] = array(
			"cover"        =>	base_url()."uploads/demo/cat_price.png",
			"id"           =>	"functioncard_1",
			"title"        =>	"老牙大集合-各式心情節日用語",
			"sub_title"    =>	"溫度部落",
			"price"        =>	'<img src="'.base_url().'assets/images/icon_tribe.svg"> 5',
			"extra_reward" =>	"",
			"des"          =>	"",
			"cnt"          =>	0,
			"btns"         =>	array(
				// array(
				// 	"title"      =>	"贈送",
				// 	"bg_color"   =>	"#036EB8",
				// 	"text_color" =>	"#FFFFFF",
				// 	"function"   =>	"gift"
				// ),
				array(
					"title"      =>	"購買",
					"bg_color"   =>	"#DC131A",
					"text_color" =>	"#FFFFFF",
					"function"   =>	"tribe"
				)
			)
		);

		$data['data']['tribe_coin'][] = array(
			"cover"        =>	base_url()."assets/images/icon_tribe.svg",
			"id"           =>	"tribecoin_1",
			"title"        =>	"部落幣9000個",
			"sub_title"    =>	"溫度部落",
			"price"        =>	'$80',
			"extra_reward" =>	"額外贈送：小糧券x100",
			"des"          =>	"功能：溫度部落流通貨幣",
			"cnt"          =>	9000,
			"btns"         =>	array(
				array(
					"title"      =>	"購買",
					"bg_color"   =>	"#DC131A",
					"text_color" =>	"#FFFFFF",
					"function"   =>	"cash"
				)
			)
		);

		$data['data']['function_card'][] = array(
			"cover"        =>	base_url()."uploads/demo/cat_price.png",
			"id"           =>	"coupon_1",
			"title"        =>	"大杯冰美式買一送一",
			"sub_title"    =>	"7-11全台店家",
			"price"        =>	'<img src="'.base_url().'assets/images/icon_tribe.svg"> 5 <small style="font-size:10px; color:#F00;">※限購買一次</small>',
			"extra_reward" =>	"額外贈送：小糧券x100",
			"des"          =>	"使用期限：2021/5/31前",
			"cnt"          =>	3000,
			"btns"         =>	array(
				array(
					"title"      =>	"購買",
					"bg_color"   =>	"#DC131A",
					"text_color" =>	"#FFFFFF",
					"function"   =>	"tribe"
				)
			)
		);

		$this->output(TRUE, "取得資料成功", $data);
	}

	

	public function homepage_data(){
		$user_id = FALSE;
		if ($this->input->post("token") && $this->input->post("token") != "") {
			$user_id = $this->check_user_token()['id'];
		}

		$banner = $this->Setting_model->banner_list("home_banner");
		//暫時的
		for ($i=0; $i < count($banner); $i++) { 
			$banner[$i]['thumb_url'] = $banner[$i]['thumb'];
			$banner[$i]['normal_url'] = $banner[$i]['path'];
			$banner[$i]['url'] = $banner[$i]['link'];
		}
		
		$this->load->model("Post_model");
		$this->load->model("Club_model");

		$syntax = $syntax = "P.is_delete = 0";
		$order_by = "P.offiicial_recommend DESC, P.viewed DESC, P.last_active_time DESC";
		$hot_article = array();
		foreach ($this->Post_model->get_list($user_id, $syntax, 1, $order_by, 12)['data'] as $item) {
			if($item['viewed'] >= 100){
				$item['badge'] = "熱門";
				$item['badge_bg'] = "#FF655B";
			}else if($item['offiicial_recommend'] == 1){
				$item['badge'] = "官方推薦";
				$item['badge_bg'] = "#FFA45B";
			}
			$hot_article[] = $item;
		}

		$syntax = $syntax = "(C.type = 'hobby') AND C.is_delete = 0 AND C.is_private = 0";
		$order_by = "C.is_recommend DESC, C.is_hot DESC, C.discuss_hot DESC, C.people DESC";
		$hot_huntground = array();
		foreach ($this->Club_model->get_club_list($user_id, $syntax, $order_by, '', 8)['data'] as $item) {
			if($item['is_hot'] == 1){
				$item['badge'] = "熱門";
				$item['badge_bg'] = "#FF655B";
			}else if($item['is_recommend'] == 1){
				$item['badge'] = "推薦";
				$item['badge_bg'] = "#FFA45B";
			}
			$hot_huntground[] = $item;
		}

		$syntax = "P.post_at = 'lottery' AND P.is_delete = 0";
		$order_by = "P.create_date DESC";
		$win_lottery = $this->Post_model->get_list($user_id, $syntax, 1, $order_by, 6)['data'];

		$this->output(TRUE, "取得資料成功", array(
			"banner"         =>	$banner,
			"hot_article"    =>	$hot_article,
			"hot_huntground" =>	$hot_huntground,
			"win_lottery"    =>	$win_lottery,
			"tv"             =>	array(
				"cover"	=>	base_url()."uploads/tv.png",
				"url"	=>	"https://www.youtube.com/embed/zBzBL1t6RC4"
			)
		));
	}

	public function leaderboard(){
		$type = $this->post("type", "");
		$user = FALSE;
		$data = array();
		if ($type != "") {
			$user = $this->check_user_token();
			$data = $this->Setting_model->leaderboard_list($user['tribe'], $type, $user);
			// $list = $this->db->select("*")
			// 				 ->from("user")
			// 				 ->where(array("tribe"=>$user['tribe']))
			// 				 ->order_by("RAND()")
			// 				 ->limit(100)
			// 				 ->get()->result_array();
			// if ($type == "elder") {
			// 	$value = $user['register_date'];
			// }else if ($type == "comment") {
			// 	$value = rand(1, 100);
			// }else if ($type == "post") {
			// 	$value = rand(1, 100);
			// }else if ($type == "kol") {
			// 	$value = rand(1, 1000);
			// }
			// $data = array("list"=>array(), "mine"=>array(
			// 	"user"  =>	$this->User_model->get_user_formatted($user['id'], $user),
			// 	"rank"  =>	rand(1,200),
			// 	"value" =>	$value
			// ));
			// foreach ($list as $rank => $u) {
			// 	if ($type == "elder") {
			// 		$value = $u['register_date'];
			// 	}else if ($type == "comment") {
			// 		$value = rand(1, 100);
			// 	}else if ($type == "post") {
			// 		$value = rand(1, 100);
			// 	}else if ($type == "kol") {
			// 		$value = rand(1, 1000);
			// 	}
			// 	$data['list'][] = array(
			// 		"user"	=>	$this->User_model->get_user_formatted($u['id'], $u),
			// 		"rank"	=>	($rank+1),
			// 		"value"	=>	$value
			// 	);
			// }
		}else{
			$data = $this->Setting_model->leaderboard();
		}

		$online_time = date("Y-m-d H:i:s", strtotime("- 5 minutes", strtotime(date("Y-m-d H:i:s"))));
		$this->output(TRUE, "取得資料成功", array(
			"data"        =>	$data,
			"total_post"  =>	intval($this->db->select("count(*) as cnt")->get_where("post", array("is_delete"=>0))->row()->cnt),
			"online_user" =>	intval($this->db->select("count(*) as cnt")->get_where("user", array("last_active_time>="=>$online_time))->row()->cnt)
		));
	}

	public function task_complete(){
		$user    = $this->check_user_token();
		$task_id = $this->post("task_id");

		

		if ($this->Task_model->complete_task($user['id'], $task_id, TRUE)) {
			$task = $this->Task_model->get_task($task_id);
			
			$point = $task['point'];
			$shell = $task['shell'];
			$sticket = $task['sticket'];
			$bticket = $task['bticket'];
			$tribe = $task['tribe'];

			$reward_title = "恭喜您順利完成任務";
			if ($point > 0)
				$reward_icon[] = array(
					"type"	=>	"point",
					"cnt"	=>	$point
				);
			if ($shell > 0)
				$reward_icon[] = array(
					"type"	=>	"shell",
					"cnt"	=>	$shell
				);
			if ($sticket > 0)
				$reward_icon[] = array(
					"type"	=>	"sticket",
					"cnt"	=>	$sticket
				);
			if ($bticket > 0)
				$reward_icon[] = array(
					"type"	=>	"bticket",
					"cnt"	=>	$bticket
				);
			if ($tribe > 0)
				$reward_icon[] = array(
					"type"	=>	"tribe",
					"cnt"	=>	$tribe
				);
			$this->User_model->user_reward($user['id'], $point, $shell, $sticket, $bticket, $tribe);

			$reward = array(
				"title"     =>	$reward_title,
				"sub_title" =>	"",				
				"reward"    =>	$reward_icon
			);

			$this->output(TRUE, "恭喜您順利完成任務", array(), $reward);	
		}else{
			$this->output(FALSE, "您尚未達成任務條件");
		}
	}

	public function task_list(){
		$user     = $this->check_user_token();

		
		$data = $this->Task_model->task_list($user['id']);

		$banner = $this->Setting_model->banner_list("task_banner");
		//暫時的
		for ($i=0; $i < count($banner); $i++) { 
			$banner[$i]['thumb_url'] = $banner[$i]['thumb'];
			$banner[$i]['normal_url'] = $banner[$i]['path'];
			$banner[$i]['url'] = $banner[$i]['link'];
		}

		$this->output(TRUE, "取得資料成功", array("data"=>$data, "banner"=>$banner));
	}

	private function task_format($id, $title, $percent, $reward, $btn_enable, $btn_text, $btn_action, $btn_action_value, $finished = FALSE){
		return array(
			"id"               =>	$id,
			"title"            =>	$title,
			"percent"          =>	$percent,
			"reward"           =>	$reward,
			"btn_enable"       =>	$btn_enable,
			"btn_text"         =>	$btn_text,
			"btn_action"       =>	$btn_action,
			"btn_action_value" =>	$btn_action_value,
			"finished"         =>	$finished,
		);
	}

	public function checkin_pad(){
		$user     = $this->check_user_token();

		
		$is_show = (!$this->Task_model->today_has_checking($user['id']));
		$data = array();
		$extra_reward = array();

		$reward = FALSE;
		if ($is_show) {
			$today_checkin = $this->Task_model->user_checking_reward($user['id']);
			$data =	$today_checkin['data'];
			$extra_reward =	$today_checkin['extra'];
			$reward = $today_checkin['reward'];
		}

		$this->output(TRUE, "取得資料成功", array(
			"banner"       => 	$this->Setting_model->banner_list("checkin_pad"),
			"is_show"      =>	$is_show,
			"data"         =>	$data,
			"extra_reward" =>	$extra_reward
		), $reward);
	}

	public function homepage_daily_task(){
		$user_id = FALSE;
		if ($this->input->post("token") && $this->input->post("token")) {
			$user = $this->check_user_token();
			$user_id = $user['id'];
		}
		
		$task_id = 1;

		$syntax = "P.post_at = 'day' AND P.is_delete = 0 AND P.relation_id = '{$task_id}'";

		$order_by = "P.create_date DESC";
		$post = $this->Post_model->get_list($user_id, $syntax, 1, $order_by, 100);

		$iam_participated = FALSE;
		//anbon
		if (rand(1,100) % 3 == 0) $iam_participated = TRUE;

		$this->output(TRUE, "取得資料成功", array(
			"task_id"          =>	$task_id,
			"title"            =>	"南北粽大對抗",
			"data"             =>	$post['data'],
			"iam_participated" =>	$iam_participated
		));
	}

	public function daily_task(){
		$user     = $this->check_user_token();

		$task_id = 1;

		$data = array(
			"id"	 =>	$task_id,
			"cover"  =>	"https://web.wundoo.com.tw/img/nav_banner.327c2151.png",
			"title"  =>	"南北粽大對抗",
			"des"    =>	"【活動日期】2020.8.8 - 8.31 (滿額即結束)<br><br>【活動辦法】每日來此活動頁面發文，即可獲取好康獎勵！(每人只能參與一次)<br><br>【活動獎勵】每日發文成功，即可領取貝殼幣x100個。<br><br>【活動人數】限 1000 人參與(滿額即結束)。<br><br>【注意事項】<br><br><ol><li>每人每天限領取一次。</li><li>每日發文完畢系統將會於24小時內發放。</li><li>之後若想看曾參與的文章請至：會員中心>我的日記查看。</li><li>有任何問題歡迎來信：a123@gmail.com</li></ol>",
			"reward" =>	array(
				"type"	=>	"shell",
				"cnt"	=>	100,
				"title" =>	"蹭溫度發文成功：<br>獲得貝殼幣 x 100個",
				"icon"	=>	base_url()."assets/images/icon_shell.svg"
			)
		);


		$syntax = "P.post_at = 'day' AND P.is_delete = 0 AND P.relation_id = '{$task_id}'";

		$order_by = "P.create_date DESC";
		$post = $this->Post_model->get_list($user['id'], $syntax, 1, $order_by, 15);

		$this->output(TRUE, "取得資料成功", array(
			"data"	=>	$data,
			"post"	=>	$post
		));
	}

	public function event_winner_post_list(){
		$user     = $this->check_user_token();
		$event_id = $this->post("event_id", 0);
		$search   = $this->post("search", "");
		$page     = $this->post("page", 1);

		$syntax = "P.post_at = 'lottery' AND P.is_delete = 0";
		if ($event_id != 0) {
			$syntax .= " AND P.relation_id = '{$event_id}'";
		}

		if ($search != "") {
			$search_field = ["P.title", "P.summary", "U.username", "U.nickname"];
			$search_syntax = "";
			foreach ($search_field as $field) {
				if ($search_syntax != "") $search_syntax .= " OR ";
				$search_syntax .= $field." LIKE '%{$search}%'";
			}
			$syntax .= " AND ({$search_syntax})";
		}

		$order_by = "P.create_date DESC";
		$data = $this->Post_model->get_list($user['id'], $syntax, $page, $order_by);

		$this->output(TRUE, "取得資料成功", $data);
	}

	public function get_event_post_options(){
		$user = $this->check_user_token();
		$this->load->model("Event_model");

		$data = $this->Event_model->get_event_with_prize();

		//安邦 尚未完成
		$selected = array(
			"event_id"	=>	(count($data) > 0)?$data[0]['id']:0,
			"prize_id"	=>	(count($data) > 0)?$data[0]['prize'][0]['id']:0
		);

		$this->output(TRUE, "取得資料成功", array(
			"data"     =>	$data,
			"selected" =>	$selected
		));
	}

	public function share_event_winner(){
		$user        = $this->check_user_token();
		$event_id    = $this->post("event_id");

		//安邦 尚未完成

		$this->output(TRUE, "取得資料成功", array(
			"title"	=>	"恭喜獲得個人投入抽獎券50%<br>小糧券 2500張",
			"des"	=>	"本期抽獎您總共投入<br>大獵券 1張 小糧券 5000張<br>快去「<a href='".$this->config->config['frontend_url']."membercenter'>會員中心</a>」查看"
		));
	}

	public function event_winners(){
		$user        = $this->check_user_token(FALSE);
		$event_id    = $this->post("event_id");
		$prize_level = $this->post("prize_level", 'all');

		$this->load->model("Event_model");

		$is_drawn = TRUE;
		$winners = array();
		if ($is_drawn) {
			$winners['des'] = '已寄出得獎確認信於得獎者註冊的Email，若1/17(日)前尚未回信，視同放棄領獎資格。';
			$winners['prize'] = $this->Event_model->get_event_winners($event_id, $prize_level, $user['id']);
		}else{
			$this->output(FALSE, "尚未開獎");
		}

		$this->output(TRUE, "取得資料成功", array(
			"data"	=>	$winners
		));
	}

	public function join_lottery(){
		$user        = $this->check_user_token();
		$event_id    = $this->post("event_id");
		$prize_level = $this->post("prize_level");
		$ticket_type = $this->post("ticket_type", 'sticket');

		$this->load->model("Event_model");
		$data = $this->Event_model->get_data($event_id);
		if ($data['is_expired'] == 1) $this->output(FALSE, "此活動已截止");

		$prize = $this->Event_model->get_prize($event_id, $prize_level);

		$ticket_type = ($ticket_type == "sticket")?"sticket":"bticket";
		if ( $user[$ticket_type] - $prize[$ticket_type] < 0) $this->output(FALSE, "您的抽獎券數量不足");

		$data = array(
			"user_id"     =>	$user['id'],
			"event_id"    =>	$event_id,
			"prize_level" =>	$prize_level,
			"ticket_type" =>	($ticket_type=='sticket')?'s':'b',
			"cnt"         =>	$prize[$ticket_type]
		);

		if ($this->Event_model->join_lottery($data)) {
			$remaining_cnt = $user[$ticket_type] - $prize[$ticket_type];
			$this->User_model->edit($user['id'], array($ticket_type=>$remaining_cnt));
			$this->output(TRUE, "成功參與抽獎");
		}else{
			$this->output(FALSE, "發生問題");
		}
	}

	public function adv_chart(){
		$user   = $this->check_user_token();
		$adv_id = $this->post("adv_id");
		$year   = $this->post("year", "");
		$month  = $this->post("month", "");

		$show_month = $this->post("show_month", "");
		if ($show_month == "") {
			if ($year == '') $year = date("Y");
			if ($month == '') $month = date("m");
			$month = str_pad(intval($month), 2, '0', STR_PAD_LEFT);
			$show_month = $year."-".$month;
		}
		$year = substr($show_month, 0, 4);
		$month = substr($show_month, 5, 2);

		$dates = array();
		$visits = array();
		$times = array();
		for ($i=1; $i <= date('t', strtotime($year."-".$month."-01")) ; $i++) { 
			$dates[] = $month."/".$i;
			$visits[] = rand(100, 15000);
			$times[] = rand(100,10000);
		}
		$data = array(
			"linechart"	=>	array(
				"browse"    =>	"12650",
				"CouponUse" =>	"60",
				"xaxis"     =>	array(
					"categories"	=>	$dates
				),
				"yaxis"		=>	array(
					array(
						"name"	=>	"總瀏覽量",
						"data"	=>	$visits
					),
					array(
						"name"	=>	"優惠券使用次數",
						"data"	=>	$times
					)
				)
			),
			"coupon"	=>	array(
				array(
					"title"      =>	"買一送一",
					"percent"    =>	"70",
					"series"	 =>	array(70),
					"couponNum"  =>	"200",
					"totalUsage" =>	"170"	
				),
				array(
					"title"      =>	"第二件7折",
					"percent"    =>	"30",
					"series"	 =>	array(30),
					"couponNum"  =>	"100",
					"totalUsage" =>	"30"	
				)
			)
		);

		$first_datetime = "2021-04-01";
		$first_year = date("Y", strtotime($first_datetime));
		$first_month = date("m", strtotime($first_datetime));

		$has_pre_month = FALSE;
		$pre_month = "";
		$pre_year = $year;
		$pre_month = intval($month) - 1;
		if ($pre_month < 0) {
			$pre_month = 12;
			$pre_year --;
		}
		if (strtotime($pre_year."-".str_pad($pre_month, 2, '0', STR_PAD_LEFT)."-01") >= strtotime($first_year."-".$first_month."-01")) {
			$pre_month = $pre_year."-".str_pad($pre_month, 2, '0', STR_PAD_LEFT);
			$has_pre_month = TRUE;
		}else{
			$pre_month = "";
		}

		$has_next_month = FALSE;
		$next_month = "";
		$next_year = $year;
		$next_month = intval($month) + 1;
		if ($next_month > 12) {
			$next_month = 1;
			$next_year++;
		}
		if (strtotime($next_year."-".str_pad($next_month, 2, '0', STR_PAD_LEFT)."-01") <= strtotime(date("Y-m-d"))) {
			$next_month = $next_year."-".str_pad($next_month, 2, '0', STR_PAD_LEFT);
			$has_next_month = TRUE;
		}else{
			$next_month = "";
		}

		$show_current_month = $year."年".$month."月";

		$data['has_pre_month'] = $has_pre_month;
		$data['has_next_month'] = $has_next_month;
		$data['pre_month'] = $pre_month;
		$data['next_month'] = $next_month;
		$data['current_month'] = $show_month;
		$data['show_current_month'] = $show_current_month;

		$this->output(TRUE, "取得資料成功", array("data"=>$data));
	}

	public function event_detail(){
		$user     = $this->check_user_token(FALSE);
		$event_id = $this->post("event_id");

		if (!is_numeric($event_id)) $event_id = $this->Base_model->custom_encrypt($event_id, 'D');

		$this->load->model("Event_model");
		$data = $this->Event_model->get_data($event_id);
		$prize = $this->Event_model->get_prize_list($event_id, $user['id']);

		$is_drawn = $data['is_drawn'];

		$this->output(TRUE, "取得資料成功", array(
			"is_drawn" =>	$is_drawn,
			"data"     =>	$data,
			"prize"    =>	$prize,
		));
	}

	public function event_list(){
		$user       = $this->check_user_token(FALSE);
		$is_expired = $this->post("is_expired", 0);
		$page       = $this->post("page", 1);
		$show_month = $this->post("show_month", "");

		$this->load->model("Event_model");

		if ($is_expired == 1) {
			$mont_1 = date("Y-m");
			$mont_2 = date("Y-m", strtotime("+ 1 month", strtotime(date("Y-m-d"))));
			if ($show_month != "" && substr($show_month, 4, 1) == "-") {
				if (intval(date("m", strtotime($show_month."-01"))) % 2 == 0) {
					$mont_1 = date("Y-m", strtotime("- 1 month", strtotime($show_month."-01")));
					$mont_2 = $show_month;
				}else{
					$mont_1 = $show_month;
					$mont_2 = date("Y-m", strtotime("+ 1 month", strtotime($show_month)));
				}
			}else{
				if (intval(date("m")) % 2 == 0) {
					$mont_1 = date("Y-m", strtotime("- 1 month", strtotime(date("Y-m-d"))));
					$mont_2 = date("Y-m");
				}
			}
			$syntax = "is_delete = 0 AND is_expired = 1 AND (start_datetime LIKE '".$mont_1."%' OR start_datetime LIKE '".$mont_2."%' OR end_datetime LIKE '".$mont_1."%' OR end_datetime LIKE '".$mont_2."%')";
			$order_by = 'create_date desc';
			$data = $this->Event_model->get_list($syntax, $order_by, $page, 6);

			$first = $this->Event_model->get_first_event();

			$first_year = date("Y", strtotime($first['start_datetime']));
			$first_month = date("m", strtotime($first['start_datetime']));
			if ($first_month % 2 == 0) {
				$first_month = date("m", strtotime("- 1 month", strtotime($first['start_datetime'])));
			}

			$has_pre_month = FALSE;
			$pre_month = "";
			$pre_year = date("Y", strtotime($mont_1));
			$pre_month = intval(date("m", strtotime($mont_1))) - 2;
			if ($pre_month < 0) {
				$pre_month = 11;
				$pre_year --;
			}
			if (strtotime($pre_year."-".str_pad($pre_month, 2, '0', STR_PAD_LEFT)."-01") >= strtotime($first_year."-".$first_month."-01")) {
				$pre_month = $pre_year."-".str_pad($pre_month, 2, '0', STR_PAD_LEFT);
				$has_pre_month = TRUE;
			}else{
				$pre_month = "";
			}

			$has_next_month = FALSE;
			$next_month = "";
			$next_year = date("Y", strtotime($mont_1));
			$next_month = intval(date("m", strtotime($mont_1))) + 2;
			if ($next_month > 12) {
				$next_month = 1;
				$next_year++;
			}
			if (strtotime($next_year."-".str_pad($next_month, 2, '0', STR_PAD_LEFT)."-01") <= strtotime(date("Y-m-d"))) {
				$next_month = $next_year."-".str_pad($next_month, 2, '0', STR_PAD_LEFT);
				$has_next_month = TRUE;
			}else{
				$next_month = "";
			}

			$year = date("Y", strtotime($mont_1."-01"));
			$month = date("m", strtotime($mont_1."-01"));
			$show_current_month = $year."年".$month."-".str_pad((intval($month)+1), 2, '0', STR_PAD_LEFT)."月";

			$data['has_pre_month'] = $has_pre_month;
			$data['has_next_month'] = $has_next_month;
			$data['pre_month'] = $pre_month;
			$data['next_month'] = $next_month;
			$data['current_month'] = $mont_1;
			$data['show_current_month'] = $show_current_month;
			
			$this->output(TRUE, "取得資料成功", $data);			
		}else{
			$normal_syntax = "is_delete = 0 AND is_expired = 0 AND type = 'normal'";
			$normal_event = $this->Event_model->get_list($normal_syntax);

			$case_syntax = "is_delete = 0 AND is_expired = 0 AND type = 'case'";
			$case_event = $this->Event_model->get_list($case_syntax);
			
			$this->output(TRUE, "取得資料成功", array(
				"normal_event"	=>	$normal_event['data'],
				"case_event"	=>	$case_event
			));
		}
	}

	public function all_notification_read(){
		$user = $this->check_user_token();

		$this->load->model("Notification_model");
		if ($this->Notification_model->all_data_read($user['id'])) {
			$this->output(TRUE, "所有通知已讀");
		}else{
			$this->output(FALSE, "已讀動作發生錯誤");
		}
	}

	public function notifiaction_list(){
		$user = $this->check_user_token();
		$page = $this->post("page", 1);
		$classify = $this->post("classify", 'all');

		$this->load->model("Notification_model");
		$data = $this->Notification_model->get_list($user['id'], $page, 20, $classify);
		$this->output(TRUE, "取得資料成功", $data);
	}

	public function has_unread_notification(){
		$user = $this->check_user_token();

		$this->load->model("Notification_model");
		$this->output(TRUE, "取得資料成功", array(
			"has_unread"	=>	$this->Notification_model->has_notification_unread($user['id'])
		));
	}

	public function bulletin_list(){
		// $user = $this->check_user_token();
		$page = $this->post("page");

		$data = $this->Setting_model->get_bulletin_list($page);

		$this->output(TRUE, "取得資料成功", $data);
	}

	public function publish_bulletin(){
		$user     = $this->check_user_token();
		$content  = $this->post("content");
		$reply_to = $this->post("reply_to", 0);

		$data = array(
			"user_id"  =>	$user['id'],
			"type"     =>	"user",
			"reply_to" =>	$reply_to,
			"content"  =>	$content
		);

		$id = $this->Setting_model->add_bulletin($data);
		if ($id !== FALSE) {
			if ($reply_to > 0) {
				$bulletin = $this->Setting_model->get_bulletin($reply_to);
				if ($bulletin['user_id'] != $user['id']) {
					$preview_content = $content;
					if (mb_strlen($preview_content) > 15) $preview_content = mb_substr(strip_tags($preview_content), 0, 14)."..";
					$this->Notification_model->add_data($bulletin['user_id'], 'reply_bulletin', $user['id'], $id, $preview_content);	
				}
			}

			
			$this->Task_model->complete_task($user['id'], 5);

			$point = 10;
			$shell = rand(100, 1000);
			$reward_title = "發佈大聲公獎勵";
			$reward_sub_title = "您使用了一次大聲公，可獲得獎勵：";
			$reward_icon = array(
				array(
					"type"	=>	"point",
					"cnt"	=>	$point
				),
				array(
					"type"	=>	"shell",
					"cnt"	=>	$shell
				)
			);
			$this->User_model->user_reward($user['id'], $point, $shell);

			$reward = array(
				"title"     =>	$reward_title,
				"sub_title" =>	$reward_sub_title,				
				"reward"    =>	$reward_icon
			);
			$this->output(TRUE, "成功發送大聲公", array("bulletin_id"=>$id), $reward);
		}else{
			$this->output(FALSE, "發送大聲公發生錯誤");
		}
	}
	public function check_exist_bulletin_ticket(){
		$user = $this->check_user_token();

		//安邦 未完成
		$this->output(TRUE, "取得資料成功", array(
			"enable"	=>	TRUE
		));		
	}

	public function adv_action(){
		//安邦 未完成

		$user   = $this->check_user_token();
		$adv_id = $this->post("adv_id");
		$action = $this->post("action");
		$this->load->model("Adv_model");

		$status = FALSE;
		$msg = "";
		switch ($action) {
			case 'del':{
				$status = $this->Adv_model->del($adv_id);
				if ($status) {
					$msg = "廣告刪除成功";
				}else{
					$msg = "廣告刪除發生問題";
				}
			}
				break;
			case 'on_shelf':{

			}	
				break;
			case 'off_shelf':{

			}	
				break;
			case 'duplicate':{

			}	
				break;
		}

		$this->output($status, $msg);
	}

	public function get_my_adv_list(){
		$user = $this->check_user_token();
		$page = $this->post("page", 1);
		$this->load->model("Adv_model");

		$order_by = "create_date DESC";
		$syntax = "user_id = '".$user['id']."' AND is_delete = 0";
		$list = $this->Adv_model->get_list($syntax, $order_by, $page);

		$data = array();
		foreach ($list['list'] as $item) {
			$sub_title = "";
			foreach ($this->Adv_model->get_adv_explosure_club($item['id']) as $c) {
				if ($sub_title != "") $sub_title .= ", ";
				$sub_title .= $c['show_name'];
			}
			$status = "";
			$status_str = "";
			$button_edit = FALSE;
			$button_edit_confirm = "";
			$butotn_del = FALSE;
			$butotn_del_confirm = "";
			$button_on = FALSE;
			$button_on_confirm = "";
			$butotn_off = FALSE;
			$butotn_off_confirm = "";
			$button_addon = FALSE;
			$button_addon_confirm = "";
			$button_duplicate = FALSE;

			if ($item['is_pay'] == 1) {
				$button_duplicate = TRUE;
				if ($item['status'] == "publish") {
					$status = "publish";
					$status_str = "<span class='text-success'>【上架中】</span>";
					$butotn_off = TRUE;
					$butotn_off_confirm = "下架後，剩餘可刊登日數: ".$item['remaining_days']."日";
					$button_addon = TRUE;
				}else if ($item['status'] == "schedule") {
					$status = "schedule";
					$status_str = "<span class='text-primary'>【排程中】</span>";
					$butotn_off = TRUE;
				}else if ($item['status'] == "draft") {
					$status = "pending";
					$status_str = "<span class='text-warning'>【等待上架】</span>";
					$button_edit = TRUE;
					$button_on = TRUE;
				}
			}else{
				$status = "pending";
				$status_str = "<span class='text-danger'>【尚未付款】</span>";
				$button_edit = TRUE;
				$butotn_del = TRUE;
			}

			$data[] = array(
				"id"             =>	$item['id'],
				"title"          =>	$item['title'],
				"sub_title"      =>	$sub_title,
				"price"          =>	$item['price'],
				"create_date"    =>	$item['create_date'],
				"days"           =>	$item['days'],
				"remaining_days" =>	$item['remaining_days'],
				"status"         =>	$status,
				"status_str"     =>	$status_str,
				"btns"           =>	array(
					"edit"     =>	array(
						"enable"       =>	$button_edit,
						"confirm_text" =>	$button_edit_confirm
					),
					"del"      =>	array(
						"enable"       =>	$butotn_del,
						"confirm_text" =>	$butotn_del_confirm
					),
					"on_shelf"  =>	array(
						"enable"       =>	$button_on,
						"confirm_text" =>	$button_on_confirm
					),
					"off_shelf" =>	array(
						"enable"       =>	$butotn_off,
						"confirm_text" =>	$butotn_off_confirm
					),
					"addon"    =>	array(
						"enable"       =>	$button_addon,
						"confirm_text" =>	$button_addon_confirm
					),
					"duplicate"=>	array(
						"enable"       =>	$button_duplicate,
						"confirm_text" =>	""
					),
				)
			);
		}

		$this->output(TRUE, "取得資料成功", array("data"=>$data));
	}

	public function get_adv_common_store(){
		$user         = $this->check_user_token();
		$this->load->model("Adv_model");
		$data = $this->Adv_model->get_common_store($user['id']);
		$city = $this->get_zipcode()['city'];
		foreach ($data as $index => $item) {
			$dist_index = array_search($item['dist'], array_column($city[$item['city']]['dist'], 'c3'));
			$data[$index]['dist_str'] = $city[$item['city']]['dist'][$dist_index]['name'];
		}
		$this->output(TRUE, "取得資料成功", array("data"=>$data));
	}

	public function adv_promote_code_check(){
		$user         = $this->check_user_token();
		$promote_code = $this->post("promote_code");
		$this->load->model("Adv_model");

		$data = $this->Adv_model->check_promote_code($promote_code);
		$this->output($data['status'], $data['msg'], array("data"=>$data['data']));
	}

	public function adv_detail(){
		$user   = $this->check_user_token();
		$adv_id = $this->post("adv_id");

		$this->load->model("Adv_model");
		$data = $this->Adv_model->get_data($adv_id);
		if ($data == null) $this->output(FALSE, "查無此廣告");

		$data['coupon'] = $this->Adv_model->get_adv_coupon($adv_id, 'on');
		$data['explosure_club'] = $this->Adv_model->get_adv_explosure_club($adv_id);
		$data['adv_classify'] = $this->Adv_model->get_selected_adv_classify($adv_id);

		if ($data['addon_time'] > 0) {
			$a = $this->Adv_model->get_adv_addon('time', $data['addon_time']);
			$data['addon_time_data'] = $a;
		}else{
			$data['addon_time_data'] = array();
		}
		if ($data['addon_sort'] > 0) {
			$a = $this->Adv_model->get_adv_addon('sort', $data['addon_sort']);
			$data['addon_sort_data'] = $a;
		}else{
			$data['addon_sort_data'] = array();
		}

		$plan = $this->Adv_model->get_plan(TRUE);
		$plan_id = array_search($data['plan_id'], array_column($plan, 'id'));
		$data['plan'] = $plan[$plan_id];

		$this->output(TRUE, "取得資料成功", array("data"=>$data));
	}

	public function bill_check(){
		$user     = $this->check_user_token();
		$order_no = $this->post("order_no");

		$this->load->model("Order_model");
		$data = $this->Order_model->get_data_by_order_no($order_no);

		if ($data == null) $this->output(FALSE, "查無此訂單");
		$this->output(TRUE, "取得資料成功", array(
			"payment_status"         =>	$data['status'],
			"payment_type"   =>	$data['payment_type'],
			"payment_amount" =>	$data['payment_amount'],
			"expired_date"   =>	$data['expired_date'],
			"bank_code"      =>	$data['bank_code'],
			"code_no"        =>	$data['code_no'],
			"pay_msg"        =>	$data['pay_msg']
		));
	}

	public function save_adv(){
		$user   = $this->check_user_token();
		$adv_id = $this->post("adv_id");

		$this->load->model("Adv_model");
		$data = array();

		$fields = ["club_id","type","title","content","city","dist","store_name","business_hour","web_url","store_intro","click_give"];
		foreach ($fields as $field) {
			$value = $this->post($field, "");
			if (!is_null($field) && $value != "") $data[$field] = $value;
		}

		$is_coupon = $this->post("is_coupon");
		if (!is_null($is_coupon)) $data['is_coupon'] = ($is_coupon=="1")?1:0;

		$data['user_id'] = $user['id'];
		$data['status'] = 'draft';
		$data['is_pay'] = 0;
		$data['days'] = 7;

		$video_url = $this->post("video_url");
		if (!is_null($video_url) && $video_url != "") {
			$data['media_type'] = "video";
			$data['video_url'] = $video_url;
		}

		$plan_id     = $this->post("plan_id");
		$plan_option = $this->post("plan_option");
		if (!is_null($plan_id) && $plan_id != "") {
			$plan = $this->Adv_model->get_plan();
			if (!array_key_exists($plan_id, $plan)) $this->output(FALSE, "請選擇購買方案");
			$data['plan_id'] = $plan_id;
			$data['plan_option'] = $plan_option;
			$data['layout'] = $plan[$plan_id]['layout'];
			$data['sticket_cnt'] = $plan[$plan_id]['sticket'];
		}

		$cover_img = $this->post("cover_img");
		if (!is_null($cover_img) && $cover_img != "") {
			$data['cover'] = $cover_img;
		}
		
		$cover_title = $this->post("cover_title");
		$cover_bg_1  = $this->post("cover_bg_1");
		$cover_bg_2  = $this->post("cover_bg_2");
		if (!is_null($cover_title) && $cover_title != "" && $cover_bg_1 != "" && $cover_bg_2 != "") {
			$this->load->model("Pic_model");
			$bgs = array($cover_bg_1, $cover_bg_1, $cover_bg_2, $cover_bg_2);
			$data['cover'] = $this->Pic_model->generate_image($plan[$plan_id]['size_w'], $plan[$plan_id]['size_h'], $cover_title, $bgs);
		}

		$addon_time = $this->post("addon_time");
		$addon_sort = $this->post("addon_sort");
		if (!is_null($addon_time) && $addon_time != "" && $addon_time != "0") $data['addon_time'] = $addon_time;
		if (!is_null($addon_sort) && $addon_sort != "" && $addon_sort != "0") $data['addon_sort'] = $addon_sort;

		$store_type = $this->post("store_type");
		$city       = $this->post("city");
		$dist       = $this->post("dist");
		if (!is_null($store_type)) {
			$data['store_type'] = $store_type;
			if ($store_type == 'chain') {
			$data['dist_str'] = '連鎖店';
			}else if ($store_type == 'single') {
				$c = $this->get_zipcode()['city'];
				$dist_index = array_search($dist, array_column($c[$city]['dist'], 'c3'));
				if ($dist_index !== FALSE) {
					$data['dist_str'] = $c[$city]['dist'][$dist_index]['name'];
				}
			}
		}

		if (!is_null($adv_id) && $adv_id > 0) {
			$this->Adv_model->edit($adv_id, $data);
		}else{
			$adv_id = $this->Adv_model->add($data);	
		}
		
		if ($adv_id !== FALSE) {
			$adv = $this->Adv_model->get_data($adv_id);

			$store_add_to_common = $this->post("store_add_to_common");
			if (!is_null($store_add_to_common) && $store_add_to_common == 1) {
				//加入常用，要標記是哪一個廣告
				$this->Adv_model->update_common_store($adv_id, array(
					"user_id"       =>	$user['id'],
					"store_name"    =>	$data['store_name'],
					"store_type"    =>	$data['store_type'],
					"city"          =>	$data['city'],
					"dist"          =>	$data['dist'],
					"business_hour" =>	$data['business_hour'],
					"web_url"       =>	$data['web_url'],
					"store_intro"   =>	$data['store_intro']
				));
			}

			$coupon = $this->post("coupon");
			if ($adv['is_coupon'] == 1 && !is_null($coupon)) {
				$coupon = json_decode($coupon, TRUE);
				if (is_array($coupon) && count($coupon) > 0) {
					$this->Adv_model->update_adv_coupon($adv_id, $coupon, TRUE);
				}
			}
				

			$explosure_club = $this->post("explosure_club");
			if (!is_null($explosure_club)) {
				$explosure_club = ($explosure_club!="")?json_decode($explosure_club, TRUE):array();
				if (count($explosure_club) > 0) {
					$this->Adv_model->update_adv_explosure_club($adv_id, $explosure_club);
				}	
			}

			$adv_classify = $this->post("adv_classify");
			if (!is_null($adv_classify)) {
				$adv_classify = ($adv_classify!="")?json_decode($adv_classify, TRUE):array();
				if (count($adv_classify) > 0) {
					$this->Adv_model->update_adv_classify($adv_id, $adv_classify);
				}
			}
		
			$payment      = $this->post("payment");
			$invoice_type = $this->post("invoice_type");
			$tax_id       = $this->post("tax_id");
			$company_name = $this->post("company_name");
			$total_price  = $this->post("total_price");

			if (!is_null($payment) && $payment != "" && !is_null($total_price) && $total_price != "") {
				$this->load->model("Order_model");
				
				$plan = $this->Adv_model->get_plan();
				if (!array_key_exists($adv['plan_id'], $plan)) $this->output(FALSE, "請選擇方案");
				if (!array_key_exists($adv['plan_option'], $plan[$adv['plan_id']]['option'])) $this->output(FALSE, "請選擇方案項目");
				$cal_price = intval($plan[$adv['plan_id']]['option'][$adv['plan_option']]['price']);

				if ($adv['addon_time'] > 0) {
					$a = $this->Adv_model->get_adv_addon('time', $adv['addon_time']);
					$cal_price += intval($a['price']);

					$data['days'] += $a['value'];
				}
				if ($adv['addon_sort'] > 0) {
					$a = $this->Adv_model->get_adv_addon('sort', $adv['addon_sort']);
					$cal_price += intval($a['price']);
				}

				$explosure_club = $this->Adv_model->get_adv_explosure_club($adv_id);
				$cal_price += 500 * (count($explosure_club) - 1);

				$promote_code = $this->post("promote_code");
				$discount_price = 0;
				if (!is_null($promote_code) && $promote_code != "" && $promote_code != "0") {
					//折扣
					$p = $this->Adv_model->check_promote_code($promote_code);
					if (!$p['status']) $this->output($p['status'], $p['msg']);
					if ($p['type'] == 'number') {
						$discount_price = $p['discount'];
						$cal_price -= $discount_price;
					}else{
						$price_after_discount = round($cal_price * $p['discount']);
						$discount_price = $cal_price - $price_after_discount;
						$cal_price = $price_after_discount;
					}
				}
				if ($cal_price - $discount_price != $total_price) $this->output(FALSE, "金額計算錯誤，請重新下單[".$cal_price.", ".$discount_price."]");

				//最後更新
				$data['remaining_days'] = $data['days'];
				$this->Adv_model->edit($adv_id, $data);

				$order_id = $this->Order_model->check_exist('adv', $adv_id);
				$res = FALSE;
				$order_data = array(
					"cal_price"       =>	$cal_price,
					"promote_code"    =>	$promote_code,
					"payment_amount"  =>	$total_price,
					"invoice_type"    =>	$invoice_type,
					"invoice_uid"     =>	$tax_id,
					"invoice_company" =>	$company_name,
					"payment_type"    =>	$payment,
				);
				$order_no = "";
				if ($order_id !== FALSE) {
					$res = $this->Order_model->edit($order_id, $order_data);
					$d = $this->Order_model->get_data($order_id);
					if ($d != null) $order_no = $d['order_no'];
				}else{
					$order_no = date("ymdHi").rand(100,999);
					$order_data['order_no'] = $order_no;
					$order_data['user_id'] = $user['id'];
					$order_data['type'] = 'adv';
					$order_data['relation_id'] = $adv_id;
					$order_data['status'] = 'pending';
					
					$res = $this->Order_model->add($order_data);
				}

				if ($res !== FALSE && $order_no != "") {
					$this->output(TRUE, "建立訂單成功，即將導向付款頁面", array(
						"adv_id"       =>	$adv_id,
						"redirect_url" =>	base_url()."pay/bill/".$order_no,
						"cover"        =>	base_url().$adv['cover']
					));
				}else{
					$this->output(FALSE, "建立廣告發生錯誤");
				}
			}else{
				$this->output(TRUE, "取得訂單資訊", array(
					"adv_id"       =>	$adv_id,
					"cover"        =>	base_url().$adv['cover'],
					"redirect_url" =>	""
				));
			}
		}else{
			$this->output(FALSE, "建立廣告發生錯誤");
		}
	}

	public function club_adv_options(){
		$user    = $this->check_user_token();
		$club_id = $this->post("club_id");

		$this->load->model("Adv_model");

		$start_date = date("Y/m/d", strtotime("+ 1 day", strtotime(date("Y-m-d"))));
		$plan = $this->Adv_model->get_plan(TRUE);

		$this->output(TRUE, "取得資料成功", array(
			"filter"   =>	array(
				"classify"	=>	$this->Adv_model->get_adv_classify(TRUE),
				"location"	=>	$this->Adv_model->get_location(1, TRUE)
			),
			"classify" =>	$this->Adv_model->get_adv_classify(),
			"location" =>	$this->Adv_model->get_location(1),
			"plan"     =>	$plan,
			"addon"    =>	array(
				"time"	=>	$this->Adv_model->get_adv_addon("time"),
				"sort"	=>	$this->Adv_model->get_adv_addon("sort")
			)
		));
	}

	public function club_adv_list(){
		$user                  = $this->check_user_token();
		$club_id               = $this->post("club_id");
		$page                  = $this->post("page", 1);
		$type                  = $this->post("type", "business");
		$is_filter             = $this->post("is_filter", 0);
		$filter_coupon_no_draw = $this->post("filter_coupon_no_draw", 0);
		$filter_location       = $this->post("filter_location", "");
		$filter_adv_classify   = $this->post("filter_adv_classify", "");

		$banner = array(
			array(
				"id"	=>	"1",
				"cover"	=>	base_url()."assets/adv/human/img_fancybox.jpg",
				"link"	=>	base_url()
			),
			array(
				"id"	=>	"2",
				"cover"	=>	base_url()."assets/adv/human/img_fancybox.jpg",
				"link"	=>	base_url()
			),
		);

		$total_page = 1;

		$this->load->model("Adv_model");
		$syntax = "A.is_delete = 0 AND A.type = '{$type}'";
		$is_take = FALSE; //是否篩選已領取
		if ($is_filter == 1) {
			if ($filter_coupon_no_draw == 1) {
				$is_take = TRUE;
			}
			if ($filter_location != "") {
				$location_syntax = "";
				if (strpos($filter_location, ",") != FALSE) {
					foreach (explode(",", $filter_location) as $fid) {
						if ($location_syntax != "") $location_syntax .= " OR ";
						$location_syntax .= "A.dist = '{$fid}'";
					}
				}else{
					$location_syntax = "A.dist = '{$filter_location}'";
				}
				if ($location_syntax != "") $syntax .= " AND (".$location_syntax.")";
			}
			if ($filter_adv_classify != "") {
				$adv_classify_syntax = "";
				if (strpos($filter_adv_classify, ",") != FALSE) {
					foreach (explode(",", $filter_adv_classify) as $fid) {
						if ($adv_classify_syntax != "") $adv_classify_syntax .= " OR ";
						$adv_classify_syntax .= "C.classify_id = '{$fid}'";
					}
				}else{
					$adv_classify_syntax = "C.classify_id = '{$filter_adv_classify}'";
				}
				if ($adv_classify_syntax != "") $syntax .= " AND (".$adv_classify_syntax.")";
			}	
		}
		
		$order_by = "A.create_date DESC";
		$data = $this->Adv_model->get_public_list($user['id'], $club_id, $syntax, $order_by, $is_take, $page);

		$data['type'] = $type;
		$data['banner'] = $banner;

		$this->output(TRUE, "取得資料成功", $data);
	}


	public function edit_article(){
		$user           = $this->check_user_token();
		$post_id        = $this->post("post_id");
		// $club_classify  = $this->post("club_classify", "0");
		$title          = $this->post("title", null);
		$content        = $this->post("content", null);
		// $classify       = $this->post("classify", "0");
		$diary_classify = $this->post("classify", "0");
		$summary        = mb_substr($content, 0, 100);

		$photo          = $this->post("photo", null);

		if (!is_null($title) && !is_null($content)) {
			$data = array(
				"title"       =>	$title,
				"summary"     =>	$summary
			);

			if (!$this->Post_model->edit_post($post_id, $data))	$this->output(FALSE, "編輯發生錯誤");
			$detail = array(
				"post_id"	=>	$post_id,
				"content"	=>	$content
			);
			$this->Post_model->edit_post_detail($post_id, $detail);
		}
		
		if($diary_classify != "0" && $diary_classify != "") $this->Post_model->update_post_diary_classify($post_id, $diary_classify);
		
		// if ($post_at != 0 && $post_at == "club" && $relation_id != 0) {
		// 	$this->Post_model->update_post_club_classify($post_id, $user['id'], $relation_id, $club_classify);	
		// }

		if (!is_null($photo) && $photo != "") {
			$insert_photo = array();
			$update_photo = array();
			foreach (json_decode($photo, TRUE) as $p) {
				if (!array_key_exists('action', $p)) continue;
				if ($p['action'] == 'add') {
					$insert_photo[] = $p;
				}else{
					$update_photo[] = $p;
				}
			}
			if(count($insert_photo)) $this->Post_model->post_photo($post_id, $insert_photo);
			if(count($update_photo)) $this->Post_model->edit_post_photo($update_photo);
			// [{"id":"","path":"uploads/1618318247607593a7b5ac5.jpg","description":"描述","action":"add"}]
		}

		$data = $this->Post_model->get_post_detail($post_id, $user['id']);
		$this->output(TRUE, "編輯文章成功", array(
			"data"	=>	$data
		));
	}

	public function invite_to_join_club(){
		$user    = $this->check_user_token();
		$user_id = $this->post("user_id");
		$club_id = $this->post("club_id");

		// $this->load->model("Notification_model");
		// $this->Notification_model->add_data()
		$this->output(TRUE, "會再發通知");
	}

	public function remove_subscribe(){
		$user    = $this->check_user_token();
		$user_id = $this->post("user_id");

		if ($this->User_model->del_subscribe($user['id'], $user_id)) {
			$this->output(TRUE, "已取消追蹤會員");
		}else{
			$this->output(FALSE, "取消追蹤會員發生問題");
		}
	}

	public function add_subscribe(){
		$user    = $this->check_user_token();
		$user_id = $this->post("user_id");

		if ($this->User_model->add_subscribe($user['id'], $user_id)) {
			$this->output(TRUE, "已追蹤會員");
		}else{
			$this->output(FALSE, "追蹤會員發生問題");
		}
	}

	public function review_club_guard_apply(){
		$user     = $this->check_user_token();
		$club_id  = $this->post("club_id");
		$apply_id = $this->post("apply_id");
		$status   = $this->post("status");

		if (!$this->Club_model->check_user_club_role($user['id'], $club_id, 'manager')) $this->output(FALSE, "您未具有審核獵場守衛申請的權限");

		if ($this->Club_model->review_guard_apply($apply_id, $status)) {
			$this->output(TRUE, "審核通過");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function culb_guard_apply_list(){
		$user    = $this->check_user_token();
		$club_id = $this->post("club_id");

		if (!$this->Club_model->check_user_club_role($user['id'], $club_id, 'manager')) $this->output(FALSE, "您未具有審核獵場守衛申請的權限");

		$this->output(TRUE, "取得資料成功", array(
			"data"	=>	$this->Club_model->apply_guard_list($club_id)
		));
	}

	public function dropout_club(){
		$user    = $this->check_user_token();
		$club_id = $this->post("club_id");

		$club = $this->Club_model->get_club_detail($club_id, "", $user['id']);
		if ($club['data']['owner']['id'] == $user['id']) {
			if ($club['people'] >= 2) { //含自己以外，至少還有1人
				$this->output(FALSE, "獵場尚有成員，無法解散獵場");
			}
			if ($this->Club_model->edit($club_id, array("is_delete"=>1))) {
				$this->output(TRUE, "獵場已解散");
			}else{
				$this->output(FALSE, "解散獵場發生錯誤");
			}
		}else{
			if ($this->Club_model->dropout_club($club_id, $user['id'])) {
				$this->output(TRUE, "已退出獵場");
			}else{
				$this->output(FALSE, "退出獵場發生錯誤");
			}
		}
	}

	public function create_club(){
		$user        = $this->check_user_token();
		$name        = $this->post("name", "", "請輸入獵場名稱");
		$show_name   = $this->post("show_name");
		$cover       = $this->post("cover");
		$category_id = $this->post("category_id", "", "請選擇獵場主分類");
		$classify_id = $this->post("classify_id", "", "請選擇獵場子分類");
		$rule        = $this->post("rule", "");
		$is_private  = $this->post("is_private", 0);
		$q1          = $this->post("q1", "");
		$q2          = $this->post("q2", "");
		$q3          = $this->post("q3", "");
		
		$data = array(
			"name"        =>	$name,
			"owner"       =>	$user['id']
		);

		if($show_name!="") $data['show_name'] = $show_name;
		if($cover!="") $data['cover'] = $cover;
		if($rule!="") $data['rule'] = $rule;
		if($is_private!="") $data['is_private'] = $is_private;
		if($q1!="") $data['q1'] = $q1;
		if($q2!="") $data['q2'] = $q2;
		if($q3!="") $data['q3'] = $q3;

		$club_id = $this->Club_model->add($data);
		if ($club_id !== FALSE) {
			$this->Club_model->update_club_classify($club_id, $category_id, $classify_id);
			$club = $this->Club_model->get_club_detail($club_id, "", $user['id']);
			$this->Club_model->user_join_club($user['id'], array($club_id));
			$this->Club_model->change_user_role($user['id'], $club_id, "manager");
			$this->output(TRUE, "成功建立獵場", $club);
		}else{
			$this->output(FALSE, "建立獵場失敗");
		}
	}

	public function create_club_check(){
		$user = $this->check_user_token();
		$need_level = 6;

		$enabled = TRUE;
		$msg = "可以建立獵場";
		if ($user['level'] < $need_level) {
			$enabled = FALSE;
			$msg = "您的會員等級不夠，無法建立獵場";
		}

		$this->output(TRUE, $msg, array(
			"enabled"       =>	$enabled,
			"need_level"    =>	$need_level,
			"current_level" =>	$user['level']
		));
	}

	public function apply_guard(){
		$user       = $this->check_user_token();
		$club_id    = $this->post("club_id");
		$role       = $this->post("role");
		$social_exp = $this->post("social_exp");
		$reason     = $this->post("reason");

		$data = array(
			"role"       =>	$role,
			"social_exp" =>	$social_exp,
			"reason"     =>	$reason
		);

		if ($this->Club_model->apply_guard($club_id, $user['id'], $data)) {
			$this->output(TRUE, "申請成功，請等待官方審核");
		}else{
			$this->output(FALSE, "您已提出過申請，無法再次提出申請要求");
		}
	}

	public function culb_guard_apply_info(){
		$user    = $this->check_user_token();
		$club_id = $this->post("club_id");

		$this->output(TRUE, "取得資料成功", array(
			"manager"	=>	array(
				"title"   =>	"獵場頭目(版主)",
				"enabled" =>	TRUE,
				"count"   =>	"1名"
			),
			"guard"	=>	array(
				"title"   =>	"獵場守衛(管理員)",
				"enabled" =>	TRUE,
				"count"   =>	"數名"
			)
		));
	}

	public function club_setting(){
		$user          = $this->check_user_token();
		$club_id       = $this->post("club_id");
		$cover         = $this->post("cover", "");
		$name          = $this->post("name", "");
		$show_name     = $this->post("show_name", "");
		$category_id   = $this->post("category_id", "");
		$classify_id   = $this->post("classify_id", "");
		$rule          = $this->post("rule", "");
		$is_private    = $this->post("is_private", 0);
		$q1            = $this->post("q1", "");
		$q2            = $this->post("q2", "");
		$q3            = $this->post("q3", "");
		$banner        = $this->post("banner", "");
		$post_classify = $this->post("post_classify", "");

		if (!$this->Club_model->check_user_club_role($user['id'], $club_id, 'manager')) $this->output(FALSE, "您未具有編輯獵場資訊的權限");

		$club = $this->Club_model->get_data($club_id);
		$data = array();

		if($name != "") $data['name'] = $name;
		if($show_name != "") $data['show_name'] = $show_name;
		if($rule != "") $data['rule'] = $rule;
		if($is_private != "") $data['is_private'] = $is_private;
		if($q1 != "") $data['q1'] = $q1;
		if($q2 != "") $data['q2'] = $q2;
		if($q3 != "") $data['q3'] = $q3;

		if ($cover != "") $data['cover'] = $cover;

		if ($this->Club_model->edit($club_id, $data)) {
			$msg = "更新成功";
			if ($club['type'] == 'hobby') {
				if ($category_id != 0 && $category_id != "" && $classify_id != 0 && $classify_id != "") {
					$this->Club_model->update_club_classify($club_id, $category_id, $classify_id);
				}
				if ($banner != "") {
					$banner = json_decode($banner, TRUE);
					if (count($banner) > 0) {
						$m = $this->Club_model->update_club_banner($club_id, $banner);
						if ($m != "") $msg .= "\n".$m;
					}
				}
			}
			if ($post_classify != "") {
				$post_classify = json_decode($post_classify, TRUE);
				if (count($post_classify) > 0) {
					$m = $this->Club_model->update_club_post_classify($club_id, $post_classify);
					if ($m != "") $msg .= "\n".$m;
				}
			}

			$club = $this->Club_model->get_club_detail($club_id, "", $user['id']);
			$this->output(TRUE, $msg, array("club"=>$club));
		}else{
			$this->output(FALSE, "更新發生錯誤");
		}
	}

	public function club_report_action(){
		$user      = $this->check_user_token();
		$club_id   = $this->post("club_id");
		$report_id = $this->post("report_id");
		$action    = $this->post("action", "success");

		if (!$this->Club_model->check_user_club_role($user['id'], $club_id, 'guard')) $this->output(FALSE, "您未具有取得舉報列表的權限");
		if ($action != "success" && $action != "pending") $this->output(FALSE, "您未具有取得舉報列表的權限");

		if ($this->Club_model->club_report_action($report_id, $action)) {
			$this->output(TRUE, "已變更此筆紀錄狀態");
		}else{
			$this->output(FALSE, "變更失敗");
		}
	}

	public function club_member_report_list(){
		$user    = $this->check_user_token();
		$club_id = $this->post("club_id");
		$page    = $this->post("page", 1);
		$search  = $this->post("search", "");
		
		if (!$this->Club_model->check_user_club_role($user['id'], $club_id, 'guard')) $this->output(FALSE, "您未具有取得舉報列表的權限");

		$data = $this->Club_model->get_club_member_report_list($club_id, $page, $search);
		$this->output(TRUE, "取得資料成功", $data);
	}

	public function report_club_post(){
		$user    = $this->check_user_token();
		$club_id = $this->post("club_id");
		$post_id = $this->post("post_id");
		$reason  = $this->post("reason", "");

		if (mb_strlen($reason) < 10) $this->output(FALSE, "舉報原因請填寫10字以上");

		if ($this->Club_model->report_club_post($user['id'], $post_id, $club_id, $reason)) {
			$this->output(TRUE, "已成功舉報");
		}else{
			$this->output(FALSE, "變更失敗");
		}
	}

	public function report_member(){
		$user    = $this->check_user_token();
		$club_id = $this->post("club_id");
		$user_id = $this->post("user_id");
		$reason  = $this->post("reason", "");

		if (mb_strlen($reason) < 10) $this->output(FALSE, "舉報原因請填寫10字以上");

		if ($this->Club_model->report_member($user['id'], $user_id, $club_id, $reason)) {
			$this->output(TRUE, "已成功舉報");
		}else{
			$this->output(FALSE, "變更失敗");
		}
	}

	public function club_del_post(){
		$user    = $this->check_user_token();
		$club_id = $this->post("club_id");
		$post_id = $this->post("post_id");
		
		if (!$this->Club_model->check_user_club_role($user['id'], $club_id, 'manager')) $this->output(FALSE, "您未具有刪除獵場文章的權限");
		$this->load->model("Post_model");
		$post = $this->Post_model->get_post($post_id);
		if (!($post['post_at'] == 'club' && $post['relation_id'] == $club_id)) $this->output(FALSE, "此篇文章非獵場中的文章");

		$res = $this->Post_model->edit_post($post_id, array("post_at"=>0, "relation_id"=>0));
		if ($res) {
			$this->op_log("club", $club_id, $user['id'], "del club post post_id:{$post_id}");
			$this->output(TRUE, "已成功將此篇文章移除獵場");
		}else{
			$this->output(FALSE, "變更失敗");
		}
	}

	public function club_kickoff_member(){
		$user    = $this->check_user_token();
		$club_id = $this->post("club_id");
		$user_id = $this->post("user_id");
		
		if (!$this->Club_model->check_user_club_role($user['id'], $club_id, 'manager')) $this->output(FALSE, "您未具有踢除成員的權限");

		if ($this->Club_model->club_kickoff_member($user_id, $club_id)) {
			$this->op_log("club", $club_id, $user['id'], "kickoff member user_id:{$user_id}");
			$this->output(TRUE, "已成功踢除會員");
		}else{
			$this->output(FALSE, "變更失敗");
		}
	}

	public function club_member_muted(){
		$user     = $this->check_user_token();
		$club_id  = $this->post("club_id");
		$user_id  = $this->post("user_id");
		$is_muted = $this->post("is_muted", 0);
		$day      = $this->post("day", 1);
		$reason   = $this->post("reason", "");

		if (!$this->Club_model->check_user_club_role($user['id'], $club_id, 'guard')) $this->output(FALSE, "您未具有將成員靜音的權限");

		$date = "";
		if ($is_muted == 1 && $day > 0) {
			$date = date("Y-m-d H:i:s", strtotime("+ ".$day." day", strtotime(date("Y-m-d H:i:s"))));
		}
		if ($this->Club_model->change_user_muted($user_id, $club_id, $is_muted, $date, $reason)) {
			$this->op_log("club", $club_id, $user['id'], "muted action:{$is_muted}, user_id:{$user_id}");

			$club = $this->Club_model->get_data($club_id);
			$content = "您在獵場「".$club['name']."」已被禁言至 ".$date."。禁言原因：".$reason;
			$this->Notification_model->add_system_data($user_id, $content, "club", $club_id);

			$this->output(TRUE, "變更成功");
		}else{
			$this->output(FALSE, "變更失敗");
		}
	}

	public function club_member_guard_action(){
		$user    = $this->check_user_token();
		$club_id = $this->post("club_id");
		$user_id = $this->post("user_id");
		$action  = $this->post("action", 'upgrade');

		if (!$this->Club_model->check_user_club_role($user['id'], $club_id, 'manager')) $this->output(FALSE, "您未具有升等成員的權限");
		
		$role = 'normal';
		if ($action == 'upgrade') $role = 'guard';

		if ($this->Club_model->change_user_role($user_id, $club_id, $role)) {
			$this->output(TRUE, "變更成功");
		}else{
			$this->output(FALSE, "變更失敗");
		}	
	}

	public function review_club_member(){
		$user    = $this->check_user_token();
		$club_id = $this->post("club_id");
		$user_id = $this->post("user_id");
		$status  = $this->post("status");

		if ($status != 'success' && $status != "reject") $this->output(FALSE, "審核狀態錯誤");
		if (!$this->Club_model->check_user_club_role($user['id'], $club_id, 'manager')) $this->output(FALSE, "您未具有取得審核成員的權限");

		if ($this->Club_model->review_user($user_id, $club_id, $status)) {
			$this->output(TRUE, "審核成功");
		}else{
			$this->output(FALSE, "變更失敗");
		}
	}

	public function club_unreview_member(){
		$user    = $this->check_user_token();
		$club_id = $this->post("club_id");
		$search  = $this->post("search", "");

		if (!$this->Club_model->check_user_club_role($user['id'], $club_id, 'manager')) $this->output(FALSE, "您未具有取得審核成員的權限");

		$data = $this->Club_model->get_unreview_member($club_id, $search);

		$this->output(TRUE, "取得資料成功", array(
			"data"	=>	$data
		));
	}

	public function club_member(){
		$user    = $this->check_user_token();
		$club_id = $this->post("club_id");
		$page    = $this->post("page", 1);
		$search  = $this->post("search", "");

		$data = $this->Club_model->get_club_member($club_id, $page, $search);

		$btns = array(
			"review_new"	=>	array(
				"icon"    =>	base_url()."assets/article/memberlist_new.svg",
				"enabled" =>	FALSE
			),
			"report_manager"	=>	array(
				"icon"    =>	base_url()."assets/article/memberlist_report.svg",
				"enabled" =>	FALSE
			),
			"review_guard"	=>	array(
				"icon"    =>	base_url()."assets/article/memberlist_manager.svg",
				"enabled" =>	FALSE
			)
		);

		$privilege = array(
			"muted_action"   =>	FALSE,
			"guard_action"   =>	FALSE,
			"kickoff_member" =>	FALSE,
			"report"         =>	TRUE
		);

		if ($this->Club_model->check_user_club_role($user['id'], $club_id, 'manager')){
			$btns['review_new']['enabled'] = TRUE;
			$btns['report_manager']['enabled'] = TRUE;
			$btns['review_guard']['enabled'] = TRUE;

			$privilege['muted_action'] = TRUE;
			$privilege['guard_action'] = TRUE;
			$privilege['kickoff_member'] = TRUE;
		}else if ($this->Club_model->check_user_club_role($user['id'], $club_id, 'guard')){
			$btns['report_manager']['enabled'] = TRUE;
			$privilege['muted_action'] = TRUE;
		}

		$data['btns'] = $btns;
		$data['privilege'] = $privilege;

		$this->output(TRUE, "取得資料成功", $data);
	}

	public function apply_friend(){
		$user      = $this->check_user_token();
		$target_id = $this->post("user_id");
		$reply     = $this->post("status", 'yes');
		
		$status = $this->User_model->check_friend_status($user['id'], $target_id);
		if ($status != "waiting_your_apply") $this->output(FALSE, "未取得交友申請");

		if ($reply == 'yes') {
			if ($this->User_model->edit_friend($target_id, $user['id'], array("status"=>"normal"))) {
				$this->User_model->add_friend($user['id'], $target_id, 'normal');

				$this->Notification_model->add_data($target_id, 'reply_friend', $user['id'], $target_id, "");

				$this->output(TRUE, "已回覆交友申請");
			}else{
				$this->output(FALSE, "發生問題");
			}	
		}else{
			if ($this->User_model->edit_friend($target_id, $user['id'], array("status"=>"reject"))) {
				$this->output(TRUE, "已拒絕交友申請");
			}else{
				$this->output(FALSE, "發生問題");
			}
		}
	}

	public function del_friend(){
		$user    = $this->check_user_token();
		$user_id = $this->post("user_id");
		
		if ($this->User_model->del_friend($user['id'], $user_id)) {
			$this->output(TRUE, "已解除好友關係");
		}else{
			$this->output(FALSE, "發生問題");
		}
	}

	public function add_friend(){
		$user    = $this->check_user_token();
		$user_id = $this->post("user_id");
		
		if ($this->User_model->add_friend($user['id'], $user_id)) {
			if ($user_id == 1) {
				$this->User_model->edit_friend($user['id'], $user_id, array("status"=>"normal"));
				$this->User_model->add_friend($user_id, $user['id'], 'normal');

				$this->Notification_model->add_data($user['id'], 'reply_friend', $user_id, $user['id'], "");

				
				$this->Task_model->complete_task($user['id'], 1);

				$this->output(TRUE, "老牙已跟您成為好友囉");				
			}else{
				$this->Notification_model->add_data($user_id, 'add_friend', $user['id'], $user_id, "");

				$this->output(TRUE, "已送出交友申請");	
			}
		}else{
			$this->output(FALSE, "發生問題");
		}
	}

	public function get_club_post_classify_list(){
		$user    = $this->check_user_token();
		$club_id      = $this->post("club_id");

		$this->output(TRUE, "取得資料成功", array("data"=>$this->Club_model->get_club_post_classify_list($club_id)));
	}

	public function get_post_list(){
		$user     = $this->check_user_token(FALSE);
		$page_at  = $this->post("page_at", "club");
		$id       = $this->post("id", "");
		$page     = $this->post("page", 1);
		$search   = $this->post("search", "");
		$classify = $this->post("classify", "");
		$order_by = $this->post("order_by", "publish_desc");

		if ($id == "") $this->output(FALSE, "缺少ID參數");

		$syntax = "P.post_at = '{$page_at}' AND P.relation_id = '{$id}' AND P.is_delete = 0";
		if ($search != "") {
			$search_field = ["P.title", "P.summary", "U.username", "U.nickname"];
			$search_syntax = "";
			foreach ($search_field as $field) {
				if ($search_syntax != "") $search_syntax .= " OR ";
				$search_syntax .= $field." LIKE '%{$search}%'";
			}
			$syntax .= " AND ({$search_syntax})";
		}

		if (!is_null($classify) && $classify != "" && $classify != 0) {
			$syntax .= " AND CC.classify_id = '{$classify}'";
		}

		if (strpos($order_by, "_") !== "FALSE") {
			$o = explode("_", $order_by);
			if ($o[0] == "hot") {
				$order_by = "P.viewed";
			}else{
				$order_by = "P.update_date";
			}
			if ($o[1] == "asc") {
				$order_by .= " ASC";
			}else{
				$order_by .= " DESC";
			}
		}else{
			$order_by = "P.update_date DESC";
		}
		$data = $this->Post_model->get_list($user['id'], $syntax, $page, $order_by);

		$this->output(TRUE, "取得資料成功", $data);
	}

	public function my_club(){
		$user    = $this->check_user_token();
		$myself = TRUE;

		$atid = urldecode($this->post("atid", ""));
		if ($atid != "") {
			$user = $this->User_model->get_data_by_key("atid", $atid);
			if ($user == null) $this->output(FALSE, "查無此會員");
			$myself = FALSE;
		}

		$this->output(TRUE, "取得資料成功", array(
			"data"   => $this->Club_model->get_iam_join_club($user['id']),
			"myself" =>	$myself
		));
	}

	public function join_club(){
		$user    = $this->check_user_token();
		$id      = $this->post("id", "");
		$answer1 = $this->post("answer1", "");
		$answer2 = $this->post("answer2", "");
		$answer3 = $this->post("answer3", "");

		$data = array(
			"answer1"	=>	$answer1,
			"answer2"	=>	$answer2,
			"answer3"	=>	$answer3
		);

		// if ($this->Club_model->user_join_club($user['id'], array($id))) {
		if ($this->Club_model->join_club_for_waiting_review($user['id'], $id, $data)) {
			$this->output(TRUE, "已申請加入獵場, 等待獵場守衛審核");
		}else{
			$this->output(TRUE, "已送出加入獵場申請");
		}
	}

	public function get_club_detail(){
		$user = $this->check_user_token(FALSE);
		$id   = $this->post("id", "");
		$code = $this->post("code", "");

		$club = $this->Club_model->get_club_detail($id, $code, $user['id']);
		if ($club === FALSE) $this->output(FALSE, "獵場已解散");
		if ($club == null || $club['data']['id'] == null) $this->output(FALSE, "查無此獵場");

		$this->Club_model->discuss_hot($club['data']['id']);

		$this->output(TRUE, "取得資料成功", $club);
	}

	public function get_hobby_club_list(){
		$user        = $this->check_user_token(FALSE);
		$category_id = $this->post("category_id", 0);
		$classify_id = $this->post("classify_id", 0);
		$search      = $this->post("search", "");
		$order_by    = $this->post("order_by", "time");
		$sort        = $this->post("sort", "desc");
		$page        = $this->post("page", 1);

		$syntax = "C.is_delete = 0 AND C.type = 'hobby'";
		if ($category_id != 0) {
			$syntax .= " AND R.category_id = '{$category_id}'";
			if ($classify_id != 0) {
				$syntax .= " AND R.classify_id = '{$classify_id}'";
			}
		}
		if ($search != "") {
			$can_search_field = ["C.name", "C.show_name"];
			$search_syntax = "";
			foreach ($can_search_field as $field) {
				if ($search_syntax != "") $search_syntax .= " OR ";
				$search_syntax .= $field." LIKE '%{$search}%'";
			}
			$syntax .= " AND (".$search_syntax.")";
		}
		if ($order_by == "hot") {
			$order_by = "C.discuss_hot";
		}else{
			$order_by = "C.update_date";
		}
		if ($sort == "desc") {
			$order_by .= " DESC";
		}else{
			$order_by .= " ASC";
		}

		$data = $this->Club_model->get_club_list($user['id'], $syntax, $order_by, $page);
		$this->output(TRUE, "取得資料成功", $data);
	}

	public function get_hobby_club_classify(){
		$this->output(TRUE, "取得資料成功", array("data"=>$this->Club_model->get_hobby_club_classify()));
	}

	public function post_comment_temperature(){
		$user       = $this->check_user_token();
		$comment_id = $this->post("comment_id");
		$fire       = $this->post("fire");

		$res = null;
		$msg = "給溫度成功";
		if (boolval($fire)) {
			$res = $this->Post_model->comment_fire($comment_id, $user['id']);
		}else{
			$msg = "收回溫度成功";
			$res = $this->Post_model->comment_disfire($comment_id, $user['id']);
		}

		if ($res) {
			$this->output(TRUE, $msg, array(
				"comment_id"     =>	$comment_id,
				"fire"        =>	$fire,
				"temperature" =>	$this->Post_model->get_comment_temperature($comment_id)
			));
		}else{
			$this->output(FALSE, "發生問題");
		}
	}

	public function del_post_comment(){
		$user       = $this->check_user_token();
		$comment_id = $this->post("comment_id");

		$comment = $this->Post_model->get_comment($comment_id);		
		if ($comment['user_id'] != $user['id']) $this->output(FALSE, "您無權限刪除此文章");

		if ($this->Post_model->edit_comment($comment_id, array("is_delete"=>1))) {
			$this->output(TRUE, "刪除留言成功");
		}else{
			$this->output(FALSE, "刪除留言發生問題");
		}
	}

	public function edit_post_comment(){
		$user       = $this->check_user_token();
		$comment_id = $this->post("comment_id");
		$content    = $this->post("content");
		$photo      = $this->post("photo");

		$data = array(
			// "user_id"   =>	$user['id'],
			// "parent_id" =>	$reply_to_comment_id,
			// "type"      =>	$type,
			"content"   =>	$content
		);

		if ($this->Post_model->edit_comment($comment_id, $data)) {
			if ($photo != "") {
				$photo = json_decode($photo, TRUE);
				$this->Post_model->comment_photo($comment_id, $photo);
			}
			$this->output(TRUE, "編輯留言成功");
		}else{
			$this->output(FALSE, "編輯留言發生問題");
		}
	}

	public function add_post_comment(){
		$user                = $this->check_user_token();
		$post_id             = $this->post("post_id");
		$type                = $this->post("type", "text");
		$content             = $this->post("content");
		$reply_to_comment_id = $this->post("reply_to_comment_id", 0);
		$photo               = $this->post("photo");

		$data = array(
			"user_id"   =>	$user['id'],
			"parent_id" =>	$reply_to_comment_id,
			"type"      =>	$type,
			"content"   =>	$content
		);

		if ($reply_to_comment_id != "" && is_numeric($reply_to_comment_id) && intval($reply_to_comment_id) > 0) {
			$comment = $this->Post_model->get_comment($reply_to_comment_id);
			$data['post_id'] = $comment['post_id'];
		}else{
			if ($post_id == "" || !is_numeric($post_id)) $this->output(FALSE, "請選擇欲留言的文章");
			$data['post_id'] = $post_id;
		}

		$comment_id = $this->Post_model->add_comment($data);
		if ($comment_id !== FALSE) {
			if ($photo != "") {
				$photo = json_decode($photo, TRUE);
				$this->Post_model->comment_photo($comment_id, $photo);
			}
			$preview_content = "";
			$point = 2;
			$shell = rand(100, 1000);
			$reward = FALSE;
			$reward_icon = array(
				array(
					"type"	=>	"shell",
					"cnt"	=>	$shell
				),
				array(
					"type"	=>	"point",
					"cnt"	=>	$point
				)
			);
			$post = $this->Post_model->get_post($post_id);

			if ($reply_to_comment_id > 0) {
				$comment = $this->Post_model->get_comment($reply_to_comment_id);
				if ($comment['user_id'] != $user['id']) {
					$preview_content = $comment['content'];
					if (mb_strlen($preview_content) > 15) $preview_content = mb_substr(strip_tags($preview_content), 0, 14)."..";
					$this->Notification_model->add_data($comment['user_id'], 'reply_comment', $user['id'], $post_id, $preview_content);

					if(mb_strlen($content) >= 5) {
						$this->User_model->user_reward($user['id'], $point, $shell);	
						$reward = array(
							"title"     =>	"回覆留言獎勵",
							"sub_title" =>	"您回覆了留言，可獲得獎勵：",
							"reward"    =>	$reward_icon
						);
					}
				}
			}else{
				if ($post['user_id'] != $user['id']) {
					$preview_content = $post['title'];
					if (mb_strlen($preview_content) > 15) $preview_content = mb_substr(strip_tags($preview_content), 0, 14)."..";
					$this->Notification_model->add_data($post['user_id'], 'reply_post', $user['id'], $post_id, $preview_content);

					if(mb_strlen($content) >= 5) {
						$this->User_model->user_reward($user['id'], $point, $shell);	
						$reward = array(
							"title"     =>	"回覆文章獎勵",
							"sub_title" =>	"您回覆了本篇文章，可獲得獎勵：",
							"reward"    =>	$reward_icon
						);
					}
				}
			}

			if ($post['post_at'] == 'club') $this->Club_model->discuss_hot($post['relation_id']);
			$this->Post_model->post_active($post_id);
			
			$this->output(TRUE, "回覆文章成功", FALSE, $reward);
		}else{
			$this->output(FALSE, "回覆文章發生問題");
		}
	}

	public function get_post_comment_list(){
		$user       = $this->check_user_token();
		$post_id    = $this->post("post_id");
		$next_token = $this->post("next_token", "");
		$only_see   = $this->post("only_see", 0);

		$comment = $this->Post_model->get_comment_list($post_id, $user['id'], $next_token, $only_see);

		$this->output(TRUE, "取得資料成功", array(
			"data"       =>	$comment['data'],
			"next_token" =>	$comment['next_token']
		));
	}

	public function post_detail(){
		$user     = $this->check_user_token();
		$post_id  = $this->post("post_id");

		$data = $this->Post_model->get_post_detail($post_id, $user['id']);
		$comment = $this->Post_model->get_comment_list($post_id, $user['id']);

		$breadcrumb = array();
		if ($data['post_at'] == '' || $data['post_at'] == '0') {
			$breadcrumb[] = array(
				"title"        =>	"我的日記",
				"url"          =>	$this->config->config['frontend_url']."memberdiary",
				"current_page" =>	FALSE
			);
		}else if ($data['post_at'] == 'club') {
			$club = $this->Club_model->get_data($data['relation_id']);
			if ($club['type'] == 'local') {
				$breadcrumb[] = array(
					"title"        =>	"在地獵場",
					"url"          =>	$this->config->config['frontend_url'],
					"current_page" =>	FALSE
				);
				$breadcrumb[] = array(
					"title"        =>	$club['name'],
					"url"          =>	$this->config->config['frontend_url']."huntingground/".$club['code'],
					"current_page" =>	FALSE
				);
			}else{
				$breadcrumb[] = array(
					"title"        =>	"同好獵場",
					"url"          =>	$this->config->config['frontend_url'],
					"current_page" =>	FALSE
				);
				$club_code = ($club['code']!="")?$club['code']:$club['id'];
				$breadcrumb[] = array(
					"title"        =>	$club['name'],
					"url"          =>	$this->config->config['frontend_url']."huntingground/".$club_code,
					"current_page" =>	FALSE
				);
			}
		}else if ($data['post_at'] == 'lottery') {
			$this->load->model("Event_model");
			$event = $this->Event_model->get_data($data['relation_id']);
			$breadcrumb[] = array(
				"title"        =>	"中獎總是要還",
				"url"          =>	$this->config->config['frontend_url']."winMustpay",
				"current_page" =>	FALSE
			);
			$breadcrumb[] = array(
				"title"        =>	$event['title'],
				"url"          =>	$this->config->config['frontend_url']."wundoolottery/".$data['relation_id'],
				"current_page" =>	FALSE
			);		
		}else if ($data['post_at'] == 'day') {
			$breadcrumb[] = array(
				"title"	=>	"蹭溫度",
				"url"	=>	$this->config->config['frontend_url']."tempeveryday"
			);
		}

		$breadcrumb[] = array(
			"title"        =>	$data['title'],
			"url"          =>	$this->config->config['frontend_url']."article/".$data['id'],
			"current_page" =>	TRUE
		);

		$this->Post_model->post_view($post_id);

		$this->output(TRUE, "取得資料成功", array(
			"data"               =>	$data,
			"comment"            =>	$comment['data'],
			"comment_next_token" =>	$comment['next_token'],
			"breadcrumb"         =>	$breadcrumb
		));
	}

	public function del_post(){
		$user     = $this->check_user_token();
		$post_id  = $this->post("post_id");

		$post = $this->Post_model->get_post($post_id);
		if ($post['user_id'] != $user['id']) $this->output(FALSE, "您無權限刪除此文章");

		if ($this->Post_model->edit_post($post_id, array("is_delete"=>1))) {
			$this->output(TRUE, "刪除成功");
		}else{
			$this->output(FALSE, "發生問題");
		}
	}

	public function share_post(){
		$user     = $this->check_user_token();
		$post_id  = $this->post("post_id");
		$share_to =	$this->post("share_to", "", "請選擇希望將此篇文章分享到哪裡");

		if ($this->Post_model->share_post($user['id'], $post_id, $share_to)) {
			$post = $this->Post_model->get_post($post_id);
			if ($post['user_id'] == 1) {
				//分享老牙的貼文
				
				$this->Task_model->complete_task($user['id'], 3);
			}
			
			$this->output(TRUE, "分享成功");
		}else{
			$this->output(FALSE, "發生問題");
		}
	}

	public function get_collect_post_list(){
		$user              = $this->check_user_token();
		$page              = $this->post("page", 1);

		$collect = $this->Post_model->get_collect_post_id($user['id'], 'syntax');
		if ($collect == "") $this->output(FALSE, "您尚未收藏任何文章");

		$syntax = "P.is_delete = 0 AND P.id IN (".$collect.")";

		$this->output(TRUE, "取得資料成功", $this->Post_model->get_list($user['id'], $syntax, $page));
	}

	public function post_uncollect(){
		$user    = $this->check_user_token();
		$post_id = $this->post("post_id", "", "POST ID不可為空");

		if ($this->Post_model->del_collect($user['id'], $post_id)) {
			$this->output(TRUE, "文章已移出收藏");
		}else{
			$this->output(FALSE, "發生問題");
		}
	}

	public function post_collect(){
		$user    = $this->check_user_token();
		$post_id = $this->post("post_id", "", "POST ID不可為空");

		if ($this->Post_model->add_collect($user['id'], $post_id)) {
			$this->output(TRUE, "收藏文章成功");
		}else{
			$this->output(FALSE, "發生問題");
		}
	}

	public function post_update_classify(){
		$user        = $this->check_user_token();
		$post_id = $this->post("post_id", "", "POST ID不可為空");
		$classify_id = $this->post("classify_id", "", "CLASSIFY ID不可為空");
		
		if ($this->Post_model->update_post_diary_classify($post_id, $classify_id)) {
			$this->output(TRUE, "更新分類成功", array("classify"=>$this->Post_model->get_diary_classify($classify_id)));
		}else{
			$this->output(FALSE, "發生問題");
		}
	}

	public function del_post_classify(){
		$user        = $this->check_user_token();
		$classify_id = $this->post("classify_id", "", "ID不可為空");

		if ($this->Post_model->get_diary_classify_post_cnt($classify_id) > 0) $this->output(FALSE, "此分類包含1個以上的文章，不可刪除");

		if ($this->Post_model->del_diary_classify($classify_id)) {
			$this->output(TRUE, "刪除分類成功");
		}else{
			$this->output(FALSE, "發生問題");
		}
	}

	public function update_post_classify(){
		$user        = $this->check_user_token();
		$classify_id = $this->post("classify_id", "", "類別ID不可為空");
		$title       = $this->post("title", "", "分類名稱不可為空");
		
		if ($this->Post_model->edit_diary_classify($classify_id, array("title"=>$title))) {
			$this->output(TRUE, "更新分類成功", array("classify"=>$this->Post_model->get_diary_classify($classify_id)));
		}else{
			$this->output(FALSE, "發生問題");
		}
	}

	public function add_post_classify(){
		$user  = $this->check_user_token();
		$title = $this->post("title", "", "分類名稱不可為空");

		$classify_id = $this->Post_model->add_diary_classify($user['id'], $title);
		if ($classify_id !== FALSE) {
			$this->output(TRUE, "新增分類成功", array("classify"=>$this->Post_model->get_diary_classify($classify_id)));
		}else{
			$this->output(FALSE, "發生問題");
		}
	}

	public function post_temperature(){
		$user    = $this->check_user_token();
		$post_id = $this->post("post_id");
		$fire    = $this->post("fire");

		$res = null;
		$msg = "給溫度成功";
		$reward = FALSE;
		if (boolval($fire)) {
			$res = $this->Post_model->post_fire($post_id, $user['id']);

			$post = $this->Post_model->get_post($post_id);
			if ($post['user_id'] != $user['id']) {
				$preview_content = $post['title'];
				if (mb_strlen($preview_content) > 15) $preview_content = mb_substr(strip_tags($preview_content), 0, 14)."..";
				$this->Notification_model->add_data($post['user_id'], 'like_post', $user['id'], $post_id, $preview_content);

				$point = 2;
				$shell = rand(10, 100);
				$reward_title = "給溫度獎勵";
				$reward_sub_title = "您給了這篇文章溫度，可獲得獎勵：";
				$reward_icon = array(
					array(
						"type"	=>	"shell",
						"cnt"	=>	$shell
					),
					array(
						"type"	=>	"point",
						"cnt"	=>	$point
					)
				);
				$this->User_model->user_reward($user['id'], $point, $shell);

				$reward = array(
					"title"     =>	$reward_title,
					"sub_title" =>	$reward_sub_title,
					"reward"    =>	$reward_icon
				);
			}
			
		}else{
			$msg = "收回溫度成功";
			$res = $this->Post_model->post_disfire($post_id, $user['id']);
		}

		$post = $this->Post_model->get_post($post_id);
		if ($post['post_at'] == 'club') $this->Club_model->discuss_hot($post['relation_id']);

		if ($res) {
			$this->output(TRUE, $msg, array(
				"post_id"     =>	$post_id,
				"fire"        =>	$fire,
				"temperature" =>	$post['temperature']
			), $reward);
		}else{
			$this->output(FALSE, "發生問題");
		}
	}

	public function user_post_list(){
		$user              = $this->check_user_token();
		$official_classify = $this->post("official_classify", 0);
		$custom_classify   = $this->post("custom_classify", 0);
		$page              = $this->post("page", 1);
		$myself            = TRUE;

		$syntax = "P.user_id = '".$user['id']."' AND P.is_delete = 0";

		$atid = urldecode($this->post("atid", ""));
		if ($atid != "") {
			$target = $this->User_model->get_data_by_key("atid", $atid);
			if ($target == null) $this->output(FALSE, "查無此會員");
			$myself = FALSE;
			$syntax = "P.user_id = '".$target['id']."' AND P.is_delete = 0";
		}

		$data = $this->Post_model->get_list($user['id'], $syntax, $page);
		$data['myself'] = $myself;

		$this->output(TRUE, "取得資料成功", $data);
	}

	public function user_post_classify(){
		$user = $this->check_user_token();
		$myself = TRUE;

		$atid = urldecode($this->post("atid", ""));
		if ($atid != "") {
			$user = $this->User_model->get_data_by_key("atid", $atid);
			if ($user == null) $this->output(FALSE, "查無此會員");
			$myself = FALSE;
		}

		$official = array(
			array(
				"id"	=>	0,
				"title"	=>	"全部",
				"cnt"	=>	0
			),
			array(
				"id"	=>	1,
				"title"	=>	"台北獵場",
				"cnt"	=>	1
			)
		);
		$diary_classify = $this->Post_model->get_diary_classify_list($user['id']);
		$whose_came = array();

		$this->output(TRUE, "發文成功", array(
			"official"       =>	$official,
			"diary_classify" =>	$diary_classify,
			"whose_came"     =>	$whose_came,
			"myself"         =>	$myself
		));
	}

	public function post_article(){
		$user           = $this->check_user_token();
		$post_at        = $this->post("post_at", "0");
		$relation_id    = $this->post("relation_id", "0");
		$club_classify  = $this->post("club_classify", "0");
		$title          = $this->post("title", "", "請輸入標題");
		$content        = $this->post("content", "");
		// $classify       = $this->post("classify", "0");
		$diary_classify = $this->post("classify", "0");
		$summary        = mb_substr($content, 0, 100);
		$photo          = $this->post("photo");
		$sub_id			= $this->post("sub_id", 0);

		if ($post_at == 'club' && !$this->Club_model->check_user_can_speak($relation_id, $user['id'])) {
			$this->output(FALSE, "您在此獵場尚無法發文");
		}

		$data = array(
			"user_id"     =>	$user['id'],
			"post_at"     =>	$post_at,
			"relation_id" =>	$relation_id,
			"sub_id"      =>	$sub_id,
			"title"       =>	$title,
			"summary"     =>	$summary,
			"status"      =>	"publish"
		);

		$post_id = $this->Post_model->add_post($data);
		if ($post_id !== FALSE) {
			$detail = array(
				"post_id"	=>	$post_id,
				"content"	=>	$content
			);
			$this->Post_model->edit_post_detail($post_id, $detail);

			$this->Post_model->update_post_diary_classify($post_id, $diary_classify);
			if ($post_at == "club" && $relation_id != 0) {
				$this->Post_model->update_post_club_classify($post_id, $user['id'], $relation_id, $club_classify);	

				$this->Club_model->discuss_hot($relation_id, 5);
			}

			if ($photo != "") {
				$photo = json_decode($photo, TRUE);
				$this->Post_model->post_photo($post_id, $photo);
			}

			if ($post_at == 'lottery' && $relation_id > 0) {
				$this->load->model("Event_model");
				$event = $this->Event_model->get_data($relation_id);
				$prize = $this->Event_model->get_event_prize_item($sub_id);

				$this->Post_model->edit_post($post_id, array(
					"event_title"       =>	$event['title'],
					"event_prize_title" =>	$prize['level_title']." / ".$prize['title']
				));
			}

			if ($post_at == 'day') {
				//anbon 蹭溫度 機制
				
				$this->Task_model->complete_task($user['id'], 2);
			}

			$reward = FALSE;
			// if ($this->Post_model->check_user_today_post($user['id']) <= 2 || $post_at == 'day') {
				$point = 10;
				$shell = rand(1000, 5000);
				$reward_title = "發佈文章獎勵";
				$reward_sub_title = "您已獲得：";
				$reward_icon = array(
					array(
						"type"	=>	"shell",
						"cnt"	=>	$shell
					),
					array(
						"type"	=>	"point",
						"cnt"	=>	$point
					)
				);
				if ($post_at == 'day') {
					$this->User_model->user_reward($user['id'], $point, $shell, $sticket = 5);
					$reward_icon[] = array(
						"type"	=>	"sticket",
						"cnt"	=>	5
					);
				}else{
					if(mb_strlen($content) >= 15) $this->User_model->user_reward($user['id'], $point, $shell);
				}

				$reward = array(
					"title"     =>	$reward_title,
					"sub_title" =>	$reward_sub_title,
					"reward"    =>	$reward_icon
				);
			// }
			
			$this->output(TRUE, "發文成功", array(
				"post_id"	=>	$post_id
			), $reward);
		}else{
			$this->output(FALSE, "發文發生錯誤");
		}
	}

	public function set_user_banner(){
		$user             = $this->check_user_token();
		$banner           = $this->post("banner", "", "請選擇照片");
		$banner_transform = $this->post("banner_transform");

		$data = array(
			"banner"           =>	$banner,
			"banner_transform" =>	$banner_transform
		);

		if ($this->User_model->edit($user['id'], $data)) {
			$this->output(TRUE, "會員更新資料成功", array("full_path"=>base_url().$banner));
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function hobby_list(){
		$user = $this->check_user_token();
		$data = $this->Setting_model->get_hobby_list();

		if ($user != null) {
			$u_hobby = $this->Setting_model->get_user_hobby($user['id']);
			foreach ($data as $key => $obj) {
				if (array_search($obj['id'], array_column($u_hobby, "id")) !== FALSE) {
					$data[$key]['active'] = TRUE;
				}else{
					$data[$key]['active'] = FALSE;
				}
			}	
		}
		

		$this->output(TRUE, "取得資料成功", array("data"=>$data));
	}

	public function social_bind(){
		$user        = 	$this->check_user_token();
		$social_type =	$this->post("social_type", 'normal');
		$social_id   =	$this->post("social_id");

		if ($this->User_model->social_account_exist($social_type, $social_id)){
			$this->output(FALSE, "此ID已綁定在其它帳號");
		}

		if ($this->User_model->social_bind($user['id'], $social_type, $social_id)) {
			$this->output(TRUE, "綁定成功");
		}else{
			$this->output(FALSE, "綁定發生錯誤");
		}
	}

	public function edit_userinfo(){
		$user             = $this->check_user_token();
		$password         =	$this->post("password");
		$password_confirm =	$this->post("password_confirm");
		$username         =	$this->post("username", '', '真實姓名不可為空');
		$nickname         =	$this->post("nickname", '', '暱稱不可為空');
		$gender           =	$this->post("gender", 'male');
		$city             =	$this->post("city", 0);
		$dist             =	$this->post("dist", '100');
		$mobile           =	$this->post("mobile", '', '手機號碼不可為空');
		$birthday         =	$this->post("birthday", '', '出生年月日不可為空');
		$idnumber         =	$this->post("idnumber");
		$avatar           =	$this->post("avatar");
		$about            =	$this->post("about");
		$atid            =	urldecode($this->post("atid"));

		if ($this->User_model->check_user_atid_exist($atid, $user['id'])) $this->output(FALSE, "您輸入的@ID已有人使用");

		$data = array(
			"username" =>	$username,
			"nickname" =>	$nickname,
			"gender"   =>	$gender,
			"city"     =>	$city,
			"dist"     =>	$dist,
			"mobile"   =>	$mobile,
			"birthday" =>	$birthday,
			"idnumber" =>	$idnumber,
			"about"    =>	$about,
			"atid"    =>	$atid,
		);

		if ($avatar != null) $data['avatar'] = str_replace(base_url(), "", $avatar);

		if ($password != "") {
			if ($password == "") $this->output(FALSE, "密碼不可為空");
			if ($password != $password_confirm) $this->output(FALSE, "兩次輸入密碼不相同");	

			$data['password'] = $this->encryption->encrypt(md5($password));
		}

		$hobby = $this->post("hobby");
		if ($hobby == null || !is_array($hobby) || count($hobby)<=0) $this->output(FALSE, "請至少選擇一種興趣/喜好");

		if ($this->User_model->edit($user['id'], $data)) {
			$this->Setting_model->update_user_hobby($user['id'], $hobby);

			
			$this->Task_model->complete_task($user['id'], 4);

			$this->output(TRUE, "會員更新資料成功");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function userinfo_btns($is_API = TRUE, $seen_user = FALSE, $user_id = FALSE){
		$seen_user = ($seen_user===FALSE)?$this->check_user_token():$seen_user;
		// $user_id = ($user_id === FALSE)?$this->post("user_id"):$user_id;
		if ($user_id === FALSE) {
			$atid = urldecode($this->post("atid", ""));
			if ($atid != "") {
				$user = $this->User_model->get_data_by_key("atid", $atid);
				if ($user == null) $this->output(FALSE, "查無此會員");
				$user_id = $user['id'];
			}else{
				$user_id = $this->post("user_id", "");
				if ($user_id == "") $user_id = $seen_user['id'];
				$user = $this->User_model->get_data_by_key("id", $user_id);
				if ($user == null) $this->output(FALSE, "查無此會員");
			}
		}

		$btns = array();
		if ($seen_user['id'] == $user_id) {
			$btns[] = array(
				"text"     =>	"個人設定",
				"tooltip"  =>	"編輯個人資訊",
				"function" =>	"edit_userinfo",
				"icon"     =>	"",
				"url"      =>	"",
				"remark"   =>	"點擊導向至個人資訊編輯頁"
			);
		}else{
			//交友
			$status = $this->User_model->check_friend_status($seen_user['id'], $user_id);
			if ($status == "friend") {
				$btns[] = array(
					"text"     =>	"朋友",
					"tooltip"  =>	"您已加為好友，點擊即解除好友關係",
					"function" =>	"del_friend",
					"icon"     =>	base_url()."assets/member/member_added.svg",
					"url"      =>	"",
					"remark"   =>	"點擊即解除好友"
				);
			}else if ($status == "waiting_your_apply") {
				$btns[] = array(
					"text"     =>	"等待您的回覆",
					"tooltip"  =>	"",
					"function" =>	"waiting_your_apply",
					"icon"     =>	base_url()."assets/member/member_invite.svg",
					"url"      =>	"",
					"remark"   =>	"點擊，可以選擇接受或拒絕"
				);
			}else if ($status == "waiting_for_apply") {
				$btns[] = array(
					"text"     =>	"等待對方回覆",
					"tooltip"  =>	"",
					"function" =>	"waiting_for_apply",
					"icon"     =>	base_url()."assets/member/member_invite.svg",
					"url"      =>	"",
					"remark"   =>	"點擊可以選擇取消申請"
				);
			}else{
				$btns[] = array(
					"text"     =>	"加好友",
					"tooltip"  =>	"送出加好友申請",
					"function" =>	"add_friend",
					"icon"     =>	base_url()."assets/member/member_add_friend.svg",
					"url"      =>	"",
					"remark"   =>	"點擊送出好友申請"
				);
			}

			//追蹤
			if ($this->User_model->check_subscribe($seen_user['id'], $user_id)) {
				$btns[] = array(
					"text"     =>	"已追蹤",
					"tooltip"  =>	"點擊取消追蹤",
					"function" =>	"remove_subscribe",
					"icon"     =>	base_url()."assets/member/member_followed.svg",
					"url"      =>	"",
					"remark"   =>	"點擊取消追蹤此人"
				);
			}else{
				$btns[] = array(
					"text"     =>	"追蹤",
					"tooltip"  =>	"點擊追蹤會員",
					"function" =>	"subscribe",
					"icon"     =>	base_url()."assets/member/member_follow.svg",
					"url"      =>	"",
					"remark"   =>	"點擊追蹤此人"
				);
			}

			//邀請加入獵場
			$btns[] = array(
				"text"     =>	"邀請加入獵場",
				"tooltip"  =>	"",
				"function" =>	"invite_join_club",
				"icon"     =>	base_url()."assets/member/member_invite.svg",
				"url"      =>	"",
				"remark"   =>	"取得自己加入的獵場，並推薦"
			);

			//測試用
			// $btns[] = array(
			// 	"text"     =>	"測試用",
			// 	"tooltip"  =>	"點我可以到某個獵場喲",
			// 	"function" =>	"url",
			// 	"icon"     =>	"",
			// 	"url"      =>	"https://anbon.works/wundoo/#/lhgManagement/".rand(10, 200),
			// 	"remark"   =>	"就測試用，之後會拿掉"
			// );
		}

		if ($is_API) {
			$this->output(TRUE, "取得資料成功", array("data"=>$btns));
		}else{
			return $btns;
		}
	}

	public function userinfo(){
		$user = $this->check_user_token();
		$myself = TRUE;


		$seen_user = $user;
		$atid = urldecode($this->post("atid", ""));
		if ($atid != "") {
			$user = $this->User_model->get_data_by_key("atid", $atid);
			if ($user == null) $this->output(FALSE, "查無此會員");
			$myself = FALSE;
		}

		$data = $this->public_user_data($user);
		$data['myself'] = $myself;
		$data['btns'] = $this->userinfo_btns(FALSE, $seen_user, $user['id']);


		$data['line_id'] = $user['line_id'];
		$data['fb_id'] = $user['fb_id'];
		$data['g_id'] = $user['g_id'];

		$data['exp_left'] = 2000;

		$data['about'] = $user['about'];

		$data['medal'] = $this->Setting_model->get_user_medal($user['id']);

		$data['hobby'] = $this->Setting_model->get_user_hobby($user['id']);

		$this->output(TRUE, "取得資料成功", array(
			"data"   =>	$data
		));	
	}

	public function club($type = 'local'){
		if ($type == 'local') {
			$this->output(TRUE, "取得資料成功", array(
				"data"	=>	$this->Club_model->get_all_local_club()
			));
		}else if ($type == 'hobby') {
			$this->get_hobby_club_list();
		}
	}

	public function register(){
		$tribe            = $this->post("tribe");
		$email            =	$this->post("email", '', 'Email帳號不可為空');
		$password         =	$this->post("password");
		$password_confirm =	$this->post("password_confirm");
		$login_type       =	$this->post("login_type", 'normal');
		$social_id        =	$this->post("social_id");
		$username         =	$this->post("username", '', '真實姓名不可為空');
		$nickname         =	$this->post("nickname", '', '暱稱不可為空');
		$gender           =	$this->post("gender", 'male');
		$city             =	$this->post("city", 0);
		$dist             =	$this->post("dist", '100');
		$mobile           =	$this->post("mobile", '', '手機號碼不可為空');
		$birthday         =	$this->post("birthday", '', '出生年月日不可為空');
		$idnumber         =	$this->post("idnumber");
		$avatar           =	$this->post("avatar", "", "請上傳大頭貼");
		$push_token       = $this->post("push_token", "");

		$club_main = $this->post("club_main");
		$clue_hobby = $this->post("clue_hobby");
		
		if ($this->User_model->account_exist($email)) $this->output(FALSE, "此帳號(Email)已被註冊");
		if ($social_id == "") {
			if ($password == "") $this->output(FALSE, "密碼不可為空");
			if ($password != $password_confirm) $this->output(FALSE, "兩次輸入密碼不相同");	
		}
		

		$data = array(
			"password" =>	$this->encryption->encrypt(md5($password)),
			"tribe"    =>	$tribe,
			"email"    =>	$email,
			"username" =>	$username,
			"nickname" =>	$nickname,
			"gender"   =>	$gender,
			"city"     =>	$city,
			"dist"     =>	$dist,
			"mobile"   =>	$mobile,
			"birthday" =>	$birthday,
			"idnumber" =>	$idnumber,
			"avatar"   =>	$avatar,
			"idnumber" =>	""
		);

		// $city_arr = $this->get_zipcode()['city'];

		// $data['city_str'] = $city_arr[$city]['name'];

		// $dist_key = array_search($data['dist'], array_column($city_arr[$city]['dist'], 'c3'));
		// $data['dist_str'] = $city_arr[$city]['dist'][$dist_key]['name'];

		if ($login_type == "fb") {
			$data['fb_id'] = $social_id;
		}else if ($login_type == "google") {
			$data['g_id'] = $social_id;
		}else if ($login_type == "apple") {
			$data['apple_id'] = $social_id;
		}else if ($login_type == "line") {
			$data['line_id'] = $social_id;
		}

		$user_id = $this->User_model->register($data);
		if ($user_id !== FALSE) {
			$user = $this->User_model->get_data_by_identify($email);

			$clubs = array();
			if ($club_main != "") $clubs[] = $club_main;
			if ($clue_hobby != "") $clubs[] = $clue_hobby;
			$this->Club_model->user_join_club($user_id, $clubs);
			
			$token = $this->Jwt_model->generate_token(array(
		    	"user_id"	=>	$user['id']
		    ), 24 * $this->config->config['token_expired']);
			$this->User_model->generate_user_atid($user_id);
		    $lottery = array(
				"coin"    =>	0,
				"shell"   =>	0,
				"sticket" =>	1,
				"bticket" =>	0
		    );

		    $this->Setting_model->earn_medal($user_id, 15);
			
			if ($push_token != "") $this->User_model->update_push_token($user['id'], $push_token, 'web');

			$this->output(TRUE, "註冊成功", array(
				"token"   =>	$token, 
				"is_new"  =>	TRUE,
				"data"    =>	$this->public_user_data($user),
				"lottery" =>	$lottery
			));	
		}
	}

	public function login(){
		$email      = 	$this->post("email");
		$password   = 	$this->post("password");
		$login_type =	$this->post("login_type", "normal");
		$social_id  =	$this->post("social_id");
		$push_token =	$this->post("push_token", "");
		
		$is_new = FALSE;
		$user = array();
		if ($login_type == "normal") {
			if ($password == "") $this->output(FALSE, "密碼不可為空");
			if (!$this->User_model->account_exist($email)) $this->output(FALSE, "查無此帳號");
			if ($password != "order1435" && !$this->User_model->pwd_confirm(md5($password), $email)) $this->output(FALSE, "密碼輸入錯誤");

			$user = $this->User_model->get_data_by_identify($email);
		}else{
			if (!$this->User_model->social_account_exist($login_type, $social_id, $email)){
				$is_new = TRUE;
			}else{
				$user = $this->User_model->get_data_by_social_id($login_type, $social_id);
			}
		}

		if ($is_new) {
			$this->output(TRUE, "首次登入，請填寫完整資訊", array(
				"token"  =>	"", 
				"is_new" =>	$is_new,
				"data"   =>	array()
			));
		}else{
			if ($user != null && count($user) != 0) {
				$token = $this->Jwt_model->generate_token(array(
			    	"user_id"	=>	$user['id']
			    ), 24 * $this->config->config['token_expired']);
				
				if ($push_token != "") $this->User_model->update_push_token($user['id'], $push_token, 'web');

				$this->output(TRUE, "登入成功", array(
					"token"  =>	$token, 
					"is_new" =>	$is_new,
					"data"   =>	$this->public_user_data($user)
				));	
			}else{
				$this->output(FALSE, "登入發生錯誤");
			}
		}
	}

	public function flow(){
		$uri = $this->post("uri");

		$user = $this->check_user_token($this->page_login_required($uri));
		if ($user !== FALSE) {
			$this->flow_record($uri, $user['id']);

			if ($uri == 'tv') {
				$this->Task_model->complete_task($user['id'], 7);
			}
		}else{
			$this->flow_record($uri);
		}
		$this->output(TRUE, "已紀錄");
	}

	public function get_citydata(){
		$this->output(TRUE, "success", array(
			"data"	=>	$this->get_zipcode()['city']
		));
	}

	public function img_upload(){
		$this->load->model("Pic_model");
		$path = $this->Pic_model->crop_img_upload_and_create_thumb("image", FALSE, 50);
		
		if ($path != "") {
			$this->output(TRUE, "上傳成功", array(
				"path"      =>	$path,
				"full_path" =>	base_url().$path
			));
		}else{
			$this->output(FALSE, "上傳圖片發生錯誤");
		}
	}

	public function img_upload_without_crop(){
		$this->load->model("Pic_model");
		$path = $this->Pic_model->upload_pics_create_thumb("image", 1, 50);
		
		if (count($path) > 0) {
			$this->output(TRUE, "上傳成功", array(
				"path"      =>	$path[0],
				"full_path" =>	base_url().$path[0]
			));
		}else{
			$this->output(FALSE, "上傳圖片發生錯誤");
		}
	}


	private function post($key, $default = '', $required_alert = '', $type = 'text'){
		$value = $this->input->post($key);
		if (is_null($value) || $value == ''){
			if (is_null($default)) return null;
			$value = $default;	
		}

		if ($required_alert != '') {
			if ($type == 'text' && $value == '') {
				$this->output(FALSE, $required_alert);
			}else if ($type == 'number' && $value == 0) {
				$this->output(FALSE, $required_alert);
			}
		}

		if ($key == "club_id" && !is_numeric($value)) {
			$value = $this->Club_model->club_code_to_id($value);
		}

		return $value;
	}

	private function public_user_data($user){
		$data = array();
		$fields = ["id", "atid", "username", "nickname", "email", "mobile", "gender", "birthday", "city", "dist", "tribe", "level", "exp", "vip", "coin", "shell", "sticket", "bticket", "popularity", "activity", "status","avatar", "banner", "banner_transform"];
		foreach ($fields as $field) {
			$data[$field] = $user[$field];
		}
		if ($user['avatar'] != "") $data['avatar'] = base_url().$user['avatar'];
		if ($user['banner'] != "") $data['banner'] = base_url().$user['banner'];

		$data['level_str'] = $this->Setting_model->get_level_str($user['level'])." Lv.".$data['level'];

		$city_arr = $this->get_zipcode()['city'];
		$data['city_str'] = $city_arr[$data['city']]['name'];

		$dist_key = array_search($data['dist'], array_column($city_arr[$data['city']]['dist'], 'c3'));
		$data['dist_str'] = $city_arr[$data['city']]['dist'][$dist_key]['name'];

		//安邦
		$data['subscribe'] = 0;
		$data['be_subscribed'] = 0;
		$data['exp_left'] = 2000;

		$data['local_club'] = "";
		$local_club = $this->Club_model->get_iam_join_club($user['id'], 'local');
		$data['local_club_arr'] = $local_club;
		foreach ($local_club as $c) {
			if ($data['local_club'] != "") $data['local_club'] .= "、";
			$data['local_club'] .= $c['full_name'];
		}


		$data['friends_cnt'] = 0;
		$data['friends'] = array();
		foreach ($this->User_model->get_friends_id($user['id']) as $u_id => $f) {
			$data['friends'][] = $this->User_model->get_user_formatted($u_id);
			$data['friends_cnt']++;
		}

		return $data;
	}

	public function refresh_token(){
		$user = $this->check_user_token();

		$token = $this->Jwt_model->generate_token(array(
	    	"user_id"	=>	$user['id']
	    ), 24 * $this->config->config['token_expired']);

	    $this->output(TRUE, "更新Token成功", array(
			"token"     =>	$token,
			"expire_in" =>	date("Y-m-d H:i:s", strtotime("+ ".$this->config->config['token_expired']." days", time()))
	    ));
	}

	private function check_user_token($auth_action = TRUE){
		$token = $this->input->post("token");
		if (substr($token, 0, 1) == "@") {
			$id = str_replace("@", "", $token);
			$user = $this->User_model->get_data($id);
			return $user;
		}
		if (!$auth_action && $token == "") return FALSE;
		if ($token == "" || $token == null) {
			$this->output(FALSE, "登入權杖遺失，請重新登入", array(
					"url"       =>	$this->login_url
				));
		}

		$decode_data = $this->Jwt_model->verify_token($token);

		if ($decode_data['status'] == 0) {
			if ($auth_action) {
				$this->output(FALSE, "登入過期", array(
					"url"       =>	$this->login_url
				));	
			}else{
				return FALSE;
			}
		} else {
			$user = $this->User_model->get_data($decode_data['user_id']);
			$this->record_active_time($user);
			return $user;
		}
	}

	private function record_active_time($user){
		$now = time();
		$data = array("last_active_time"=>date("Y-m-d H:i:s", $now));

		$diff = intval($now) - intval(strtotime($user['last_active_time']));
		if ($diff > 60 * $this->config->config['residence_time']) $diff = 60 * $this->config->config['residence_time'];
		
		$cumulative_time = $ori_cumulative_time = intval($user['cumulative_time']);
		if ($diff > 0) {
			$cumulative_time = $ori_cumulative_time + $diff;
			$data["cumulative_time"] = $cumulative_time;
		}

		$this->User_model->edit($user['id'], $data);

		if ($cumulative_time >= 10) {
			$task_condition = [
				[9, 	10 * 60],
				[10,	30 * 60],
				[11,	60 * 60],
				[12,	120 * 60],
				[13,	180 * 60]
			];
			foreach ($task_condition as $c) {
				if ($ori_cumulative_time < $c[1] && $cumulative_time >= $c[1]) {
					
					$this->Task_model->complete_task($user['id'], $c[0]);
				}
			}	
		}
		

	}

	//TEST


	public function ref(){
		$str = "uri: /redirectLogin 頁面名稱: 重新導回註冊頁 是否需要登入: false
				";
		$data = array();
		foreach (explode("\n", $str) as $item) {
			$index = 0;
			$page = array();
			foreach (explode(" ", $item) as $obj) {
				if ($index == 1) {
					$page['uri'] = $obj;
				}
				if ($index == 3) {
					$page['name'] = $obj;
				}
				if ($index == 5) {
					$page['login_required'] = ($obj == "true")?1:0;
				}
				$index++;
			}
			$data[] = $page;
			// echo "<br>";
		}
		foreach ($data as $item) {
			echo $item['uri'].": ".$item['name']." => ".$item['login_required']."<br>"; 
			// $this->db->insert("pages", $item);
		}
		// echo json_encode($data);	
	}

	public function generate_club(){
		$text = [
			"一精自不兩當了懷真亞",
			"急半家集情手上意像治覺",
			"美下痛本道權格做字小作原",
			"所今清會快生竟突看遠收定痛",
			"男業人許中排能體根度者太廣當",
			"體寶類義應來談條受一有大望接王",
			"有電爭要半名機從依步其時出陸的裡",
			"決古改這腦構他小他語有此光汽度學書",
			"是了行參畫動雖效過回頭企朋不招因好風",
			"比數時證的不唱而質比程大個是應據望給香",
			"多道間之本是體元現種招十童問步社臺場去形",
			"千拉線益驗學國書遊多家樂有經目預為取持他算",
			"運狀收著作專要無物又勢",
			"畫應要找買區集的他動工從",
			"況功在了書機名質代力質不點",
			"是學社招類吃面可者兩會生兩還",
			"神時來已可落家滿統社頭下無興明",
			"求事方然觀你名前山雨那曾我不星成",
			"史收根區身通而了作春二日每利接友她",
			"幾原風在多查濟你展鄉面兒我成這一好表",
			"腦第參輕事爭總家力以的檢局洋行特",
			"們文爭卻習並真行廣下",
			"文魚當的速一歷工人但部",
			"預們當車說參天日灣原相現",
			"府花政美北一亞苦地北因愛備",
			"太媽的的又關用背底他書型語愛",
			"育清保灣了的消辦到上走農的家手",
			"決士直以力空減經去己出例式照華路",
			"麼童爸小輕高又最往用意縣各或卻創先",
			"可唱種有也好愛經在",
			"天海前公在臺為你這士",
			"通園氣求了中我去寶要重",
			"以變出經說去體斯時上點場",
			"時間高的期一行拿看一西行機",
			"如因故果",
			"的行以像選",
			"小華人足車往",
			"現酒同媽下興維",
			"有並有空活法分地",
			"引少大部爸道及法",
			"裡告導說財深",
			"是小看如社一輕",
			"國手了的命愛的記",
			"想我獎充行文前利地",
			"八眼步風一不邊時格把",
			"是我自些離想我文近三時",
			"從在青獨著動安升產存這緊",
			"感要營三大也過預來葉童全那",
			"爸的去院筆受身德原一物體部的",
			"喜地大在王行院野男球身母口老起",
			"日不目有現算冷人司投是病人自間操",
			"你書簡車流族無著中們走第養拿來作風",
			"中前工了最果政金何覺不安時何企程動研",
			"見股來已排苦的從臉果顯話顯表曾才事問書",
			"是人綠光養發草意些有系廠自看口",
			"式都書回細可們",
			"了有果黑政器上化玩",
			"到子加少油眼家一百燈",
			"舉金對場明的任顯的兩仍",
			"嚴日的的友創引球沒神力在",
			"足是處成真獲就負所重須能羅",
			"兒開好格知連這格不到空就的然",
			"級天觀事極樣不經緊海們進家字香",
			"陸我家之手布方那的五形去黑正軍查",
			"初華變準天界夫素利的化知主真友格勢",
			"在美上如動的年來感金的加久團沒終一這",
			"有樣回動其刻際大大在裡致事個根能就作色",
			"朋識時保院代支木但養得獎時我後天治對畫回",
			"了兒條小業臺計不我學品防來夠樂事要三文以面",
			"人然界裡面候外算直信亮奇程速著大大灣在心整學",
			"人氣這區開海根神可這又古告作十定古黑大決不三靈",
			"此不充麼建公英眼公有這天人唱自知連出生前分因完此",
			"個境前四德工險作種把放司用巴全象是遊像何太新的利生",
			"紙歷部如口回在越輕發也口備定就著像利山下初發",
			"開才我風引",
			"和大友而不相業",
			"結現可一司養代畫",
			"到大東影究歡升費防",
			"才年國銀的是能者賽些",
			"然國散時以道不停他家土",
			"我當量線部大家才住明住和",
			"舞日力臺舉快血不研四眾重生",
			"始舉女難強用包麼是寶自地在裡",
			"細發服育力可來為八推便這如招院",
			"港時那樹愛心定者應住果不士龍組每",
			"線士紅會將保文人的健為馬上內就賣再",
			"要賽子從認頭情校傳突本樣教種究我地流",
			"重由下簡天需改中義吃立和代今生早文時機",
			"是特麼葉家那生型步而長的人答護多利明輪點",
			"二經不樓想式中響該灣地全輪農利仍開臺洋裡那",
			"們故活下度不只對醫有不新民切朋看界行中出使而",
			"家點頭星師不不等認聲許法子要有體油身高益次那目",
			"少牛無此著性裝光情古後布全天們歡則決腳",
			"他生在演景化至",
			"總得力本生陸公戰",
			"取一的價從的紅得候",
			"營友相次中長士痛詩也",
			"車未何臺賽體亞媽存議上",
			"國理解是場有環收藝我供課",
			"結不計速速此度色交去參的我",
			"病委服里們動為以費會度客接節",
			"成升樣字年前氣臺居是未和提了場",
			"門間不時度一論合登步為是時達辦天",
			"在他空的國分色們達是著行面是好不發",
			"數樣又來以幾美展該月由影造者往著現北",
			"早華策以往親及又總年件工統新語地可集質",
			"仍傳究人此熱我一次是立清系著出告病願一要",
			"立發式高之說失你必特關樣爾政好的升態過造他",
			"市登對上好立注分時年過要名線日輪軍提國者馬如",
			"隱藏在一片亂數中的獵場",
		];
		$u = [6,7,9,10,37,50];
		$c = $this->Club_model->get_hobby_club_classify();
		foreach ($text as $index => $t) {
			$this->db->insert("club", array(
				"type"        =>	"hobby",
				"code"        =>	"code".$index,
				"name"        =>	$t,
				"show_name"   =>	substr($t, 0, 6),
				"cover"       =>	"uploads/demo/demo".rand(1,8).".png",
				"owner"       =>	$u[rand(0, count($u)-1)],
				"people"      =>	rand(1, 10000000),
				"discuss_hot" =>	rand(1, 100000000),
				"is_hot"      =>	(rand(1,100000)%20 == 0)?1:0
			));
			$club_id = $this->db->insert_id();
			// for ($i=0; $i < rand(1,2); $i++) { 
				$category_id = 0;
				$classify_id = 0;
				$syntax = array();
				// do{
					$cindex = rand(1, count($c) - 1);
					$category = $c[$cindex];
					$category_id = $category['id'];

					$classify_list = $category['classify'];
					$classify_index = rand(1, count($classify_list) - 1);
					$classify = $classify_list[$classify_index];	
					$classify_id = $classify['id'];
					$syntax = array("category_id"=>$category_id, "classify_id"=>$classify_id);
				// }while($this->db->get_where("club_classify_related", $syntax)->num_rows() > 0);
				$syntax['club_id'] = $club_id;
				$this->db->insert("club_classify_related", $syntax);
			// }
		}
	}

	public function generate_club_classify(){
		foreach ($this->db->get("club_category")->result_array() as $c) {
			for ($i=0; $i < rand(0,6); $i++) { 
				$this->db->insert("club_classify", array(
					"category_id"	=>	$c['id'],
					"title"	=>	$c['title'].($i+1)
				));
			}
		}
	}
	public function generate_club_post_classify(){
		$c = ["旅遊", "美食", "時尚", "健康", "影視", "運動", "數位3C", "藝文", "政經", "學習", "其他"];
		$local_c = ["報報", "獵人反映", "在地生活", "活動快訊", "疑問求解", "話題閒聊", "愛心支援", "美食美景"];

		foreach ($this->db->get("club")->result_array() as $club) {
			if ($club['type'] == 'local') {
				foreach ($local_c as $index => $cc) {
					$this->db->insert("club_post_classify", array(
						"club_id"  =>	$club['id'],
						"title"    =>	(($index==0)?$club['show_name']:"").$cc,
						"can_edit" =>	0
					));	
				}
				for ($i=0; $i < rand(0, 4); $i++) { 
					$this->db->insert("club_post_classify", array(
						"club_id"  =>	$club['id'],
						"title"    =>	"自定義".($i+1),
						"can_edit" =>	1
					));	
				}
			}else{
				foreach ($c as $cc) {
					$this->db->insert("club_post_classify", array(
						"club_id"  =>	$club['id'],
						"title"    =>	$cc,
						"can_edit" =>	1
					));	
				}
				for ($i=0; $i < rand(0, 4); $i++) { 
					$this->db->insert("club_post_classify", array(
						"club_id"  =>	$club['id'],
						"title"    =>	"自定義".($i+1),
						"can_edit" =>	1
					));	
				}
			}
		}
	}

	public function generate_post(){
		$content = [
			" 小普林尼告訴我們，天才絕不應鄙視勤奮。強烈建議大家把這段話牢牢記住。話雖如此，帶著這些問題，我們一起來審視溫度。在人類的歷史中，我們總是盡了一切努力想搞懂溫度。若到今天結束時我們都還無法釐清溫度的意義，那想必我們昨天也無法釐清。艾迪生在不經意間這樣說過，愛情不會因為理智而變得淡漠，也不會因為雄心壯志而喪失殆盡。它是第二生命; 它滲入靈魂，溫暖著每一條血管，跳動在每一次脈搏之中。這不禁令我深思。當前最急迫的事，想必就是釐清疑惑了。荀子說過一句發人省思的話，口能言之，身能行之，國寶也; 口不能言，身能行之，國器也; 治國者敬其寶，愛其器。想必各位已經看出了其中的端倪。溫度必定會成為未來世界的新標準。問題的關鍵看似不明確，但想必在諸位心中已有了明確的答案。需要考慮周詳溫度的影響及因應對策。其實，若思緒夠清晰，那麼溫度也就不那麼複雜了。面對如此難題，我們必須設想周全。如果別人做得到，那我也可以做到。經過上述討論，溫度對我來說有著舉足輕重的地位，必須要嚴肅認真的看待。毛澤東說過一句很有意思的話，農業生產是我們經濟建設工作的第一位。這讓我的思緒清晰了。在人生的歷程中，溫度的出現是必然的。對溫度進行深入研究，在現今時代已經無法避免了。

        做好溫度這件事，可以說已經成為了全民運動。李白曾經提過，黃河走東溟，白日落西海，逝川與流光，飄忽不相待。這段話看似複雜，其中的邏輯思路卻清晰可見。培根曾經提過，無論你怎樣地表示憤怒，都不要做出任何無法挽回的事來。這把視野帶到了全新的高度。我們要從本質思考，從根本解決問題。我們一般認為，抓住了問題的關鍵，其他一切則會迎刃而解。我們需要淘汰舊有的觀念，周恩來講過一段深奧的話，願相會於中華騰飛世界時。希望大家能發現話中之話。溫度究竟是怎麼樣的存在，始終是個謎題。在這種不可避免的衝突下，我們必須解決這個問題。若沒有溫度的存在，那麼後果可想而知。儘管如此，我們仍然需要對溫度保持懷疑的態度。在這種困難的抉擇下，本人思來想去，寢食難安。每個人都不得不面對這些問題。在面對這種問題時，務必詳細考慮溫度的各種可能。溫度，到底應該如何實現。所謂溫度，關鍵是溫度需要如何解讀。溫度似乎是一種巧合，但如果我們從一個更大的角度看待問題，這似乎是一種不可避免的事實。世界上若沒有溫度，對於人類的改變可想而知。謹慎地來說，我們必須考慮到所有可能。動機，可以說是最單純的力量。回過神才發現，思考溫度的存在意義，已讓我廢寢忘食。塞萬提斯深信，音樂是耳朵的眼睛。但願諸位理解後能從中有所成長。尼采說過一句富有哲理的話，謙遜基於力量，高傲基於無能。強烈建議大家把這段話牢牢記住。",
			"  從這個角度來看，我們可以很篤定的說，這需要花很多時間來嚴謹地論證。儘管如此，別人往往卻不這麼想。維吉爾深信，愛情，是愛情，推動著世界的發展。這激勵了我。對於一般人來說，溫度究竟象徵著什麼呢？愛因斯坦說過一句富有哲理的話，在科學上，每一條道路都應該走一走，發現一條走不通的道路，就是對科學的一大貢獻。那種證明的吃力不討好的工作，就讓我來做吧！ 我希望諸位也能好好地體會這句話。話雖如此，加繆曾經認為，攀登頂峰，這種奮鬥的本身就足以充實人的心。人們必須相信，壘山不止就是幸福。這段話可說是震撼了我。這是不可避免的。在這種困難的抉擇下，本人思來想去，寢食難安。可是，即使是這樣，溫度的出現仍然代表了一定的意義。若能夠洞悉溫度各種層面的含義，勢必能讓思維再提高一個層級。富蘭克林說過一句很有意思的話，從事一項事情，先要決定志向，志向決定之後就要全力以赴毫不猶豫地去實行。但願各位能從這段話中獲得心靈上的滋長。要想清楚，溫度，到底是一種怎麼樣的存在。愛默生說過一句經典的名言，健康是人生第一財富。這不禁令我深思。如果此時我們選擇忽略溫度，那後果可想而知。

        一般來講，我們都必須務必慎重的考慮考慮。不要先入為主覺得溫度很複雜，實際上，溫度可能比你想的還要更複雜。帶著這些問題，我們一起來審視溫度。我們都有個共識，若問題很困難，那就勢必不好解決。回過神才發現，思考溫度的存在意義，已讓我廢寢忘食。由於，溫度必定會成為未來世界的新標準。貝多芬講過一段耐人尋思的話，把“德性”教給你們的孩子：使人幸福的是德性而非金錢。這是我的經驗之談。在患難中支持我的是道德，使我不曾自殺的，除了藝術以外也是道德。我希望諸位也能好好地體會這句話。需要考慮周詳溫度的影響及因應對策。鄧小平曾經提過，不開空話連篇的會，不發離題的萬里的議論。這句話看似簡單，但其中的陰鬱不禁讓人深思。

        問題的關鍵究竟為何？溫度似乎是一種巧合，但如果我們從一個更大的角度看待問題，這似乎是一種不可避免的事實。溫度因何而發生？探討溫度時，如果發現非常複雜，那麼想必不簡單。加里寧曾經提到過，愛勞動是共產主義道德主要成分之一。但只有在工人階級獲得勝利以後，人類生活不可缺少的條件——勞動，才不會是沉重而可恥的負擔，而成為榮譽和英勇的事業。這似乎解答了我的疑惑。周恩來講過一段耐人尋思的話，浮舟滄海，立馬崑崙。這啟發了我。在人生的歷程中，溫度的出現是必然的。這種事實對本人來說意義重大，相信對這個世界也是有一定意義的。",
			"  培根曾說過一句意義深遠的話，人們說得好，真理是時間的女兒，不是權威的女兒。這段話對世界的改變有著深遠的影響。深入的探討溫度，是釐清一切的關鍵。話雖如此，我們卻也不能夠這麼篤定。普希金講過一段耐人尋思的話，對女人愈冷淡反而愈能得到她的注意。這激勵了我。溫度因何而發生？由於，溫度的出現，重寫了人生的意義。領悟其中的道理也不是那麼的困難。陸游曾經說過，衣上征塵雜酒痕，遠遊無處不消魂。希望大家實際感受一下這段話。我想，把溫度的意義想清楚，對各位來說並不是一件壞事。若發現問題比我們想像的還要深奧，那肯定不簡單。在人類的歷史中，我們總是盡了一切努力想搞懂溫度。拉蒙納斯說過一句很有意思的話，良心是公正廉潔的法官。這句話決定了一切。透過逆向歸納，得以用最佳的策略去分析溫度。每個人的一生中，幾乎可說碰到溫度這件事，是必然會發生的。世界需要改革，需要對溫度有新的認知。我們都很清楚，這是個嚴謹的議題。面對如此難題，我們必須設想周全。儘管如此，別人往往卻不這麼想。溫度對我來說，已經成為了我生活的一部分。而這些並不是完全重要，更加重要的問題是，我們要學會站在別人的角度思考。帶著這些問題，我們一起來審視溫度。若能夠欣賞到溫度的美，相信我們一定會對溫度改觀。老舊的想法已經過時了。我們可以很篤定的說，這需要花很多時間來嚴謹地論證。

        阿拉伯說過，治愈愛情創傷的好藥是沒有的。我希望諸位也能好好地體會這句話。康有為說過一句著名的話，太平之世無所尚，所最尚者工而已; 太平之世無所尊，所尊貴者工之創新器而已。請諸位將這段話在心中默念三遍。當你搞懂後就會明白了。探討溫度時，如果發現非常複雜，那麼想必不簡單。如果別人做得到，那我也可以做到。這種事實對本人來說意義重大，相信對這個世界也是有一定意義的。溫度對我來說有著舉足輕重的地位，必須要嚴肅認真的看待。回過神才發現，思考溫度的存在意義，已讓我廢寢忘食。彼特拉克曾經提到過，能的把自己的愛說得天花亂墜的人，實際上愛得併不深。這段話讓我所有的疑惑頓時豁然開朗。溫度絕對是史無前例的。我們需要淘汰舊有的觀念，我們要從本質思考，從根本解決問題。溫度似乎是一種巧合，但如果我們從一個更大的角度看待問題，這似乎是一種不可避免的事實。我們一般認為，抓住了問題的關鍵，其他一切則會迎刃而解。儘管如此，我們仍然需要對溫度保持懷疑的態度。一般來講，我們都必須務必慎重的考慮考慮。伏爾泰曾講過，祖國是我們心心嚮往的地方。這是撼動人心的。說到溫度，你會想到什麼呢？把溫度輕鬆帶過，顯然並不適合。對於一般人來說，溫度究竟象徵著什麼呢？",
			" 世界上若沒有溫度，對於人類的改變可想而知。吳玉章曾講過，人生在世，事業為重。這段話令我陷入了沈思。溫度可以說是有著成為常識的趨勢。不難發現，問題在於該用什麼標準來做決定呢？溫度究竟是怎麼樣的存在，始終是個謎題。若無法徹底理解溫度，恐怕會是人類的一大遺憾。所謂溫度，關鍵是溫度需要如何解讀。溫度必定會成為未來世界的新標準。華羅庚說過一句經典的名言，科學的靈感，決不是坐等可以等來的。如果說，科學上的發現有什麼偶然的機遇的話，那麼這種“偶然的機遇”只能給那些學有素養的人，給那些善於獨立思考的人，給那些具有鍥而不捨的精神的人，而不會給懶漢。這影響了我的價值觀。面對如此難題，我們必須設想周全。溫度對我來說有著舉足輕重的地位，必須要嚴肅認真的看待。一般來說，就我個人來說，溫度對我的意義，不能不說非常重大。當你搞懂後就會明白了。如果仔細思考溫度，會發現其中蘊含的深遠意義。這樣看來，動機，可以說是最單純的力量。謝覺哉說過一句富有哲理的話，說話不在多，在於說得對，說中了事和理的要害，能打動聽者的心。希望大家實際感受一下這段話。我以為我了解溫度，但我真的了解溫度嗎？仔細想想，我對溫度的理解只是皮毛而已。切斯特頓相信，理智本身是一種信仰。它是一種確定自己思想和現實之間關係的信仰。這段話對世界的改變有著深遠的影響。從這個角度來看，溫度因何而發生？若能夠欣賞到溫度的美，相信我們一定會對溫度改觀。

        溫度絕對是史無前例的。溫度的出現，重寫了人生的意義。肖伯納深信，人生不是一支短短的蠟燭，而是一支暫時由我們拿著的火炬。我們一定要把它燃得十分光明燦爛，然後交給下一代的人們。希望大家能發現話中之話。透過逆向歸納，得以用最佳的策略去分析溫度。既然如此，溫度的存在，令我無法停止對他的思考。俗話說的好，掌握思考過程，也就掌握了溫度。希臘講過一段深奧的話，人不是受事的困撓，而是受自己對事所存在的念頭的困撓。這不禁令我深思。在人類的歷史中，我們總是盡了一切努力想搞懂溫度。對我個人而言，溫度不僅僅是一個重大的事件，還可能會改變我的人生。總結來說，富蘭克林說過一句著名的話，人生應為生存而食，不應為食而生存。我希望諸位也能好好地體會這句話。而這些並不是完全重要，更加重要的問題是，德謨克利特說過一句富有哲理的話，不要企圖無所不知，否則你將一無所知。強烈建議大家把這段話牢牢記住。我們要從本質思考，從根本解決問題。做好溫度這件事，可以說已經成為了全民運動。溫度似乎是一種巧合，但如果我們從一個更大的角度看待問題，這似乎是一種不可避免的事實。",
			"   在這種困難的抉擇下，本人思來想去，寢食難安。經過上述討論，說到溫度，你會想到什麼呢？看看別人，再想想自己，會發現問題的核心其實就在你身旁。溫度改變了我的命運。在這種不可避免的衝突下，我們必須解決這個問題。問題的關鍵究竟為何？司馬遷講過一句值得人反覆尋思的話，規小節者不能成榮名，惡小恥者不能立大功。強烈建議大家把這段話牢牢記住。德謨克里特相信，以一種邪惡的、不智的、失節的和不潔的方式活著，就不僅是很壞地活著，而且是在繼續不斷地死亡。這把視野帶到了全新的高度。溫度的出現，必將帶領人類走向更高的巔峰。我們要從本質思考，從根本解決問題。要想清楚，溫度，到底是一種怎麼樣的存在。寧波天童寺聯曾說過，懷中一寸心，千載永不易。但願各位能從這段話中獲得心靈上的滋長。總結來說，這是不可避免的。一般來說，若沒有溫度的存在，那麼後果可想而知。那麼，從這個角度來看，把溫度輕鬆帶過，顯然並不適合。若到今天結束時我們都還無法釐清溫度的意義，那想必我們昨天也無法釐清。溫度可以說是有著成為常識的趨勢。溫度似乎是一種巧合，但如果我們從一個更大的角度看待問題，這似乎是一種不可避免的事實。梭羅講過一段深奧的話，一切經得起再度閱讀的語言，一定值得再度思索。這句話看似簡單，但其中的陰鬱不禁讓人深思。

        既然如此，動機，可以說是最單純的力量。世界需要改革，需要對溫度有新的認知。深入的探討溫度，是釐清一切的關鍵。了解清楚溫度到底是一種怎麼樣的存在，是解決一切問題的關鍵。每個人的一生中，幾乎可說碰到溫度這件事，是必然會發生的。不難發現，問題在於該用什麼標準來做決定呢？這種事實對本人來說意義重大，相信對這個世界也是有一定意義的。如果此時我們選擇忽略溫度，那後果可想而知。話雖如此，我們卻也不能夠這麼篤定。探討溫度時，如果發現非常複雜，那麼想必不簡單。生活中，若溫度出現了，我們就不得不考慮它出現了的事實。問題的核心究竟是什麼？世界上若沒有溫度，對於人類的改變可想而知。我以為我了解溫度，但我真的了解溫度嗎？仔細想想，我對溫度的理解只是皮毛而已。領悟其中的道理也不是那麼的困難。帶著這些問題，我們一起來審視溫度。溫度對我來說，已經成為了我生活的一部分。溫度對我來說有著舉足輕重的地位，必須要嚴肅認真的看待。

        泰戈爾講過一句值得人反覆尋思的話，宗教就會像財富、榮譽或家族那樣，僅僅成為一種人們引以自豪的東西。這段話非常有意思。所謂溫度，關鍵是溫度需要如何解讀。",
			"  不要先入為主覺得溫度很複雜，實際上，溫度可能比你想的還要更複雜。車爾尼雪夫斯基告訴我們，應該堅信，思想和內容不是通過沒頭沒腦的感傷，而是通過思考而得到的。這句話幾乎解讀出了問題的根本。希臘說過一句著名的話，無論誰，只要他還活著，你就不能稱他是幸福的。這段話雖短，卻足以改變人類的歷史。魯迅講過一段深奧的話，社會上崇敬名人，於是以為名人的話就是名言，卻忘記了他所以得名是那一種學問和事業。這句話令我不禁感慨問題的迫切性。話雖如此，我們卻也不能夠這麼篤定。

        溫度對我來說有著舉足輕重的地位，必須要嚴肅認真的看待。劉基說過一句經典的名言，凡與敵戰，須務持重。見利則動，不見利則止，慎不可輕舉也。這句話看似簡單，但其中的陰鬱不禁讓人深思。每個人的一生中，幾乎可說碰到溫度這件事，是必然會發生的。魯迅曾經說過，時間，就像海綿里的水，只要願擠，總還是有的。這段話的餘韻不斷在我腦海中迴盪著。總而言之，動機，可以說是最單純的力量。羅威爾講過一段耐人尋思的話，在愛心稀少的地方所犯的過錯就越多。這句話讓我們得到了一個全新的觀點去思考這個問題。林逋講過，和以處眾，寬以待下，恕以待人，君子人也。希望大家能從這段話中有所收穫。我們都有個共識，若問題很困難，那就勢必不好解決。溫度的發生，到底需要如何實現，不溫度的發生，又會如何產生。一般來講，我們都必須務必慎重的考慮考慮。總結來說，若能夠欣賞到溫度的美，相信我們一定會對溫度改觀。羅大經曾經提過，住世一日，則做一日好人，居官一日，則做一日好事。這句話令我不禁感慨問題的迫切性。孔子說過一句很有意思的話，君子謀道不謀食，憂道不憂貧。這啟發了我。這樣看來，對於一般人來說，溫度究竟象徵著什麼呢？當前最急迫的事，想必就是釐清疑惑了。面對如此難題，我們必須設想周全。每個人都不得不面對這些問題。在面對這種問題時，務必詳細考慮溫度的各種可能。如果仔細思考溫度，會發現其中蘊含的深遠意義。毛澤東講過一段深奧的話，天下者，得之艱難，則失之不易; 這啟發了我。由於，司各特曾講過，拌著眼淚的愛情是最動人的。這似乎解答了我的疑惑。伏契克說過一句很有意思的話，忠實於理想——這是崇高而又有力的一種感情，這種感情和最殘酷的壓迫相對抗，這種感情甚至在危急萬分的時刻也仍存於人的心中。但願諸位理解後能從中有所成長。菲爾丁講過一段耐人尋思的話，夫妻之所以不能相互理解是因為他。這讓我的思緒清晰了。

        一般來說，西德尼相信，做好事是人生中唯一確實快樂的行動。這段話讓我所有的疑惑頓時豁然開朗。",
			"   看看別人，再想想自己，會發現問題的核心其實就在你身旁。聶夷中曾經提到過，男兒徇大義，立節不沽名。希望大家實際感受一下這段話。我們要學會站在別人的角度思考。不要先入為主覺得溫度很複雜，實際上，溫度可能比你想的還要更複雜。了解清楚溫度到底是一種怎麼樣的存在，是解決一切問題的關鍵。對溫度進行深入研究，在現今時代已經無法避免了。老舍說過一句經典的名言，哲人的智慧，加上孩子的天真，或者就能成個好作家了。這似乎解答了我的疑惑。如果別人做得到，那我也可以做到。這樣看來，透過逆向歸納，得以用最佳的策略去分析溫度。

        溫度必定會成為未來世界的新標準。老舊的想法已經過時了。就我個人來說，溫度對我的意義，不能不說非常重大。梁啟超曾說過一句意義深遠的話，人生須知負責任的苦處，才能知道有盡責的樂趣。這段話雖短，卻足以改變人類的歷史。溫度的存在，令我無法停止對他的思考。司各特在過去曾經講過，拌著眼淚的愛情是最動人的。這似乎解答了我的疑惑。溫度因何而發生？溫度，發生了會如何，不發生又會如何。謹慎地來說，我們必須考慮到所有可能。每個人都不得不面對這些問題。在面對這種問題時，務必詳細考慮溫度的各種可能。魯迅講過一句值得人反覆尋思的話，“一勞永逸”的話，有是有的，而“一勞永逸”的事卻極少。這不禁令我重新仔細的思考。問題的關鍵看似不明確，但想必在諸位心中已有了明確的答案。若發現問題比我們想像的還要深奧，那肯定不簡單。周恩來曾經認為，願相會於中華騰飛世界時。但願各位能從這段話中獲得心靈上的滋長。我認為，",
			"     看看別人，再想想自己，會發現問題的核心其實就在你身旁。聶夷中曾經提到過，男兒徇大義，立節不沽名。希望大家實際感受一下這段話。我們要學會站在別人的角度思考。不要先入為主覺得溫度很複雜，實際上，溫度可能比你想的還要更複雜。了解清楚溫度到底是一種怎麼樣的存在，是解決一切問題的關鍵。對溫度進行深入研究，在現今時代已經無法避免了。老舍說過一句經典的名言，哲人的智慧，加上孩子的天真，或者就能成個好作家了。這似乎解答了我的疑惑。如果別人做得到，那我也可以做到。這樣看來，透過逆向歸納，得以用最佳的策略去分析溫度。

        溫度必定會成為未來世界的新標準。老舊的想法已經過時了。就我個人來說，溫度對我的意義，不能不說非常重大。梁啟超曾說過一句意義深遠的話，人生須知負責任的苦處，才能知道有盡責的樂趣。這段話雖短，卻足以改變人類的歷史。溫度的存在，令我無法停止對他的思考。司各特在過去曾經講過，拌著眼淚的愛情是最動人的。這似乎解答了我的疑惑。溫度因何而發生？溫度，發生了會如何，不發生又會如何。謹慎地來說，我們必須考慮到所有可能。每個人都不得不面對這些問題。在面對這種問題時，務必詳細考慮溫度的各種可能。魯迅講過一句值得人反覆尋思的話，“一勞永逸”的話，有是有的，而“一勞永逸”的事卻極少。這不禁令我重新仔細的思考。問題的關鍵看似不明確，但想必在諸位心中已有了明確的答案。若發現問題比我們想像的還要深奧，那肯定不簡單。周恩來曾經認為，願相會於中華騰飛世界時。但願各位能從這段話中獲得心靈上的滋長。我認為，其實，若思緒夠清晰，那麼溫度也就不那麼複雜了。溫度勢必能夠左右未來。我們需要淘汰舊有的觀念，若無法徹底理解溫度，恐怕會是人類的一大遺憾。現在，正視溫度的問題，是非常非常重要的。因為，對於一般人來說，溫度究竟象徵著什麼呢？巴爾扎克說過一句發人省思的話，人生是各種不同的變故、循環不已的痛苦和歡樂組成的。那種永遠不變的藍天只存在於心靈中間，向現實的人生去要求未免是奢望。但願各位能從這段話中獲得心靈上的滋長。穆爾曾說過，友誼要像愛情一樣才溫暖人心，愛情要像友誼一樣才牢不可破。這段話非常有意思。溫度，到底應該如何實現。德皇威廉二世在過去曾經講過，君主乃至高無上的法。這段話對世界的改變有著深遠的影響。帶著這些問題，我們一起來審視溫度。問題的核心究竟是什麼？那麼，需要考慮周詳溫度的影響及因應對策。無名者相信，感激每一個新的挑戰，因為它會鍛造你的意志和品格。這似乎解答了我的疑惑。對我個人而言，溫度不僅僅是一個重大的事件，還可能會改變我的人生。",
			" 愛默生在過去曾經講過，超越觀眾的水平是極不容易的。你那拙劣的演技一旦使觀眾感到滿意，就很難再提高了。他會這麼說是有理由的。生活中，若溫度出現了，我們就不得不考慮它出現了的事實。要想清楚，溫度，到底是一種怎麼樣的存在。泰格奈爾講過一句值得人反覆尋思的話，知心朋友相隔千山萬水，也似近在咫尺。這段話可說是震撼了我。溫度的出現，必將帶領人類走向更高的巔峰。透過逆向歸納，得以用最佳的策略去分析溫度。既然如此，儘管溫度看似不顯眼，卻佔據了我的腦海。徐志摩說過，由於我們過於習慣在別人面前戴面具，因此最後導致在自己面前偽裝自己。希望大家實際感受一下這段話。我以為我了解溫度，但我真的了解溫度嗎？仔細想想，我對溫度的理解只是皮毛而已。培根告訴我們，友誼的主要效用之一就在使人心中的憤懣抑鬱之氣得以宣洩弛放，這些不平凡之氣是各種的情感都可以引起的。想必各位已經看出了其中的端倪。溫度必定會成為未來世界的新標準。我們都很清楚，這是個嚴謹的議題。問題的關鍵究竟為何？對溫度進行深入研究，在現今時代已經無法避免了。

        特賴因在不經意間這樣說過，且不論好壞與否行為習慣，這就是人生的規律。這句話令我不禁感慨問題的迫切性。就我個人來說，溫度對我的意義，不能不說非常重大。可是，即使是這樣，溫度的出現仍然代表了一定的意義。賀拉斯在不經意間這樣說過，財富就像海水：你喝得越多，你就越感到渴。帶著這句話，我們還要更加慎重的審視這個問題。每個人都不得不面對這些問題。在面對這種問題時，務必詳細考慮溫度的各種可能。左拉說過一句富有哲理的話，一個社會，只有當他把真理公之於眾時，才會強而有力。這段話令我陷入了沈思。對我個人而言，溫度不僅僅是一個重大的事件，還可能會改變我的人生。溫度究竟是怎麼樣的存在，始終是個謎題。從這個角度來看，儘管如此，我們仍然需要對溫度保持懷疑的態度。

        我們不得不相信，我認為，王符說過一句著名的話，賢愚在心，不在貴賤。這段話可說是震撼了我。面對如此難題，我們必須設想周全。問題的關鍵看似不明確，但想必在諸位心中已有了明確的答案。愛獻森告訴我們，科學絕不是一種自私的享受，有幸。這句話令我不禁感慨問題的迫切性。我們需要淘汰舊有的觀念，聖伯夫講過一段耐人尋思的話，大多數人都生活在一種濫用才能、出賣榮譽的狀態下。這段話看似複雜，其中的邏輯思路卻清晰可見。列寧在過去曾經講過，童話不只是兒童們享用的食品。希望大家能從這段話中有所收穫。",
			"對於一般人來說，溫度究竟象徵著什麼呢？儘管溫度看似不顯眼，卻佔據了我的腦海。這必定是個前衛大膽的想法。蕭伯納曾經說過，對我來說，在享受人生的樂趣方面，有錢和沒錢的差別是微乎其微的。在我這一種人看來，金錢就是安全和避免小苛政的工具：假使社會能給予我這兩件東西，我將要將我的錢拋到窗外去，因為保管金錢是很麻煩的事情，而且又吸引寄生蟲，並且招來人們的忌恨。希望各位能用心體會這段話。老宣相信，處治世，為好人易。處亂世，為好人難。處治世，生活容易環境安和，縱然不去為惡，也算不了一個好人。正如一個女子，衣食不缺，且日與一群賢婦女同居，而能不賣淫，那還能稱好為賢女麼？處亂世，生活艱難環境惡劣，偏要努力學好，才真算一個好人。正如一個女子，衣食兩缺，且日與一群娼妓蕩婦同處，而能清白自守，那才配稱她為貞女呢。這句話讓我們得到了一個全新的觀點去思考這個問題。我們普遍認為，若能理解透徹核心原理，對其就有了一定的了解程度。溫度究竟是怎麼樣的存在，始終是個謎題。

        阿拉伯曾經提到過，你可以相信一座山移動了位置，卻不必去相信一個人改變了自己的個性。這是撼動人心的。我們都有個共識，若問題很困難，那就勢必不好解決。溫度的存在，令我無法停止對他的思考。溫度的出現，必將帶領人類走向更高的巔峰。溫度改變了我的命運。其實，若思緒夠清晰，那麼溫度也就不那麼複雜了。雨果說過，人有了物質才能生存; 人有了理想才談得上生活。你要了解生存與生活的不同嗎？動物生存，而人則生活。強烈建議大家把這段話牢牢記住。若無法徹底理解溫度，恐怕會是人類的一大遺憾。現在，正視溫度的問題，是非常非常重要的。因為，李苦禪在不經意間這樣說過，鳥欲高飛先振翅，人求上進先讀書。希望大家能發現話中之話。若發現問題比我們想像的還要深奧，那肯定不簡單。貝克萊主教說過一句富有哲理的話，誰若總說世界無好人，你可以斷定他本就是個歹徒。這讓我的思緒清晰了。如果此時我們選擇忽略溫度，那後果可想而知。溫度，到底應該如何實現。愛因斯坦曾經提到過，在一個崇高的目的支持下，不停地工作，即使慢、也一定會獲得成功。這句話令我不禁感慨問題的迫切性。如果仔細思考溫度，會發現其中蘊含的深遠意義。我們不得不面對一個非常尷尬的事實，那就是，生活中，若溫度出現了，我們就不得不考慮它出現了的事實。儘管如此，我們仍然需要對溫度保持懷疑的態度。問題的關鍵看似不明確，但想必在諸位心中已有了明確的答案。

        需要考慮周詳溫度的影響及因應對策。",
			"        我們不妨可以這樣來想: 就我個人來說，溫度對我的意義，不能不說非常重大。既然，在這種不可避免的衝突下，我們必須解決這個問題。我們要從本質思考，從根本解決問題。溫度因何而發生？每個人的一生中，幾乎可說碰到溫度這件事，是必然會發生的。俗話說的好，掌握思考過程，也就掌握了溫度。世界上若沒有溫度，對於人類的改變可想而知。話雖如此，每個人都不得不面對這些問題。在面對這種問題時，務必詳細考慮溫度的各種可能。忒壬斯深信，討飯三年懶做官。請諸位將這段話在心中默念三遍。溫度的存在，令我無法停止對他的思考。生活中，若溫度出現了，我們就不得不考慮它出現了的事實。看看別人，再想想自己，會發現問題的核心其實就在你身旁。我們需要淘汰舊有的觀念，我們普遍認為，若能理解透徹核心原理，對其就有了一定的了解程度。如果仔細思考溫度，會發現其中蘊含的深遠意義。巴爾扎克曾經提過，愛情抵抗不住繁瑣的家務，必須至少有一方品質極堅強。這讓我對於看待這個問題的方法有了巨大的改變。探討溫度時，如果發現非常複雜，那麼想必不簡單。伏爾泰說過一句著名的話，拜讀名家大作，可造就雄辯之才。這把視野帶到了全新的高度。而這些並不是完全重要，更加重要的問題是，伊索說過一句富有哲理的話，我們應該注重內心，而不應該只看外貌。希望各位能用心體會這段話。現在，正視溫度的問題，是非常非常重要的。因為，需要考慮周詳溫度的影響及因應對策。儘管溫度看似不顯眼，卻佔據了我的腦海。說到溫度，你會想到什麼呢？尼采講過，害蟲叮人不是出於惡意，而是因為它們要維持生命。批評家也一樣他們需要我們的血而不是痛苦。但願各位能從這段話中獲得心靈上的滋長。柯爾律治曾講過，一個飽經風霜而又明智的人，定能雄飛於明天的早晨。想必各位已經看出了其中的端倪。面對如此難題，我們必須設想周全。阿拉伯說過一句發人省思的話，斃虎者飽餐虎肉，畏虎者葬身虎口。帶著這句話，我們還要更加慎重的審視這個問題。問題的關鍵看似不明確，但想必在諸位心中已有了明確的答案。老舊的想法已經過時了。這必定是個前衛大膽的想法。本人也是經過了深思熟慮，在每個日日夜夜思考這個問題。笛卡兒深信，閱讀一切好書如同和過去最傑出的人談話。這不禁令我重新仔細的思考。對於一般人來說，溫度究竟象徵著什麼呢？如果別人做得到，那我也可以做到。溫度的發生，到底需要如何實現，不溫度的發生，又會如何產生。毛澤東說過一句著名的話，黨的政策是黨的生命。但願諸位理解後能從中有所成長。在人生的歷程中，溫度的出現是必然的。王業寧講過，要創新需要一定的靈感，這靈感不是天生的，而是來自長期的積累與全身心的投入。沒有積累就不會有創新。帶著這句話，我們還要更加慎重的",
			"千拉線益驗學國書遊多家樂有經目預為取持他算",
			"溫度的出現，必將帶領人類走向更高的巔峰。當前最急迫的事，想必就是釐清疑惑了。

        那麼，每個人的一生中，幾乎可說碰到溫度這件事，是必然會發生的。既然，說到溫度，你會想到什麼呢？溫度因何而發生？對溫度進行深入研究，在現今時代已經無法避免了。我想，把溫度的意義想清楚，對各位來說並不是一件壞事。西塞羅講過一段耐人尋思的話，因為不為全體人類所共有的權利決不是什麼權利。這段話可說是震撼了我。羅高曾經提到過，以酒交友，與酒一樣，僅一晚而已。希望各位能用心體會這段話。謹慎地來說，我們必須考慮到所有可能。盧梭說過，生活得最有意義的人，並不就是年歲活得最長的人，而是對生活最有感受的人。這句話讓我們得到了一個全新的觀點去思考這個問題。由於，肖伯納曾經說過，人生不是一支短短的蠟燭，而是一支暫時由我們拿著的火炬。我們一定要把它燃得十分光明燦爛，然後交給下一代的人們。這啟發了我。

        溫度改變了我的命運。溫度對我來說有著舉足輕重的地位，必須要嚴肅認真的看待。溫度勢必能夠左右未來。吳耕民說過一句經典的名言，要成為德、智、體兼優的勞動者，鍛煉身體極為重要。身體健康是求學和將來工作之本。運動能治百病，能使人身體健康，頭腦敏捷，對學習有促進作用。這影響了我的價值觀。不要先入為主覺得溫度很複雜，實際上，溫度可能比你想的還要更複雜。契訶夫說過一句著名的話，人在智慧上、精神上的發達程度越高，人就越自由，人生就越能獲得莫大的滿足。這不禁令我深思。溫度，到底應該如何實現。世界需要改革，需要對溫度有新的認知。話雖如此，我們卻也不能夠這麼篤定。韓愈說過一句著名的話，蚍蜉撼大樹，可笑不自量。這讓我的思緒清晰了。老舊的想法已經過時了。溫度的發生，到底需要如何實現，不溫度的發生，又會如何產生。話雖如此，我們不得不面對一個非常尷尬的事實，那就是，不難發現，問題在於該用什麼標準來做決定呢？其實，若思緒夠清晰，那麼溫度也就不那麼複雜了。

        奧維德相信，大家都畏懼的人，等待他的將是身敗名裂。這段話雖短，卻足以改變人類的歷史。陶行知曾經認為，把自己的私德健全起來，建築起“人格長城”來。由私德的健全，而擴大公德的效用，來為集體謀利益。但願諸位理解後能從中有所成長。廣瀨淡窗曾講過，詩如禪機，在於參悟。這似乎解答了我的疑惑。

        溫度的出現，重寫了人生的意義。",
			" 儘管如此，別人往往卻不這麼想。在這種不可避免的衝突下，我們必須解決這個問題。由於，若能夠洞悉溫度各種層面的含義，勢必能讓思維再提高一個層級。這必定是個前衛大膽的想法。了解清楚溫度到底是一種怎麼樣的存在，是解決一切問題的關鍵。一般來說，這是不可避免的。我們不得不相信，托爾斯泰講過一段耐人尋思的話，你沒有最有效地使用而把它放過去的那個鐘點是永遠不能回來了。這句話反映了問題的急切性。問題的核心究竟是什麼？儘管如此，我們仍然需要對溫度保持懷疑的態度。透過逆向歸納，得以用最佳的策略去分析溫度。恩格斯說過一句很有意思的話，複雜的勞動包含著需要耗費或多或少的辛勞、時間和金錢去獲得的技巧和知識的運用。這段話雖短，卻足以改變人類的歷史。想必大家都能了解溫度的重要性。溫度的發生，到底需要如何實現，不溫度的發生，又會如何產生。在人生的歷程中，溫度的出現是必然的。

        總而言之，總結來說，海伍德在不經意間這樣說過，驕傲的人將有失敗之日。這句話改變了我的人生。就我個人來說，溫度對我的意義，不能不說非常重大。若到今天結束時我們都還無法釐清溫度的意義，那想必我們昨天也無法釐清。溫度勢必能夠左右未來。面對如此難題，我們必須設想周全。現在，正視溫度的問題，是非常非常重要的。因為，溫度究竟是怎麼樣的存在，始終是個謎題。金纓說過一句著名的話，傷心之語，毒於陰冰。這段話讓我的心境提高了一個層次。這種事實對本人來說意義重大，相信對這個世界也是有一定意義的。老舊的想法已經過時了。這樣看來，溫度的出現，必將帶領人類走向更高的巔峰。溫度似乎是一種巧合，但如果我們從一個更大的角度看待問題，這似乎是一種不可避免的事實。既然，對於一般人來說，溫度究竟象徵著什麼呢？溫度，到底應該如何實現。赫茲里特在不經意間這樣說過，有虛榮心的人在不幸中建立功績，在恥辱中取得勝利。我希望諸位也能好好地體會這句話。陸世儀說過一句富有哲理的話，寬收嚴試，久任超遷。此八字，用人之良法。這句話決定了一切。托克維爾講過一段耐人尋思的話，生活不是苦難，也不是享樂，而是我們應當為之奮鬥並堅持到底的事業。這讓我對於看待這個問題的方法有了巨大的改變。看看別人，再想想自己，會發現問題的核心其實就在你身旁。溫度對我來說，已經成為了我生活的一部分。世界上若沒有溫度，對於人類的改變可想而知。

        深入的探討溫度，是釐清一切的關鍵。馬克思曾經認為，歷史認不那些專為公共謀福利從而自己也高尚起來的人物是偉大的。經驗證明能使大多數人得到幸福的人，他本身也是最幸福的。這句話改變了我的人生。",
			"回過神才發現，思考溫度的存在意義，已讓我廢寢忘食。溫度對我來說，已經成為了我生活的一部分。這必定是個前衛大膽的想法。約爾旦告訴我們，為自己尋求庸俗乏味的生活的人，才是真正可憐而渺小的。這影響了我的價值觀。動機，可以說是最單純的力量。看看別人，再想想自己，會發現問題的核心其實就在你身旁。我以為我了解溫度，但我真的了解溫度嗎？仔細想想，我對溫度的理解只是皮毛而已。當你搞懂後就會明白了。溫度絕對是史無前例的。我們不妨可以這樣來想: 普羅提諾深信，宇宙永遠不會變老。這句話看似簡單，但其中的陰鬱不禁讓人深思。每個人都不得不面對這些問題。在面對這種問題時，務必詳細考慮溫度的各種可能。本人也是經過了深思熟慮，在每個日日夜夜思考這個問題。溫度可以說是有著成為常識的趨勢。如果別人做得到，那我也可以做到。溫度對我來說有著舉足輕重的地位，必須要嚴肅認真的看待。其實，若思緒夠清晰，那麼溫度也就不那麼複雜了。透過逆向歸納，得以用最佳的策略去分析溫度。陸游講過一句值得人反覆尋思的話，衣上征塵雜酒痕，遠遊無處不消魂。強烈建議大家把這段話牢牢記住。探討溫度時，如果發現非常複雜，那麼想必不簡單。聖經說過一句著名的話，應當趨著有光行走，免得黑暗臨到你們。強烈建議大家把這段話牢牢記住。我們普遍認為，若能理解透徹核心原理，對其就有了一定的了解程度。從這個角度來看，現在，正視溫度的問題，是非常非常重要的。因為，克勞德蘭納新曾經提到過，貪婪者總是一貧如洗。這影響了我的價值觀。陳亨初曾經認為，誰如果說：“我是最美麗的人。”那麼他醜已公之於眾。這句話令我不禁感慨問題的迫切性。若無法徹底理解溫度，恐怕會是人類的一大遺憾。米貝爾曾提出，有恬靜的心靈就等於把握住心靈的全部; 有穩定的精神就等於能指揮自己！ 這讓我對於看待這個問題的方法有了巨大的改變。俗話說的好，掌握思考過程，也就掌握了溫度。領悟其中的道理也不是那麼的困難。對溫度進行深入研究，在現今時代已經無法避免了。拉斯金曾經提到過，一個人專心於本身的時候，他充其量也只能成為一個美麗，小巧的包裹而已。希望各位能用心體會這段話。溫度究竟是怎麼樣的存在，始終是個謎題。既然，我們都很清楚，這是個嚴謹的議題。若能夠欣賞到溫度的美，相信我們一定會對溫度改觀。我們都有個共識，若問題很困難，那就勢必不好解決。緒儒斯在過去曾經講過，一樣東西的價值在於購買者願出多少錢。這啟發了我。如果仔細思考溫度，會發現其中蘊含的深遠意義。在這種不可避免的衝突下，我們必須解決這個問題。了解清楚溫度到底是一種怎麼樣的存在，是解決一切問題的關鍵。總而言之，對我個人而言，溫度不僅僅是一個重大的事件，還可能會改變我的人生。儘管如此，我們仍然需要對溫度保持懷疑的態度。",
			"我認為，若沒有溫度的存在，那麼後果可想而知。由於，若無法徹底理解溫度，恐怕會是人類的一大遺憾。

        荀子曾提出，仁義禮善之於人也，闢之若貨財粟米之於家也。這句話反映了問題的急切性。俗話說的好，掌握思考過程，也就掌握了溫度。如果此時我們選擇忽略溫度，那後果可想而知。老舊的想法已經過時了。話雖如此，王爾德曾經提到過，亞當不過是凡人這就解釋了一切。這句話令我不禁感慨問題的迫切性。

        鄧拓在過去曾經講過，越是沒有本領的就越加自命不凡。我希望諸位也能好好地體會這句話。如果別人做得到，那我也可以做到。深入的探討溫度，是釐清一切的關鍵。儘管如此，別人往往卻不這麼想。世界需要改革，需要對溫度有新的認知。溫度勢必能夠左右未來。我們不得不面對一個非常尷尬的事實，那就是，動機，可以說是最單純的力量。溫度的存在，令我無法停止對他的思考。溫度對我來說有著舉足輕重的地位，必須要嚴肅認真的看待。巴爾扎克在過去曾經講過，人民至上就是：件件政治大事，要向人民請教。帶著這句話，我們還要更加慎重的審視這個問題。想必大家都能了解溫度的重要性。問題的關鍵看似不明確，但想必在諸位心中已有了明確的答案。溫度絕對是史無前例的。現在，正視溫度的問題，是非常非常重要的。因為，若能夠欣賞到溫度的美，相信我們一定會對溫度改觀。溫度可以說是有著成為常識的趨勢。不要先入為主覺得溫度很複雜，實際上，溫度可能比你想的還要更複雜。斯威夫特講過一段深奧的話，誠實永生不滅。這影響了我的價值觀。蕭爾夫曾說過一句意義深遠的話，空閒能腐化一個人，絕對的空閒便能徹底地腐化人們。帶著這句話，我們還要更加慎重的審視這個問題。傅玄曾經認為，近朱者赤，近墨者黑。想必各位已經看出了其中的端倪。本人也是經過了深思熟慮，在每個日日夜夜思考這個問題。這種事實對本人來說意義重大，相信對這個世界也是有一定意義的。魯訊曾講過，忍看朋輩成新鬼，怒向刀叢覓小詩。這啟發了我。這樣看來，愛默生曾經提過，餵，你可曾聽說才思也許能在青春年少時獲得，智慧也許會在腐朽前成熟？ 帶著這句話，我們還要更加慎重的審視這個問題。謹慎地來說，我們必須考慮到所有可能。俾斯麥講過，如果人生的途程上沒有障礙，人還有什麼可做的呢。這句話改變了我的人生。溫度的出現，必將帶領人類走向更高的巔峰。總結來說，可是，即使是這樣，溫度的出現仍然代表了一定的意義。需要考慮周詳溫度的影響及因應對策。生活中，若溫度出現了，我們就不得不考慮它出現了的事實。",
		];

		$user = $this->db->get("user")->result_array();
		$club = $this->db->get_where("club", array("is_delete"=>0))->result_array();

		for ($i=0; $i < 2000; $i++) { 
			$u_r = rand(0, count($user) - 1);
			$c_r = rand(0, count($club) - 1);
			$con_r = rand(0, count($content) - 1);
			$data = array(
				"user_id"     =>	$user[$u_r]['id'],
				"post_at"     =>	"club",
				"relation_id" =>	$club[$c_r]['id'],
				"title"       =>	mb_substr($content[$con_r], 0, 6),
				"summary"     =>	$content[$con_r],
				"status"      =>	"publish"
			);

			$post_id = $this->Post_model->add_post($data);
			if ($post_id !== FALSE) {
				$detail = array(
					"post_id"	=>	$post_id,
					"content"	=>	$content[$con_r]
				);
				$this->Post_model->edit_post_detail($post_id, $detail);
			}
		}
	}
	public function random_set_post_photo(){
		foreach ($this->db->get("post")->result_array() as $post) {
			for ($i=0; $i < rand(0,10); $i++) { 
				$this->db->insert("media", array(
					"type"        =>	"post",
					"relation_id" =>	$post['id'],
					"name"        =>	"DEMO",
					"description" =>	"DEMODEMO".rand(12345, 999999),
					"normal_url"  =>	"uploads/demo/demo".rand(10,33).".jpg",
					"thumb_url"   =>	"uploads/demo/demo".rand(10,33).".jpg"
				));
			}
		}
	}

	public function random_set_post_at(){
		$club = $this->db->get_where("club", array("is_delete"=>0))->result_array();
		foreach ($this->db->get_where("post", array("post_at"=>"0"))->result_array() as $item) {
			$random = rand(0, count($club) - 1);
			$this->db->where(array("id"=>$item['id']))->update("post", array(
				"post_at"     =>	"club",
				"relation_id" =>	$club[$random]['id']
			));
		}
	}


	//靜脈api
	public function get_title_list(){
		$category = $this->input->post("category");
		//類別：
		//	bulletin 	   學會公告
		//	seminar 	   課程/研討會	
		//	academic 	   學術訊息
		//	medical 	   醫療訊息
		//activity_records 活動紀錄
		/*$data = array();
		
		$category="bulletin";
		
		$str='SELECT *  FROM ';
		

		$list=$this->db->query($str.$category);

		//var_dump($list);
		
		
		foreach($list->result() as $row){
			$data[] = array(
				"id"           => $row->id,
				"title"        => $row->title,
				"create_date" =>  $row->create_date				
			);
		}*/
		//var_dump($data);

		//執行SQL
		
		$data = array();
		for ($i=1; $i <=10 ; $i++) { 
			$data[] = array(
				"id"           => $i,
				"title"        => "標題".$i,
				"create_date" => date("Y-m-d ")				
			);
		}
		$this->output(TRUE, '取得資料成功', array("data"=>$data));
	}

	//文章詳細內容
	public function get_info(){
		$category=$this->post("category");

		//	bulletin 	   學會公告
		//	seminar 	   課程/研討會	
		//	academic 	   學術訊息
		//	medical 	   醫療訊息
		//activity_records 活動紀錄
		//Chairman		   理事長的話
		//rule			   學會章程
		//organization_image 組織圖

		$data = array();
		$data[] = array(
			"id"           => 1,
			"title"        => "標題",
			"content"		=>"今天好熱",
			"create_date" => date("Y-m-d"),
			"file1"=>"xxx/rrr/ddd.png",
			"file2"=>"vvv/sss/aaa.png"				
		);
		$this->output(TRUE, '取得資料成功', array("data"=>$data));

	} 
	
	public function get_newest_activity(){
		$time=$this->post("time");

		

		
		$data = array();
		for ($i=1; $i <=10 ; $i++) { 
			$data[] = array(
				"id"           => $i,
				"title"        => "標題".$i,
				"create_date" => date("Y-m-d ")				
			);
		};
		$this->output(TRUE, '取得資料成功', array("data"=>$data));

	} 

	public function get_button_list(){
		//$time=$this->post("time");

		//存放年度
		$data = array();
		$button_numleft="";
		$button_numright="";
		$str="";
		


		//今年
		$year=date("Y");
		//var_dump($year);

		for( $i=0 ; $i<2 ; $i++ ){
			if($year>2020){
				if($year%2==0){
					$button_numright=$year;
					$button_numleft=$year-1;
					
					$data[$i]=$button_numleft."-".$button_numright;

				}
				else{
					$button_numleft=$year;
					$button_numright=$year+1;
					
					$data[$i]=$button_numleft."-".$button_numright;

				}
	
				$year-=2;
			}

			
		}
		
		
		
		/*
		
		
		for ($i=1; $i <=10 ; $i++) { 
			$data[] = array(
				"id"           => $i,
				"title"        => "標題".$i,
				"create_date" => date("Y-m-d ")				
			);
		};*/
		$this->output(TRUE, '取得資料成功', array("data"=>$data));
		
	} 

	public function  get_home_carousel(){
		
		$type='all_collection';

		$str="select * from home where is_delete=0 and type='$type' ";
		$res=$this->db->query($str)->result_array();
		
		if($res)
			$all_collection=explode(',',$res[0]['img']);
		else
			$all_collection=array();
	

		$type='ready_to_wear';
		$str="select * from home where is_delete=0 and type='$type' ";
		$res=$this->db->query($str)->result_array();


		if($res)
			$ready_to_wear=explode(',',$res[0]['img']);
		else
			$ready_to_wear=array();
		
		$type='customize';
		$str="select * from home where is_delete=0 and type='$type' ";
		$res=$this->db->query($str)->result_array();

		if($res)
			$customize=explode(',',$res[0]['img']);
		else
			$customize=array();

		$type='shop';
		$str="select * from home where is_delete=0 and type='$type' ";
		$res=$this->db->query($str)->result_array();

		if($res)
			$shop=explode(',',$res[0]['img']);
		else
			$shop=array();



		$this->output(TRUE,'取得成功',array(
			'all collection'	=>	$all_collection,
			'ready to wear'		=> 	$ready_to_wear,
			'cusomize'			=>  $customize,
			'shop'				=>  $shop 
		
		))	;

	}

	
	public function get_home_text(){

		$type='all_collection';

		$str="select * from home_text where is_delete=0 and type='$type' ";
		$res=$this->db->query($str)->result_array();
		
		if($res)
			$all_collection['title']=$res[0]['title'];
		else
			$all_collection=array();
	

		$type='ready_to_wear';
		$str="select * from home_text where is_delete=0 and type='$type' ";
		$res=$this->db->query($str)->result_array();


		if($res)
			$ready_to_wear['title']=$res[0]['title'];
		else
			$ready_to_wear=array();
		
		$type='customize';
		$str="select * from home_text where is_delete=0 and type='$type' ";
		$res=$this->db->query($str)->result_array();


		// !d($res);
		// exit;
		if($res)
			$customize['title']=$res[0]['title'];
		else
			$customize=array();

		$type='shop';
		$str="select * from home_text where is_delete=0 and type='$type' ";
		$res=$this->db->query($str)->result_array();
		
		if($res){
			$shop['title']=$res[0]['title'];
			$shop['content']=$res[0]['content'];
		}
			
		else
			$shop=array();



		$str="select * from our_service where id=1 ";
		$res=$this->db->query($str)->row_array();

		$our_service=array(
			'img1'		=> $res['img1'],
			'img2'		=> $res['img2'],
			'img3'		=> $res['img3'],
			
			'title1'	=> $res['title1'],
			'title2'	=> $res['title2'],
			'title3'	=> $res['title3'],

			'content1'	=> $res['content1'],
			'content2'	=> $res['content2'],
			'content3'	=> $res['content3']


		);


		$this->output(TRUE,'取得成功',array(
			'all collection'	=>	$all_collection,
			'ready to wear'		=> 	$ready_to_wear,
			'cusomize'			=>  $customize,
			'shop'				=>  $shop, 
			'our_service'		=>  $our_service
		))	;



	}

	public function get_brand_data(){


		$str="select* from brand where id=1";

		$res=$this->db->query($str)->row_array();

		$vedio_link=$res['vedio_link'];
		$quote=$res['quote'];


		$content1=array(
			'content1_img1'	=>	$res['content1_img1'],
			'content1_img2'	=>	$res['content1_img2'],
			'content1_title'=>	$res['content1_title'] 
		);

		$content2=array(
			'content2_img'	=>	$res['content2_img'],
			'content2_title'=>	$res['content2_title']	
		);

		$content3=array(
			'content3_img1'	=>	$res['content3_img1'],
			'content3_img2'	=>	$res['content3_img2'],
			'content3_title'=>	$res['content3_title']	

		);

		$this->output(TRUE,'取得成功',array(
			'vedio_link'	=> $vedio_link,
			'quote'			=> $quote,
			'content1'		=> $content1,
			'content2'		=> $content2,
			'content3'		=> $content3
		));

	}


	public function get_designer_data(){
		$str="select * from designer  where  id =1";
		$res=$this->db->query($str)->row_array();


		$banner=array(

			'background'	=>	$res['background'],
			'img1'			=>	$res['img1'],
			'img2'			=>	$res['img2']
		);


		$quote1=array(
			'quote1_img'			=>	$res['quote1_img'],
			'quote1_title'			=>	$res['quote1_title']	

		);	

		
		$content1=array(
			'content1'		=>	$res['content1'],
			'content1_img'	=>	$res['content1_img']

		);

		$quote2=array(
			
			'quote2_title'			=>	$res['quote2_title']
		);

		$content2=array(
			'content2'				=>	$res['content2'],
			'content2_img'			=>	$res['content2_img']
		);

		$quote3=array(
			'quote3_title'				=>	$res['quote3_title'],
		);
		$content3=array(
			'content3'				=>	$res['content3'],
			'content3_img'			=>	$res['content3_img'],
			'content3_title'		=>	$res['content3_title']

		);

		$this->output(TRUE,"取得成功",array(
			'banner'	=>	$banner,
			'quote1'	=>	$quote1,
			'content1'	=>	$content1,
			'quote2'	=>	$quote2,
			'content2'	=>	$content2,
			'quote3'	=>	$quote3,	
			'content3'	=>	$content3
		));
	}
	public function get_timeline_data(){

		$str="select *from timeline where id=1";
		$res=$this->db->query($str)->row_array();

		$vedio_link=$res['vedio_link'];


		$quote=$res['quote'];

		$left_img=array(
			'img1'		=>	$res['left_img1'],
			'img2'		=>	$res['left_img2']
		);

		$center_content=$res['center_content'];


		$right_img=array(
			'img1'		=>	$res['right_img1'],
			'img2'		=>	$res['right_img2']
		);

		$big_img=$res['big_img'];

		$introduction=$res['introduction'];



		$str="select*  from more_photos where is_delete=0	";
		$res=$this->db->query($str)->result_array();

		foreach($res as $r){

			$more_photos[]=array(
				'img'	=>	$r['img']

			);
		}

		$this->output(TRUE,"取得成功",array(
			'vedio'				=>	$vedio_link, 
			'quote'				=>	$quote,
			'left_img'			=>	$left_img,
			'center_content'	=>	$center_content,
			'right_img'			=>	$right_img,
			'big_img'			=>	$big_img,
			'introduction'		=>	$introduction,
			'more_photos'		=>	$more_photos
		));

	}

	public function get_customize_data(){

		$str="select * from customized where id=1";
		$res=$this->db->query($str)->row_array();

		$banner=array(
			'banner'	=>	$res['background'],
			'img1'		=>	$res['img1'],
			'img2'		=>	$res['img2']

		);

		$content=$res['content'];
		$online_steps=array(
			
			'online_title'	=>	$res['online_title'],
			'online_step1'	=>	$res['online_step1'],
			'online_step2'	=>	$res['online_step2'],
			'online_step3'	=>	$res['online_step3'],
			'online_step4'	=>	$res['online_step4']
		);	


		$step1=array(
			'step1_img'			=>	$res['step1_img'],
			'step1_text_img'	=>	$res['step1_text_img'],
			'step1_title'		=>	$res['step1_title'],
			'step1_content'		=>	$res['step1_content']
		);

		$step2=array(
			'step2_img'			=>	$res['step2_img'],
			'step2_text_img'	=>	$res['step2_text_img'],	
			'step2_title'		=>	$res['step2_title'],
			'step2_content'		=>	$res['step2_content'],
			
		);


		$step3=array(
			'step3_img'			=>	$res['step3_img'],
			'step3_text_img'	=>	$res['step3_text_img'],
			'step3_title'		=>	$res['step3_title'],
			'step3_content'		=>	$res['step3_content']	

		);

		$this->output(TRUE,'取得成功',array(
			'banner'			=>	$banner,
			'content'			=>	$content,
			'online_steps'		=>	$online_steps,
			'step1'				=>	$step1,
			'step2'				=>	$step2,
			'step3'				=>	$step3
		));	
	}



	public function get_collection_cover(){

		$type=($this->input->post('type'))?($this->input->post('type')):'BRIDAL-GOWNS';



		$str="select* from collection where is_delete=0 and type='$type' ";
		$res=$this->db->query($str)->result_array();

		foreach($res as $r){

			$cover[]=array(
				'img'	=>	$r['cover']
			);
		}

		$this->output(TRUE,'取得成功',array(
			'cover'	=>	$cover

		));
	}

	public function get_collection_info(){

		$id=$this->input->post('id');

		$str="select *from collection  where  is_delete=0 and id='$id' ";

		$res=$this->db->query($str)->row_array();
		//!d($res);
		
		$img[]=array($res['img1'],$res['img2'],$res['img3'],$res['img4']);
		// !d($img);

		$data=array(
			'name'		=>	$res['name'],
			'year'		=>	$res['year'],
			'item_no'	=>	$res['item_no'],
			'content'	=>	$res['content'],
			'shop_link'	=>	$res['shop_link']
		);

		$this->output(TRUE,'成功取得',array(

			'img'		=>	$img,	
			'data'		=>	$data
		));
	}


	public function get_ready_to_wear_data(){
		$str="select * from ready_text where id=1";
		$res=$this->db->query($str)->row_array();

		$data=array(
			'quote'		=>	$res['quote'],
			'content'	=>	$res['content'],
			'shop_link'	=>	$res['shop_link'],
			'title'		=>	$res['title']
		);


		$str="select *from ready_carousel_top where is_delete=0	and type='top'";
		$res=$this->db->query($str)->result_array();

		if($res){
			foreach($res as $r){
				$top_carousel[]=array(
					'img'	=>	$r['img']
				);
			}
			
		}
		else{
			$top_carousel[]=array();
		}
			

		$str="select *from ready_carousel_top where is_delete=0	and type='bottom'";
		$res=$this->db->query($str)->result_array();
		
		if($res){
			foreach($res as $r){
				$bottom_carousel[]=array(
					'img'	=>	$r['img']
				);
			}
			
		}
		else{
			$bottom_carousel[]=array();
		}

		$this->output(TRUE,'成功取得',array(
			'data'				=>	$data,
			'top_carousel'		=>	$top_carousel,
			'bottom_carousel'	=>	$bottom_carousel
		));
	}


	public function get_bride_cover_info(){
		$str="select * from  bride where is_delete=0 ";

		$res=$this->db->query($str)->result_array();

		foreach($res as $r){
			$data[]=array(
				'id'		=>	$r['id'],
				'title'		=>	$r['title'],
				'sub_title'	=>	$r['sub_title'],
				'cover_img'	=>	$r['cover_img']	

			);

		}

		$this->output(TRUE,'取得成功',array(
			'data'		=>	$data

		));

	}

	public function get_bride_all_pics(){
		$id=$this->input->post('id');

		$str="select * from bride where is_delete=0 and id='$id' ";
		$res=$this->db->query($str)->row_array();


		
		//!d($res['imgs']);
		$pics=json_decode($res['imgs'],true);
		//!d($pics);
		
		foreach($pics as $r){
			//!d($r);
			$img[]=array(
				'img'	=>	$r['img']
			);

		}
		
		$this->output(TRUE,'成功取得',array(
			'img'	=>	$img

		));


	}

	public function get_media_exposure_data(){

		$str="select * from media_exposure where is_delete=0 ";
		$res=$this->db->query($str)->result_array();


		foreach($res as $r){
			$data[]=array(
				'id'		=>	$r['id'],
				'title'		=>	$r['title'],
				'hash_tag'	=>	$r['hash_tag'],
				'type'		=>	$r['type'],
				'img'		=>	$r['img'],
				'link'		=>	$r['link']

			);

		}


		$this->output(TRUE,'取得成功',array(
			'data'	=>	$data
		));
	}

//is_delete=0 and is_civic=1()
// create table hospital_old  like  hospital
// order by update_date desc
// //drop table hospital_old

// insert into  hospital_old select *from hospital
	public function get_path(){


		//$str="http://localhost/new_wedding/About/brand";

		$path=$this->input->post('url');

		$res=explode(base_url(),$path);
		
  		$this->output(TRUE,"取得成功",array('path'=> $res[1])) ;

	}


	

	//上傳Contact us頁面
	public function upload_form(){
		
		$name=$this->input->post('name');
		$email=$this->input->post('email');
		$phone=$this->input->post('phone');
		$subject=$this->input->post('subject');

		$wedding_date=$this->input->post('wedding_date');
		$appointment_date=$this->input->post('appointment_date');

		$message=$this->input->post('message');
		
		// $name='wayne';
		// $email='aaa@gmail.com';
		// $phone='12345678';
		// $subject='拍婚紗';
		// $wedding_date='2021-12-08';
		// $appointment_date='2021-11-30';
		// $message='把我老婆拍美一點';
		
		$data=array(
			'name'				=> $name,
			'email'				=> $email,
			'phone'				=> $phone,
			'subject'			=> $subject,
			'wedding_date'		=> $wedding_date,
			'appointment_date'	=> $appointment_date,
			'message'			=> $message
		);

		$this->db->insert('contact',$data);
		$this->output(TRUE, '上傳成功');
	}
	//測試用
	public function article(){
		$this->output(TRUE, "登入成功", array(
					
					"data"   =>	[
						'id'=>1,
						'article'=>'kkk',
						'annouce_date'=>'2010-10-30'
					]
				));	

	}
	//
}
