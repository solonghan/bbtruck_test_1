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
                隱藏式活動管理
            </h1>
            <button class="pull-right btn btn-md btn-primary" style="margin-top: -20px; margin-right: 25px;" onclick="location.href='<?=base_url() ?>mgr/activity/add';">新增活動</button>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li class="active">隱藏式活動管理
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
                                <i class="ti-view-list"></i> 隱藏式活動管理
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                                <table class="table horizontal_table table-striped" id="showtable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>紅字標籤</th>
                                        <th>短標題</th>
                                        <th>標題</th>
                                        <th>內容</th>
                                        <th>合作沙龍</th>
                                        <th>建立日期</th>
                                        <th>動作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? for($i=0;$i<count($list);$i++){ $item = $list[$i]; ?>
                                    <tr id="tr_<?=$item['id'] ?>">
                                        <td><?=$item['id'] ?></td>
                                        <td><?=$item['tag'] ?></td>
                                        <td><?=$item['short_title'] ?></td>
                                        <td><?=$item['title'] ?></td>
                                        <td>
                                            <?
                                                if (strpos($item['content'], "<img") !== FALSE) {
                                                    echo "<span class='label label-info'>(圖片)</span>";
                                                }
                                                if (mb_strlen(strip_tags($item['content'])) > 100) {
                                                    echo mb_substr(strip_tags($item['content']), 0, 100)."...";
                                                }else{
                                                    echo strip_tags($item['content']);
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?
                                                foreach ($item['salon'] as $s) {
                                                    echo $s['name']."<br>";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?
                                                echo $item['create_date'];
                                            ?>
                                        </td>
                                        <td style="width:10%;">
                                            <button onclick="location.href='<?=base_url()."mgr/activity/edit/".$item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>
                                            
                                            <!-- <button id="del_<?=$item['id'] ?>" class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button> -->
                                            
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

        $(".del-btn").on('click', function(event) {
            var id = $(this).attr("id").split("_");
            if (confirm("確定要刪除嗎?")) {
                $.ajax({
                    type: "POST",
                    url: '<?=base_url()."mgr/news/del/" ?>',
                    data: {
                        id: id[1]
                    },
                    dataType: "html",
                    success: function(data){
                        if (data == "success") {
                            $("#tr_"+id[1]).fadeOut('400', function() {
                                $(this).remove();
                            });
                        }else{
                            alert("發生錯誤");
                        }
                    },
                    failure: function(errMsg) {
                        alert(errMsg);
                    }
                });
            }
        });
    });    
</script>
</body>

</html>
