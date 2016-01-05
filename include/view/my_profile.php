<div class="container">
<div class="main_wrapper">
<div class="left_container">
	<div class="my_profile_mypage">
		<div class="my_profile_image_mypage">
		<img src='<?php echo $my_profile['user_profile_photo'] ?>'>
		</div>
			<div class="my_profile_user_mypage">
				<div class="my_profile_user_name">
					<a href="./profile_controller.php?action_id=profile&user_profile_id=<?php echo $user_profile_id; ?>"><?php echo $my_profile['user_name']; ?></a>
				</div>
				<div class="my_profile_user_id">
					<a href="./profile_controller.php?action_id=profile&user_profile_id=<?php echo $user_profile_id; ?>"><?php echo '@'.$user_profile_id; ?></a>
				</div>
			</div>
			<div class="my_profile_info clear">
			<ul class="my_profile_num">
				<li><p>うついーと数</p><a href="./profile_controller.php?action_id=profile&user_profile_id=<?php echo $user_profile_id; ?>"><?php echo $my_utweet_num; ?></a></li>
				<li><p>フォロー数</p><a href="./profile_controller.php?action_id=follow&user_profile_id=<?php echo $user_profile_id; ?>"><?php echo $my_follow_num; ?></a></li>
				<li><p>フォロワー数</p><a href="./profile_controller.php?action_id=follower&user_profile_id=<?php echo $user_profile_id; ?>"><?php echo $my_follower_num; ?></a></li>
			</ul>
			</div>
			<div class="my_profile_user_profile_mypage">
				<?php echo $my_profile['user_profile'] ?>
			</div>
			<div class="my_profile_user_mypage">
				<div class="my_profile_user_date_mypage">
					登録日時：<?php echo date('Y-m-d', strtotime($my_profile['user_date'])); ?>
				</div>
			<div class="btn_profile_edit_mypage">
				<?php if ($user_profile_id === $login_id) { ?>
				<form action="./profile_controller.php" method="post">
					<input type="hidden" name="action_id" value="profile_edit">
					<input type="submit" value="ぷろふ編集">
				</form>
			</div>
			<?php } ?>
			</div>
		</div>
</div>



<div class="right_container">
<div id="all_timeline">
<h3>うつぶやき</h3>

<?php foreach($my_time_line as $post) { ?>
<div class="utweet_box">
		<div class="utweet_profile_image">
			<img src= "<?php echo $my_profile['user_profile_photo']; ?>" >
		</div>
		<div class="utweet_info">
		<div class="utweet_user_top">
			<div class="utweet_user_id">
				<a href="./profile_controller.php?action_id=profile&user_profile_id=<?php echo $user_profile_id; ?>"><?php echo $my_profile['user_name']; ?></a>
			</div>
			<div class="utweet_user_name">
				<a><?php echo '@'.$user_profile_id; ?></a>
			</div>
			<div class="utweet_date">
			<?php echo $post['post_date'] ?>
			</div>
		</div>
		<div class="utweet">
		<?php echo $post['post_body']; ?>
		</div>
		<div>
		<ul class="utweet_action">
		<li>
		<img class="icon hvr-pulse" src="../include/img/parts/comment.png">
		へんじする</li>
		<li>
		<img class="icon hvr-pulse" src="../include/img/parts/knife.png">
		うついね</li>
		<li>
		<img class="icon hvr-pulse" src="../include/img/parts/favorite.png">
		おきにいり</li>
		</ul>

		</div>
		</div>
		</div>
		<?php } ?>
</div>

</div>
</div>
</div>