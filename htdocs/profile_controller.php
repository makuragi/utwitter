<?php

// 関数ファイル読み込み
require_once '../include/common/function.php';

require_once '../include/model/post_model.php';
require_once '../include/model/main_model.php';
require_once '../include/model/profile_model.php';

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
$profile = new profile_model();

// 変数宣言
$color_id  = '';
$post_body = '';
$login_user_info = array();
$user_list = array();
$my_follow_list = array();


// ログインIDを変数に格納する
$login_id  = $_SESSION['login_id'];

// ログインユーザ情報を取得する
$login_user_info = $main->getMyProfile($login_id);

// プロフィールユーザIDを変数に格納する
$user_profile_id = getGet('user_profile_id');

// プロフィールユーザのプロフィールとタイムラインを取得する
$my_profile = $main->getMyProfile($user_profile_id);
$my_time_line = $main->getMyTimeLine($user_profile_id);

// フォロー一覧を取得
$my_follows = $main->myFollowUser($user_profile_id);
if (is_array($my_follows)) {
	foreach($my_follows as $my_follow) {
		$my_follow_list[] = $my_follow['follower_user_id'];
	}
}
// フォロー数一覧を取得
$my_follow_num = count($my_follow_list);

// フォロワー一覧を取得
$my_followers = $main->myFollowerUser($user_profile_id);
$my_follower_num = count($my_followers);

// 鬱イート数一覧を取得
$my_utweet_num = count($main->getMyTimeLine($user_profile_id));

// ユーザ名がクリックされたとき、プロフィールページに遷移する
if (getGet('action_id') === 'profile') {
	// プロフィール画面表示
	include_once '../include/view/my_profile.php';
} else if (getGet('action_id') === 'follow') {
	// プロフィール画面表示
	include_once '../include/view/my_profile.php';
	// フォローユーザー覧画面
	include_once '../include/view/follow_list.php';

} else if (getGet('action_id') === 'follower') {
	// プロフィール画面表示
	include_once '../include/view/my_profile.php';
	// フォロワーユーザ一覧画面
	include_once '../include/view/follower_list.php';
}

if (isPost()) {
	// ユーザプロフィール編集
	if (getPost('action_id') === 'profile_edit') {
		$my_profile = $main->getMyProfile($login_id);
		$my_time_line = $main->getMyTimeLine($login_id);
		include_once '../include/view/my_profile_edit.php';
	} else if (getPost('action_id') === 'profile_edit_complete') {
		// todo: プロフィール更新処理
		$edit_user_name = entity_str(getPost('edit_user_name'));
		if (!isExist($edit_user_name)) {
			$errors[] = 'ユーザネームを入力してください';
		} else if (!isOverText($edit_user_name, 20)) {
			$errors[] = '文字数は20文字以内で入力してください';
		}
		$edit_user_profile = entity_str(getPost('edit_user_profile'));
		if (!isExist($edit_user_profile)) {
			$errors[] = 'プロフィールを入力してください';
		} else if (!isOvertext($edit_user_profile, 200)) {
			$errors[] = '文字数は200文字以内にしてください';
		}
		if (count($errors) === 0) {
			if (!$profile->profileEdit($login_id, $edit_user_name, $edit_user_profile)) {
				$errors[] = '更新に失敗しました';
			} else {
				header('HTTP/1.1 303 See Other');
				header('Location: http://localhost/utwitter/htdocs/profile_controller.php?action_id=profile&user_profile_id=' . $login_id);
				exit();
			}
		}
	}
} else {
	// プロフィール画面表示
	include_once '../include/view/my_profile.php';
}


// エラー表示
include_once '../include/common/errors.php';

// フッター読み込み
include_once '../include/common/hina_footer.php';
