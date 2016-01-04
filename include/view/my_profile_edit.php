
<div id="my_profile">
	<form action="./profile_controller.php" method="post">
		<input type="hidden" name="action_id" value="profile_edit_complete">
		<img src='<?php echo $login_user_info['user_profile_photo'] ?>'><br>
		ユーザ名：<input type="text" name="edit_user_name" value="<?php echo $login_user_info['user_name'] ?>"><br>
		ユーザID：<?php echo $login_id ?><br>
		プロフィール<textarea name="edit_user_prifole" rows="7" cols="40"><?php echo $login_user_info['user_profile'] ?></textarea><br>
		登録日時：<?php echo date('Y-m-d', strtotime($login_user_info['user_date'])); ?><br>
		<input type="submit" value="変更を保存">
	</form>
</div>