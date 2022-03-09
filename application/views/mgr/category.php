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
        td, th{
            text-align: center;
        }
    </style>
</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                團購商品 大分類管理
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
                <li class="active">大分類管理
                </li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-9 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> 大分類管理
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                                <!-- <input type="button" class="btn btn-sm btn-primary btn-export" value="匯出Excel" style="position: absolute;"> -->
                                <table class="table horizontal_table table-striped" id="showtable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>顯示?</th>
                                        <th>名稱</th>
                                        <th>動作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? for($i=0;$i<count($list);$i++){ $item = $list[$i]; ?>
                                    <tr id="tr_<?=$item['id'] ?>">
                                        <form action="<?=base_url() ?>mgr/category/edit/<?=$item['id'] ?>" id="form_<?=$item['id'] ?>" method="post">
                                            <td><?=$item['id'] ?></td>
                                            <td>
                                                <?
                                                    if ($item['is_show'] == 1) {
                                                        echo '<span class="text text-success">顯示</span>';
                                                    }else{
                                                        echo '<span class="text text-danger">隱藏</span>';
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <span class="view_txt"><?=$item['name'] ?></span>
                                                <input type="text" name="name" value="<?=$item['name'] ?>" class="form-control edit_txt" style="display: none; width: 100%;">
                                            </td>
                                            <td style="width:20%;">
                                                <div id="viewarea_<?=$item['id'] ?>">
                                                    <button type="button" class="btn btn-primary btn-xs btn-edit" id="edit_<?=$item['id'] ?>">
                                                        編輯
                                                    </button>
                                                    <? if ($item['is_show'] == 1): ?>
                                                    <button type="button" class="btn btn-warning btn-xs" onclick="location.href='<?=base_url()."mgr/category/status/hide/".$item['id'] ?>';">隱藏</button>
                                                    <? else: ?>
                                                    <button type="button" class="btn btn-success btn-xs" onclick="location.href='<?=base_url()."mgr/category/status/show/".$item['id'] ?>';">顯示</button>
                                                    <? endif; ?>
                                                    <button type="button" class="btn btn-danger btn-xs" onclick="location.href='<?=base_url()."mgr/category/status/del/".$item['id'] ?>';">刪除</button>
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
                <div class="col-lg-3 col-xs-12">
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
                                        <form action="<?=base_url()."mgr/category/add" ?>" method="post" enctype="multipart/form-data">
                                            <td>
                                                <input type="text" class="form-control" name="name" placeholder="請輸入大分類名稱">
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
            </div>
            <div class="background-overlay"></div>
            <input type="file" id="icon_upload_input" style="position: absolute; width: 1px; height: 1px; top: -99px;" accept="image/*">
            <input type="hidden" id="icon_upload_id" value="">
            <input type="hidden" id="icon_upload_lang" value="">
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

        $(".icon_upload, .icon_img").on('click', function(event) {
            $("#icon_upload_input").click();

            var id = $(this).attr("id").split("_");
            $("#icon_upload_id").val(id[1]);
            $("#icon_upload_lang").val(id[2]);
        });
        $("#icon_upload_input").on('change', function(event) {
            var formData = new FormData();
            formData.append('icon', $('#icon_upload_input')[0].files[0]);
            formData.append('id', $("#icon_upload_id").val());
            formData.append('lang', $("#icon_upload_lang").val());

            $.ajax({
                url : "<?=base_url() ?>mgr/category/pic_upload",
                type : 'POST',
                data : formData,
                processData: false,
                contentType: false,
                dataType:'json',
                success : function(data) {
                    if (data['status'] == "success") {
                        if ($("#uploadicon_"+$("#icon_upload_id").val()+"_"+$("#icon_upload_lang").val()).length > 0) {
                            $("#uploadicon_"+$("#icon_upload_id").val()+"_"+$("#icon_upload_lang").val()).remove();
                        }
                        
                        $("#photo_"+$("#icon_upload_id").val()+"_"+$("#icon_upload_lang").val()).attr({
                            src: data['url']
                        });
                        $("#photo_"+$("#icon_upload_id").val()+"_"+$("#icon_upload_lang").val()).fadeIn('fast');
                        
                    }else{
                        alert(data['msg']);
                    }
                    $("#icon_upload_id").val("");
                    $("#icon_upload_lang").val("");
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
