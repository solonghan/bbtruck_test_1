<tr data-id="<?=$item['id'] ?>">
    <td><?=$item['id'] ?></td>
    <td><a target="_blank" href="https://web.wundoo.com.tw/article/<?=$item['id'] ?>">https://web.wundoo.com.tw/article/<?=$item['id'] ?></a></td>
    <td><?=$item['user']['nickname'] ?></td>
    <td><?=$item['classify_str'] ?></td>
    <td><?=$item['post_at'] ?></td>
    <td><?=$item['title'] ?></td>
    <td><?=$item['status'] ?></td>
    <td><span>溫度數 : <?=$item['temperature'] ?></span><br><span>留言數 : <?=$item['comment_cnt'] ?></span><br><span>分享數 : <?=$item['share_cnt'] ?></span></td>
    <td><?=$item['create_date'] ?></td>
    <td><?=$item['update_date'] ?></td>
</tr>