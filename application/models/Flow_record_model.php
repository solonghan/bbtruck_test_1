<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flow_record_model extends Base_Model {


/* 寫入客戶端的前台流量紀錄 - Start */

    // 紀錄流量
    public function set_flow_record($enter, $client_ip)
    {
      
        if($this->db->where("create_date like '".date("Y-m-d")."%' AND ip = '".$client_ip."' AND enter='{$enter}'")
                    ->count_all_results('flow') <= 0)
        {
            $this->db->insert('flow', array("ip"=>$client_ip, "enter"=>$enter));
        }
    }
/* 寫入客戶端(不管是使用者還是後台)的流量紀錄 - End */


/* 取得流量 - Start */

    // 取得30天總流量
    public function &get_statistic($pre30day)
    {
        $get_statistic = $this->db->select("count(id) as value, SUBSTRING_INDEX(`create_date`, ' ', 1) as date")
                                  ->from('flow')
                                  ->where(array("create_date>="=>$pre30day))
                                  ->group_by("SUBSTRING_INDEX(`create_date`, ' ', 1)")
                                  ->get()
                                  ->result_array();
        return $get_statistic;
    }

    // 取得30天不重複流量
    public function &get_statistic_independent($pre30day)
    {
        $get_statistic_independent = $this->db->select("count(id) as value, SUBSTRING_INDEX(`create_date`, ' ', 1) as date")
                                              ->from('flow')
                                              ->where(array("create_date>="=>$pre30day, "enter"=>"home"))
                                              ->group_by("SUBSTRING_INDEX(`create_date`, ' ', 1)")
                                              ->get()
                                              ->result_array();
        return $get_statistic_independent;
    }
/* 取得流量 - End */
}






