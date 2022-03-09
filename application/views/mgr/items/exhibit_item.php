<tr data-id="<?=$item['id'] ?>">
    <!-- <td><?=$item['id'] ?></td> -->
    
    
    <!-- <td>
        <? if ($item['logo'] != ""): ?>
        <a data-fancybox="gallery_<?=$item['id'] ?>" href="<?=base_url().$item['logo'] ?>">
            <img src="<?=base_url().$item['logo'] ?>" style="width: 100%;">
        </a>
        <? endif; ?>
    </td> -->
    
    <td>2020</td> 
    
    <td><?=$item['code'] ?></td>

    <td><?=$item['title'] ?></td>
    
    <td><?=$item['start_date']." ~ ".$item['end_date'] ?></td>
    <!-- <td>
        上架日期：<?=$item['online_date'] ?><br>
        下架日期：<?=$item['offline_date'] ?>
    </td> -->
    <!-- <td>
        <input type="checkbox" class="status_switcher" data-size="mini" data-on-color="success" data-off-color="danger"<?=($item['status']=="open")?' checked':'' ?>>
    </td> -->
    <!-- <td><?=str_replace(" ", "<br>", $item['create_date']) ?></td> -->
    <td>
        <button class="btn btn-primary btn-xs" onclick="location.href='<?=base_url() ?>mgr/exhibit/edit/<?=$item['id']?>';">展覽資訊</button>
        <button class="btn btn-info btn-xs" onclick="location.href='<?=base_url() ?>mgr/meeting/edit/<?=$item['id']?>';">會議資訊</button>
        <!-- <button class="btn btn-primary btn-xs edit-btn"><span class="fa fa-fw ti-pencil"></span></button> -->
        
        <!-- <button class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button> -->
    </td>
</tr>