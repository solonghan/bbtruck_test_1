<?php include 'templates/header.php'; ?>

<!-- 麵包屑 start 後台目前抓link字串，須改抓 header 內文字 "BRIDAL GOWNS"or"EVENING GOWNS" -->
<ul class="badge d-flex">
    <?php echo $badge; ?>
</ul>
<!-- 麵包屑 end 後台目前抓link字串，須改抓 header 內文字 "BRIDAL GOWNS"or"EVENING GOWNS" -->

<div class="collection__section">
    <div class="container">
        <div class="row">
            <!-- collection post - Start -->
            <? foreach ($lists as $item) : ?>
                <div class="col-xl-3 col-md-3 col-lg-3 col-sm-6 col-6 collection__content">
                    <div class="product-wrap mb-25 scroll-zoom">
                        <div class="product-img">
                            <a href="<?= base_url() ?>collection/detail/<?= $item['id'] ?>">
                                <img class="default-img" src="<?= base_url() . $item['cover'] ?>" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            <? endforeach; ?>
            <!-- collection post - End -->
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>