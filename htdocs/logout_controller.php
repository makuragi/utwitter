<?php

// 関数ファイル読み込み
require_once '../include/common/function.php';


session_start();

if(isPost() && getPost('action_id') === 'logout') {
	// ログイン状態を破棄
	unset($_SESSION['login_id']);
	setcookie('login_id', '', time() -3600);
	header('HTTP/1.1 303 See Other');
	header('Location: http://localhost//utwitter/htdocs/login_controller.php');
}