<?php
class main_model {

	//todo: dbコネクト処理はコントローラーの頭でやって引数を渡せばいいかも

	/**
	 * ユーザプロフィール情報を取得する
	 * @param string $user_profile_id
	 * @return mixed
	 */
	public function getMyProfile ($user_profile_id) {
		try {
			// DBコネクトオブジェクト取得
			$db = get_db_connect();

			// SQL文を作成
			$sql = 'SELECT user_name, user_profile, user_profile_photo, user_profile_background, user_date
			FROM user_table WHERE user_id = :user_profile_id AND user_delete_flag = 0';

			$prepare= $db->prepare($sql);

			// SQL文のプレースホルダーに値をバインドする
			$prepare->bindValue(':user_profile_id',$user_profile_id , PDO::PARAM_STR);

			$prepare->execute();

			// 結果セットを取得(引数には戻り値の型を入力)
			$result = $prepare->fetch(PDO::FETCH_ASSOC);

			return $result;

		} catch (PDOException $e) {
			$errors[] = entity_str($e->getMessage());
		}
	}

	/**
	 * プロフィールユーザのタイムラインを取得
	 * @param unknown $user_profile_id
	 * @return multitype:
	 */
	public function getMyTimeLine ($user_profile_id) {
		try {
			// DBコネクトオブジェクト取得
			$db = get_db_connect();

			// SQL文を作成
			$sql = 'SELECT color_id, post_body, post_date FROM post_table
			WHERE user_id = :user_profile_id AND post_delete_flag = 0 ORDER BY post_date DESC';

			$prepare= $db->prepare($sql);

			// SQL文のプレースホルダーに値をバインドする
			$prepare->bindValue(':user_profile_id',$user_profile_id , PDO::PARAM_STR);

			$prepare->execute();

			// 結果セットを取得
			$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

			return $result;

		} catch (PDOException $e) {
			$errors[] = entity_str($e->getMessage());
		}
	}
	public function getAllTimeLine ($login_id, $my_follow_list) {
		try {

			// DBコネクトオブジェクト取得
			$db = get_db_connect();

			$display_user = '\''.implode('\',\'', $my_follow_list) . '\',\'' . $login_id . '\'';

			// SQL文を作成
			$sql = 'SELECT user.user_id, user.user_name, user.user_profile_photo, post.post_id,
			post.post_body, post.post_date FROM user_table as user INNER JOIN post_table as post
			ON user.user_id = post.user_id WHERE user.user_id IN ('. $display_user .')
			ORDER BY post.post_date DESC' ;

			$prepare= $db->prepare($sql);

			$prepare->execute();

			// 結果セットを取得
			$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

			return $result;


		} catch (PDOException $e) {
			$errors[] = entity_str($e->getMessage());
		}
	}

	/**
	 * ユーザ一覧を取得する
	 * @param unknown $login_id
	 * @return multitype:
	 */
	public function getUserList($login_id) {
		try {
			// DBコネクトオブジェクト取得
			$db = get_db_connect();

			// SQL文を作成
			$sql = 'SELECT user_id, user_name, user_profile, user_profile_photo FROM user_table
			WHERE user_id <> :login_id AND user_delete_flag = 0 ORDER BY user_date DESC';

			$prepare= $db->prepare($sql);

			// SQL文のプレースホルダーに値をバインドする
			$prepare->bindValue(':login_id',$login_id , PDO::PARAM_STR);

			$prepare->execute();

			// 結果セットを取得
			$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

			return $result;

		} catch (PDOException $e) {
			$errors[] = entity_str($e->getMessage());
		}
	}

	/**
	 * 新しくフォローする
	 * @param unknown $login_id
	 * @param unknown $follower_user_id
	 */
	public function createFollow ($login_id, $follower_user_id) {
		try {

			// DBコネクトオブジェクト取得
			$db = get_db_connect();

			// 現在日時を取得
			$follow_date = date('Y-m-d H:i:s');

			// SQL文を作成
			$sql = 'INSERT INTO follow_table (follow_user_id, follower_user_id, follow_date)
			VALUES (:follow_user_id, :follower_user_id, :follow_date)';

			$prepare= $db->prepare($sql);

			// SQL文のプレースホルダーに値をバインドする
			$prepare->bindValue(':follow_user_id',$login_id , PDO::PARAM_STR);
			$prepare->bindValue(':follower_user_id',$follower_user_id , PDO::PARAM_STR);
			$prepare->bindValue(':follow_date',$follow_date , PDO::PARAM_STR);

			$prepare->execute();

		} catch (PDOException $e) {
			$errors[] = entity_str($e->getMessage());
		}
	}

	/**
	 * フォロワー一覧を取得する
	 * @param unknown $login_id
	 * @return multitype:
	 */
	public function myFollowUser ($login_id) {
		try {
			// DBコネクトオブジェクト取得
			$db = get_db_connect();

			// SQL文を作成
			$sql = 'SELECT follower_user_id FROM follow_table WHERE follow_user_id = :login_id
			AND follow_delete_flag = 0';

			$prepare= $db->prepare($sql);

			// SQL文のプレースホルダーに値をバインドする
			$prepare->bindValue(':login_id',$login_id , PDO::PARAM_STR);

			$prepare->execute();

			$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

			return $result;

		} catch (PDOException $e) {
			$errors[] = entity_str($e->getMessage());
		}
	}

	/**
	 * ユーザーをアンフォローします
	 * @param unknown $login_id
	 * @param unknown $follower_user_id
	 */
	public function unfollowUser ($login_id, $follower_user_id) {
		try {
			// DBコネクトオブジェクト取得
			$db = get_db_connect();

			// SQL文を作成
			$sql = 'UPDATE follow_table SET follow_delete_flag = 1 WHERE
			follow_user_id = :login_id AND follower_user_id = :follower_user_id';

			$prepare= $db->prepare($sql);

			// SQL文のプレースホルダーに値をバインドする
			$prepare->bindValue(':login_id',$login_id , PDO::PARAM_STR);
			$prepare->bindValue(':follower_user_id',$follower_user_id , PDO::PARAM_STR);

			$prepare->execute();

		} catch (PDOException $e) {

		}
	}

}