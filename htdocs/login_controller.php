<?php

// 関数ファイル読み込み
require_once '../include/common/function.php';

require_once '../include/model/user_model.php';

$login_id   = '';
$login_pass = '';

if (!isPost()) {
	include_once '../../include/view/login.php';
} else if (getPost('action_id') === 'login') {
	// 入力チェック
	if (strpos(getPost('login_id'), '@') === false) {
		// ユーザIDとパスワードの組み合わせでチェック
		$login_id   = getPost('login_id');
		$login_pass = getPost('login_pass');

	} else {
		// メールアドレスとパスワードの組み合わせでチェック
		$login_id   = getPost('login_id');
		$login_pass = getPost('login_pass');
	}
}