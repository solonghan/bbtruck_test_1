$(function(){
	$(".navigation").on('click', function(){
		var page = $(this).data('page');
		$(".navigation[data-page='channel'] > img").attr('src', './images/頻道頁.png')
		$(".navigation[data-page='collect'] > img").attr('src', './images/收藏頁.png')
		$(".navigation[data-page='cart'] > img").attr('src', './images/購物車頁.png')
		// $(".navigation[data-page='channel'] > img").attr('src', './images/會員頁.png')
		switch(page){
			case "channel":
				$(".navigation[data-page='channel'] > img").attr('src', "./images/頻道.png");
			break
			case "collect":
				$(".navigation[data-page='collect'] > img").attr('src', "./images/收藏.png");
			break;
			case "cart":
				$(".navigation[data-page='cart'] > img").attr('src', "./images/購物車tab.png");
			break;
		}
	})
})