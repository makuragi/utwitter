<div class="detail_main">
  <div class="detail_user_area" style="width:33%; float:left;">
    <div class="detail_user_profile">
<?php
if (mb_strlen($user_post_list['User']['profile_photo']) !== 0) {
	echo $this->Html->image($user_post_list['User']['profile_photo']);
}
echo '<br>';
echo $user_post_list['User']['id'];
echo "&nbsp;";
echo $user_post_list['User']['name'];
echo '<br>';
echo $user_post_list['User']['profile'];
echo '<br>';
echo 'つぶやき数：' . $this->Html->link(count($user_post_list['Post']), array(
		'controller' => 'users',
		'action' => 'detail',
		$user_id
	));
echo '<br>';
echo 'フォロー数：' . $this->Html->link($follow_count, array(
		'controller' => 'follows',
		'action' => 'dispList',
		'followUsers',
		$user_id
	));
echo '<br>';
echo 'フォロワー数：' . $this->Html->link($follower_count, array(
		'controller' => 'follows',
		'action' => 'dispList',
		'followers',
		$user_id
	));
echo '<br>';
	if ($user_id !== AuthComponent::user('id')) {
		if (!in_array($user_id, $follow_user_ids)) {
			echo $this->Html->link('フォローする', array(
					'controller' => 'follows',
					'action' => 'follow',
					$user_id 
				));
		} else {
			echo $this->Html->link('さよなら', array(
					'controller' => 'follows',
					'action' => 'unfollow',
					$user_id
				));
		}
	}
?>	
    </div>
  </div>
  <div class="detail_post_area" style="width:33%; float:left;">
<?php
foreach ($user_post_list['Post'] as $post) {
	echo h($user_post_list['User']['id']) . "&nbsp;";
	echo h($user_post_list['User']['name']) . '&nbsp;';
	echo h($post['created']) . '<br>';
	echo h($post['body']);
	echo '<br>';
}
?>
  </div>
 </div>