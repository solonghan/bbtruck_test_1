<!DOCTYPE html>
<html>

<head>
    <? include("header.php"); ?>
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
                                <div class="pull-right row">
                                    <div class="col-lg-3 col-md-4 col-sm-12 pull-right">
                                        <div class="input-group form-inline">
                                            <input type="text" class="form-control search">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default search_action" type="button">搜尋</button>
                                                <button class="btn btn-default search_clear" type="button">清空</button>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <table class="table horizontal_table table-striped" id="data_table">
                                    <thead>
                                    <tr>
                                        <? 
                                            foreach ($th_title as $t) {
                                                echo '<th>'.$t.'</th>';
                                            }
                                        ?>
                                    </tr>
                                    </thead>
                                    <tbody id="content"></tbody>
                                </table>
                                <ul class="pagination page pull-right"></ul>
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
    var page = 1;
    var search = "";
    
    var can_order_column_indedx = [0, 1, 2, 5, 6];
    var default_order_column = 1;
    var order_direction = 'ASC';
    $(document).ready(function () {
        
        $(document).on('click', ".btn-del", function(event) {
            if (!confirm("確定刪除此筆資料嗎?")) return;
            var id = $(this).attr("id").split("_")[1];
            
            $.ajax({
                url: '<?=$action ?>del/" ?>',
                data: {
                    id:id
                },
                type: "POST",
                dataType: "json",
                success: function(msg){
                    if (msg.status) {
                        $("#tr_"+id[1]).fadeTo('fast', 0.5, function() {
                            $(this).remove();
                        });
                    }else{
                    }
                }
            });
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
        });

        $(document).on('click', '.sort_down', function(event) {
            var id = $(this).parent().attr("id").split("_")[1];  
            var sort = parseInt($("#sort_"+id).val());
            sort = sort + 1;
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
    });

    

    function load_data(goto_page){
        page = goto_page;
        $.ajax({
            type: "POST",
            url: "<?=$action ?>data",
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
            },
            failure: function(errMsg) {}
        }); 
    }

    var page_range = 10;
    function generate_page(total_page){
        page = parseInt(page);
        var html = "";
        var first = Math.floor((page-1)/page_range) * page_range + 1;
        console.log(page+" "+total_page+" "+first)
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
