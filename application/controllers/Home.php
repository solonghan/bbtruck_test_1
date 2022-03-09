<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Base_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Flow_record_model');
		$this->load->model('Customized_model');
		$this->load->model('Collection_model');
		$this->load->model('Category_model');
		$this->load->model('Home_model');
		$this->load->model('Home_text_model');
		//
		$this->load->model("Login_model");
		//
		$this->Flow_record_model->set_flow_record("home", $this->get_client_ip());
	}

	public function index()
	{
		$category=$this->Category_model->get_all_category();

		$this->data = array_merge($this->data, array(
				'category' => $this->Collection_model->get_collection_category(),
				'collection_category'=>	$category[1],
				'collection' 	=> $this->Collection_model->get_carousel(),
				'customized' 	=> $this->Customized_model->get_carousel(),
				'ready_to_wear'	=> $this->Home_model->get_ready_carousel(),
				'shop'			=> $this->Home_model->get_shop_carousel(),	
				'our_service'	=> $this->Home_model->get_service_img(),
				'content'		=> $this->Home_text_model->get_content(),
				'title'			=> $this->Home_text_model->get_title(),	
		));
		//!d($this->data);
		$this->load->view('index',$this->data);
	}

//使用者註冊
public function register()
{
	$this->load->model('Member_model');
	$this->load->model('Login_model');
	$this->flow_record("register");

	if ($_POST) {

		$username         = $this->input->post("username");
		$email            = $this->input->post("email");
		$password         = $this->input->post("password");
		$password2 = $this->input->post("password2");

		//判斷pwd格式
		// if (strlen($password) < 6 || strlen($password) > 12) {
		// 	$this->js_output_and_back("密碼不可小於六位數 或 大於十二位數");
		// }

		// $res = $this->checkStr($password);
		// if(!$res){
		// 	$this->js_output_and_back("密碼須包含英文及數字");
		// }


		if ($password == "" || $email == "" || $username == "")
			$this->js_output_and_back("必填欄位不可為空");

		if ($password2 != $password)
			$this->js_output_and_back("兩次輸入密碼不相同");




		if (!$this->Member_model->exsit_check($email)) {


			//user data save to db
			$res = $this->Login_model->register(array(
				"username"    =>	$username,
				"email"       =>	$email,
				"password"    =>	$this->encryption->encrypt(md5($password)),
				"status"      =>	"normal"
			));

			if ($res) {

				$r = $this->Member_model->get_data_by_email($email);
				$member_id = $r->id;



				$this->Login_model->login(array(
					"uid"      => $this->encryption->encrypt($member_id),
					'id'       => $r->id,
					"username" => $r->username,
					"email"    => $r->email
				));

				$old_url = $this->session->userdata('old_url');
				$redirect_url = (isset($old_url) && $old_url && strpos($old_url, 'register') === false) ? $old_url : base_url('member/home/tw');

				$this->js_output_and_redirect("註冊成功", $redirect_url);
			} else {
				$this->js_output_and_back("註冊發生問題，請聯繫管理員");
			}
		} else {
			$this->js_output_and_back("此帳號已被註冊");
		}
	} else {

		$this->flow_record("register", $this->data);
		$this->load->view("signup", $this->data);
	}
}


	//使用者登入
	public function login()
	{

		// print_r($this->session);exit;		
		// 2021-10-28 add
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			$old_url = $_SERVER['HTTP_REFERER'] ?: '';
			$this->session->set_userdata('old_url', $old_url);
		}

		if (isset($_SERVER['HTTP_REFERER']) && preg_match('/face/i', $_SERVER['HTTP_REFERER'])) {
			// print_r('111');exit;

			$this->session->set_userdata('contact', 'face');
		} elseif (isset($_SERVER['HTTP_REFERER']) && preg_match('/online/i', $_SERVER['HTTP_REFERER'])) {
			// print_r('222');exit;
			$this->session->set_userdata('contact', 'online');
		} elseif (isset($_SERVER['HTTP_REFERER']) && preg_match('/experience/i', $_SERVER['HTTP_REFERER'])) {
			// print_r('222');exit;
			$this->session->set_userdata('contact', 'experience');
		}

		$this->load->model('Member_model');
		$this->load->model('Login_model');
		$this->load->model('Cart_model');

		$this->flow_record("login");

		if ($_POST) {
			$email    = $this->input->post("email");
			$password = $this->input->post("password");


			if ($email == "" || $password == "") {

				$this->js_output_and_back("欄位不可為空");
			} else {
				if ($this->Member_model->pwd_confirm(md5($password), $email)) {
					$r = $this->Member_model->get_data_by_email($email);
					$member_id = $r->id;

					if ($r->is_delete != "0") {
						$this->js_output_and_back("您的帳號發生問題，請聯繫管理員");
					}

					$this->Login_model->login(array(
						"uid"      =>	$this->encryption->encrypt($member_id),
						"id" => 	$r->id,
						"uemail"    =>	$r->email
					));

					if ($this->session->userdata('contact') == 'face') {
						$this->js_output_and_redirect("登入成功",   base_url() . "contact/face/tw");
					} elseif ($this->session->userdata('contact') == 'online') {
						$this->js_output_and_redirect("登入成功",   base_url() . "contact/online/tw");
					} elseif ($this->session->userdata('contact') == 'experience') {
						$this->js_output_and_redirect("登入成功",   base_url() . "experience");
					} elseif ($this->session->userdata('check_product') != "") {
						$this->js_output_and_redirect("登入成功",  $this->session->userdata('check_product'));
					} elseif ($this->session->userdata('check_video') != "") {
						$this->js_output_and_redirect("登入成功",  $this->session->userdata('check_video'));
					} elseif ($this->session->userdata('check_audio') != "") {
						$this->js_output_and_redirect("登入成功",  $this->session->userdata('check_audio'));
					} elseif ($this->session->userdata('check_activity') != "") {
						$this->js_output_and_redirect("登入成功",  $this->session->userdata('check_activity'));
					} elseif ($this->session->userdata('check_topic') != "") {
						$this->js_output_and_redirect("登入成功",  $this->session->userdata('check_topic'));
					}

					$old_url = $this->session->userdata('old_url');
					$redirect_url = (isset($old_url) && $old_url && strpos($old_url, 'register') === false) ? $old_url : base_url('member/home/tw');
					$this->js_output_and_redirect("登入成功",   $redirect_url);
				} else {

					$this->js_output_and_redirect("帳號/密碼錯誤", base_url() . "home/login/tw");
				}
			}
		} else {
			if (isset($_SERVER['HTTP_REFERER'])) {
				$this->session->set_userdata(array("before_login" => $_SERVER['HTTP_REFERER']));
			}


			$this->load->view("signin", $this->data);
		}
	}

	//登出
	public function logout()
	{
		$this->session->sess_destroy();

		header("Location: " . base_url() . "home/login/tw");
	}
}
