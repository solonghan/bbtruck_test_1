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
    <link href="vendors/iCheck/css/all.css" rel="stylesheet">
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
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <? if (isset($parent) && $parent != ""): ?>
                <li ><a href="<?=$parent_link ?>">
                        <i class="fa fa-fw ti-folder"></i> <?=$parent ?>
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
                    <h4>選擇展覽：</h4>
                    <select class="form-control select2" multiple>
                        <option>FD┃所有美食展</option>
                        <option selected>FD_2020┃2020美食展</option>
                        <? for ($i=2021; $i <=2030 ; $i++): ?>
                            <option>FD_<?=$i ?>┃<?=$i ?>美食展</option>
                        <? endfor; ?>
                        <option>BY┃所有腳踏車零件展</option>
                        <option selected>BY_2020┃2020腳踏車零件展</option>
                        <? for ($i=2021; $i <=2030 ; $i++): ?>
                            <option>BY_<?=$i ?>┃<?=$i ?>腳踏車零件展</option>
                        <? endfor; ?>
                    </select>
                </div>
                <div class="col-lg-12 col-xs-12">
                    <h4>設定各展覽權限：</h4>
                </div>
                <?
                    $exhibit = ["FD_2020┃2020美食展", "BY_2020┃腳踏車零件展"];
                    foreach ($exhibit as $e):
                ?>
                <div class="col-lg-12 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title m-t-6">
                                <i class="ti-view-list"></i> <?=$e ?>
                                <span class="pull-right">
                                    <i class="fa fa-fw ti-angle-up clickable"></i>
                                </span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="m-t-10">
                                <table class="table horizontal_table table-striped" id="data_table">
                                    <thead>
                                    <tr>
                                        <th>菜單/功能</th>
                                        <th>瀏覽</th>
                                        <th>新增</th>
                                        <th>編輯</th>
                                        <th>刪除</th>
                                        <th>匯出</th>
                                        <th>其它</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                        <?
                                            $item = array(
                                                // "home1"          =>  array("廠商現場報到", "ti-folder", 0),
                                                // "home2"          =>  array("買主現場報到", "ti-folder", 0),
                                                // "home3"          =>  array("異動作業", "ti-folder", 0),
                                                // "home4"          =>  array("報表查詢", "ti-folder", 0),
                                                // "home5"          =>  array("位置圖", "ti-folder", 0),
                                                // "hr"    =>  array(),
                                                "exhibit"         =>  array("Event列表", "ti-package", 0),
                                                "meeting"         =>  array("採洽會議管理", "ti-folder", 0,
                                                    array(
                                                        "meeting/add"     =>  array("新增會議", "ti-package", 0),
                                                        "meeting"         =>  array("會議列表", "ti-package", 0),
                                                        "meeting/session" =>  array("會議場次維護", "ti-package", 0),
                                                        "schedule"  =>  array("與會人員管理", "ti-package", 0),
                                                        // "exhibit/import"  =>  array("匯入", "ti-package", 0),
                                                    )
                                                ),
                                                "buyer"         =>  array("買主資料管理", "ti-folder", 0,
                                                    array(
                                                        "buyer/add"         =>  array("新增買主", "ti-package", 0),
                                                        "buyer/list" =>  array("買主列表", "ti-package", 0),
                                                        "buyer/session"    =>  array("買主資料審核", "ti-package", 0),
                                                        // "buyer/import"    =>  array("買主資料匯入", "ti-package", 0),
                                                    )
                                                ),
                                                "vender"         =>  array("廠商資料管理", "ti-folder", 0,
                                                    array(
                                                        "vender/add"         =>  array("新增廠商", "ti-package", 0),
                                                        "vender/list" =>  array("廠商列表", "ti-package", 0),
                                                        "vender/session"    =>  array("廠商資料審核", "ti-package", 0),
                                                        // "vender/import"    =>  array("廠商資料匯入", "ti-package", 0),
                                                    )
                                                ),
                                                "emeeting"         =>  array("視訊會議管理", "ti-folder", 0,
                                                    array(
                                                        "emeeting/cisco" =>  array("Cisco Webex", "ti-package", 0),
                                                        "emeeting/list"  =>  array("視訊會議列表", "ti-package", 0)
                                                    )
                                                ),
                                                "quest"         =>  array("問卷資料管理", "ti-folder", 0,
                                                    array(
                                                        "quest/add"    =>  array("新增問卷", "ti-package", 0),
                                                        "quest/list"   =>  array("問卷列表", "ti-package", 0),
                                                        "quest/cron"   =>  array("問卷派送及排程", "ti-package", 0),
                                                        "quest/answer" =>  array("問卷答案管理", "ti-package", 0)
                                                    )
                                                ),
                                                "mail"         =>  array("信件管理", "ti-folder", 0,
                                                    array(
                                                        "quest/add" =>  array("新增信件範本", "ti-package", 0),
                                                        "quest/list" =>  array("信件範本列表", "ti-package", 0),
                                                        "quest/cron" =>  array("信件派送與排程", "ti-package", 0),
                                                        "quest/log" =>  array("信件LOG", "ti-package", 0)
                                                    )
                                                ),
                                                "report"         =>  array("報表查詢", "ti-folder", 0,
                                                    array(
                                                        "quest/add" =>  array("報表1", "ti-package", 0),
                                                        "quest/list" =>  array("報表2", "ti-package", 0)
                                                    )
                                                ),
                                                "priv"         =>  array("帳號權限管理", "ti-folder", 0,
                                                    array(
                                                        "member" =>  array("帳號管理", "ti-package", 0),
                                                        "priv"   =>  array("權限管理", "ti-package", 0)
                                                    )
                                                )
                                                
                                            );
                                            foreach ($item as $key => $category) {
                                                echo '<tr><td><strong>'.$category[0].'</strong></td>';
                                                for ($i=0; $i < 6; $i++) { 
                                                    if ($i < 1) {
                                                        echo '<td><input type="checkbox"></td>';    
                                                    }else{
                                                        echo '<td></td>';
                                                    }
                                                    
                                                }
                                                echo '</tr>';
                                                if (array_key_exists(3, $category) && is_array($category[3])) {
                                                    foreach ($category[3] as $key => $classify) {
                                                        echo '<tr><td>&nbsp;∟&nbsp;'.$classify[0].'</td>';
                                                        for ($i=0; $i < 6; $i++) { 
                                                            echo '<td><input type="checkbox" checked></td>';
                                                        }
                                                        echo '</tr>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <ul class="pagination page pull-right"></ul>
                            </div>
                        </div>
                    </div>
                </div>
                <? endforeach; ?>
            </div>
            <div class="background-overlay"></div>
        </section>
        <!-- /.content -->
    </aside>
</div>



<!-- template add Modal -->
<div class="modal fade" id="privilegeAssignModal" role="dialog" aria-labelledby="modalLabel" tabindex="-1">
  <div class="modal-dialog" role="document" style="width: 800px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">指派人員 群組名稱：<span class="pri_name">最高權限</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </h5>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-12" style="display: inline-flex; line-height: 28px;">
                選擇人員： 
                <select  class="form-control select2" style="width: 220px;">
                    <option value="">王大明</option>
                    <option value="">江金沙</option>
                    <option value="">劉奕如</option>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button class="btn btn-info btn-xs" id="" style="height: 28px; line-height: 18px;">加入</button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table id="coin_log_table" class="table table-striped dataTable no-footer">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>姓名</th>
                            <th>帳號</th>
                            <th>職稱</th>
                            <th>單位/資訊</th>
                            <th>加入時間</th>
                            <td>動作</td>
                        </tr>
                    </thead>
                    <tbody id="">
                        <tr>
                            <td>1</td>
                            <td>王小明</td>
                            <td>Wangmin</td>
                            <td>專員</td>
                            <td>主計處</td>
                            <td>2020-09-01<br>15:34:21</td>
                            <td><button class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button></td>
                        </tr>

                        <tr>
                            <td>1</td>
                            <td>蕭英山</td>
                            <td>eishan</td>
                            <td>展務</td>
                            <td>展覽處<br>(02)2245-3563</td>
                            <td>2020-09-04<br>12:43:11</td>
                            <td><button class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">關閉</button>
        <!-- <button id="template_save" type="button" class="btn btn-primary" data-dismiss="modal">儲存</button> -->
      </div>
    </div>
  </div>
</div>
<!-- template add Modal -->

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
<script type="text/javascript" src="vendors/iCheck/js/icheck.js"></script>
<script>
    var page = 1;
    var search = "";
    
    var can_order_column_indedx = <?=json_encode($can_order_fields) ?>;
    var default_order_column = <?=$default_order_column ?>;
    var order_direction = '<?=$default_order_direction ?>';
    $(document).ready(function () {
        $(document).on('click', ".privilege-assign-member", function(event) {
            $("#privilegeAssignModal").modal("show"); 
        });


        $("input").iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '80%'
        });
        

        $(".select2").select2();
        //Delete Action
        $(document).on('click', ".del-btn", function(event) {
            if (!confirm("確定刪除此筆資料嗎?")) return;
            var id = $(this).closest('tr').attr("data-id");
            
            $.ajax({
                url: '<?=$action ?>del',
                data: {
                    id:id
                },
                type: "POST",
                dataType: "json",
                success: function(msg){
                    if (msg.status) {
                        $("tr[data-id="+id+"]").fadeTo('fast', 0.5, function() {
                            $(this).remove();
                        });
                    }
                }
            });
        });
        
        //Edit Action
        $(document).on('click', ".edit-btn", function(event) {
            var id = $(this).closest('tr').attr("data-id");
            location.href = '<?=$action ?>edit/'+id;
        });

        generate_order();
        load_data(page);

        $(".search").on('keypress', function(event) {
            if( event.which == 13 ){
                search = $(".search").val();
                load_data(1);
            }
        });

        $(".search_action").on('click', function(event) {
            search = $(".search").val();
            load_data(1);
        });

        $(".search_clear").on('click', function(event) {
            search = "";
            $(".search").val("");
            load_data(1);   
        });

        $(document).on('keypress', '.curpage', function(event) {
             if( event.which == 13 && $.isNumeric($(this).val())){
                load_data(parseInt($(this).val()));
            }
        });

        $(document).on('click', '.sort_up', function(event) {
            var id = $(this).parent().attr("id").split("_")[1];
            var sort = parseInt($("#sort_"+id).val());
            sort = sort - 1;
            sort = (sort <= 0)?1:sort;
            sort_action(id, sort);
        });

        $(document).on('click', '.sort_down', function(event) {
            var id = $(this).parent().attr("id").split("_")[1];  
            var sort = parseInt($("#sort_"+id).val());
            sort = sort + 1;
            sort_action(id, sort);
        });

        $(document).on('click', '.order_btn', function(event) {
            var selected_index = $(this).attr("data-index");
            if (selected_index == default_order_column) {
                if (order_direction == "DESC") {
                    order_direction = "ASC";
                }else{
                    order_direction = "DESC";
                }
            }else{
                default_order_column = selected_index;
                order_direction = "DESC";
            }
            $("#data_table").find('th').each(function(index, el) {
                if (can_order_column_indedx.indexOf(index) != -1) {
                    if (index == default_order_column) {
                        if (order_direction == "DESC") {
                            $(this).find("button").html('<span class="glyphicon glyphicon-sort-by-attributes-alt"></span>');
                        }else{
                            $(this).find("button").html('<span class="glyphicon glyphicon-sort-by-attributes"></span>');
                        }
                    }else{
                        $(this).find("button").html('<span class="glyphicon glyphicon-sort"></span>');
                    }
                } 
            });
            load_data(page);
        });

        $(document).on('click', '.ajax_update', function(event) {
            var id = $(this).attr("id").split("_")[1];
            var action = $(this).attr("data-action");

            var formData = new FormData();
            $("#tr_"+id).find('.edit_field').each(function(index, el) {
                formData.append($(this).attr("name"), $(this).val());
            }); 
            $.ajax({
                type: "POST",
                url: action,
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(data){
                    if (data.status) {
                        nativeToast({
                            message: '更新成功',
                            type: 'success',
                            position: 'top',
                            square: true,
                            edge: false,
                            debug: false
                        });
                    }else{
                        nativeToast({
                            message: data.msg,
                            type: 'danger',
                            position: 'top',
                            square: true,
                            edge: false,
                            debug: false
                        });
                    }
                },
                failure: function(errMsg) {}
            }); 
        });
    });

    function sort_action(id, sort){
        $.ajax({
            type: "POST",
            url: "<?=$action ?>sort",
            data: {
                id: id,
                sort: sort
            },
            dataType: "json",
            success: function(data){
                if (data.status) {
                    load_data(page);
                }
            },
            failure: function(errMsg) {}
        }); 
    }    

    function load_data(goto_page){
        page = goto_page;
        $.ajax({
            type: "POST",
            url: "<?=(isset($custom_data_url))?$custom_data_url:$action.'data' ?>",
            data: {
                page: page,
                search: search,
                order: default_order_column,
                direction: order_direction
            },
            dataType: "json",
            success: function(data){
                if (data.status) {
                    $("#content").html(data.html);
                    page = parseInt(data.page);
                    generate_page(data.total_page);
                    $(".curpage").val(page);
                }
                // $(".select2").select2().on('change.select2', function(event) {
                //     var id = $(this).parent().attr("id").split("_")[1];
                //     var sort = $(this).val();
                //     sort_action(id, sort);
                // });
                $('.status_switcher').bootstrapSwitch({
                    onText: "開啟",
                    offText: "關閉",
                    onSwitchChange: function(e, state) {
                        var id = $(this).closest('tr').attr("data-id");
                        var status = (state)?1:0;
                        $.ajax({
                            type: "POST",
                            url: "<?=(isset($custom_data_url))?$custom_data_url:$action.'switch_toggle' ?>",
                            data: {
                                id: id,
                                status: status
                            },
                            dataType: "json",
                            success: function(data){
                                
                            }
                        });
                    }
                });
            },
            failure: function(errMsg) {}
        }); 
    }

    var page_range = 10;
    function generate_page(total_page){
        page = parseInt(page);
        var html = "";
        var first = Math.floor((page-1)/page_range) * page_range + 1;
        if (page == 1) {
            html = '<li class="paginate_button previous disabled"><a href="javascript:;">Previous</a></li>';
        }else{
            html ='<li class="paginate_button previous"><a href="javascript:load_data('+(page-1)+');">Previous</a></li>';
        }

        for (var i = first; i < first + page_range && i <= total_page ; i++) {
            html += '<li class="paginate_button ';
            if(i == page) html += ' active';
            html += '"><a href="javascript:load_data('+i+');">'+i+'</a></li>';
        }

        if (page == total_page) {
            html += '<li class="paginate_button next disabled"><a href="javascript:;">Next</a></li>';
        }else{
            html += '<li class="paginate_button next"><a href="javascript:load_data('+(page+1)+');">Next</a></li>';
        }

        if (page != total_page) {
            html += '<li class="paginate_button last"><a href="javascript:load_data('+(total_page)+');">Last('+total_page+')</a></li>';
        }

        html += '<li class="paginate_button last"><a href="javascript:;" style="padding:0;"><input type="text" class="form-control curpage" style="width:56px; height:30px; border:0; text-align:center;" value="1"></a></li>';

        $(".page").html(html);
    }

    function generate_order(){
        $("#data_table").find('th').each(function(index, el) {
            if (can_order_column_indedx.indexOf(index) != -1) {
                if (index == default_order_column) {
                    $(this).append(
                        $("<button/>").addClass('btn order_btn btn-sm pull-right').css({
                            width: '16px',
                            height: '16px',
                            padding: 0
                        })
                        .html('<span class="glyphicon glyphicon-sort-by-attributes'+((order_direction == "DESC")?'-alt':'')+'"></span>')
                        .attr("data-index", index)
                    );
                }else{
                    $(this).append(
                        $("<button/>").addClass('btn order_btn btn-sm pull-right').css({
                            width: '16px',
                            height: '16px',
                            padding: 0
                        }).html('<span class="glyphicon glyphicon-sort"></span>')
                        .attr("data-index", index)
                    );
                }
            } 
        });
    }
</script>
</body>

</html>
