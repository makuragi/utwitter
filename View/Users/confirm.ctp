<h2>ユーザ登録確認</h2>
<dl>
<?php foreach ($data['User'] as $name => $val): ?>
<?php if($name === 'password' || $name === 'password_confirm') continue;?>
<?php if ($name === 'profile_photo'): ?>
	<dt><?php echo h($name); ?></dt>
	<dd><?php echo $this->Html->image('tmp'. DS . $file_name); ?></dd>
<?php 
continue;
endif;
?>
<?php if ($name === 'birthdate'): ?>
	<dt><?php echo h($name); ?></dt>
	<dd><?php echo h($val['year'] . '年' . $val['month'] . '月' . $val['day'] . '日'); ?></dd>
<?php 
continue;
endif;
?>
	<dt><?php echo h($name); ?></dt>
	<dd><?php echo h($val); ?></dd>
<?php endforeach; ?>
</dl>

<?php
echo $this->Form->create('User', array('type' => 'post', 'url' => 'complete'));

foreach ($data['User'] as $name => $val) {
	if ($name === 'password_confirm') continue;
	if ($name === 'birthdate') {
		echo $this->Form->hidden('birthdate', array('value' => $val['year'] . '-' . $val['month'] . '-' . $val['day']));
		continue;
	}
	if ($name === 'profile_photo') {
		if ($file_name !== null) {
			echo $this->Form->hidden(h($name), array('value' => h('user'. DS . $file_name)));
		} else {
			echo $this->Form->hidden(h($name), array('value' => ''));
		}
		continue;
	}
	echo $this->Form->hidden(h($name), array('value' => h($val)));
}

echo $this->Form->button('back', array('type' => 'button', 'onClick' => 'history.back()'));

echo $this->Form->end('Signup');
?>

