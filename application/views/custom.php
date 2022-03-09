<?php include 'templates/header.php'; ?>
<style>
    h3 > strong{
        margin: 0 10px;
    }
    @media (max-width: 480px){
        .custom2 h3{
            font-size: 16px;
        }
        .custom2 h3 > strong{
            margin: 0 5px;
        }
        .custom-text img{
            width: 50%;
            padding-top: 30px;
        }
        .custom .custom-border .custom-text{
            padding: 5% 20px;
        }
        .custom-block{
            display: none;
        }
        .jenny-border{
            display: none;
        }
        .images-3-col + .pt-50{
            padding-top: 16px;
        }
        .pt-60{
            padding-top: 5vh;
        }
        .pb-60{
            padding-bottom: 5vh;
        }
    }
</style>
<!-- 麵包屑 start 後台目前抓link字串，須改抓 header 內文字 "CUSTOMIZED" -->
<ul class="badge d-flex">
    <?php echo $badge; ?>
</ul>
<!-- 麵包屑 end 後台目前抓link字串，須改抓 header 內文字 "CUSTOMIZED" -->

<div class="custom__banner">
    <div class="container">
        <div class="d-flex justify-content-center align-items-center">
            <img src="<?= base_url() . $data['img1'] ?>" alt=""> <!-- 後台可置換 953*1014(px) -->
            <img src="<?= base_url() . $data['img2'] ?>" alt="">
            <!-- 後台可置換 879*937(px)，手機版不顯示-->
        </div>
    </div>
</div>

