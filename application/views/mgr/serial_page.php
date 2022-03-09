<!DOCTYPE html>
<html>

<head>
    <? include("header.php"); ?>
    <link rel="stylesheet" href="vendors/datetime/css/jquery.datetimepicker.css">
    <link href="vendors/airdatepicker/css/datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="vendors/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="vendors/select2/css/select2-bootstrap.css" rel="stylesheet" type="text/css">
    
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
                <? if ($parent != ""): ?>
                <li ><a href="<?=$parent_link ?>">
                        <i class="fa fa-fw ti-folder"></i> <?=$parent ?>
                    </a>
                </li>
                <? endif; ?>
                <li class="active"><?=$title ?></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> <?=$title ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="<?=$action ?>" id="new_form" enctype='multipart/form-data'>
                                <?
                                    
                                    foreach ($param as $item):
                                ?>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label"><?=$item[0] ?></label>
                                    <div class="col-sm-10">
                                        <? if ($item[2] == "text"): ?>
                                        <input type="text" class="form-control" name="<?=$item[1] ?>" value="<?=$item[3] ?>">
                                        <? elseif ($item[2] == "number"): ?>
                                        <input type="number" class="form-control" name="<?=$item[1] ?>" value="<?=$item[3] ?>">
                                        <? elseif ($item[2] == "plain"): ?>
                                        <div style="line-height: 40px; border-bottom: 1px solid #EEE;"><?=$item[3] ?></div>
                                        <? elseif($item[2] == "textarea"): ?>
                                        <textarea class="ckeditor" id="<?=$item[1] ?>" name="<?=$item[1] ?>"><?=$item[3] ?></textarea>
                                        <? elseif($item[2] == "textarea_plain"): ?>
                                        <textarea class="form-control" id="<?=$item[1] ?>" name="<?=$item[1] ?>" style="height: 200px;"><?=$item[3] ?></textarea>
                                        <? elseif($item[2] == "checkbox"): ?>
                                        <input type="checkbox" class="form-control" name="<?=$item[1] ?>"<?=($item[3]!="" && $item[3]==1)?' checked':'' ?>>
                                        <? elseif($item[2] == "day"): ?>
                                        <input type="text" class="form-control daypicker" name="<?=$item[1] ?>" value="<?=$item[3] ?>" autocomplete="off">
                                        <? elseif($item[2] == "select"): ?>
                                        <select class="form-control select2" name="<?=$item[1] ?>">
                                            <? 
                                                foreach ($select[$item[1]] as $option){
                                                    echo '<option value="'.$option[$item[4][0]].'"';
                                                    if ($item[3] == $option[$item[4][0]]) echo ' selected';
                                                    echo '>'.$option[$item[4][1]].'</option>';
                                                } 
                                            ?>
                                        </select>
                                        <? elseif($item[2] == "select_multi"): ?>
                                        <select class="form-control select2" name="<?=$item[1] ?>[]" multiple="multiple">
                                            <? 
                                                foreach ($select[$item[1]] as $option){
                                                    echo '<option value="'.$option[$item[4][0]].'"';
                                                    if (is_array($item[3]) && in_array($option[$item[4][0]], $item[3])) echo ' selected';
                                                    echo '>'.$option[$item[4][1]].'</option>';
                                                } 
                                            ?>
                                        </select>
                                        <? elseif($item[2] == "file"): ?>
                                        <input type="file" class="form-control" name="<?=$item[1] ?>">
                                            <? if ($item[3] != ""): ?>
                                            <br>
                                            <div id="file_<?=$item[1] ?>">
                                                <a href="<?=base_url().$item[3] ?>">下載連結</a>&nbsp;&nbsp;
                                                <button type="button" class="btn btn-sm btn-danger" onclick="delete_file('<?=$item[1] ?>');">刪除檔案</button>
                                            </div>
                                            <input type="hidden" name="<?=$item[1] ?>_deleted" value="false">
                                            <? endif; ?>
                                        <? elseif($item[2] == "img"): ?>
                                            <input data-ratio="<?=$item[4] ?>" data-related="<?=$item[1] ?>" class="img_upload" type="file" id="imgupload_<?=$item[1] ?>" style="display: none;" accept="image/*">
                                            <button type="button" class="btn btn-sm btn-info" onclick="imgupload_<?=$item[1] ?>.click();">選擇照片</button>
                                            <button id="delphoto_<?=$item[1] ?>" type="button" class="btn btn-sm btn-danger" onclick="delete_photo('<?=$item[1] ?>');"<?=($item[3] == "")?' style="display:none;"':"" ?>>刪除照片</button>
                                            <input type="hidden" name="<?=$item[1] ?>" id="<?=$item[1] ?>" value="<?=$item[3] ?>">
                                            <div id="img_<?=$item[1] ?>" style="width: 256px; margin-top: 6px; background-color: #FFF; border:1px solid #DDD; padding: 2px; border-radius: 2px;<?=($item[3] == "")?' display:none;':"" ?>">
                                                <img src="<?=($item[3] != "")?base_url().$item[3]:"" ?>" style="width: 250px;">
                                            </div>
                                        <? elseif($item[2] == "custom"): ?>
                                        <div style="display: inline;">
                                            <select class="form-control select2 downloads_option" style="width: 550px;">
                                                <? 
                                                    $exist_tr = "";
                                                    $downloads_ids = "";
                                                    foreach ($select[$item[1]] as $option){
                                                        echo '<option value="'.$option[$item[4][0]].'"';
                                                        if (is_array($downloads) && array_key_exists($option[$item[4][0]], $downloads)){
                                                            $exist_tr .= '<tr id="tr_'.$option[$item[4][0]].'">';
                                                            $exist_tr .= '<td>'.$option[$item[4][1]].'</td>';
                                                            $exist_tr .= '<td><select name="required_'.$option[$item[4][0]].'" class="form-control" style="width:60px">';
                                                            $exist_tr .= '<option value="1"'.(($downloads[$option[$item[4][0]]]['required']==1)?' selected':'').'>是</option>';
                                                            $exist_tr .= '<option value="0"'.(($downloads[$option[$item[4][0]]]['required']==0)?' selected':'').'>否</option>';
                                                            $exist_tr .= '</option></td>';
                                                            $exist_tr .= '<td><button onclick="del_download('.$option[$item[4][0]].');" type="button" class="btn btn-md btn-danger"><span class="ti-trash"></span></button></td>';
                                                            $exist_tr .= '</tr>';

                                                            $downloads_ids .= $option[$item[4][0]].";";
                                                        }
                                                        echo '>'.$option[$item[4][1]].'</option>';
                                                    } 
                                                ?>
                                            </select>    
                                            <button type="button" class="btn btn-sm btn-info btn-add">加入</button>
                                        </div>
                                        <table style="width: 600px" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>名稱</th>
                                                    <th>是否必安裝</th>
                                                    <th>動作</th>
                                                </tr>
                                            </thead>
                                            <tbody id="content">
                                                <?=$exist_tr ?>
                                            </tbody>
                                        </table>
                                        <input type="hidden" name="downloads_ids" value="<?=$downloads_ids ?>">
                                        <? endif; ?>
                                    </div>
                                </div>
                                <? endforeach; ?>
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <button type="button" class="btn btn-md btn-primary submit_btn"><?=$submit_txt ?></button>
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

