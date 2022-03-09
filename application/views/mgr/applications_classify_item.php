<tr id="tr_<?=$item['id'] ?>">
    <td><?=$item['id'] ?></td>
    <td>
        <div class="input-group" id="sortarea_<?=$item['id'] ?>">
            <? if ($item['sort'] == 1): ?>
            <span class="input-group-addon" style="color: #CCC; cursor: not-allowed;">▲</span>
            <? else: ?>
            <span class="input-group-addon sort_up">▲</span>
            <? endif; ?>
            <!-- <input type="text" class="form-control text-center" id="sort_<?=$item['id'] ?>" value="<?=$item['sort'] ?>"> -->
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
    <td><?=$item['title_tw'] ?></td>
    <td><?=$item['title_en'] ?></td>
    <td><?=$item['create_date'] ?></td>
    <td>
        <button onclick="location.href='<?=base_url()."mgr/applications/classify/".$category_id."/edit/".$item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>
        
        <button id="del_<?=$item['id'] ?>" class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td>
</tr>