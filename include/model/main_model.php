<?php
class main_model {

	/**
	 * ユーザプロフィール情報を取得する
	 * @param unknown $db
	 * @param unknown $user_profile_id
	 * @return mixed
	 */
	public function getMyProfile ($db, $user_profile_id) {
		try {

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
	 * @param unknown $db
	 * @param unknown $user_profile_id
	 * @return multitype:
	 */
	public function getMyTimeLine ($db, $user_profile_id) {
		try {
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

	/**
	 * フォローしてるユーザと自分のタイムライン情報を取得します
	 * @param unknown $db
	 * @param unknown $login_id
	 * @param unknown $my_follow_list
	 * @return multitype:
	 */
	public function getAllTimeLine ($db, $login_id, $my_follow_list) {
		try {

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
	 * @param unknown $db
	 * @param unknown $login_id
	 * @return multitype:
	 */
	public function getUserList($db, $login_id) {
		try {

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

}