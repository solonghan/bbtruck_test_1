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
                沙龍管理
            </h1>
            <button class="pull-right btn btn-md btn-success add_action" style="margin-top: -20px; margin-right: 25px;">新增沙龍</button>
            <button class="pull-right btn btn-md btn-primary export_action" style="margin-top: -20px; margin-right: 15px;">匯出清單</button>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li class="active">沙龍管理
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
                                <i class="ti-view-list"></i> 沙龍管理
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                                <table class="table horizontal_table table-striped" id="showtable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>名稱<br>帳號</th>
                                        <th>聯絡資訊</th>
                                        <th style="width: 78px;">營業時間<br>統計</th>
                                        <th>提供服務</th>
                                        <th>成案次數</th>
                                        <th>使用方案</th>
                                        <th>狀態</th>
                                        <th>註冊日期</th>
                                        <th>動作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? for($i=0;$i<count($list);$i++){ $item = $list[$i]; ?>
                                    <tr>
                                        <td><?=$item['id'] ?></td>
                                        <td><?=$item['name']."<br>".$item['email'] ?></td>
                                        <td><?=$item['principal']."<br>".$item['phone']."<br>".$item['address'] ?></td>
                                        <td>
                                            <?
                                                echo $item['opentime']."年<br>";
                                                echo "設計師 ".$item['designers']." 位<br>";
                                                echo "助　理 ".$item['assistants']." 位<br>";
                                                echo "洗頭台 ".$item['punchtable']." 台";
                                            ?>
                                        </td>
                                        <td>
                                            <?
                                                $service = json_decode($item['service'], true);
                                                $s_str = "";
                                                foreach ($service as $sitem) {
                                                    if ($s_str != "") $s_str .= ", ";
                                                    if ($sitem == 1) {
                                                        $s_str .= "洗";
                                                    }else if ($sitem == 2) {
                                                        $s_str .= "剪";
                                                    }else if ($sitem == 3) {
                                                        $s_str .= "染";
                                                    }else if ($sitem == 4) {
                                                        $s_str .= "燙";
                                                    }else if ($sitem == 5) {
                                                        $s_str .= "護";
                                                    }else{
                                                        $s_str .= $sitem;
                                                    }
                                                }
                                                echo $s_str;
                                            ?>
                                        </td>
                                        <td>已成案 <?=$item['sales'] ?> 次<br>累積共$ <?=($item['sales_money'])?$item['sales_money']:0 ?></td>
                                        <td>
                                            <select class="form-control plan_select" style="width: 160px;" id="plan_<?=$item['id'] ?>">
                                                <option value="0"<?=(($item['plan'] == "0")?" selected":"") ?>>試用版</option>
                                                <?
                                                    foreach ($plan as $pitem) {
                                                ?>
                                                <option value="<?=$pitem['id'] ?>"<?=(($item['plan'] == $pitem['id'])?" selected":"") ?>><?=$pitem['title'] ?></option>
                                                <?
                                                    }
                                                ?>
                                            </select>
                                            <input class="timepick form-control" data-timepicker="true" value="<?=$item['deadline'] ?>" style="width:160px" id="deadline_<?=$item['id'] ?>" />
                                        </td>
                                        <td style="width: 50px;" id="status_<?=$item['id'] ?>">
                                            <?
                                                if ($item['status'] == "open") {
                                                    echo '<span class="text text-success">開啟</span>';
                                                }else if ($item['status'] == "close") {
                                                    echo '<span class="text text-warning">關閉</span>';
                                                }else if ($item['status'] == "not_verify") {
                                                    echo '<span class="text text-muted">尚未驗證</span>';
                                                }else if ($item['status'] == "delete") {
                                                    echo '<span class="text text-danger">已刪除</span>';
                                                }
                                            ?>
                                        </td>
                                        <td><?=$item['register_date'] ?></td>
                                        <td style="width:10%;" id="action_<?=$item['id'] ?>">
                                            <!-- <button onclick="location.href='<?=base_url()."mgr/user/detail/".$item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button> -->
                                            <?
                                                if ($item['is_recommend'] == 1) {
                                            ?>
                                            <a href="<?=base_url() ?>mgr/salon/recommend/<?=$item['id'] ?>/off" class="btn btn-default btn-xs">取消推薦</a>
                                            <?
                                                }else{
                                            ?>
                                            <a href="<?=base_url() ?>mgr/salon/recommend/<?=$item['id'] ?>/on" class="btn btn-success btn-xs">設為推薦</a>
                                            <? 
                                                } 
                                            ?>
                                            <br>
                                            <?
                                                if ($item['status'] == "close") {
                                            ?>
                                            <button class="btn btn-success btn-xs btn-status" id="status_action_<?=$item['id'] ?>">開啟</button>
                                            <?
                                                }else{
                                            ?>
                                            <button class="btn btn-danger btn-xs btn-status" id="status_action_<?=$item['id'] ?>">關閉</button>
                                            <? 
                                                } 
                                            ?>
                                            <button id="del_<?=$item['id'] ?>" class="btn btn-danger btn-xs btn-del">刪除</button>
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

<script src="vendors/moment/js/moment.min.js" type="text/javascript"></script>
<script src="vendors/moment/js/moment-timezone.js" type="text/javascript"></script>
<script src="vendors/moment/js/moment-timezone-with-data.js" type="text/javascript"></script>
<script src="vendors/moment/js/moment-timezone-with-data-2012-2022.js" type="text/javascript"></script>
<script src="vendors/datetime/js/jquery.datetimepicker.full.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.en.js" type="text/javascript"></script>


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
    $(document).ready(function () {
        window.onload = function () {
            $(function () {
                var inputMapper = {
                    "name": 1,
                    "contact": 2,
                    "opentime": 3,
                    "service": 4,
                    "plan": 5
                };

                dtInstance = $("#showtable").DataTable({
                    "lengthMenu": [25, 50, 100],
                    "responsive": true,
                    // bLengthChange: true,
                    "pageLength": 25,
                    bLengthChange: false,
                    info: false,
                    mark: true,
                    "order": [[0, "desc"]],
                    columnDefs: [
                        { targets: [9], orderable: false},
                    ]
                });

                $("input").on("input", function () {
                    var $this = $(this);
                    var val = $this.val();
                    var key = $this.attr("name");
                    dtInstance.columns(inputMapper[key] - 1).search(val).draw();
                });
            });
        }


        $('.timepick').datepicker({
            language: {
                days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                daysMin: ['日', '一', '二', '三', '四', '五', '六'],
                months: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
                monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                today: 'Today',
                clear: 'Clear',
                dateFormat: 'yyyy-mm-dd',
                timeFormat: 'hh:ii:59',
                firstDay: 0
            },
            onHide: function(dp, animationCompleted){
                if (animationCompleted) {
                    var id = dp.$el.attr("id").split("_");
                    if (dp.selectedDates.length <= 0) return;

                    $.ajax({
                        url: "<?= base_url() ?>mgr/salon/deadline",
                        data: {
                            id: id[1],
                            deadline: moment(new Date(dp.selectedDates)).tz("Asia/Taipei").format('YYYY-MM-DD HH:mm:59')
                        },
                        type: "POST",
                        dataType: "json",
                        success: function(msg){
                            if (msg.status == 100) {
                                
                            }
                        },
                        error:function(xhr, ajaxOptions, thrownError){ 
                            alert(xhr.status); 
                            alert(thrownError); 
                        },
                        complete:function(){
                            
                        }
                    });
                }
            }
        });

        $(".add_action").on('click', function(event) {
            location.href = "<?=base_url() ?>mgr/salon/add"; 
        });

        $(".export_action").on('click', function(event) {
            window.open("<?=base_url()."mgr/salon/export" ?>");
        });

        $(".btn-status").on('click', function(event) {
            var id = $(this).attr("id").split("_");
            var status = "open";
            if ($(this).hasClass('btn-danger')) {
                status = "close";
            }

            $.ajax({
                url: "<?= base_url() ?>mgr/salon/status/"+status,
                data: {
                    id: id[2]
                },
                type: "POST",
                dataType: "json",
                success: function(msg){
                    if (msg.status == 100) {
                        if (status == "close") {
                            $("#status_action_"+id[2]).html("開啟");
                            $("#status_action_"+id[2]).removeClass('btn-danger');
                            $("#status_action_"+id[2]).addClass('btn-success');
                            $("#status_"+id[2]).html('<span class="text text-warning">關閉</span>');
                        }else{
                            $("#status_action_"+id[2]).html("關閉");
                            $("#status_action_"+id[2]).addClass('btn-danger');
                            $("#status_action_"+id[2]).removeClass('btn-success');
                            $("#status_"+id[2]).html('<span class="text text-success">開啟</span>');
                        }
                    }
                },
                error:function(xhr, ajaxOptions, thrownError){ 
                    alert(xhr.status); 
                    alert(thrownError); 
                },
                complete:function(){
                    
                }
            });
        });

        $(".plan_select").on('change', function(event) {
           var id = $(this).attr("id").split("_");
           $.ajax({
                url: "<?= base_url() ?>mgr/salon/changeplan",
                data: {
                    id: id[1],
                    plan: $(this).val()
                },
                type: "POST",
                dataType: "json",
                success: function(msg){
                    if (msg.status == 100) {
                        
                    }
                },
                error:function(xhr, ajaxOptions, thrownError){ 
                    alert(xhr.status); 
                    alert(thrownError); 
                },
                complete:function(){
                    
                }
            });
        });

        $(".btn-del").on('click', function(event) {
            if (!confirm("確定刪除此沙龍? 此動作無法回復")) return;
            var id = $(this).attr("id").split("_");

            location.href='<?=base_url()."mgr/salon/del/" ?>'+id[1];
        });
    });    
</script>
</body>

</html>
