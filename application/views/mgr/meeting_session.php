<!DOCTYPE html>
<html>
<head>
    <? include("header.php"); ?>
    <!-- <link rel="stylesheet" href="vendors/swiper/css/swiper.min.css"> -->
    <!-- <link href="vendors/nvd3/css/nv.d3.min.css" rel="stylesheet" type="text/css"> -->
    <!-- <link rel="stylesheet" href="vendors/lcswitch/css/lc_switch.css"> -->
    
    <!-- <link href="css/custom_css/dashboard1_timeline.css" rel="stylesheet"/> -->
    <link href="vendors/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css"/>
    <link href="vendors/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="vendors/select2/css/select2-bootstrap.css" rel="stylesheet" type="text/css">

    <link href="vendors/bootstrap-switch/css/bootstrap-switch.css" rel="stylesheet" type="text/css"/>  
    <link rel="stylesheet" media="screen" type="text/css" href="vendors/summernote/summernote.css">

    <link rel="stylesheet" href="vendors/datetime/css/jquery.datetimepicker.css">
    <link href="vendors/airdatepicker/css/datepicker.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/datepicker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.css" />
    <style>
        table.session{
            /*width: 100%;*/
            margin: 10px;
            border-collapse: collapse;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            table-layout: fixed !important;
        }
        table.session th, table.session td{
            text-align: center;
            border: 1px solid #fdfdfd;
            min-width: 80px;
            padding: 0 6px;
            /*height: 40px;
            line-height: 40px;*/
        }
        table.session th:not(:first-child), table.session td:not(:first-child){
            min-width: 210px;
        }

        table.session  tr:first-child th {
            border-top: 0;
        }
        table.session  tr:last-child td {
            border-bottom: 0;
        }
        table.session  tr td:first-child,
        table.session  tr th:first-child {
            border-left: 0;
        }
        table.session  tr td:last-child,
        table.session  tr th:last-child {
            border-right: 0;
        }
        
        table.session th{
            padding: 0 0 10px 0;
            height: 40px;
            /*line-height: 40px;*/
            color: #333;
            background-color: #EEE;
            width: auto;
            font-size: 18px;
            font-weight: 400;
        }

        table.session tbody td{ 
            background-color: #FEFEFF;
            /*height: 41px;*/
        }
        table.session tr:nth-child(even) td{
            background-color: #F9F9F9;
        }

        .time_btn{
            width: 70px;
            padding: 1px;
            margin: 1px;
            border: 0;
        }
        .type-online{
            background-color: #c1ebfb;
        }
        .type-online:hover,
        .type-online:active,
        .type-online:focus{
            background-color: #92DDFC;
        }
        .type-both{
            background-color: #A173F1;
        }
        .type-both:hover,
        .type-both:active,
        .type-both:focus{
            background-color: #AF87FF;
        }
        .type-disabled{
            background-color: #E9E9EA;
            cursor: no-drop;
        }
        .type-disabled:hover,
        .type-disabled:active,
        .type-disabled:focus{
            background-color: #E5E5E9;
        }
        .select2-selection__rendered{
            font-size: 16px;
        }

        .tooltip-inner {
            min-width: 70px; 
        }


        .table-template{
            border: 2px solid #AAA;
            line-height: 11px;
        }
        .table-template th{
            text-align: center;
            border: 2px solid #AAA;
        }
        .table-template td{
            font-size: 12px !important;
            line-height: 12px !important;
            padding: 3px !important;
            cursor: pointer;
            user-select: none;
            width: 60px;
        }
        .table-template td:nth-child(odd){
            border-left: 2px solid #AAA;
            border-right: 1px solid #DDD;
        }
        .table-template td:nth-child(even){
            border-right: 2px solid #AAA;
            border-left: 1px solid #DDD;
        }

        .table-template-add{
            border: 2px solid #AAA;
            line-height: 11px;
        }
        .table-template-add td{
            font-size: 18px !important;
            line-height: 15px !important;
            padding: 4px !important;
            cursor: pointer;
            user-select: none;
            /*width: 60px;*/
        }
    </style>
