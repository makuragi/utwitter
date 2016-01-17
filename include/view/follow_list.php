<!--
	<div id="my_profile">
	<img src='<?php echo $login_user_info['user_profile_photo'] ?>'><br>
	ユーザ名：<?php echo $login_user_info['user_name'] ?><br>
	ユーザID：<?php echo $login_id ?><br>
	プロフィール：<?php echo $login_user_info['user_profile'] ?><br>
	登録日時：<?php echo date('Y-m-d', strtotime($login_user_info['user_date'])); ?><br>
	</div>
 -->

<div class="right_container">
	<h2>あなたがフォローしている人たち</h2>
	<?php foreach($my_follows as $my_follow_user) { ?>
	<div class="follow_list_box">
	<div class="follow_list_box_img">
		<img src="<?php echo $my_follow_user['user_profile_photo']; ?>">
	</div>
	<div class="follow_list_box_text">
			<a href="./profile_controller.php?action_id=profile&user_profile_id=<?php echo $my_follow_user['user_id']; ?>">
			<br><?php echo $my_follow_user['user_name']; ?></a>
			<br><?php echo $my_follow_user['user_name']; ?>
			<br><?php echo $my_follow_user['user_profile']; ?>
	</div>
	</div>
	<?php } ?>
	
</div>
</div>