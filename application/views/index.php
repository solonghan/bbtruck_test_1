<?php include 'templates/header.php'; ?>

<!-- 新款形象照 start 後台可上傳圖片 1440*720(px)以及對應連結 -->
<div class="slider-area section-padding-1">
    <div class="container">
        <div class="slider-active-1 bg-gray-5 nav-style-1 dot-style-1">

            <? foreach ($collection as $collect) { ?>
                <a href="<?php echo base_url() . 'collection' ?>" target="_blank">
                    <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                        <img src="<?= base_url() . $collect['img'] ?>">
                    </div>
                </a>
                <!-- <a href="<?php echo base_url() . 'collection/bridal-gowns' ?>" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/top/home01.png">
                </div>
            </a>
            <a href="<?php echo base_url() . 'collection/bridal-gowns' ?>" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/top/home02.png">
                </div>
            </a>
            <a href="<?php echo base_url() . 'collection/bridal-gowns' ?>" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/top/home03.png">
                </div>
            </a>
            <a href="<?php echo base_url() . 'collection/bridal-gowns' ?>" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/top/home04.png">
                </div>
            </a>
            <a href="<?php echo base_url() . 'collection/bridal-gowns' ?>" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/top/home05.png">
                </div>
            </a>
            <a href="<?php echo base_url() . 'collection/bridal-gowns' ?>" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/top/home06.png">
                </div>
            </a>
            <a href="<?php echo base_url() . 'collection/bridal-gowns' ?>" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/top/home07.png">
                </div>
            </a>
            <a href="<?php echo base_url() . 'collection/bridal-gowns' ?>" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/top/home08.png">
                </div>
            </a> -->
            <? } ?>
        </div>
    </div>
</div>
<?
//!d($title[0]);
// 
?>
<!-- 新款形象照 end 後台可上傳圖片 1440*720(px)以及對應連結 -->
<div class="d-flex justify-content-center mobile">
    <? foreach ($title as $t2) {
        if ($t2['no'] == 1) {
            $tmp2 = $t2['mobile_title'];
            break;
        }
    } ?>
    <h3 class="text-center home__title"><? echo $tmp2 ?></h3>
</div>

<div class="d-flex justify-content-center desk">
    <? foreach ($title as $t2) {
        if ($t2['no'] == 2) {
            $tmp2 = $t2['desktop_title'];
            break;
        }
    } ?>
    <h3 class="text-center home__title"><? echo $tmp2 ?></h3>
</div>
<!-- new arrivals start 後台可上傳圖片 1440*720(px)以及對應連結 -->
<div class="slider-area section-padding-1">
    <div class="container">
        <div class="slider-active-1 bg-gray-5 nav-style-1 dot-style-1">
            <? foreach ($ready_to_wear as $ready) { ?>
                <a href="<?php echo base_url() . 'ReadyToWear' ?>" target="_blank">
                    <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                        <img src="<?= base_url() . $ready['img'] ?>">
                    </div>
                </a>
                <!-- <a href="<?php echo base_url() . 'ReadyToWear' ?>" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/new/new01.jpg">
                </div>-->


            <? } ?>
        </div>
    </div>
</div>
<!-- new arrivals end 後台可上傳圖片 1440*720(px)以及對應連結 -->
<div class="d-flex justify-content-center mobile">
    <? foreach ($title as $t3) {
        if ($t3['no'] == 2) {
            $tmp3 = $t3['mobile_title'];
            break;
        }
    } ?>
    <h3 class="text-center home__title"><? echo $tmp3 ?></h3>
</div>

<div class="d-flex justify-content-center desk">
    <? foreach ($title as $t3) {
        if ($t3['no'] == 3) {
            $tmp3 = $t3['desktop_title'];
            break;
        }
    } ?>
    <h3 class="text-center home__title"><? echo $tmp3 ?></h3>
</div>
<!-- customized start 後台可上傳圖片 1440*720(px)以及對應連結 -->
<div class="slider-area section-padding-1 custom__slider">
    <div class="container">
        <div class="slider-active-1 bg-gray-5 nav-style-1 dot-style-1">
            <? foreach ($customized as $cus) { ?>
                <a href="<?php echo base_url() . 'customized' ?>" target="_blank">
                    <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                        <img src="<?= base_url() . $cus['img'] ?>">
                    </div>
                </a>
                <!-- <a href="<?php echo base_url() . 'customized' ?>" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/customized/custom01.png">
                </div>
            </a>
            <a href="<?php echo base_url() . 'customized' ?>" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/customized/custom02.png">
                </div>
            </a>
            <a href="<?php echo base_url() . 'customized' ?>" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/customized/custom03.png">
                </div>
            </a>-->

            <? } ?>
        </div>
    </div>
