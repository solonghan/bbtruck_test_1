<!-- HEADER LOGO & MENU -->
<header id="header">
    <div class="header_top header_menu_home2 hidden-xs hidden-sm " id="header-top">
        <div class="container">
            <div class="wrapper-menu">
                <!-- HEADER LOGO -->
                <div class="header_logo">
                    <a href="<?= base_url() ?>"><img class="" src="<?= base_url() ?>public/element/logo.jpg" alt="image" title="logo"></a>
                </div>
                <!-- END / HEADER LOGO -->
                <!-- HEADER MENU -->
                <nav class="header_menu header_second last_home">
                    <ul class="menu">
                        <li class="current-menu-item">
                            <a href="<?= base_url() ?>" title="Home">首頁</a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>home/founder/book" title="創辦人介紹">創辦人介紹</a>
                            <ul class="sub-menu">
                                <li><a href="<?= base_url() ?>home/founder/book#tab-page">著作</a></li>
                                <? if ($event_menu[0]['is_show'] != 1) { ?>
                                    <li><a href="<?= base_url() ?>home/founder/speech#tab-page">演講</a></li>
                                <? } ?>
                                <? if ($activity_menu[0]['is_show'] != 1) { ?>
                                    <li><a href="<?= base_url() ?>home/founder/workshop#tab-page">工作坊</a></li>
                                <? } ?>
                                <? if ($activity_menu[1]['is_show'] != 1) { ?>
                                    <li><a href="<?= base_url() ?>home/founder/experience#tab-page">體驗會</a></li>
                                <? } ?>
                                <? if ($activity_menu[2]['is_show'] != 1) { ?>
                                    <li><a href="<?= base_url() ?>home/founder/studygroup#tab-page">讀書會</a></li>
                                <? } ?>
                                <? if ($event_menu[1]['is_show'] != 1) { ?>
                                    <li><a href="<?= base_url() ?>home/founder/communicate#tab-page">交流會</a></li>
                                <? } ?>
                                <li><a href="<?= base_url() ?>home/founder/media#tab-page">媒體專訪</a></li>
                                <? if ($event_menu[2]['is_show'] != 1) { ?>
                                    <li><a href="<?= base_url() ?>home/founder/donate#tab-page">基金會物資捐贈</a></li>
                                <? } ?>
                            </ul>
                        </li>
                        <li class="current-menu-item">
                            <a href="<?= base_url() ?>#classprogram" title="">主題課程</a>
                            <ul class="sub-menu">

                                <?
                                foreach ($topic as $to) { ?>
                                    <li><a href="<?= base_url() ?>classify/index/<?= $to['id'] ?>" title=""><?= $to['title'] ?></a></li>
                                <? } ?>

                            </ul>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>learn" title="">學習專區</a>
                            <ul class="sub-menu">
                                <!-- <li><a href="<?= base_url() ?>v/learn" title="">All</a></li> -->
                                <li><a href="<?= base_url() ?>video" title="">學習課程</a></li>
                                <li><a href="<?= base_url() ?>audio" title="">音頻</a></li>
                                <li><a href="<?= base_url() ?>product" title=" ">圖卡與書籍/商品</a></li>
                                <li><a href="<?= base_url() ?>activity" title="">活動</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>contact" title="">諮詢服務</a>
                            <ul class="sub-menu">
                                <li><a href="<?= base_url() ?>experience" title="">線上體驗</a></li>
                                <li><a href="<?= base_url() ?>contact" title="">面談諮詢</a></li>
                                <li><a href="<?= base_url() ?>contact" title="">線上諮詢</a></li>
                                <!-- <li><a href="<?= base_url() ?>v/contact#reserve" title=" ">我要預約</a></li> -->
                            </ul>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>blog/index/all" title="BLog">Blog</a>
                            <ul class="sub-menu">
                                <li><a href="<?= base_url() ?>blog/index/all#s" title="">All</a></li>
                                <li><a href="<?= base_url() ?>blog/index/icu#s" title="">ICU心靈相談</a></li>
                                <li><a href="<?= base_url() ?>blog/index/book#s" title=" ">沈唐書摘</a></li>
                                <li><a href="<?= base_url() ?>blog/index/mental#s" title="">沈唐心語</a></li>
                                <li><a href="<?= base_url() ?>blog/index/week#s" title="">沈唐週話</a></li>
                            </ul>
                        </li>
                        <li class="current-menu-item">
                            <a href="<?= base_url() ?>faq/index/all" title="FAQ">FAQ</a>
                        </li>
                        <? if ($isLogin == 1) { ?>
                            <li class="current-menu-item">
                                <a class="menusignin" href="<?= base_url() ?>member/home/tw" title=""><i class="fa fa-user"></i> 會員中心</a>
                            </li>
                        <? } ?>

                        <li class="current-menu-item">
                            <? if ($isLogin != 1) { ?>
                                <a class="menusignin" href="<?= base_url() ?>home/login/tw" title=""><i class="fa fa-user"></i> 登入／註冊</a>
                            <? } else { ?>
                                <a class="menusignin" href="<?= base_url() ?>home/logout/tw" title="">登出</a>
                            <? } ?>
                        </li>
                        <li>
                    </ul>
                </nav>
                <!-- END / HEADER MENU -->
            </div>
        </div>
    </div>
