<div class="right_wrapper">
<div id="my_profile">
<img src='<?php echo $my_profile['user_profile_photo'] ?>'><br>
	ユーザ名：<?php echo $my_profile['user_name'] ?><br>
	ユーザID：<?php echo $user_profile_id ?><br>
	プロフィール：<?php echo $my_profile['user_profile'] ?><br>
	登録日時：<?php echo date('Y-m-d', strtotime($my_profile['user_date'])); ?><br>
	</div>
</div>

<div class="left_wrapper">
<div id="my_timeline" class="left">
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