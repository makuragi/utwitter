<?php

echo $this->Form->create('User', array('type' => 'post'));
echo $this->Form->input('id', array('type' => 'text'));
echo $this->Form->input('password');
echo $this->Form->end('ログイン');

?>