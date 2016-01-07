<?php
class follow_model {

	/**
	 * 新しくフォローする
	 * @param unknown $db
	 * @param unknown $login_id
	 * @param unknown $follower_user_id
	 */
	public function createFollow ($db, $login_id, $follower_user_id) {
		try {

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
	 * フォロー一覧を取得する
	 * @param unknown $db
	 * @param unknown $user_id
	 * @return multitype:
	 */
	public function myFollowUser ($db, $user_id) {
		try {

			// SQL文を作成
			$sql = 'SELECT follow.follower_user_id,user.user_id, user.user_name, user.user_profile,
			user.user_profile_photo, user.user_profile_background FROM follow_table as follow
			INNER JOIN user_table as user ON follow.follower_user_id = user.user_id
			WHERE follow.follow_user_id = :user_id AND follow.follow_delete_flag = 0
			AND user.user_delete_flag = 0';

			$prepare= $db->prepare($sql);

			// SQL文のプレースホルダーに値をバインドする
			$prepare->bindValue(':user_id',$user_id , PDO::PARAM_STR);

			$prepare->execute();

			$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

			return $result;

		} catch (PDOException $e) {
			$errors[] = entity_str($e->getMessage());
		}
	}

	/**
	 * フォロワー一覧を取得する
	 * @param unknown $db
	 * @param unknown $login_id
	 * @return unknown
	 */
	public function myFollowerUser ($db, $login_id) {
		try {

			// SQL文を作成
			$sql = 'SELECT follow.follow_user_id,user.user_id, user.user_name, user.user_profile,
			user.user_profile_photo, user.user_profile_background FROM follow_table as follow
			INNER JOIN user_table as user ON follow.follow_user_id = user.user_id
			WHERE follow.follower_user_id = :login_id AND follow.follow_delete_flag = 0
			AND user.user_delete_flag = 0';

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
	 * @param unknown $db
	 * @param unknown $login_id
	 * @param unknown $follower_user_id
	 */
	public function unfollowUser ($db, $login_id, $follower_user_id) {
		try {

			// SQL文を作成
			$sql = 'UPDATE follow_table SET follow_delete_flag = 1 WHERE
			follow_user_id = :login_id AND follower_user_id = :follower_user_id';

			$prepare= $db->prepare($sql);

			// SQL文のプレースホルダーに値をバインドする
			$prepare->bindValue(':login_id',$login_id , PDO::PARAM_STR);
			$prepare->bindValue(':follower_user_id',$follower_user_id , PDO::PARAM_STR);

			$prepare->execute();

		} catch (PDOException $e) {
			$errors[] = entity_str($e->getMessage());
		}
	}

}