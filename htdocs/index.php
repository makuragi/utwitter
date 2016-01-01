<?php

// 関数ファイル読み込み
require_once '../include/common/function.php';

// ログイン情報を読み込み
include_once '../include/common/start_session.php';


// ログイン済みの場合→メインページへ
include_once '../include/common/goto_main.php';

	// セッション変数を破棄
	if (isSessionExist('user_id'))                unset($_SESSION['user_id']);
	if (isSessionExist('user_name'))              unset($_SESSION['user_name']);
	if (isSessionExist('user_email'))             unset($_SESSION['user_email']);
	if (isSessionExist('user_password'))          unset($_SESSION['user_password']);
	if (isSessionExist('user_age'))               unset($_SESSION['user_age']);
	if (isSessionExist('user_gender'))            unset($_SESSION['user_gender']);
	if (isSessionExist('user_profile'))           unset($_SESSION['user_profile']);
	if (isSessionExist('user_profile_photo'))     unset($_SESSION['user_profile_photo']);
	if (isSessionExist('user_profile_backgroud')) unset($_SESSION['user_profile_backgroud']);

	include_once '../include/view/menu.php';
