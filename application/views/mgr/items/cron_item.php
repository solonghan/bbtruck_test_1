<?
    $data = [
        ["會議預約通知信", "當會議成功預約時", "自動發送", "無", "開啟"],
        ["配對成功信", "審核配對狀態",  "每日固定時間發送", "每日 00:00:00 發送", "開啟"],
    ];
    foreach ($data as $item) {
        echo '<tr>';
        for ($i=0; $i < count($item); $i++) { 
            if ($i == 4) {
                $tag = explode(",", $item[$i]);
                echo '<td>';
                foreach ($tag as $t) {
                    echo '<span class="label label-primary">'.$t.'</span>&nbsp;';       
                }   
                echo '</td>';
            }else{
                echo '<td>'.$item[$i].'</td>';    
            }
        }
?>
    <td>
        <!-- <button class="btn btn-info btn-xs" data-toggle="tooltip" data-original-title="手動發送">手動發送</button> -->
        <button class="btn btn-primary " data-toggle="tooltip" data-original-title="編輯排程">編輯排程</button>
        <button class="btn btn-danger btn-xs del-btn" data-toggle="tooltip" data-original-title="刪除排程">刪除排程</button>
    </td>
</tr>
<?
    }
?>