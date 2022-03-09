<?php include 'templates/header.php'; ?>

<!-- 麵包屑 start 後台目前抓link字串，須改抓 header 內文字"DESIGNER" -->
<ul class="badge d-flex">
    <?php echo $badge; ?>
</ul>
<!-- 麵包屑 end 後台目前抓link字串，須改抓 header 內文字"DESIGNER" -->

<div class="designer__banner">
    <div class="container px-0 d-flex justify-content-md-center justify-content-lg-end align-items-center">
        <img src="<?= base_url() ?>resource/assets/img/designer/ph02.png" alt=""> <!-- 後台可置換 -->
        <img src="<?= base_url() ?>resource/assets/img/designer/ph01.png" alt=""> <!-- 後台可置換 -->
        <img src="<?= base_url() ?>resource/assets/img/designer/ph07.png" alt="">
    </div>
</div>

<?
$quote1 = explode("\n", $data['quote1_title']);

?>


<div class="flower">
    <div class="container">

        <div class="designer__content--first">
            <div class="row mx-0">
                <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
                    <div class="all__quoted light-color__quoted">
                        <? for ($i = 0; $i < count($quote1); $i++) { ?>
                            <? if ($i === 0) : ?>
                                <p class="text-center">
                                    <span class="dot-left-position mb-0">
                                        <img src="<?= base_url() ?>resource/assets/img/dots1.svg" alt="">
                                    </span>
                                    <? echo $quote1[$i] ?>
                                    <!-- 我從來不急，如果我取悅市場， -->
                                </p>
                            <? elseif ($i !== 0 && $i !== count($quote1) - 1) : ?>
                                <p>
                                    <?
                                    echo $quote1[$i]
                                    ?>

                                </p>

                            <? elseif ($i === count($quote1) - 1) : ?>
                                <p class="text-center">
                                    <!-- 失去我自己，就無法打動人心 -->
                                    <? echo $quote1[$i] ?>
                                    <span class="dot-right-position mb-0">
                                        <img src="<?= base_url() ?>resource/assets/img/dots2.svg" alt="">
                                    </span>
                                </p>
                            <? endif ?>
                        <? } ?>
                    </div>
                </div>
                <div class="col-12 col-md-6 d-flex align-items-center justify-content-start">
                    <!-- <img class="designer__img--first" src="<?= base_url() ?>resource/assets/img/designer/ph03.png" alt=""> -->
                    <img class="designer__img--first" src="<?= base_url() . $data['quote1_img'] ?>" alt="">
                </div>
            </div>
        </div>

        <div class="designer__content--second">
            <div class="row mx-0">
                <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
                    <div class="d-flex flex-wrap justify-content-sm-around align-items-center justify-content-center">
                        <ul class="designer__content list-unstyled">
                            <!-- <li>設計總監Jenny的母親及家族曾是禮服、時裝的製作師和打版師，從小看著母親在紙上畫圖，看著專業的打版技術和製作禮服時認真的背影，知道堅持專業是需要汗水與無數夜晚的浸潤，才能成就完美。
                            </li>
                            <li>品牌經過十年的茁壯，有幸受到許多人的喜愛，但2020年的一個念想，卻讓Jenny決定歸零，重新開始。
                            </li>
                            <li>放棄堅守一成不變的禮服租借，決心為每個女孩縫製屬於自己的風格。
                            </li> -->
                            <li>
                                <? echo $data['content1'] ?>
                            </li>
                        </ul>
                        <div class="d-flex designer__arrow">
                            <img src="<?= base_url() ?>resource/assets/img/brand/arrow.svg" class="about__img--arrow">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-center align-items-center designer__img--second">
                    <!-- <img class="designer__img--main" src="<?= base_url() ?>resource/assets/img/designer/ph04.png" alt=""> -->
                    <img class="designer__img--main" src="<?= base_url() . $data['content1_img'] ?>" alt="">
                </div>
            </div>
        </div>
        <?
        $quote2 = explode("\n", $data['quote2_title']);
        //!d($quote2);                       
        ?>
        <div class="designer__quote">
            <div class="row mx-0">
                <div class="col-12">
                    <div class="all__quoted light-color__quoted">
                        <? for ($i = 0; $i < count($quote2); $i++) { ?>
                            <? if ($i === 0) : ?>
                                <p class="text-center">
                                    <span class="dot-left-position mb-0">
                                        <img src="<?= base_url() ?>resource/assets/img/dots1.svg" alt="">
                                    </span>
                                    <!-- 生活就該有儀式感，想提升質感品味， -->
                                    <? echo $quote2[$i] ?>
                                </p>
                            <? elseif ($i !== 0 && $i !== count($quote2) - 1) : ?>
                                <p>
                                    <?
                                    echo $quote2[$i]
                                    ?>
                                </p>
                            <? elseif ($i === count($quote2) - 1) : ?>
                                <p class="text-center">
                                    <? echo $quote2[$i] ?>
                                    <!-- 就從穿上JENNY CHOU開始！  -->
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

        <div class="designer__content--fourth">
            <div class="row mx-0">
                <div class="col-12 col-md-6 designer__img--fourth">
                    <div>
                        <div class="color-block"></div>
                        <!-- <img src="<?= base_url() ?>resource/assets/img/designer/ph05.png" alt=""> -->
                        <img src="<?= base_url() . $data['content2_img'] ?>" alt="">
                    </div>
                </div>
                <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
                    <ul class="designer__content list-unstyled">
                        <!-- <li>Jenny 擅長以繁複的細節處理與獨到的剪裁方式，讓女性每一寸腰身都恰到好處的展現絕美曲線。巧妙融合歐美潮流與亞洲女性身形，無論是經典的魚尾亦或是輕柔貼合的蕾絲，都在需要隱藏處包覆、在值得展現處性感。</li> -->
                        <li><? echo $data['content2'] ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <?
        $quote3 = explode("\n", $data['quote3_title']);

        ?>
        <div class="designer__quote">
            <div class="row mx-0">
                <div class="col-12">
                    <div class="all__quoted light-color__quoted">
                        <? for ($i = 0; $i < count($quote3); $i++) { ?>
                            <? if ($i === 0) : ?>
                                <p class="text-center">
                                    <span class="dot-left-position mb-0">
                                        <img src="<?= base_url() ?>resource/assets/img/dots1.svg" alt="">
                                    </span>
                                    <!-- 很多衣服看起來在製作的時候都沒有被人的手碰過， -->
                                    <? echo $quote3[$i] ?>
                                </p>
                            <? elseif ($i !== 0 && $i !== count($quote3) - 1) : ?>
                                <P>
                                    <? echo $quote3[$i] ?>
                                </P>
                            <? elseif ($i === count($quote3) - 1) : ?>
                                <p class="text-center">
                                    <!-- 所以穿起來無法合身 -->
                                    <? echo $quote3[$i] ?>
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
        <?
        $content3 = explode("\n", $data['content3']);
        $content3_title = explode("\n", $data['content3_title']);
        ?>
        <div class="designer__content--last">
            <div class="row mx-0">
                <div class="col-12 col-md-6 d-flex flex-column justify-content-center position-relative mobile__order--first">
                    <!-- <p class="text-center designer__content">她一針一線縫出你的性感與內斂，展現你的品味與智慧；</p>
                    <p class="text-center designer__content">她苛求每片布料與身體的貼合，為您挑剔所有的不完美。</p> -->
                    <!-- <div class="all__quoted light-color__quoted">
                        <p class="text-center">她用自己的名字為品牌命名</p>
                        <p class="text-center">妳最美的模樣，將由 JC 親手打造</p>
                    </div> -->
                    <? foreach ($content3 as $con3) { ?>
                        <p class="text-center designer__content"><? echo $con3 ?></p>
                    <? } ?>
                    <div class="all__quoted light-color__quoted">
                        <? foreach ($content3_title as $con3_t) { ?>
                            <p class="text-center"><? echo $con3_t ?></p>
                        <? } ?>
                    </div>
                </div>
                <div class="col-12 col-md-6 designer__img--fifth">
                    <div></div>
                    <!-- <img class="designer__img--main" src="<?= base_url() ?>resource/assets/img/designer/ph06.png" alt=""> -->
                    <img class="designer__img--main" src="<?= base_url() . $data['content3_img'] ?>" alt="">
                </div>
                <div class="col-12">
                    <div class="d-flex justify-content-lg-start justify-content-end page-sign absolute-sign">
                        <img src="<?= base_url() ?>resource/assets/img/page-sign.svg" alt="">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'templates/footer.php'; ?>