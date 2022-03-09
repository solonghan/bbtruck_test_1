<tr data-id="<?= $item['id'] ?>">
    <td><?= $item['id'] ?></td>
    <td><?= $item['desktop_title'] ?></td>
    <td><?= $item['mobile_title']?></td>
    <td><?= $item['content'] ?></td>
    
    <td><?=  $item['create_date'] ?></td>
    <td>
        <!--<button class="btn btn-success btn-xs" onclick="location.href='<?= base_url() ?>mgr/huntground/post_list/<?= $item['id'] ?>';" data-toggle="tooltip" data-original-title="文章列表"><i class="fa fa-fw ti-menu-alt"></i></button>-->
        <button class="btn btn-primary btn-xs" onclick="location.href='<?= base_url() ?>mgr/home_mgr_text/edit/<?= $item['id'] ?>';" data-toggle="tooltip" data-original-title="編輯"><i class="fa fa-fw ti-pencil"></i></button>
        <button class="btn btn-danger btn-xs del-btn" onclick = "location.href='<?= base_url()?>mgr/home_mgr/local_del/<?=$item['id'] ?>';"data-toggle="tooltip" data-original-title="刪除圖片"><i class="fa fa-fw ti-trash"></i></button>
    </td>
</tr>