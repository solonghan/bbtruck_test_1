<!DOCTYPE html>
<html>

<head>
    <? include("header.php"); ?>
    <link href="vendors/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="vendors/select2/css/select2-bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.css" />
    
    <link rel="stylesheet" href="vendors/datetime/css/jquery.datetimepicker.css">
    <link href="vendors/airdatepicker/css/datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="css/native-toast.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/custom_css/toastr_notificatons.css">

    <link href="vendors/iCheck/css/all.css" rel="stylesheet">
    <style>
        .table td{
            border: 0 !important;
            height: 34px !important;
            line-height: 34px !important;
            font-size: 14px;
        }
        .table input{
            height: 34px;
            line-height: 34px;
        }
        .table td:first-child{
            text-align: right;
            width: 90px;
        }

        #content td{
            font-size: 16px;
        }

        .filter{
            margin: 0 4px;
            color: #333;
            cursor: pointer;
        }

        .filter:hover,
        .filter.active{
            color: #E94;
        }

        .select2-selection.select2-selection--single{
            height: 34px;
        }


        /* time range */
        #time-range p {
            font-family:"Arial", sans-serif;
            font-size:14px;
            color:#333;
        }
        .ui-slider-horizontal {
            height: 8px;
            background: #D7D7D7;
            border: 1px solid #BABABA;
            box-shadow: 0 1px 0 #FFF, 0 1px 0 #CFCFCF inset;
            clear: both;
            margin: 8px 0;
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            -ms-border-radius: 6px;
            -o-border-radius: 6px;
            border-radius: 6px;
        }
        .ui-slider {
            position: relative;
            text-align: left;
        }
        .ui-slider-horizontal .ui-slider-range {
            top: -1px;
            height: 100%;
        }
        .ui-slider .ui-slider-range {
            position: absolute;
            z-index: 1;
            height: 8px;
            font-size: .7em;
            display: block;
            border: 1px solid #5BA8E1;
            box-shadow: 0 1px 0 #AAD6F6 inset;
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            -khtml-border-radius: 6px;
            border-radius: 6px;
            background: #81B8F3;
            background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgi…pZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
            background-size: 100%;
            background-image: -webkit-gradient(linear, 50% 0, 50% 100%, color-stop(0%, #A0D4F5), color-stop(100%, #81B8F3));
            background-image: -webkit-linear-gradient(top, #A0D4F5, #81B8F3);
            background-image: -moz-linear-gradient(top, #A0D4F5, #81B8F3);
            background-image: -o-linear-gradient(top, #A0D4F5, #81B8F3);
            background-image: linear-gradient(top, #A0D4F5, #81B8F3);
        }
        .ui-slider .ui-slider-handle {
            border-radius: 50%;
            background: #F9FBFA;
            background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgi…pZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
            background-size: 100%;
            background-image: -webkit-gradient(linear, 50% 0, 50% 100%, color-stop(0%, #C7CED6), color-stop(100%, #F9FBFA));
            background-image: -webkit-linear-gradient(top, #C7CED6, #F9FBFA);
            background-image: -moz-linear-gradient(top, #C7CED6, #F9FBFA);
            background-image: -o-linear-gradient(top, #C7CED6, #F9FBFA);
            background-image: linear-gradient(top, #C7CED6, #F9FBFA);
            width: 22px;
            height: 22px;
            -webkit-box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
            -moz-box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
            box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
            -webkit-transition: box-shadow .3s;
            -moz-transition: box-shadow .3s;
            -o-transition: box-shadow .3s;
            transition: box-shadow .3s;
        }
        .ui-slider .ui-slider-handle {
            position: absolute;
            z-index: 2;
            width: 22px;
            height: 22px;
            cursor: default;
            border: none;
            cursor: pointer;
        }
        .ui-slider .ui-slider-handle:after {
            content:"";
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            top: 50%;
            margin-top: -4px;
            left: 50%;
            margin-left: -4px;
            background: #30A2D2;
            -webkit-box-shadow: 0 1px 1px 1px rgba(22, 73, 163, 0.7) inset, 0 1px 0 0 #FFF;
            -moz-box-shadow: 0 1px 1px 1px rgba(22, 73, 163, 0.7) inset, 0 1px 0 0 white;
            box-shadow: 0 1px 1px 1px rgba(22, 73, 163, 0.7) inset, 0 1px 0 0 #FFF;
        }
        .ui-slider-horizontal .ui-slider-handle {
            top: -.5em;
            margin-left: -.6em;
        }
        .ui-slider a:focus {
            outline:none;
        }
        /* time range */
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
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title m-t-6">
                                <i class="ti-view-list"></i> 篩選條件
                                <span class="pull-right">
                                    <i class="fa fa-fw ti-angle-up clickable"></i>
                                </span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td><strong>日期:</strong></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <? foreach ($content as $day => $data): ?>
                                                <button class="btn btn-md btn-default day-filter"><?=$day ?></button>
                                                <? endforeach; ?>  
                                            </div>
                                            <div class="col-md-6 col-sm-12" style="display: inline-flex;">
                                                關鍵字:&nbsp;&nbsp;&nbsp;<input type="text" class="form-control" placeholder="買家名稱、廠商名稱、桌次..等" style="width: 80%;">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>時間:</strong></td>
                                    <td>
                                        <div id="time-range">
                                            <span class="slider-time">10:00</span> - <span class="slider-time2">17:00</span>
                                            <div class="sliders_step1">
                                                <div id="slider-range"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td><strong>買主:</td>
                                    <td style="">
                                        <div style="display: inline-flex;">
                                            <select class="form-control select2" style="width: 160px;" id="create_by">
                                                <option value="0">不拘</option>
                                                <option>Terry Wang</option>
                                                <option></option>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong>廠商:</strong>&nbsp;&nbsp;
                                            <select class="form-control select2" style="width: 160px;" id="close_by">
                                                <option value="0">不拘</option>
                                                <option>王大明</option>
                                                <option>廖添丁</option>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong>類型:</strong>&nbsp;&nbsp;
                                            <select class="form-control select2" style="width: 160px;" id="close_by">
                                                <option value="0">不拘</option>
                                                <option>現場</option>
                                                <option>視訊</option>
                                            </select>
                                        </div>
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-primary search_action" style="width: 120px;">搜尋</button>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <button type="button" class="btn btn-default pull-right reset_action" style="width: 90px;">清空</button>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xs-12">
                    <div class="m-t-10">
                        <table class="table horizontal_table table-striped" id="data_table">
                            <thead>
                            <tr>
                                <?  
                                    $index = 0;
                                    foreach ($th_title as $t) {
                                        echo '<th';
                                        if ($th_width[$index] != "") {
                                            echo ' style="width:'.$th_width[$index].'";';
                                        }
                                        echo '>'.$t.'</th>';
                                        $index++;
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

<script src="vendors/datetime/js/jquery.datetimepicker.full.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.en.js" type="text/javascript"></script>

<script type="text/javascript" src="vendors/iCheck/js/icheck.js"></script>

<script>
    var language = {
        daysMin: ['日', '一', '二', '三', '四', '五', '六'],
        months: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
        monthsShort: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
        dateFormat: 'yyyy-mm-dd',
        timeFormat: 'hh:ii:00',
        firstDay: 0
    };

    var page = 1;
    var city = JSON.parse('<?=json_encode($city) ?>');
    
    var can_order_column_indedx = <?=json_encode($can_order_fields) ?>;
    var default_order_column = <?=$default_order_column ?>;
    var order_direction = '<?=$default_order_direction ?>';
    $(document).ready(function () {
        $(document).find('.day-filter').each(function(index, el) {
            if (index == 0) $(this).removeClass('btn-default').addClass('btn-primary');
        });
        $(".day-filter").on('click', function(event) {
            $(document).find('.day-filter').each(function(index, el) {
                $(this).removeClass('btn-primary').addClass('btn-default');
            });  
            $(this).removeClass('btn-default').addClass('btn-primary');
        });

        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 1410,
            step: 30,
            values: [600, 17*60],
            slide: function (e, ui) {
                var hours1 = Math.floor(ui.values[0] / 60);
                var minutes1 = ui.values[0] - (hours1 * 60);

                if (hours1.length == 1) hours1 = '0' + hours1;
                if (minutes1.length == 1) minutes1 = '0' + minutes1;
                if (minutes1 == 0) minutes1 = '00';
                if (hours1 >= 12) {
                    if (hours1 == 12) {
                        hours1 = hours1;
                        minutes1 = minutes1;// + " PM";
                    } else {
                        /* hours1 = hours1 - 12 */;
                        minutes1 = minutes1;// + " PM";
                    }
                } else {
                    hours1 = hours1;
                    minutes1 = minutes1;// + " AM";
                }
                if (hours1 == 0) {
                    // hours1 = 12;
                    minutes1 = minutes1;
                }



                $('.slider-time').html(hours1 + ':' + minutes1);

                var hours2 = Math.floor(ui.values[1] / 60);
                var minutes2 = ui.values[1] - (hours2 * 60);

                if (hours2.length == 1) hours2 = '0' + hours2;
                if (minutes2.length == 1) minutes2 = '0' + minutes2;
                if (minutes2 == 0) minutes2 = '00';
                if (hours2 >= 12) {
                    if (hours2 == 12) {
                        hours2 = hours2;
                        minutes2 = minutes2;// + " PM";
                    } else if (hours2 == 24) {
                        hours2 = 23;
                        // minutes2 = "59 PM";
                        minutes2 = "30";
                    } else {
                        // hours2 = hours2 - 12;
                        minutes2 = minutes2;// + " PM";
                    }
                } else {
                    hours2 = hours2;
                    minutes2 = minutes2;// + " AM";
                }

                $('.slider-time2').html(hours2 + ':' + minutes2);
            }
        });




        $(".select2").select2();
        $("input").iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '80%'
        });
        $('.daypicker').datepicker({
            language: language,
            position: "bottom left",
            autoClose: true
        });   
        $("input").on('keydown', function(e) {
            code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) load_data(1);
        });
        $(document).on('click', ".del-btn", function(event) {
            if (!confirm("確定刪除此筆資料嗎?")) return;
            var id = $(this).attr("id").split("_")[1];
            
            $.ajax({
                url: '<?=$action ?>del',
                data: {
                    id:id
                },
                type: "POST",
                dataType: "json",
                success: function(msg){
                    if (msg.status) {
                        $("#case_"+id).fadeTo('fast', 0.5, function() {
                            $(this).remove();
                        });
                    }
                }
            });
        });

        generate_order();
        load_data(page);

        $(".search_action").on('click', function(event) {
            load_data(1);
        });

        $(".reset_action").on('click', function(event) {
            var default_city = 0;
            $(document).find("[data-related=city]").each(function(index, el) {
                if (index == default_city)
                    $(this).addClass('active');
                else
                    $(this).removeClass('active');
            });
            generate_dist(default_city);
            $(document).find("[data-related=use]").each(function(index, el) {
                if (index == 0)
                    $(this).addClass('active');
                else
                    $(this).removeClass('active');
            });
            $("select[name=pattern_room]").val(1);
            $("select[name=pattern_hall]").val(1);
            $("select[name=pattern_bath]").val(1);
            $("input[name=front_balcony]").iCheck('uncheck');
            $("input[name=back_balcony]").iCheck('uncheck');

            $("#rent_start").val('');
            $("#rent_end").val('');
            $("#addr").val('');
            $("#create_by").val(0).trigger('change');
            $("#close_by").val(0).trigger('change');
            $("#create_date").val('');

            load_data(1);
        });

        $(document).on('keypress', '.curpage', function(event) {
             if( event.which == 13 && $.isNumeric($(this).val())){
                load_data(parseInt($(this).val()));
            }
        });

        $(document).on('click', '.num_minus', function(event) {
            var id = $(this).parent().attr("id").split("_")[1];
            var num = parseInt($("#select_"+id).val());
            num = num - 1;
            num = (num < 0)?0:num;
            $("#select_"+id).val(num);
        });

        $(document).on('click', '.num_plus', function(event) {
            var id = $(this).parent().attr("id").split("_")[1];  
            var num = parseInt($("#select_"+id).val());
            var total = parseInt($(this).closest('.pattern').attr("data-max"));
            num = num + 1;
            num = (num >= total)?total:num;
            $("#select_"+id).val(num);
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

        $(document).on('click', '.filter', function(event) {
            var related = $(this).attr("data-related");
            if (!$(this).hasClass('filter-multi')) {
                $(document).find("[data-related="+related+"]").each(function(index, el) {
                    $(this).removeClass('active');
                });
                $(this).addClass('active');
            }else{
                if ($(this).attr("data-id") == "all") {
                    $(document).find("[data-related="+related+"]").each(function(index, el) {
                        if(index != 0) $(this).removeClass('active');
                    });    
                }else{
                    $(document).find("[data-related="+related+"]").each(function(index, el) {
                        if(index == 0) $(this).removeClass('active');
                    });    
                }
                
                if ($(this).hasClass('active')) 
                    $(this).removeClass('active');
                else
                    $(this).addClass('active');
            }

            if (related == "city") {
                generate_dist($(this).attr("data-index"));
            }
        });
    }); 

    function generate_dist(city_index){
        $("#dist_area").empty();
        $("#dist_area").append('<a class="filter filter-multi active" data-related="dist" data-id="all">全區</a>');
        for (var i = 0; i < city[city_index]['dist'].length; i++) {
            var d = city[city_index]['dist'][i];
            $("#dist_area").append('&nbsp;<a class="filter filter-multi" data-related="dist" data-id="'+d['c3']+'">'+d['name']+'</a>');
        }
    }

    function load_data(goto_page){
        page = goto_page;

        $.ajax({
            type: "POST",
            url: "<?=base_url() ?>mgr/schedule/data",
            data: {
                page: page,
                order: default_order_column,
                direction: order_direction,
            },
            dataType: "json",
            success: function(data){
                if (data.status) {
                    if (data.html != "") {
                        $("#content").html(data.html);
                    }else{
                        $("#content").html("<tr><td colspan='<?=count($th_title) ?>' style='text-align:center; color:#944;'>查無資料</td></tr>");
                    }
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
