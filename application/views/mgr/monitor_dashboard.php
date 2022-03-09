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
            <? foreach ($tool_btns as $item): ?>
            <button class="pull-right btn btn-md <?=$item[2] ?>" style="margin-top: -20px; margin-right: 25px;" onclick="location.href='<?=$item[1] ?>';"><?=$item[0] ?></button>
            <? endforeach; ?>
            <h5 class="pull-right" style="margin-top: -20px; margin-right: 40px; display: inline-flex;">
                <div>
                    Current Time: <strong class="current_time" style="font-size: 16px;"></strong>
                </div>
                <div class="dropdown user-menu" style="margin-left: 10px;">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span>GMT +8 <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <? for ($i=0; $i <= 26; $i++): ?>
                        <li><a href="javascript:void(0)">GMT <?=$i - 13 ?></a></li>
                        <? endfor; ?>
                    </ul>

                </div>        
            </h5>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 首頁
                    </a>
                </li>
                <? if (isset($parent) && $parent != ""): ?>
                <li ><a href="<?=$parent_link ?>">
                        <?=$parent ?>
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
                                <div class="row">
                                    <?for($ii=1;$ii<=3;$ii++){?>
                                        <div class="col-md-3 col-sm-6">
                                            <div class="panel">
                                                <div class="social">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div class="text-center animated-background-success bg-success" style="padding: 10px; font-size: 25px;">
                                                                <?=$ii ?>                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 text-center">
                                                            <i class="fa fa-fw fa-cog" style="cursor: pointer; position: absolute; right: 20px; top: 5px;" data-toggle="tooltip" data-original-title="設定"></i>
                                                            <h5 style="font-size: 16px;">1:30</h5>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <div class="info-1 text-center">
                                                                <div style="margin: 5px;"><span class="label label-success">ONLINE</span></div>
                                                                <h4>Alibaba Tech Corp.</h4>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <div class="info-2 text-center">
                                                                <div style="margin: 5px;"><span class="label label-success">ONLINE</div>
                                                                <h4>我懂你生物科技有限公司</h4>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    <?}?>   
                                        <div class="col-md-3 col-sm-6">
                                            <div class="panel">
                                                <div class="social">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div class="text-center bg-danger" style="padding: 10px; font-size: 25px;">
                                                                <?=$ii ?>                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 text-center">
                                                            <i class="fa fa-fw fa-cog" style="cursor: pointer; position: absolute; right: 20px; top: 5px;" data-toggle="tooltip" data-original-title="設定"></i>
                                                            <h5 style="font-size: 16px;">1:30</h5>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <div class="info-1 text-center">
                                                                <div style="margin: 5px;"><span class="label label-success">ONLINE</span></div>
                                                                <h4>Alibaba Tech Corp.</h4>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <div class="info-2 text-center">
                                                                <div style="margin: 5px;"><span class="label label-default">OFFLINE</div>
                                                                <h4>我懂你生物科技有限公司</h4>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    <?for($ii=1;$ii<=3;$ii++){?>
                                        <div class="col-md-3 col-sm-6">
                                            <div class="panel">
                                                <div class="social">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div class="text-center" style="background-color: #EEE; padding: 10px; font-size: 25px;">
                                                                <?=$ii ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 text-center">
                                                            <i class="fa fa-fw fa-cog" style="cursor: pointer; position: absolute; right: 20px; top: 5px;" data-toggle="tooltip" data-original-title="設定"></i>
                                                            <h5 style="font-size: 16px;">2:00</h5>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <div class="info-1 text-center">
                                                                <div style="margin: 5px;"><span class="label label-success">ONLINE</span></div>
                                                                <h4>Alibaba Tech Corp.</h4>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <div class="info-2 text-center">
                                                                <div style="margin: 5px;"><span class="label label-default">OFFLINE</div>
                                                                <h4>我懂你生物科技有限公司</h4>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    <?}?>                                                          
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

<script src="vendors/mark.js/jquery.mark.js" charset="UTF-8"></script>
<script src="vendors/datatablesmark.js/js/datatables.mark.min.js" charset="UTF-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.js"></script>
<script src="js/native-toast.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="vendors/bootstrap-switch/js/bootstrap-switch.js" type="text/javascript"></script>
<script>
    $(document).ready(function($) {
        update_now_time =  setInterval(update_now_time, 1000);
        $(window).on('beforeunload', function(event) {
            clearInterval(update_now_time);
        });
    });

    function update_now_time(){
        $.ajax({
            type: "POST",
            url: '<?=base_url()."mgr/dashboard/now" ?>',
            data: {
            },
            dataType: "json",
            success: function(data){
                if (data.status){
                    $(".current_time").html(data.formatted_time);
                }
            },
            failure: function(errMsg) {
                
            }
        });
    }
</script>

</body>

</html>
