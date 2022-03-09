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
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 首頁
                    </a>
                </li>
                
                <? if ($parent != ""): ?>
                <li ><a href="<?=$parent_link ?>">
                        <i class="fa fa-fw ti-folder"></i> <?=$parent ?>
                    </a>
                </li>
                <? endif; ?>
                <li class="active"><?=$title ?></li>
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
                            <form class="form-horizontal" role="form" method="POST" action="" id="new_form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="input-text" class="col-sm-2 control-label">帳號</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="tag" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input-text" class="col-sm-2 control-label">姓名</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="short_title" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input-text" class="col-sm-2 control-label">職稱</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="title" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input-text" class="col-sm-2 control-label">處別</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="title" value="">
                                        </div>
                                    </div>    
                                    <div class="form-group">
                                        <label for="input-text" class="col-sm-2 control-label">電話</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="title" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input-text" class="col-sm-2 control-label">行動電話</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="title" value="">
                                        </div>
                                    </div>                                                                                                        
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="input-text" class="col-sm-4 control-label">權限群組</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2">
                                                <option>最高權限</option>
                                                <option>展務</option>
                                                <option>組長</option>
                                                <option>專員</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input-text" class="col-sm-4 control-label">負責展代</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" multiple>
                                                <option>FD</option>
                                                <option>AB</option>
                                                <option>BY</option>
                                                <option>CI</option>
                                                <option>DS</option>
                                                <option>AE</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                                


                                <div class="form-group">
                                    <div class="col-sm-12 mx-auto text-center">
                                        <button type="button" onclick="location.href='<?=base_url()."mgr/member"?>'" class="btn btn-md btn-primary submit_btn">新增</button>
                                        <button type="button" onclick="location.href='<?=base_url()."mgr/member"?>'" class="btn btn-md btn-danger submit_btn">取消</button>
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
<!-- begining of page level js -->

<script src="vendors/mark.js/jquery.mark.js" charset="UTF-8"></script>
<script src="vendors/datatablesmark.js/js/datatables.mark.min.js" charset="UTF-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.js"></script>
<script src="js/native-toast.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="vendors/bootstrap-switch/js/bootstrap-switch.js" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        $(document).on('click', ".privilege-assign-member", function(event) {
            $("#privilegeAssignModal").modal("show"); 
        });




        $(".select2").select2();
    });
</script>
</body>

</html>
