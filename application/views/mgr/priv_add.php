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
                新增人員
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li ><a href="<?=base_url() ?>mgr/priv">
                        <i class="fa fa-fw ti-user"></i> 權限管理
                    </a>
                </li>
                <li class="active">新增人員</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> 新增人員
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="<?=base_url() ?>mgr/priv/addaction">
                                <!-- <input type="hidden" name="user_id" value="<?=$data['id'] ?>"> -->
                                <?
                                    $field = [
                                        ["姓名", "name", "text"],
                                        ["帳號", "account", "text"],
                                        ["密碼", "password", "password"],
                                        ["確認密碼", "password_confirm", "password"]
                                    ];
                                    foreach ($field as $item) {
                                ?>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label"><?=$item[0] ?></label>
                                    <div class="col-sm-10">
                                        <input type="<?=$item[2] ?>" class="form-control" name="<?=$item[1] ?>" value="">
                                    </div>
                                </div>
                                <?
                                    }
                                ?>
                                <!-- <div class="form-group" id="pri_area">
                                    <label for="input-text" class="col-sm-2 control-label">權限</label>
                                    <div class="col-sm-10">
                                        <?
                                            $privname = ["輪播圖", "會員管理", "商品管理", "大分類管理", "分類管理", "訂單管理", "優惠券管理", "廣告管理", "全站設定", "Q&A管理"];
                                            for ($i=1; $i <= count($privname) ; $i++) { 
                                        ?>
                                        <p>
                                            <input type="checkbox" name="canuse[]" checked value="<?=$i ?>" id="privname_<?=$i ?>">
                                            <label for="privname_<?=$i ?>"><?=$privname[$i-1] ?></label>
                                        </p>
                                        <?
                                            }
                                        ?>
                                    </div>
                                </div> -->
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

</body>

</html>
