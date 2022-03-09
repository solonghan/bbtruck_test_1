<h1 class="title-all color-main">創辦人介紹</h1>
<p class="titleline"></p>
<div class="row d-flex align-items-center">
    <div class="col-12 col-sm-5 p-5 p-sm-5 p-lg-5">
        <img class="w-80 establisher-pic main-center" src="<?=$cdn_url.$founder['cover']?>" alt="">
        </div>
        <div class="col-12 col-sm-7 text-xs-center">
        <h2><?=$founder['name']?></h2>
        <?=$founder['intro']?>
        </div>
    <div class="flip22 main-center">
            <span class="1"><i class="fa fa-caret-down"></i> <?=strip_tags($founder['title'])?> <i class="fa fa-caret-down"></i></span>
        </div>
        <div class="panel22 px-4">
          <?=$founder['description']?>          
    </div>
</div>