<tr data-id="<?=$item['id'] ?>">
    <td><?=$item['id'] ?></td>
    <td><?=$item['email'] ?></td>
    
    <td><?=$item['create_date'] ?></td>
    
   <!-- <td>
         <span class="label label-primary">FD</span>
        <span class="label label-primary">BY</span>
        <span class="label label-primary">ID</span> 
    </td>-->
    <!-- <td>
        <input type="checkbox" class="status_switcher" data-size="mini" data-on-color="success" data-off-color="danger"<?=($item['status']=="open")?' checked':'' ?>>
</td>       -->
   <td>
        <!-- <button class="btn btn-info btn-xs" onclick="location.href='<?=base_url() ?>mgr/member/detail';" data-toggle="tooltip" data-original-title="查看擁有權限"><i class="fa fa-fw fa-info-circle"></i></button> -->
        <button class="btn btn-primary btn-xs " onclick="location.href='<?=base_url() ?>mgr/member/edit_temp/<?=$item['id']?>'" data-toggle="tooltip" data-original-title="編輯資訊"><span class="fa fa-fw ti-pencil"></span></button>
        
        <button class="btn btn-danger btn-xs del-btn" data-toggle="tooltip" data-original-title="刪除"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td>
</tr>