<?php

// 関数ファイル読み込み
require_once '../include/common/function.php';

// モデルファイル読み込み
require_once '../include/model/post_model.php';
require_once '../include/model/main_model.php';
require_once '../include/model/follow_model.php';
require_once '../include/model/good_model.php';


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
// メッセージ配列
$msg = array();
// 各変数宣言
$login_id  = $_SESSION['login_id'];

$color_id  = '';
$post_body = '';
$login_user_info = array();
$user_list = array();
$my_follow_list = array();
$good_list = array();
$all_time_line = array();

// modelオブジェクト作成
$main = new main_model();
$post = new post_model();
$follow = new follow_model();
$good = new good_model();
// DBコネクトオブジェクト取得
try {
	$db = get_db_connect();
} catch (PDOException $e) {
	$errors[] = entity_str($e->getMessage());
}

// ユーザ情報を取得する
$login_user_info = $main->getMyProfile($db, $login_id);

// フォロー一覧を取得
$my_follows = $follow->myFollowUser($db, $login_id);
if (is_array($my_follows)) {
	foreach($my_follows as $my_follow) {
		$my_follow_list[] = $my_follow['follower_user_id'];
	}
}

// フォロー数一覧を取得
$my_follow_num = count($my_follow_list);

// フォロワー一覧を取得
$my_followers = $follow->myFollowerUser($db, $login_id);
$my_follower_num = count($my_followers);

// 鬱イート数一覧を取得
$my_utweet_num = count($main->getMyTimeLine($db, $login_id));

// ログインユーザがうついねを押したpost_id一覧を取得
$good_list = $good->getGoodPostId($db, $login_id);

// todo: ユーザ一覧を取得。将来的にはリコメンドユーザにしたい。
if (count($main->getUserList($db, $login_id)) === 0) {
	$msg[] = 'ユーザ一覧データがありません';
} else {
	$user_list = $main->getUserList($db, $login_id);
}

// タイムラインを取得します
if (count($main->getAllTimeLine($db, $login_id, $my_follow_list)) === 0) {
	$msg[] = 'つぶやきがありません';
} else {
	$all_time_line = $main->getAllTimeLine($db, $login_id, $my_follow_list);
}

if (isPost()) {
	if (getPost('action_id') === 'post_create') {

		$color_id  = entity_str(getPost('color_id'));
		echo $color_id;
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
			$post->postCreate($db, $login_id, $color_id, $post_body);
			include_once '../include/common/goto_main.php';
		}
	// フォロー処理
	} else if (getPost('action_id') === 'follow') {
		$follower_user_id = getPost('follower_user_id');
		$follow->createFollow($db, $login_id, $follower_user_id);
		include_once '../include/common/goto_main.php';
	// アンフォロー処理
	} else if (getPost('action_id') === 'unfollow') {
		$follower_user_id = getPost('follower_user_id');
		$follow->unfollowUser($db, $login_id, $follower_user_id);
		include_once '../include/common/goto_main.php';
	// うついね処理
	} else if (getPost('action_id') === 'create_good') {
		$good_post_id = getPost('good_post_id');
		if (!$good->createGood($db, $login_id, $good_post_id)) {
			$errors[] = 'うついねに失敗しました';
		}
		include_once '../include/common/goto_main.php';
	// うついねキャンセル処理(うつくないね)
	} else if (getPost('action_id') === 'delete_good') {
		$good_post_id = getPost('good_post_id');
		if (!$good->deleteGood($db, $login_id, $good_post_id)) {
			$errors[] = 'うつくないねに失敗しました';
		}
		include_once '../include/common/goto_main.php';
	} else if (getPost('action_id') === 'reply') {
		// reply受け取り処理
		$parent_post_id = getPost('parent_post_id');
		$post_body = getPost('post_body');
		if (!$post->replyCreate($db, $login_id, $parent_post_id, '1', $post_body)) {
			$errors[] = '返信に失敗しました';
		}
		include_once '../include/common/goto_main.php';
	}
}

if (getGet('action_id') === 'follow') {
// フォローユーザ一覧画面を表示する
	// ユーザ一プロフィール
	include_once '../include/view/user_top.php';
	// ユーザ一覧画面
	include_once '../include/view/user_list.php';
	// フォローユーザー覧画面
	include_once '../include/view/follow_list.php';
} else if (getGet('action_id') === 'follower') {
// フォロワーユーザ一覧画面を表示する
	// ユーザープロフィール
	include_once '../include/view/user_top.php';
	// ユーザ一覧画面
	include_once '../include/view/user_list.php';
	// フォロワーユーザー覧画面
	include_once '../include/view/follower_list.php';
} else {

	// ユーザプロフィール
	include_once '../include/view/user_top.php';
	// ユーザ一覧画面
	include_once '../include/view/user_list.php';

	// 投稿画面
	include_once '../include/view/post.php';
	// エラー表示
	include_once '../include/common/errors.php';
	// 鬱バードエリア

	// タイムライン
	include_once '../include/view/time_line.php';
	// メッセージ表示
	include_once '../include/common/msg.php';
}


// フッター読み込み
include_once '../include/common/hina_footer.php';