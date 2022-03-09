<?
    $data = [
        ["範本1", "會議預約通知信", "<span class='label label-primary'>買主</span> Alibaba", "已發送", "2020-10-27 21:13:00",],
        ["範本2", "配對成功信", "<span class='label label-primary'>廠商</span> Asus",  "送件失敗，等待重試", "2020-10-13 09:27:00",],
    ];
    foreach ($data as $item) {
        echo '<tr>';
        for ($i=0; $i < count($item); $i++) { 
            // if ($i == 4) {
            //     $tag = explode(",", $item[$i]);
            //     echo '<td>';
            //     foreach ($tag as $t) {
            //         echo '<span class="label label-primary">'.$t.'</span>&nbsp;';       
            //     }   
            //     echo '</td>';
            // }else{
                echo '<td>'.$item[$i].'</td>';    
            // }
        }
?>
    <td>
        <button class="btn btn-info btn-xs" data-toggle="tooltip" data-original-title="重新發送">重新發送</button>
        <button class="btn btn-success" data-toggle="tooltip" data-original-title="查看信件詳細內容">詳細資訊</button>
        <!-- <button class="btn btn-danger btn-xs del-btn" data-toggle="tooltip" data-original-title="刪除範本">刪除範本</button> -->
    </td>
</tr>
<?
    }
?>