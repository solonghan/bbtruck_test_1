var header_template = 
`
<div class="fluid-container visible-lg visible-md">
	<div class="row">
		<img src="{{:cover}}" style="width:100%;margin-top:60px;" id="cover">	
	</div>
</div>
<div class="container">
	<div class="main-host-box" id="anchor">
		<div class="row">
			<div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
				<img class="main-host-img" src="{{:host_pic}}" id="host_pic">
			</div>
			<div class="col-lg-8 col-md-7 col-sm-6 col-xs-12 main-host-textbox">
				<div class="main-host-minibox">
					<img src="./images/頻道主頁.png" class="main-host-minimg">
					<span class="main-host-mininame" id="channel_name">{{:channel_name}}</span>
				</div>	
				<div class="main-host-minibox">
					<img src="./images/主持人.png" class="main-host-minimg">
					<span class="main-host-mininame" id="host">{{:host}}</span>
				</div>
				<div class="main-host-minibox">
					<a class="main-btn-fast main-host-mininame" href="#">
						<img src="./images/wplayer.png" alt="快速播放" class="main-host-minimg">快速播放
					</a>
				</div>
				<div class="main-host-minibox" align="right">
					<a href="#" target="_blank">
						<img src="./images/facebook_sqare.jpg" class="main-host-minimg">
					</a>
					<a href="#" target="_blank">
						<img src="./images/line_sqare.jpg" class="main-host-minimg">
					</a>
					<a href="#">
						<img src="./images/收藏主持人.png" class="main-host-minimg">
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
`;


var main_bar_template = 
`
<div class="container" id="navbar">
	<div class="row">
		<div class="col-md-12" align="center">
			<ul class="nav nav-tabs" style="border:none;padding-top:50px;" align="center">			  
			  	<li class="waves-effect" style="width:20%;"><a class="TabPageIndex" name="0">關於</a></li>
				<li class="waves-effect" style="width:20%;"><a class="TabPageIndex" name="1">節目</a></li>
				<li class="waves-effect" style="width:20%;"><a class="TabPageIndex" name="2">收藏</a></li>
				<li class="waves-effect" style="width:20%;"><a class="TabPageIndex" name="3">文章</a></li>
				<li class="waves-effect" style="width:20%;"><a class="TabPageIndex" name="4">產品</a></li>
			</ul>
			<img src="./images/nav.png" style="width:100%;height:30%;">
		</div>
	</div>
</div>
`;

var about_page_template = 
`
<div class="container">
	<div class="row">
		<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 index-category">
			<select id="About" name="category" class="visible-sm visible-xs browser-default Submenu" style="margin:0px 0% 25px;text-align-last:center;border:1.5px solid #67B1BF;">
				<option value="0" selected="">關於主持人</option>
				<option value="1">精選節目</option>
				<option value="2">精選文章</option>
				<option value="3">精選產品</option>
			</select>
			<div class="visible-md visible-lg">
				<div class="select"><a class="select-item" href="#">關於主持人</a></div>
				<div class="select"><a class="select-item" href="#">精選節目</a></div>
				<div class="select"><a class="select-item" href="#">精選文章</a></div>
				<div class="select"><a class="select-item" href="#">精選產品</a></div>
			</div>
		</div>
		<div class="col-lg-10 col-md-9 col-sm-12 col-xs-12">
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title_box AboutPage" style="padding:0;">
				<div class="col-lg-10 col-md-9 col-sm-9 col-xs-7">
					<img class="about-star" src="./images/精選紅.png">
					<span class="content-title">{{:host}}</span>
				</div>
				<div class="col-lg-2 col-md-3 col-sm-3 col-xs-5" align="right" style="padding-top:10px;">
					<a style="color:#DA5F4C;" class="TabPageIndex content-title" name="0">更多</a>
				</div>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content_box">
				<span class="content-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{:content}}</span>
			</div>	 
			
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title_box AboutPage" style="padding:0;">
				<div class="col-lg-10 col-md-9 col-sm-9 col-xs-7">
					<img class="about-star" src="./images/精選黃.png">
					<span class="content-title">精選節目</span>
				</div>
				<div class="col-lg-2 col-md-3 col-sm-3 col-xs-5" align="right" style="padding-top:10px;">
					<a style="color:#fcbe37;" class="TabPageIndex content-title" name="1">更多節目</a>
				</div>
			</div>
			{{for special_programs}}
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title_box">
				<div class="col-md-10 col-sm-10 col-xs-7" style="display:inline-block">
					<img src="./images/播放鍵.png" style="width:30px;">
					<a class="Programproshow">{{:name}}</a>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-5" align="right">
					<a><img src="./images/加入歌單鈕.png" alt="加入歌單" style="width:30px;padding:0 5px;"></a> 
					<a><img src="./images/收藏鈕.png" alt="收藏" style="width:30px;padding:0 5px;"></a> 
				</div>
			</div>
			{{/for}}

			
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title_box AboutPage" style="padding:0;">
				<div class="col-lg-10 col-md-9 col-sm-9 col-xs-7">
					<img class="about-star" src="./images/精選綠.png">
					<span class="content-title">精選文章</span>
				</div>
				<div class="col-lg-2 col-md-3 col-sm-3 col-xs-5" align="right" style="padding-top:10px;">
					<a style="color:#75ae3d;" class="TabPageIndex content-title" name="1">更多文章</a>
				</div>
			</div>
			<div class="col-md-12  col-sm-12 col-xs-12 content_box AboutPage">
				{{for special_articles}}
				<div class="col-md-4 col-sm-4 col-xs-12" content-box name="0">
					<img src="./images/400x280.jpg" alt="" style="width:100%;margin-bottom:10px;">
					<div class="content-date">{{:date}}</div>
					<div class="content-title">{{:title}}</div>
					<p class="content-date">{{:content}}</p>
					<div class="content-date" style="color:#666">
						<i class="fa fa-tags"></i>{{for tags}}<a class="tags" href="#">{{:tag}}</a>{{/for}}
					</div>
					<p class="content-date" style="color:#75ae3d" align="right">繼續閱讀</p>
				</div>
				{{/for}}				
			</div>
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title_box AboutPage" style="padding:0;">
				<div class="col-lg-10 col-md-9 col-sm-9 col-xs-7">
					<img class="about-star" src="./images/精選藍.png">
					<span class="content-title">精選商品</span>
				</div>
				<div class="col-lg-2 col-md-3 col-sm-3 col-xs-5" align="right" style="padding-top:10px;">
					<a style="color:#67B1BF;" class="TabPageIndex content-title" name="1">更多商品</a>
				</div>
			</div>
			<div class="col-md-12  col-sm-12 col-xs-12 content_box AboutPage">
				{{for special_products}}
				<div class="col-md-4 col-sm-4  col-xs-12" name="0">
					<img src="./images/400x280.jpg" alt="" style="width:100%;margin-bottom:10px;">
					<a href="#">
						<img src="./images/購買購物車.png" alt="" style="float:right;width:40px;">
					</a>
					<span class="content-title">{{:name}}</span>
					<div class="content-date" style="color:#DA5F4C">\${{:price}}</div>
				</div>				
				{{/for}}
			</div>
		</div>
	</div>
</div>
`;

