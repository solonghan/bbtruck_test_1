<?
    $data = [
        ['台灣國際工具機展採購洽談會', "2020-09-10|11:00", "01", "Aliba Corp.", "上銀科技股份有限公司<br>王有名", "https://webex.com/", "<span class='text text-success'>已完成</span>"],
        ['台灣國際工具機展採購洽談會', "2020-09-17|14:00", "02", "Treasure tech Corp.", "東台精機股份有限公司<br>曾實力", "https://webex.com/", "<span class='text text-danger'>正在進行</span>"],
        ['台灣國際工具機展採購洽談會', "2020-09-28|09:00", "03", "FATCAT ALKD Corp.", "永進機械工業股份有限公司<br>顧品質", "https://webex.com/", "尚未進行"]
    ];
    foreach ($data as $item) {
        echo '<tr>';
        for ($i=0; $i < count($item); $i++) { 
            if ($i == 5) {
                echo '<td>';
                echo '<a href="'.$item[$i].'">連結</a>';
                echo '</td>';
            }else{
                echo '<td>'.$item[$i].'</td>';    
            }
        }
?>
    <!-- <td>
        <button class="btn btn-info btn-xs schedule-btn" data-toggle="tooltip" data-original-title="查看細節"><i class="fa fa-fw fa-eye"></i></button>
         <button class="btn btn-primary btn-xs edit-btn" data-toggle="tooltip" data-original-title="編輯權限"><span class="fa fa-fw ti-pencil"></span></button> 
        
        <button class="btn btn-danger btn-xs del-btn" data-toggle="tooltip" data-original-title="刪除"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td> -->
</tr>
<?
    }
?>