</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <section class="content-header">
            <h1>
                會議場次維護
            </h1>
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
        <section class="content" style="overflow-x: auto; height: 100%;">
            
            <div class="row">
                <div class="col-xs-12">
                    &nbsp;&nbsp;<span style="color: #A173F1;">■</span> 現場＆視訊會議
                    &nbsp;&nbsp;<span style="color: #6699cc;">■</span> 現場會議
                    &nbsp;&nbsp;<span style="color: #c1ebfb;">■</span> 視訊會議
                    &nbsp;&nbsp;<span style="color: #E9E9EA;">■</span> 不開放
                </div>
                <div class="col-lg-12 col-xs-12" style="display: flex;">
                    <table class="session">
                        <thead id="time_head">
                            <tr>
                                <th>時間</th>
                                <? foreach ($content as $day => $data): ?>
                                <th>
                                    <? $my->date_show($day); ?><br>
                                    <input data-day="<?=$day ?>" type="checkbox" class="status_switcher" data-size="mini" data-on-color="success" data-off-color="danger"<?=($data['status']=="open")?' checked':'' ?>>
                                    <button class="btn btn-xs btn-warning use_template" data-date="<?=$day ?>">套用範本</button>
                                </th>
                                <? endforeach; ?>
                            </tr>
                        </thead>
                        <tbody id="time_body">
                            <?
                                for ($hour=0; $hour <= 23 ; $hour++) { 
                                    $on_hour = str_pad($hour, 2, '0', STR_PAD_LEFT).":00";
                                    $hour_half = str_pad($hour, 2, '0', STR_PAD_LEFT).":30";

                                    echo '<tr><td>'.$on_hour.'</td>';
                                    foreach ($content as $day => $data) {
                                        echo '<td>';
                                        if ($data['status'] == "close") {
                                            $my->time_btn($on_hour, "type-disabled", $day, $on_hour);
                                            $my->time_btn($hour_half, "type-disabled", $day, $hour_half);
                                        }else if ($data['status'] == "open") {
                                            if (array_key_exists($on_hour, $data['data'])) {
                                                if ($data['data'][$on_hour]['type'] == "both") {
                                                    $my->time_btn($on_hour, "type-both", $day, $on_hour);
                                                }else if ($data['data'][$on_hour]['type'] == "site") {
                                                    $my->time_btn($on_hour, "type-site", $day, $on_hour);
                                                }else if ($data['data'][$on_hour]['type'] == "disabled") {
                                                    $my->time_btn($on_hour, "type-disabled", $day, $on_hour);
                                                }
                                            }else{
                                                $my->time_btn($on_hour, "type-online", $day, $on_hour);
                                            }
                                            //half hour
                                            if (array_key_exists($hour_half, $data['data'])) {
                                                if ($data['data'][$on_hour]['type'] == "both") {
                                                    $my->time_btn($hour_half, "type-both", $day, $hour_half);
                                                }else if ($data['data'][$hour_half]['type'] == "site") {
                                                    $my->time_btn($hour_half, "type-site", $day, $hour_half);
                                                }else if ($data['data'][$hour_half]['type'] == "disabled") {
                                                    $my->time_btn($hour_half, "type-disabled", $day, $hour_half);
                                                }
                                            }else{
                                                $my->time_btn($hour_half, "type-online", $day, $hour_half);
                                            }
                                        }
                                        echo '</td>';
                                    }
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    
    </aside>

</div>

<!-- template Modal -->
<div class="modal fade" id="templateModal" role="dialog" aria-labelledby="modalLabel" tabindex="-1">
  <div class="modal-dialog" role="document" style="width: 800px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">套用範本 <span class="template_date"></span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </h5>
      </div>
      <div class="modal-body" style="overflow-x: scroll;">
        <? 
            $times = 5; 
            $fill_color = array(
                0   =>  array(
                    "8"  =>  '#6699cc',
                    "9"  =>  '#6699cc',
                    "10"  =>  '#6699cc',
                    "11"  =>  '#6699cc',
                    "14"  =>  '#6699cc',
                    "15"  =>  '#6699cc',
                    "16"  =>  '#6699cc',
                    "17"  =>  '#6699cc',
                ),
                1   =>  array(
                    "8"  =>  '#6699cc',
                    "9"  =>  '#6699cc',
                    "10"  =>  '#6699cc',
                    "11"  =>  '#6699cc',
                    "12"  =>  '#c1ebfb',
                    "13"  =>  '#c1ebfb',
                    "14"  =>  '#6699cc',
                    "15"  =>  '#6699cc',
                    "16"  =>  '#6699cc',
                    "17"  =>  '#6699cc',
                ),
                // 1   =>  array(
                //     "7"  =>  '#c1ebfb',
                //     "8"  =>  '#c1ebfb',
                //     "9"  =>  '#c1ebfb',
                //     "10"  =>  '#c1ebfb',
                //     "11"  =>  '#c1ebfb',
                //     "12"  =>  '#6699cc',
                //     "13"  =>  '#6699cc',
                //     "14"  =>  '#6699cc',
                //     "15"  =>  '#A173F1',
                //     "16"  =>  '#A173F1',
                //     "17"  =>  '#A173F1',
                //     "18"  =>  '#A173F1',
                //     "19"  =>  '#A173F1',
                //     "20"  =>  '#A173F1',
                //     "21"  =>  '#A173F1',
                //     "22"  =>  '#A173F1',
                // ),
                // 2   =>  array(
                //     "0"  =>  '#c1ebfb',
                //     "1"  =>  '#c1ebfb',
                //     "2"  =>  '#c1ebfb',
                //     "3"  =>  '#c1ebfb',
                //     "4"  =>  '#c1ebfb',
                //     "5"  =>  '#c1ebfb',
                //     "6"  =>  '#c1ebfb',
                //     "7"  =>  '#c1ebfb',
                //     "8"  =>  '#c1ebfb',
                //     "9"  =>  '#c1ebfb',
                //     "10"  =>  '#c1ebfb',
                //     "11"  =>  '#c1ebfb',
                //     "12"  =>  '#6699cc',
                //     "13"  =>  '#6699cc',
                //     "14"  =>  '#6699cc',
                // )
            );
        ?>
        <div class="row">
            <div class="col-xs-12">
                &nbsp;&nbsp;<span style="color: #A173F1;">■</span> 現場＆視訊會議
                &nbsp;&nbsp;<span style="color: #6699cc;">■</span> 現場會議
                &nbsp;&nbsp;<span style="color: #c1ebfb;">■</span> 視訊會議
                &nbsp;&nbsp;<span style="color: #E9E9EA;">■</span> 不開放
            </div>
            <!-- <div class="col-xs-4">
                <button class="btn btn-primary btn-xs pull-right btn-add-template">新增範本</button>
            </div> -->
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-template" style="text-align: center; width: auto;">
                    <thead>
                        <tr>
                            <? for ($i=0; $i < $times; $i++): ?>
                            <th colspan="2">
                            <!-- <button class="btn btn-xs btn-info">套用此模版</button> -->
                            <button class="btn btn-xs btn-info">套用</button>
                            <button class="btn btn-xs btn-warning btn-add-template">修改</button>
                            <button class="btn btn-xs btn-danger">刪除</button>
                            </th>
                            <? endfor; ?>
                        </tr>
                        <tr>
                            <? for ($i=0; $i < $times; $i++): ?>
                            <th colspan="2">Template-<?=($i+1) ?></th>
                            <? endfor; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <? for ($j=0; $j <= 23; $j++): ?>
                        <tr>
                            <? 
                                for ($i=0; $i < $times; $i++){
                                    echo '<td style="background-color: ';
                                    if (array_key_exists($j, $fill_color[($i)%count($fill_color)])) {
                                        echo $fill_color[($i)%count($fill_color)][$j];
                                    }else{
                                        echo '#E9E9EA';
                                    }
                                    echo ';">'.str_pad($j, 2, '0', STR_PAD_LEFT).":00".'</td>';
                                
                                    echo '<td style="background-color: ';
                                    if (array_key_exists($j, $fill_color[($i)%count($fill_color)])) {
                                        echo $fill_color[($i)%count($fill_color)][$j];
                                    }else{
                                        echo '#E9E9EA';
                                    }
                                    echo ';">'.str_pad($j, 2, '0', STR_PAD_LEFT).":30".'</td>';
                                }
                            ?>
                        </tr>
                        <? endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">關閉</button>
        <!-- <button id="template_save" type="button" class="btn btn-primary" data-dismiss="modal">套用</button> -->
      </div>
    </div>
  </div>
</div>
<!-- template Modal -->

<!-- template add Modal -->
<div class="modal fade" id="templateAddModal" role="dialog" aria-labelledby="modalLabel" tabindex="-1">
  <div class="modal-dialog" role="document" style="width: 800px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">新增範本
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </h5>
      </div>
      <div class="modal-body">
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-xs-6 col-xs-offset-3">
                &nbsp;&nbsp;<span style="color:#FFF; border-radius: 3px; background-color: #A173F1; padding: 5px; cursor: pointer;" class="color_btn"><span class="color_select">✔ </span>現場＆視訊會議</span>
                &nbsp;&nbsp;<span style="color:#FFF; border-radius: 3px; background-color: #6699cc; padding: 5px; cursor: pointer;" class="color_btn"><span class="color_select"></span>現場會議</span>
                &nbsp;&nbsp;<span style="color:#000; border-radius: 3px; background-color: #c1ebfb; padding: 5px; cursor: pointer;" class="color_btn"><span class="color_select"></span>視訊會議</span>
                &nbsp;&nbsp;<span style="color:#000; border-radius: 3px; background-color: #E9E9EA; padding: 5px; cursor: pointer;" class="color_btn"><span class="color_select"></span>不開放</span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <table class="table table-template-add" style="text-align: center; width: 100%;">
                    <tbody>
                        <? for ($j=0; $j <= 23; $j++): ?>
                        <tr>
                            
                            <td style="background-color: #E9E9EA;"><?=str_pad($j, 2, '0', STR_PAD_LEFT).":00" ?></td>
                            
                            <td style="background-color: #E9E9EA;"><?=str_pad($j, 2, '0', STR_PAD_LEFT).":30" ?></td>
                            
                        </tr>
                        <? endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">取消</button>
        <button id="template_save" type="button" class="btn btn-primary" data-dismiss="modal">儲存</button>
      </div>
    </div>
  </div>
</div>
<!-- template add Modal -->


<script src="js/app.js" type="text/javascript"></script>
<!-- end of global js -->
<script src="vendors/datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="vendors/datatables/js/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="vendors/moment/js/moment.min.js"></script>
<script type="text/javascript" src="vendors/advanced_newsTicker/js/newsTicker.js"></script>
<!-- <script type="text/javascript" src="js/dashboard1.js"></script> -->
<script src="vendors/select2/js/select2.js" type="text/javascript"></script>

<script type="text/javascript" src="vendors/lcswitch/js/lc_switch.min.js"></script>
<script src="vendors/colorpicker/js/bootstrap-colorpicker.min.js" type="text/javascript"></script>

<script type="text/javascript" src="vendors/summernote/summernote.min.js"></script>
<script type="text/javascript" src="vendors/summernote/summernote-zh-TW.js"></script>

<script src="vendors/moment/js/moment.min.js" type="text/javascript"></script>
<script src="vendors/moment/js/moment-timezone.js" type="text/javascript"></script>
<script src="vendors/moment/js/moment-timezone-with-data.js" type="text/javascript"></script>
<script src="vendors/moment/js/moment-timezone-with-data-2012-2022.js" type="text/javascript"></script>
<script src="vendors/datetime/js/jquery.datetimepicker.full.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.en.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.js" async></script>
<script>
    $(document).ready(function($) {
        $(".select2").select2();
        $('.status_switcher').bootstrapSwitch({
            onText: "開啟",
            offText: "關閉",
            onSwitchChange: function(e, state) {
                var day = $(this).attr("data-day");
                var status = (state)?1:0;
                if (!state) {
                    $("button[data-day="+day+"]").removeClass('type-online').removeClass('type-site').removeClass('type-both').addClass('type-disabled');
                }else{
                    $("button[data-day="+day+"]").addClass('type-online').removeClass('type-disabled');
                }
                // $.ajax({
                //     type: "POST",
                //     url: '<?=base_url() ?>exhibit/switch_toggle',
                //     data: {
                //         id: id,
                //         status: status
                //     },
                //     dataType: "json",
                //     success: function(data){
                        
                //     }
                // });
            }
        });

        $(".time_btn").on('click', function(event) {
            if ($(this).hasClass('type-both')) {
                $(this).removeClass('type-both').addClass('type-site');
            }else if ($(this).hasClass('type-site')) {
                $(this).removeClass('type-site').addClass('type-online');
            }else if ($(this).hasClass('type-online')) {
                $(this).removeClass('type-online').addClass('type-disabled');
            }else if ($(this).hasClass('type-disabled')) {
                var day = $(this).attr("data-day");
                if (!$("input[data-day="+day+"]").bootstrapSwitch('state')) return;
                $(this).removeClass('type-disabled').addClass('type-both');
            } 
        });

        $(".use_template").on('click', function(event) {
            var day = $(this).attr("data-date");
            $(".template_date").html(day);
            $("#templateModal").modal("show");
        });

        $("#template_save").on('click', function(event) {
            $("#templateModal").modal("hide"); 
        });


        var isDown = false;

        $(document).mousedown(function() {
            isDown = true; 
        })
        .mouseup(function() {
            isDown = false;
        });
        $(".table-template-add td").on('mousemove', function(event) {
            if (isDown) {
                $(this).css({
                    background: selected_color
                });     
            }
            
        });

        var selected_color = "#A173F1";
        $(".btn-add-template").on('click', function(event) {
            $("#templateAddModal").modal("show"); 
        });

        $(".color_btn").on('click', function(event) {
            $(document).find('.color_btn').each(function(index, el) {
                $(this).find('.color_select').html("");     
            });
            $(this).find('.color_select').html("✔ ");
            selected_color = $(this).css('background-color');
        });
    });

    
</script>

</body>

</html>