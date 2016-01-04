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
	<div>
	<?php foreach($my_followers as $my_follower_user) { ?>
		<img src="<?php echo $my_follower_user['user_profile_photo']; ?>">
		<?php echo $my_follower_user['user_id']; ?>
		<a href="./profile_controller.php?action_id=profile&user_profile_id=<?php echo $my_follower_user['user_id']; ?>"><?php echo $my_follower_user['user_name']; ?></a>&nbsp;
		<?php echo $my_follower_user['user_profile']; ?>
	<?php } ?>
	</div>
</div>