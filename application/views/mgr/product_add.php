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
    <link href="vendors/airdatepicker/css/datepicker.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/datepicker.css">

</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                新增產品
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li ><a href="<?=base_url() ?>mgr/product">
                        <i class="fa fa-fw ti-package"></i> 產品管理
                    </a>
                </li>
                <li class="active">新增產品</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> 新增產品
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="<?=base_url() ?>mgr/product/add" id="new_form" enctype="multipart/form-data">
                                <!-- <input type="hidden" name="user_id" value="<?=$data['id'] ?>"> -->
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">大類別</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="category">
                                            <?
                                                foreach ($category as $item) {
                                                    echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="classify_area">
                                    <label for="input-text" class="col-sm-2 control-label">子分類</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="classify">
                                            <?
                                                foreach ($classify[$category[0]['id']] as $item) {
                                                    echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                        <? if ($this->encryption->decrypt($this->session->p) == "vendor"): ?>
                                        <!-- <br>
                                        <input type="button" class="btn btn-link btn-sm btn-insert" value="沒有合適的分類嗎? 點此新增"> -->
                                        <? endif; ?>
                                    </div>
                                </div>
                                <!-- <div class="form-group" id="add_classify_area" style="display: none;">
                                    <label for="input-text" class="col-sm-2 control-label text-danger">新增分類</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control add_classify" name="add_classify" value="" required>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">產品名稱</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" value="">
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">原價</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name="ori_price" value="">
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">售價</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name="price" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">TAG</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="tag" value="">
                                        <small class="text text-danger">請使用逗號『,』分隔</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">規格一</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="spe1" placeholder ="紅色,藍色">
                                        <small class="text text-danger">請使用逗號『,』分隔，若無請留空</small>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">規格二</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="spe2" placeholder="XL,L,M,S">
                                        <small class="text text-danger">請使用逗號『,』分隔，若無請留空</small>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">封面圖<br><small>建議比例 4:3</small></label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="photo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">照片(多圖)</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="pics[]" multiple>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">截止日期</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control timepick" name="deadline" data-timepicker="true" autocomplete="off">
                                        <small class="text text-danger">若消費者於截止時間前將商品加入購物車，但未結帳，系統會於截止日期1小時後自動刪除購物車中的商品</small>
                                    </div>
                                </div> -->
                                <? if($this->encryption->decrypt($this->session->p) != "vendor"): ?>
                                <!-- <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">指派供應商</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="owner">
                                            <option value="1">不指定</option>
                                            <?
                                                foreach ($vendor as $item) {
                                                    echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div> -->
                                <? endif; ?>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">商品摘要介紹<br><small>(限100字內)</small></label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="summary"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">詳細介紹</label>
                                    <div class="col-sm-10">
                                        <textarea name="des" id="des" style="position: absolute; width: 1px; height: 1px; z-index: -100;"></textarea>
                                        <div class="summernote" id="des_sn" style="width: 100%; height: 350px;"></div>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">付款說明</label>
                                    <div class="col-sm-10">
                                        <textarea name="payment_des" id="payment_des" style="position: absolute; width: 1px; height: 1px; z-index: -100;"></textarea>
                                        <div class="summernote" id="payment_des_sn" style="width: 100%; height: 350px;"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">團購須知</label>
                                    <div class="col-sm-10">
                                        <textarea name="rule" id="rule" style="position: absolute; width: 1px; height: 1px; z-index: -100;"></textarea>
                                        <div class="summernote" id="rule_sn" style="width: 100%; height: 350px;"></div>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">狀態</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="status">
                                            <option value="publish">正常</option>
                                            <option value="soldout">下架</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-block btn-primary submit_btn">新增</button>
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
<script src="vendors/airdatepicker/js/datepicker.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.en.js" type="text/javascript"></script>

<script>
    var classify = JSON.parse('<?=json_encode($classify) ?>');
    $(document).ready(function () {
        $("select").select2();

        $(".btn-insert").on('click', function(event) {
            $("#classify_area").hide();
            $("#add_classify_area").show(); 
        });

        $(".add_classify").on('blur', function(event) {
            if ($(this).val() == "") return;
            $.ajax({
                type: "POST",
                url: '<?=base_url()."mgr/product/classify_exist" ?>',
                data: {
                    name: $(this).val(),
                    type: $("select[name=type]").val()
                },
                dataType: "json",
                success: function(data){
                    if (data.status == 200) {
                        alert(data.msg);
                        $(".add_classify").val("");
                    }
                },
                failure: function(errMsg) {
                    alert(errMsg);
                }
            });
        });

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
                    var iam = $(this);
                    data = new FormData();
                    data.append("pic", file);
                    $.ajax({
                        data: data,
                        type: "POST",
                        url: "<?=base_url() ?>home/upload_pic",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(url) {
                            var image = $('<img>').attr('src', url).css("width", '100%');
                            iam.summernote("insertNode", image[0]);
                        }
                    });
                }
            }
        });
        
        $("select[name=category]").on('change', function(event) {
            $("select[name=classify]").empty();
            var category = $(this).val();
            for (var i = 0; i < classify[category].length; i++) {
                $("select[name=classify]").append('<option value="'+classify[category][i]['id']+'">'+classify[category][i]['name']+'</option>');
            } 
        });

        $(".submit_btn").on('click', function(event) {
            // $("#payment_des").html($('#payment_des_sn').summernote('code'));
            // $("#rule").html($('#rule_sn').summernote('code'));
            $("#des").html($('#des_sn').summernote('code'));

            $("#new_form").submit();
        });

        $('.timepick').datepicker({
            language: {
                days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                daysMin: ['日', '一', '二', '三', '四', '五', '六'],
                months: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
                monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                today: 'Today',
                clear: 'Clear',
                dateFormat: 'yyyy-mm-dd',
                timeFormat: 'hh:ii:59',
                firstDay: 0
            }
        });
    });    
</script>
</body>

</html>
