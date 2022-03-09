<?php include 'templates/header.php'; ?>

<!-- 麵包屑 start 後台目前抓link字串，須改抓 header 內文字"THE BRAND" -->
<ul class="badge d-flex">
    <?php echo $badge; ?>
</ul>
<!-- 麵包屑 end 後台目前抓link字串，須改抓 header 內文字"THE BRAND" -->

<div class="brand__section">
    <div class="consumer-video-area">
        <div class="container">
            <div class="consumer-video-wrap">
                <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/nDusdSRF_WA" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
                <iframe width="560" height="315" src="<?= $data['vedio_link'] ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <?
    $quote = explode("\n", $data['quote']);

    //!d($quote);               

    ?>
    <div class="container">
        <div class="brand__quote">
            <div class="col-12 text-center">
                <div class="all__quoted">
                    <? for ($i = 0; $i < count($quote); $i++) { ?>
                        <? if ($i === 0) : ?>
                            <p>
                                <span class="dot-left-position mb-0">
                                    <img src="<?= base_url() ?>resource/assets/img/dots1.svg" alt="">
                                </span>
                                <!-- 她們誇我匠心獨具，但我知道，女孩需要的， -->
                                <? echo $quote[$i] ?>
                            </p>
                        <? elseif ($i !== 0 && $i !== count($quote) - 1) : ?>
                            <p>
                                <? echo $quote[$i] ?>
                            </p>
                            <!-- <p>從來都不是多厲害的設計師，</p>
                    <p>而是聽懂她們需求的人。 -->

                        <? elseif ($i === count($quote) - 1) : ?>
                            <p>
                                <? echo $quote[$i] ?>
                                <span class="dot-right-position mb-0">
                                    <img src="<?= base_url() ?>resource/assets/img/dots2.svg" alt="">
                                </span>
                            </p>
                        <? endif ?>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?
$content1_title = explode("\n", $data['content1_title']);
$content2_title = explode("\n", $data['content2_title']);
$content3_title = explode("\n", $data['content3_title']);
?>
<div class="brand__section">
    <div class="container">
        <div class="brand__content--first">
            <div class="row mx-0">
                <div class="col-12 col-lg-5 col-md-6 p-0">
                    <div class="image-group">
                        <!-- <img src="<?= base_url() ?>resource/assets/img/brand/pic_one.png" alt="">
                        <img src="<?= base_url() ?>resource/assets/img/brand/pic_two.png" alt=""> -->
                        <img src="<?= base_url() . $data['content1_img1'] ?>" alt="">
                        <img src="<?= base_url() . $data['content1_img2'] ?>" alt="">

                    </div>
                </div>
                <div class="col-12 col-lg-7 col-md-6 p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-sm-around">
                        <div class="d-flex">
                            <img class="about__img--arrow" src="<?= base_url() ?>resource/assets/img/brand/arrow.svg">
                        </div>
                        <div class="d-flex">
                            <!-- <p>JENNY CHOU 於2008年創立品牌，</p>
                            <p>從第一天開始，就堅持手工打版製圖，從設計到生產，</p>
                            <p>聘僱專屬的設計、打版及製作師。</p>
                            <p>每季會親自飛往歐洲、美國，選購獨特面料及頂級蕾絲，</p>
                            <p>秉持著來自台灣設計及手工製作的理念，</p>
                            <p>希望可以為每個女孩設計專屬的幸福，</p>
                            <p>一針一線地打造出屬於時尚的絕美視野。</p> -->
                            <? foreach ($content1_title as $con_t1) { ?>
                                <p><? echo $con_t1 ?></p>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="brand__content--bg">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-end page-sign">
                        <img src="<?= base_url() ?>resource/assets/img/page-sign.svg" alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="brand__content--second">
            <div class="row align-items-center mx-0">
                <div class="col-12 col-md-6 col-lg-6 col-xl-5 p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-sm-around">
                        <ul class="list-unstyled d-flex flex-column">
                            <!-- <li class="brand__text--second">這樣的理念，13年來引領台灣高端訂製婚紗禮服潮流，</li>
                            <li class="brand__text--second">與國際品牌流行同步，成為品味獨到的新人首選，</li>
                            <li class="brand__text--second">並深受許多明星藝人肯定，融合優雅及性感的獨特風格，</li>
                            <li class="brand__text--second">如藝人：簡嫚書、周曉涵、柯佳嬿、曾寶儀、</li>
                            <li class="brand__text--second">模特兒瑞莎至時尚部落客 & KOL等，</li>
                            <li class="brand__text--second">皆穿著出席重要場而合成為鎂光燈焦點。</li>
                         -->
                            <? foreach ($content2_title as $con_t2) { ?>
                                <li class="brand__text--second"><? echo $con_t2 ?></li>
                            <? } ?>
                        </ul>
                        <div class="d-flex brand__arrow">
                            <img class="about__img--arrow rotate-180" src="<?= base_url() ?>resource/assets/img/brand/arrow.svg">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6 col-xl-7 p-0">
                    <div class="brand__img1">
                        <img src="<?= base_url() . $data['content2_img'] ?>" alt="">
                        <!-- <img src="<?= base_url() ?>resource/assets/img/brand/sprit_img01.png" alt=""> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="brand__content--third">
            <div class="row mx-0">
                <div class="col-12 col-md-6 col-lg-5 p-0">
                    <div class="image-group">
                        <img src="<?= base_url() . $data['content3_img1'] ?>" alt="">
                        <img src="<?= base_url() . $data['content3_img2'] ?>" alt="">
                        <!-- <img src="<?= base_url() ?>resource/assets/img/brand/sprit_img02.png" alt="">
                        <img src="<?= base_url() ?>resource/assets/img/brand/sprit_img03.png" alt=""> -->
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-7 p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-sm-around">
                        <div class="d-flex">
                            <img class="about__img--arrow" src="<?= base_url() ?>resource/assets/img/brand/arrow.svg">
                        </div>
                        <ul class="list-unstyled d-flex flex-column">
                            <!-- <li>無論您想要什麼風格，有多少的理想與幻想，</li>
                            <li>我們都能為您泡上一杯咖啡，細細討論妳的挑剔與憧憬，</li>
                            <li>從布料材質開始，直至每一片蕾絲、每一顆珠鑽，</li>
                            <li>Jenny Chou 每張設計稿所落下的第一筆，</li>
                            <li>運用石墨與畫紙摩擦出的唯美，將蘊含數十年設計經驗，</li>
                            <li>化作妳身上獨一無二的風格品味。</li> -->
                            <? foreach ($content3_title as $con_t3) { ?>
                                <li><? echo $con_t3 ?></li>
                            <? } ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>