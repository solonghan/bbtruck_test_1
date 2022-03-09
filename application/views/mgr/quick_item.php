<tr id="tr_<?=$item['id'] ?>">
    <td><?=$item['id'] ?></td>
    <td>
        <?
            if ($item['cover'] != "") {
                echo '<a data-fancybox="cover_'.$item['id'].'" href="'.base_url().$item['cover'].'"><img src="'.base_url().$item['cover'].'" style="width:300px;"></a>';
            }
        ?>
    </td>
    <td>
        <?
            if ($item['cover_mobile'] != "") {
                echo '<a data-fancybox="cover_'.$item['id'].'" href="'.base_url().$item['cover_mobile'].'"><img src="'.base_url().$item['cover_mobile'].'" style="width:150px;"></a>';
            }
        ?>
    </td>
    <td><?=$item['title_tw']."<br><small>".$item['title_en']."</small>" ?></td>
    <td>
        <?
            if (strpos($item['des_tw'], "<img") !== FALSE) {
                echo "<span class='label label-info'>(圖片)</span>";
            }
            if (mb_strlen(strip_tags($item['des_tw'])) > 100) {
                echo mb_substr(strip_tags($item['des_tw']), 0, 100)."...";
            }else{
                echo strip_tags($item['des_tw']);
            }
        ?>
    </td>
    <td>
        <? if ($item['url'] != ""): ?>
        <a href="<?=(strpos($item['url'], "http") !== FALSE)?$item['url']:base_url().$item['url'] ?>" target="_blank">連結</a>
        <? else: ?>
        無連結
        <? endif; ?>
    </td>
    <td><?=$item['create_date'] ?></td>
    <td>
        <button onclick="location.href='<?=base_url()."mgr/home/quick/edit/".$item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>
    </td>
</tr>