</div>
<!-- customized end 後台可上傳圖片 1440*720(px)以及對應連結 -->
<div class="d-flex justify-content-center mobile">
    <? foreach ($title as $t4) {
        if ($t4['no'] == 3) {
            $tmp4 = $t4['mobile_title'];
            break;
        }
    }

    ?>
    <h3 class="text-center home__title"><? echo $tmp4; ?></h3>
</div>
<?
$title = explode("\n", $content['desktop_title']);

//!d($content);
$text = explode("\n", $content['content']);
?>


<!-- 店景照 start 後台可上傳圖片 528*456(px) -->
<div class="index__store">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="index__store--text">
                    <!-- <h3>我們期望每一位來到JENNY CHOU的客人<br>感受一個最舒適安心的頂級試衣空間</h3>
                    <p>
                        2008年創立至今，堅持手工打版與設計，從無到有，所有禮服皆於台灣製作完成。2013年成立第一家實體店面於敦北林蔭大道旁，2020年底搬遷至內湖科學園區，座落於科技大樓內的寬敞舒適空間，宛如如紐約曼哈頓大樓內的摩登showroom，極簡的弧形線條帷幕，為整體空間點出視覺核心。
                    </p>
                    
                    <p>
                        陽光灑落的大片落地玻璃，挑高天花板與灰白藕粉的溫和色調，仿舊感的大面古銅鏡與金屬陳列架，慵懶高貴的絨面沙發靠枕，勾勒出低調奢華且靜諡獨具的VIP試衣空間，融合簡潔、優雅與性感兼具的風格，並致力將女性的衣著品味細膩提升。
                    </p> -->
                    <h3>
                        <? 
                            $count=0;
                            foreach ($title as $ti) { 

                                 echo $ti;
                                if($count!=count($title)-1)
                                    echo '<br>';
                                $count++;
                         } ?>
                    </h3>
                    <? foreach ($text as $t) { ?>
                        <p>
                            <!-- <? !d($content) ?> -->
                            <? echo $t ?>

                        </p>
                    <? } ?>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 mobile__order--last">
                <div class="index__store--img">
                    <div class="product__corner"></div>
                    <div class="product-img product-img-slider-active dot-style-5">

                        <? foreach ($shop as $s) { ?>
                            <div class="product__slide" style="background-image: url('<?= base_url() . $s['img'] ?>');"></div>

                            <!-- <div class="product__slide" style="background-image: url('img/home/store/store01.png');"></div>
                        <div class="product__slide" style="background-image: url('img/home/store/store02.png');"></div>
                        <div class="product__slide" style="background-image: url('img/home/store/store03.png');"></div>
                        <div class="product__slide" style="background-image: url('img/home/store/store04.png');"></div>
                        <div class="product__slide" style="background-image: url('img/home/store/store05.png');"></div>
                        <div class="product__slide" style="background-image: url('img/home/store/store06.png');"></div>
                        <div class="product__slide" style="background-image: url('img/home/store/store07.png');"></div> -->
                        <? } ?>
                    </div>
                </div>
                <div class="w-100 product__sign d-flex align-items-center justify-content-lg-start justify-content-end">
                    <img src="img/page-sign.svg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 店景照 end 後台可上傳圖片 528*456(px) -->


<?php
$content1 = explode("\n", $our_service['content1']);
$content2 = explode("\n", $our_service['content2']);
$content3 = explode("\n", $our_service['content3']);

