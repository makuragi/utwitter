<div class="container">
<div class="main_wrapper">
<div class="left_container">
	<div class="my_profile">
	<div class="my_profile_image hvr-glow">
	<img src= "<?php echo $login_user_info['user_profile_photo']; ?>" >
	</div>
	<div class="my_profile_user">
		<ul>
			<li>
			<div class="my_profile_user_name">
			<a href="./profile_controller.php?action_id=profile&user_profile_id=<?php echo $login_id; ?>"><?php echo $login_user_info['user_name']; ?></a>
			</div>
			</li>
			<li>
			<div class="my_profile_user_id">
			<a href="./profile_controller.php?action_id=profile&user_profile_id=<?php echo $login_id; ?>"><?php echo '@'.$login_id; ?></a>
			</div>
			</li>
		</ul>
	</div>
	<div class="my_profile_info clear">
		<ul class="my_profile_num">
			<li><p>うついーと数</p><a href="./profile_controller.php?action_id=profile&user_profile_id=<?php echo $login_id; ?>"><?php echo $my_utweet_num; ?></a></li>
			<li><p>フォロー数</p><a href="./main_controller.php?action_id=follow"><?php echo $my_follow_num; ?></a></li>
			<li><p>フォロワー数</p><a href="./main_controller.php?action_id=follower"><?php echo $my_follower_num; ?></a></li>
		</ul>
	</div>
	</div>

