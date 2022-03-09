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


</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                會員管理
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li class="active">會員管理
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
                                <i class="ti-view-list"></i> 會員管理
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                                <!-- <input type="button" class="btn btn-sm btn-primary btn-export" value="匯出Excel" style="position: absolute;"> -->
                                <table class="table horizontal_table table-striped" id="showtable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>姓名</th>
                                        <th>Email/手機</th>
                                        <th>點數</th>
                                        <th>拆帳比</th>
                                        <th>回饋金</th>
                                        <th>狀態</th>
                                        <th>註冊日期</th>
                                        <th>動作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? for($i=0;$i<count($list);$i++){ $item = $list[$i]; ?>
                                    <tr>
                                        <td><?=$item['id'] ?></td>
                                        <td style="width: 90px;">
                                            <span id="username_<?=$item['id'] ?>"><?=$item['username'] ?></span><br><button class="btn btn-default btn-sm" onclick="copyStringToClipboard('<?=base_url()."invite/".$item['id'] ?>');">複製推薦連結</button>
                                        </td>
                                        <td><?=$item['email']."<Br>".$item['phone'] ?></td>
                                        <td>
                                            <span id="coin_<?=$item['id'] ?>"><?=$item['coin'] ?></span>
                                            <span class="fa fa-cog coin-setting" id="setting_<?=$item['id'] ?>" style="cursor: pointer;"></span>
                                        </td>
                                        <td>
                                            <input type="text" id="ratio_<?=$item['id'] ?>" class="form-control ratio" value="<?=$item['ratio'] ?>" style="width: 55px; text-align: center;">
                                        </td>
                                        <td>
                                            <span id="reward_<?=$item['id'] ?>"><?=$item['reward'] ?></span>
                                            <span class="fa fa-cog reward-setting" id="reward_<?=$item['id'] ?>" style="cursor: pointer;"></span>
                                        </td>
                                        <td style="width: 50px;" id="status_<?=$item['id'] ?>">
                                            <?
                                                if ($item['status'] == "normal") {
                                                    echo '<span class="text text-success">正常</span>';
                                                }else if ($item['status'] == "not_verify") {
                                                    echo '<span class="text text-muted">尚未驗證</span>';
                                                }else if ($item['status'] == "delete") {
                                                    echo '<span class="text text-danger">已刪除</span>';
                                                }
                                            ?>
                                        </td>
                                        <td><?=$item['register_date'] ?></td>
                                        <td style="width:10%;">
                                            <button onclick="location.href='<?=base_url()."mgr/user/detail/".$item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>
                                            
                                            <button class="btn btn-danger btn-xs btn-del" id="del_<?=$item['id'] ?>">
                                                <span class="fa fa-fw fa-trash"></span>
                                            </button>
                                            
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

<!-- coin modal -->
<div id="coin_modal" class="modal fade animated" role="dialog">
    <div class="modal-dialog" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal_title">點數</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>增減</th>
                                    <th>點數數量</th>
                                    <th>理由</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select id="addcoin_type" class="form-control">
                                            <option value="plus">增加</option>
                                            <option value="minus">減少</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" id="addcoin_count" placeholder="點數數量">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="addcoin_note" placeholder="操作理由">
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-xs" id="coin-submit">確認</button>
                                        <input type="hidden" id="addcoin_member">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table id="coin_log_table" class="table table-striped dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>用途</th>
                                    <th>變動</th>
                                    <th>剩餘</th>
                                    <th>時間</th>
                                </tr>
                            </thead>
                            <tbody id="hi_log">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
            </div>
        </div>
    </div>
</div>
<!-- coin modal -->


<!-- coin modal -->
<div id="aff_modal" class="modal fade animated" role="dialog">
    <div class="modal-dialog" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal_title">回饋金</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>增減</th>
                                    <th>金額</th>
                                    <th>理由</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select id="aff_type" class="form-control">
                                            <option value="plus">增加</option>
                                            <option value="minus">減少</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" id="aff_count" placeholder="金額">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="aff_note" placeholder="操作理由">
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-xs" id="aff-submit">確認</button>
                                        <input type="hidden" id="aff_member">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table id="aff_log_table" class="table table-striped dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>用途</th>
                                    <th>變動</th>
                                    <th>剩餘</th>
                                    <th>時間</th>
                                </tr>
                            </thead>
                            <tbody id="aff_log">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
            </div>
        </div>
    </div>
</div>
<!-- coin modal -->

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
    $(document).ready(function () {
        window.onload = function () {
            $(function () {
                var inputMapper = {
                    "name": 1,
                    "phone": 2,
                    "email": 3
                };

                dtInstance = $("#showtable").DataTable({
                    "lengthMenu": [25, 50, 100],
                    "responsive": true,
                    // bLengthChange: true,
                    "pageLength": 25,
                    bLengthChange: true,
                    info: true,
                    mark: true,
                    "order": [[0, "desc"]],
                    columnDefs: [
                        { targets: [1, 2, 4, 7, 8], orderable: false},
                    ]
                });

                $("input[type=search]").on("input", function () {
                    var $this = $(this);
                    var val = $this.val();
                    var key = $this.attr("name");
                    dtInstance.columns(inputMapper[key] - 1).search(val).draw();
                });
            });
        }

        $(".verify-btn").on('click', function(event) {
            var id = $(this).parent().attr("id").split("_");
            $("#verify_id").val(id[1]);

            $("#verify_modal").modal("show").on('shown.bs.modal', function (e) {
                var username = $("#username_"+$("#verify_id").val()).html().split("<br>");
                var idnumber = $("#idnumber_"+$("#verify_id").val()).html().split("<br>");
                $(".modal_username").html(username[0]);
                $(".user_detail").html("姓名："+username[0]+"<br>居留證："+idnumber[0]+"<br>居留證到期日："+idnumber[1]);
                $(".idcard1").attr({
                    src: $("#idcard1_"+$("#verify_id").val()).attr("href")
                });
                $(".idcard2").attr({
                    src: $("#idcard2_"+$("#verify_id").val()).attr("href")
                });
            });            
        });

        $(".verify-confirm").on('click', function(event) {
            $.ajax({
                url: "<?=base_url() ?>mgr/user/verify",
                data: {
                    id: $("#verify_id").val()
                },
                type:"POST",
                dataType:'json',
                success: function(d){
                    if (d.status == "100") {
                        $("#status_"+$("#verify_id").val()).html('<span class="text text-success">正常</span>');
                        toastr["success"]("會員驗證已成功", "驗證成功");
                    }else{
                        toastr["error"](d.msg, "發生問題");
                    }
                },
                error:function(xhr, ajaxOptions, thrownError){ 
                    toastr["error"]("請檢查網路狀態再重試一次", "網路發生問題");
                }
            });
            $("#verify_modal").modal("hide");
        });

        $(".btn-export").on('click', function(event) {
            $.ajax({
                url: "<?=base_url() ?>mgr/user/export",
                data: {},
                type:"POST",
                dataType:'json',
                success: function(d){
                    if (d.status == "100") {
                        window.open(d.url);
                    }else{
                        toastr["error"](d.msg, "發生問題");
                    }
                },
                error:function(xhr, ajaxOptions, thrownError){ 
                    toastr["error"]("請檢查網路狀態再重試一次", "網路發生問題");
                }
            });
        });

        $(".btn-del").on('click', function(event) {
            if (!confirm("確定刪除此會員嗎?")) return;
            var id = $(this).attr("id").split("_");
            location.href='<?=base_url()."mgr/user/del/" ?>'+id[1]; 
        });

        $(".reward-setting").on('click', function(event) {
            var id = $(this).attr("id").split("_");
            reloadRewardLog(id[1]);
            $("#aff_member").val(id[1]);

            $("#aff_modal .modal_title").html($("#username_"+id[1]).html()+"(會員編號:"+id[1]+") 回饋金");

            $("#aff_modal").modal("show");
        });

        $("#aff_log_table").DataTable({
            "lengthMenu": [10, 25, 50],
            "responsive": true,
            "pageLength": 10,
            columnDefs: [
                { targets: [0,1,2,3], orderable: false},
            ]
        });

        $("#aff-submit").on('click', function(event) {
            var aff_type = $("#aff_type").val();
            var aff_count = $("#aff_count").val();
            var aff_note = $("#aff_note").val();
            var id = $("#aff_member").val();
            $.ajax({
                url: "<?= base_url() ?>mgr/user/reward_op",
                data: {
                    id: id,
                    type: aff_type,
                    count: aff_count,
                    note: aff_note
                },
                type: "POST",
                dataType: "json",
                success: function(msg){
                    if (msg.status == 100) {
                        reloadRewardLog(id);
                        $("#reward_"+id).html(msg.result);
                    }else{
                        alert(msg.msg);
                    }
                },
                error:function(xhr, ajaxOptions, thrownError){ 
                    alert(xhr.status); 
                    alert(thrownError); 
                },
                complete:function(){
                    $("#aff_count").val("");
                    $("#aff_note").val("");
                }
            });
        });

        $(".coin-setting").on('click', function(event) {
            var id = $(this).attr("id").split("_");
            reloadCoinLog(id[1]);
            $("#addcoin_member").val(id[1]);

            $("#coin_modal .modal_title").html($("#username_"+id[1]).html()+"(會員編號:"+id[1]+") 點數");

            $("#coin_modal").modal("show");
        });

        $("#coin_log_table").DataTable({
            "lengthMenu": [10, 25, 50],
            "responsive": true,
            "pageLength": 10,
            columnDefs: [
                { targets: [0,1,2,3], orderable: false},
            ]
        });

        $("#coin-submit").on('click', function(event) {
            var addcoin_type = $("#addcoin_type").val();
            var addcoin_count = $("#addcoin_count").val();
            var addcoin_note = $("#addcoin_note").val();
            var id = $("#addcoin_member").val();
            $.ajax({
                url: "<?= base_url() ?>mgr/user/coin_op",
                data: {
                    id: id,
                    type: addcoin_type,
                    count: addcoin_count,
                    note: addcoin_note
                },
                type: "POST",
                dataType: "json",
                success: function(msg){
                    if (msg.status == 100) {
                        reloadCoinLog(id);
                        $("#coin_"+id).html(msg.result);
                    }else{
                        alert(msg.msg);
                    }
                },
                error:function(xhr, ajaxOptions, thrownError){ 
                    alert(xhr.status); 
                    alert(thrownError); 
                },
                complete:function(){
                    $("#addcoin_count").val("");
                    $("#addcoin_note").val("");
                }
            });
        });

        $(".ratio").on('blur', function(event) {
            var id = $(this).attr("id").split("_");
            $.ajax({
                url: "<?= base_url() ?>mgr/user/ratio",
                data: {
                    id: id[1],
                    ratio: $(this).val()
                },
                type: "POST",
                dataType: "json",
                success: function(msg){
                    
                },
                error:function(xhr, ajaxOptions, thrownError){ 
                    
                }
            });
        });
    });    

    function reloadCoinLog(id){
        $("#hi_log").empty();
        $.ajax({
            url: "<?= base_url() ?>mgr/user/coin_log",
            data: {
                id: id
            },
            type: "POST",
            dataType: "json",
            success: function(msg){
                if (msg.status == 100) {
                    for (var i = 0; i < msg.data.length; i++) {
                        var item = msg.data[i];
                        var changetxt = "";
                        if (item['action'] == "plus") {
                            changetxt = '<span class="text text-success"> +'+item['count']+'</span>';
                        }else{
                            changetxt = '<span class="text text-danger"> -'+item['count']+'</span>';
                        }
                        var tr = $("<tr/>").append(
                            $("<td/>").html(item['id'])
                        ).append(
                            $("<td/>").html(item['note'])
                        ).append(
                            $("<td/>").html(changetxt)
                        ).append(
                            $("<td/>").html(item['result'])
                        ).append(
                            $("<td/>").html(item['create_date'])
                        ).appendTo($("#hi_log"));
                    }
                    
                }else{
                    alert(msg.msg);
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

    function reloadRewardLog(id){
        $("#aff_log").empty();
        $.ajax({
            url: "<?= base_url() ?>mgr/user/reward_log",
            data: {
                id: id
            },
            type: "POST",
            dataType: "json",
            success: function(msg){
                if (msg.status == 100) {
                    for (var i = 0; i < msg.data.length; i++) {
                        var item = msg.data[i];
                        var changetxt = "";
                        if (item['action'] == "plus") {
                            changetxt = '<span class="text text-success"> +'+item['count']+'</span>';
                        }else{
                            changetxt = '<span class="text text-danger"> -'+item['count']+'</span>';
                        }
                        var tr = $("<tr/>").append(
                            $("<td/>").html(item['id'])
                        ).append(
                            $("<td/>").html(item['note'])
                        ).append(
                            $("<td/>").html(changetxt)
                        ).append(
                            $("<td/>").html(item['result'])
                        ).append(
                            $("<td/>").html(item['create_date'])
                        ).appendTo($("#aff_log"));
                    }
                    
                }else{
                    alert(msg.msg);
                }
            },
            error:function(xhr, ajaxOptions, thrownError){ 
                 
            },
            complete:function(){
                
            }
        });
    }
    function copyStringToClipboard (str) {
       // Create new element
       var el = document.createElement('textarea');
       // Set value (string to be copied)
       el.value = str;
       // Set non-editable to avoid focus and move outside of view
       el.setAttribute('readonly', '');
       el.style = {position: 'absolute', left: '-9999px'};
       document.body.appendChild(el);
       // Select text inside element
       el.select();
       // Copy text to clipboard
       document.execCommand('copy');
       // Remove temporary element
       document.body.removeChild(el);
    }
</script>
</body>

</html>