<?
$quote = explode("\n", $data['quote']);

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
                            <? echo $quote[$i] ?>
                            <!-- 為妳精挑一絲一縷，為妳縫製一針一線， -->
                        </p>
                    <? elseif ($i !== 0 && $i !== count($quote) - 1) : ?>
                        <p>
                            <? echo $quote[$i] ?>
                        </p>
                    <? elseif ($i === count($quote) - 1) : ?>
                        <p>
                            <!-- 只為了，獨一無二的妳 -->
                            <? echo $quote[$i] ?>

                            <span class="dot-right-position mb-0">
                                <img src="<?= base_url() ?>resource/assets/img/dots2.svg" alt="">
                            </span>
                        </p>
                    <? endif ?>
                <? } ?>
            </div>
        </div>
        <?
        $content = explode("\n", $data['content']);
        ?>

        <div class="col-12">
            <div class="d-flex flex-column align-items-center timeline__content--text text-center">
                <!-- 後台可置換文案 start -->
                <ul>
                    <? foreach ($content as $con) { ?>
                        <li><? echo $con ?></li>
                    <? } ?>
                    <!-- <li>不論您是</li>
                    <li>想擁有一件不褪流行的時裝</li>
                    <li>訂製一件具有意義的禮服</li>
                    <li>專屬於自己的風格西裝</li>
                    <li>不論台灣或海外的訂製，我們擁有豐富經驗</li>
                    <li>專業的量身訂製服務</li> -->
                </ul>
                <!-- 後台可置換文案 end -->
            </div>
        </div>
        <div class="col-12 timeline__sign--block">
            <div class="d-flex justify-content-end">
                <img class="timeline__sign" src="<?= base_url() ?>resource/assets/img/page-sign.svg" alt="">
            </div>
        </div>
    </div>
    <?
    $step1 = explode("\n", $data['online_step1']);
    $step2 = explode("\n", $data['online_step2']);
    $step3 = explode("\n", $data['online_step3']);
    $step4 = explode("\n", $data['online_step4']);

    ?>
    <div class="custom__flow">
        <!-- <p><em>Online Customized Service</em> ｜ 線上客製化流程</p>
        <p>Online Customized Service<br>線上客製化流程</p> -->
        <p><? echo $data['online_title'] ?></p>
        <div class="custom__flow--bg">
            <div class="custom__flow--box">
                <div class="custom__flow--box--content">
                    <div class="custom__flow--content--step d-flex justify-content-between">
                        <div class="d-flex align-items-center justify-content-center flex-column">
                            <!-- <p>線上諮詢<br>溝通款式</p> -->
                            <? foreach ($step1 as $on_st1) { ?>
                                <p><? echo $on_st1 ?></p>
                            <? } ?>
                        </div>
                        <div class="d-flex align-items-center justify-content-center flex-column">
                            <img src="<?= base_url() ?>resource/assets/img/custom/custom-arrow-right.png" alt="">
                        </div>
                        <div class="d-flex align-items-center justify-content-center flex-column">
                            <!-- <p>量身教學<br>胚衣製作</p> -->
                            <? foreach ($step2 as $on_st2) { ?>
                                <p><? echo $on_st2 ?></p>
                            <? } ?>
                        </div>
                        <div class="d-flex align-items-center justify-content-center flex-column">
                            <img src="<?= base_url() ?>resource/assets/img/custom/custom-arrow-right.png" alt="">
                        </div>
                        <div class="d-flex align-items-center justify-content-center flex-column">
                            <!-- <p>郵寄胚衣<br>尺寸修改</p> -->
                            <? foreach ($step3 as $on_st3) { ?>
                                <p><? echo $on_st3 ?></p>
                            <? } ?>
                        </div>
                        <div class="d-flex align-items-center justify-content-center flex-column">
                            <img src="<?= base_url() ?>resource/assets/img/custom/custom-arrow-right.png" alt="">
                        </div>
                        <div class="d-flex align-items-center justify-content-center flex-column">
                            <!-- <p>成品製作<br>發貨寄送</p> -->
                            <? foreach ($step4 as $on_st4) { ?>
                                <p><? echo $on_st4 ?></p>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?
    $step1_content = explode("\n", $data['step1_content']);
    $step2_content = explode("\n", $data['step2_content']);
    $step3_content = explode("\n", $data['step3_content']);

    ?>
    <div class="row">
        <div class="col-12 col-md-6 custom__step-content--img custom__step--order">
            <!-- <img src="<?= base_url() ?>resource/assets/img/custom/custom-step01.png" alt="step01"> -->
            <img src="<?= base_url() . $data['step1_img'] ?>" alt="step01">
        </div>
        <div class="col-12 col-md-6 d-flex justify-content-center flex-column custom__step-content custom__step--order">
            <img src="<?= base_url() ?>resource/assets/img/custom/custom-text-step01.png" alt="">

            <div class="custom__step-content--text">

                <h3>
                    <? echo $data['step1_title'] ?>
                </h3>

                <? foreach ($step1_content as $step1_c) { ?>
                    <p><? echo $step1_c ?></p>
                <? } ?>
                <!-- <h3>初版 細修身型</h3>
                <p>量身、溝通、選材都完成後，</p>
                <p>便開始替妳獨一無二的禮服製作「胚衣版型」</p>
                <p>在胚衣階段，追求完美的我們，會請妳再次試穿</p>
                <p>將胸線、腰身、領口、臀型、裙襬長等等細節再次確認</p>
                <p>每一絲毫都不放過，只求能做到最適合妳的絕美身型</p> -->
            </div>
            <img src="<?= base_url() ?>resource/assets/img/custom/custom-arrow-down.png" alt="">
        </div>
        <div class="col-12 col-md-6 d-flex justify-content-center flex-column custom__step-content custom__step--order">
            <img src="<?= base_url() ?>resource/assets/img/custom/custom-text-step02.png" alt="">

            <div class="custom__step-content--text">
                <h3>
                    <? echo $data['step2_title'] ?>
                </h3>
                <!-- <h3>二版 是 JENNY 對完美的堅持</h3>
                <p>試穿胚衣及專業的修改後，再依選擇的布料製作成「禮服半成品」</p>
                <p>在這階段，我們將請您再次試穿，確認所有尺寸都完美無瑕</p>
                <p>才會將屬於妳的量身設計，進程到最後的珠工與蕾絲縫製</p> -->
                <? foreach ($step2_content as $step2_c) { ?>
                    <p><? echo $step2_c ?></p>
                <? } ?>
            </div>
            <img src="<?= base_url() ?>resource/assets/img/custom/custom-arrow-down.png" alt="">
        </div>
        <div class="col-12 col-md-6 custom__step-content--img custom__step--order">
            <div></div>
            <!-- <img src="<?= base_url() ?>resource/assets/img/custom/custom-step02.png" alt="step02"> -->
            <img src="<?= base_url() . $data['step2_img'] ?>" alt="step02">
        </div>
        <div class="col-12 col-md-6 custom__step-content--img custom__step--order">
            <!-- <img src="<?= base_url() ?>resource/assets/img/custom/custom-step03.png" alt="step03"> -->
            <img src="<?= base_url() . $data['step3_img'] ?>" alt="step03">
        </div>
        <div class="col-12 col-md-6 d-flex justify-content-center flex-column custom__step-content custom__step--order">
            <img src="<?= base_url() ?>resource/assets/img/custom/custom-text-step03.png" alt="">
            <div class="custom__step-content--text">
                <h3>
                    <? echo $data['step3_title'] ?>
                </h3>
                <!-- <h3>完成，為妳勾勒的禮服</h3>
                <p>從『溝通、量身、打版、試胚衣、選布料、縫製珠工與蕾絲』</p>
                <p>等待了九十天的總合，即將伴隨步入另一階段的妳</p>
                <p>獨一無二，展現最美好的樣子</p>
                <p>這就是 JENNY CHOU 客製化禮服的魔力</p> -->
                <? foreach ($step3_content as $step3_c) { ?>
                    <p><? echo $step3_c ?></p>
                <? } ?>
            </div>
            <img src="<?= base_url() ?>resource/assets/img/custom/custom-arrow-down.png" alt="">
            <div class="custom__button">
                <img src="<?= base_url() ?>resource/assets/img/custom/custom-reservation.png" alt="">
                <div class="d-flex justify-content-center">
                    <a href="<?php echo base_url() . 'contact' ?>">我想訂製一件專屬禮服</a>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include 'templates/footer.php'; ?>