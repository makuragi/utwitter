$(function(){

    // 返信用トグル処理
    function replyApply (parent_post_id) {
        $("." + parent_post_id).each(function(){
            $(this).appendTo("#" + parent_post_id).slideToggle("fast");
            if($(".reply").hasClass($(this).attr("id")) === false) {
                return true;
            }
            replyApply($(this).attr("id"));
        });
    }

    $(".utweet").click(function(){
        replyApply($(this).attr("id"));
    });

    // ajaxで返信をもってくる
    $(".utweet").click(function(){
    	var parent_post_id = $(this).attr("id");
    	console.log(parent_post_id);
    	$.ajax ({
    		type: 'POST',
    		url: 'http://makuragi.com/posts/reply_list',
    		dataType: "json",
    		data: {
    			'id': parent_post_id
    		},
    		success: function(data) {
    			console.log(data);
    		},
    		error: function(XMLHttpRequest, textStatus, errorThrown){
    	        console.log(XMLHttpRequest); // XMLHttpRequestオブジェクト
    	        console.log(textStatus); // status は、リクエスト結果を表す文字列
    	        console.log(errorThrown); // errorThrown は、例外オブジェクト
    		}
    	});
    });

    // モーダルに値をセット
    $(".reply-btn").click(function(){
        var user_id = $(this).parent().siblings(".user-id").text();
        var post_id = $(this).parent().siblings(".post-id").text();
        $(".modal-title").text('reply to ' + user_id);
        $(".post-body").text(' @' + user_id);
        $("#parent-post-id").val(post_id);
    });

    // post-formの大きさを変える
     $(".post-form").focus(function(){
      $(this).attr('rows', 4);
    }).blur(function(){
        $(this).attr('rows', 1);
    });
});