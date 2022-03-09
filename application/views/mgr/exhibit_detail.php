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
    <!--end of page level css-->

</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?=$data['title']?> - 詳細資訊
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 首頁
                    </a>
                </li>
                <li ><a href="<?=base_url() ?>mgr/exhibit">Event列表
                    </a>
                </li>
                <li class="active">詳細資訊</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> 詳細資訊
                            </h3>
                        </div>
                        <div class="panel-body mt-5 mx-auto">
                        
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col" style="line-height:35px;font-size:16px">展覽館別：台北南港展覽館1館1樓、台北南港展覽館1館4樓、台北南港展覽館2館</div>
                                    <div class="col" style="line-height:35px;font-size:16px">展覽官網：https://www.taipeicycle.com.tw/zh-tw/index.html</div>
                                    <div class="col" style="line-height:35px;font-size:16px">展覽Email：taitra@taitra.org.tw</div>
                                    <div class="col" style="line-height:35px;font-size:16px">展覽描述：自行車整車、自行車零件、自行車配件及人身部品、電動自行車及電機系統、智慧騎乘裝置、騎行服務</div>                                
                                </div>
                                <div class="col-md-6">
                                    <div class="col" style="line-height:35px;font-size:16px">產業別：<?=$data['shorttitle']?></div>                                
                                    <div class="col" style="line-height:35px;font-size:16px">主辦單位：財團法人中華民國對外貿易發展協會</div>                                
                                    <div class="col" style="line-height:35px;font-size:16px">協辦單位：台灣自行車輸出業同業公會</div>                                                           
                                </div>
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary btn" onclick="location.href='<?=base_url() ?>mgr/exhibit/';">離開</button>
                                </div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $(document).ready(function($) {
        $(".select2").select2();
    });
</script>

</body>

</html>
