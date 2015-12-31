<div class="right_wrapper">
	<div id="my_profile">
	<img src='<?php echo $login_user_info['user_profile_photo'] ?>'><br>
	ユーザ名：<?php echo $login_user_info['user_name'] ?><br>
	ユーザID：<?php echo $login_id ?><br>
	プロフィール：<?php echo $login_user_info['user_profile'] ?><br>
	登録日時：<?php echo date('Y-m-d', strtotime($login_user_info['user_date'])); ?><br>
	</div>
</div>


<div>
<?php foreach($my_follows as $my_follow_user) { ?>
	<img src="<?php echo $my_follow_user['user_profile_photo']; ?>">
		<a href="./main_controller.php?action_id=profile&user_profile_id=<?php echo $my_follow_user['user_id']; ?>"><?php echo $my_follow_user['user_name']; ?></a>&nbsp;
		<?php echo $my_follow_user['user_name']; ?>
	<?php echo $my_follow_user['user_profile']; ?>
<?php } ?>
</div>