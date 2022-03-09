<?php include 'templates/header.php'; ?>

<!-- 麵包屑 start 後台目前抓link字串，須改抓 header 內文字 "MEDIA EXPOSURE" -->
<ul class="badge d-flex">
    <?php echo $badge; ?>
</ul>
<!-- 麵包屑 end 後台目前抓link字串，須改抓 header 內文字 "MEDIA EXPOSURE" -->
<?
    //判斷第一項
    $count_num=0 ;
    $count_block=0;
    $count_no_block=0;
    
?>
<div class="container">
    <div class="row media__exp--all">
        <? foreach ($post as $p) { ?>
            <div class="col-12 col-md-6 d-flex flex-column align-items-center justify-content-end" data-aos-delay="500" data-aos="fade-left">
                <a href="<?= $p['link'] ?>" target="_blank">
                    <div class="media__exp--img">
                        <img class="blowup_image" src="<?= base_url() . $p['img'] ?>" alt="">
                    </div>
                    <!-- <?!d($count_no_block);?> -->
                    <div class="media__exp--content">
                        <?
                            $title=explode("\n",$p['title']);
                        
                        ?>
                        <p>
                            <? echo $p['type'] ?>
                        </p>
                        <p>
                            <? echo $p['hash_tag'] ?>
                        </p>
                        <p>
                            <?
                                $count=0;
                                foreach($title as $ti){
                                    echo $ti; 
                                    if($count!= count($title)-1)
                                        echo '<br>';
                                    $count++;    
                                }    
                            ?>
                        </p>
                        <!-- 第一項 -->
                        <?if($count_num==0){$count_no_block=2;?>
                        <!-- 右邊方塊 -->
                        <?}else if( ($count_num%2==1) && $count_no_block==2 ){?>
                           
                            <div class="media__block media__block--right"></div>
                        <? $count_block++; 
                    
                            }else if( ($count_num%2==0) && $count_no_block==2){
                            
                        ?>
                        <!-- 左邊方塊 -->
                         <div class="media__block media__block--left"></div>
                         <?
                            $count_no_block=0;
                            //沒有方塊    
                            }else {
                                $count_no_block++;
                            }
                         ?>
                    </div>
                   
                </a>
            </div>
            <? $count_num++;?>
        <!--      <div class="col-12 col-md-6 d-flex flex-column align-items-center justify-content-end" data-aos-delay="500" data-aos="fade-left">
            <a href="https://thecirclejournal.com/interview-jennychou/" target="_blank">
                <div class="media__exp--img">
                    <img class="blowup_image" src="<?= base_url() ?>resource/assets/img/media/media__01.png" alt="">
                </div>
                <div class="media__exp--content">
                    <p>Blogger</p>
                    <p>#ALIAS MAGAZINE</p>
                    <p>
                        《風格人物專訪 - 手工訂製婚紗 JENNY CHOU》
                    </p>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-6 d-flex flex-column align-items-center justify-content-end" data-aos-delay="500" data-aos="fade-right">
            <a href="https://www.prestigeonline.com/tw/people-events/people/幸福裁縫師-tailor-of-happiness｜頂級訂製婚紗-jenny-chou/" target="_blank">
                <div class="media__exp--img">
                    <img src="<?= base_url() ?>resource/assets/img/media/media__02.png" alt="">
                </div>
                <div class="media__exp--content">
                    <p>Media</p>
                    <p>#Prestige Taiwan</p>
                    <p>
                        幸福裁縫師 TAILOR OF HAPPINESS | 頂級訂製婚紗
                    </p>
                    <div class="media__block media__block--right"></div>
                </div>
            </a>
        </div>
       <div class="col-12 col-md-6 d-flex flex-column align-items-center justify-content-end" data-aos-delay="500" data-aos="fade-left">
            <a href="https://www.weddingday.com.tw/blog/archives/66175" target="_blank">
                <div class="media__exp--img">
                    <img src="<?= base_url() ?>resource/assets/img/media/media__03.png" alt="">
                </div>
                <div class="media__exp--content">
                    <p>Media</p>
                    <p>#WeddingDay 好婚專欄/品牌快訊</p>
                    <p>
                        JENNY CHOU Couture | 內湖隱密禮服工坊 隆重開幕
                    </p>
                    <div class="media__block media__block--left"></div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-6 d-flex flex-column align-items-center justify-content-end" data-aos-delay="500" data-aos="fade-right">
            <a href="https://www.prestigeonline.com/tw/profiles/jenny-chou/" target="_blank">
                <div class="media__exp--img">
                    <img src="<?= base_url() ?>resource/assets/img/media/media__04.png" alt="">
                </div>
                <div class="media__exp--content">
                    <p>Media</p>
                    <p>#Prestige Taiwan</p>
                    <p>
                        2020 PRESTIGE 遴選 40 UNDER 40 菁英領袖
                    </p>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-6 d-flex flex-column align-items-center justify-content-start" data-aos-delay="500" data-aos="fade-left">
            <a href="https://tw.news.yahoo.com/時尚指標-空姐最愛婚紗top3大公開-073128575.html" target="_blank">
                <div class="media__exp--img">
                    <img src="<?= base_url() ?>resource/assets/img/media/media__05.png" alt="">
                </div>
                <div class="media__exp--content">
                    <p>Media</p>
                    <p>#風傳媒</p>
                    <p>
                        時尚指標，空姐最愛婚紗Top3大公開
                    </p>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-6 d-flex flex-column align-items-center justify-content-start" data-aos-delay="500" data-aos="fade-right">
            <a href="https://brenda.tw/fabulouswomen_jennychou/" target="_blank">
                <div class="media__exp--img">
                    <img src="<?= base_url() ?>resource/assets/img/media/media__06.png" alt="">
                </div>
                <div class="media__exp--content">
                    <p>Blogger</p>
                    <p>#BRENDA FABULOUS</p>
                    <p>
                        30小姐系列 | 訂製婚紗設計師JENNY CHOU：<br>「非本科又如何？女人追求的從來不是匠心而是誰能懂你」
                    </p>
                    <div class="media__block media__block--right"></div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-6 d-flex flex-column align-items-center justify-content-end" data-aos-delay="500" data-aos="fade-left">
            <a href="https://eberinkou.blogspot.com/2018/12/jennychou-10th-show.html" target="_blank">
                <div class="media__exp--img">
                    <img src="<?= base_url() ?>resource/assets/img/media/media__07.png" alt="">
                </div>
                <div class="media__exp--content">
                    <p>Blogger</p>
                    <p>#EBERIN.KOU</p>
                    <p>
                        JENNY CHOU品牌十周年：華美婚紗走秀<br>特製法式饗宴，給妳一個盛裝打扮的理由
                    </p>
                    <div class="media__block media__block--left"></div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-6 d-flex flex-column align-items-center justify-content-end" data-aos-delay="500" data-aos="fade-right">
            <a href="https://www.cheriestylery.com/post/我也可以穿上性感魚尾禮服嗎？高級訂製禮服設計師jenny-chou教妳如何從身形挑選歐美風格婚紗" target="_blank">
                <div class="media__exp--img">
                    <img src="<?= base_url() ?>resource/assets/img/media/media__08.png" alt="">
                </div>
                <div class="media__exp--content">
                    <p>Blogger</p>
                    <p>#Cherie Stylery by Cherie Chen</p>
                    <p>
                        我也可以穿上性感魚尾禮服嗎？教妳如何從身形<br>挑選歐美風格婚紗
                    </p>
                </div>
            </a>
        </div> -->
        <? } ?>
    </div>
</div>
<?php include 'templates/footer.php'; ?>