<?
    $data = [
        ["問卷範本1", "採購會談意見表", base_url()."quest1", rand(10, 100), "Andy", ],
        ["問卷範本2", "線上會議意見表", base_url()."quest2", rand(10, 100), "peter", ],
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
        <button class="btn btn-info btn-xs" data-toggle="tooltip" data-original-title="預覽問卷(導連結)">預覽問卷</button>
        <!-- <button class="btn btn-primary btn-xs edit-btn" data-toggle="tooltip" data-original-title="編輯範本">編輯範本</button> -->
        <!-- <button class="btn btn-danger btn-xs del-btn" data-toggle="tooltip" data-original-title="刪除問卷">刪除問卷</button> -->
    </td>
</tr>
<?
    }
?>