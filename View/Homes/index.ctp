<div class="main">
  <div class="user_area col-xs-3">
    <div class="user_profile">
<?php
if (mb_strlen(AuthComponent::user('profile_photo')) !== 0) {
	echo $this->Html->image(AuthComponent::user('profile_photo'));
}
echo '<br>';
echo $this->Html->link(AuthComponent::user('id'), array(
	'controller' => 'users',
	'action' => 'detail',
	AuthComponent::user('id')
	)) . "&nbsp;";
echo AuthComponent::user('name');
echo '<br>';
echo AuthComponent::user('profile');
echo '<br>';
echo 'つぶやき数：' . $this->Html->link($post_count, array(
		'controller' => 'users',
		'action' => 'detail',
		AuthComponent::user('id')
	));
echo '<br>';
echo 'フォロー数：' . $this->Html->link($follow_count, array(
		'controller' => 'follows',
		'action' => 'dispList',
		'followUsers',
		AuthComponent::user('id')
	));
echo '<br>';
echo 'フォロワー数：' . $this->Html->link($follower_count, array(
		'controller' => 'follows',
		'action' => 'dispList',
		'followers',
		AuthComponent::user('id')
	));
?>
    </div><br>
    <div class="user_list">
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
	if (!in_array($user['User']['id'], $follow_user_ids)) {
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
	echo '<br><br>';
}
?>
    </div>
  </div>
  <div class="postarea col-xs-6">
    <div class="form-group post-space text-right">
<?PHP
// 投稿フォーム作成
echo $this->Form->create('Post', array('type' => 'post', 'url' => 'postCreate'));

// ユーザID
echo $this->Form->hidden('user_id', array('value' => AuthComponent::user('id')));
// 投稿内容
echo $this->Form->input('body', array('type' => 'textarea', 'rows' => '1', 'maxlength' => '140', 'placeholder' => 'うつぶきましょう', 'label' => false, 'class' => 'post-form form-control auto-link'));

echo $this->Form->end(array('label' => '投稿', 'class' => 'btn btn-primary btn-lg btn-block post-button'));
?>
     </div><!-- form-group -->
<!--投稿一覧-->
<?php foreach ($post_list as $post): ?>
<div class="panel panel-default utweet" id="<?php echo $post['Post']['id'];?>">
    <ul class="list-inline utweet-header">
     <li>
       <?php echo $this->Html->image($post['User']['profile_photo'], array('class' => 'utweet-img img-rounded')); ?>
     </li>
     <li>
<?php
echo $this->Html->link($post['User']['id'], array(
	'controller' => 'users',
	'action' => 'detail',
	$post['User']['id']
	));
?>
	  </li>
	  <li><?php echo h($post['User']['name']); ?></li>
	</ul>
  <div class="panel-body">
<?php $post['Post']['body'] = preg_replace('/(^|\s)@([a-z0-9_]+)/i',
                      '$1<a href="http://makuragi.com/users/detail/$2">@$2</a>',
                       $post['Post']['body']);
?>
	<p><?php echo $post['Post']['body']; ?></p>

  </div> <!-- panel-body -->
	<ul class="list-inline text-right">
	  <li><?php echo h($post['Post']['created']); ?></li>
	  <div class="user-id" style="display: none;"><?php echo $post['User']['id']; ?></div>
	  <div class="post-id" style="display: none;"><?php echo $post['Post']['id']; ?></div>
	  <li>
	    <button class="btn btn-primary reply-btn" data-toggle="modal" data-target="#reply-modal">
          返信する
        </button>
      </li>
	  <li>
<?php
if (!in_array($post['Post']['id'], $good_post_ids)) {
	echo $this->Html->link(__('うついね'), array(
		'controller' => 'goods',
		'action' => 'good',
		$post['Post']['id']
		));
} else {
		echo $this->Html->link(__('うつくないね'), array(
		'controller' => 'goods',
		'action' => 'bad',
		$post['Post']['id']
		));
}
?>
	  </li>
    <!-- うついね件数 -->
      <li>
<?php echo count($post['Good']); ?>
      </li>
	</ul>
</div> <!--	panel -->
<?php endforeach; ?>
<!-- reply-modal-begin -->
    <div class="modal" role="dialog" aria-hidden="true" id="reply-modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
              <button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <p class="modal-title"></p>
          </div>
          <div class="modal-body">
<?php echo $this->Form->create('Post', array('type' => 'post', 'url' => 'postCreate'));
// ユーザID
echo $this->Form->hidden('user_id', array('value' => AuthComponent::user('id')));
echo $this->Form->hidden('parent_post_id', array('id' => 'parent-post-id'));
// 投稿内容
echo $this->Form->input('body', array('type' => 'textarea', 'rows' => '1', 'maxlength' => '140', 'placeholder' => 'うつぶきましょう', 'label' => false, 'class' => 'post-form form-control post-body'));
?>
          </div>
          <div class="modal-footer">
<?php echo $this->Form->end(array('label' => '投稿', 'class' => 'btn btn-primary btn-lg btn-block post-button')); ?>
          </div>
        </div>
      </div>
    </div>
<!-- reply-modal-end -->
  </div>
</div>