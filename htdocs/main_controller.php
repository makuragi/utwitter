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

$login_id  = $_SESSION['login_id'];
$color_id  = '';
$post_body = '';
$login_user_info = array();
$user_list = array();
$my_follow_list = array();
$all_time_line = array();

// ユーザ情報を取得する

$login_user_info = $main->getMyProfile($login_id);

// フォロー一覧を取得
$my_followers = $main->myFollowUser($login_id);
if (is_array($my_followers)) {
	foreach($my_followers as $key => $value) {
		foreach ($value as $follower) {
			$my_follow_list[] = $follower;
		}
	}
}
// ユーザ一覧を取得。将来的にはリコメンドユーザにしたい。
if (count($main->getUserList($login_id)) === 0) {
	$errors[] = 'ユーザ一覧データがありません';
} else {
	$user_list = $main->getUserList($login_id);
}

// タイムラインを取得します
if (count($main->getAllTimeLine($login_id, $my_follow_list)) === 0) {
	$errors[] = 'つぶやきがありません';
} else {
	$all_time_line = $main->getAllTimeLine($login_id, $my_follow_list);
}

if (isPost()) {
	if (getPost('action_id') === 'post_create') {

		$color_id  = entity_str(getPost('color_id'));
		$post_body = entity_str(getPost('post_body'));

		// 入力チェック

		if (isExist($color_id) !== true) {
			$errors[] = '色を選択してください';
		} else if (preg_match('/^[1-5]$/', $color_id) !== 1) {
			$errors[] = '正しい色を選択してください';
		}

		if (isExist($post_body) !== true) {
			$errors[] = 'つぶやきを入力してください';
		} else if (isOvertext($post_body, 140) !== true) {
			$erros[] = 'つぶやきは140文字以内で入力してください';
		}

		if (count($errors) === 0) {
			$post->postCreate($login_id, $color_id, $post_body);
			include_once '../include/common/goto_main.php';
		}
	// フォロー処理
	} else if (getPost('action_id') === 'follow') {
		$follower_user_id = getPost('follower_user_id');
		$main->createFollow($login_id, $follower_user_id);
		include_once '../include/common/goto_main.php';
	// アンフォロー処理
	} else if (getPost('action_id') === 'unfollow') {
		$follower_user_id = getPost('follower_user_id');
		$main->unfollowUser($login_id, $follower_user_id);
		include_once '../include/common/goto_main.php';
	}
}

// ユーザ名がクリックされたとき、プロフィールページに遷移する
if (isExist($_SERVER['QUERY_STRING'])) {
	$user_profile_id = $_SERVER['QUERY_STRING'];
	$my_profile = $main->getMyProfile($user_profile_id);
	$my_time_line = $main->getMyTimeLine($user_profile_id);
	include_once '../include/view/my_profile.php';
} else {
	// 投稿画面
	include_once '../include/view/post.php';
	// タイムライン
	include_once '../include/view/time_line.php';
	// ユーザ一覧画面
	include_once '../include/view/user_list.php';
}

// エラー表示
include_once '../include/common/errors.php';

// フッター読み込み
include_once '../include/common/hina_footer.php';