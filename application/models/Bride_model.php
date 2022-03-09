<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bride_model extends Base_Model {
	protected $page_count = 18;
	private $member_page_count = 20;
	private $report_page_count = 20;

    public function get_data($id){
        $str="select * from bride where is_delete=0 and id= '$id' ";
        $res=$this->db->query($str)->row_array();
        return $res;
    }

    public function add($data){
        
        $res = $this->db->insert('bride', $data);
		if (!$res) return FALSE;
		$item_id = $this->db->insert_id();
		
		return $item_id;
         
    }

	public function edit($id,$data){
		$res = $this->db->where('id',$id)
						->update('bride', $data);
		if (!$res) return FALSE;
		//$item_id = $this->db->insert_id();
		
		return $res;

		
	}
    public function get_local_list($syntax, $order_by, $page, $page_count)
	{
		$total = $this->db->select()->from('bride')->where($syntax)->get()->num_rows();
		$total_page = ceil($total / $page_count);

		$list = $this->db->select()
			->from('bride')
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

    public function get_all_num($syntax)
	{
		return $this->db->select('id')
						->where($syntax)
						->get('bride')
						->num_rows();
	}

	public function get_all_lists($syntax, $order_by, $page)
	{
        return $this->db->select('*')
        				->from('bride')
        				->where($syntax)
        				->order_by($order_by)
        				->limit($this->page_count, ($page-1)*$this->page_count)
        				->get()
        				->result_array();
	}

	public function get_posts()
	{
		return $this->db->select('*')
						->from('bride')
        				->where('is_delete', '0')
						->order_by('sort', 'ASC')
						->get()
						->result_array();
	}

	public function get_post_detail($id)
	{
		$row = $this->db->select('*')
						->from('bride')
						->where(array('id' => $id, 'is_delete' => '0'))
        				->get()
        				->row_array();

		//var_dump($row);		

       	if ($row === NULL)
        {
        	return '';
        }
        else
        {
        	return $row;
        }
	}

	public function set_post_detail($id, $data)
	{
		if ($id === 'add')
			return $this->db->insert('bride', $data);

		return $this->db->where('id', $id)->update('bride', $data);
	}

	public function is_post_delete($id)
	{
		return $this->db->select('is_delete')
						->from('bride')
						->where('id', $id)
        				->get()
        				->row_array();
	}
}