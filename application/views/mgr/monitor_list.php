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
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> <?=$title ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                            <h4><i class="ti-calendar"></i> 2020/11/11 | 01:40:32</h4>
                                <div class="row">
                                    <?for($ii=1;$ii<=3;$ii++){?>
                                        <div class="col-md-4">
                                            <div class="row">
                                                
                                                <div class="text-center" style="padding:2px;margin-left:8px;background-color:#F0F0F0">                                            
                                                    <p><img src="<?=base_url()?>dist/images/1.png" width=20%>台灣國際工具機展採購洽談會</p>
                                                                                                    <p>2020/11/11 | 01:00~01:30</p>

                                                </div>    

                                                <?for($i=1;$i<=3;$i++){?>
                                                <table class="table" style="border:1px solid #F0F0F0;padding:2px;margin:5px;">
                                                    <thead style="background-color:orange;color:white;" >
                                                        <th colspan="2" class="text-center">Table01 <a href="<?=base_url()?>mgr/webex" style="color:black"><i class="menu-icon ti-link" style="font-weight:bold;font-size:18px;"></i></a></th>
                                                    </thead>
                                                    <tbody class="text-center">
                                                        <tr>
                                                            <td>Buyer</td>
                                                            <td><button class="btn btn-success btn-xs edit-btn">Online</button></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Exhibitor</td>
                                                            <td><button class="btn btn-primary btn-xs edit-btn">Offline</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <?}?>
                                                
                                                    
                                                
                                            </div>
                                        
                                        </div>
                                    <?}?>                                                            
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
<!-- begining of page level js -->

<script src="vendors/mark.js/jquery.mark.js" charset="UTF-8"></script>
<script src="vendors/datatablesmark.js/js/datatables.mark.min.js" charset="UTF-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.js"></script>
<script src="js/native-toast.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="vendors/bootstrap-switch/js/bootstrap-switch.js" type="text/javascript"></script>


</body>

</html>
