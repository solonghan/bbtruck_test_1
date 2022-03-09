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
    
    <!--end of page level css-->

</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                訂單管理
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li ><a href="<?=base_url() ?>mgr/bill">
                        <i class="fa fa-fw ti-money"></i> 訂單管理
                    </a>
                </li>
                <li class="active">#<?=$data['order_no'] ?></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> 訂單資料 #<?=$data['order_no'] ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="<?=base_url() ?>mgr/bill/detail/<?=$data['id'] ?>">
                                <?
                                    $field = [
                                        ["收件人", "recipient_name", "text"],
                                        ["電話", "phone", "text"],
                                        ["Email", "email", "text"],
                                        ["城市", "city", "select"],
                                        ["收件人地址", "recipient_address", "text"],
                                        // ["付款資訊", "payment_remark", "text"],
                                        // ["貨運資訊", "shipping_remark", "text"],
                                        ["運費", "fee", "text"]
                                    ];
                                    foreach ($field as $item) {
                                        if ($item[2] == "text") {
                                ?>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label"><?=$item[0] ?></label>
                                    <div class="col-sm-10">
                                        <input type="<?=$item[2] ?>" class="form-control" name="<?=$item[1] ?>" value="<?=$data[$item[1]] ?>">
                                    </div>
                                </div>
                                <?
                                        }else{
                                ?>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">城市</label>
                                    <div class="col-sm-10">
                                        <select name="city" class="form-control">
                                            <option value="基隆"<?=($data['city']=="基隆")?" selected":"" ?>>基隆 Keelung</option>
                                            <option value="台北"<?=($data['city']=="台北")?" selected":"" ?>>台北 Taipei</option>
                                            <option value="新北"<?=($data['city']=="新北")?" selected":"" ?>>新北 New Taipei</option>
                                            <option value="桃園"<?=($data['city']=="桃園")?" selected":"" ?>>桃園 Taoyuan</option>
                                            <option value="新竹"<?=($data['city']=="新竹")?" selected":"" ?>>新竹 Hsinchu</option>
                                            <option value="苗栗"<?=($data['city']=="苗栗")?" selected":"" ?>>苗栗 Miaoli</option>
                                            <option value="臺中"<?=($data['city']=="臺中")?" selected":"" ?>>臺中 Taichung</option>
                                            <option value="彰化"<?=($data['city']=="彰化")?" selected":"" ?>>彰化 Changhua</option>
                                            <option value="南投"<?=($data['city']=="南投")?" selected":"" ?>>南投 Nantou</option>
                                            <option value="雲林"<?=($data['city']=="雲林")?" selected":"" ?>>雲林 Yunlin</option>
                                            <option value="嘉義"<?=($data['city']=="嘉義")?" selected":"" ?>>嘉義 Chiayi</option>
                                            <option value="臺南"<?=($data['city']=="臺南")?" selected":"" ?>>臺南 Tainan</option>
                                            <option value="高雄"<?=($data['city']=="高雄")?" selected":"" ?>>高雄 Kaohsiung</option>
                                            <option value="屏東"<?=($data['city']=="屏東")?" selected":"" ?>>屏東 Pingtung</option>
                                            <option value="宜蘭"<?=($data['city']=="宜蘭")?" selected":"" ?>>宜蘭 Yilan</option>
                                            <option value="臺東"<?=($data['city']=="臺東")?" selected":"" ?>>臺東 Taitung</option>
                                            <option value="花蓮"<?=($data['city']=="花蓮")?" selected":"" ?>>花蓮 Hualien</option>
                                            <option value="澎湖"<?=($data['city']=="澎湖")?" selected":"" ?>>澎湖 Penghu</option>
                                            <option value="金門"<?=($data['city']=="金門")?" selected":"" ?>>金門 Kinmen</option>
                                            <option value="連江"<?=($data['city']=="連江")?" selected":"" ?>>連江 Lienchiang</option>
                                        </select>
                                    </div>
                                </div>
                                <?          
                                        }
                                    }
                                ?>
                                <!-- <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">狀態</label>
                                    <div class="col-sm-10">
                                        <select name="status" class="form-control">
                                            <option value="pending"<?=($data['status']=="pending")?' selected':'' ?>>準備中</option>
                                            <option value="shipping"<?=($data['status']=="shipping")?' selected':'' ?>>配送中</option>
                                            <option value="success"<?=($data['status']=="success")?' selected':'' ?>>完成</option>
                                            <option value="cancel"<?=($data['status']=="cancel")?' selected':'' ?>>用戶取消</option>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <button type="submit" class="btn btn-block btn-primary">確認修改</button>
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
<script>
    $(document).ready(function () {
        
    });    
</script>
</body>

</html>
