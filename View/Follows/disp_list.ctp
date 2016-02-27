<p><?php echo $type?>一覧</p>
<?php
// ユーザ一覧
foreach ($user_list as $user) {
	if (mb_strlen($user['User']['profile_photo']) !== 0) {
		echo $this->Html->image($user['User']['profile_photo']) . '<br>';
	}
	echo $this->Html->link(h($user['User']['id']), array(
		'controller' => 'users',
		'action' => 'detail',
		$user['User']['id']
		)) . "&nbsp;";
	echo h($user['User']['name']) . '<br>';
	echo h($user['User']['profile']) . '<br>';
	if ($user['User']['id'] !== AuthComponent::user('id')) {
		if (!in_array($user['User']['id'], $login_follow_user_ids)) {
			echo $this->Html->link('フォローする', array(
					'controller' => 'follows',
					'action' => 'follow',
					$user['User']['id'] 
				));
		} else {
			echo $this->Html->link('さよなら', array(
					'controller' => 'follows',
					'action' => 'unfollow',
					$user['User']['id'] 
				));
		}
	}
	echo '<br><br>';
}
?>