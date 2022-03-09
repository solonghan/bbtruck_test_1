<?
    $data = [
        ["範本1", "會議預約通知信", base_url()."xxxxx", "ADMIN", ],
        ["範本2", "配對成功信", base_url()."oooo", "ADMIN", ],
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
        <button class="btn btn-info btn-xs" data-toggle="tooltip" data-original-title="發送信件">發送信件</button>
        <button class="btn btn-primary btn-xs edit-btn" data-toggle="tooltip" data-original-title="編輯範本">編輯範本</button>
        <button class="btn btn-danger btn-xs del-btn" data-toggle="tooltip" data-original-title="刪除範本">刪除範本</button>
    </td>
</tr>
<?
    }
?>