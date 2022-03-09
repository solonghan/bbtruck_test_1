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
    <link rel="stylesheet" media="screen" type="text/css" href="vendors/summernote/summernote.css">

    <!--end of page level css-->

</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                編輯最新消息
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li ><a href="<?=base_url() ?>mgr/priv">
                        <i class="fa fa-fw ti-comment-alt"></i> 最新消息管理
                    </a>
                </li>
                <li class="active">編輯最新消息</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> 編輯最新消息
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="<?=base_url() ?>mgr/news/detail" id="edit_form">
                                <input type="hidden" name="id" value="<?=$data['id'] ?>">
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">標題</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="title" value="<?=$data['title'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">內容</label>
                                    <div class="col-sm-10">
                                        <textarea name="content" id="content" style="position: absolute; width: 1px; height: 1px; z-index: -100;"><?=$data['content'] ?></textarea>
                                        <div class="summernote" id="content_sn" style="width: 100%; height: 350px;"><?=$data['content'] ?></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">置頂</label>
                                    <div class="col-sm-10">
                                        <input type="checkbox" class="form-control" name="is_head"<?=($data['is_head']==1)?' checked':'' ?>>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <button type="button" class="btn btn-md btn-danger submit_btn">編輯</button>
                                    </div>
                                </div>
                            </form>
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
<script type="text/javascript" src="vendors/summernote/summernote.min.js"></script>

<script>
    $(document).ready(function () {
        $(".summernote").summernote({
            height: 350,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['Insert', ['picture', 'link', 'table', 'hr']]
            ],
            callbacks: {
                onImageUpload: function(image) {
                    var file = image[0];
                    var reader = new FileReader();
                    reader.onloadend = function() {
                        var image = $('<img>').attr('src',  reader.result).css("width", '100%');
                        $('.summernote').summernote("insertNode", image[0]);
                    }
                    reader.readAsDataURL(file);
                }
            }
        });


        $(".submit_btn").on('click', function(event) {
            $("#content").html($('#content_sn').summernote('code'));

            $("#edit_form").submit();
        });

    });    
</script>
</body>

</html>
