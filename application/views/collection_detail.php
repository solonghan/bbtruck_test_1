<!doctype html>
<html class="no-js" lang="en">
<base href="<?php echo base_url() ?>resource/assets/">
</base>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Jenny Chou | 禮服訂製 手工婚紗 禮服租售 婚紗攝影 自助婚紗</title>
    <meta name="robots" content="index, follow" />
    <meta name="description" content="獨創設計的台灣婚紗設計師暨品牌JENNY CHOU，創立於2008年。Jenny用自己的名為品牌命名，承諾你 穿上 最能勾勒出女性自信美的婚紗與禮服">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">

    <!-- All CSS is here
	============================================ -->

    <link rel="stylesheet" href="css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="css/vendor/vandella.css">
    <link rel="stylesheet" href="css/vendor/jellybelly.css">
    <link rel="stylesheet" href="css/vendor/icofont.min.css">
    <link rel="stylesheet" href="css/vendor/fontello.css">
    <link rel="stylesheet" href="css/plugins/easyzoom.css">
    <link rel="stylesheet" href="css/plugins/slick.css">
    <link rel="stylesheet" href="css/plugins/nice-select.css">
    <link rel="stylesheet" href="css/plugins/animate.css">
    <link rel="stylesheet" href="css/plugins/magnific-popup.css">
    <link rel="stylesheet" href="css/plugins/jquery-ui.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/new.css">

    <link rel="stylesheet" href="css/slide.css">
    <link rel="stylesheet" href=" https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <link rel="canonoical" href="https://weddingjenny.com/">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-68883334-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-68883334-1');
    </script>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-N6XW8L6');
    </script>
    <!-- End Google Tag Manager -->

