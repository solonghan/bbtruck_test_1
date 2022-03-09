<?php include 'templates/header.php'; ?>

<!-- 麵包屑 start 後台目前抓link字串，須改抓 新人資料的標題(someone's Wedding) 文字 -->
<ul class="badge d-flex">
    <?php echo $badge; ?>
</ul>
<!-- 麵包屑 end 後台目前抓link字串，須改抓 新人資料的標題(someone's Wedding) 文字 -->

<div class="bride__info">
    <div class="container">
        <div class="row align-items-center">

            <?php echo $row_html; ?>

        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>