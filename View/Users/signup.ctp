<?php

// formを作成する
echo $this->Form->create('User', array('type' => 'post', 'url' => 'confirm', 'enctype' => 'multipart/form-data'));
// ユーザID
echo $this->Form->input('id', array('type' => 'text', 'maxlength' => '20'));
// ユーザ名
echo $this->Form->input('name', array('type' => 'text', 'maxlength' => '20'));
// email
echo $this->Form->input('email', array('maxlength' => '40', 'type' => 'email'));
// パスワード
echo $this->Form->input('password', array('maxlength' => '100', 'type' => 'password', 'label' => 'パスワード'));
// パスワード確認用
echo $this->Form->input('password_confirm', array('maxlength' => '100', 'type' => 'password'));
// 年齢
// echo $this->Form->input('age', array('type' => 'text', 'size' => '3', 'maxlength' => '3'));
echo $this->Form->input('birthdate', array( 'label' => '誕生日', 
	'type' => 'date',
	'dateFormat' => 'YMD', 
	// 'default' => date('Y'),
	'empty' => '-',
	'minYear' => date('Y') - 100,
	'maxYear' => date('Y') - 1,
	'orderYear' => 'asc'));

// 性別
echo 'Gender' . '<br>' . $this->Form->input('gender', 
	array('type' => 'radio', 'legend' => false, 
		'options' => array('1' => '男', '2' => '女'), 'value' => '1'
		)
	);
// プロフィール
echo $this->Form->input('profile', array('type' => 'textarea', 'rows' => '4', 'value' => 'プロフィールを入力してください'));
// 画像
echo $this->Form->input('profile_photo', array('type' => 'file', 'label' => false));

echo $this->Form->end('Confirm');

?>