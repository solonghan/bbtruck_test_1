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
    <td>
        <span style="width: 50px;">繁中:</span><input type="text" class="form-control edit_field" value="<?=$item['name_tw'] ?>" name="name_tw"><br>
        <span style="width: 50px;">EN:</span><input type="text" class="form-control edit_field" value="<?=$item['name_en'] ?>" name="name_en">
    </td>
    <td>
        <span style="width: 50px;">繁中:</span><textarea class="form-control edit_field" name="des_tw"><?=$item['des_tw'] ?></textarea><br>
        <span style="width: 50px;">EN:</span><textarea class="form-control edit_field" name="des_en"><?=$item['des_en'] ?></textarea>
    </td>
    <td><?=$item['create_date'] ?></td>
    <td>
        <button data-action="<?=base_url()."mgr/product/spec/".$item['p_id']."/edit_ajax/".$item['id'] ?>" class="btn btn-primary btn-xs ajax_update" id="update_<?=$item['id'] ?>">更新</button>
        
        <button id="del_<?=$item['id'] ?>" class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td>
</tr>