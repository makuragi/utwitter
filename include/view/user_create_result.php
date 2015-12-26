<?php

echo '登録が完了しました';

// ユーザIDをログイン情報としてsessionに保存
$_SESSION['login_id'] = $_SESSION['user_id'];

// 登録情報のsession変数を破棄
if (isSessionExist('user_id'))                unset($_SESSION['user_id']);
if (isSessionExist('user_name'))              unset($_SESSION['user_name']);
if (isSessionExist('user_email'))             unset($_SESSION['user_email']);
if (isSessionExist('user_password'))          unset($_SESSION['user_password']);
if (isSessionExist('user_age'))               unset($_SESSION['user_age']);
if (isSessionExist('user_gender'))            unset($_SESSION['user_gender']);
if (isSessionExist('user_profile'))           unset($_SESSION['user_profile']);
if (isSessionExist('user_profile_photo'))     unset($_SESSION['user_profile_photo']);
if (isSessionExist('user_profile_backgroud')) unset($_SESSION['user_profile_backgroud']);

// todo sessionに値を保存、main_controller.phpに遷移
header('HTTP/1.1 303 See Other');
header('Location: http://localhost/utwitter/htdocs/main_controller.php');
exit();