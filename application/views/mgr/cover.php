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

    <link rel="stylesheet" href="css/portlet.css"/>    
    <link href="css/nestable.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="css/pickers.css">

    <link rel="stylesheet" type="text/css" href="vendors/datatables/css/dataTables.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="vendors/datatablesmark.js/css/datatables.mark.min.css"/>


    <link href="vendors/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="vendors/select2/css/select2-bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.css" />
    
    <link href="vendors/toastr/css/toastr.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="css/custom_css/toastr_notificatons.css">

    <link rel="stylesheet" type="text/css" href="css/custom_css/jquery.mCustomScrollbar.css">
    <!-- <link rel="stylesheet" type="text/css" href="http://manos.malihu.gr/repository/custom-scrollbar/demo/examples/style.css"> -->
    <link href="css/buttons_sass.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.css" />

    <style>
        .btn-del{
            position: absolute;
            top: 0;
            right: 0;
            height: inherit;
            z-index: 99;
            color: #000;
        }
        .btn-del:hover{
            color: #2ea8e5;
        }
        .btn-edit{
            position: absolute;
            top: 0;
            right: 25px;
            height: inherit;
            z-index: 99;
            color: #000;
        }
        .btn-edit:hover{
            color: #2ea8e5;
        }
        .bg-default{
            background-color: #F5F5F5;
            color: #333333 !important;
            border: 1px solid #cccccc;
        }
        .img_thumbnail {
            border: 1px solid #ddd; /* Gray border */
            border-radius: 4px;  /* Rounded border */
            padding: 5px; /* Some padding */
            width: 150px; /* Set a small width */
            margin: 1px;
        }

        /* Add a hover effect (blue shadow) */
        .img_thumbnail:hover {
            box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
        }

        /* beauty scrollbar */
        .showcase .horizontal-images.content{
            height: 140px;
            width: 100%;
            padding: 5px 5px 0 5px;
        }

        .horizontal-images.content ul, .vertical-images.content ul{
            margin: 0;
            padding: 0;
            list-style: none;
            overflow: hidden;
        }

        .horizontal-images.content li{
            margin: 0 3px;
            float: left;
        }

        .vertical-images.content li{ margin: 3px 0; }

        .horizontal-images.content li:first-child{ margin-left: 0; }

        .vertical-images.content li:first-child{
            margin-bottom: 3px;
            margin-top: 0;
        }

        .horizontal-images.content li:last-child{ margin-right: 0; }

        .vertical-images.content li:last-child{ margin-bottom: 0; }

        .del-btn{
            position:absolute; 
            bottom:0; 
            right:0; 
            margin:3%; 
            height:25px; 
            width:25px; 
            line-height:25px; 
            padding:0;
            z-index: 100;
        }

        .sort_txt{
            position:absolute; 
            top:0; 
            left:0; 
            margin:3%; 
            height:25px; 
            width:25px; 
            line-height:25px; 
            padding:0;
            z-index: 100;
        }
        
        .link_txt{
            position:absolute; 
            top:0; 
            right:0; 
            margin:3%; 
            height:25px; 
            width:130px; 
            line-height:25px; 
            padding:0;
            z-index: 100;
        }
    </style>
