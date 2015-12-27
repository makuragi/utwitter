<?php

// 関数ファイル読み込み
require_once '../include/common/function.php';

require_once '../include/model/user_login_model.php';

session_start();

$login_id   = '';
$login_pass = '';

// エラー保持用配列
$errors = array();

// todo session['user_id']に値を持っていた場合、main.phpに遷移させる

if (!isPost()) {
	include_once '../include/view/login.php';
} else if (getPost('action_id') === 'login') {

	// ユーザIDとパスワードの組み合わせでチェック

	$login_id   = entity_str(getPost('login_id'));
	$login_pass = entity_str(getPost('login_pass'));

	//  todo ユーザID入力チェック
	if (!isExist($login_id)) {
		$errors[] = 'ユーザIDを入力してください';
	}

	// todo パスワード入力チェック
	if (!isExist($login_pass)) {
		$errors[] = 'パスワードを入力してください';
	}

	// 入力エラーがない場合DB認証チェック
	if (count($errors) === 0) {
		$login = new user_login_model();
		if ($login->loginCheck($login_id, $login_pass)) {
			// todo セッションにログインIDを登録
			$_SESSION['login_id'] = $login_id;

			header('HTTP/1.1 303 See Other');
			header('Location: http://localhost/utwitter/htdocs/main_controller.php');
			exit();
		} else {
			// todo ログイン画面へ。エラーメッセージも表示する。
			$errors[] = 'ユーザIDとパスワードの組み合わせが正しくありません';
			include_once '../include/view/login.php';
		}
	} else {
		// todo 入力エラーを表示(実装はajaxで非同期でDB通信する)
		foreach ($errors as $error) {
			print $error. '<br>';
		}
	}
} else if (getPost('action_id') === 'logout') {
	unset($_SESSION['login_id']);
	header('HTTP/1.1 303 See Other');
	header('Location: http://localhost/utwitter/htdocs/index.php');
}