var program_page_template = 
`
<div class="container">
	<div class="row">
		<div class="ProgramTab">
			<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 index-category">
				<select id="About" name="category" class="visible-sm visible-xs browser-default Submenu" style="margin:0px 0% 25px;text-align-last:center;border:1.5px solid #67B1BF;">
					<option value="0" selected="">我的節目1</option>
					<option value="1">我的節目2</option>
					<option value="2">我的節目3</option>
					<option value="3">我的節目4</option>
				</select>
				<div class="visible-md visible-lg">
					{{for programs}}
					<div class="select"><a class="select-item" href="#">{{:name}}</a></div>					
					{{/for}}
				</div>
			</div>
			<div class="col-lg-10 col-md-9 col-sm-12 col-xs-12">
				{{for program_detail}}
				<div class="col-md-12 col-sm-12 col-xs-12 content_box ProgramPage">
					<p class="content-title">{{:name}}</p>
					<p class="content-date">發佈：{{:date}}</p>
					<div class="col-md-5 col-sm-6 col-xs-12">
						<img src="{{:cover}}" alt="" style="width:100%;">
					</div>

					{{for audio}}
					<div class="col-md-5 col-sm-4 col-xs-7 ProgramDetail">
						<img src="./images/播放鍵.png" alt="" style="width:30px;">
						<a class="Programproshow"><span style="color:#000;">{{:name}}</span></a>
					</div>					
					<div class="col-md-2 col-sm-2 col-xs-5 ProgramDetail">
						<a><img src="./images/加入歌單鈕.png" alt="加入歌單" style="width:30px;padding:5px;"></a> 
						<a><img src="./images/收藏鈕.png" alt="收藏" style="width:30px;padding:0 5px;"></a> 
					</div>
					{{/for}}
				</div>
				{{/for}}				
			</div>
		</div><!-- ProgramTab 1 end -->
		<!-- 音檔詳細頁開始 -->	
		<div class="ProgramTab" style="display:none">
			<div class="col-md-8 col-sm-8 col-xs-12" style="margin-bottom:20px;">
				<img src="./images/播放鍵.png" alt="播放" style="width:50px;float:left;">
			    <p style="margin:10px;"><span class="entry-title animated fadeInRight" style="font-size:18px;margin:15px;">節目名稱</span></p>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12" style="margin-bottom:20px;"><!-- Content social share -->
				<a href="#" style="width:80px"><img src="./images/facebook.png" style="width:80px"></a>
				<a href="#" style="width:80px"><img src="./images/line.png" style="width:80px"></a>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 content_box">節目介紹<br>連時表節這中據也人高只！達沒經西的又顧認回產界眼小國有們人媽回東格指重人興心一大影市麼我安的？其子產才再願有那部帶呢理產比得候法，們名見麼狀好的師一根有體度不質須門程中親這則市來機！消遊它公者北歡海還好且角高海有實是推？</div>
			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:15px;text-align:center">
				<a href="javascript:BackforMain(0)" class="backbutton">回到主頁</a>
				<a href="javascript:BackforMain(1)" class="backbutton">返回上頁</a>
			</div>
		</div><!-- 音檔詳細頁結束 --><!-- ProgramTab 2 end -->
	</div><!-- row end -->	
</div><!-- 容器結束 -->	
`;


