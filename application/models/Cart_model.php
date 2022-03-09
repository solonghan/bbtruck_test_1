<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_model extends CI_Model {
	private $localized = array();
	protected $ulang = "";
	private $isLogin = FALSE;
	private $level = 0;

	function __construct(){
		parent::__construct ();
		$this->load->model("Lang_model");
		// $this->localized = $this->Lang_model->localized();
		// $this->ulang = $this->Lang_model->get_lang();

		if ($this->session->isLogin && $this->encryption->decrypt($this->session->isLogin) == md5("uLogIn")) {
			$this->isLogin = TRUE;
			$this->level = $this->encryption->decrypt($this->session->level);
		}else{
			$this->isLogin = FALSE;
		}
	}

	public function clean_cart(){
		if (!$this->is_login()) return;

		$this->db->delete("cart", array("u_id"=>$this->encryption->decrypt($this->session->uid)));
		set_cookie("cart", "", 0);
	}

	public function merge_cart_when_login(){
		if (!$this->is_login()) return;

		$cart = array();
		$data = $this->db->get_where("cart", array("u_id"=>$this->encryption->decrypt($this->session->uid)))->row_array();
		if ($data != null && strtotime($data['update_date']) + 60*60*24*7 > strtotime(date('Y-m-d H:i:s'))) {
			$cart = unserialize($data['content']);
		}
		
		$cookie_cart = array();
		if (get_cookie("cart") && get_cookie("cart") != "") {
			$cookie_cart = unserialize(get_cookie("cart"));	
		}

		foreach ($cookie_cart as $item) {
			array_push($cart, $item);
		}

		set_cookie("cart", "", 0);

		$this->save_cart($cart);
	}

	public function cart_badge(){
		$cart = $this->cart();
		return count($cart);
	}

	public function add_cart($p_id, $quantity, $specification = FALSE){
		$cart = $this->cart();

		$is_inarray = FALSE;
		for ($i=0; $i < count($cart); $i++) { 
			if ($cart[$i]['id'] == $p_id && $cart[$i]['specification'] == $specification) {
				$is_inarray = TRUE;
				$cart[$i]['quantity'] += $quantity;
			}
		}
		if (!$is_inarray) {
			array_push($cart, array(
				"id"            =>	$p_id,
				"quantity"      =>	$quantity,
				"specification" =>	$specification
			));
		}
		
		$this->save_cart($cart);

		return array("cart"=>$this->get_cart(serialize($cart)), "badge"=>count($cart));
	}

	public function product_add_amount($p_id, $amount, $specification = FALSE){
		$cart = $this->cart();

		for ($i=0; $i < count($cart); $i++) { 
			if ($cart[$i]['id'] == $p_id && $cart[$i]['specification'] == $specification) {
				$cart[$i]['quantity'] = $amount;
			}
		}		

		$this->save_cart($cart);

		return array("cart"=>$this->get_cart(serialize($cart)), "badge"=>count($cart));
	}

	public function delete_cart($p_id, $specification = FALSE){
		$cart = $this->cart();

		for ($i=0; $i < count($cart); $i++) { 
			if ($cart[$i]['id'] == $p_id && $cart[$i]['specification'] == $specification) {
				array_splice($cart, $i, 1);
			}
		}		

		$this->save_cart($cart);

		return array("cart"=>$this->get_cart(serialize($cart)), "badge"=>count($cart));
	}

	public function get_cart_by_array(){
		$cart = $this->cart();
		$data = array();
		foreach ($cart as $item) {
			$p = $this->db->select("P.*")
						  ->from("product P")
						  ->where(array("P.id"=>$item['id']))
						  ->get()->row_array();
			// $p['localized_name'] = ($p['localized_name']!=null && $p['localized_name']!="")?$p['localized_name']:$p['name'];
			// if ($p['pics'] == "") {
			// 	$p['photo'] = base_url()."img/default.png";	
			// }else{
			// 	$pics = explode(",", $p['pics']);
			// 	$p['photo'] = base_url().$pics[0];
			// }
			unset($p['pics']);
			unset($p['summary']);
			unset($p['des']);
			unset($p['rule']);
			unset($p['payment_des']);
			$p['quantity'] = $item['quantity'];
			$p['specification'] = $item['specification'];

			if ($this->level == 0) {
				$p['price'] = 0;
			}else if ($this->level == 1) {
				$p['price'] = $p['level1_price'];
			}else if ($this->level == 2) {
				$p['price'] = $p['level2_price'];
			}else if ($this->level == 3) {
				$p['price'] = $p['level3_price'];
			}

			$data[] = $p;
		}

		return $data;
	}

	public function get_cart($defaultcart = FALSE){
		$cart = array();
		if ($defaultcart !== FALSE) {
			$cart = unserialize($defaultcart);
		}else{
			$cart = $this->cart();
		}

		if (count($cart) <= 0) return "<div style='text-align:center;'>".$this->localized['cart_empty']."</div>";

		$html = "";
		$amout = 0;
		foreach ($cart as $item) {
			$p = $this->db->select("P.*")
						  ->from("product P")
						  ->where(array("P.id"=>$item['id']))
						  ->get()->row_array();
			// $product_name = ($p['localized_name']!=null && $p['localized_name']!="")?$p['localized_name']:$p['name'];

			$photo = base_url().$p['photo'];//explode(",", $p['pics'])[0];
			
			$price = 0;
			if ($this->level == 0) {
				$price = 0;
			}else if ($this->level == 1) {
				$price = $p['level1_price'];
			}else if ($this->level == 2) {
				$price = $p['level2_price'];
			}else if ($this->level == 3) {
				$price = $p['level3_price'];
			}

			// $html .= '<li>
			// 			<div class="image"><img src="'.$photo.'"></div>
			// 			<strong><a href="'.base_url().'product/detail/'.$item['id'].'">'.$product_name.'</a>'.$item['quantity'].' x $'.$p['price'].' </strong>
   //                      <a href="javascript:void(0);" class="action del_cart" id="delcart_'.$item['id'].'"><i class="icon-trash"></i></a>
   //                   </li>';
   			$html .= '<div class="form-group">
                        <div class="image">
                            <img src="'.$photo.'">
                        </div>
                        <strong><a href="'.base_url().'product/detail/'.$item['id'].'">'.$p['name'].'</a>'.$item['quantity'].' x $'.$price.' </strong>
                        <a href="javascript:void(0);" class="action del_cart" id="delcart_'.$item['id'].'"><i class="icon-trash"></i></a>
                    </div>';
            $amout += $item['quantity'] * $price;
		}
		// $html .= '<li>
  //                   <div>'.$this->localized['total'].': <span>$'.$amout.'</span></div>
  //                   <a href="'.base_url().'cart" class="button_drop">'.$this->localized['cart'].'</a>
  //                   <a href="'.base_url().'checkout" class="button_drop outline">'.$this->localized['checkout'].'</a>
  //                 </li>';
  		$html .= '<div class="form-group">
                    <div>'.$this->localized['total'].': <span>$'.$amout.'</span></div>
                    <a href="'.base_url().'cart" class="button_drop">'.$this->localized['cart'].'</a>
                    <a href="'.base_url().'checkout" class="button_drop outline">'.$this->localized['checkout'].'</a>
                </div>';
        return $html;
	}

	private function save_cart($cart){
		if ($this->is_login()) {
			$data = $this->db->get_where("cart", array("u_id"=>$this->encryption->decrypt($this->session->uid)))->row_array();
			if ($data != null) {
				$this->db->where(array("u_id"=>$this->encryption->decrypt($this->session->uid)))->update("cart", array("content"=>serialize($cart)));
			}else{
				$this->db->insert("cart", array("content"=>serialize($cart), "u_id"=>$this->encryption->decrypt($this->session->uid)));
			}
		}else{
			set_cookie("cart", serialize($cart), 3*86400);
		}
	}

	private function cart(){
		if ($this->is_login()) {
			$data = $this->db->get_where("cart", array("u_id"=>$this->encryption->decrypt($this->session->uid)))->row_array();
			if ($data != null && strtotime($data['update_date']) + 60*60*24*7 > strtotime(date('Y-m-d H:i:s'))) {
				//超過7日，購物車清空
				return unserialize($data['content']);
			}
		}else{
			if (get_cookie("cart") && get_cookie("cart") != "") {
				return unserialize(get_cookie("cart"));	
			}
		}
		return array();
	}

	private function is_login(){
		if (!($this->session->isLogin && $this->encryption->decrypt($this->session->isLogin) == md5("uLogIn"))) {
			return FALSE;
		}
		return TRUE;
	}

	// 實體商品付款資料確認
	public function check_info(){
		
		$user_id = $this->session->id;
		$user = $this->db->get_where('user', ['id' => $user_id])->row();
		if (!empty($user->addr) && !empty($user->phone)) {
			$data=array(
				'addr'	=>	$user->addr,
				'phone'	=>	$user->phone
			);
			return $data;
		} else {
			return false;
		}
	}


	public function update_info()
	{
		$addr    = $this->input->post('addr');
		$phone   = $this->input->post('phone');
		$user_id = $this->session->id;

		$data = [];
		if (!empty($addr)) $data['addr'] = $addr;
		if (!empty($phone)) $data['phone'] = $phone;

		$res = $this->db->where(['id' => $user_id])->update('user', $data);
		
		if ($res) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}