$(function(){
	// モーダルに値をセット
	$(".reply-btn").click(function(){
		var user_id = $(this).parent().siblings(".user-id").text();
		var post_id = $(this).parent().siblings(".post-id").text();
		$(".modal-title").text('reply to ' + user_id);
		$("#parent-post-id").val(post_id);
	});
});



