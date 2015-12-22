<?php

// 関数ファイル読み込み
require_once '../include/common/function.php';

session_start();

// セッション内容を初期化
if (isSessionExist('user_name'))     $_SESSION['user_name']     = '';
if (isSessionExist('user_email'))    $_SESSION['user_email']    = '';
if (isSessionExist('user_password')) $_SESSION['user_password'] = '';
if (isSessionExist('user_age'))      $_SESSION['user_age']      = '';
if (isSessionExist('user_gender'))   $_SESSION['user_gender']   = '';
if (isSessionExist('user_profile'))  $_SESSION['user_profile']  = '';

include_once '../include/view/menu.php';
