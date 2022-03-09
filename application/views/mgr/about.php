<!DOCTYPE html>
<html>

<head>
    <? include("header.php"); ?>
    <link rel="stylesheet" href="vendors/datetime/css/jquery.datetimepicker.css">
    <link href="vendors/airdatepicker/css/datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="css/native-toast.css" rel="stylesheet">
</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?=$title ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li class="active"><?=$title ?>
                </li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <? foreach ($data as $item): ?>
                <div class="col-lg-12 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> <?=$item['hint'] ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                                <? if ($item['type'] == "textarea"): ?>
                                <textarea name="content" id="content_<?=$item['id'] ?>" class="ckeditor form-control"><?=$item['content'] ?></textarea>
                                
                                <? elseif($item['type'] == "text"): ?>
                                <input type="text" id="content_<?=$item['id'] ?>" class="form-control" value="<?=$item['content'] ?>">

                                <? elseif($item['type'] == "img"): ?>
                                <input data-ratio="<?=$item['w']/$item['h'] ?>" data-related="<?=$item['id'] ?>" class="img_upload" type="file" id="imgupload_<?=$item['id'] ?>" style="display: none;" accept="image/*">
                                <button type="button" class="btn btn-sm btn-info" onclick="imgupload_<?=$item['id'] ?>.click();">選擇照片</button>
                                <button id="delphoto_<?=$item['id'] ?>" type="button" class="btn btn-sm btn-danger" onclick="delete_photo('<?=$item['id'] ?>');"<?=($item['content'] == "")?' style="display:none;"':"" ?>>刪除照片</button>
                                <input type="hidden" id="<?=$item['id'] ?>" value="<?=$item['content'] ?>" class="target_img">
                                <div id="img_<?=$item['id'] ?>" style="width: 256px; margin-top: 6px; background-color: #FFF; border:1px solid #DDD; padding: 2px; border-radius: 2px;<?=($item['content'] == "")?' display:none;':"" ?>">
                                    <img src="<?=($item['content'] != "")?base_url().$item['content']:"" ?>" style="width: 250px;">
                                </div>
                                
                                <? endif; ?>
                                <button type="button" class="btn btn-primary btn-block submit_btn" id="<?=$item['type'] ?>_<?=$item['id'] ?>">更新</button>
                            </div>
                        </div>
                    </div>
                </div>
                <? endforeach; ?>
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
<script src="vendors/datetime/js/jquery.datetimepicker.full.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.en.js" type="text/javascript"></script>
<script src="js/native-toast.js"></script>

<script src="ckeditor/ckeditor.js"></script>
<script>
    var language = {
        daysMin: ['日', '一', '二', '三', '四', '五', '六'],
        months: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
        monthsShort: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
        dateFormat: 'yyyy-mm-dd',
        timeFormat: 'hh:ii:00',
        firstDay: 0
    };
    $(document).ready(function () {
        $('.daypicker').datepicker({
            language: language,
            minDate: new Date('<?=date('Y-m-d') ?>'),
            position: "top left",
            autoClose: true
        });        

        $(".submit_btn").on('click', function(event) {
            var id = $(this).attr("id").split("_");
            var content = $("#content_"+id[1]).val();
            if (id[0] == "textarea") {
                content = CKEDITOR.instances["content_"+id[1]].getData();    
            }else if(id[0] == "img"){
                content = $("#"+id[1]).val()
            }

            $.ajax({
                type: "POST",
                url: "<?=base_url() ?>mgr/about/edit",
                data: {
                    id: id[1],
                    content: content
                },
                dataType: "json",
                success: function(data){
                    if (data.status == 100) {
                        nativeToast({
                            message: '更新成功',
                            type: 'success',
                            position: 'top',
                            square: true,
                            edge: false,
                            debug: false
                        })
                    }
                },
                failure: function(errMsg) {
                    alert(errMsg);
                }
            }); 
        });
    }); 

    function delete_photo(id){
        $("#delphoto_"+id).hide();
        $("#"+id).val("");
        $("#img_"+id+" img").attr("src", "");
        $("#img_"+id).hide();
    }
</script>
<? include("crop.php"); ?>
</body>

</html>
