<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_model extends Base_Model {
	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

	public function get_shop_menu(){
		$syntax = "status = 'on'";
		return $this->db->select("id, title")->get_where($this->shop_menu_table, $syntax)->result_array();
	}

	public function get_shop_product(){
		$today = date("Y-m-d H:i:s");
		$syntax = "P.is_delete = 0 AND P.status = 'on' AND ('{$today}' BETWEEN P.online_date AND P.offline_date) AND P.stock <> 0";

		$menu = $this->get_shop_menu();
		$data = array("data"=>array(), "menu"=>$menu);

		$list = $this->db->get_where($this->shop_product_table, $syntax)->result_array();
		$data = array();
		foreach ($list as $item) {
			$data[] = $this->shop_item_format($item);
		}
	}

	private function shop_item_format($data){
		$payment = "";
		switch ($data['payment']) {
			case 'tribe':
				$payment = '<img src="'.base_url().'assets/images/icon_tribe.svg">';
				break;
			
			default:
				# code...
				break;
		}

		return array(
			"cover"        =>	base_url()."uploads/demo/cat_price.png",
			"id"           =>	$data['type']."_".$data['id'],
			"title"        =>	$data['title'],
			"sub_title"    =>	$data['sub_title'],
			"price"        =>	'<img src="'.base_url().'assets/images/icon_tribe.svg"> 5',
			"extra_reward" =>	"",
			"des"          =>	"",
			"cnt"          =>	0,
			"btns"         =>	array(
				array(
					"title"      =>	"贈送",
					"bg_color"   =>	"#036EB8",
					"text_color" =>	"#FFFFFF",
					"function"   =>	"gift"
				),
				array(
					"title"      =>	"購買",
					"bg_color"   =>	"#DC131A",
					"text_color" =>	"#FFFFFF",
					"function"   =>	"tribe"
				)
			)
		);
	}
}