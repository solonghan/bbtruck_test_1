<?php include 'templates/header.php'; ?>

<script>
    var map;

    function initMap() {
        var position = {
            lat: 25.06231123268149,
            lng: 121.58776396926086
        };
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: position,
        });
        var marker = new google.maps.Marker({
            position: position,
            map: map,
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOLgnZ23aBss3bDfZg2oGl1SKcSnRtiGk&callback=initMap" async defer></script>

<!-- 麵包屑 start 後台目前抓link字串，須改抓 header 內文字 -->
<ul class="badge d-flex">
    <?php echo $badge; ?>
</ul>
<!-- 麵包屑 end 後台目前抓link字串，須改抓 header 內文字 "CONTACT US" -->

<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 images-sprit-main">
            <div class="contact-banner">
                <img alt="contact-main" src="img/contact/img_contact.jpg">
            </div>
        </div>
    </div>
    <div class="row align-items-start pt-50 pb-50 contact-s">
        <div class="col-lg-4 col-md-4 contact-row">
            <div class="mb-50">
                <h3 class="pb-20 title-s">Contact us</h3>
                <div class="contact-list">
                    <a href="tel:+886-2-2717-1355" class="contact-list-item"><i class="fa fa-phone fa-lg fa-fw mr-10" aria-hidden="true"></i>+886-2-2717-1355</a>
                    <a href="mailto:wedjenny@gmail.com" class="contact-list-item"><i class="fa fa-envelope fa-lg fa-fw mr-10" aria-hidden="true"></i>wedjenny@gmail.com</a>
                    <a href="https://g.page/JENNYCHOUCOUTURE?share" target="_blank" class="contact-list-item"><i class="fa fa-map-marker fa-lg fa-fw mr-10" aria-hidden="true"></i>台北市內湖區金莊路26號5樓之5</a>
                </div>
            </div>
            <div class="mb-50">
                <h3 class="pb-20 title-s">Follow us</h3>
                <div class="contact-list">
                    <a href="https://www.facebook.com/jennychouweddinggown/" class="contact-list-item" target="_blank"><i class="icon-social-facebook-square fa-lg fa-fw mr-10"></i>JENNY CHOU Couture</a>
                    <a href="https://www.instagram.com/jennychoucouture" class="contact-list-item" target="_blank"><i class="icon-social-instagram fa-lg fa-fw mr-10"></i>jennychoucouture</a>
                    <a href="http://line.me/ti/p/@jennychou" class="contact-list-item" target="_blank"><span class="icon icon-line mr-10"></span>@jennychou</a>
                    <a href="https://www.youtube.com/channel/UCoNFsFehZ5q2pJwMhqa2vpQ" class="contact-list-item" target="_blank"><i class="fa fa-youtube-play fa-lg fa-fw mr-10"></i>JENNY CHOU</a>
                    <a href="https://in.pinterest.com/wedjennychou/" class="contact-list-item" target="_blank"><i class="icon-social-pinterest fa-lg fa-fw mr-10"></i>JENNY CHOU Couture</a>
                </div>
            </div>
            <div class="mb-50">
                <h3 class="pb-20 title-s">Online Payment</h3>
                <div class="contact-list">
                    <a href="https://payment.ecpay.com.tw/QuickCollect/PayData?gB8CnokUehQ%2f1lIQBQRVWFiMek9A7XtUL2wWcuQVgO8%3d" class="contact-list-item" target="_blank"><i class="fa fa-credit-card fa-lg fa-fw mr-10" aria-hidden="true"></i>ECPay</a></li>
                </div>
            </div>
        </div>

        <!-- 聯絡表單 start -->
        <div class="col-lg-8 col-md-8 mobile-order">
            <div class="contact-form-area">
                <h3>聯絡我們</h3>
                <form action="<?= base_url() ?>contact/post" method="post">
                    <div class="single-contact-form">
                        <input name="name" type="text" placeholder="姓名 Name　*">
                    </div>
                    <div class="single-contact-form">
                        <input name="email" type="email" placeholder="信箱 Email Address　*">
                    </div>
                    <div class="single-contact-form">
                        <input name="phone" type="phone" placeholder="電話 Phone Number　*">
                    </div>

                    <div class="login-guest-top">
                        <div class="tab-content">
                            <div class="checkout-guest-wrap">
                                <select class=" nice-select-style-3 cart-tax-select mb-30" style="border:1px solid #424242;height:45px;" name="demand">
                                    <option selected="">需求 Subject　*</option>
                                    <option value="Tailor-made_Couture_Dress">客製量身訂做 Tailor-made Couture Dress</option>
                                    <option value="Buy_New_Wedding_Gown">購買全新白紗 Buy New Wedding Gown</option>
                                    <option value="Dress_Rental">禮服租借 Dress Rental</option>
                                    <option value="Business_Partnership">商業合作 Business Partnership</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <p class="cotitle">使用日期 Wedding Date</p>
                    <div class="single-contact-form">
                        <input type="date" name="wedding_date">
                    </div>

                    <p class="cotitle">預約日期 Appointment Date</p>
                    <div class="single-contact-form">
                        <input type="date" name="appoint_date">
                    </div>

                    <div class="single-contact-form">
                        <textarea name="message" placeholder="訊息 *" spellcheck="false"></textarea>
                        <button class="submit" type="submit">Send Message</button>
                    </div>
                </form>
                <p class="form-messege"></p>
            </div>
        </div>
        <!-- 聯絡表單 end -->
        <?
        $content = explode("\n", $data['content']);

        ?>
        <div class="col-12 text-center pb-50 contact__text">
            <? foreach ($content as $c) {?>
            <p>
                <? echo $c ?>
            </p>
            <?}?>
            <!-- <p>第一家實體店面位於敦北林蔭大道旁，自2020十一月搬遷至內湖區金莊路26號5樓之5</p>
            <p>從創業就堅持手工打版製圖，從無到有，禮服全程都在台灣設計、打版、製作，完美呈現亞洲女性的身形曲線</p>
            <p>融合簡潔時尚、優雅與性感兼具的風格，並致力將女性的衣著品味細膩提升</p>
            <p>同時期待台灣婚紗的精細工藝，更能被國際看見</p> -->
        </div>
    </div>
    <div class="mx-auto" id="map"></div>
</div>
<?php include 'templates/footer.php'; ?>