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


    <link rel="stylesheet" href="vendors/datetime/css/jquery.datetimepicker.css">
    <link href="vendors/airdatepicker/css/datepicker.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/datepicker.css">


</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                交易紀錄
            </h1>
            <!-- <button class="pull-right btn btn-md btn-primary export_action" style="margin-top: -20px; margin-right: 25px;">匯出清單</button> -->
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li class="active">交易紀錄
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
                                <i class="ti-view-list"></i> 交易紀錄
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                                <table class="table horizontal_table table-striped" id="showtable">
                                    <thead>
                                    <tr>
                                        <th>訂單編號</th>
                                        <th>沙龍名稱</th>
                                        <th>金額</th>
                                        <th>方案名稱</th>
                                        <th>狀態</th>
                                        <th>建立日期</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? 
                                        for($i=0;$i<count($plan);$i++){ 
                                            $item = $plan[$i];
                                            
                                            $transaction = array($item);

                                            $tmp_i = $i + 1;
                                            while ($tmp_i < count($plan) && $plan[$tmp_i]['trade_no'] == $item['trade_no']) {
                                                array_push($transaction, $plan[$tmp_i]);
                                                $i ++;
                                                $tmp_i++;
                                            }

                                    ?>
                                    <tr>
                                        <td rowspan="2" style="text-align: center; vertical-align: middle;"><?=$item['trade_no'] ?></td>
                                        <td>
                                            <? 
                                                echo "<span class='send_mail' data-email='".$item['salon_email']."'>".$item['salon_name']."</span>";
                                            ?>
                                        </td>
                                        <td><?=$item['price'] ?></td>
                                        <td><?=$item['plan_title'] ?></td>
                                        <td>
                                            <?
                                                if ($item['status'] == "pending") {
                                                    echo "<span class='text text-muted'>尚未付款</span>";
                                                }else if ($item['status'] == "success") {
                                                    echo "<span class='text text-success'>已付款</span>";
                                                }else{
                                                    echo "狀態不明";
                                                }
                                            ?>
                                        </td>
                                        <td><?=$item['create_date'] ?></td>
                                        <td style="width:10%;" id="action_<?=$item['id'] ?>">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <?
                                                echo "綠界交易紀錄：<br>";
                                                if (count($transaction) <= 0) {
                                                    echo '<span class="text text-muted">無</span>';
                                                }
                                                foreach ($transaction as $obj) {
                                                    if ($obj['RtnCode'] == "1") {
                                                        echo '<span class="label label-success">交易成功</span> ';

                                                        echo "$".$obj['TradeAmt']." ".$obj['PaymentDate']."<Br>";
                                                    }else if ($obj['RtnCode'] == "0") {
                                                        echo '<span class="label label-warning">'.$obj['RtnMsg'].'</span> ';
                                                    }else{
                                                        echo '<span class="label label-default">狀態不明</span> ';
                                                    }
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

<script>
    $(document).ready(function () {
        window.onload = function () {
            $(function () {
                // dtInstance = $("#showtable").DataTable({
                //     "lengthMenu": [25, 50, 100],
                //     "responsive": true,
                //     // bLengthChange: true,
                //     "pageLength": 25,
                //     bLengthChange: false,
                //     info: false,
                //     mark: true,
                //     "order": [[5, "desc"]],
                //     columnDefs: [
                //         { targets: [5], orderable: false},
                //     ]
                // });
            });
        }

        $(".send_mail").on('click', function(event) {
            var email = $(this).attr("data-email");
            
            $("#mailModal").modal("show");
            $("#mailModal .modal-body .email").val(email);
        });
    });    
</script>
<? include("send_mail.php"); ?>
</body>

</html>
