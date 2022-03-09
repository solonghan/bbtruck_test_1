<tr>
    <td><?=$item['title'] ?></td>
    <td>
        <?
            // $sdt = new DateTime($item['start'], new DateTimeZone('Asia/Taipei'));
            // echo $sdt->format('Y-m-d H:i:s')."<br>";
            // $edt = new DateTime($item['end'], new DateTimeZone('Asia/Taipei'));
            // echo $edt->format('Y-m-d H:i:s');
            
            // echo $item['start'];//date("Y-m-d H:i:s", strtotime('+ 8 hours', strtotime($item['start'])))."<Br>";
            // echo $item['end'];//date("Y-m-d H:i:s", strtotime('+ 8 hours', strtotime($item['end'])));
            
            echo date("Y-m-d H:i:s", strtotime($item['start']))."<Br>";
            echo date("Y-m-d H:i:s", strtotime($item['end']));
        ?>
    </td>
    <td></td>
    <td></td>
    <td></td>
    <td><a target="_blank" href="<?=$item['url'] ?>">連結</a><br>密碼: <?=$item['password'] ?></td>
    <td><?=$item['state'] ?></td>
    <!-- <td>
        <button class="btn btn-info btn-xs schedule-btn" data-toggle="tooltip" data-original-title="查看細節"><i class="fa fa-fw fa-eye"></i></button>
         <button class="btn btn-primary btn-xs edit-btn" data-toggle="tooltip" data-original-title="編輯權限"><span class="fa fa-fw ti-pencil"></span></button> 
        
        <button class="btn btn-danger btn-xs del-btn" data-toggle="tooltip" data-original-title="刪除"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td> -->
</tr>