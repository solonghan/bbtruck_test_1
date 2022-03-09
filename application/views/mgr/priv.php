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
                權限管理
            </h1>
            <button class="pull-right btn btn-md btn-primary" style="margin-top: -20px; margin-right: 25px;" onclick="location.href='<?=base_url() ?>mgr/priv/add';">新增人員</button>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li class="active">權限管理
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
                                <i class="ti-view-list"></i> 權限管理
                            </h3>
                            <!-- <div class="pull-right">
                                <button onclick="location.href='<?=base_url() ?>mgr/priv/add/'" class="btn btn-info btn-sm" type="button">新增管理帳號</button>
                            </div> -->
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                                <table class="table horizontal_table table-striped" id="showtable">
                                    <thead>
                                    <tr>
                                        <th>姓名</th>
                                        <th>類型</th>
                                        <th>帳號</th>
                                        <th>狀態</th>
                                        <th>最後操作</th>
                                        <th>建立日期</th>
                                        <th style="width:10%;">動作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? for($i=0;$i<count($list);$i++){ $item = $list[$i]; ?>
                                    <tr>
                                        <td><?=$item['name'] ?></td>
                                        <td>
                                            <?
                                                if ($item['privilege'] == "super") {
                                                    echo "最高權限";
                                                }else if ($item['privilege'] == "mgr") {
                                                    echo "行政人員";
                                                }
                                            ?>
                                        </td>
                                        <td><?=$item['account'] ?></td>
                                        <td>
                                            <?
                                                if ($item['privilege'] != "super") {
                                                    if ($item['status'] == "normal") {
                                                        echo '<span class="label label-success">正常</span>';
                                                    }else if($item['status'] == "block"){
                                                        echo '<span class="label label-danger">關閉</span>';
                                                    }
                                                }
                                            ?>  
                                        </td>
                                        <td>
                                            <?
                                                echo $item['last_action']."<br><span class='text text-primary'>".$item['last_action_datetime']."</span>";
                                            ?>
                                        </td>
                                        
                                        <td><?=$item['create_date'] ?></td>
                                        <td>
                                            <?
                                                if ($item['privilege'] == "super") {
                                                    
                                                }else{
                                            ?>
                                            <button onclick="location.href='<?=base_url()."mgr/priv/detail/".$item['id'] ?>'" class="btn btn-primary btn-xs"><span
                                                        class="fa fa-fw ti-pencil"></span></button>
                                            
                                            <button id="del_<?=$item['id'] ?>" class="btn btn-danger btn-xs btn-del"><span class="fa fa-fw fa-minus-square-o"></span></button>
                                            <?
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
<script type="text/javascript" src="vendors/datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="vendors/datatables/js/dataTables.bootstrap.js"></script>
<script src="vendors/mark.js/jquery.mark.js" charset="UTF-8"></script>
<script src="vendors/datatablesmark.js/js/datatables.mark.min.js" charset="UTF-8"></script>
<script src="js/custom_js/responsive_datatables.js" type="text/javascript"></script>


<script src="vendors/moment/js/moment.min.js" type="text/javascript"></script>
<script src="vendors/colorpicker/js/bootstrap-colorpicker.min.js" type="text/javascript"></script>
<script src="vendors/clockpicker/js/bootstrap-clockpicker.min.js" type="text/javascript"></script>
<script src="vendors/datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

<script src="vendors/bootstrap-multiselect/js/bootstrap-multiselect.js" type="text/javascript"></script>
<script src="vendors/clockface/js/clockface.js" type="text/javascript"></script>
<script src="vendors/bootstrap-touchspin/js/jquery.bootstrap-touchspin.js" type="text/javascript"></script>
<script src="vendors/bootstrap-switch/js/bootstrap-switch.js" type="text/javascript"></script>
<script src="vendors/toolbar/js/jquery.toolbar.min.js"></script>
<script src="js/custom_js/pickers.js" type="text/javascript"></script>

<script src="vendors/bootstrap-multiselect/js/bootstrap-multiselect.js" type="text/javascript"></script>
<script src="vendors/select2/js/select2.js" type="text/javascript"></script>


<script>
    $(document).ready(function () {
        window.onload = function () {
            $(function () {
                dtInstance = $("#showtable").DataTable({
                    "lengthMenu": [25, 50, -1],
                    "responsive": true,
                    bLengthChange: true,
                    "pageLength": 25,
                    "ordering": true,
                    "order": [[2, "desc"]]
                });
            });
        }

        $(".btn-del").on('click', function(event) {
            var id = $(this).attr("id").split("_");
            if (confirm("確定刪除此人員嗎?")) {
                location.href = '<?=base_url() ?>mgr/priv/del/'+id[1];
            }
        });
    });    
</script>
</body>

</html>
