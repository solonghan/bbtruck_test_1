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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.css" />
    
    <link href="vendors/toastr/css/toastr.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="css/custom_css/toastr_notificatons.css">
    <style>
        .label{
            margin: 3px;
        }
    </style>
</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                產品管理
            </h1>
            <button class="pull-right btn btn-md btn-primary" style="margin-top: -20px; margin-right: 25px;" onclick="location.href='<?=base_url() ?>mgr/product/add';">新增產品</button>
            <? if($this->encryption->decrypt($this->session->p) != "vendor"): ?>
            <!-- <button class="pull-right btn btn-md btn-warning" style="margin-top: -20px; margin-right: 10px;" onclick="importXLS.click();">Excel批次匯入產品</button> -->
            <!-- <form method="POST" action="<?=base_url() ?>mgr/product/import" id="import_form" enctype="multipart/form-data"> -->
                <input type="file" id="importXLS" name="importXLS" style="display: none;" accept=".xls" onchange="import_form.submit();">
            <!-- </form> -->
            <!-- <button class="pull-right btn btn-md btn-default" style="margin-top: -20px; margin-right: 10px;" onclick="location.href='<?=base_url() ?>sample.xls';">Excel範例檔下載</button> -->
            <? endif; ?>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li class="active">產品管理
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
                                <i class="ti-view-list"></i> 產品管理
                                <small class="text text-danger">※點擊圖片可變更封面圖，建議圖片比例 4:3</small>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                                <!-- <input type="button" class="btn btn-sm btn-primary btn-export" value="匯出Excel" style="position: absolute;"> -->
                                <table class="table horizontal_table table-striped" id="showtable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>封面圖</th>
                                        <?
                                            // if($this->encryption->decrypt($this->session->p) != "vendor"){
                                            //     echo '<th>供應商</th>';
                                            // }
                                        ?>
                                        <th>分類</th>
                                        <th>產品名稱</th>
                                        <th>售價</th>
                                        <th>狀態</th>
                                        <th>建立日期</th>
                                        <th>動作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? for($i=0;$i<count($list);$i++){ $item = $list[$i]; ?>
                                    <tr>
                                        <td><?=$item['id'] ?></td>
                                        <td>
                                            <? if($item['photo']!=""): ?>
                                            <img src="<?=base_url().$item['photo'] ?>" style="width:100px;" class="icon_img" id="photo_<?=$item['id'] ?>">
                                            <? else: ?>
                                            <button class="icon_upload" type="button" id="uploadicon_<?=$item['id'] ?>">上傳封面圖</button>
                                            <img src="<?=base_url().$item['photo'] ?>" style="width:100px; display: none;" class="icon_img" id="photo_<?=$item['id'] ?>">
                                            <? endif; ?>
                                        </td>
                                        <?
                                            // if($this->encryption->decrypt($this->session->p) != "vendor"){
                                            //     if ($item['owner'] <= 1) {
                                            //         echo '<td>-</td>';   
                                            //     }else{
                                            //         echo '<td>'.$item['vendor'].'</td>';    
                                            //     }
                                            // }
                                        ?>
                                        <td><?=$item['category']." > ".$item['classify'] ?></td>
                                        <td><?=$item['name'] ?></td>
                                        <td><?=$item['price'] ?></td>
                                        
                                        <td style="width: 50px;" id="status_<?=$item['id'] ?>">
                                            <?
                                                if ($item['status'] == "publish") {
                                                    echo '<span class="text text-success">正常</span>';
                                                }else if ($item['status'] == "soldout") {
                                                    echo '<span class="text text-danger">下架</span>';
                                                }else{
                                                    echo '<span class="text text-warning">'.$item['status'].'</span>';
                                                }
                                            ?>
                                        </td>
                                        <td><?=str_replace(" ", "<br>", $item['create_date']) ?></td>
                                        <td style="width:10%;">
                                            <button onclick="location.href='<?=base_url()."mgr/product/edit/".$item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>
                                            
                                            <button class="btn btn-danger btn-xs btn-del" id="del_<?=$item['id'] ?>">
                                                <span class="fa fa-fw fa-trash"></span>
                                            </button>
                                            
                                        </td>
                                    </tr>
                                    <? } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="file" id="icon_upload_input" style="position: absolute; width: 1px; height: 1px; top: -99px;" accept="image/*">
            <input type="hidden" id="icon_upload_id" value="">
            <div class="background-overlay"></div>
        </section>
        <!-- /.content -->
    </aside>
</div>

<!-- global js -->
<script src="js/app.js" type="text/javascript"></script>
<!-- end of global js -->
<!-- begining of page level js -->

<script src="vendors/datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="vendors/datatables/js/dataTables.bootstrap.js"></script>
<script src="vendors/mark.js/jquery.mark.js" charset="UTF-8"></script>
<script src="vendors/datatablesmark.js/js/datatables.mark.min.js" charset="UTF-8"></script>
<script src="vendors/mark.js/jquery.mark.js" charset="UTF-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.js"></script>

<script>
    $(document).ready(function () {
        window.onload = function () {
            $(function () {
                var inputMapper = {
                    "name": 1,
                    "phone": 2,
                    "email": 3
                };

                dtInstance = $("#showtable").DataTable({
                    "lengthMenu": [25, 50, 100],
                    "responsive": true,
                    // bLengthChange: true,
                    "pageLength": 25,
                    bLengthChange: true,
                    info: true,
                    mark: true,
                    "order": [[0, "desc"]],
                    columnDefs: [
                        { targets: [6], orderable: false},
                    ]
                });

                $("input").on("input", function () {
                    var $this = $(this);
                    var val = $this.val();
                    var key = $this.attr("name");
                    dtInstance.columns(inputMapper[key] - 1).search(val).draw();
                });
            });
        }


        $(".icon_upload, .icon_img").on('click', function(event) {
            $("#icon_upload_input").click();

            var id = $(this).attr("id").split("_");
            $("#icon_upload_id").val(id[1]);
        });
        $("#icon_upload_input").on('change', function(event) {
            var formData = new FormData();
            formData.append('photo', $('#icon_upload_input')[0].files[0]);
            formData.append('id', $("#icon_upload_id").val());

            $.ajax({
                url : "<?=base_url() ?>mgr/product/pic_upload",
                type : 'POST',
                data : formData,
                processData: false,
                contentType: false,
                dataType:'json',
                success : function(data) {
                    if (data['status'] == "success") {
                        if ($("#uploadicon_"+$("#icon_upload_id").val()).length > 0) {
                            $("#uploadicon_"+$("#icon_upload_id").val()).remove();
                        }
                        
                        $("#photo_"+$("#icon_upload_id").val()).attr({
                            src: data['url']
                        });
                        $("#photo_"+$("#icon_upload_id").val()).fadeIn('fast');
                        
                    }else{
                        alert(data['msg']);
                    }
                    $("#icon_upload_id").val("");
                }
            });
        });
        $(".btn-del").on('click', function(event) {
            if (!confirm("確定刪除此商品嗎?")) return;
            var id = $(this).attr("id").split("_");
            location.href='<?=base_url()."mgr/product/del/" ?>'+id[1]; 
        });
    });    
</script>
</body>

</html>
