<tr id="tr_<?=$item['id'] ?>">
    <td><?=$item['id'] ?></td>
    <td><?=$item['year']."年".$item['month']."月" ?></td>
    <td><?=number_format($item['total_revenue']) ?></td>
    <td><?=$item['total_revenue_diff_percent'] ?></td>
    <td><?=number_format($item['grand_total_revenue']) ?></td>
    <td><?=$item['grand_total_revenue_diff_percent'] ?></td>
    <td>
        <button onclick="location.href='<?=base_url()."mgr/financial/revenuereport/edit/".$item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>
        
        <button id="del_<?=$item['id'] ?>" class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td>
</tr>