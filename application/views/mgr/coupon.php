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

    <!--end of page level css-->

</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                折扣碼管理
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li class="active">折扣碼管理
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
                                <i class="ti-view-list"></i> 新增折扣碼
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                                <table class="table horizontal_table table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: auto;">折扣碼</th>
                                        <th>使用次數(無限請輸入-1)</th>
                                        <th>截止日期</th>
                                        <th>折扣金額(請輸入整數)</th>
                                        <th style="width:30px;"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <form action="<?=base_url() ?>mgr/coupon/add" method="POST">
                                            <td>
                                                <input type="text" name="code" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="use_limit" class="form-control">
                                            </td>
                                            <td>
                                                <input type="date" name="expire_date" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" name="discount" class="form-control">
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-md btn-danger" id="add_row">新增</button>
                                            </td>
                                        </form>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> 折扣碼管理
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                                <table class="table horizontal_table table-striped" id="showtable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>折扣碼</th>
                                        <th>折扣金額</th>
                                        <th>使用次數</th>
                                        <th>使用期限</th>
                                        <th>建立日期</th>
                                        <th>動作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? for($i=0;$i<count($list);$i++){ $item = $list[$i]; ?>
                                    <tr>
                                        <td><?=$item['id'] ?></td>
                                        <td><?=$item['code'] ?></td>
                                        <td><?=$item['discount'] ?></td>
                                        <td>
                                            <?
                                                echo $item['used']."/";
                                                if ($item['use_limit'] == -1) {
                                                    echo "∞";
                                                }else{
                                                    echo $item['use_limit'];
                                                }
                                            ?>
                                        </td>
                                        <td><?=date("Y-m-d", strtotime($item['expire_date'])) ?></td>
                                        <td><?=$item['create_date'] ?></td>
                                        <td style="width:10%;">
                                            <button onclick="location.href='<?=base_url()."mgr/coupon/delete/".$item['id'] ?>'" class="btn btn-danger btn-xs"><span
                                                        class="fa fa-fw ti-trash"></span></button>
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
<script type="text/javascript" src="vendors/datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="vendors/datatables/js/dataTables.bootstrap.js"></script>
<script src="vendors/mark.js/jquery.mark.js" charset="UTF-8"></script>
<script src="vendors/datatablesmark.js/js/datatables.mark.min.js" charset="UTF-8"></script>

<script>
    $(document).ready(function () {
        window.onload = function () {
            $(function () {
                dtInstance = $("#showtable").DataTable({
                    "lengthMenu": [25, 50, -1],
                    "responsive": true,
                    bLengthChange: true,
                    "pageLength": 25,
                    // "ordering": false,
                    "order": [[0, "desc"]],
                    columnDefs: [
                        { targets: [10], orderable: false},
                    ]
                });
            });
        }
    });    
</script>
</body>

</html>
