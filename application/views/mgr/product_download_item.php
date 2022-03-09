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
    <td><?=$select['classify'][$item['classify']]['title_tw'] ?></td>
    <td><?=$item['des_tw']."<hr>".$item['des_en'] ?></td>
    <td>
        <?
            // $select['os'][$item['os']]['name_tw'] 
            foreach ($os as $o_item) {
                echo $select['os'][$o_item['os_id']]['name_tw']."<br>";
            }
        ?>
    </td>
    <td>
        <? if ($item['url'] != ""){ ?>
        <a href="<?=(strpos($item['url'], "http") !== FALSE)?$item['url']:base_url().$item['url'] ?>" target="_blank">下載連結</a>
        <? }else if($item['file_id'] > 0){ ?>
        <a href="<?=base_url()."product/download/".$item['file_id'] ?>" target="_blank">下載連結</a>
        <? }else{ ?>
        無連結
        <? } ?>
    </td>
    <td><?=$item['install_path']."<hr>".$item['file_name'] ?></td>
    <td><?=$item['create_date'] ?></td>
    <td>
        <button onclick="location.href='<?=base_url()."mgr/product/download/edit/".$item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>
        
        <button id="del_<?=$item['id'] ?>" class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td>
</tr>