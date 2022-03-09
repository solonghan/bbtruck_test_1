<tr data-id="<?= $item['id'] ?>">
    <td><?= $item['id'] ?></td>
    <td><a target="_blank" href="<?= base_url() . $item['cover'] ?>"><img src="<?= base_url() . $item['cover'] ?>" alt="" style="width:150px"></a></td>
    <td><?= $item['title'] ?></td>
    <td style="text-align: center">
        <?= $item['level_title'] ?>
        <br>
        <img src="<?= base_url() . $item['level_img'] ?>" alt="" style="width:150px">
    </td>
    <td><a target="_blank" href="<?= base_url() . 'mgr/event/list_edit/' . $item['event_id'] ?>"><?= $item['event_title'] ?></a></td>
    <td><?= $item['worth'] ?></td>
    <td><?= $item['quota'] ?></td>
    <td><?= (strlen($item['des']) > 50) ? mb_substr($item['des'], 0, 300) . '...' : $item['des'] ?></td>
    <td>
        <input type="checkbox" class="status_switcher" data-size="mini" data-on-color="success" data-off-color="danger" <?= ($item['status'] == "on") ? ' checked' : '' ?>>
    </td>
    <td>
        <button class="btn btn-primary btn-xs" onclick="location.href='<?= base_url() ?>mgr/event/awards_edit/<?= $item['id'] ?>';" data-toggle="tooltip" data-original-title="編輯"><i class="fa fa-fw ti-pencil"></i></button>
        <button class="btn btn-danger btn-xs del-btn" data-toggle="tooltip" data-original-title="刪除抽獎活動"><i class="fa fa-fw ti-trash"></i></button>
    </td>
</tr>