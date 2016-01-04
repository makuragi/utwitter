<?php

// 関数ファイル読み込み
require_once '../include/common/function.php';

require_once '../include/model/post_model.php';
require_once '../include/model/main_model.php';

// ログイン情報を読み込み
include_once '../include/common/start_session.php';

// ログインしていない場合→メニューページへ
include_once '../include/common/goto_menu.php';

// ヘッダー読み込み
include_once '../include/common/hina_header.php';

// ログアウトフォーム表示
include_once '../include/common/logout.php';

//エラー保持用配列
$errors = array();

// modelオブジェクト作成
$main = new main_model();
$post = new post_model();

// ログインIDを変数に格納する
$login_id  = $_SESSION['login_id'];

// ユーザ情報を取得する
$login_user_info = $main->getMyProfile($login_id);

// ユーザ名がクリックされたとき、プロフィールページに遷移する
if (getGet('action_id') === 'profile') {
	$user_profile_id = getGet('user_profile_id');
	$my_profile = $main->getMyProfile($user_profile_id);
	$my_time_line = $main->getMyTimeLine($user_profile_id);
	include_once '../include/view/my_profile.php';
}

if (isPost()) {
	// ユーザプロフィール編集
	if (getPost('action_id') === 'profile_edit') {
		include_once '../include/view/my_profile_edit.php';
	} else if (getPost('action_id') === 'profile_edit_complete') {
		// todo: プロフィール更新処理
	}
}

// エラー表示
include_once '../include/common/errors.php';

// フッター読み込み
include_once '../include/common/hina_footer.php';
