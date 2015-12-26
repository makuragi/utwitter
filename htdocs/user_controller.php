<?php

// 関数ファイル読み込み
require_once '../include/common/function.php';
require_once '../include/model/user_model.php';

// セッションを開始
session_start();

// エラー保持用配列
$errors = array();

//  todo 暫定値
$_SESSION['user_profile_photo'] = '';
$_SESSION['user_profile_background'] = '';


if (!isPost()) {
	include_once '../include/view/user_create.php';
} else if (getPost('action_id') === 'user_create_confirm') {
	// todo 入力チェック

    $_SESSION['user_id']     = getPost('user_id');
    if (!isExist($_SESSION['user_id'])) {
        $errors[] = 'ユーザIDを入力してください';
    } else if (!isOverText($_SESSION['user_id'], 10)) {
        $errors[] = 'IDは10文字以内で入力してください';
    } else if (!isOnlyAbc($_SESSION['user_id'])) {
        $errors[] = 'IDは半角英数字で入力してください';
    }
    // todo ユーザIDに重複がないかチェック
    //  if (!isUsedID($_SESSION['user_name'])) {
    //  $errors[] = '既に存在するIDです';

    $_SESSION['user_name']     = getPost('user_name');
    if (!isExist($_SESSION['user_name'])) {
        $errors[] = 'ユーザネームを入力してください';
    // todo ユーザネームは半角英数字じゃなくてもよいのでは、仕様確認
    } else if (!isOverText($_SESSION['user_name'], 10) || !isOnlyAbc($_SESSION['user_name'])) {
           $errors[] = '文字数は10文字以内の半角英数字で入力してください';
    }

    $_SESSION['user_email']    = getPost('user_email');
    if (!isExist($_SESSION['user_email'])) {
       $errors[] = 'emailアドレスを入力してください';
    } elseif (!isCorrectEmail($_SESSION['user_email'])) {
        $errors[] = '正しいアドレスを入力してください';
    }

    $_SESSION['user_password'] = getPost('user_password');
    if (!isExist($_SESSION['user_password'])) {
        $errors[] = 'パスワードを入力してください';
    } else if (!isOverText($_SESSION['user_password'], 20) || !isOnlyAbc($_SESSION['user_password'])) {
        $errors[] = 'パスワードは20文字以内の半角英数字で入力してください';
    }

//    $_SESSION['user_password_confirm'] = getPost('user_password_confirm')
//     if($_SESSION['user_password_confirm'] !== $_SESSION['user_password']){
//     	$errors[] = '確認用パスワードが一致しません';
//     }

    $_SESSION['user_age']      = getPost('user_age');
    if (!isExist($_SESSION['user_age'])) {
        $errors[] = '年齢を入力してください';
    } else if (!isOverText($_SESSION['user_age'], 3) || !isOnlyNumber($_SESSION['user_age'])) {
        $errors[] = '正しい年齢を入力してください';
    }

    $_SESSION['user_gender']   = getPost('user_gender');
    if (!isExist($_SESSION['user_gender'])) {
        $errors[] = '性別を選択してください';
    }

    $_SESSION['user_profile']  = getPost('user_profile');
    if (!isExist($_SESSION['user_profile'])) {
        $errors[] = 'プロフィールを入力してください';
    } else if (!isOverText($_SESSION['user_profile'], 200)) {
        $errors[] = '文字数は200文字以内にしてください';
    }

	// todo 画像アップロッド処理


    // 入力エラーがなかった場合、確認画面へ遷移
	if (count($errors) === 0) {
		include_once '../include/view/user_create_confirm.php';
	}

} else if (getPost('action_id') === 'user_create_result') {
	$user = new user_model();
	$user->userCreate();
	include_once '../include/view/user_create_result.php';
}

if (count($errors) !== 0) {
	foreach ($errors as $error) {
		print $error. '<br>';
	}
}

    // todo 未入力項目のチェック
    //hush化