</header>
<!-- END-HEADER -->
<!-- HEADER LOGO & MENU MOBILE -->
<div class="wrapper"></div>
<nav class="menu-mobile hidden-md hidden-lg menu-mobile1">
    <ul>
        <li class="dropdown">
            <a href="<?= base_url() ?>" title="HOME">首頁</a>
        </li>
        <li class="dropdown">
            <a href="<?= base_url() ?>home/founder/book" class="dropdown-toggle" data-toggle="dropdown">創辦人介紹<span class="fa fa-caret-down"></span></a>
            <ul class="dropdown-menu mini-item-mobile">
                <li><a href="<?= base_url() ?>home/founder/book#tab-page">著作</a></li>
                <? if ($event_menu[0]['is_show'] != 1) { ?>
                    <li><a href="<?= base_url() ?>home/founder/speech#tab-page">演講</a></li>
                <? } ?>
                <? if ($activity_menu[0]['is_show'] != 1) { ?>
                    <li><a href="<?= base_url() ?>home/founder/workshop#tab-page">工作坊</a></li>
                <? } ?>
                <? if ($activity_menu[1]['is_show'] != 1) { ?>
                    <li><a href="<?= base_url() ?>home/founder/experience#tab-page">體驗會</a></li>
                <? } ?>
                <? if ($activity_menu[2]['is_show'] != 1) { ?>
                    <li><a href="<?= base_url() ?>home/founder/studygroup#tab-page">讀書會</a></li>
                <? } ?>
                <? if ($event_menu[1]['is_show'] != 1) { ?>
                    <li><a href="<?= base_url() ?>home/founder/communicate#tab-page">交流會</a></li>
                <? } ?>
                <li><a href="<?= base_url() ?>home/founder/media#tab-page">媒體專訪</a></li>
                <? if ($event_menu[2]['is_show'] != 1) { ?>
                    <li><a href="<?= base_url() ?>home/founder/donate#tab-page">基金會物資捐贈</a></li>
                <? } ?>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown">主題課程<span class="fa fa-caret-down"></span></a>
            <ul class="dropdown-menu mini-item-mobile">
                <? foreach ($topic as $t) { ?>
                    <li><a href="<?= base_url() ?>classify/index/<?= $t['id'] ?>" title=""><?= $t['title'] ?></a></li>
                <? } ?>
            </ul>
        </li>

        <li class="dropdown">
            <a href="<?= base_url() ?>learn" class="dropdown-toggle" data-toggle="dropdown">學習專區<span class="fa fa-caret-down"></span></a>
            <ul class="dropdown-menu mini-item-mobile">
                <li><a href="<?= base_url() ?>learn" title="">學習專區</a></li>
                <li><a href="<?= base_url() ?>video" title="">學習課程</a></li>
                <li><a href="<?= base_url() ?>audio" title="">音頻</a></li>
                <li><a href="<?= base_url() ?>product" title=" ">圖卡與書籍/商品</a></li>
                <li><a href="<?= base_url() ?>activity" title="">活動</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="<?= base_url() ?>contact" class="dropdown-toggle" data-toggle="dropdown">諮詢服務<span class="fa fa-caret-down"></span></a>
            <ul class="dropdown-menu mini-item-mobile">
                <li><a href="<?= base_url() ?>experience" title="">線上體驗</a></li>
                <li><a href="<?= base_url() ?>contact" title="">面談諮詢</a></li>
                <li><a href="<?= base_url() ?>contact" title="">線上諮詢</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="<?= base_url() ?>blog/index/all" class="dropdown-toggle" data-toggle="dropdown">Blog<span class="fa fa-caret-down"></span></a>
            <ul class="dropdown-menu mini-item-mobile">
                <li><a href="<?= base_url() ?>blog/index/all#s" title="">All</a></li>
                <li><a href="<?= base_url() ?>blog/index/icu#s" title="">ICU心靈相談</a></li>
                <li><a href="<?= base_url() ?>blog/index/book#s" title=" ">沈唐書摘</a></li>
                <li><a href="<?= base_url() ?>blog/index/mental#s" title="">沈唐心語</a></li>
                <li><a href="<?= base_url() ?>blog/index/week#s" title="">沈唐週話</a></li>
            </ul>
        </li>
        <li class="">
            <a href="<?= base_url() ?>faq/index/all" class="dropdown-toggle">FAQ</a>
        </li>
        <li class="">


            <? if ($isLogin != 1) { ?>
                <a href="<?= base_url() ?>home/login/tw"><i class="fa fa-user color-white"></i> 登入／註冊</a>
            <? } else { ?>
                <a href="<?= base_url() ?>member/home/tw"><i class="fa fa-user"></i> 會員中心</a>
                <a href="<?= base_url() ?>home/logout/tw"><i class="fa fa-user color-white"></i> 登出</a>
            <? } ?>

            <!-- <a href="<?= base_url() ?>home/login/tw"><i class="fa fa-user color-white"></i> 登入／註冊</a> -->
        </li>
    </ul>
</nav>
<header class="navbar  hidden-md hidden-lg small" id="header-top1">
    <div class="container">
        <a class="brand" href="<?= base_url() ?>"><img class="" style="width:24rem;" src="<?= base_url() ?>public/element/logo.jpg" alt="image"></a>
        <button class="togglebutton">
            <span class="oct-line"></span>
            <span class="oct-line"></span>
            <span class="oct-line"></span>
        </button>
    </div>
</header>