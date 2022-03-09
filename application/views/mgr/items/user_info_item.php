<tr data-id="<?=$item['id'] ?>">
    <td><?=$item['id'] ?></td>
    <td>@ID : <?=$item['atid'] ?><br><span>等　級 : <?=$item['level'] ?></span><br><span>經驗值 : <?=$item['exp'] ?></span></td>
    <td>
        <?=$item['nickname'] ?><?php if ($item['vip'] == 1): ?><span> / <span style="color: #CE0000;">VIP</span></span><?php endif; ?>
        <?php foreach ($item['login_type'] as $key => $value): ?>
            <?php if ($key == 'G'): ?>
                <br><div class="label label-danger" style="line-height:25px;"><?=$value?></div>
            <?php elseif ($key == 'L'): ?>
                <br><div class="label label-success" style="line-height:25px;"><?=$value?></div>
            <?php elseif ($key == 'F'): ?>
                <br><div class="label label-primary" style="line-height:25px;"><?=$value?></div>
            <?php endif; ?>
        <?php endforeach; ?>
    </td>
    <td><?=$item['email'] ?><br><?=$item['mobile'] ?></td>
    <td><span>部落幣 : <?=$item['coin'] ?></span><br><span>貝殼幣 : <?=$item['shell'] ?></span><br><span>大獵卷 : <?=$item['bticket'] ?></span><br><span>小米卷 : <?=$item['sticket'] ?></span></td>
    <td><span>人　&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;氣 : <?=$item['popularity'] ?></span><br><span>活 &nbsp;&nbsp;躍 &nbsp;&nbsp;&nbsp;度 : <?=$item['activity'] ?></span><br><span>追 蹤 人 數 : 0</span><br><span>被追蹤人數 : 0</span></td>
    <td>
        <?php if (isset($item['medal_name']) AND ( ! empty($item['medal_name']))): ?>
            <?php foreach ($item['medal_name'] as $key => $value): ?>
                <?php if ($key == 2): ?><br><?php endif; ?>
                <img src="<?=base_url().$value['medal_name']?>" style="width: 30px;height: 30px;display: inline;">
            <?php endforeach; ?>
        <?php endif; ?>
    </td>
    <td><?=$item['tribe']?></td>
    <td>
        <?php if (isset($item['local_club_name']) AND ( ! empty($item['local_club_name']))): ?>
            <?php foreach ($item['local_club_name'] as $value): ?>
                <span><?=$value['local_club_name']?></span><br>
            <?php endforeach; ?>
        <?php endif; ?>
    </td>
    <td>
        <button class="btn btn-info btn-xs" onclick="location.href='<?=base_url().'mgr/User/posts/'.$item['id']?>';" data-toggle="tooltip" data-original-title="查看獵人日記"><i class="fa fa-fw fa-info-circle"></i></button>

        <button class="btn btn-warning btn-xs" onclick="location.href='<?=base_url().'mgr/User/friends/'.$item['id']?>';" data-toggle="tooltip" data-original-title="好友清單"><i class="fa fa-fw ti-user"></i></button>

        <button class="btn btn-info btn-xs" onclick="location.href='<?=base_url().'mgr/User/h_club/'.$item['id']?>';" data-toggle="tooltip" data-original-title="查看同好獵場"><i class="fa fa-fw ti-menu-alt"></i></button>

        <button class="btn btn-primary btn-xs pull-right" onclick="location.href='<?=base_url() ?>';" data-toggle="tooltip" data-original-title="編輯資訊"><span class="fa fa-fw ti-pencil"></span></button><span class="pull-right">&nbsp;&nbsp;&nbsp;</span><br>

        <button class="btn btn-warning btn-xs" onclick="location.href='<?=base_url() ?>';" data-toggle="tooltip" data-original-title="交易紀錄"><i class="fa fa-fw ti-credit-card"></i></button>
        
        <button class="btn btn-danger btn-xs" onclick="location.href='<?=base_url() ?>';" data-toggle="tooltip" data-original-title="刊登的廣告"><i class="fa fa-fw ti-volume"></i></button>

        <button class="btn btn-warning btn-xs" onclick="location.href='<?=base_url() ?>';" data-toggle="tooltip" data-original-title="收藏盒"><i class="fa fa-fw ti-harddrives"></i></button>

        <button class="btn btn-danger btn-xs del-btn pull-right" data-toggle="tooltip" data-original-title="刪除"><span class="fa fa-fw fa-minus-square-o"></span></button>
        <span class="pull-right">&nbsp;&nbsp;&nbsp;</span>
        
    </td>
</tr>