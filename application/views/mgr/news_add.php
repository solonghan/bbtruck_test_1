<!DOCTYPE html>
<html>

<head>
    <? include("header.php"); ?>
    <link rel="stylesheet" href="vendors/datetime/css/jquery.datetimepicker.css">
    <link href="vendors/airdatepicker/css/datepicker.min.css" rel="stylesheet" type="text/css">
    
</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                新增最新消息
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
                <li class="active">新增最新消息</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> 新增最新消息
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="<?=base_url() ?>mgr/news/add" id="new_form">
                                <?
                                    $param = [
                                        ["標題(繁中)", "title_tw", "text", ""],
                                        ["標題(EN)", "title_en", "text", ""],
                                        ["顯示日期", "date", "day", date("Y-m-d")],
                                        ["內容(繁中)<br><span class='text text-primary'>電腦版</span>", "content_tw", "textarea", ""],
                                        ["內容(EN)<br><span class='text text-primary'>電腦版</span>", "content_en", "textarea", ""],
                                        ["內容(繁中)<br><span class='text text-info'>手機版</span>", "content_mobile_tw", "textarea", ""],
                                        ["內容(EN)<br><span class='text text-info'>手機版</span>", "content_mobile_en", "textarea", ""],
                                        ["置頂", "is_head", "checkbox", ""],
                                    ];
                                    foreach ($param as $item):
                                ?>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label"><?=$item[0] ?></label>
                                    <div class="col-sm-10">
                                        <? if ($item[2] == "text"): ?>
                                        <input type="text" class="form-control" name="<?=$item[1] ?>" value="<?=$item[3] ?>">
                                        <? elseif($item[2] == "textarea"): ?>
                                        <textarea class="ckeditor" id="<?=$item[1] ?>" name="<?=$item[1] ?>"><?=$item[3] ?></textarea>
                                        <? elseif($item[2] == "checkbox"): ?>
                                        <input type="checkbox" class="form-control" name="<?=$item[1] ?>"<?=($item[3]!="" && $item[3]==1)?' checked':'' ?>>
                                        <? elseif($item[2] == "day"): ?>
                                        <input type="text" class="form-control daypicker" name="<?=$item[1] ?>" value="<?=$item[3] ?>" autocomplete="off">
                                        <? endif; ?>
                                    </div>
                                </div>
                                <? endforeach; ?>
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

<script src="vendors/datetime/js/jquery.datetimepicker.full.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.en.js" type="text/javascript"></script>
<script src="ckeditor/ckeditor.js"></script>

<script>var language = {
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
        $(".submit_btn").on('click', function(event) {
            $("#new_form").submit();
        });

    });    
</script>
</body>

</html>
