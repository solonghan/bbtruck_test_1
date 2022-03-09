<!DOCTYPE html>
<html>

<head>
    <? include("header.php"); ?>

    <link href="vendors/clockface/css/clockface.css" rel="stylesheet" type="text/css"/>
    <link href="vendors/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css"/>
    <link href="vendors/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
    <link href="vendors/bootstrap-touchspin/css/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css"/>
    <link href="vendors/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css"/>
    <link href="vendors/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet" type="text/css"/>
    <link href="vendors/bootstrap-switch/css/bootstrap-switch.css" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" type="text/css" href="css/pickers.css">

    <link rel="stylesheet" type="text/css" href="vendors/datatables/css/dataTables.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="vendors/datatablesmark.js/css/datatables.mark.min.css"/>


    <link href="vendors/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="vendors/select2/css/select2-bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.css" />
    
    <link href="vendors/toastr/css/toastr.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="css/custom_css/toastr_notificatons.css">

    <style>
        .statusbar mark{
            background: none;
            color: inherit !important;
        }
    </style>
</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                訂單管理
            </h1>
            <div class="pull-right" style="display: inline; margin-top: -20px; margin-right: 25px;">
                <!-- <select class="form-control" style="width: 100px; display: inline; margin-right: 10px; height: 40px;" id="export_year">
                    <?
                        $start_year = 2018;
                        $start_month = 9;
                        $now_year = date('Y');
                        $now_month = date('m');

                        for ($i=$start_year; $i <=$now_year ; $i++) { 
                            $start = $start_month;
                            $end = $now_month;
                            if ($start_year != $now_year) {
                                if ($i == $start_year) {
                                    $end = 12;
                                }else if ($i == $now_year) {
                                    $start = 1;
                                }else{
                                    $start = 1;
                                    $end = 12;
                                }
                            }

                            for ($j=$start; $j <= $end; $j++) { 
                                echo '<option value="'.$i.'-'.str_pad($j, 2, "0", STR_PAD_LEFT).'"';
                                echo '>'.$i.'年'.str_pad($j, 2, "0", STR_PAD_LEFT).'月</option>';   
                            }   
                            
                        }
                    ?>
                </select>
                <button class=" btn btn-md btn-primary export_action" style="height: 38px; margin-bottom: 4px;">匯出報表</button> -->
            </div>
            
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li class="active">訂單管理
                </li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> 訂單管理
                            </h3>
                        </div>
                        <div class="panel-body">
                            <?
                                $status = ["全部", "等待出貨中", "等待付款中", "已付款,等待出貨中","商品運送中", "完成", "取消", "訂單異常"];
                                $index = 1;
                                foreach ($status as $s) {
                            ?>
                            <input type="button" class="btn btn-xs btn-default <?=($index==1)?'btn-primary':'' ?> btn-status" value="<?=$s ?>" style="width: 110px;"> 
                            <?
                                    $index++;
                                }
                            ?>
                            <div class="m-t-10">
                                <!-- <input type="button" class="btn btn-sm btn-primary btn-export" value="匯出Excel" style="position: absolute;"> -->
                                <table class="table horizontal_table table-striped" id="showtable">
                                    <thead>
                                    <tr>
                                        <!-- <th>#</th> -->
                                        <th>訂單編號</th>
                                        <th>訂購人</th>
                                        <th>收件人資訊</th>
                                        <th style="text-align: center;">備註</th>
                                        <th>商品</th>
                                        <th>金額</th>
                                        <th>付款方式<br>物流方式</th>
                                        <th>狀態</th>
                                        <th style="width: 70px;">下訂日期</th>
                                        <th>動作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? for($i=0;$i<count($list);$i++){ $item = $list[$i]; ?>
                                    <tr>
                                        <!-- <td><?=$item['id'] ?></td> -->
                                        <td><?=$item['order_no'] ?></td>
                                        <td><?=$item['username']."<br>會員編號: ".$item['u_id'] ?></td>
                                        <td>
                                            <?
                                                echo $item['recipient_name']."<br>";
                                                echo $item['phone']."<br>";
                                                echo $item['email']."<br>";
                                                echo $item['city']."<br>";
                                                echo "<strong>".$item['recipient_address']."</strong>";
                                                
                                            ?>
                                        </td>
                                        <td style="text-align: center;"><?
                                            echo '<a href="javascript:void(0)" data-toggle="tooltip" data-original-title="'.$item['remarks'].'"> <span class="ti-info-alt"></span></a>';
                                            ?>
                                        </td>
                                        <td>
                                            <?
                                                $products = unserialize($item['products']);
                                                $txt = "";
                                                foreach ($products as $product) {
                                                    if ($txt != "") $txt .= "<br>";

                                                    $photo = $product['photo'];
                                                    $picpath = explode(".", $product['photo']);
                                                    if (file_exists(str_replace(base_url(), "", $picpath[0]."_m.".$picpath[1]))) {
                                                        $photo = $picpath[0]."_m.".$picpath[1];
                                                    }
                                                    $txt .= '<a data-fancybox="gallery'.$item['id']."_".$product['id'].'" href="'.$product['photo'].'"><img src="'.base_url().$photo.'" class="img_thumbnail" style="width:36px;"></a> '.$product['name']." × ".$product['quantity'];
                                                }
                                                echo $txt;
                                            ?>
                                        </td>
                                        <td><?=$item['amount']."<br>(運費: ".$item['fee'].")" ?></td>
                                        <td>
                                            <?
                                                if ($item['payment'] == 1) {
                                                    echo "信用卡刷卡";
                                                }else if ($item['payment'] == 2) {
                                                    echo "ATM轉帳";
                                                }else if ($item['payment'] == 3) {
                                                    echo "超商取貨付款";
                                                }
                                                echo "<br>";
                                                if ($item['delivery'] == 1) {
                                                    echo "宅配";
                                                }else if ($item['delivery'] == 2) {
                                                    echo "711交貨便";
                                                }else if ($item['delivery'] == 3) {
                                                    echo "全家店到店";
                                                }
                                            ?>
                                        </td>
                                        <td style="width: 50px;" id="status_<?=$item['id'] ?>" class="statusbar">
                                            <?
                                                if ($item['status'] == "pending" && $item['payment'] == 3) {
                                                    echo "<span class='text text-warning'>等待出貨中</span>";
                                                }else if ($item['status'] == "wait") {
                                                    echo "<span class='text text-default'>等待付款中</span>";
                                                }else if ($item['status'] == "paid") {
                                                    echo "<span class='text text-warning'>已付款,等待出貨中</span>";
                                                }else if ($item['status'] == "shipping") {
                                                    echo "<span class='text text-info'>商品運送中</span>";
                                                }else if ($item['status'] == "success") {
                                                    echo '<span class="text text-success">完成</span>';
                                                }else if ($item['status'] == "cancel") {
                                                    echo '<span class="text text-muted">取消</span>';
                                                }else{
                                                    echo '<span class="text text-danger">訂單異常</span>';
                                                }
                                            ?>
                                        </td>
                                        <td><?=$item['create_date'] ?></td>
                                        <td style="width:60px;" id="action_<?=$item['id'] ?>">
                                            <button onclick="location.href='<?=base_url()."mgr/bill/detail/".$item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>
                                            
                                            <button class="btn btn-danger btn-xs btn-del" id="del_<?=$item['id'] ?>">
                                                <span class="fa fa-fw fa-trash"></span>
                                            </button>
                                            <?
                                                if ($item['status'] == "pending" && $item['payment'] == 3) {
                                                    echo '<button class="btn btn-warning btn-xs btn-shipping" id="shipping_'.$item['id'].'">出貨</button>';
                                                }else if ($item['status'] == "wait") {
                                                    
                                                }else if ($item['status'] == "paid") {
                                                    echo '<button class="btn btn-warning btn-xs btn-shipping" id="shipping_'.$item['id'].'">出貨</button>';
                                                }else if ($item['status'] == "shipping") {
                                                    echo '<button class="btn btn-info btn-xs btn-success" id="success_'.$item['id'].'">訂單完成</button>';
                                                }else if ($item['status'] == "success") {
                                                    
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <? } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="background-overlay"></div>
        </section>
        <!-- /.content -->
    </aside>
</div>

<!-- global js -->
<script src="js/app.js" type="text/javascript"></script>
<!-- end of global js -->
<!-- begining of page level js -->

<script src="vendors/datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="vendors/datatables/js/dataTables.bootstrap.js"></script>
<script src="vendors/mark.js/jquery.mark.js" charset="UTF-8"></script>
<script src="vendors/datatablesmark.js/js/datatables.mark.min.js" charset="UTF-8"></script>
<script src="vendors/mark.js/jquery.mark.js" charset="UTF-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.js"></script>

<script src="vendors/toastr/js/toastr.min.js"></script>

<script>
    toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": false,
          "progressBar": false,
          "positionClass": "toast-bottom-full-width",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "1000",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "swing",
          "showMethod": "show"
        };
    var dtInstance;
    $(document).ready(function () {
        window.onload = function () {
            $(function () {
                dtInstance = $("#showtable").DataTable({
                    "lengthMenu": [25, 50, 100],
                    "responsive": true,
                    "pageLength": 25,
                    bLengthChange: true,
                    info: true,
                    mark: true,
                    "order": [[8, "desc"]],
                    columnDefs: [
                        { targets: [1,2,3,4,6,9], orderable: false},
                    ]
                });

                $("input[type=search]").on("input", function () {
                    dtInstance.search(val).draw();
                });
            });
        }

        $(".btn-status").on('click', function(event) {
            $(document).find('.btn-status').each(function(index, el) {
                $(this).removeClass("btn-primary");
            });
            $(this).addClass("btn-primary");
            var value = $(this).val();
            if (value == "全部") 
                dtInstance.columns(7).search("").draw();
            else
                dtInstance.columns(7).search(value).draw();
        });

        $(document).on('click', '.btn-shipping', function(event) {
            var btn = $(this);
            var id = btn.attr("id").split("_")[1];
            $.ajax({
                url: "<?=base_url() ?>mgr/bill/change_status",
                data: {
                    id: id,
                    status: "shipping"
                },
                type:"POST",
                dataType:'json',
                success: function(data){
                    if (data.status == 100) {
                        $("#status_"+id).html("<span class='text text-info'>商品運送中</span>");
                        btn.remove();
                        $("#action_"+id).append('<button class="btn btn-info btn-xs btn-success" id="success_'+id+'">訂單完成</button>');
                    }
                },
                error:function(xhr, ajaxOptions, thrownError){ 
                }
            }); 
        });

        $(document).on('click', '.btn-success', function(event) {
            var btn = $(this);
            var id = btn.attr("id").split("_")[1];
            $.ajax({
                url: "<?=base_url() ?>mgr/bill/change_status",
                data: {
                    id: id,
                    status: "success"
                },
                type:"POST",
                dataType:'json',
                success: function(data){
                    if (data.status == 100) {
                        $("#status_"+id).html('<span class="text text-success">完成</span>');
                        btn.remove();
                    }
                },
                error:function(xhr, ajaxOptions, thrownError){ 
                }
            }); 
        });

        $(".btn-del").on('click', function(event) {
            if (!confirm("確定刪除此訂單嗎?")) return;
            var id = $(this).attr("id").split("_");
            location.href='<?=base_url()."mgr/bill/del/" ?>'+id[1]; 
        });

        $(".export_action").on('click', function(event) {
            window.open('<?=base_url()."mgr/bill/export/" ?>'+$("#export_year").val()); 
        });
    });    
</script>
</body>

</html>
