<?
    $data = [
        ["GoodBuy Co.,<br>America UST-12", "Godaddy wang", "terry@adeco.com<br>02-22341232", "hosting", "<strong class='label label-primary'>美洲辦事處</strong>", rand(1,50)."/38", rand(1,30)],
        ["Alibaba Tech Corp.<br>China UST+8", "Ma YUAN", "alice@evora.com<br>", "ecommerce", "自行申請", rand(1,50)."/40", rand(1,30)]
    ];
    foreach ($data as $item) {
        echo '<tr>';
        for ($i=0; $i < count($item); $i++) { 
            echo '<td>'.$item[$i].'</td>';
        }
?>
    <td>
        <button class="btn btn-info btn-xs schedule-btn" data-toggle="tooltip" data-original-title="時程表"><i class="fa fa-fw fa-calendar"></i></button>
        <button class="btn btn-primary btn-xs edit-btn" data-toggle="tooltip" data-original-title="編輯買主"><span class="fa fa-fw ti-pencil"></span></button>
        
        <button class="btn btn-danger btn-xs del-btn" data-toggle="tooltip" data-original-title="刪除"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td>
</tr>
<?
    }
?>