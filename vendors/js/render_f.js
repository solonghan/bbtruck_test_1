function aContent(inputArticles){
	var articles = "";
	if(inputArticles==""){
		return articles;
	}

	inputArticles.forEach(article => {
		articles += `
		<div class="Articlelist col-md-12 col-sm-12 col-xs-12 content_box" name="0" data-id="${article.id}">
			<div class="col-md-4 col-sm-4 col-xs-12">
				<img src="${article.cover}" alt="" style="width:100%;margin-right:10px;">
			</div>
			<div class="col-md-8 col-sm-8 col-xs-12">
				<p class="content-date">${article.date}</p>
				<p class="content-title">${article.title}</p>
				<p>${article.content.substr(0,31)}...</p>
				<div class="content-date" style="color:#666;">
					<i class="fa fa-tags"></i>
    	`
    	article.tags.forEach(tag => {
    		articles += `<a class="tags" href="#">${tag.name}</a>`
    	})

    	articles +=`
				</div>
				<p class="content-date" style="color:#75ae3d" align="right">繼續閱讀</p>
			</div>
		</div>
    	`
	});
	return articles;
}


function pContent(inputProducts){
	var products = "";
	inputProducts.forEach(product => {
		products += `
		<div class="col-md-4 col-sm-6 col-xs-12 Products" name="0" style="margin-bottom:10px;" data-id="${product.id}">
			<img src="${product.cover}" alt="" style="width:100%;margin-bottom:10px;">
			<a class="cart_icon">
				<img src="./images/購買購物車.png" alt="" style="float:right;width:40px;">
			</a>
			<span class="content-title">${product.name}</span>
			<div class="content-date" style="color:#DA5F4C">$${product.price}</div>
		</div>
		`;
	});
	return products;
}

function playlistAudio(inputAudio){
	var all = "";
	inputAudio.forEach(audio => {
		all += `
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 collect_box track" data-src="${audio.src}" data-cover="${audio.cover}" data-audio_id="${audio.id}">
				<div class="col-lg-4 col-md-3 col-sm-8 col-xs-7" align="left">
					<img class="collect_play" src="./images/播放鍵.png">
					<span class="audio_name">${audio.name}</span>
				</div>
				<div class="col-lg-3 col-md-3 visible-lg visible-md">
					<span class="hostname">${audio.host}</span>
				</div>
				<div class="col-lg-3 col-md-3 visible-lg visible-md">
					<span>${audio.channel_name}</span>
				</div>	
				<div class="col-lg-2 col-md-3 col-sm-4 col-xs-5" align="right">
					<a><img class="collect_icon add_playlist" src="./images/加入歌單鈕.png" alt="加入歌單"></a> 
					<a><img class="collect_icon more" alt="更多" src="./images/more.png"></a> 
				</div>
			</div>
		`
	});
	return all;
}


function aCategory(inputACategories){
	var a_categories   = `<div class="select"><a class="select-item" data-category="all" href="#">全部類別</a></div>`,
		a_categories_m = `<option value="all">全部類別</option>`;

	inputACategories.forEach(category => {
		a_categories += `
			<div class="select"><a class="select-item" data-category="${category.id}" href="#">${category.name}</a></div>
		`;
		a_categories_m += `
			<option value="${category.id}">${category.name}</option>
		`;
	})
	return {w: a_categories, m: a_categories_m};
}

function pCategory(inputPCategories){
	var p_categories   = `<div class="select"><a class="select-item" data-category="all" href="#">全部類別</a></div>`,
		p_categories_m = `<option value="all">全部類別</option>`;

	inputPCategories.forEach(category => {
		p_categories += `
			<div class="select"><a class="select-item" data-category="${category.id}" href="#">${category.name}</a></div>
		`;
		p_categories_m += `
			<option value="${category.id}">${category.name}</option>
		`;
		return {w: p_categories, m: p_categories_m};
	})
}



