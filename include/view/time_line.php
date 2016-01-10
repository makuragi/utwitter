<script type="text/javascript">
$(function() {
	//クリックイベント
	$(".showoverlay").click(function() {
	    //オーバーレイ用のボックスを作成
	    $("body").append("<div id='overlay'></div>");
	    //フェードエフェクト
	    $("#overlay").fadeTo(500, 0.7);
	    $("#modalbox").fadeIn(500);
	});
	//閉じる際のクリックイベント
	$("#close").click(function() {
	    $("#modalbox, #overlay").fadeOut(500, function() {
	        $("#overlay").remove();
	    });

	});
	$(window).resize(function() {
	    //ボックスサイズ
	    $("#modalbox").css({
	        top: ($(window).height() - $("#modalbox").outerHeight()) / 2,
	        left: ($(window).width() - $("#modalbox").outerWidth()) / 2
	    });
	});
// 	$(window).resize();​
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
		<ul class="utweet_action">
		<li>
		<img class="icon hvr-pulse" src="../include/img/parts/comment.png">
		<a href="#" class="showoverlay">へんじする</a>
		</li>
		<li>
		<?php if (in_array($time_line['post_id'], $good_list) === false) { ?>
			<form action="./main_controller.php" method="post">
				<input type="hidden" name="action_id" value="create_good">
				<input type="hidden" name="good_post_id" value="<?php echo $time_line['post_id']; ?>">
				<input class="icon hvr-pulse" type="image" src="../include/img/parts/knife.png">
			</form>うついね
		<?php } else { ?>
			<form action="./main_controller.php" method="post">
				<input type="hidden" name="action_id" value="delete_good">
				<input type="hidden" name="good_post_id" value="<?php echo $time_line['post_id']; ?>">
				<input class="icon hvr-pulse" type="image" src="../include/img/parts/knife.png">
			</form>うつくないね
		<?php } ?>
		</li>
		<li>
		<img class="icon hvr-pulse" src="../include/img/parts/favorite.png">
		おきにいり</li>
		</ul>
		</div>
		</div>
		</div>
	</div>
<?php } ?>

<div id="modalbox">
    <a href="#" id="close">x</a>
    <form action="./main_controller" method="post">
    <input type="hidden">
	<textarea cols="40" rows="7"></textarea><br>
	<input type="submit" value="返信する">
</div>

<div class="pager"></div>
<div class="pageNum">
    <span class="nownum"></span>/<span class="totalnum"></span>pages
</div>
