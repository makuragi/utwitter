<div id="my_profile_edit">
<div class="container">
<div class="main_wrapper">
<div class="left_container">
	<div class="my_profile_mypage">
		<div class="my_profile_user_mypage">
		<form action="./profile_controller.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="action_id" value="profile_edit_complete">
				<input type="file" accept="image/*" id = "getfile" name="edit_user_profile_photo">
			<div class="my_profile_image_mypage">
				<img src='<?php echo $login_user_info['user_profile_photo'] ?>' id="preview">
			</div>
				<p>ユーザー名</p>
				<input type="text" name="edit_user_name" value="<?php echo $login_user_info['user_name'] ?>" placeholder="ユーザー名を入力してください"><br>
				<p>ユーザID</p><?php echo $login_id ?>
				<p>プロフィール</p>
				<textarea name="edit_user_profile" rows="7" cols="40" placeholder="プロフィールを入力してください"><?php echo $login_user_info['user_profile']; ?></textarea><br>
			<div class="my_profile_user_date_mypage">
				登録日時<?php echo date('Y-m-d', strtotime($login_user_info['user_date'])); ?>
			</div>
			<div class="btn_profile_edit_mypage">
				<input type="submit" value="変更を保存">
			</div>
		</form>
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
				<a href="./profile_controller.php?action_id=profile&user_profile_id=<?php echo $login_id; ?>"><?php echo $login_user_info['user_name']; ?></a>
			</div>
			<div class="utweet_user_name">
				<a><?php echo '@'.$login_id; ?></a>
			</div>
			<div class="utweet_date">
			<?php echo $post['post_date'] ?>
			</div>
		</div>
		<div class="utweet">
		<?php echo $post['post_body']; ?>
		</div>
		<div>
		<div class="btn-actions">
		<img class="icon hvr-pulse" src="../include/img/parts/comment.png">
		へんじする
		</div>
		<div class="btn-actions">
		<img class="icon hvr-pulse" src="../include/img/parts/knife.png">
		うついね
		</div>


		</div>
		</div>
		</div>
		<?php } ?>
</div>

</div>
</div>
</div>