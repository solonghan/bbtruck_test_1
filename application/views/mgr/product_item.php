<tr id="tr_<?=$item['id'] ?>">
    <td><?=$item['id'] ?></td>
    <td>
        <div class="input-group" id="sortarea_<?=$item['id'] ?>">
            <? if ($item['sort'] == 1): ?>
            <span class="input-group-addon" style="color: #CCC; cursor: not-allowed;">▲</span>
            <? else: ?>
            <span class="input-group-addon sort_up">▲</span>
            <? endif; ?>
            <input type="hidden" id="sort_<?=$item['id'] ?>" value="<?=$item['sort'] ?>">
            <select class="form-control select2">
                <? 
                    for ($index=1; $index <= $total ; $index++) { 
                        echo '<option value="'.$index.'"';
                        if ($index == $item['sort']) {
                            echo ' selected';
                        }
                        echo '>'.$index.'</option>';
                    }
                ?>
            </select>
            <? if ($item['sort'] == $total): ?>
            <span class="input-group-addon" style="color: #CCC; cursor: not-allowed;">▼</span>
            <? else: ?>
            <span class="input-group-addon sort_down">▼</span>
            <? endif; ?>
        </div>
    </td>
    <td><?=$item['series'] ?></td>
    <td><?=$item['title_tw'] ?></td>
    <td>
        <?
            if ($item['cover'] != "") {
                echo '<a data-fancybox="cover_'.$item['id'].'" href="'.base_url().$item['cover'].'"><img src="'.base_url().$item['cover'].'" style="width:200px;"></a>';
            }
        ?>
    </td>
    <td>
        <?
            if (strpos($item['summary_tw'], "<img") !== FALSE) {
                echo "<span class='label label-info'>(圖片)</span>";
            }
            if (mb_strlen(strip_tags($item['summary_tw'])) > 100) {
                echo mb_substr(strip_tags($item['summary_tw']), 0, 100)."...";
            }else{
                echo strip_tags($item['summary_tw']);
            }
        ?>
    </td>
    <td>
        <? 
            if ($item['status'] == "on") {
                echo "<span class='label label-success'>開啟</span>";
            }else{
                echo "<span class='label label-danger'>關閉</span>";
            }
        ?>
    </td>
    <td><?=$item['create_date'] ?></td>
    <td>
        <button onclick="location.href='<?=base_url()."mgr/product/spec/".$item['id'] ?>'" class="btn btn-info btn-xs">規格</button>
        <button onclick="location.href='<?=base_url()."mgr/product/model/".$item['id'] ?>'" class="btn btn-info btn-xs">型號</button>

        <button onclick="location.href='<?=base_url()."mgr/product/edit/".$item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>
        
        <button id="del_<?=$item['id'] ?>" class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td>
</tr>