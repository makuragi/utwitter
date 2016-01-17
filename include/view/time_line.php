<script type="text/javascript">

/**
 * モーダルウィンドウformを出現させるメソッド
 */
var sample = function (parent_post_id) {
	$("#parent_post_id").val(parent_post_id);

    //オーバーレイ用のボックスを作成
    $("body").append("<div id='overlay'></div>");
    //フェードエフェクト
    $("#overlay").fadeTo(500, 0.7);
    $("#modalbox").fadeIn(500);

    //ボックスサイズ
    $("#modalbox").css({
        top: ($(window).height() - $("#modalbox").outerHeight()) / 2,
        left: ($(window).width() - $("#modalbox").outerWidth()) / 2
    });
}
$(function() {
	//閉じる際のクリックイベント
	$("#close").click(function() {
	    $("#modalbox, #overlay").fadeOut(500, function() {
	        $("#overlay").remove();
	    });

	});
	$(window).resize(function() {
		console.log(window.height);
		console.log($("#modalbox").outerHeight());

	    //ボックスサイズ
	    $("#modalbox").css({
	        top: ($(window).height() - $("#modalbox").outerHeight()) / 2,
	        left: ($(window).width() - $("#modalbox").outerWidth()) / 2
	    });
	});
});

</script>

<div id="all_timeline">
<h3>うついーと一覧</h3>
<?php foreach($all_time_line as $time_line) { ?>
	<div class="time_line">
		<div class="utweet_box">
		<div class="utweet_profile_image hvr-glow">
			<a href="./profile_controller.php?action_id=profile&user_profile_id=<?php echo $time_line['user_id']; ?>">
			<img src= "<?php echo $time_line['user_profile_photo']; ?>" >
			</a>
		</div>
		<div class="utweet_info">
		<div class="utweet_user_top">
			<div class="utweet_user_id">
				<a href="./profile_controller.php?action_id=profile&user_profile_id=<?php echo $time_line['user_id']; ?>"><?php echo $time_line['user_name']; ?></a>
			</div>
			<div class="utweet_user_name">
				@<?php echo $time_line['user_id']; ?>
			</div>
			<div class="utweet_date">
			<?php echo $time_line['post_date'] ?>
			</div>
		</div>
		<div class="utweet">
		<?php echo $time_line['post_body']; ?>
		</div>
		<div>
		<div class="btn-actions">
		<img class="icon hvr-pulse" src="../include/img/parts/comment.png">
		<a href="#" class="showoverlay" id="show_over_lay" onClick="sample(
		'<?php echo $time_line['user_id']; ?>'
		)">へんじする</a>
		</div>
		<div class="btn-actions">
		<?php if (in_array($time_line['post_id'], $good_list) === false) { ?>
			<form action="./main_controller.php" method="post">
				<input type="hidden" name="action_id" value="create_good">
				<input type="hidden" name="good_post_id" value="<?php echo $time_line['post_id']; ?>">
				<input class="icon hvr-pulse" type="image" src="../include/img/parts/knife.png">
			うついね</form>
		<?php } else { ?>
			<form action="./main_controller.php" method="post">
				<input type="hidden" name="action_id" value="delete_good">
				<input type="hidden" name="good_post_id" value="<?php echo $time_line['post_id']; ?>">
				<input class="icon hvr-pulse" type="image" src="../include/img/parts/knife.png">
			うつくないね</form>
		<?php } ?>
		</div>
		<!-- 
		<li>
		<img class="icon hvr-pulse" src="../include/img/parts/favorite.png">
		おきにいり</li>
		 -->
		
		</div>
		</div>
		</div>
	</div>
<?php } ?>
	<!-- モーダルウィンドウ -->
	<div id="modalbox">
	    <a href="#" id="close">x</a>
	    <form action="./main_controller.php" method="post">
		    <input type="hidden" name="action_id" value="reply">
		    <input type="hidden" id="parent_post_id" name="parent_post_id">
			<textarea id="post_body" name="post_body" cols="40" rows="7"></textarea><br>
			<input type="submit" value="返信する">
		</form>
	</div>
<div class="pager"></div>
<div class="pageNum">
    <span class="nownum"></span>/<span class="totalnum"></span>pages
</div>
