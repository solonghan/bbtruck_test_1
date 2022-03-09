<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * date string Helpers
 * 
 */

// ------------------------------------------------------------------------

if ( ! function_exists('date_tostring'))
{
    function date_tostring($date)
    {
    	$date = strtotime($date);
        if ((time()-$date)<60*10) {
            // 十分鐘內
            return '剛剛';
        } elseif (((time()-$date)<60*60)&&((time()-$date)>=60*10)) {
            // 十分鐘~1小時
            $s = floor((time()-$date)/60);
            return  $s."分鐘前";
        } elseif (((time()-$date)<60*60*24)&&((time()-$date)>=60*60)) {
            // 1小時～24小時
            $s = floor((time()-$date)/60/60);
            return  $s."小時前";
        } elseif (((time()-$date)<60*60*24*3)&&((time()-$date)>=60*60*24)) {
            // 1天~3天
            $s = floor((time()-$date)/60/60/24);
            return $s."天前";
        } else {
            // 超过3天
            if (date('Y', strtotime($date)) == date('Y')) {
            	// 今年
            	return date("m/d H:i", $date);
            } else {
            	return date("Y/m/d", $date);
            }
        }
    }
}


if ( ! function_exists('privilege_to_str'))
{
    function privilege_to_str($priv)
    {
        switch ($priv) {
            case 'super':
                return '最高權限管理員';
            case 'mgr':
                return '管理員';
        }
    }
}


/* For Wedding project - Start */

if ( ! function_exists('bride_type_to_string'))             // With bride_type_to_btn_num()
{
    function bride_type_to_string($type)
    {
        if ( ! is_numeric($type))
            return FALSE;

        switch ($type)
        {
            case '1':
                return '版型一 : 一張圖片 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            case '2':
                return '版型二 : 二張圖片, 左長右寬';
            case '3':
                return '版型三 : 二張圖片, 左寬右長';
            case '4':
                return '版型四 : 三張圖片 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            default:
                return FALSE; 
        }
    }
}

if ( ! function_exists('bride_type_to_str_for_form'))         // With bride_type_to_btn_num()
{
    function bride_type_to_str_for_form($type)
    {
        if ( ! is_numeric($type))
            return FALSE;

        switch ($type)
        {
            case '1':
                return '版型一';
            case '2':
                return '版型二';
            case '3':
                return '版型三';
            case '4':
                return '版型四';
            default:
                return FALSE; 
        }
    }
}

if ( ! function_exists('bride_type_to_btn_num'))             // With bride_type_to_string()
{
    function bride_type_to_btn_num($type)
    {
        if ( ! is_numeric($type))
            return FALSE;

        switch ($type)
        {
            case '1':
                return 1;
            case '2':
                return 2;
            case '3':
                return 2;
            case '4':
                return 3;
            default:
                return FALSE; 
        }
    }
}

if ( ! function_exists('bride_type_to_btn_types'))
{
    function bride_type_to_btn_types($type)
    {
        if ( ! is_numeric($type))
            return FALSE;

        switch ($type)
        {
            case '1':
                return array(2);
            case '2':
                return array(1, 2);
            case '3':
                return array(2, 1);
            case '4':
                return array(1, 1, 1);
            default:
                return FALSE; 
        }
    }
}
/* For Wedding project - End */