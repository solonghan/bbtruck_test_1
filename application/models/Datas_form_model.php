<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// 專 for 編輯或新增用
/* 專For編輯或新增用
 * @param : 用於在表單中的選項(通常為select用)
 * @field : 用於表單的欄位名稱、值對設定等表單欄位。
 */
class Datas_form_model extends Base_Model {

	// Fixed - Start

	public $changepwd_field = [
            ["舊密碼", "old_pwd", "password"],
            ["新密碼", "new_pwd", "password"],
        	["確認新密碼", "new_pwd_confirm", "password"]
    ];
    // Fixed - End


    // For Wedding project
	public function collection_post($item = '')
	{
		if (($item != '') AND (is_array($item)))
		{
			return [
['cover image', 'cover_img', 	'img', 		$item['cover_img'], 					  TRUE, '', 400 / 600, 'uploads/collection/'],
['photo1', 		'photo1', 		'img', 		json_decode($item['collection_imgs'])[0], 	'', '', 400 / 600, 'uploads/collection/'],
['photo2', 		'photo2', 		'img', 		json_decode($item['collection_imgs'])[1], 	'', '', 400 / 600, 'uploads/collection/'],
['photo3', 		'photo3', 		'img', 		json_decode($item['collection_imgs'])[2], 	'', '', 400 / 600, 'uploads/collection/'],
['photo4', 		'photo4', 		'img', 		json_decode($item['collection_imgs'])[3], 	'', '', 400 / 600, 'uploads/collection/'],
['year', 		'year_id', 		'select', 	$item['year_id'], 							'', '', ['value', 'string']],
['title', 		'title2', 		'text', 	$item['title2'], 							'', ''],
['sub_title', 	'title3', 		'text', 	$item['title3'], 							'', ''],
['description', 'description', 	'text', 	$item['description'], 						'', ''],
['information', 'information', 	'text', 	$item['information'], 						'', ''],
['status', 		'status', 		'select', 	$item['status'], 							'', '', ['value', 'string']],
['contract', 	'contract',		'text', 	$item['contract'], 							'', ''],
['create date',	'create_date', 	'datetime_pre',	$item['create_date'], 					'', ''],
			];
		}
		else
		{
			return [
['cover image', 'cover_img', 	'img', 				'',   TRUE, 	'', 400 / 600, 'uploads/collection/'],
['photo1', 		'photo1', 		'img', 				'', 	'', 	'', 400 / 600, 'uploads/collection/'],
['photo2', 		'photo2', 		'img', 				'', 	'', 	'', 400 / 600, 'uploads/collection/'],
['photo3', 		'photo3', 		'img', 				'', 	'', 	'', 400 / 600, 'uploads/collection/'],
['photo4', 		'photo4', 		'img', 				'', 	'', 	'', 400 / 600, 'uploads/collection/'],
['year', 		'year_id', 		'select', 			'', 	'', 	'', ['value', 'string']],
['title', 		'title2', 		'text', 			'', 	'', 	''],
['sub_title', 	'title3', 		'text', 			'', 	'', 	''],
['description', 'description',  'text', 			'', 	'', 	''],
['information', 'information',  'text', 			'', 	'', 	''],
['status', 		'status', 		'select', 			'', 	'', 	'', ['value', 'string']],
['contract', 	'contract', 	'text', 			'', 	'', 	''],
			];
		}
	}

	public function collection_add_year($item = '')
	{
		if (($item != '') AND (is_array($item)))
		{
			return [
				['year', 'year',  'p_select', $item['year'], TRUE, '', ['value', 'string'], 'collection_mgr'],
				['狀態', 'is_open', 'c_select', $item['is_open'], '', '', ['value', 'string'], 'collection_mgr'],
			];
		}
		else
		{
			return [
				['year', 'year', 'select', '', TRUE, '', ['value', 'string']],
				['狀態', 'is_open', 'select', '1', '', '', ['value', 'string']],
			];
		}
	}

	public function bride_post($item = '')
	{
		if ($item != '' AND is_array($item))
		{
			return [
['新增一列內文版型', '_content_type', 'btn_active',  '', 					TRUE, 	'', ['value', 'string'], 'bride'],
['title', 			'title', 		 'text', 		$item['title'], 	'', 	''],
['subtitle', 		'sub_title', 	 'text', 		$item['sub_title'], '', 	''],
['cover image', 	'cover_img', 	 'img', 		$item['cover_img'], TRUE,  '', 400 / 600, 			 'uploads/'],
[FALSE, 			'row_num', 	 	 'hid_btn', 	$item['row_num'], 	'', 	''],
[FALSE, 			'row_types', 	 'hid_btn', 	$item['row_types'], '', 	''],
[FALSE, 			'row_del', 	 	 'hid_btn', 	'', 				'', 	''],
			];
		}
		else
		{
			return [
['新增一列內文版型', '_content_type', 'btn_active',  '',		TRUE, 	'', ['value', 'string'], 'bride'],
['title', 			'title', 		 'text', 		'',		'', 	''],
['subtitle', 		'sub_title', 	 'text', 		'',		'', 	''],
['cover image', 	'cover_img', 	 'img', 		'',		TRUE, 	'', 400 / 600, 			 'uploads/'],
[FALSE, 			'row_num', 	 	 'hid_btn', 	 0,		'', 	''],
[FALSE, 			'row_types', 	 'hid_btn', 	'',		'', 	''],
[FALSE, 			'row_del', 	 	 'hid_btn', 	'', 	'', 	''],
			];
		}
	}

	public function bride_post_dynamic_btn($row, $i, $type, $img_type = 1, $img = '')
	{
		if ($img != '' AND is_string($img))
		{
			// row_$num_type_$type_photo_x
			if ($img_type == 1)
			{
				return [
['第'.$row.'列-'.$type.',第'.$i.'張圖', 'row_'.$row.'_photo_'.$i, 'img', $img, 	'', '', 400 / 600, 'uploads/'],
				];
			}
			elseif ($img_type == 2)
			{
				return [
['第'.$row.'列-'.$type.',第'.$i.'張圖', 'row_'.$row.'_photo_'.$i, 'img', $img, 	'', '', 810 / 540, 'uploads/'],
				];
			}
		}
		else
		{
			if ($img_type == 1)
			{
				return [
['第'.$row.'列-'.$type.',第'.$i.'張圖', 'row_'.$row.'_photo_'.$i, 'img', '', 	'', '', 400 / 600, 'uploads/'],
				];
			}
			elseif ($img_type == 2)
			{
				return [
['第'.$row.'列-'.$type.',第'.$i.'張圖', 'row_'.$row.'_photo_'.$i, 'img', '', 	'', '', 810 / 540, 'uploads/'],
				];
			}
		}
	}

	public function home_mgr($item = '')
	{
		if ($item != '' AND is_array($item))
		{
			return [
['backendground image 1', 'src1', 'img', $item['src1'], TRUE,  '', 810 / 540, 'uploads/home/'],
['backendground image 2', 'src2', 'img', $item['src2'], TRUE,  '', 810 / 540, 'uploads/home/'],
['backendground image 3', 'src3', 'img', $item['src3'], TRUE,  '', 810 / 540, 'uploads/home/'],
			];
		}
		else
		{
			return [
['backendground image 1', 'src1', 'img', '', TRUE,  '', 810 / 540, 'uploads/home/'],
['backendground image 2', 'src2', 'img', '', TRUE,  '', 810 / 540, 'uploads/home/'],
['backendground image 3', 'src3', 'img', '', TRUE,  '', 810 / 540, 'uploads/home/'],
			];
		}
	}
}