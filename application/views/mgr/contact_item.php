<tr id="tr_<?=$item['id'] ?>">
    <td><?=$item['id'] ?></td>
    <td><?=$item['username'] ?></td>
    <td><?=$item['email'] ?></td>
    <td><?=$item['nation'] ?></td>
    <td><?=$item['department'] ?></td>
    <td><?=$item['product'] ?></td>
    <td><?=$item['title'] ?></td>
    <td><?=$item['content'] ?></td>
    <td><?=$item['remarks'] ?></td>
    <td>
        <?
            if ($item['status'] == "new") {
                echo '<span class="label label-danger">最新</span>';
            }else if ($item['status'] == "proccessed") {
                echo '<span class="text text-muted">已處理</span>';
            }
        ?>
    </td>
    <td><?=$item['create_date'] ?></td>
    <td>
        <button onclick="location.href='<?=base_url()."mgr/about/contact/edit/".$item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>
        
        <button id="del_<?=$item['id'] ?>" class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td>
</tr>