</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                輪播圖
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li class="active">播播圖
                </li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row ui-sortable" id="sortable_portlets">
                <div class="col-md-12 sortable" id="picArea">
                    <?  
                        $cate = array(
                            array("id"=>"home", "name"=>"首頁")
                        );
                        $index = 0;
                        foreach ($cate as $item) {
                    ?>
                    <div class="portlet box" id="cate_<?=$item['id'] ?>">
                        <div class="portlet-title bg-default">
                            <div class="caption clearfix">
                                <i class="ti-menu"></i> <?=$item['name'] ?>
                                <div class="pull-right">
                                    <form class="form-horizontal" role="form" action="<?=base_url()."mgr/cover/add/".$item['id'] ?>" method="post" enctype="multipart/form-data" id="form<?=$item['id'] ?>">
                                        <input type="file" id="image<?=$item['id'] ?>" name="image<?=$item['id'] ?>[]" style="position: absolute; z-index: -999; width: 0;" multiple onchange="menuUpload('<?=$item['id'] ?>')" accept="image/*">
                                        <input type="button" value="上傳照片" onclick="image<?=$item['id'] ?>.click();">
                                        <input type="button" value="更新排序" onclick="location.reload();">
                                    </form>
                                </div>
                                <span class="pull-right" id="loading_<?=$item['id'] ?>" style="display: none;"><img src="img/loading.gif" style="width: 30px;"></span>
                            </div>
                            
                        </div>
                        <div class="portlet-body">
                            <div id="" class="showcase">
                                <div class="content horizontal-images light customScrollbar">
                                    <form action="<?=base_url() ?>mgr/cover/picsort" method="post" id="menu_<?=$item['id'] ?>_form">
                                        <ul>
                                            <? 
                                                $show = $home;
                                                foreach ($show as $pic) {
                                            ?>
                                                <li style="position: relative;">
                                                    <a data-fancybox="gallery<?=$index ?>" href="<?=base_url().$pic['url'] ?>">
                                                        <img src="<?=base_url().$pic['url'] ?>" class="img_thumbnail" style="width: auto; height: 120px;">
                                                    </a>
                                                    <button type='button' onclick='delImg(this, "<?=$item['id'] ?>", "<?=$pic['id'] ?>"); return false;' class='button button-caution-flat hvr-wobble-horizontal del-btn'><span class='fa fa-fw ti-trash'></span></button>
                                                    <input type="text" style="text-align: center;" class="sort_txt" id="pic_<?=$pic['id'] ?>" value="<?=$pic['sort'] ?>">
                                                    <input type="text" class="link_txt" id="piclink_<?=$pic['id'] ?>" value="<?=$pic['link'] ?>">
                                                </li>
                                            <?
                                                }
                                            ?>
                                            
                                        </ul>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <?
                            $index++;
                        }
                    ?>
                    
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

<script src="vendors/nestable-list/jquery.nestable.js"></script>
<script src="js/custom_js/jquery.mCustomScrollbar.concat.min.js">
</script>
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
        $(".customScrollbar").mCustomScrollbar({
            axis:"x",
            theme:"dark-thin",
            autoExpandScrollbar:true,
            advanced:{autoExpandHorizontalScroll:true}
        });

        $('[data-fancybox]').fancybox({
            protect: true,
            // thumbs : {
            //     autoStart : true
            // }
            image : {
            // Wait for images to load before displaying
            // Requires predefined image dimensions
            // If 'auto' - will zoom in thumbnail if 'width' and 'height' attributes are found
                preload : 'auto',
            },
        });

        $(".sort_txt").on('blur', function(event) {
            var id = $(this).attr("id");
            id = id.split("_");
            $.ajax({
                url: "<?=base_url() ?>mgr/cover/picsort",
                data: {
                    id: id[1],
                    sort: $(this).val()
                },
                type:"POST",
                dataType:'html',
                success: function(d){
                    
                },
                error:function(xhr, ajaxOptions, thrownError){ 
                    console.log(xhr);
                }
            });
        });

        $(".link_txt").on('blur', function(event) {
            var id = $(this).attr("id");
            id = id.split("_");
            $.ajax({
                url: "<?=base_url() ?>mgr/cover/piclink",
                data: {
                    id: id[1],
                    link: $(this).val()
                },
                type:"POST",
                dataType:'html',
                success: function(d){
                    
                },
                error:function(xhr, ajaxOptions, thrownError){ 
                    console.log(xhr);
                }
            });
        });
    }); 

    function delImg(obj, type, pic_id){
        if (!confirm("確定刪除此照片嗎?")) return;
        $.ajax({
            type: "POST",
            url: "<?=base_url().'mgr/cover/del' ?>",
            data: {
                type: type,
                pic_id: pic_id
            },
            dataType: "html",
            success: function(data){
                if (data == "success") {
                    $(obj).parent("li").fadeOut();
                }else{
                    alert("刪除失敗");
                }
            },
            failure: function(errMsg) {
                alert(errMsg);
            }
        });
    }

    function menuUpload(id){
        
        $('.loader_img img').show();
        $('.preloader').show();
        $('.preloader').css({
            'background-color': '#FFFFFF',
            'opacity': 0.6
        });

        $("#form"+id).submit();
    }   
</script>
</body>

</html>