$title1 = explode("\n", $our_service['title1']);
$title2 = explode("\n", $our_service['title2']);
$title3 = explode("\n", $our_service['title3']);
?>
<!-- 服務項目 Start -->
<div class="service-area section-padding-10">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center service">
                <h3>OUR SERVICE</h3>
                <p class="pb-40">服務項目</p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12 service-border">
                <a href="<?php echo base_url() . 'collection/index/bridal-gowns' ?>">
                    <div class="service-wrap service-wrap-modify-2 text-center">
                        <img src="<?= base_url() . $our_service['img1'] ?>" width="50">
                        <h3>
                            <?
                            $count = 0;
                            foreach ($title1 as $service_t1) {
                                echo $service_t1;
                                if ($count != count($title1) - 1)
                                    echo '<br>';
                                $count++;    
                            }
                            ?>

                        </h3>
                        <!-- <h5>婚紗中的精品</h5> -->
                        <div class="d-flex flex-column">
                            <? foreach ($content1 as $con1) { ?>
                                <span><? echo $con1 ?></span>
                            <? } ?>
                        </div>
                    </div>
                </a>
                <!-- <a href="<?php echo base_url() . 'collection/bridal-gowns' ?>">
                    <div class="service-wrap service-wrap-modify-2 text-center">
                        <img src="img/home/Lease.png" width="50">
                        <h3>-禮服租借-</h3>
                        <h5>婚紗中的精品</h5>
                        <div class="d-flex flex-column">
                            <span>顯瘦打版</span>
                            <span>歐美風格</span>
                            <span>白紗.晚禮服</span>
                            <span>伴娘.花童服</span>
                        </div>
                    </div>
                </a> -->
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-12 service-border">
                <a href="<?php echo base_url() . 'customized' ?>">
                    <div class="service-wrap service-wrap-modify-2 text-center">
                        <img src="<?= base_url() . $our_service['img2'] ?>" width="50">
                        <h3>
                            <?
                            $count=0;
                             foreach($title2 as $service_t2){
                                echo $service_t2;
                                if(count($title2)-1!=$count)
                                    echo '<br>';
                                $count++;    
                             } 
                            
                            ?>
                        </h3>
                        <!-- <h5>量身訂製的專家</h5> -->
                        <div class="d-flex flex-column">

                            <? foreach ($content2 as $con2) { ?>
                                <span><? echo $con2 ?></span>
                            <? } ?>
                            <!-- <span>客製化訂做</span>
                            <span>女性西裝</span>
                            <span>白紗.禮服訂製</span>
                            <span>線上訂製服務</span> -->
                        </div>
                    </div>
                </a>
                <!-- <a href="<?php echo base_url() . 'customized' ?>">
                    <div class="service-wrap service-wrap-modify-2 text-center">
                        <img src="img/home/custom.png" width="50">
                        <h3>-客製化訂製-</h3>
                        <h5>量身訂製的專家</h5>
                        <div class="d-flex flex-column">
                            <span>客製化訂做</span>
                            <span>女性西裝</span>
                            <span>白紗.禮服訂製</span>
                            <span>線上訂製服務</span>
                        </div>
                    </div>
                </a> -->
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12 service-border">
                <a href="<?php echo base_url() . 'ReadyToWear' ?>">
                    <div class="service-wrap service-wrap-modify-2 text-center">
                        <img src="<?= base_url() . $our_service['img3'] ?>" width="50">
                        <h3>
                            <? 

                                $count=0;
                                foreach($title3 as $service_t3){
                                    echo $service_t3;
                                    if($count != count($title3)-1)
                                        echo '<br>';
                                    
                                    $count++;    

                                }

                                 
                            ?>
                        </h3>
                        <!-- <h5>高級時裝系列</h5> -->
                        <div class="d-flex flex-column">
                            <? foreach ($content3 as $con3) { ?>
                                <span><? echo $con3 ?></span>
                            <? } ?>
                            <!-- <span>精選面料</span>
                            <span>獨家打版</span>
                            <span>限量預購</span>
                            <span>創造生活儀式感</span> -->
                        </div>
                    </div>
                </a>
                <!-- <a href="<?php echo base_url() . 'ReadyToWear' ?>">
                    <div class="service-wrap service-wrap-modify-2 text-center">
                        <img src="img/home/advanced.png" width="50">
                        <h3>-JC READY TO WEAR-</h3>
                        <h5>高級時裝系列</h5>
                        <div class="d-flex flex-column">
                            <span>精選面料</span>
                            <span>獨家打版</span>
                            <span>限量預購</span>
                            <span>創造生活儀式感</span>
                        </div>
                    </div>
                </a> -->
            </div>
        </div>
    </div>
</div>
<!-- 服務項目 end -->


<?php include 'templates/footer.php'; ?>