var collection_page_template = 
`
<div class="container">
	<div class="row">
		<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 index-category">
			<select id="About" name="category" class="visible-sm visible-xs browser-default Submenu" style="margin:0px 0% 25px;text-align-last:center;border:1.5px solid #67B1BF;">
				<option value="0" selected="">喜愛主持人</option>
				<option value="1">喜愛收藏</option>
				<option value="2">最近收聽</option>
				<option value="3">自訂歌單1</option>
			</select>
			<div class="visible-md visible-lg">
				<div class="select"><a class="select-item" href="#">喜愛主持人</a></div>
				<div class="select"><a class="select-item" href="#">喜愛收藏</a></div>
				<div class="select"><a class="select-item" href="#">最近收聽</a></div>

				{{for playlists}}
				<div class="select"><a class="select-item" href="#">{{:name}}</a></div>
				{{/for}}

			</div>
		</div>
		<div class="col-lg-10 col-md-9 col-sm-12 col-xs-12"><!-- 右邊收藏內容 -->	
			{{for playlist_detail}}
			<div class="col-md-12 col-sm-12 col-xs-12 content_box">
				<div class="col-md-10 col-sm-10 col-xs-9">
					<img src="./images/範例2.jpg" style="height:80px;width:80px;float:left;margin-right:10px;" alt="">
					<span class="content-title">{{:name}}</span><br>
					<span class="content-text">{{:host}}</span><br>
					<span class="content-text">{{:channel}}</span>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-3" style="padding:25px 0;">
					<a><img src="./images/加入歌單鈕.png" alt="加入歌單" style="width:35px;padding:0 5px;"></a> 
					<a href="#"><img src="./images/已收藏.png" alt="已收藏" style="width:35px;padding:0 5px;"></a>
				</div>	
			</div>
			{{/for}}			
		</div>
	</div>
</div>
`;


