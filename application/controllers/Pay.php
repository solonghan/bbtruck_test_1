<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pay extends Base_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Order_model");
		$this->load->model("Newebpay_model");
	}

	public function index(){
		header("Location: ".base_url());
	}

	public function bill($order_no){
		$bill = $this->Order_model->get_data_by_order_no($order_no);
		if ($bill == null){
			$this->js_output_and_redirect("查無此訂單", base_url());
			return;	
		} 

		if ($bill['is_payment_load'] == 1){
			$new_order_no = $order_no."_1";
			if (strpos($order_no, "_") !== FALSE) {
				$o = explode("_", $order_no);
				$new_order_no = $o[0]."_".(intval($o[1])+1);
			}

			if ($this->Order_model->update_order_no($order_no, $new_order_no)) {
				$order_no = $new_order_no;
			}else{
				$this->js_output_and_redirect("訂單發生問題，請聯繫我們", base_url());
				return;
			}
		} 

		$user = $this->User_model->get_data($bill['user_id']);
		$paytype = array('credit', 'atm');

		$products_str = "溫度部落";
		if ($bill['type'] == 'adv') {
			$products_str .= " 廣告刊登費";
		}
        echo $this->Newebpay_model->pay(
            $paytype,										//可使用金流方式
            $user['email'],									//付款人email
            $bill['payment_amount'],						//付款金額
            $order_no,                      				//訂單編號
            $products_str,                  				//訂單敘述
            base_url()."pay/success/".$order_no,		  	//付款完後，前端返回的頁面，也可透過POST接到到資訊
            base_url()."pay/pay_receive" 		  			//付款完後，藍新會透過background POST方式回傳資訊回來
        );
	}

	public function success($order_no){
		//前端導向頁面
		$bill = $this->Order_model->get_data_by_order_no($order_no);
		if ($bill == null) $this->js_output_and_redirect("查無此訂單", base_url());


		$bill_confirm_status = FALSE;
		if ($this->input->post("JSONData") && $this->input->post("JSONData") != "") {
			$jsondata = json_decode($this->input->post("JSONData"), TRUE);	
			if ($jsondata['Status'] == 'SUCCESS') {
				$bill_confirm_status = TRUE;
				$result = json_decode($jsondata['Result'], TRUE);	

				$order_no = $result['MerchantOrderNo'];
				if ($order_no != $result['MerchantOrderNo']) $this->js_output_and_redirect("查無此訂單", base_url());

				$data = array();
				$payment_type = $result['PaymentType'];
				if ($payment_type == "VACC") {
					$expire_date = $result['ExpireDate'];
					$bank_code = $result['BankCode'];
					$code_no = $result['CodeNo'];
					$data = array(
						"payment_type" =>	$payment_type,
						"expire_date"  =>	$expire_date,
						"bank_code"    =>	$bank_code,
						"code_no"      =>	$code_no
					);	

					$this->Order_model->edit($bill['id'], $data);
				}

			}else{
				$this->data['error_msg'] = $jsondata['Message']." [".$jsondata['Status']."]";
				$this->load->view('pay_fail', $this->data);
				return;
			}
		}

		if ($bill['status'] == 'PAID' || $bill_confirm_status) {
			// $this->load->view('success_'.$project['code'], $this->data);		
			$this->load->view('success_project', $this->data);		
		}else{
			if ($bill['status'] == 'FAIL') {
				$this->data['error_msg'] = $bill['newebpay_msg'];
			}else if ($bill['status'] == 'PENDING') {
				$this->data['error_msg'] = "訂單未成立";
			}else if ($bill['status'] == 'CANCELED') {
				$this->data['error_msg'] = "訂單已取消";
			}
			$this->data['error_msg'] = "";

			$this->load->view('pay_fail', $this->data);
		}
		
	}

	public function share($order_no){
		//前端導向頁面
		$bill = $this->Order_model->get_data_by_order_no($order_no);
		if ($bill == null) $this->js_output_and_redirect("查無此訂單", base_url());

		$project = $this->Project_model->get_data($bill['project_id']);

		$data = array();
		
		$this->data['project'] = $project;
		$this->data['bill'] = $this->Order_model->get_data_by_order_no($order_no);
		$this->data['clients'] = $this->Order_model->get_clients($bill['id']);

		$this->data['content'] = '';

		if ($project['code'] == "2021lanterns") {
			$content = '光明燈點燈<div class="d-flex justify-content-center flex-wrap">';
			foreach ($this->Order_model->get_order_laterns($bill['id']) as $l){
				$content .= '<img src="assets/images/2021thankgod/latern_'.$l['latern'].'_pad.png" class="m-2 latern">';
			}
			$content .= '</div>';
			$this->data['content'] = $content;

			$this->data['web_title'] = "2021光明燈 | ".$this->data['web_title'];
		}else if ($project['code'] == "2021thankgod") {
			$this->data['content'] = "謝神祈福平安法會 110/01/25 - 01/29";

			$this->data['web_title'] = "2021謝神祈福平安法會 110/01/25 - 01/29 | ".$this->data['web_title'];
		}else if ($project['code'] == "2021newyear") {
			$this->data['content'] = "新春祈福平安法會 110/02/12 - 02/16";

			$this->data['web_title'] = "2021新春祈福平安法會 110/02/12 - 02/16 | ".$this->data['web_title'];
		}else if ($project['code'] == "2021aprilwisdom") {
			$this->data['content'] = "文昌祈福 110/05/20";

			$this->data['web_title'] = "文昌祈福 110/05/20 | ".$this->data['web_title'];
		}else if ($project['code'] == "anti-epidemic") {
			$this->data['content'] = "防疫祈福專案 110/05/17 ~ 05/21";

			$this->data['web_title'] = "防疫祈福專案 110/05/17 ~ 05/21 | ".$this->data['web_title'];
		}else{
			$this->data['content'] = $project['title']." 110/04/19 - 04/23";

			$this->data['web_title'] = $this->data['content']." | ".$this->data['web_title'];
		}
		$this->data['remarks'] = "";//"【線上點燈】<br>在2/26前完成點燈，收據會建立於會員中心方便信眾查看。";



		$this->load->view('share', $this->data);
	}

	public function pay_receive(){
		$f = fopen("log.txt", "a+");
		fwrite($f, "pay_receive:\n".date("Y-m-d H:i:s")."\n".json_encode($_POST)."\n\n");
		fclose($f);

		$jsondata = array();
		$result = "";
		if ($this->input->post("Status") && $this->input->post("Status") == "SUCCESS") {
			$TradeInfo = $this->input->post("TradeInfo");
			$info = $this->Newebpay_model->create_aes_decrypt($TradeInfo);

			$f = fopen("log.txt", "a+");
			fwrite($f, "pay_receive (by decrypt aes trade info):\n".date("Y-m-d H:i:s")."\n".$info."\n\n");
			fclose($f);

			$jsondata = json_decode($info, TRUE);	
			$result = $jsondata['Result'];
		}else{
			$jsondata = json_decode($this->input->post("JSONData"), TRUE);		
		}

		if ($jsondata['Status'] == 'SUCCESS') {
			if ($result == "") $result = json_decode($jsondata['Result'], TRUE);
			$order_no = $result['MerchantOrderNo'];
			$pay_time = $result['PayTime'];

			$f = fopen("log.txt", "a+");
			fwrite($f, "Update Bill: \n".date("Y-m-d H:i:s")."\n".$order_no."\n".$pay_time."\n\n");
			fclose($f);

			$bill = $this->Order_model->get_data_by_order_no($order_no);
			$this->Order_model->edit($bill['id'], array(
				"status"         =>	'PAID',
				"pay_date"       =>	$pay_time,
				"payment_result" =>	json_encode($jsondata)
			));
		}else{
			$result = json_decode($jsondata['Result'], TRUE);	
			$order_no = $result['MerchantOrderNo'];

			$bill = $this->Order_model->get_data_by_order_no($order_no);
			$this->Order_model->edit($bill['id'], array(
				"status"         =>	'FAIL',
				"pay_msg"        =>	$jsondata['Status']." ".$jsondata['Message'],
				"payment_result" =>	json_encode($jsondata)
			));
		}
		
	}
}
