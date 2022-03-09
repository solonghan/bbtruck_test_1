<!DOCTYPE html>
<html>

<head>
    <? include("header.php"); ?>
    <!-- <link href="vendors/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="vendors/select2/css/select2-bootstrap.css" rel="stylesheet" type="text/css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.css" />
    
    <link rel="stylesheet" href="vendors/datetime/css/jquery.datetimepicker.css">
    <link href="vendors/airdatepicker/css/datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="css/native-toast.css" rel="stylesheet">
    <link href="css/multi-select.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/custom_css/toastr_notificatons.css">

    <link href="vendors/iCheck/css/all.css" rel="stylesheet">
    <style>

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

        .ms-container{
            width: 90%;
            margin: 30px 5%;
        }
        td{
            padding-top: 4px !important;
            padding-bottom: 0 !important;
            line-height: 12px !important;
        }

        .select2-container--default .select2-selection--single{
            border-radius: 0;
            border: 1px solid #CCC;
            text-align: center;
        }
    </style>
</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?=$title ?>
            </h1>
            <button class="pull-right btn btn-md btn-primary" style="margin-top: -20px; margin-right: 25px;">存檔</button>
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
                    <div class="nav-tabs-custom">
                        <?
                            $dates = array();
                            for ($i=0; $i < 5; $i++) { 
                                $day = date("Y-m-d", strtotime('+ '.$i.' days', strtotime(date("Y-m-d"))));
                                $dates[] = $day;
                            }
                        ?>
                        <ul class="nav nav-tabs">
                            <? foreach ($dates as $index => $day): ?>
                            <li class="<?=($index==0)?'active':'' ?>">
                                <a href="#tab_<?=date("Ymd", strtotime($day)) ?>" data-toggle="tab"><?=date("m/d", strtotime($day)) ?></a>
                            </li>
                            <? endforeach; ?>
                        </ul>

                        

                        <div class="tab-content">
                            <? foreach ($dates as $index => $day): ?>
                            <div class="panel tab-pane<?=($index==0)?' active':'' ?>" id="tab_<?=date("Ymd", strtotime($day)) ?>">
                                <div class="m-t-10">
                                    <select class="searchable" multiple='multiple'>
                                        <? foreach ($default_corp as $corp): ?>
                                        <option value='<?=$corp[0] ?>'<?=($corp[2])?' selected':'' ?>><?=$corp[0] ?>, <?=$corp[1] ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </div>
                                <div class="m-t-10">
                                    <table class="table horizontal_table table-striped attendance_table">
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
                                        <tbody>
                                            <? $total = count($default_corp);
                                            $in=1;
                                            foreach ($default_corp as $corp): if(!$corp[2]) continue; ?>
                                                <?
                                                    $item = array("id"=>1,"sort"=>$in++);
                                                    
                                                ?>
                                            <tr data-id="">
                                                <td>
                                                    <div class="input-group" id="sortarea_<?=$item['id'] ?>">
                                                        <? if ($item['sort'] == 1): ?>
                                                        <span class="input-group-addon" style="color: #CCC; cursor: not-allowed;">▲</span>
                                                        <? else: ?>
                                                        <span class="input-group-addon sort_up">▲</span>
                                                        <? endif; ?>
                                                        <input type="hidden" id="sort_<?=$item['id'] ?>" value="<?=$item['sort'] ?>">
                                                        <select class="form-control select2">
                                                            <? 
                                                                for ($index=1; $index <= $total ; $index++) { 
                                                                    echo '<option value="'.$index.'"';
                                                                    if ($index == $item['sort']) {
                                                                        echo ' selected';
                                                                    }
                                                                    echo '>'.$index.'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                        <? if ($item['sort'] == $total): ?>
                                                        <span class="input-group-addon" style="color: #CCC; cursor: not-allowed;">▼</span>
                                                        <? else: ?>
                                                        <span class="input-group-addon sort_down">▼</span>
                                                        <? endif; ?>
                                                    </div>
                                                </td>
                                                <td><?=$corp[0] ?></td>
                                                <td><?=$corp[1] ?></td>
                                                <td>
                                                    <button class="  btn-xs " style="border:none"><span style="color: #A33; font-size: 24px;"><i class="fa fa-fw fa-times"></i></span></button>
                                                </td>
                                            </tr>
                                            <? endforeach; ?>
                                        </tbody>
                                    </table>
                                    <!-- <ul class="pagination page pull-right"></ul> -->
                                </div>
                            </div>
                            <? endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xs-12">

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
<script src="js/jquery.multi-select.js" type="text/javascript"></script>
<script src="js/jquery.quicksearch.js" type="text/javascript"></script>

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
        $(".select2").select2();
    }); 

    var buyer = [];


  $('.searchable').multiSelect({
    selectableHeader: "未參與名單<input type='text' style='height:30px;width:100%;margin-bottom:10px;border-radius: 3px; border: 1px solid #ccc;' class='search-input' autocomplete='off' placeholder='搜尋公司、聯絡人'>",
    selectionHeader: "參與名單<input type='text' style='height:30px;width:100%;margin-bottom:10px;border-radius: 3px; border: 1px solid #ccc;' class='search-input' autocomplete='off' placeholder='搜尋公司、聯絡人'>",
    afterInit: function (ms) {
      var that = this,
        $selectableSearch = that.$selectableUl.prev(),
        $selectionSearch = that.$selectionUl.prev(),
        selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
        selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

      that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
        .on('keydown', function (e) {
          if (e.which === 40) {
            that.$selectableUl.focus();
            return false;
          }
        });

      that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
        .on('keydown', function (e) {
          if (e.which == 40) {
            that.$selectionUl.focus();
            return false;
          }
        });
    },
    afterSelect: function (values) {
      this.qs1.cache();
      this.qs2.cache();      
      console.log("selected: "+values)
    },
    afterDeselect: function (values) {
      this.qs1.cache();
      this.qs2.cache();      
      console.log("deselected: "+values)
    }
  });

  $(".ms-elem-selectable").on('click', function(event) {
    //選取->下方table新增data
console.log($(this))
    var val = $(this).val();
    var name = $(this).text();
    // var html ='<tr data-id=""><td>2</td>        <td>Sheldon</td>    <td>Sheldon Information Company</td><td><button class="  btn-xs " style="border:none"><span style="color: #A33; font-size: 24px;"><i class="fa fa-fw fa-times"></i></span></button></td></tr><tr data-id=""><td style="tex">1</td>        <td>Watson</td>    <td>Watson Information Company</td><td><button class="  btn-xs " style="border:none"><span style="color: #A33; font-size: 24px;"><i class="fa fa-fw fa-times"></i></span></button></td> </tr>';

    var html ="";

    html += '<tr data-id=""><td><input type="text" size="5" value="0" style="text-align: center;"></td><td>'+name+'</td><td>'+name+'</td><td><button class="  btn-xs " style="border:none"><span style="color: #A33; font-size: 24px;"><i class="fa fa-fw fa-times"></i></span></button></td> </tr>';
    // $("tr:last").after(html);
        var id = $(this).closest('.tab-pane').attr("id");
        $("#"+id+" .table.attendance_table tbody").append(html);
    })

  $(".ms-selected").on('click', function(event) {
    //取消選取->下方table刪除data 
    console.log('dddd');
    console.log($(this).text());
    })    
  </script>
</body>

</html>