var article_page_template = 
`
<div class="container">
	<div class="row">
		<div class="ArticlePage">
			<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 index-category">
				<select id="About" name="category" class="visible-sm visible-xs browser-default Submenu" style="margin:0px 0% 25px;text-align-last:center;border:1.5px solid #67B1BF;">
					<option value="0" selected="">春</option>
					<option value="1">夏</option>
					<option value="2">秋</option>
					<option value="3">冬</option>
				</select>
				<div class="visible-md visible-lg">
					{{for categories}}
					<div class="select"><a class="select-item" href="#">{{:name}}</a></div>
					{{/for}}
				</div>
			</div>
			<div class="col-lg-10 col-md-9 col-sm-12 col-xs-12"><!-- 右邊主要內容 -->

				{{for category_detail}}
				<div class="Articlelist col-md-12 col-sm-12 col-xs-12 content_box" name="0">
					<div class="col-md-4 col-sm-4 col-xs-12">
						<img src="./images/400x280.jpg" alt="" style="width:100%;margin-right:10px;">
					</div>
					<div class="col-md-8 col-sm-8 col-xs-12">
						<p class="content-date">2018.03.23</p>
						<p class="content-title">{{:title}}</p>
						<p>{{:content}}</p>
						<div class="content-date" style="color:#666;">
							<i class="fa fa-tags"></i>
							{{for tags}}
							<a class="tags" href="#">{{:tag}}</a>
							{{/for}}							
						</div>
						<p class="content-date" style="color:#75ae3d" align="right">繼續閱讀</p>
					</div>
				</div>
				{{/for}}

				
			</div><!-- 右邊文章內容 -->
		</div><!-- ArticlePage 1 end -->

		<!-- 內文詳細頁 -->
		<div class="ArticlePage" style="display:none">
			<div class="ArticleDetail" style="display:none"><!-- 為什麼會得糖尿病? -->
				<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 index-category">
					<select id="About" name="category" class="visible-sm visible-xs browser-default Submenu" style="margin:0px 0% 25px;text-align-last:center;border:1.5px solid #67B1BF;">
						<option value="0" selected="">春</option>
						<option value="1">夏</option>
						<option value="2">秋</option>
						<option value="3">冬</option>
					</select>
					<div class="visible-md visible-lg">
						<div class="select"><a class="select-item" href="#">春</a></div>
						<div class="select"><a class="select-item" href="#">夏</a></div>
						<div class="select"><a class="select-item" href="#">秋</a></div>
						<div class="select"><a class="select-item" href="#">冬</a></div>
					</div>
				</div>
				<div class="col-lg-10 col-md-9 col-sm-12 col-xs-12"><!-- 右邊文章內容 -->
					<div class="col-md-12 col-sm-12 col-xs-12">
						<img src="./images/400x280.jpg" alt="" style="width:100%;margin-bottom:10px;">
						<p class="content-text" ">主持人名稱  2018.01.23</p>
						<p class="content-title">為什麼會得糖尿病?</p>
						<a href="#"><img src="./images/facebook.png" style="width:80px;margin:5px 3px;"></a>
						<a href="#"><img src="./images/line.png" style="width:80px;margin:5px 3px;"></a>
						<div class="content-text" style="color:#74AE3D;">相關音檔</div>
						<div class="col-md-10 col-sm-10 col-xs-8 ProgramDetail content_box">
							<img src="./images/播放鍵.png" alt="" style="width:30px;">
							<a class="Programproshow"><span style="color:#000;">節目1曲目</span></a>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-4 ProgramDetail content_box">
							<a><img src="./images/加入歌單鈕.png" alt="加入歌單" style="width:30px;padding:5px;"></a> 
							<a><img src="./images/收藏鈕.png" alt="收藏" style="width:30px;padding:0 5px;"></a> 
						</div><!-- 曲目1 end -->
						<div class="col-md-10 col-sm-10 col-xs-8 ProgramDetail content_box">
							<img src="./images/播放鍵.png" alt="" style="width:30px;">
							<a class="Programproshow"><span style="color:#000;">節目2曲目</span></a>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-4 ProgramDetail content_box">
							<a><img src="./images/加入歌單鈕.png" alt="加入歌單" style="width:30px;padding:5px;"></a> 
							<a><img src="./images/收藏鈕.png" alt="收藏" style="width:30px;padding:0 5px;"></a> 
						</div><!-- 曲目2 end -->	
						<p>
							<span style="font-size:12pt;font-family:Calibri;color:#000000;">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;糖尿病是新陳代謝異常所致，過去被認為是胰島素分泌不足或不分泌所引起（一型糖尿病），現在則發現「胰島素阻抗」是最常見且更重要的原因（二型糖尿病）。所謂「胰島素阻抗」是指雖然血中胰島素含量正常甚至過多，但胰島素受到某種阻抗而不能發揮功能，導致胰島素利用率不良，不能有效將血糖帶入細胞中，此現象還常見於肥胖、動脈粥狀硬化、高血壓、高膽固醇血症、高尿酸血症等病患中。除此之外，糖尿病患者人數不斷地增加，這不單純是先天基因遺傳的問題，主要是因為現代化生活習慣所致，如：飲食不均、缺乏運動、壓力的增加等，而缺乏耐糖因子（GTP）則是近來醫界發現的重要原因。<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;目前用以控制糖尿病患血糖的藥物有五種，第一種是在肝臟中抑制葡萄糖，第二種作用在刺激胰島素分泌，第三種則能減少身體中對胰島素的抗拒性，第四種能改善病發時胰島素快速分泌消失的情況，第五種則在小腸中抑制碳水化合物的分解，使得糖份的吸收減少。雖然近年研發的藥物越來越多，但看來似乎都是治標而非治本。部分第二型糖尿病患在服藥後仍有逐漸控制不良的現象，必須改用胰島素注射治療，以提高效果。毛嘉洪說，耐糖因子（GlucoseToleranceFactor，簡稱GTP），存在於動物體內肝臟等處（含人在內），主要維持體內糖類的正常代謝，並將血液中的葡萄糖經由胰島素的協同作用，送入體內各細胞中;而耐糖因子為三價鉻離子、維生素及胺基酸所組成的複合體，正常人可由食物中攝取到三價鉻，在體內轉化形成GTE，協助葡萄糖的正常代謝。不過，若過份勞動、懷孕、肥胖、年老、酗酒、手術或疾病等各種狀況的人，會加速體內的鉻由尿中排出，造成人體缺乏GTF。<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;若再碰上三價鉻長期攝取不足，加上體內的合成GTF減少，由消化系統吸引到體內的葡萄糖，就不能有效地進入細胞內被利用，高濃度的血糖流經腎臟時，因無法完全被吸收而出現在尿液中，產生糖尿病的臨床病狀。毛嘉洪強調，耐糖因子並非是新名詞，而最早發現GTF的時間，可追溯至公元一九五七年，由美國Schwartz等人自豬腎中萃取發現;直至公元一九五九年，才由前美國人類營養研究中心主任waiterMertz博士確定其為一種維生素與微量元素的複合體。
								<br><br>
								<span style="font-size:15pt;font-family:'細明體';color:#000000;">
								所以這些症狀都將迎刃而解:
								</span>
								<br><br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;減輕糖尿病病情，減少併發症發生。改善肝功能，如脂肪肝，肝硬化，肝纖維化。動脈硬化、腎臟病變、視網膜病變、神經病變等。增加免疫力，減少疾病發生。降低血脂肪、三酸甘油脂。改善皮膚敏感症，幫助傷口癒合，預防皮膚老化。幫助體重控制，減少脂肪堆積，增加肌肉活力。減緩老化速度，提升睡眠品質，減少疲勞感。 
								<br><br>
								<span style="font-size:15pt;font-family:'細明體';color:#000000;">
								降糖技術配方：
								</span>
								<br><br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;促進血糖代謝、改善胰島素抗性針對二型(非胰島素依賴型)糖尿病所開發的降糖配方，經過完整的安全性評估以及人體臨床功效實驗，分別獲得台灣及中國大陸官方降血糖，是安全無副作用的優良降糖產品。
								<br><br>
								<span style="font-size:15pt;font-family:'細明體';color:#000000;">
								護肝技術配方：
								</span>
								<br><br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;保肝臟、促進脂質代謝國立中興大學與加特福產學合作，針對脂肪肝及高血脂所開發的護肝配方，在國科會、經濟部產學合作專案計畫下，驗證了護肝配方對於脂肪肝、降血脂以及改善氧化傷害有良好功效，安全性實驗也同步確認了護肝配方安全無副作用。
								<br><br>
								<span style="font-size:15pt;font-family:'細明體';color:#000000;">
								美膚纖體配方：
								</span>
								<br><br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;減少體脂肪堆積、增堋抗氧化酵素活性累積加特福研究細胞代謝十多年所開發的美膚纖體配方。除了改善瘦體素抗性，在人體臨床實驗證實了不易形成體脂肪，並藉由增強抗氧化酵素活性(抗衰老)以維持體內膠原蛋白結構，此外在增強長壽基因表現性等方面，獲得了科學實證。	
								<br><br>
								<span style="font-size:15pt;font-family:'細明體';color:#000000;">
								糖尿病早期症狀
								</span>
								<br><br>
							1.四肢疼痛：下肢、足部各關節經常疼痛,而排除骨質增生,風濕、類風濕<br>
							2.皮膚瘙癢：以外陰部肛門部位最嚴重。<br>
							3.面色發紅：有89.5%的患者呈不同程度面色發紅。<br>
							4.飲食改變：三多現象(吃的多、喝的多、尿的多)。<br>
							5.手足部水皰疹<br>
							6.舌炎<br>
							7.手足背肉芽緟<br>
							8.澗歇跛行<br>
							9.脛骨前出現褐色斑<br>
							10.性能力低落<br><br>
								<table style="border:1px solid #000;text-align:center;">
									<tr style="border:1px solid #000;">
										<td style="border:1px solid #000;width:150px;">慢性併發症</td>
										<td style="border:1px solid #000;">病變徵兆與結果</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td style="border:1px solid #000;">眼睛病變</td>
										<td style="border:1px solid #000;">視網膜病變、青光眼、黃斑部病變、複視、眼部肌肉麻痺、顏色敏感度降低丶屈光不正、白內障,嚴重會導致失明。(糖尿病是成人失明的主因)</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td style="border:1px solid #000;">腎臟病變</td>
										<td style="border:1px solid #000;">尿液帶泡泡、蛋白尿、血壓上升、下肢出現水腫等、慢性腎衰竭,嚴重會引發尿毒症、洗腎。</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td style="border:1px solid #000;">下肢(足部)病變</td>
										<td style="border:1px solid #000;">足部血液供應減少、間歇性跛行、感覺異常、足部冰冷、易感染、傷囗不易癒合或變"老爛腳",嚴重時需截肢。</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td style="border:1px solid #000;">神經病變</td>
										<td style="border:1px solid #000;">觸覺或溫度感覺異常丶手足麻木、刺痛、蟻行感、性功能障礙、小便困難、肌肉無力、莫名疼痛(通常夜間特別明顯)、腸胃蠕動異常(胃輕癱)、自主神經與周邊神經病變。</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td style="border:1px solid #000;">血管病變</td>
										<td style="border:1px solid #000;">腦中風、心肌梗塞、動脈硬化,心血管疾病死亡率高,醫療支出也最高。</td>
									</tr>
								</table>
								<br><br>
								<span style="font-size:15pt;font-family:'細明體';color:#000000;">
								獨步世界的專利複合物-乳鐵蛋白鉻
								</span>
								<br><br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;乳鐵蛋白鉻(ChromiumLactoferrin)是加特福研發團隊，從「細胞營養及生理代謝」的觀點，所開發的新陳代謝症候群專利複合物。乳鐵蛋白鉻專利複合物及其應用除了獲得全世界超過20個國家的專利外，十多年的研究開發及成功案例，更使乳鐵蛋白鉻專利複合物成為全世界許多慢性病友的必備保健食品。<br><br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;公司歷年研發經營成果表2013麥鉻花多穀營養補充品2013歐盟營養學會發表脂肪肝臨床實驗成果2013年麥鉻花加特幅生技Ⅲ多穀營養補充品2011年發表研發成果於亞洲食品因子學會2010年發表研發成果於知名國際期刊BBRC2009年發表研發成果於知名國際期刊LifeSciences2008年發表研發成果於權威國際期刊DOM2007年發表最新研究成果於西班牙之世界論壇2007年權威期刊Nature於台灣專刊中專頁報導與大及加特福的產學合作成功典範2006年發表人體臨床實驗成果於知名國際期刊Metabolism2005年發表人體臨床實驗成果於歐洲醫學會EASO2005年代表台灣於韓國主辦2005APEC中小企業論壇宣揚台灣生物科技2004年榮獲「國家品質標章」及「國家生技醫療品質金獎」2003年榮獲「第二屆國家新創事業獎」2003年榮獲「國家生技醫療品質獎」2002年榮獲「第一屆國際生醫新創獎」2001年榮獲「國家生技醫療品質獎」。<br><br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;常人由食物中攝取的營養成分，有部分可在體內轉化成<b>耐糖因子 (GTF)</b>，再與胰島素協同作用，將血液中的葡萄糖送入細胞內，進而促進葡萄糖的新陳代謝，將葡萄糖轉化成身體細胞能量的來源，讓每個組織器官都能進行其該有的運轉功能，例如：支持腦細胞的記憶思考、強化肝細胞解毒、腎臟排毒等功能。如果我們身體可以有足量的<b>耐糖因子(GTF)</b>那細胞就可活化，葡萄糖就可全面進入細胞變成能量，不會囤積在血管中，我們就不會生病並可延遲老化。<b>一般人每天從飲食中平均只能獲取20至40微克可能會轉化成GTF的物質!!</b>可是我們每天都需要約200微克的GTF更別說調整的體質需要更多<br><br>早在1957年... <br>美國營養學之父-莫茲博士就提出疾病是因為缺乏營養素而非缺乏藥物。<br><br>
								可贈送兩包體驗包與精美小手冊
							</span>
						</p><!-- 內文 end -->
					</div>
				</div><!-- 右邊文章內容 end -->
				<div class="col-md-12 col-sm-12 col-xs-12" style="padding-top:60px;text-align:center">
					<a href="javascript:BackforMain(3)" class="backbutton">返回上頁</a>
				</div>
			</div><!-- 為什麼會得糖尿病? end -->
		</div><!-- ArticlePage 2 內文詳細頁 end -->
	</div><!-- row end -->	
</div><!-- 容器結束 -->	
`;

