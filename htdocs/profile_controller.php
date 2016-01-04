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

$color_id  = '';
$post_body = '';
$login_user_info = array();
$user_list = array();
$my_follow_list = array();

// ユーザ情報を取得する
$login_user_info = $main->getMyProfile($login_id);

// フォロー一覧を取得
$my_follows = $main->myFollowUser($login_id);
if (is_array($my_follows)) {
	foreach($my_follows as $my_follow) {
		$my_follow_list[] = $my_follow['follower_user_id'];
	}
}
// フォロー数一覧を取得
$my_follow_num = count($my_follow_list);

// フォロワー一覧を取得
$my_followers = $main->myFollowerUser($login_id);
$my_follower_num = count($my_followers);

// 鬱イート数一覧を取得
$my_utweet_num = count($main->getMyTimeLine($login_id));

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
		$user_profile_id = getGet('user_profile_id');
		$my_profile = $main->getMyProfile($user_profile_id);
		$my_time_line = $main->getMyTimeLine($user_profile_id);
		include_once '../include/view/my_profile_edit.php';
	} else if (getPost('action_id') === 'profile_edit_complete') {
		// todo: プロフィール更新処理
	}
}

// エラー表示
include_once '../include/common/errors.php';

// フッター読み込み
include_once '../include/common/hina_footer.php';