<script src="vendors/datetime/js/jquery.datetimepicker.full.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.en.js" type="text/javascript"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>var language = {
        daysMin: ['日', '一', '二', '三', '四', '五', '六'],
        months: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
        monthsShort: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
        dateFormat: 'yyyy-mm-dd',
        timeFormat: 'hh:ii:00',
        firstDay: 0
    };
    $(document).ready(function () {
        $(".select2").select2();
        $('.daypicker').datepicker({
            language: language,
            minDate: new Date('<?=date('Y-m-d') ?>'),
            position: "bottom left",
            autoClose: true
        });   
        $(".submit_btn").on('click', function(event) {
            $("#new_form").submit();
        });

        $(".btn-add").on('click', function(event) {
            var downloads_ids = $("input[name=downloads_ids]").val();
            if (downloads_ids.indexOf($(".downloads_option").val()+";") !== -1){
                alert("此項目已加入");
                return;
            }
            $("#content").append(
                $("<tr/>").attr("id","tr_"+$(".downloads_option").val()).append(
                    $("<td/>").html($(".downloads_option").select2('data')[0].text)
                ).append(
                    $("<td/>").append(
                        $("<select/>").attr("name","required_"+$(".downloads_option").val()).addClass('form-control').css({width:'60px'})
                        .append($("<option/>").val(1).html("是"))
                        .append($("<option/>").val(0).html("否").attr("selected",true))
                    )
                ).append(
                    $("<td/>").html('<button onclick="del_download('+$(".downloads_option").val()+');" type="button" class="btn btn-md btn-danger"><span class="ti-trash"></span></button>')
                )
            );
            downloads_ids += $(".downloads_option").val()+";";
            $("input[name=downloads_ids]").val(downloads_ids);
        });
    });

    function delete_file(id){
        $("#file_"+id).remove();
        $("input[name="+id+"_deleted]").val("true");
    }

    function delete_photo(id){
        $("#delphoto_"+id).hide();
        $("#"+id).val("");
        $("#img_"+id+" img").attr("src", "");
        $("#img_"+id).hide();
    }

    function del_download(id){
        $("#tr_"+id).fadeTo('fast', 0, function() {
            $(this).remove();
        });
        var downloads_ids = $("input[name=downloads_ids]").val();
        downloads_ids = downloads_ids.replace(id+";", "");
        $("input[name=downloads_ids]").val(downloads_ids);
    }
</script>
<? include("crop.php"); ?>
</body>

</html>
