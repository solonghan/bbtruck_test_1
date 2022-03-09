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

    <link rel="stylesheet" media="screen" type="text/css" href="vendors/summernote/summernote.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <!--end of page level css-->

</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                編輯活動
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li ><a href="<?=base_url() ?>mgr/activity">
                        <i class="fa fa-fw ti-rrs-alt"></i> 隱藏式活動管理
                    </a>
                </li>
                <li class="active">編輯活動</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> 編輯活動
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="<?=base_url() ?>mgr/activity/edit" id="new_form">
                                <input type="hidden" name="id" value="<?=$data['id'] ?>">
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">紅字標籤</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="tag" value="<?=$data['tag'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">短標題</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="short_title" value="<?=$data['short_title'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">標題</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="title" value="<?=$data['title'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">內容</label>
                                    <div class="col-sm-10">
                                        <textarea name="content" id="content" style="position: absolute; width: 1px; height: 1px; z-index: -100;"></textarea>
                                        <div class="summernote" id="content_sn" style="width: 100%; height: 350px;"><?=$data['content'] ?></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">合作沙龍</label>
                                    <div class="col-sm-10">
                                        <select class="form-control js-example-basic-multiple" name="salon[]" multiple="multiple" id="salon">
                                            <?
                                                foreach ($salon as $s) {
                                                    echo '<option value="'.$s['id'].'"';
                                                    if (in_array($s['id'], $select_salon)) {
                                                        echo ' selected';
                                                    }
                                                    echo '>'.$s['name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">狀態</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="status">
                                            <option value="open"<?=($data['status']=="open")?' selected':'' ?>>開啟</option>
                                            <option value="close"<?=($data['status']=="close")?' selected':'' ?>>關閉</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <button type="button" class="btn btn-md btn-danger submit_btn">新增</button>
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
<script type="text/javascript" src="vendors/summernote/summernote.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
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
        $('#salon').select2({
            placeholder: '沙龍選擇',
            width: 'resolve' 
        }).on('select2:select', function (e) {
            
        }).on('select2:unselect', function(e) {

        });

        $(".submit_btn").on('click', function(event) {
            $("#content").html($('#content_sn').summernote('code'));

            // var set_selected_value = [];
            // for (var i = 0; i < cdata.length; i++) {
            //     set_selected_value.push(cdata[i]['id']);
            // }
            // category = set_selected_value;

            $("#new_form").submit();
        });

    });    
</script>
</body>

</html>
