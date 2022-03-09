<?php include 'templates/header.php'; ?>

<!-- 麵包屑 start 後台目前抓link字串，須改抓 header 內文字 "OUR BRIDE" -->
<ul class="badge d-flex">
    <?php echo $badge; ?>
</ul>
<!-- 麵包屑 end 後台目前抓link字串，須改抓 header 內文字 "OUR BRIDE" -->

<div class="bride__section">
    <div class="container">
        <div class="row">
            <!-- 後台可以建立 新人資料，包含"標題(someone's Wedding)、內文(month, year)、封面圖 300*449(px)、內頁圖片上傳 -->
            <?php $cot = 0; ?>
            <?php foreach ($lists as $value) : ?>
                <?php if ($cot % 2 == 0) : ?>
                    <div class="col-xl-3 col-md-4 col-lg-3 col-sm-6 col-6 bride__content">
                        <div class="product-wrap mb-25 scroll-zoom">
                            <?php ?>
                            <a href="<?php echo base_url('bride/detail/') . $value['id']; ?>">
                                <img class="bride_img" src="<?php echo base_url('') . $value['cover_img']; ?>" alt="">
                            </a>

                            <div class="desc">
                                <p class="collection_title"><?php echo $value['title']; ?></p>
                                <p class="time"><?php echo $value['sub_title']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-xl-3 col-md-4 col-lg-3 col-sm-6 col-6 bride__content">
                        <div class="product-wrap mb-25 scroll-zoom">
                            <?php ?>
                            <a href="<?php echo base_url('bride/detail/') . $value['id']; ?>">
                                <img class="bride_img" src="<?php echo base_url('') . $value['cover_img']; ?>" alt="">
                            </a>

                            <div class="desc black">
                                <p class="collection_title"><?php echo $value['title']; ?></p>
                                <p class="time"><?php echo $value['sub_title']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php $cot++; ?>
            <?php endforeach; ?>

        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
<script>
    $(document).ready(function($) {
        $(document).on('mouseover', '.product-wrap', function(event) {
            $(this).find('.desc').addClass('show');
        });
        $(document).on('mouseleave', '.product-wrap', function(event) {
            $(this).find('.desc').removeClass('show');
        });
    });
</script>