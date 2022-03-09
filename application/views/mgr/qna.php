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
                Q&A管理
            </h1>
            <button class="pull-right btn btn-md btn-primary" style="margin-top: -20px; margin-right: 25px;" onclick="location.href='<?=base_url() ?>mgr/qna/add';">新增Q&A</button>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li class="active">Q&A管理
                </li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-8 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> Q&A管理
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                                <table class="table horizontal_table table-striped" id="showtable">
                                    <thead>
                                    <tr>
                                        <th>排序</th>
                                        <th>分類</th>
                                        <th>問題</th>
                                        <th>回答內容</th>
                                        <th>建立日期</th>
                                        <th>動作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? for($i=0;$i<count($list);$i++){ $item = $list[$i]; ?>
                                    <tr id="tr_<?=$item['id'] ?>">
                                        <td>
                                            <input class="form-control sort" type="text" id="sort_<?=$item['id'] ?>" value="<?=$item['sort'] ?>" style="width: 60px; text-align: center;">
                                        </td>
                                        <td><?=$item['classify'] ?></td>
                                        <td>
                                            <?
                                                echo $item['title'];
                                            ?>
                                        </td>
                                        <td>
                                            <?
                                                if (strpos($item['answer'], "<img") !== FALSE) {
                                                    echo "<span class='label label-info'>(圖片)</span>";
                                                }
                                                if (mb_strlen(strip_tags($item['answer'])) > 100) {
                                                    echo mb_substr(strip_tags($item['answer']), 0, 100)."...";
                                                }else{
                                                    echo strip_tags($item['answer']);
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?
                                                echo $item['create_date'];
                                            ?>
                                        </td>
                                        <td style="width:12%;">
                                            <button onclick="location.href='<?=base_url()."mgr/qna/detail/".$item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>
                                            
                                            <button id="del_<?=$item['id'] ?>" class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-trash"></span></button>
                                            
                                        </td>
                                    </tr>
                                    <? } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> 新增大分類
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                                <table class="table horizontal_table table-striped">
                                    <thead>
                                    <tr>
                                        <th>大分類名稱</th>
                                        <th>動作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <form action="<?=base_url()."mgr/qna/c_add" ?>" method="post" enctype="multipart/form-data">
                                            <td>
                                                <input type="text" class="form-control" name="name" placeholder="請輸入大分類名稱">
                                            </td>
                                            <td><input type="submit" class="btn btn-xs btn-primary" value="新增"></td>
                                        </form>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table horizontal_table table-striped">
                                    <thead>
                                    <tr>
                                        <th>排序</th>
                                        <th>名稱</th>
                                        <th>動作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? foreach ($classify as $item): ?>
                                    <tr id="ctr_<?=$item['id'] ?>">
                                        <td>
                                            <input type="text" class="form-control c_sort" style="width: 50px; text-align: center;" value="<?=$item['sort'] ?>" id="csort_<?=$item['id'] ?>">
                                        </td>
                                        <td>
                                            <?=$item['name'] ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-danger cdel" id="cdel_<?=$item['id'] ?>">刪除</button>
                                        </td>
                                    </tr>
                                    <? endforeach; ?>
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
    $(document).ready(function () {
        window.onload = function () {
            $(function () {
                var inputMapper = {
                    // "name": 1,
                    // "idnumber": 2,
                    // "phone": 4,
                    // "social": 5,
                    // "introducer": 7
                };

                dtInstance = $("#showtable").DataTable({
                    "lengthMenu": [25, 50, 100],
                    "responsive": true,
                    // bLengthChange: true,
                    "pageLength": 25,
                    bLengthChange: false,
                    info: false,
                    mark: true,
                    "order": [],
                    // columnDefs: [
                    //     { targets: [0,1,2,3], orderable: false},
                    // ]
                });

                $("input[type=search]").on("input", function () {
                    var $this = $(this);
                    var val = $this.val();
                    var key = $this.attr("name");
                    dtInstance.columns(inputMapper[key] - 1).search(val).draw();
                });
            });
        }

        $(".sort").on('blur', function(event) {
            var id = $(this).attr("id").split("_")[1]; 
            $.ajax({
                    type: "POST",
                    url: '<?=base_url()."mgr/qna/sort/" ?>',
                    data: {
                        id: id,
                        sort: $(this).val()
                    },
                    dataType: "html",
                    success: function(data){
                        if (data == "success") {
                            
                        }else{
                            alert("發生錯誤");
                        }
                    },
                    failure: function(errMsg) {
                        alert(errMsg);
                    }
                });
        });


        $(".c_sort").on('blur', function(event) {
            var id = $(this).attr("id").split("_")[1]; 
            $.ajax({
                    type: "POST",
                    url: '<?=base_url()."mgr/qna/c_sort/" ?>',
                    data: {
                        id: id,
                        sort: $(this).val()
                    },
                    dataType: "html",
                    success: function(data){
                        if (data == "success") {
                            
                        }else{
                            alert("發生錯誤");
                        }
                    },
                    failure: function(errMsg) {
                        alert(errMsg);
                    }
                });
        });

        $(".del-btn").on('click', function(event) {
            var id = $(this).attr("id").split("_");
            if (confirm("確定要刪除嗎?")) {
                $.ajax({
                    type: "POST",
                    url: '<?=base_url()."mgr/qna/del/" ?>',
                    data: {
                        id: id[1]
                    },
                    dataType: "html",
                    success: function(data){
                        if (data == "success") {
                            $("#tr_"+id[1]).fadeOut('400', function() {
                                $(this).remove();
                            });
                        }else{
                            alert("發生錯誤");
                        }
                    },
                    failure: function(errMsg) {
                        alert(errMsg);
                    }
                });
            }
        });

        $(".cdel").on('click', function(event) {
            var id = $(this).attr("id").split("_");
            if (confirm("確定要刪除嗎?")) {
                $.ajax({
                    type: "POST",
                    url: '<?=base_url()."mgr/qna/c_del/" ?>',
                    data: {
                        id: id[1]
                    },
                    dataType: "html",
                    success: function(data){
                        if (data == "success") {
                            $("#ctr_"+id[1]).fadeOut('400', function() {
                                $(this).remove();
                            });
                        }else{
                            alert(data);
                        }
                    },
                    failure: function(errMsg) {
                        alert(errMsg);
                    }
                });
            }
        });
    });    
</script>
</body>

</html>
