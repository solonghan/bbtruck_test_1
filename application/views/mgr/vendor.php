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


</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                廠商合作
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li class="active">廠商合作
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
                                <i class="ti-view-list"></i> 廠商合作
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                                <table class="table horizontal_table table-striped" id="showtable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>公司名</th>
                                        <th>聯絡資訊</th>
                                        <th>合作產品</th>
                                        <th>產地</th>
                                        <th>預算</th>
                                        <th>自有系統</th>
                                        <th>支援地區</th>
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
                                            <?
                                                echo $item['name'];
                                            ?>
                                        </td>
                                        <td><?=$item['contact_name']." ".$item['contact_nickname']."<br>".$item['contact_phone'] ?></td>
                                        <td><?=$item['product_type']."<br>".$item['product_name'] ?></td>
                                        <td><?=$item['product_origin'] ?></td>
                                        <td>$<?=$item['cost'] ?></td>
                                        <td><?=($item['exist_system']==1)?"有":"無" ?></td>
                                        <td><?=$item['support_area'] ?></td>
                                        <td style="width: 50px;" id="status_<?=$item['id'] ?>">
                                            <?
                                                if ($item['status'] == "new") {
                                                    echo '<span class="text text-danger">最新</span>';
                                                }else if ($item['status'] == "processed") {
                                                    echo '<span class="text text-muted">已處理</span>';
                                                }
                                            ?>
                                        </td>
                                        <td><?=$item['create_date'] ?></td>
                                        <td style="width:10%;" id="action_<?=$item['id'] ?>">
                                            <? if ($item['status'] == "new") : ?>
                                            <button class="btn btn-success btn-xs proccessed" id="processed_<?=$item['id'] ?>">標記為已處理</button>
                                            <? endif; ?>
                                            <!-- <button onclick="location.href='<?=base_url()."mgr/user/status/".$item['UserId']."/close" ?>'" class="btn btn-danger btn-xs"><span class="fa fa-fw fa-minus-square-o"></span></button> -->
                                            
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

<script src="vendors/toastr/js/toastr.min.js"></script>

<script>
    toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": false,
          "progressBar": false,
          "positionClass": "toast-bottom-full-width",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "1000",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "swing",
          "showMethod": "show"
        };
    $(document).ready(function () {
        window.onload = function () {
            $(function () {
                var inputMapper = {
                    // "name": 1,
                    // "idnumber": 2,
                    // "phone": 4,
                    // "social": 5,
                    // "introducer": 7
                };

                dtInstance = $("#showtable").DataTable({
                    "lengthMenu": [25, 50, 100],
                    "responsive": true,
                    // bLengthChange: true,
                    "pageLength": 25,
                    bLengthChange: false,
                    info: false,
                    mark: true,
                    "order": [[0, "desc"]],
                    columnDefs: [
                        { targets: [10], orderable: false},
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

        $(".proccessed").on('click', function(event) {
            var id = $(this).attr("id").split("_");
            $.ajax({
                url: "<?= base_url() ?>mgr/vendor/proccessed",
                data: {
                    id: id[1]
                },
                type: "POST",
                dataType: "json",
                success: function(msg){
                    if (msg.status == 100) {
                        $("#action_"+id[1]).html("");
                        $("#status_"+id[1]).html('<span class="text text-muted">已處理</span>');
                    }
                },
                error:function(xhr, ajaxOptions, thrownError){ 
                    alert(xhr.status); 
                    alert(thrownError); 
                },
                complete:function(){
                    $(".service_items .loading_item").remove();
                    
                }
            });
        });

    });    
</script>
</body>

</html>