var product_page_template = 
`
<div class="container">
	<div class="row">
		<div class="ProductTab">
			<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 index-category">
				<select id="About" name="category" class="visible-sm visible-xs browser-default Submenu" style="margin:0px 0% 25px;text-align-last:center;border:1.5px solid #67B1BF;">
					<option value="0" selected="">春</option>
					<option value="1">夏</option>
					<option value="2">秋</option>
					<option value="3">冬</option>
				</select>
				<div class="visible-md visible-lg">
					{{for categories}}
					<div class="select"><a class="select-item" href="#">{{:name}}</a></div>
					{{/for}}					
				</div>
			</div>
			<div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 ProductsPage"><!-- 右邊主要內容 -->
				<div class="col-md-12 col-sm-12 col-xs-12 content_box">
					{{for category_detail}}
					<div class="col-md-4 col-sm-6 col-xs-12" name="0" style="margin-bottom:10px;">
						<img src="./images/400x280.jpg" alt="" style="width:100%;margin-bottom:10px;">
						<a href="#">
							<img src="./images/購買購物車.png" alt="" style="float:right;width:40px;">
						</a>
						<span class="content-title">{{:name}}</span>
						<div class="content-date" style="color:#DA5F4C">\${{:price}}</div>
					</div>
					{{/for}}					
				</div>
			</div><!-- 右邊主要內容 end -->
		</div><!-- ProductTab 1 end -->
		<div class="ProductTab" style="display:none">
			<div class="ProductsDetail">
				<div class="entry-main">
					<!-- Content header -->
					<h1 class="entry-title animated fadeInRight">麥鉻花</h1><!-- News title -->
					<!-- End Content header -->
					
					<!-- Post thumbnail -->
					<div class="post-featured animated fadeInRight">
						<img src="assets/Front/images/1.jpg" alt="">
					</div>

					<div class="entry-footer">
						<div class="social-share"><!-- Content social share -->
							<a href="#" style="width:80px"><img src="assets/Icon/facebook.png" style="width:80px"></a>
							<a href="#" style="width:80px"><img src="assets/Icon/line.png" style="width:80px"></a>
						</div>
					</div>

					<!-- Entry content -->
					<div class="entry-content animated fadeInUp">
						<p>The Association of Southeast Asian Nations is a political and economic organization of ten Southeast Asian countries. It was formed on 8 August 1967 by Indonesia, Malaysia, the Philippines, Singapore, and Thailand. </p>
						<p>Since then, membership has expanded to include Brunei, Cambodia, Laos, Myanmar (Burma), and Vietnam. Its aims include accelerating economic growth, social progress, and sociocultural evolution among its members alongside protection of regional stability as well as providing a mechanism for member countries to resolve differences peacefully</p>
						<p>The Association of Southeast Asian Nations is a political and economic organization of ten Southeast Asian countries. It was formed on 8 August 1967 by Indonesia, Malaysia, the Philippines, Singapore, and Thailand. Since then, membership has expanded to include Brunei, Cambodia, Laos, Myanmar (Burma), and Vietnam. </p>
						<p>Its aims include accelerating economic growth, social progress, and sociocultural evolution among its members alongside protection of regional stability as well as providing a mechanism for member countries to resolve differences peacefully</p>
					</div>
					<!-- End entry content -->
				</div>
				<div class="col-md-12" style="margin-bottom:15px;text-align:center">
					<a href="javascript:BackforMain(4)" style="width:100%;border:2px solid #8e8e8e;color:#8e8e8e;padding:3px 30px;">返回上頁</a>
				</div>
			</div>

			<div class="ProductsDetail">
				<div class="entry-main">
					<!-- Content header -->
					<h1 class="entry-title animated fadeInRight">小芬子褐藻</h1><!-- News title -->
					<!-- End Content header -->
					
					<!-- Post thumbnail -->
					<div class="post-featured animated fadeInRight">
						<img src="assets/Front/images/2.jpg" alt="">
					</div>

					<div class="entry-footer">
						<div class="social-share"><!-- Content social share -->
							<a href="#" style="width:80px"><img src="assets/Icon/facebook.png" style="width:80px"></a>
							<a href="#" style="width:80px"><img src="assets/Icon/line.png" style="width:80px"></a>
						</div>
					</div>

					<!-- Entry content -->
					<div class="entry-content animated fadeInUp">
						<p>The Association of Southeast Asian Nations is a political and economic organization of ten Southeast Asian countries. It was formed on 8 August 1967 by Indonesia, Malaysia, the Philippines, Singapore, and Thailand. </p>
						<p>Since then, membership has expanded to include Brunei, Cambodia, Laos, Myanmar (Burma), and Vietnam. Its aims include accelerating economic growth, social progress, and sociocultural evolution among its members alongside protection of regional stability as well as providing a mechanism for member countries to resolve differences peacefully</p>
						<p>The Association of Southeast Asian Nations is a political and economic organization of ten Southeast Asian countries. It was formed on 8 August 1967 by Indonesia, Malaysia, the Philippines, Singapore, and Thailand. Since then, membership has expanded to include Brunei, Cambodia, Laos, Myanmar (Burma), and Vietnam. </p>
						<p>Its aims include accelerating economic growth, social progress, and sociocultural evolution among its members alongside protection of regional stability as well as providing a mechanism for member countries to resolve differences peacefully</p>
					</div>
					<!-- End entry content -->
				</div>
				<div class="col-md-12" style="margin-bottom:15px;text-align:center">
					<a href="javascript:BackforMain(4)" style="width:100%;border:2px solid #8e8e8e;color:#8e8e8e;padding:3px 30px;">返回上頁</a>
				</div>
			</div>

			<div class="ProductsDetail">
				<div class="entry-main">
					<!-- Content header -->
					<h1 class="entry-title animated fadeInRight">男鋼</h1><!-- News title -->
					<!-- End Content header -->
					
					<!-- Post thumbnail -->
					<div class="post-featured animated fadeInRight">
						<img src="assets/Front/images/3.jpg" alt="">
					</div>

					<div class="entry-footer">
						<div class="social-share"><!-- Content social share -->
							<a href="#" style="width:80px"><img src="assets/Icon/facebook.png" style="width:80px"></a>
							<a href="#" style="width:80px"><img src="assets/Icon/line.png" style="width:80px"></a>
						</div>
					</div>

					<!-- Entry content -->
					<div class="entry-content animated fadeInUp">
						<p>The Association of Southeast Asian Nations is a political and economic organization of ten Southeast Asian countries. It was formed on 8 August 1967 by Indonesia, Malaysia, the Philippines, Singapore, and Thailand. </p>
						<p>Since then, membership has expanded to include Brunei, Cambodia, Laos, Myanmar (Burma), and Vietnam. Its aims include accelerating economic growth, social progress, and sociocultural evolution among its members alongside protection of regional stability as well as providing a mechanism for member countries to resolve differences peacefully</p>
						<p>The Association of Southeast Asian Nations is a political and economic organization of ten Southeast Asian countries. It was formed on 8 August 1967 by Indonesia, Malaysia, the Philippines, Singapore, and Thailand. Since then, membership has expanded to include Brunei, Cambodia, Laos, Myanmar (Burma), and Vietnam. </p>
						<p>Its aims include accelerating economic growth, social progress, and sociocultural evolution among its members alongside protection of regional stability as well as providing a mechanism for member countries to resolve differences peacefully</p>
					</div>
					<!-- End entry content -->
				</div>
				<div class="col-md-12" style="margin-bottom:15px;text-align:center">
					<a href="javascript:BackforMain(4)" style="width:100%;border:2px solid #8e8e8e;color:#8e8e8e;padding:3px 30px;">返回上頁</a>
				</div>
			</div>

			<div class="ProductsDetail">
				<div class="entry-main">
					<!-- Content header -->
					<h1 class="entry-title animated fadeInRight">特益箘</h1><!-- News title -->
					<!-- End Content header -->
					
					<!-- Post thumbnail -->
					<div class="post-featured animated fadeInRight">
						<img src="assets/Front/images/4.jpg" alt="">
					</div>

					<div class="entry-footer">
						<div class="social-share"><!-- Content social share -->
							<a href="#" style="width:80px"><img src="assets/Icon/facebook.png" style="width:80px"></a>
							<a href="#" style="width:80px"><img src="assets/Icon/line.png" style="width:80px"></a>
						</div>
					</div>

					<!-- Entry content -->
					<div class="entry-content animated fadeInUp">
						<p>The Association of Southeast Asian Nations is a political and economic organization of ten Southeast Asian countries. It was formed on 8 August 1967 by Indonesia, Malaysia, the Philippines, Singapore, and Thailand. </p>
						<p>Since then, membership has expanded to include Brunei, Cambodia, Laos, Myanmar (Burma), and Vietnam. Its aims include accelerating economic growth, social progress, and sociocultural evolution among its members alongside protection of regional stability as well as providing a mechanism for member countries to resolve differences peacefully</p>
						<p>The Association of Southeast Asian Nations is a political and economic organization of ten Southeast Asian countries. It was formed on 8 August 1967 by Indonesia, Malaysia, the Philippines, Singapore, and Thailand. Since then, membership has expanded to include Brunei, Cambodia, Laos, Myanmar (Burma), and Vietnam. </p>
						<p>Its aims include accelerating economic growth, social progress, and sociocultural evolution among its members alongside protection of regional stability as well as providing a mechanism for member countries to resolve differences peacefully</p>
					</div>
					<!-- End entry content -->
				</div>
				<div class="col-md-12" style="margin-bottom:15px;text-align:center">
					<a href="javascript:BackforMain(4)" style="width:100%;border:2px solid #8e8e8e;color:#8e8e8e;padding:3px 30px;">返回上頁</a>
				</div>
			</div>

			<div class="ProductsDetail">
				<div class="entry-main">
					<!-- Content header -->
					<h1 class="entry-title animated fadeInRight">精胺沛</h1><!-- News title -->
					<!-- End Content header -->
					
					<!-- Post thumbnail -->
					<div class="post-featured animated fadeInRight">
						<img src="assets/Front/images/5.jpg" alt="">
					</div>

					<div class="entry-footer">
						<div class="social-share"><!-- Content social share -->
							<a href="#" style="width:80px"><img src="assets/Icon/facebook.png" style="width:80px"></a>
							<a href="#" style="width:80px"><img src="assets/Icon/line.png" style="width:80px"></a>
						</div>
					</div>

					<!-- Entry content -->
					<div class="entry-content animated fadeInUp">
						<p>The Association of Southeast Asian Nations is a political and economic organization of ten Southeast Asian countries. It was formed on 8 August 1967 by Indonesia, Malaysia, the Philippines, Singapore, and Thailand. </p>
						<p>Since then, membership has expanded to include Brunei, Cambodia, Laos, Myanmar (Burma), and Vietnam. Its aims include accelerating economic growth, social progress, and sociocultural evolution among its members alongside protection of regional stability as well as providing a mechanism for member countries to resolve differences peacefully</p>
						<p>The Association of Southeast Asian Nations is a political and economic organization of ten Southeast Asian countries. It was formed on 8 August 1967 by Indonesia, Malaysia, the Philippines, Singapore, and Thailand. Since then, membership has expanded to include Brunei, Cambodia, Laos, Myanmar (Burma), and Vietnam. </p>
						<p>Its aims include accelerating economic growth, social progress, and sociocultural evolution among its members alongside protection of regional stability as well as providing a mechanism for member countries to resolve differences peacefully</p>
					</div>
					<!-- End entry content -->
				</div>
				<div class="col-md-12" style="margin-bottom:15px;text-align:center">
					<a href="javascript:BackforMain(4)" style="width:100%;border:2px solid #8e8e8e;color:#8e8e8e;padding:3px 30px;">返回上頁</a>
				</div>
			</div>
		</div><!-- ProductTab 2 end -->
	</div><!-- row end -->	
</div><!-- 容器結束 -->
`;
