<?
    $data = [
        ["真棒有限公司<br>Taiwan GMT+8", "王大明", "wang@pccliem<br>02-22341232", "<strong>56283523</strong>", "手工業", rand(1,30)."/35", "12"],
        ["添丁實業有限公司<br>Taiwan GMT+8", "廖添丁", "tti@gmail.com<br>0912313567", "<strong>82341287</strong>", "腳踏車", rand(1,30)."/42", "20"]
    ];
    foreach ($data as $item) {
        echo '<tr>';
        for ($i=0; $i < count($item); $i++) { 
                echo '<td>'.$item[$i].'</td>';    
            
        }
?>
    <td>
        <button class="btn btn-info btn-xs schedule-btn" data-toggle="tooltip" data-original-title="時程表"><i class="fa fa-fw fa-calendar"></i></button>
        <button class="btn btn-primary btn-xs edit-btn" data-toggle="tooltip" data-original-title="編輯廠商"><span class="fa fa-fw ti-pencil"></span></button>
        
        <button class="btn btn-danger btn-xs del-btn" data-toggle="tooltip" data-original-title="刪除"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td>
</tr>
<?
    }
?>