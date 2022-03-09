<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ready_text_model extends Base_Model {
	protected $page_count = 18;
	private $member_page_count = 20;
	private $report_page_count = 20;

	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

    public function get_local_list($syntax, $order_by, $page, $page_count)
	{
		$total = $this->db->select()->from($this->ready_text_table)->where($syntax)->get()->num_rows();
		$total_page = ceil($total / $page_count);

		$list = $this->db->select()
			->from($this->ready_text_table)
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


    public function add($data){

         // var_dump($data['type']);
    //    exit;
		$res = $this->db->insert($this->ready_text_table, $data);
	    
       
        if (!$res) return FALSE;
      
        
		$home_id = $this->db->insert_id();

       
		//$this->home_add_header_post($home_id);
		return $home_id;
    }

    public function get_data($id){
        $str="select * from  ready_text where  id ='$id' and is_delete=0  ";
        $res=$this->db->query($str)->row_array();

        return $res;
    }


    public function edit($id,$data){
        return $this->db->where(array("id"=>$id))->update($this->ready_text_table, $data);

    }


	public function get_text(){

		$res=$this->db->select()
					  ->from('ready_text')
					  ->get()
					  ->result_array();
					  
		//!d($res);
	return $res[0]		;	  

	}

}