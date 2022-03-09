/* modal初始化 */
//抓網址中的search
function getParameter(param)  
{  
    var query = window.location.search;  
    var iLen = param.length;  
    var iStart = query.indexOf(param);  
    if (iStart == -1)  
       return "";  
    iStart += iLen + 1;  
    var iEnd = query.indexOf("&", iStart);  
    if (iEnd == -1)  
       return query.substring(iStart);  
    return query.substring(iStart, iEnd);  
}  

$(function(){
	var BASE_URL = getParameter(b);
	alert(b)
	// $("#uploadHostPicModal").on('hidden.bs.modal', function(){
	// 	$("#upload_host_pic").empty();
	// })
	// $("#editAudioModal").on('hidden.bs.modal', function(){
	// 	$("#summernote_audio_edit").summernote('destroy');
	// })
	// $("#addProgramModal").on('shown.bs.modal', function(){
	// 	cuttarget = "add_program";
	// }).on('hidden.bs.modal', function(){
	// 	$("#addProgramArea").empty();
	// 	$("#add_program_name").val("");
	// })
	// $("#uploadModal").on('hidden.bs.modal', function(){
	// 	$("#upload_audio_name").val("");
	// 	$("#summernote_audio_add").summernote('destroy');
	// })
	// $("#addArticleModal").on('shown.bs.modal', function(){
	// 	cuttarget = "add_article";
	// 	//撈分類資料
	// 	$.ajax({
	// 		url: "<?= base_url() ?>channel/get_category",
	// 		data: {type: 'article', channel_id: channel_id},
	// 	    type: "POST",
	// 	    dataType: "json",
	// 	    success: function(msg){
	// 	    	console.log(msg)
	// 	    	var options = "";
	// 	    	msg.forEach(category=>{
	// 	    		options += `<option value="${category.id}">${category.name}</option>`;
	// 	    	})
	// 	    	$("#addArticleCategory").html(options).selectpicker('refresh');
	// 	    }
	// 	})
	// 	//撈標籤資料
	// 	$.ajax({
	// 		url: "<?= base_url() ?>channel/get_tag",
	// 		data: {channel_id: channel_id},
	// 	    type: "POST",
	// 	    dataType: "json",
	// 	    success: function(msg){
	// 	    	console.log(msg)
	// 	    	var options = "";
	// 	    	msg.forEach(tag=>{
	// 	    		options += `<option value="${tag.id}">${tag.name}</option>`;
	// 	    	})
	// 	    	$("#addArticleTag").html(options).selectpicker('refresh');
	// 	    }
	// 	})
	// 	$("#summernote_article_add").summernote({height: 200});
	// }).on('hidden.bs.modal', function(){
	// 	$("#addArticleArea").empty();
	// 	$("#add_article_title").val("");
	// 	$("#summernote_article_add").summernote('destroy');
	// })
	// $("#editArticleModal").on('shown.bs.modal', function(){
	// 	cuttarget = "edit_article";			
	// }).on('hidden.bs.modal', function(){
	// 	$("#editArticleArea").empty();
	// 	$("#edit_article_title").val("");
	// 	$("#summernote_edit").summernote('destroy');
	// })
	// $("#addProductModal").on('shown.bs.modal', function(){
	// 	cuttarget = "add_product";
	// 	//撈分類資料
	// 	$.ajax({
	// 		url: "<?= base_url() ?>channel/get_category",
	// 		data: {type: 'product', channel_id: channel_id},
	// 	    type: "POST",
	// 	    dataType: "json",
	// 	    success: function(msg){
	// 	    	console.log(msg)
	// 	    	var options = "";
	// 	    	msg.forEach(category=>{
	// 	    		options += `<option value="${category.id}">${category.name}</option>`;
	// 	    	})
	// 	    	$("#addProductCategory").html(options).selectpicker('refresh');
	// 	    }
	// 	})
	// 	$("#summernote_product_add").summernote({height: 200});
	// }).on('hidden.bs.modal', function(){
	// 	$("#addProductArea").empty();
	// 	$("#add_product_name").val("");
	// 	$("#add_product_price").val("");
	// 	$("#summernote_product_add").summernote('destroy');
	// })
})