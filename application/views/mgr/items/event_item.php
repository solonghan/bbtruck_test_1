<tr data-id="<?= $item['id'] ?>">
    <td><?= $item['id'] ?></td>
    <td><?= $item['title'] ?></td>
    <td><?= $item['rule'] ?></td>
    <td><?= $item['participants'] ?></td>
    <td style="text-align:center"><?= $item['start_datetime'] . "<br>～<br>" . $item['end_datetime'] ?></td>
    <td>
        <input type="checkbox" class="status_switcher" data-size="mini" data-on-color="success" data-off-color="danger" <?= ($item['status'] == "on") ? ' checked' : '' ?>>
    </td>
    <td><?= $item['create_date'] ?></td>
    <td>
        <button class="btn btn-success btn-xs" onclick="location.href='<?= base_url() ?>mgr/event/awards_add/<?= $item['id'] ?>';" data-toggle="tooltip" data-original-title="新增獎品"><i class="fa fa-fw ti-gift"></i></button>
        <button class="btn btn-default btn-xs" onclick="location.href='<?= base_url() ?>mgr/event/awards/<?= $item['id'] ?>';" data-toggle="tooltip" data-original-title="獎品列表"><i class="fa fa-fw ti-menu-alt"></i></button>
        <button class="btn btn-primary btn-xs" onclick="location.href='<?= base_url() ?>mgr/event/list_edit/<?= $item['id'] ?>';" data-toggle="tooltip" data-original-title="編輯"><i class="fa fa-fw ti-pencil"></i></button>
        <button class="btn btn-danger btn-xs del-btn" data-toggle="tooltip" data-original-title="刪除抽獎活動"><i class="fa fa-fw ti-trash"></i></button>
    </td>
</tr>