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
        .label{
            margin: 3px;
        }
        #showtable td input{
            max-width: 100px !important;
        }
    </style>
</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                團購商品 分類管理
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li>
                    <a href="<?=base_url() ?>mgr/product">
                        <i class="fa fa-fw ti-package"></i> 團購商品
                    </a>
                </li>
                <li class="active">分類管理
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
                                <i class="ti-view-list"></i> 新增分類
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                                <table class="table horizontal_table table-striped">
                                    <thead>
                                    <tr>
                                        <th>ICON</th>
                                        <th>大分類名稱</th>
                                        <th>分類名稱</th>
                                        <th>動作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <form action="<?=base_url()."mgr/classify/add" ?>" method="post" enctype="multipart/form-data">
                                            <td style="max-width: 90px;">
                                                <input type="file" name="icon" class="form-control">
                                            </td>
                                            <td>
                                                <select class="form-control" name="category">
                                                    <?
                                                        foreach ($category as $item) {
                                                            echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="name" placeholder="請輸入子分類名稱">
                                            </td>
                                            <td><input type="submit" class="btn btn-xs btn-primary" value="新增"></td>
                                        </form>
                                    </tr>
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
                                <i class="ti-view-list"></i> 分類管理
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                                <!-- <input type="button" class="btn btn-sm btn-primary btn-export" value="匯出Excel" style="position: absolute;"> -->
                                <table class="table horizontal_table table-striped" id="showtable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ICON</th>
                                        <th>大分類</th>
                                        <th>中文名稱</th>
                                        <th>建立日期</th>
                                        <th>動作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? for($i=0;$i<count($list);$i++){ $item = $list[$i]; ?>
                                    <tr id="tr_<?=$item['id'] ?>">
                                        <form action="<?=base_url() ?>mgr/classify/edit/<?=$item['id'] ?>" id="form_<?=$item['id'] ?>" method="post">
                                            <td><?=$item['id'] ?></td>
                                            <td>
                                                <? if($item['icon']!=""): ?>
                                                <img src="<?=base_url().$item['icon'] ?>" style="width:40px;" class="icon_img" id="photo_<?=$item['id'] ?>">
                                                <? else: ?>
                                                <button class="icon_upload" type="button" id="uploadicon_<?=$item['id'] ?>">上傳照片</button>
                                                <img src="<?=base_url().$item['icon'] ?>" style="width:40px; display: none;" class="icon_img" id="photo_<?=$item['id'] ?>">
                                                <? endif; ?>
                                            </td>
                                            <td><?=$item['category'] ?></td>
                                            <td>
                                                <span class="view_txt"><?=$item['name'] ?></span>
                                                <input type="text" name="name" value="<?=$item['name'] ?>" class="form-control edit_txt" style="display: none;">
                                            </td>
                                            <td><?=str_replace(" ", "<br>", $item['create_date']) ?></td>
                                            <td style="width:10%;">
                                                <div id="viewarea_<?=$item['id'] ?>">
                                                    <button type="button" class="btn btn-primary btn-xs btn-edit" id="edit_<?=$item['id'] ?>">
                                                        編輯
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-xs" onclick="location.href='<?=base_url() ?>mgr/classify/del/<?=$item['id'] ?>'">
                                                        刪除
                                                    </button>
                                                </div>

                                                <div id="editarea_<?=$item['id'] ?>" style="display: none;">
                                                    <button type="button" class="btn btn-info btn-xs" onclick="form_<?=$item['id'] ?>.submit();">
                                                        確認
                                                    </button>
                                                    <button type="button" class="btn btn-default btn-xs btn-cancel" id="cancel_<?=$item['id'] ?>">
                                                        取消
                                                    </button>
                                                </div>
                                                
                                            </td>
                                        </form>
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
            <input type="file" id="icon_upload_input" style="position: absolute; width: 1px; height: 1px; top: -99;" accept="image/*">
            <input type="hidden" id="icon_upload_id" value="">
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
                    mark: false,
                    "order": [[0, "desc"]],
                    columnDefs: [
                        { targets: [1,4,5], orderable: false},
                    ]
                });
                // dtInstance.columns(2).search("大分類二").draw();
                $("input[type=search]").on("input", function () {
                    var $this = $(this);
                    var val = $this.val();
                    var key = $this.attr("name");
                    dtInstance.columns(inputMapper[key] - 1).search(val).draw();
                });
            });
        };

        $(".icon_upload, .icon_img").on('click', function(event) {
            $("#icon_upload_input").click();

            var id = $(this).attr("id").split("_");
            $("#icon_upload_id").val(id[1]);
        });
        $("#icon_upload_input").on('change', function(event) {
            var formData = new FormData();
            formData.append('icon', $('#icon_upload_input')[0].files[0]);
            formData.append('id', $("#icon_upload_id").val());

            $.ajax({
                url : "<?=base_url() ?>mgr/classify/pic_upload",
                type : 'POST',
                data : formData,
                processData: false,
                contentType: false,
                dataType:'json',
                success : function(data) {
                    if (data['status'] == "success") {
                        if ($("#uploadicon_"+$("#icon_upload_id").val()).length > 0) {
                            $("#uploadicon_"+$("#icon_upload_id").val()).remove();
                        }
                        
                        $("#photo_"+$("#icon_upload_id").val()).attr({
                            src: data['url']
                        });
                        $("#photo_"+$("#icon_upload_id").val()).fadeIn('fast');
                        
                    }else{
                        alert(data['msg']);
                    }
                    $("#icon_upload_id").val("");
                }
            });
        });

        $(".btn-edit").on('click', function(event) {
            var id = $(this).attr("id").split("_");
            $("#viewarea_"+id[1]).hide();
            $("#editarea_"+id[1]).show();
            $("#tr_"+id[1]).find('.view_txt').each(function(index, el) {
                $(this).hide();
            });
            $("#tr_"+id[1]).find('.edit_txt').each(function(index, el) {
                $(this).show();
            });
        });
        $(".btn-cancel").on('click', function(event) {
            var id = $(this).attr("id").split("_");
            $("#viewarea_"+id[1]).show();
            $("#editarea_"+id[1]).hide();
            $("#tr_"+id[1]).find('.view_txt').each(function(index, el) {
                $(this).show();
            });
            $("#tr_"+id[1]).find('.edit_txt').each(function(index, el) {
                $(this).hide();
            });
        });
    });    
</script>
</body>

</html>
