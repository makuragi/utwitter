<div class="container">
<div class="main_wrapper">
<div class="left_container">
	<div class="my_profile">
		<div class="my_profile_image">
<img src='<?php echo $my_profile['user_profile_photo'] ?>'></div>
	ユーザ名：<?php echo $my_profile['user_name'] ?><br>
	ユーザID：<?php echo $user_profile_id ?><br>
	プロフィール：<?php echo $my_profile['user_profile'] ?><br>
	登録日時：<?php echo date('Y-m-d', strtotime($my_profile['user_date'])); ?><br><br><br><br><br>
	</div>
<br><br><br><br><br>
// プロフ編集フォーム
<?php if ($user_profile_id === $login_id) { ?>
<form action="./profile_controller.php" method="post">
	<input type="hidden" name="action_id" value="profile_edit">
	<input type="submit" value="ぷろふ編集">
</form>
<?php } ?>

</div>



<div class="right_container">
<div id="all_timeline">
<h3>うつぶやき</h3>
<?php foreach($my_time_line as $post) { ?>
	<div class="my_post">
		<?php echo $my_profile['user_name'] ?>&nbsp;
		<?php echo $user_profile_id ?><br>
		<?php echo $post['post_body']; ?><br>
		<?php echo $post['post_date'] ?>
	</div>
<?php } ?>
</div>
</div>

</div>

</div>