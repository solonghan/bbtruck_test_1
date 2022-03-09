<!DOCTYPE html>
<html>

<head>
    <? include("header.php"); ?>
    <link href="vendors/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="vendors/select2/css/select2-bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.css" />
    
    <link href="css/native-toast.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/custom_css/toastr_notificatons.css">

    <link href="vendors/bootstrap-switch/css/bootstrap-switch.css" rel="stylesheet" type="text/css"/>
    <link href="vendors/iCheck/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="vendors/datetime/css/jquery.datetimepicker.css">
    <link href="vendors/airdatepicker/css/datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="vendors/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="vendors/select2/css/select2-bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.css" />
    <link href="vendors/iCheck/css/all.css" rel="stylesheet">    
    <style>
        /*.select2-container--default .select2-selection--single{
            border-radius: 0;
            border: 1px solid #CCC;
            text-align: center;
        }*/
    </style>
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
                <? if (isset($parent) && $parent != ""): ?>
                <li ><a href="<?=$parent_link ?>">
                        <i class="fa fa-fw ti-folder"></i> <?=$parent ?>
                    </a>
                </li>
                <? endif; ?>
                <li class="active"><?=$title ?>
                </li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="form-group">
                        <label for="input-text" class="col-sm-4 control-label">群組名稱</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="short_title" value="">
                        </div>
                    </div>                    
                    <!-- <div class="form-group" >
                        <label for="input-text" class="col-sm-4 control-label" style="margin-top:10px;">選擇群組代碼</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="" style="margin-top:10px;">
                                <option value="">TM |台灣國際工具機展</option>
                                <option value="">CC | 台北國際自行車展</option>
                                <option value="">TP | 台北國際體育用品展</option>
                            </select>
                        </div>
                    </div>          -->           
                </div>
                <div class="col-lg-12 col-xs-12" style="margin-top:10px;">
                    <!-- <h4>各展覽擁有權限：</h4> -->
                </div>
                
                <div class="col-lg-12 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title m-t-6">
                                <i class="ti-view-list"></i> 權限列表
                                <span class="pull-right">
                                    <i class="fa fa-fw ti-angle-up clickable"></i>
                                </span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                                <table class="table horizontal_table table-striped" id="data_table">
                                    <thead>
                                    <tr>
                                        <th>菜單/功能</th>
                                        <th>瀏覽</th>
                                        <th>新增/匯入</th>
                                        <th>編輯/匯出</th>
                                        <th>刪除</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                        <?
                                            $item = array(
                                                // "home1"          =>  array("廠商現場報到", "ti-folder", 0),
                                                // "home2"          =>  array("買主現場報到", "ti-folder", 0),
                                                // "home3"          =>  array("異動作業", "ti-folder", 0),
                                                // "home4"          =>  array("報表查詢", "ti-folder", 0),
                                                // "home5"          =>  array("位置圖", "ti-folder", 0),
                                                // "hr"    =>  array(),
                                                "exhibit"         =>  array("Event列表", "ti-package", 0),
                                                "meeting"         =>  array("採洽會議管理", "ti-folder", 0,
                                                    array(
                                                        "meeting/add"     =>  array("新增會議", "ti-package", 0),
                                                        "meeting"         =>  array("會議列表", "ti-package", 0),
                                                        "meeting/session" =>  array("會議場次維護", "ti-package", 0),
                                                        "schedule"  =>  array("與會人員管理", "ti-package", 0),
                                                        // "exhibit/import"  =>  array("匯入", "ti-package", 0),
                                                    )
                                                ),
                                                "buyer"         =>  array("買主資料管理", "ti-folder", 0,
                                                    array(
                                                        "buyer/add"         =>  array("新增買主", "ti-package", 0),
                                                        "buyer/list" =>  array("買主列表", "ti-package", 0),
                                                        "buyer/session"    =>  array("買主資料審核", "ti-package", 0),
                                                        // "buyer/import"    =>  array("買主資料匯入", "ti-package", 0),
                                                    )
                                                ),
                                                "vender"         =>  array("廠商資料管理", "ti-folder", 0,
                                                    array(
                                                        "vender/add"         =>  array("新增廠商", "ti-package", 0),
                                                        "vender/list" =>  array("廠商列表", "ti-package", 0),
                                                        "vender/session"    =>  array("廠商資料審核", "ti-package", 0),
                                                        // "vender/import"    =>  array("廠商資料匯入", "ti-package", 0),
                                                    )
                                                ),
                                                "emeeting"         =>  array("視訊會議管理", "ti-folder", 0,
                                                    array(
                                                        "emeeting/cisco" =>  array("Cisco Webex", "ti-package", 0),
                                                        "emeeting/list"  =>  array("視訊會議列表", "ti-package", 0)
                                                    )
                                                ),
                                                "quest"         =>  array("問卷資料管理", "ti-folder", 0,
                                                    array(
                                                        "quest/add"    =>  array("新增問卷", "ti-package", 0),
                                                        "quest/list"   =>  array("問卷列表", "ti-package", 0),
                                                        "quest/cron"   =>  array("問卷派送及排程", "ti-package", 0),
                                                        "quest/answer" =>  array("問卷答案管理", "ti-package", 0)
                                                    )
                                                ),
                                                "mail"         =>  array("信件管理", "ti-folder", 0,
                                                    array(
                                                        "quest/add" =>  array("新增信件範本", "ti-package", 0),
                                                        "quest/list" =>  array("信件範本列表", "ti-package", 0),
                                                        "quest/cron" =>  array("信件派送與排程", "ti-package", 0),
                                                        "quest/log" =>  array("信件LOG", "ti-package", 0)
                                                    )
                                                ),
                                                "report"         =>  array("報表查詢", "ti-folder", 0,
                                                    array(
                                                        "quest/add" =>  array("報表1", "ti-package", 0),
                                                        "quest/list" =>  array("報表2", "ti-package", 0)
                                                    )
                                                ),
                                                "priv"         =>  array("帳號權限管理", "ti-folder", 0,
                                                    array(
                                                        "member" =>  array("帳號管理", "ti-package", 0),
                                                        "priv"   =>  array("權限管理", "ti-package", 0)
                                                    )
                                                )
                                                
                                            );
                                            foreach ($item as $key => $category) {
                                                echo '<tr><td><strong>'.$category[0].'</strong></td>';
                                                for ($i=0; $i < 4; $i++) { 
                                                    if ($i < 1) {
                                                        echo '<td><input type="checkbox" checked></td>';    
                                                    }else{
                                                        echo '<td>-</td>';
                                                    }
                                                    
                                                }
                                                echo '</tr>';
                                                if (array_key_exists(3, $category) && is_array($category[3])) {
                                                    foreach ($category[3] as $key => $classify) {
                                                        echo '<tr><td>&nbsp;∟&nbsp;'.$classify[0].'</td>';
                                                        for ($i=0; $i < 4; $i++) { 
                                                            echo '<td><input type="checkbox" checked></td>';
                                                        }
                                                        echo '</tr>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <div class="col-sm-12 mx-auto text-center">
                                        <button type="button" onclick="location.href='<?=base_url()."mgr/priv"?>'" class="btn btn-md btn-primary submit_btn">確認編輯</button>
                                        <button type="button" onclick="location.href='<?=base_url()."mgr/priv"?>'" class="btn btn-md btn-danger submit_btn">取消</button>
                                    </div>
                                </div>                                
                                <ul class="pagination page pull-right"></ul>
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


<script src="js/app.js" type="text/javascript"></script>

<script src="vendors/datetime/js/jquery.datetimepicker.full.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.en.js" type="text/javascript"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.js"></script>
<script type="text/javascript" src="vendors/iCheck/js/icheck.js"></script>

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
        $(".select2").select2();
        $('.daypicker').datepicker({
            language: language,
            minDate: new Date('<?=date('Y-m-d') ?>'),
            position: "bottom left",
            autoClose: true
        });
        $('.datetimepicker').datepicker({
            language: language,
            minDate: new Date('<?=date('Y-m-d') ?>'),
            position: "bottom left",
            autoClose: true,
            timepicker: true
        });
        $(".submit_btn").on('click', function(event) {
            $("#new_form").submit();
        });
        $(document).on('input', 'input[type=number]', function(event) {
            if ($(this).val() != "" && parseInt($(this).val()) < 0) 
                $(this).val(0);
        });
        $(".form-action").on('click', function(event) {
            event.preventDefault();
            return false;
        });
        $("input").iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '80%'
        });

        $("select[name=city]").on('change', function(e) {
            // var data = e.params.data;
            var selected_id = $(this).val();
            var new_data = new Array();
            for (var i = 0; i < city[selected_id]['dist'].length; i++) {
                new_data.push(
                    {
                        "id": city[selected_id]['dist'][i]['c3'],
                        "text": city[selected_id]['dist'][i]['c3']+" "+city[selected_id]['dist'][i]['name']
                    }
                )
            }
            $("select[name=dist]").empty().select2({
                data: new_data
            })
        });
        $(document).on('click', '.num_minus', function(event) {
            var id = $(this).parent().attr("id").split("_")[1];
            var num = parseInt($("#select_"+id).val());
            num = num - 1;
            num = (num < 0)?0:num;
            $("#select_"+id).val(num);
        });

        $(document).on('click', '.num_plus', function(event) {
            var id = $(this).parent().attr("id").split("_")[1];  
            var num = parseInt($("#select_"+id).val());
            var total = parseInt($(this).closest('.pattern').attr("data-max"));
            num = num + 1;
            num = (num >= total)?total:num;
            $("#select_"+id).val(num);
        });

        $(".multiple_img_upload").on('change', function(event) {
            var related_id = $(this).attr("data-related");
            var formData = new FormData();
            
            $.each($(this)[0].files, function(i, file) {
                formData.append('pics['+i+']', file);    
            });
            $.ajax({
                url: "<?=base_url() ?>mgr/dashboard/multiple_img_upload",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type:"POST",
                dataType:'json',
                success: function(data){
                    if (data.status) {
                        jQuery.each(data.data, function(index, pic) {
                            $("#pics_"+related_id).append(
                                $("<div/>").addClass('col-lg-2 col-md-3 col-sm-4 col-xs-6').append(
                                    $("<a/>").attr({"href":"<?=base_url() ?>"+pic, "data-fancybox":"gallery_"+related_id}).append(
                                        $("<img/>").addClass('thumbnail').css({'width':'100%'}).attr("src", "<?=base_url() ?>"+pic)
                                    )
                                ).append(
                                    $("<button/>").attr("type", "button").addClass('btn btn-sm btn-danger del-btn').on('click', function(event) {
                                        del_multi_img($(this), pic, related_id);  
                                    }).append(
                                        $('<span/>').addClass('fa fa-fw ti-trash')
                                    )
                                )
                            );
                            $("#"+related_id).val($("#"+related_id).val()+pic+";");
                        });
                        
                    }
                },
                error:function(xhr, ajaxOptions, thrownError){ 
                    alert("照片上傳發生錯誤"); 
                }
            });
        });

        $(".file_upload").on('change', function(event) {
            var multiple = $(this).attr("data-multi");
            var related_id = $(this).attr("data-related");
            var formData = new FormData();
            // formData.append('relation_id', <?=0//$id ?>);
            
            if (multiple == "true") {
                $.each($(this)[0].files, function(i, file) {
                    formData.append('files['+i+']', file);    
                });    
            }else{
                formData.append('files', $(this)[0].files[0]);
            }
            
            $.ajax({
                url: "<?=base_url() ?>mgr/dashboard/file_upload",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type:"POST",
                dataType:'json',
                success: function(data){
                    if (data.status) {
                        if (multiple == "true") {
                            jQuery.each(data.data, function(index, file) {
                                $("#files_"+related_id).append(
                                    $("<div/>").attr("id", "file_"+file.id).addClass('col-xs-12').css({'margin-top':'10px'}).append(
                                        $("<button/>").attr("type", "button").addClass('btn btn-sm btn-danger').on('click', function(event) {
                                            delete_file(related_id, file.id);  
                                        }).append(
                                            $('<span/>').addClass('fa fa-fw ti-trash')
                                        )
                                    ).append('&nbsp;&nbsp;').append(
                                        $("<a/>").attr({"href":"<?=base_url()."file/" ?>"+file.id}).append(
                                            file.realname
                                        )
                                    )
                                );
                                $("#"+related_id).val($("#"+related_id).val()+file.id+";");
                            });    
                        }else{
                            var file = data.data[0];
                            $("#files_"+related_id).append(
                                $("<div/>").attr("id", "file_"+file.id).addClass('col-xs-12').css({'margin-top':'10px'}).append(
                                    $("<button/>").attr("type", "button").addClass('btn btn-sm btn-danger').on('click', function(event) {
                                        delete_file(related_id, file.id);  
                                    }).append(
                                        $('<span/>').addClass('fa fa-fw ti-trash')
                                    )
                                ).append('&nbsp;&nbsp;').append(
                                    $("<a/>").attr({"href":"<?=base_url()."file/" ?>"+file.id}).append(
                                        file.realname
                                    )
                                )
                            );
                            if ($("#"+related_id).val() != "") {
                                var old_id = $("#"+related_id).val().replace(";", "");
                                delete_file(related_id, old_id, false);    
                            }
                            $("#"+related_id).val(file.id+";");
                        }
                    }
                },
                error:function(xhr, ajaxOptions, thrownError){ 
                    // alert("檔案上傳發生錯誤"); 
                }
            });
        });
    });

    function delete_file(related_id, id, alarm = true){
        if (alarm && !confirm("確定刪除此檔案?"+"\n"+"注意! 儲存後此動作才會正式生效")) return;
        $("#file_"+id).fadeTo('fast', 0, function() {
            $(this).remove(); 
        });
        $("#"+related_id+"_deleted").val($("#"+related_id+"_deleted").val()+id+",");
    }

    function delete_photo(id){
        $("#delphoto_"+id).hide();
        $("#"+id).val("");
        $("#img_"+id+" img").attr("src", "");
        $("#img_"+id).hide();
    }

    function del_multi_img(obj, pic, id){
        if (!confirm("確定刪除此照片嗎?刪除後請按下方儲存鈕，才會真正刪除。")) return;
        $(obj).parent("div").fadeOut();
        $("#picdeleted_"+id).val($("#picdeleted_"+id).val()+pic+",");
    }
    function form_action(url){
        $("#new_form").attr("action", url).submit();
    }
</script>
<? include("crop.php"); ?>
</body>

</html>
