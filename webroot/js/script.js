$(function(){
	$(".parent-post-id[id]").each(function(){
	$(this).parent('.utweet').addClass('reply')
	});
	$(".utweet.reply").each(function(){
		$(this).appendTo("#" + $(this).children(".parent-post-id").text());
	});
});