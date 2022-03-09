<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends Base_Model {

    public function get_local_list($syntax, $order_by, $page, $page_count)
	{
		$total = $this->db->select()->from('collection_category')->where($syntax)->get()->num_rows();
		$total_page = ceil($total / $page_count);

		$list = $this->db->select()
			->from('collection_category')
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

    public function edit($club_id, $data){
		return $this->db->where(array("id"=>$club_id))->update('collection_category', $data);
	}

	public function add($data){
		$res = $this->db->insert('collection_category', $data);
		if (!$res) return FALSE;
		$club_id = $this->db->insert_id();
		//$this->club_add_header_post($club_id);
		return $club_id;
	}


    public function get_category_select(){
        $str="select name from collection_category where is_delete=0 ";
        $res=$this->db->query($str)->result_array();

        if($res){


            foreach($res as  $r){


                $data[]=array(
                    'id'        =>  $r['name'],
                    'title'     =>  $r['name'] 

                );
            }
            return $data;
        }
           
        else
            return FALSE;    

    }


    

    public function get_all_category(){
        $str="select name from collection_category where is_delete=0 ";
        $res=$this->db->query($str);
        
        if($res){
            $num=$res->num_rows();
            //!d($num);
            $count=0;
            foreach($res->result_array() as  $r){


                $category[$count]=$r['name'];
                $count++;
            }
            $data[0]=$num;
            $data[1]=$category;
            return $data;
        }
           
        else
            return FALSE;   

    }


    public function get_category_data($id){
        $str="select * from collection where is_delete=0 and id ='$id'";
        $res=$this->db->query($str)->result_array();

        return $res;
    }
}
?>
