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

    <!--end of page level css-->

</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                新增沙龍
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li ><a href="<?=base_url() ?>mgr/salon">
                        <i class="fa fa-fw ti-user"></i> 沙龍管理
                    </a>
                </li>
                <li class="active">新增沙龍</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> 新增沙龍
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="<?=base_url() ?>mgr/salon/add">
                                <!-- <input type="hidden" name="user_id" value="<?=$data['id'] ?>"> -->
                                <?
                                    $field = [
                                        ["沙龍名稱", "name", "text"],
                                        ["帳號/Email", "email", "text"],
                                        ["密碼", "password", "password"],
                                        ["確認密碼", "password_confirm", "password"],
                                        ["負責人", "principal", "text"],
                                        ["電話", "phone", "tel"],
                                        ["地址", "address", "text"],
                                        ["營業時間", "opentime", "select"],
                                        ["設計師數量", "designers", "number"],
                                        ["助理數量", "assistants", "number"],
                                        ["洗頭台數量", "punchtable", "number"],
                                        ["服務項目", "service", "checkbox"],
                                        ["可接受付費方式", "accept", "checkbox"],
                                        ["介紹", "intro", "textarea"],
                                    ];
                                    foreach ($field as $item) {
                                        if ($item[1] == "intro") {
                                ?>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label"><?=$item[0] ?></label>
                                    <div class="col-sm-10">
                                        <textarea name="<?=$item[1] ?>" class="form-control" style="height: 60px;"></textarea>
                                    </div>
                                </div>
                                <?
                                        }else if ($item[1] == "opentime") {
                                ?>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label"><?=$item[0] ?></label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="<?=$item[1] ?>">
                                            <?
                                                for ($i=date("Y"); $i >= date("Y")-100; $i--) { 
                                                    echo '<option value="'.$i.'">'.$i.'年</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?
                                        }else if($item[1] == "service" || $item[1] == "accept"){
                                ?>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label"><?=$item[0] ?></label>
                                    <div class="col-sm-10">
                                        <?
                                            $service_name = ["洗", "剪", "染", "燙", "護"];
                                            $accept_name = ["信用卡", "現金"];
                                            $show_name = array();
                                            if ($item[1] == "service") {
                                                $show_name = $service_name;
                                            }else if ($item[1] == "accept") {
                                                $show_name = $accept_name;
                                            }
                                            for ($i=1; $i <= count($show_name) ; $i++) { 
                                        ?>
                                        <p>
                                            <input type="checkbox" name="<?=$item[1] ?>[]" checked value="<?=$i ?>" id="<?=$item[1] ?>name_<?=$i ?>">
                                            <label for="<?=$item[1] ?>name_<?=$i ?>"><?=$show_name[$i-1] ?></label>
                                        </p>
                                        <?
                                            }
                                        ?>
                                    </div>
                                </div>
                                <?
                                        }else{
                                ?>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label"><?=$item[0] ?></label>
                                    <div class="col-sm-10">
                                        <input type="<?=$item[2] ?>" class="form-control" name="<?=$item[1] ?>" value="">
                                    </div>
                                </div>
                                <?
                                        }
                                    }
                                ?>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">封面照</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" name="cover" id="coverurl" value="">
                                        <input type="file" id="inputCover" style="display: none;">
                                        <a class="btn btn-md btn-info" href="javascript:void(0);" onclick="inputCover.click();"><i class="icon-upload"></i> 上傳照片</a>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="coverArea">
                                                <img src="" style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-block btn-primary">新增</button>
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
<script type="text/javascript" src="vendors/datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="vendors/datatables/js/dataTables.bootstrap.js"></script>
<script src="vendors/mark.js/jquery.mark.js" charset="UTF-8"></script>
<script src="vendors/datatablesmark.js/js/datatables.mark.min.js" charset="UTF-8"></script>

<? include("crop.php"); ?>
</body>

</html>
