<?php defined('BASEPATH') or exit('No direct script access allowed');


class Contact_model extends Base_Model
{

	protected $page_count = 18;
	private $member_page_count = 20;
	private $report_page_count = 20;

	public function get_data($id)
	{
		$str = "SELECT * from contact where is_delete=0 AND id='$id' ";

		return $this->db->query($str)->row_array();
	}

	public function get_mgr_data($id)
	{
		$str = "SELECT * from contact_mgr where is_delete=0 AND id='$id' ";

		return $this->db->query($str)->row_array();
	}


	public function edit_mgr($id, $data)
	{
		return $this->db->where(array("id" => $id))->update('contact_mgr', $data);
	}

	public function edit($id, $data)
	{
		return $this->db->where(array("id" => $id))->update('contact', $data);
	}


	public function get_local_list($syntax, $order_by, $page, $page_count)
	{
		$total = $this->db->select()->from('contact')->where($syntax)->get()->num_rows();
		$total_page = ceil($total / $page_count);



		$list = $this->db->select()
			->from('contact')
			->where($syntax)
			->limit($page_count, ($page - 1) * $page_count)
			->order_by($order_by)
			->get()
			->result_array();



		return array(
			'total'      => $total,
			'total_page' => $total_page,
			'list'       => $list,
		);
	}



	public function set_post($data)
	{
		return $this->db->insert('contact', $data);
	}

	public function send_contact($data)
	{
		$this->send_mail(
			'service@weddingjenny.com',
			"您好，您在JennyChou上收到以下聯絡我們訊息：<br>
			姓名：" . $data['name'] . "<br>
			信箱：" . $data['email'] . "<br>
			電話：" . $data['phone'] . "<br>
			需求：" . $data['subject'] . "<br>
			使用日期：" . $data['wedding_date'] . "<br>
			預約日期：" . $data['appointment_date'] . "<br>		
			訊息：" . $data['message'] . "<br>
			以上，謝謝您",
			"《JennyChou》聯絡我們通知信"
		);

		$this->send_mail(
			'anbonbackend2021@gmail.com',
			"您好，您在JennyChou上收到以下聯絡我們訊息：<br>
			姓名：" . $data['name'] . "<br>
			信箱：" . $data['email'] . "<br>
			電話：" . $data['phone'] . "<br>
			需求：" . $data['subject'] . "<br>
			使用日期：" . $data['wedding_date'] . "<br>
			預約日期：" . $data['appointment_date'] . "<br>		
			訊息：" . $data['message'] . "<br>
			以上，謝謝您",
			"《JennyChou》聯絡我們通知信"
		);
	}

	public function send_mail($email, $body, $subject = "")
	{

		
		 //var_dump(base_url());
		// exit;
		if (!class_exists("phpmailer")) {
			//include("C://xampp/htdocs/new_wedding/phpmailer/class.phpmailer.php");
			include("./phpmailer/class.phpmailer.php");
			//require("C://xampp/htdocs/new_wedding/phpmailer/PHPMailerAutoload.php");
			require_once "./phpmailer/PHPMailerAutoload.php";
		}

		$mail = new PHPMailer();                        	// 建立新物件        

		$mail->IsSMTP();                         			// 設定使用SMTP方式寄信        
		$mail->SMTPAuth = true;                     		// 設定SMTP需要驗證
		$mail->SMTPSecure = "ssl";                  		// Gmail的SMTP主機需要使用SSL連線   
		//$mail->SMTPDebug = 1;
		$mail->Host = "smtp.gmail.com";                  	// Gmail的SMTP主機        
		$mail->Port = 465;                        			// Gmail的SMTP主機的port為465      
		$mail->CharSet = "utf-8";                   		// 設定郵件編碼   

		// $mail->Username = "service@weddingjenny.com";    // 設定驗證帳號        
		// $mail->Password = "0922025580";             		// 設定驗證密碼        

	
		// $mail->Username = "service@weddingjenny.com";     	// 設定驗證帳號        
		// $mail->Password = "rjqvwrifycbnkvln";             	// 設定驗證密碼        
		$mail->Username = "service@weddingjenny.com"; 
		$mail->Password="xnqhampspipzkbnt";

		$mail->From = "service@weddingjenny.com";         	// 設定寄件者信箱        
		$mail->FromName = "Jenny Chou";                   	// 設定寄件者姓名 

		$mail->Subject = $subject;                  		// 設定郵件標題        
		//$mail->SMTPDebug = 3;                               

		$mail->IsHTML(true);                        		// 設定郵件內容為HTML       
		$mail->AddAddress($email, $email);          		// 收件者郵件及名稱 ***改這個
		$mail->Body = $body;

		if ($mail->Send()) 									// 郵件寄出
		{
			return array("status" => TRUE);
		} else {
			print_r($mail->ErrorInfo);
			exit;
			return array("status" => FALSE, "msg" => $mail->ErrorInfo);
		}

		$mail->ClearAddresses();
	}
	public function get_view_data()
	{
		$str="select * from contact_mgr where is_delete=0";
		$res=$this->db->query($str)->row_array();

		//!d($res);
		return $res;
	}
}
