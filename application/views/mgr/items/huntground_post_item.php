<tr data-id="<?= $item['id'] ?>">
    <td><?= $item['id'] ?></td>
    <td><a target="_blank" href="https://web.wundoo.com.tw/article/<?= $item['id'] ?>">https://web.wundoo.com.tw/article/<?= $item['id'] ?></a></td>
    <td><?= $club['name'] ?></td>
    <td><?= $item['nickname'] ?></td>
    <td>
        <? if (empty($item['PC_title']) && empty($item['PD_title']))
            echo '未分類';
        elseif (!empty($item['PC_title']))
            echo $item['PC_title'];
        elseif (!empty($item['PD_title']))
            echo $item['PD_title'];
        ?>
    </td>
    <td><?= $item['title'] ?></td>
    <td><?= $item['status'] ?></td>
    <td><span>溫度數 : <?= $item['temperature'] ?></span><br><span>留言數 : <?= $item['comment_cnt'] ?></span><br><span>分享數 : <?= $item['share_cnt'] ?></span></td>
    <td><?= $item['create_date'] ?></td>
    <td><?= $item['update_date'] ?></td>
</tr>