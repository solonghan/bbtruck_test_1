<!-- 此頁在正式站需先隱藏，因圖文內容待處理中 -->
<?php include 'templates/header.php'; ?>

<!-- 麵包屑 start 後台目前抓link字串，須改抓 header 內文字 "READY TO WEAR" -->
<ul class="badge d-flex">
    <?php echo $badge; ?>
</ul>
<!-- 麵包屑 end 後台目前抓link字串，須改抓 header 內文字 "READY TO WEAR" -->

<!-- ready to wear 形象照 start 後台可上傳圖片 1440*720(px)以及對應連結 -->
<div class="slider-area">
    <div class="container">
        <div class="slider-active-1 bg-gray-5 nav-style-1 dot-style-1 rtw__slider--main">
            <? foreach ($top as $t) { ?>
                <a href="#0" target="_blank">
                    <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                        <img src="<?= base_url() . $t['img'] ?>">
                    </div>
                </a>
                <!-- <a href="#0" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/top/home01.png">
                </div>
            </a>
            <a href="#0" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/top/home02.png">
                </div>
            </a>
            <a href="#0" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/top/home03.png">
                </div>
            </a>
            <a href="#0" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/top/home04.png">
                </div>
            </a>
            <a href="#0" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/top/home05.png">
                </div>
            </a>
            <a href="#0" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/top/home06.png">
                </div>
            </a>
            <a href="#0" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/top/home07.png">
                </div>
            </a>
            <a href="#0" target="_blank">
                <div class="single-slider slider-height-11 custom-d-flex custom-align-item-center bg-img">
                    <img src="img/home/top/home08.png">
                </div>
            </a> -->
            <? } ?>
        </div>
    </div>
</div>
<!-- ready to wear 形象照 end 後台可上傳圖片 1440*720(px)以及對應連結 -->
<?
$quote = explode("\n", $data['quote']);
//!d($quote);            
// var_dump($data['quote']);
//             die;
?>
<div class="container">
    <div class="row">
        <div class="col-12 text-center custom__sec">
            <div class="all__quoted light-color__quoted">
                <? for ($i = 0; $i < count($quote); $i++) { ?>
                    <? if ($i === 0) : ?>
                        <p>
                            <span class="dot-left-position mb-0">
                                <img src="<?= base_url() ?>resource/assets/img/dots1.svg" alt="">
                            </span>
                            <!-- <span>生活就該有儀式感，想提升質感品味，</span> -->
                            <? echo $quote[0] ?>
                        </p>
                    <? elseif ($i !== 0 && $i !== count($quote) - 1) : ?>
                        <p>
                            <!-- <span>就從穿上 JENNY CHOU 開始！</span> -->
                            <? echo $quote[$i] ?>
                            <!-- <span class="dot-right-position mb-0">
                                <img src="<?= base_url() ?>resource/assets/img/dots2.svg" alt="">
                            </span> -->
                        </p>
                    <? elseif ($i === count($quote) - 1) : ?>
                        <p>
                            <!-- <span>就從穿上 JENNY CHOU 開始！</span> -->
                            <? echo $quote[$i] . "\t" ?>
                            <span class="dot-right-position mb-0">
                                <img src="<?= base_url() ?>resource/assets/img/dots2.svg" alt="">
                            </span>
                        </p>
                    <? endif ?>
                <? } ?>
            </div>
        </div>
        <?

        $content_down = explode("\n", $data['content']);


        ?>

        <div class="col-12 custom__sec">
            <div class="d-flex flex-column align-items-center timeline__content--text text-center">
                <ul>
                    <!-- <li>因著對生活有無比的熱情，以及對女性力量的推崇，</li>
                    <li>在2021下半年，我們推出了 JENNY CHOU 高級時裝系列</li>
                    <li>除了在面料選擇與剪裁的用心，</li>
                    <li>所有單品皆為少量生產，保有服裝的獨特性</li>
                    <li>JC Ready To Wear 於是誕生！</li> -->

                    <li>

                        <?

                        foreach ($content_down as $cd) { ?>
                            <p>
                                <? echo $cd; ?>
                            </p>
                        <? } ?>





                    </li>
                </ul>
            </div>
        </div>
        <div class="col-12 rtw__button">
            <div class="d-flex justify-content-center">
                <!-- shop now 預計導向外部連結 -->
                <a href="<?= $data['shop_link'] ?>">Shop Now</a>
            </div>
        </div>
    </div>

</div>

<div class="rtw__carousel--title">
    <div class="container">
        <p>
            <? echo $data['title'] ?>
            <!-- <p><em>Ready To Wear</em> ｜ 高級時裝系列</p> -->
    </div>
</div>

<!-- ready to wear 所有款式 start 後台可上傳圖片 長寬比2:3 至少400*600(px) -->
<div class="rtw__carousel--bg">
    <div class="container">
        <div class="timelineSlider nav-style-1 dot-style-5">
            <? foreach ($bottom as $b) { ?>
                <div>
                    <div class="timeline__image">
                        <img src="<?= base_url() . $b['img'] ?>">
                    </div>
                </div>
                <!-- <div>
                <div class="timeline__image">
                    <img src="<?= base_url() ?>resource/assets/img/timeline/carousel/1.jpg">
                </div>
            </div>
            <div>
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
<!-- ready to wear 所有款式 end 後台可上傳圖片 長寬比2:3 至少400*600(px) -->

<?php include 'templates/footer.php'; ?>
<!-- 此頁在正式站需先隱藏，因圖文內容待處理中 -->