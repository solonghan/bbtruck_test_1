<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if ( ! function_exists('output_msg'))
{
	function output_msg($key = '0000')
	{
		$msg = array(
				'0000' => '?',

				'form_01' => '新增',				// from : 表單
				'form_02' => '編輯',
				'form_03' => '刪除',
				'form_21' => '新增成功',
				'form_22' => '編輯成功',
				'form_50' => '發生錯誤',
				'form_51' => 'Insert',
				'form_52' => 'Edit',
				'form_53' => 'Delete',

				'login_01' => '登錄成功',
				'login_02' => '查無此帳號',
				'login_03' => '密碼輸入錯誤',
				'login_04' => '您無權限登錄',

				'signup_01' => '帳號不可為空',
				'signup_02' => '密碼不可為空',
				'signup_03' => '兩次輸入的密碼不相同',

				'info_01' => '密碼變更成功',  	// info : 基本資訊(個人、會員等...)

				'msg_01' => 'success',  		// msg : ajax or api
				'msg_02' => 'error',
				'msg_11' => '資料取得成功',
				'msg_12' => '資料取得失敗',

				// For Wedding project use
				'collection_001' => '此年度已存在',
				'collection_002' => '新增年度時發生錯誤',
				'collection_003' => '年度加入後台menu時發生錯誤',
				'collection_004' => '將此年度之menu加入最高權限閱讀群組時發生錯誤',
				'collection_005' => '將此年度尚未開放, 請重新搜尋',
				'bride_001' 	 => '此網頁不開放',
				'contact_001' 	 => '欄位不可為空!',
				'contact_002' 	 => '5分鐘內寄信超過2次, 請等待後再發送。',

		);

		return $msg[$key];
	}
}