


<ul class="nav nav-tabs text-uppercase clearfix text-center" id="tab-page">

    <li class="<?=($input=="book")?'active':"";?>"><a href="<?=base_url()?>home/founder/book#tab-page">著作</a></li>
    
    <?foreach($activity_list as $a){?>
        <li class="<?=($input==$a['classify_en'])?'active':"";?>"><a href="<?=base_url()?>home/founder/<?=$a['classify_en']?>#tab-page"><?=$a['classify']?></a></li>
    <?}?>            


    <?foreach($event_list as $e){?>
        <li class="<?=($input==$e['classify_en'])?'active':"";?>"><a href="<?=base_url()?>home/founder/<?=$e['classify_en']?>#tab-page"><?=$e['classify']?></a></li>
    <?}?>

    

    <li class="<?=($input=="media")?'active':"";?>"><a href="<?=base_url()?>home/founder/media#tab-page">媒體專訪</a></li>    
    
</ul>