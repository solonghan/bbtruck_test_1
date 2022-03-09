<tr data-id="<?= $item['id'] ?>">
    <td><?= $item['id'] ?></td>
    
    <!-- <td><?= $total?> </td> -->
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
                            echo '  selected';
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
    

    <td><?if(!empty($item['cover'])){?><img src= "<?=base_url(). $item['cover'] ?>" width ="100px"><?}?></td>
    
    <td><?= $item['name'] ?></td>
    <td><?= $item['year'] ?></td>
    <td><?= $item['item_no'] ?></td>
    <td><?= $item['content'] ?></td>
   
  
    <td><? if(!empty($item['img1'])){ ?><img src="<?=base_url(). $item['img1'] ?>" width ="100px"><?}?> </td>
    <td><? if(!empty($item['img2'])){ ?><img src="<?=base_url(). $item['img2'] ?>" width ="100px"><?}?> </td>
    <td><? if(!empty($item['img3'])){ ?><img src="<?=base_url(). $item['img3'] ?>" width ="100px"><?}?> </td>
    <td><? if(!empty($item['img4'])){ ?><img src="<?=base_url(). $item['img4'] ?>"width ="100px"><?}?> </td>
    <td><?= $item['shop_link'] ?></td>
    
    
   
    <td><?=  $item['create_date'] ?></td>
    <td>
        <!--<button class="btn btn-success btn-xs" onclick="location.href='<?= base_url() ?>mgr/huntground/post_list/<?= $item['id'] ?>';" data-toggle="tooltip" data-original-title="文章列表"><i class="fa fa-fw ti-menu-alt"></i></button>-->
        <button class="btn btn-primary btn-xs" onclick="location.href='<?= base_url() ?>mgr/collection/edit/<?= $item['id'] ?>';" data-toggle="tooltip" data-original-title="編輯"><i class="fa fa-fw ti-pencil"></i></button>
        <button class="btn btn-danger btn-xs del-btn" onclick = "location.href='<?= base_url()?>mgr/collection/local_del/<?=$item['id'] ?>';"data-toggle="tooltip" data-original-title="刪除圖片"><i class="fa fa-fw ti-trash"></i></button>
    </td>
</tr>