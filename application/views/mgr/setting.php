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
                全站設定
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li class="active">全站設定
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
                                <i class="ti-view-list"></i> 全站設定
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                                <table class="table horizontal_table table-striped" id="showtable">
                                    <thead>
                                    <tr>
                                        <!-- <th>#</th> -->
                                        <th>項目</th>
                                        <th style="width: 70%;">數值</th>
                                        <th>更新日期</th>
                                        <th>動作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? 
                                        $price_sep = 0;
                                        for($i=0;$i<count($list);$i++){ 
                                            $item = $list[$i]; 
                                    ?>
                                    <form action="<?=base_url()."mgr/setting/edit" ?>" method="POST">
                                        <!-- <input type="hidden" name="id" value="<?=$item['id'] ?>"> -->
                                        <tr>
                                            <!-- <td><?=$item['id'] ?></td> -->
                                            <td>
                                                <?=$item['hint'] ?>
                                            </td>
                                            <td>
                                                <?
                                                    if ($item['type'] == "text") {
                                                ?>
                                                    <input type="text" id="content_<?=$item['id'] ?>" value="<?=$item['content'] ?>" class="form-control">
                                                <?
                                                    }else if ($item['type'] == "number") {
                                                ?>
                                                    <input type="number" id="content_<?=$item['id'] ?>" value="<?=$item['content'] ?>" class="form-control">
                                                <?
                                                    }else if($item['type'] == "textarea_plain"){
                                                ?>
                                                    <textarea name="content" id="content_<?=$item['id'] ?>" class="form-control" style="height: 200px;"><?=$item['content'] ?></textarea>
                                                <?
                                                    }else if($item['type'] == "textarea"){
                                                ?>
                                                    <textarea name="content" id="content_<?=$item['id'] ?>" class="ckeditor form-control"><?=$item['content'] ?></textarea>
                                                <?
                                                    }else if($item['type'] == "puretextarea"){
                                                ?>
                                                    <textarea id="content_<?=$item['id'] ?>" style="height: 80px;" name="content" class="form-control"><?=$item['content'] ?></textarea>
                                                <?
                                                    }else if($item['type'] == "datetime"){
                                                ?>
                                                    <input type="text" id="content_<?=$item['id'] ?>" value="<?=$item['content'] ?>" class="form-control daypicker" data-timepicker="true" autocomplete="off">
                                                <?
                                                    }
                                                ?>
                                            </td>
                                            <td><?=str_replace(" ", "<br>", $item['update_date']) ?></td>
                                            <td>

                                                <button type="button" class="btn btn-primary btn-xs submit_btn" data-id="<?=$item['id'] ?>" data-type="<?=$item['type'] ?>" id="action_<?=$item['id'] ?>">更新</button>
                                            </td>
                                        </tr>
                                    </form>
                                    <? } ?>
                                    </tbody>
                                </table>
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
            var id = $(this).attr("data-id");
            var type = $(this).attr("data-type");
            var content = $("#content_"+id).val();
            
            if (type == "textarea") {
                // $("#content_"+id[1]).text($('#content_sn_'+id[1]).summernote('code'));
                content = CKEDITOR.instances["content_"+id].getData();
            }
            // $("#form_"+id[1]).submit();
            $.ajax({
                type: "POST",
                url: "<?=base_url() ?>mgr/setting/edit",
                data: {
                    id: id,
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
</script>
</body>

</html>
