<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends Base_Model {

	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

	// public function generate_short_url($url){
	// 	$s = $this->db->get_where($this->short_url_table, array("url"=>$url))->row_array();
	// 	if ($s != null) return "https://wish333.tw/".$s['code'];

	// 	$exist = 1;
	// 	$code = "";
	// 	do{
	// 		$code = $this->generate_code();
	// 		$exist = $this->db->get_where($this->short_url_table, array("code"=>$code))->num_rows();
	// 	}while ($exist > 0);

	// 	$this->db->insert($this->short_url_table, array(
	// 		"code"	=>	$code,
	// 		"url"	=>	$url
	// 	));
	// 	return "https://wish333.tw/".$code;
	// }

	public function update_order_no($order_no, $new_order_no){
		return $this->db->where(array("order_no"=>$order_no))->update($this->order_table, array(
			"order_no"	=>	$new_order_no
		));
	}

	//Cron Used to check newebpay status
	public function go_newebpay_check($syntax, $order_by){
		$this->load->model("Newebpay_model");
		
		$error_msg = "";

		$data = $this->Bill_model->get_list($syntax, $order_by, 'all');
		foreach ($data['list'] as $item) {
			$check = $this->Newebpay_model->check_bill($item['order_no'], $item['payment_amount']);
			// echo $check."<br>";
			$f = fopen("log.txt", "a+");
			fwrite($f, "newebpay check: ".$item['order_no']."\n".date("Y-m-d H:i:s")."\n".$check."\n\n");
			fclose($f);
			$result = json_decode($check ,TRUE);	
			// echo $item['order_no'].": ".$result['Status'];
			if ($result['Status'] == 'SUCCESS') {
				// echo ", ".$result['Result']['TradeStatus'];
				$this->Bill_model->newebpay_check($item['order_no'], $result['Result']['TradeStatus'], $result['Result']['PayTime']);
				if ($result['Result']['TradeStatus'] == 1 && $item['status'] != "PAID") $error_msg .= "[".$item['order_no']."]\n";
				if ($result['Result']['TradeStatus'] != '1' && $item['status'] == "PAID") $error_msg .= "[".$item['order_no']."]\n";
			}else{
				$this->Bill_model->newebpay_check($item['order_no'], $result['Status'], '');
				if ($item['status'] == "PAID") $error_msg .= "[".$item['order_no']."]\n";
			}
			// echo "<br>";
		}
		
		if ($error_msg != "") $this->Line_Notify_model->schedule_cron_and_send("異常訂單:\n".$error_msg);	
	}

	public function newebpay_check($order_no, $newebpay_status, $paid_at){
		$update_data = array(
			"newebpay_checked" =>	1,
			"newebpay_status"  =>	$newebpay_status,
			// "paid_at"          =>	$paid_at
		);
		if ($newebpay_status == 1) {
			$update_data['paid_at'] = $paid_at;
		}else{
			$update_data['paid_at'] = '0000-00-00 00:00:00';
		}
		$this->db->where(array("order_no"=>$order_no))->update($this->order_table, $update_data);
	}

	//Cron Used
	public function get_today_bill_and_clients(){
		//排程設定為 00:05
		$today = date("Y-m-d");
		$yesterday = date("Y-m-d", strtotime('- 1 day', strtotime(date($today))));

		//昨天已付款訂單
		$syntax = "O.`status` = 'PAID' AND O.`created_at` LIKE '{$yesterday}%'";
		$yesterday_bill_cnt = $this->db->get_where($this->order_table." O", $syntax)->num_rows();
		$success_mobile = array();
		foreach ($this->db->get_where($this->order_table." O", $syntax)->result_array() as $b) {
			if (!in_array($b['buyer_mobile'], $success_mobile)) {
				$success_mobile[] = $b['buyer_mobile'];
			}
		}

		//昨天未付款訂單
		$n_syntax = "O.`status` = 'PENDING' AND O.`created_at` LIKE '{$yesterday}%'";
		$yesterday_notpay_bill_cnt = $this->db->get_where($this->order_table." O", $n_syntax)->num_rows();

		$this->load->model("User_model");
		$pending_mobile = array();
		foreach ($this->db->get_where($this->order_table." O", $n_syntax)->result_array() as $b) {
			if (!in_array($b['buyer_mobile'], $success_mobile) && !in_array($b['buyer_mobile'], $pending_mobile)) {
				$pending_mobile[] = $b['buyer_mobile'];
			}
		}
		foreach ($pending_mobile as $phone) {
			
		}

		//今日名單
		$list = $this->db->select("C.*")
						 ->from($this->order_table." O")
						 ->join($this->wish_table." C", "O.id = C.order_id", "left")
						 ->where("O.`status` = 'PAID' AND '{$today}' BETWEEN O.`startDate` AND O.`endDate`")
						 ->get()->result_array();

		return array(
			"yesterday"                 =>	$yesterday,
			"today"                     =>	$today,
			"yesterday_bill_cnt"        =>	$yesterday_bill_cnt,
			"yesterday_notpay_bill_cnt" =>	$yesterday_notpay_bill_cnt,
			"today_client"              =>	$list,
			"today_client_cnt"          =>	count($list)
		);
	}

	//create invoice
	public function make_invoice($go_on = FALSE){
		$today = date('Y-m-d H:i:s');
		$start_search_date = date('Y-m-d H:i:s', strtotime('- 7 days', strtotime($today)));
		$invoice_date = date('Y-m-d', strtotime('- 1 days', strtotime($today)))." 23:00:00";
		// $invoice_date = "2021-02-28 23:00:00";

		$syntax = "`status` = 'PAID' AND (`invoice_number`='' OR `invoice_number` IS NULL)";
		$syntax .= " AND `created_at` >= '{$start_search_date}'";
		// $syntax .= " AND `created_at` >= '2020-12-22 00:00:00'";
		$syntax .= " and `created_at` <= '{$today}'";
		
		$list = $this->db->get_where($this->order_table, $syntax)->result_array();

		$plan = $this->db->get("items")->result_array('id');

		if ($go_on === FALSE) {
			echo '<table style="width:100%; border: 1px solid #CCC;">';
			echo '<tr>';
			echo '<td>訂單編號<td>';
			echo '<td>訂單編號<td>';
			echo '<td>付款狀態<td>';
			echo '<td>付款金額(DB)<td>';
			echo '<td>付款金額(Cal)<td>';
			echo '<td>購買品項<td>';
			echo '<td>訂購人資訊<td>';
			echo '</tr>';
			foreach ($list as $item) {
				echo '<tr>';
				echo '<td>'.$item['order_no'].'<td>';
				echo '<td>'.$item['created_at'].'<td>';
				echo '<td>'.$item['status'].'<td>';
				echo '<td>'.$item['payment_amount'].'<td>';
				if ($item['item'] == 5) { //2021光明燈
					$quantity = 1;
					echo '<td>'.$item['payment_amount'].'<td>';
				}else{
					$quantity = $item['payment_amount'] / $plan[$item['item']]['price'];
					echo '<td>'.($quantity * $plan[$item['item']]['price']).'<td>';
				}
				
				echo '<td>';
				echo $plan[$item['item']]['name']." x ".$quantity;
				echo '<td>';
				echo '<td>';
				echo $item['buyer_name']."<br>".$item['buyer_mobile']."<br>".$item['buyer_email']."<br>";
				if ($item['invoice_uid'] != "") {
					echo "[".$item['invoice_uid']."] ".$item['invoice_uname'];
				}
				echo '<td>';
				echo '</tr>';
			}
			echo '</table>';

		}else{
			$this->load->model("Ezreceipt_model");
			$latern_price = [2800, 1800, 1700, 900, 1200];
			$latern_title = ["台南", "嘉義/雲林", "台北/新北", "苗栗/高雄", "台中/南投"];
			foreach ($list as $item) {
				$quantity = 1;
				$products = array();
				if ($item['item'] == 5) { //2021光明燈
					$quantity = 1;
					$products = array(
						    		array(
			    						"prodNo"   => 5,
			    						"qty"	   => 1,
			    						"title"	   => $plan[$item['item']]['name'],
			    						"price"	   => $item['payment_amount']
			    					)
						     	);
				}else{
					$quantity = $item['payment_amount'] / $plan[$item['item']]['price'];


					$products = array(
						    		array(
			    						"prodNo"   => $item['item'],
			    						"qty"	   => $quantity,
			    						"title"	   => $plan[$item['item']]['name'],
			    						"price"	   => $plan[$item['item']]['price']
			    					)
						     	);
				}
				

				$bill_no = $item['order_no'];
				$bill_time = $invoice_date;
				$money = $item['payment_amount'];
				$username = $item['buyer_name'];
				$phone = $item['buyer_mobile'];
				$email = $item['buyer_email'];
				$addr = "";
				$remarks = "";
				$sn = "";
				if ($item['invoice_uid'] != "") {
					$sn = $item['invoice_uid'];
				}
				$company = $item['invoice_uname'];
				$user = array(
					"accName" =>	$phone,
					"email"   =>	$email,
					"name"    =>	$username,
					"phone"   =>	$phone,
					"addr"    =>	$addr
				);
				if ($sn != "") {
					$user = array(
						"nid"   =>	$sn,
						"email" =>	$email,
						"name"  =>	($company!="")?$company:$username,
						"addr"  =>	$addr
					);
				}

				$res = $this->Ezreceipt_model->create(
					$bill_no,
					$bill_time, 
					$user,
					$products,
					$money,
					$username,
					$phone,
					$email,
					$addr,
					$remarks,
					$sn,
					$company
				);
				if ($res) {
					$invoice = $this->db->get_where($this->invoice_table, array("bill_no"=>$bill_no))->row_array();
					if ($invoice != null) {
						$this->db->where(array("order_no"=>$bill_no))->update($this->order_table, array("invoice_number"=>$invoice['invoice'], "invoice_date"=>$bill_time));
					}
				}
			}
		}
	}

	public function check_exist($type, $relation_id){
		$order = $this->db->get_where($this->order_table, array("type"=>$type, "relation_id"=>$relation_id))->row_array();
		if($order != null){
			return $order['id'];
		}else{
			return FALSE;
		}
	}

	public function edit($id, $data, $is_multi = FALSE){
		if ($is_multi) {
			return $this->db->update_batch($this->order_table, $data, $id);
		}else{
			return $this->db->where(array("id"=>$id))->update($this->order_table, $data);
		}
	}

	public function add($data, $is_multi = FALSE){
		if ($is_multi) {
			return $this->db->insert_batch($this->order_table, $data);
		}else{
			if ($this->db->insert($this->order_table, $data)) {
				return $this->db->insert_id();
			}else{
				return FALSE;
			}
		}
	}

	public function get_data_by_order_no($order_no){
		$syntax = "is_delete = 0 AND order_no LIKE '".$order_no."%'";
		return $this->db->get_where($this->order_table, $syntax)->row_array();
	}

	public function get_data($id){
		return $this->db->get_where($this->order_table, array("is_delete"=>0,'id'=>$id))->row_array();
	}

	public function get_all_list($syntax = array()){
		$syntax['is_delete'] = 0;
		return $this->db->get_where($this->order_table, $syntax)->result_array();
	}

	public function get_list($syntax, $order_by, $page = 1, $page_count = 20){
		// $syntax .= " AND show_type = 'T'";
		$total = $this->db->where($syntax)->get($this->order_table." O")->num_rows();
		$total_page = ($total % $page_count == 0) ? floor(($total)/$page_count) : floor(($total)/$page_count) + 1;

		$sum = $this->db->select("SUM(payment_amount) as sum")->from($this->order_table." O")->where($syntax)->get()->row()->sum;

		$this->db->select("O.*")
				 ->from($this->order_table." O")
				 ->where($syntax)
				 ->order_by($order_by);
		if ($page != 'all') {
			$this->db->limit($page_count, ($page-1)*$page_count);
		}
		$list = $this->db->get()->result_array();
						 
		return array(
			"sum"        =>	$sum,
			"total"      =>	$total,
			"total_page" =>	$total_page,
			"list"       =>	$list
		);
	}
}