<!DOCTYPE html>
<html>

<head>
    <?php include("header.php"); ?>

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

    <link rel="stylesheet" media="screen" type="text/css" href="vendors/summernote/summernote.css">
    <link rel="stylesheet" media="screen" type="text/css" href="dist/cropper.css">

    <!--end of page level css-->

</head>
<?php include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                新增<?=$title?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li ><a href="<?=base_url() ?>mgr/article">
                        <?=$title?>管理
                    </a>
                </li>
                <li class="active">新增<?=$title?></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> 新增<?=$title?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="article_form" role="form" method="POST" action="<?=base_url() ?>mgr/adv/add" enctype="Multipart/Form-Data">
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">位置</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="position" name="position">
                                        <?php foreach ($adv_type as $key => $v) { ?>
                                            <option value="<?=$key ?>"><?=$v['name']?> <?=$v['size']?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">標題(備註用)</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="title" name="title">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">廣告圖</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control upload_pic" id="article_file" name="article_file">
                                        <img style="width:200px;" id="article_cover"  alt="">
                                        <input type="hidden" id="cover_path" name="image">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">連結</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="url" name="url">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-block btn-primary">新增</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="background-overlay"></div>
        </section>
    </aside>

    <!-- Picture Modal(切圖) 新增用-->
    <div class="modal fade" id="pictureModal" role="dialog" aria-labelledby="modalLabel" tabindex="-1" style="overflow-y: scroll;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">裁切圖片</h5>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img id="image" src="" alt="Picture">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button id="pic_save" type="button" class="btn btn-primary" data-dismiss="modal">儲存</button>
                </div>
            </div>
        </div>
    </div>
<!-- global js -->
<script src="js/app.js" type="text/javascript"></script>
<!-- end of global js -->
<!-- begining of page level js -->
<script type="text/javascript" src="vendors/datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="vendors/datatables/js/dataTables.bootstrap.js"></script>
<script src="vendors/mark.js/jquery.mark.js" charset="UTF-8"></script>
<script src="vendors/datatablesmark.js/js/datatables.mark.min.js" charset="UTF-8"></script>

<script src="vendors/moment/js/moment.min.js" type="text/javascript"></script>
<script src="vendors/colorpicker/js/bootstrap-colorpicker.min.js" type="text/javascript"></script>
<script src="vendors/clockpicker/js/bootstrap-clockpicker.min.js" type="text/javascript"></script>
<script src="vendors/datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="dist/cropper.js"></script>

<script>
    var adv_type = JSON.parse('<?=json_encode($adv_type) ?>');
    $(document).ready(function () {

        //$("#is_active").bootstrapSwitch();
        $('#is_active').bootstrapSwitch('onText', "是");
        $('#is_active').bootstrapSwitch('offText', "否");


        //裁切//////////////////////////////////////////////////////////////////////
        $(".upload_pic").on('change', function(){ //將上傳的圖檔放到裁切畫面
            var input = this;
            type  = $(this).data('type');

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) { //將上傳的圖放到裁切畫面
                    $("#image").attr('src', e.target.result);
                    $("#image").width("100%");
                }
                reader.readAsDataURL(input.files[0]);
                $(".upload_pic").val("");//清除type=file的檔案路徑，這樣選同一張圖一樣可以觸發change
                $("#pictureModal").modal('show');//顯示裁切畫面
            }
        })

        $('#pictureModal').on('shown.bs.modal', function () { //製造裁切框框
            var size = adv_type[$("#position").val()]['size'].split(" x ");
            var image = document.getElementById("image");
            cropper = new Cropper(image, {
                aspectRatio: size[0] / size[1],
                autoCropArea: 1
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
        });

        $("#pic_save").on('click', function(event) { //裁切畫面按下確認後執行的動作
            var result = cropper.getCroppedCanvas();
            $.ajax({
                url: "<?=base_url()?>mgr/adv/img_upload",
                data: {
                    imageData: result.toDataURL("image/jpeg")
                },
                type:"POST",
                dataType:'text',
                success: function(msg){
                    $("#cover_path").val(msg); //存到hidden中傳給controller處理
                    $('#article_cover').attr('src', "<?=base_url() ?>"+msg);//顯示裁切好的畫面給使用者看
                },
                error:function(xhr, ajaxOptions, thrownError){ 
                    alert("照片上傳發生錯誤"); 
                }
            });
            
            cropper.destroy();
        });
        
    });

</script>
</body>

</html>
