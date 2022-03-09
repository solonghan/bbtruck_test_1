<tr data-id="<?=$item['id'] ?>">
    <td><?=$item['id'] ?></td>
    <td><?=$item['code'] ?></td>
    <td><?=$item['owner'] ?></td>
    <td><?=$item['show_name'] ?></td>
    <td><?=$item['name'] ?></td>
    <?php if ($item['cover'] != ''): ?>
    <td><img src="<?=base_url().$item['cover'] ?>" width="50" height="50"></td>
    <?php endif; ?>
    <td><?=$item['discuss_hot'] ?></td>
    <td><?=$item['people'] ?></td>
    <td><?=$item['create_date'] ?></td>
    <td>
        <button class="btn btn-info btn-xs" onclick="location.href='<?=base_url().'mgr/hobby_club/index/'.$item['id']?>';" data-toggle="tooltip" data-original-title="查看同好獵場細節"><i class="fa fa-fw ti-menu-alt"></i></button>
    </td>
</tr>