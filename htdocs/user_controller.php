<?php

// 関数ファイル読み込み
require_once '../include/common/function.php';

// セッションを開始
session_start();

// エラー保持用配列
$errors = array();

if (!isPost()) {
	include_once '../include/view/user_create.php';
} else if (getPost('action_id') === 'user_create_confirm') {
	// todo 入力チェック
	$_SESSION['user_name']     = getPost('user_name');
	$_SESSION['user_email']    = getPost('user_email');
	$_SESSION['user_password'] = getPost('user_password');
	$_SESSION['user_age']      = getPost('user_age');
	$_SESSION['user_gender']   = getPost('user_gender');
	$_SESSION['user_profile']  = getPost('user_profile');
	// todo 画像アップロッド処理
	include_once '../include/view/user_create_confirm.php';
}
if (count($errors) !== 0) {
	foreach ($errors as $error) {
		print $error;
	}
}
