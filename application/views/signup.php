<?php require_once('templates/header.php')?>



  <!-- BANNER -->
    <section class="banner interactive">
    </section>
    <!-- END-BANNER -->

    <section class="accordions bg-white contact-v2">
        <div class="container">
            <h1 class="title-all black mb-0">會員註冊</h1>
            <p class="titleline black"></p>
            <!-- <p class="text-center pt-2">登入後可修改個人資料與查看訂單資訊</p> -->
            <div class="row">
                <div class="my-account col-12 col-lg-6 main-center pt-0">
                    <div class="">
                        <form class="" method="post" action="<?=base_url()?>home/register/tw">
                            <div class="form-group">
                                <label for="name">姓名 <span>*</span></label>
                                <input type="name" class="form-control" id="name" name="username" placeholder="請輸入全名">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">電子郵件 <span>*</span></label>
                                <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="請輸入Email(此為以後帳號)">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">密碼設定 <span>*</span></label>
                                <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="請輸入密碼">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2">再次確認密碼 <span>*</span></label>
                                <input type="password" class="form-control" id="exampleInputPassword2" name="password2" placeholder="請再次輸入密碼">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="confirm"> 我同意隱私權政策與服務條款
                                </label>
                            </div>
                            <div class="col-12 px-0">
                                <input class="btn-login" name="login" value="註冊" type="submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>

<script>
          $(".btn-login").click(function(){
            var submit = true;


              if($("input[name=username]").val() == ""){
                  alert("請填寫姓名");
                  submit =  false;                    
              }
              if($("input[name=email]").val()==""){
                  alert("請填寫email");
                  submit =  false;                      
              }
              console.log($("input[name=password]").val());
              console.log($("input[name=password2]").val());
            if($("input[name=password]").val()!=$("input[name=password2]").val()){
                  alert("二次輸入密碼不相同");
                  submit =  false;                      
              }
              if(!$('input[name=confirm]').is(':checked')){
                  alert("請勾選確認隱私權政策與服務條款");
                  submit =  false;                          
              }
           


              

              if(submit){
                  document.form.submit();
              }else{
                return false;
              }
          })
</script>




<?php require_once('templates/footer.php')?>