</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N6XW8L6" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="main-wrapper-3">
        <header class="header-area section-padding-5 header-ptb-2 sticky-bar">
            <!-- header for PC -->
            <div class="header-large-device">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="logo text-center">
                                <a href="<?php echo base_url() . 'home' ?>">
                                    <img src="img/logo.svg" alt="jennychou" height="42">
                                </a>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="header-action-wrap header-action-flex-center">
                                <div class="main-menu main-menu-padding-1">
                                    <nav>
                                        <ul>
                                            <li><a href="<?php echo base_url() . 'home' ?>">HOME</a></li>
                                            <li><a href="#0">ABOUT</a>
                                                <ul class="mega-menu-style-1 mega-menu-width2">
                                                    <li><a class="menu-title" href="<?php echo base_url() . 'About/brand' ?>">THE BRAND</a></li>
                                                    <li><a class="menu-title" href="<?php echo base_url() . 'About/designer' ?>">DESIGNER</a></li>
                                                    <li><a class="menu-title" href="<?php echo base_url() . 'About/timeline' ?>">TIMELINE</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="<?php echo base_url() . 'customized' ?>">CUSTOMIZED</a></li>
                                            <li><a href="#0">COLLECTION</a>
                                                <ul class="mega-menu-style-1 mega-menu-width2">
                                                    <!-- 後台可新增 collection 下的分類 目前有 bridal gowns, evening gowns 要改抓取文字，不能有dash符號 -->
                                                    <? foreach ($category as $value) : ?>
                                                        <li><a class="menu-title" href="<?php echo base_url() . 'collection/index/'. $value['lower_case'] ?>"><?php echo $value['upper_case']; ?></a></li>
                                                    <? endforeach; ?>
                                                    <!-- ready to wear 是 collection 中獨立頁面，後台需另外處理 -->
                                                    <li><a class="menu-title" href="<?php echo base_url() . 'ReadyToWear' ?>">READY TO WEAR</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="<?php echo base_url() . 'bride' ?>">OUR BRIDE</a></li>
                                            <li><a href="<?php echo base_url() . 'media' ?>">MEDIA EXPOSURE</a></li>
                                            <li><a href="<?php echo base_url() . 'contact' ?>">CONTACT US</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header for PC -->
            <!-- header for mobile -->
            <div class="header-small-device">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="header__menu--mobile">
                            <div class="header-action-wrap header-action-flex header-action-mrg-1">
                                <div class="same-style header-info">
                                    <button class="mobile-menu-button-active">
                                        <span class="info-width-1"></span>
                                        <span class="info-width-2"></span>
                                        <span class="info-width-3"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="header__logo--mobile">
                            <div class="mobile-logo">
                                <a href="<?php echo base_url() . 'home' ?>">
                                    <img alt="jennychou" src="img/logo.svg">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header for mobile -->
        </header>

        <!-- Mobile menu start -->
        <div class="mobile-menu-active clickalbe-sidebar-wrapper-style-1 clickalbe-menu-sidebar-left">
            <div class="clickalbe-sidebar-wrap">
                <a class="sidebar-close"><i class="icofont-close-line"></i></a>
                <div class="mobile-menu-content-area sidebar-content-100-percent">

                    <div class="clickable-mainmenu-wrap clickable-mainmenu-style1">
                        <nav>
                            <ul>
                                <li><a href="<?php echo base_url() . 'home' ?>">HOME</a></li>
                                <li class="has-sub-menu"><a href="#0">ABOUT</a>
                                    <ul class="sub-menu-2">
                                        <li><a href="<?php echo base_url() . 'About/brand' ?>">THE BRAND</a></li>
                                        <li><a href="<?php echo base_url() . 'About/designer' ?>">DESIGNER</a></li>
                                        <li><a href="<?php echo base_url() . 'About/timeline' ?>">TIMELINE</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?php echo base_url() . 'customized' ?>">CUSTOMIZED</a></li>
                                <li class="has-sub-menu"><a href="#">COLLECTION</a>
                                    <ul class="sub-menu-2">
                                        <? foreach ($category as $value) : ?>
                                            <li><a class="menu-title" href="<?php echo base_url() . 'collection/index/'. $value['lower_case'] ?>"><?php echo str_replace("-","  ",$value['upper_case']); ?></a></li>
                                        <? endforeach; ?>
                                        <li><a class="menu-title" href="<?php echo base_url() . 'ReadyToWear' ?>">READY TO WEAR</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?php echo base_url() . 'bride' ?>">OUR BRIDE</a></li>
                                <li><a href="<?php echo base_url() . 'media' ?>">MEDIA EXPOSURE</a></li>
                                <li><a href="<?php echo base_url() . 'contact' ?>">CONTACT US</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- 麵包屑 start 後台目前抓link字串，須改抓 該商品標題 文字 -->
        <ul class="badge d-flex">
            <?php echo $badge; ?>
        </ul>
        <!-- 麵包屑 end 後台目前抓link字串，須改抓 該商品標題 文字 -->

        
        <div class="product-details-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-2 col-lg-2 col-md-3">
                        <div class="product-dec-right">
                            <div class="product-dec-slider-2 product-small-img-style">
                                <div class="product-dec-small active">
                                    <?php if ($item['img1'] != '') : ?>
                                        <img class="carousel__blow" src="<?= base_url() . $item['img1'] ?>" width="100%">
                                    <?php else : ?>
                                    <?php endif; ?>
                                </div>
                                <div class="product-dec-small">
                                    <?php if ($item['img2'] != '') : ?>
                                        <img class="carousel__blow" src="<?= base_url() . $item['img2'] ?>" width="100%">
                                    <?php else : ?>
                                    <?php endif; ?>
                                </div>
                                <div class="product-dec-small">
                                    <?php if ($item['img3'] != '') : ?>
                                        <img class="carousel__blow" src="<?= base_url() . $item['img3'] ?>" width="100%">
                                    <?php else : ?>
                                    <?php endif; ?>
                                </div>
                                <div class="product-dec-small">
                                    <?php if ($item['img4']!= '') : ?>
                                        <img class="carousel__blow" src="<?= base_url() . $item['img4'] ?>" width="100%">
                                    <?php else : ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-9 col-12">
                        <div class="product-dec-left">
                            <div class="pro-dec-big-img-slider-2 product-big-img-style">
                                <div class="easyzoom-style">
                                    <?php if ($item['img1'] != '') : ?>
                                        <img class="easyzoom__style-img" src="<?= base_url() . $item['img1'] ?>">
                                    <?php else : ?>
                                    <?php endif; ?>
                                </div>
                                <div class="easyzoom-style">
                                    <?php if ($item['img2'] != '') : ?>
                                        <img class="easyzoom__style-img" src="<?= base_url() . $item['img2'] ?>">
                                    <?php else : ?>
                                    <?php endif; ?>
                                </div>
                                <div class="easyzoom-style">
                                    <?php if ($item['img3'] != '') : ?>
                                        <img class="easyzoom__style-img" src="<?= base_url() . $item['img3'] ?>">
                                    <?php else : ?>
                                    <?php endif; ?>
                                </div>
                                <div class="easyzoom-style">
                                    <?php if ($item['img4'] != '') : ?>
                                        <img class="easyzoom__style-img" src="<?= base_url() . $item['img4'] ?>">
                                    <?php else : ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-5 col-lg-5 col-md-12 col-12">
                        <div class="h-100 d-flex align-items-center justify-content-start">
                            <div class="product-details-content quickview-content">
                                <div class="pro-details-price pro-details-price-4">
                                    <div class="pro__detail-block">
                                        <p><?= $item['name'] ?></p> <!-- 作品名稱 -->
                                        <p><?echo $item['year']?> / <?echo $item['item_no']?></p> <!-- 設計年度 / 商品貨號 -->
                                        <p>
                                            <!-- Long sleeve top applique sophisticate floral lace tailored with voluminous ruffles and side slit satin dress.
                                         --><?echo $item['content']?>
                                        </p>
                                        <!-- <?= $item['title3'] ?><br /> -->
                                    </div>
                                </div>
                                <div class="pro-details-action-wrap">
                                    <div class="pro-details-buy-now">
                                        <a href="<?=$item['shop_link']?>">Shop Now</a> <!-- 預計導向外部連結 -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer-area footer-index">
            <div class="footer-bottom copyright-ptb-2">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="social-icon social-icon-center">
                                <a href="https://www.facebook.com/jennychouweddinggown/" target="_blank"><i class="icon-social-facebook-square"></i></a>
                                <a href="https://www.instagram.com/jennychoucouture" target="_blank"><i class="icon-social-instagram"></i></a>
                                <a href="http://line.me/ti/p/@jennychou" target="_blank"><img src="img/icon_line.svg"></a>
                                <a href="https://www.youtube.com/channel/UCoNFsFehZ5q2pJwMhqa2vpQ" target="_blank"><i class="fa fa-youtube-play fa-lg"></i></a>
                                <a href="https://in.pinterest.com/wedjennychou/" target="_blank"><i class="icon-social-pinterest"></i></a>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="footer-menu">
                                <nav>
                                    <ul>
                                        <li><a href="https://g.page/JENNYCHOUCOUTURE?share" target="_blank" class="contact-list-item"><i class="fa fa-map-marker fa-lg fa-fw mr-10" aria-hidden="true"></i>台北市內湖區金莊路26號5樓之5</a></li>
                                        <li><a href="tel:+886-2-2717-1355" class="contact-list-item"><i class="fa fa-phone fa-lg fa-fw mr-10" aria-hidden="true"></i>+886-2-2717-1355</a></li>
                                    </ul>
                                    <ul>
                                        <li>© 2021 JENNY CHOU COUTURE, ALL RIGHTS RESERVED</li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- All JS is here
