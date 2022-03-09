<?php require_once('templates/header.php')?>



  <!-- BANNER -->
    <section class="banner interactive">
    </section>
    <!-- END-BANNER -->

    <section class="accordions bg-white contact-v2">
        <div class="container">
            <h1 class="title-all black mb-0">會員登入</h1>
            <p class="titleline black"></p>
            <p class="text-center pt-2">登入後可修改個人資料與查看訂單資訊</p>
            <div class="row">
                <div class="my-account col-12 col-lg-6 main-center pt-0">
                    <div class="">
                         <form class="" method="post" action="<?=base_url()?>home/login/tw">
                            <div class="form-group">
                                <label for="exampleInputEmail1">電子郵件 <span>*</span></label>
                                <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">密碼 <span>*</span></label>
                                <input type="password" class="form-control" id="exampleInputPassword1" name="password"  placeholder="請輸入密碼">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> 記住帳號
                                </label>
                            </div>
                            <div class="col-12 px-0">
                                <button type="submit" class="btn-login">登入</button>
                            </div>
                            <p class="">
                                還不是會員嗎？ <a href="<?=base_url()?>home/register/tw" class="color-pink">加入會員</a>
                            </p>
                            <p class="woocommerce-LostPassword lost_password">
                                <a href="<?=base_url()?>home/forget/tw" class="color-main">忘記密碼？</a>
                            </p>
                            <hr>
                            <!-- <p class="text-center">或是其他的登入方式</p>
                            <a href="<?=base_url()?>home/fb_login/tw" class="signin-fb"><i class="fa fa-facebook-official mr-2"></i>臉書登入</a> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>



<?php require_once('templates/footer.php')?>