<footer id="footer_home2" class="pt-5">
    <div class="container">
        <div class="row">
            <!-- FOOTER LEFT -->
            <div class="footer_left col-12 col-sm-4">
                <div class="">
                    <div class="title">訂閱付費電子報</div>
                    <div class="line"></div>
                    <!-- <div class="logo">
                            <img class="w-50" src="<?= base_url() ?>public/element/logo.jpg" alt="書齋logo">
                        </div> -->
                    <div class="content" style="text-align:left;">
                        沈唐 首創華人世界唯一「我懂你諮詢」！<br>潛意識溝通，以自創 我懂你 圖卡爲工具，協助處理各種人世間疑問。沈唐將這世界人事物的觀察，都繪製在這圖中。
                    </div>
                    <!-- <div class="social">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook-official" style="color:#4267B2;"></i></a></li>
                            </ul>
                        </div> -->
                    <div class="mailchimp">
                        <p>＊自訂閱日起一年費用為100元，每週更新。</p>
                        <div class="mailchimp-form">
                            <form class="form-inline mt-1" action="<?= base_url() ?>home/email/tw" method="POST">
                                <input type="email" name="email1" placeholder="輸入Email付費訂閱" class="input-text">
                                <!-- <button class="awe-btn"><span class="emailsub">付費訂閱</span></button> -->
                                <a type="button" data-toggle="modal" data-target="#buyclass_email" class="awe-btn"><img src="<?= base_url() ?>assets/images/plane_h2.png" alt="image"></a>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END / FOOTER LEFT -->
            <!-- FOOTER CONTENT -->
            <div class="footer_content col-12 col-sm-4">
                <div class="">
                    <div class="title">追蹤臉書專頁</div>
                    <div class="line"></div>
                    <div class="text-center">
                        <div class="fb-page" data-href="https://www.facebook.com/ICUcards/" data-tabs="timeline" data-width="300" data-height="200" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                            <blockquote cite="https://www.facebook.com/ICUcards/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/ICUcards/">沈唐我懂你諮詢</a></blockquote>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END / FOOTER CONTENT -->
            <!-- FOOTER RIGHT -->
            <div class="footer_right col-12 col-sm-4">
                <div class="">
                    <div class="title">邀約聯繫</div>
                    <div class="line"></div>
                    <div class="content mt-0">
                        <a href="mailto:service@icucard.com">
                            <i class="fa fa-envelope mr-3"></i>
                        </a>
                        <a href="tel:+886-986580541">
                            <i class="fa fa-phone"></i>
                        </a>
                        <br>
                        <i class="fa fa-map-marker mr-1"></i>台北市大安區忠孝東路四段250號10樓-3
                        <iframe class="mt-3" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3614.792511577082!2d121.5519843150063!3d25.041114583969016!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3442abc677ecf39d%3A0xede0620363705447!2zMTA25Y-w5YyX5biC5aSn5a6J5Y2A5b-g5a2d5p2x6Lev5Zub5q61MjUw6Jmf!5e0!3m2!1szh-TW!2stw!4v1591850524904!5m2!1szh-TW!2stw" width="100%" height="150" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>

                </div>
            </div>
            <!-- END / FOOTER RIGHT -->
            <!-- FOOTER BOTTOM -->
            <div class="footer_bottom_h2 col-12">
                <hr class="mt-5" style="border-top: 1px solid #000000;">
                <div class="">
                    <p class="text-center"><?= $web_copyright ?></p>
                </div>
            </div>
            <!-- END / FOOTER BOTTOM -->
        </div>
    </div>
</footer>
<!-- END / FOOTER -->
<!--SCOLL TOP-->
<a href="#" title="sroll" class="scrollToTop"><i class="fa fa-long-arrow-up color-white"></i></a>
<!--END / SROLL TOP-->


<!-- 彈跳視窗 -->
<div class="modal fade" id="buyclass_email" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-inline" id="exampleModalLongTitle">付款資訊</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="<?= base_url() ?>home/email/tw" method="post">

                    <input type="hidden" name="email" value=''>

                    <div class="radio ">
                        <label class="padding-right">
                            <input type="radio" name="payment" group="payment" value="credit" checked>線上信用卡支付</label>
                        <div class="card d-inline ml-2">

                            <img src="<?= base_url() ?>assets/images/class/mas.png" alt="#" class="">
                            <img src="<?= base_url() ?>assets/images/class/visa.png" alt="#" class="">
                            <img src="<?= base_url() ?>assets/images/class/111.png" alt="#" style="width:51px;" class="">

                        </div>
                    </div>
                    <div class="radio margin-bottom">
                        <label>
                            <input type="radio" name="payment" group="payment" value="atm">線上轉帳</label>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-gray px-5" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-orange px-5">確認</button>


            </div>
        </div>
        </form>
    </div>
</div>


<!-- JS -->

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
<!-- Custom jQuery -->


<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5eba110cdf9e2437"></script>


<!-- footer臉書專頁 -->
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v7.0&appId=3055279061172119&autoLogAppEvents=1"></script>



<!-- 1. Add latest jQuery and fancybox files -->
<!-- <script src ="<?= base_url() ?>assets/dist/jquery-3.2.1.min.js"> </script> -->
<script src="<?= base_url() ?>assets/dist/jquery.fancybox.min.js"> </script>

<script type="text/javascript">
    $(document).ready(function() {

        //E-MAIL格式檢查

        $("body").on("click", ".awe-btn", function() {

            $Emailchecking = IsEmail($('input[name=email1]').val());


            if ($Emailchecking == false) {

                alert("請填寫正確的E-MAIL格式");

                return false;

                // $("#email").blur(); //離開焦點

            }

            var email = $('input[name=email1]').val();
            $('input[name=email]').val(email);


        })

        $("body").on('keypress', function(event) {
            $Emailchecking = IsEmail($('input[name=email1]').val());

            if (event.which == 13) {

                if ($Emailchecking == false) {

                    alert("請填寫正確的E-MAIL格式");

                    return false;

                    // $("#email").blur(); //離開焦點

                }

                var email = $('input[name=email1]').val();
                $('input[name=email]').val(email);

                alert("請點選後方按鈕選擇付款方式");
                return false;
            }
        });

        //email判別
        function IsEmail(email) {

            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (!regex.test(email)) {

                return false;

            } else {

                return true;

            }

        }

    });



    // $('.awe-btn').click(function() {
    //     if($('input[name=email1]').val()==""){
    //         alert('請輸入email!');
    //         return false
    //     }else{

    //     var email = $('input[name=email1]').val();
    //     $('input[name=email]').val(email);
    //     }
    // })


    $('.navItems').click(function() {
        var navto = $(this).attr('navto');
        if (navto != "#") {

            var $div = $('#' + navto);
            var top = $div.offset().top || 0;
            $('html,body').animate({
                'scroll-top': top - 100
            }, 500);
        } else {
            $('html,body').animate({
                'scroll-top': 0
            }, 500);

        }

    });

    $(function() {
        $(".flip22").click(function() {
            $(".panel22").slideToggle("slow");
            $(".xs1").toggle();
            $(".xs2").toggle();
        });
    });
</script>


</body>

</html>