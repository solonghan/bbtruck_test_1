<?php defined('BASEPATH') or exit('No direct script access allowed');


    class Media_model extends Base_Model {

        public function get_local_list($syntax, $order_by, $page, $page_count)
	    {
		    $total = $this->db->select()->from('media_exposure')->where($syntax)->get()->num_rows();
		    $total_page = ceil($total / $page_count);

		    $list = $this->db->select()
		    	->from('media_exposure')
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

        public function edit($home_id, $data){
            return $this->db->where(array("id"=>$home_id))->update('media_exposure', $data);
        }
    
        public function add($data){
    
           // var_dump($data['type']);
            
            $res = $this->db->insert('media_exposure', $data);
            
           
            if (!$res) return FALSE;
          
            
            $home_id = $this->db->insert_id();
    
           
            //$this->home_add_header_post($home_id);
            return $home_id;
        }


        public function get_data($home_id){
            return $this->db->get_where('media_exposure', array("id"=>$home_id))->row_array();
        }


        public function get_all_post(){
            $str="select * from media_exposure where is_delete=0 ";
            $res=$this->db->query($str)->result_array();

        //    !d($res);
        //     exit;    
            return $res;


        }
    }
?>