<!DOCTYPE html>
<html>

<head>
    <? include("header.php"); ?>
    <link href="vendors/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="vendors/select2/css/select2-bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.css" />
    <link href="vendors/airdatepicker/css/datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="css/native-toast.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/custom_css/toastr_notificatons.css">
    <link href="vendors/iCheck/css/all.css" rel="stylesheet">
</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?=$title ?>
            </h1>
            <? foreach ($tool_btns as $item): ?>
            <button class="pull-right btn btn-md <?=$item[2] ?>" style="margin-top: -20px; margin-right: 25px;" onclick="location.href='<?=$item[1] ?>';"><?=$item[0] ?></button>
            <? endforeach; ?>
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
                    <? if ($type == "default"): ?>
                        <form action="<?=$action ?>" method="POST" enctype="multipart/form-data" id="import_form">
                            <input type="file" name="import_file" id="import_file" accept="xls" style="display: none;" onchange="import_form.submit();">
                            <button type="button" class="btn btn-md btn-primary" onclick="import_file.click();">上傳資料</button>
                            <button type="button" class="btn btn-md btn-default" onclick="location.href='<?=base_url() ?>'">下載格式範本Excel</button><br>
                            <!-- <small class="text text-danger">※請上傳副檔名為 .xls 的EXCEL檔案</small>     -->
                            <input type="hidden" name="type" value="<?=$type ?>">
                        </form>
                    <? elseif($type == "check"): ?>
                    <form action="<?=$action ?>" method="POST" enctype="multipart/form-data" id="import_form">
                        <input type="hidden" name="type" value="<?=$type ?>">
                        <input type="hidden" name="xls_file" value="<?=$import_file ?>">
                        <div class="panel filterable">
                            <div class="panel-heading clearfix">
                                <h3 class="panel-title pull-left m-t-6">
                                    <i class="ti-view-list"></i> <?=$title ?>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="m-t-10">
                                    <table class="table horizontal_table table-striped">
                                        <thead>
                                            <tr>
                                                <th>匯入?</th>
                                                <? foreach ($field as $t): ?>
                                                    <th<?=($t['width']!="")?' style="width: '.$t['width'].';"':'' ?>><?=$t['title'] ?></th>
                                                <? endforeach; ?>
                                                <th style="color:#F00;">系統訊息(<?=$error_cnt ?>)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach ($data as $index => $item): ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="import_index[]" value="<?=$index ?>" <?=($item['checked'])?'checked':'' ?>>
                                                </td>
                                                <? foreach ($field as $key): ?>
                                                <td>
                                                    <?
                                                        echo $item[$key['field']];
                                                    ?>
                                                </td>
                                                <? endforeach; ?>
                                                <td style="color: #F00;">
                                                    <?=$item['error'] ?>
                                                </td>
                                            </tr>
                                            <? endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-12" style="display: inline-flex; line-height: 34px;">
                                    預設到期日期：<input type="text" name="deadline" class="form-control daypicker" style="width: 160px;" autocomplete="off" value="<?=date('Y-m-d', strtotime('+ 30 days', strtotime(date("Y-m-d")))) ?>">&nbsp;&nbsp;&nbsp;&nbsp;
                                    <button type="submit" class="btn btn-md btn-primary">確認匯入 <i class="fa fa-fw fa-check"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <? endif; ?>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.js"></script>
<script src="js/native-toast.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript" src="vendors/iCheck/js/icheck.js"></script>
<script src="vendors/datetime/js/jquery.datetimepicker.full.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.en.js" type="text/javascript"></script>

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
            position: "bottom left",
            autoClose: true
        }); 
        $("input").iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '80%'
        });
    });
</script>
</body>

</html>
