<?php

// 関数ファイル読み込み
require_once '../include/common/function.php';
require_once '../include/model/user_model.php';

// ログイン情報を読み込み
include_once '../include/common/start_session.php';

// ログイン済みの場合→メインページへ
include_once '../include/common/goto_main.php';

//アップロードした画像を配置するtmpパス
$dir_tmp = '../include/img/tmp/';
//アップロードした画像を配置するsrcパス
$dir_src = '../include/img/src/';

// エラー保持用配列
$errors = array();

if (!isPost()) {

	// 画像のセッションを破棄
	if (isset($_SESSION['user_profile_photo']))      unset($_SESSION['user_profile_photo']);
	if (isset($_SESSION['user_profile_background'])) unset($_SESSION['user_profile_background']);

	include_once '../include/view/user_create.php';
} else if (getPost('action_id') === 'user_create_confirm') {

    //入力チェック

    $_SESSION['user_id']     = entity_str(getPost('user_id'));
    if (!isExist($_SESSION['user_id'])) {
        $errors[] = 'ユーザIDを入力してください';
    } else if (!isOverText($_SESSION['user_id'], 20)) {
        $errors[] = 'IDは20文字以内で入力してください';
    } else if (!isOnlyAbc($_SESSION['user_id'])) {
        $errors[] = 'IDは半角英数字で入力してください';
    }
    // todo ユーザIDに重複がないかチェック
    //  if (!isUsedID($_SESSION['user_name'])) {
    //  $errors[] = '既に存在するIDです';

    $_SESSION['user_name']     = entity_str(getPost('user_name'));
    if (!isExist($_SESSION['user_name'])) {
        $errors[] = 'ユーザネームを入力してください';
    // todo ユーザネームは半角英数字じゃなくてもよいのでは、仕様確認
    } else if (!isOverText($_SESSION['user_name'], 20) || !isOnlyAbc($_SESSION['user_name'])) {
           $errors[] = '文字数は20文字以内の半角英数字で入力してください';
    }

    $_SESSION['user_email']    = entity_str(getPost('user_email'));
    if (!isExist($_SESSION['user_email'])) {
       $errors[] = 'emailアドレスを入力してください';
    } elseif (!isCorrectEmail($_SESSION['user_email'])) {
        $errors[] = '正しいアドレスを入力してください';
    }

    $_SESSION['user_password'] = entity_str(getPost('user_password'));
    if (!isExist($_SESSION['user_password'])) {
        $errors[] = 'パスワードを入力してください';
    } else if (!isOverText($_SESSION['user_password'], 20) || !isOnlyAbc($_SESSION['user_password'])) {
        $errors[] = 'パスワードは20文字以内の半角英数字で入力してください';
    }

//    $_SESSION['user_password_confirm'] = getPost('user_password_confirm')
//     if($_SESSION['user_password_confirm'] !== $_SESSION['user_password']){
//     	$errors[] = '確認用パスワードが一致しません';
//     }

    $_SESSION['user_age']      = entity_str(getPost('user_age'));
    if (!isExist($_SESSION['user_age'])) {
        $errors[] = '年齢を入力してください';
    } else if (!isOverText($_SESSION['user_age'], 3) || !isOnlyNumber($_SESSION['user_age'])) {
        $errors[] = '正しい年齢を入力してください';
    }

    $_SESSION['user_gender']   = entity_str(getPost('user_gender'));
    if (!isExist($_SESSION['user_gender'])) {
        $errors[] = '性別を選択してください';
    }

    $_SESSION['user_profile']  = entity_str(getPost('user_profile'));
    if (!isExist($_SESSION['user_profile'])) {
        $errors[] = 'プロフィールを入力してください';
    } else if (!isOverText($_SESSION['user_profile'], 200)) {
        $errors[] = '文字数は200文字以内にしてください';
    }
    // 画像アップロード処理

    if (!checkPostMaxSize()) {
    	$errors[] = 'ファイルサイズは100KB以下にしてください';
    }
    if (isset($_FILES['user_profile_photo'])) {
		for ($i = 0; $i < count($_FILES['user_profile_photo']['name']); $i++) {
			// アップロードファイルチェック
			list($result, $ext, $error_msg) = checkFile($i);
			$errors = array_merge($errors, $error_msg);

			if ($result) {
				$name = $_FILES['user_profile_photo']['name'][$i];
				$tmp_name = $_FILES['user_profile_photo']['tmp_name'][$i];

				// 画像保存先ファイルパス
				$move_to = $dir_tmp . makeRandStr() .$ext;

				// アップロードした一時ファイルを指定した場所へ移動します
				if (!move_uploaded_file($tmp_name, $move_to)) {
					$errors[] = '画像のアップロードに失敗しました';
					if ($i == 0) {
						$_SESSION['user_profile_photo'] = '';
					} else {
						$_SESSION['user_profile_background'] = '';
					}
				} else {
					if ($i == 0 ) {
						$_SESSION['user_profile_photo'] = $move_to;
					} else {
						$_SESSION['user_profile_background'] = $move_to;
					}
				}
			}
		}
    }

    // 入力エラーがなかった場合、確認画面へ遷移
	if (count($errors) === 0) {
		include_once '../include/view/user_create_confirm.php';
	}

} else if (getPost('action_id') === 'user_create_result') {
	// プロフィール画像を移動
	if (isset($_SESSION['user_profile_photo'])) {
		$save_prof_to = $dir_src . pathinfo($_SESSION['user_profile_photo'], PATHINFO_BASENAME);
		if (!rename($_SESSION['user_profile_photo'], $save_prof_to)) {
			$errors[] = '画像ファイル移動に失敗しました';
		} else {
			$_SESSION['user_profile_photo'] = $save_prof_to;
		}
	} else {
		$_SESSION['user_profile_photo'] = '';
	}
	// 背景画像を移動
	if (isset($_SESSION['user_profile_background'])) {
		$save_bg_to = $dir_src . pathinfo($_SESSION['user_profile_background'], PATHINFO_BASENAME);
		if (!rename($_SESSION['user_profile_background'], $save_bg_to)) {
			$errors[] = '画像ファイル移動に失敗しました';
		} else {
			$_SESSION['user_profile_background'] = $save_bg_to;
		}
	} else {
		$_SESSION['user_profile_background'] = '';
	}

	if (count($errors) === 0) {
		$user = new user_model();
		$user->userCreate();
		include_once '../include/view/user_create_result.php';
	}
}

// todo: エラー表示はviewファイルの中で表示できるようにしたい
if (count($errors) !== 0) {
	foreach ($errors as $error) {
		print $error. '<br>';
	}
}