============================================ -->
    <script src="js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="js/vendor/jquery-3.5.1.min.js"></script>
    <script src="js/vendor/jquery-migrate-3.3.0.min.js"></script>
    <script src="js/vendor/bootstrap.bundle.min.js"></script>
    <script src="js/plugins/slick.js"></script>
    <script src="js/plugins/countdown.js"></script>
    <script src="js/plugins/wow.js"></script>
    <script src="js/plugins/instafeed.js"></script>
    <script src="js/plugins/svg-injector.min.js"></script>
    <script src="js/plugins/jquery.nice-select.min.js"></script>
    <script src="js/plugins/mouse-parallax.js"></script>
    <script src="js/plugins/images-loaded.js"></script>
    <script src="js/plugins/isotope.js"></script>
    <script src="js/plugins/jquery-ui-touch-punch.js"></script>
    <script src="js/plugins/jquery-ui.js"></script>
    <script src="js/plugins/magnific-popup.js"></script>
    <script src="js/plugins/easyzoom.js"></script>
    <script src="js/plugins/scrollup.js"></script>
    <script src="js/plugins/ajax-mail.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script type="text/javascript" src="js/lib/blowup.min.js"></script>
    <script type="text/javascript" src="js/demo/scripts/index.js"></script>
    <script type="text/javascript" src="js/demo/scripts/prism.js"></script>
    <script>
        $(function() {
            $('a[href*=#]').on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $($(this).attr('href')).offset().top
                }, 600, 'linear');
            });
        });
        $(document).ready(function() {
            $('.easyzoom__style-img').blowup({
                background: '#FCEBB6',
                round: false,
                border: ".5px solid #666"
            });
        })
        $(".easyzoom__style-img").on("mouseover", function() {
            $(this).blowup({
                round: false,
                border: ".5px solid #666",
                background: '#FFF',
                scale: 2,
                width: 200,
                height: 200
            });
        })
        $(".easyzoom__style-img").on("touchstart", function() {
            event.preventDefault();
        })
        $(".easyzoom__style-img").on("touchend", function() {
            event.preventDefault();
        })
    </script>
</body>

</html>