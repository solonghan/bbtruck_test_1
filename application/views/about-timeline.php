<?php include 'templates/header.php'; ?>

<!-- 麵包屑 start 後台目前抓link字串，須改抓 header 內文字"TIMELINE" -->
<ul class="badge d-flex">
    <?php echo $badge; ?>
</ul>
<!-- 麵包屑 end 後台目前抓link字串，須改抓 header 內文字"TIMELINE" -->

<?
$quote = explode("\n", $data['quote']);

?>


<div class="container">
    <div class="consumer-video-wrap">
        <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/spJTo7DsT4M" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
        </iframe>
         -->
        <iframe width="560" height="315" src="<?= $data['vedio_link'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
        </iframe>
    </div>
    <div class="row mx-0">
        <div class="col-12 text-center mt-120 mb-10">
            <div class="all__quoted">
                <? for ($i = 0; $i < count($quote); $i++) { ?>
                    <? if ($i === 0) : ?>
                        <p>
                            <span class="dot-left-position mb-0">
                                <img src="<?= base_url() ?>resource/assets/img/dots1.svg" alt="">
                            </span>
                            <!-- 婚紗如婚姻不是一天美就好，而是一生永續。 -->
                            <? echo $quote[$i] ?>
                        </p>
                    <? elseif ($i !== 0 && $i !== count($quote) - 1) : ?>
                        <p>
                            <? echo $quote[$i] ?>
                        </p>
                    <? elseif ($i === count($quote) - 1) : ?>
                        <p>
                            <? echo $quote[$i] ?>
                            <!-- 對Jenny來說，經營品牌亦然。 -->
                            <span class="dot-right-position mb-0">
                                <img src="<?= base_url() ?>resource/assets/img/dots2.svg" alt="">
                            </span>
                        </p>
                    <? endif ?>
                <? } ?>
            </div>
        </div>
        <div class="col-12 timeline__sign--block">
            <div class="d-flex justify-content-end">
                <img class="timeline__sign" src="<?= base_url() ?>resource/assets/img/page-sign.svg" alt="">
            </div>
        </div>
    </div>
    <div class="row mx-0 timeline__section">
        <div class="col-12 col-md-4">
            <div class="left-time-line">
                <div class="timeline-photo left">
                    <div class="content">
                        <!-- <img src="<?= base_url() ?>resource/assets/img/timeline/img_jenny05.png" alt=""> -->
                        <img src="<?= base_url() . $data['left_img1'] ?>" alt="">
                    </div>
                </div>
                <div class="timeline-photo left">
                    <div class="content">
                        <!-- <img src="<?= base_url() ?>resource/assets/img/timeline/img_jenny06.png" alt=""> -->
                        <img src="<?= base_url() . $data['left_img2'] ?>" alt="">
                    </div>
                    <div class="timeline__year--bg">
                        <img src="<?= base_url() ?>resource/assets/img/timeline/bg_2013.png" alt="">
                    </div>
                </div>
                <div class="timeline-photo left">
                    <div class="content"></div>
                </div>
                <div class="timeline-photo left">
                    <div class="content"></div>
                </div>
                <div class="timeline-photo left">
                    <div class="content"></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="time-line-content">
                <div class="d-flex flex-column align-items-center">
                    <img class="mb-3" src="<?= base_url() ?>resource/assets/img/timeline/2008.png" alt="">
                    <p class="mb-0">品牌創立 婚紗工作室</p>
                    <p class="mb-0">新秘造型課程</p>
                </div>
                <div class="d-flex flex-column align-items-center">
                    <img class="mb-3" src="<?= base_url() ?>resource/assets/img/timeline/2010.png" alt="">
                    <p class="mb-0">B2B 婚紗販售</p>
                </div>
                <div class="d-flex flex-column align-items-center">
                    <div class="d-flex align-items-center mb-3">
                        <img class="mr-4" src="<?= base_url() ?>resource/assets/img/timeline/2013.png" alt="">
                        <img src="<?= base_url() ?>resource/assets/img/timeline/sep.png" alt="">
                    </div>
                    <p class="mb-0">首間實體店面 敦化北路</p>
                </div>
                <div class="d-flex flex-column align-items-center">
                    <img class="mb-3" src="<?= base_url() ?>resource/assets/img/timeline/2018.png" alt="">
                    <p class="mb-0">品牌十周年慶 文華東方走秀</p>
                </div>
                <div class="d-flex flex-column align-items-center">
                    <div class="d-flex align-items-center mb-3">
                        <img class="mr-4" src="<?= base_url() ?>resource/assets/img/timeline/2020.png" alt="">
                        <img src="<?= base_url() ?>resource/assets/img/timeline/nov.png" alt="">
                    </div>
                    <p class="mb-0">搬遷至內湖區 科技大樓</p>
                    <p class="mb-0">打造頂級VIP試衣空間</p>
                </div>
                <div class="d-flex flex-column align-items-center">
                    <div class="d-flex align-items-center mb-3">
                        <img class="mr-4" src="<?= base_url() ?>resource/assets/img/timeline/2021.png" alt="">
                        <img src="<?= base_url() ?>resource/assets/img/timeline/jul.png" alt="">
                    </div>
                    <p class="mb-0">JC Ready To Wear</p>
                    <p class="mb-0">高級時裝系列 誕生</p>
                </div>
                <img class="about__img--arrow" src="<?= base_url() ?>resource/assets/img/brand/arrow.svg">
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="right-time-line">
                <div class="timeline-photo left">
                    <div class="content">
                    </div>
                </div>
                <div class="timeline-photo left">
                    <div class="content">
                    </div>
                </div>
                <div class="timeline-photo left">
                    <div class="content">
                        <!-- <img src="<?= base_url() ?>resource/assets/img/timeline/img_jenny07.png" alt=""> -->
                        <img src="<?= base_url() . $data['right_img1'] ?>" alt="">
                    </div>
                    <div class="timeline__year--bg">
                        <img src="<?= base_url() ?>resource/assets/img/timeline/bg_2015.png" alt="">

                    </div>
                </div>
                <div class="timeline-photo left">
                    <div class="content"></div>
                </div>
                <div class="timeline-photo left">
                    <div class="content">
                        <!-- <img src="<?= base_url() ?>resource/assets/img/timeline/img_jenny08.png" alt=""> -->
                        <img src="<?= base_url() . $data['right_img2'] ?>" alt="">
                    </div>
                    <div class="timeline__year--bg">
                        <img src="<?= base_url() ?>resource/assets/img/timeline/bg_2020.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mx-0 timeline__section d-flex justify-content-center">
        <div class="col-12 col-lg-10">
            <!-- <img class="w-100 jenny-tenth-img" src="<?= base_url() ?>resource/assets/img/timeline/img_jenny09.png" alt=""> -->
            <img class="w-100 jenny-tenth-img" src="<?= base_url() . $data['big_img'] ?>" alt="">
            <div class="timeline__year--bg">
                <img src="<?= base_url() ?>resource/assets/img/timeline/bg_2018.png" alt="">
            </div>
        </div>
    </div>

    <?
    $introduction = explode("\n", $data['introduction']);


    ?>
    <div class="row mx-0 timeline__section">
        <div class="col-12">
            <div class="d-flex flex-column align-items-center timeline__content--text text-center">
                <ul>
                    <? foreach ($introduction as $intro) { ?>
                        <li>
                            <? echo $intro ?>
                        </li>
                    <? } ?>
                    <!-- <li>JENNY CHOU十周年於2018年11月10日</li>
                    <li>在文華東方酒店舉辦時尚走秀晚宴</li>
                    <li>除了給予自己創業十年歷程的紀念</li>
                    <li>Jenny也希望每一位出席賓客都能盛裝打扮</li>
                    <li>同時和弘道老人基金會合作讓林奶奶圓了婚紗夢</li>
                    <li>時尚的美麗、法式美好饗宴以及賓客的公益美心</li>
                    <li>用自己的一份力量讓台灣變得更加動人</li> -->
                </ul>
                <img class="about__img--arrow" src="<?= base_url() ?>resource/assets/img/brand/arrow.svg">
            </div>
        </div>
    </div>
    <h2 class="text-center timeline__title">More photos</h2>
</div>

<div class="timeline-carousel-bg">
    <div class="container">
        <!-- no container -->
        <div class="timelineSlider nav-style-1 dot-style-5">
            <? foreach ($carousel as $img) { ?>
                <div>
                    <div class="timeline__image">
                        <img src="<?= base_url() . $img['img'] ?>">
                    </div>
                </div>
                <!-- <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/2.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/3.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/4.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/5.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/6.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/7.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/8.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/9.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/10.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/11.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/12.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/13.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/14.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/15.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/16.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/17.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/18.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/19.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/20.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/21.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/22.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/23.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/24.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/25.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/26.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/27.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/28.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/29.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/30.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/31.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/32.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/33.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/34.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/35.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/36.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/37.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/38.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/39.jpg">
                </div>
            </div>
            <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/40.jpg">
                </div>
            </div> -->
            <? } ?>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>