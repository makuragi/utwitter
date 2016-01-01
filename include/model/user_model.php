<?php

class user_model {

	/**
	 * 重複したユーザIDがないかチェックする
	 * @param unknown $user_id
	 * @return boolean
	 */
	public function isUserExist($user_id) {
		try {

			// DBコネクトオブジェクト取得
			$db = get_db_connect();

			// SQLを作成
			$sql = 'SELECT COUNT(*) as count FROM user_table WHERE user_id = :user_id AND user_delete_flag = 0';

			$prepare = $db->prepare($sql);

			// SQL文のプレースホルダーに値をバインドする
			$prepare->bindValue(':user_id', $user_id, PDO::PARAM_STR);

			$prepare->execute();

			// 結果セットを取得(引数には戻り値の型を入力)
			$result = $prepare->fetch(PDO::FETCH_ASSOC);

			if (intval($result['count']) > 0) {
				return true;
			} else {
				return false;
			}

		} catch (PDOException $e) {
			echo 'エラー' . entity_str($e->getMessage());
		}
	}

	/**
	 * 重複したemailがないかチェックする
	 * @param unknown $user_email
	 * @return boolean
	 */
	public function isEmailExist($user_email) {
		try {

			// DBコネクトオブジェクト取得
			$db = get_db_connect();

			// SQLを作成
			$sql = 'SELECT COUNT(*) as count FROM user_table WHERE user_email = :user_email AND user_delete_flag = 0';

			$prepare = $db->prepare($sql);

			// SQL文のプレースホルダーに値をバインドする
			$prepare->bindValue(':user_email', $user_email, PDO::PARAM_STR);

			$prepare->execute();

			// 結果セットを取得(引数には戻り値の型を入力)
			$result = $prepare->fetch(PDO::FETCH_ASSOC);

			if (intval($result['count']) > 0) {
				return true;
			} else {
				return false;
			}

		} catch (PDOException $e) {
			echo 'エラー' . entity_str($e->getMessage());
		}
	}


	/**
	 * ユーザ情報を登録する
	 */
	public function userCreate() {
		try {
			// DBコネクトオブジェクト取得
			$db = get_db_connect();

			// 現在日時を取得
			$user_date = date('Y-m-d H:i:s');

			// SQL文を作成
			$sql = 'INSERT INTO user_table (user_id, user_name, user_email, user_password,
			user_age, user_gender, user_profile, user_profile_photo, user_profile_background, user_date)
			VALUES (:user_id, :user_name, :user_email, :user_password, :user_age,
			:user_gender, :user_profile, :user_profile_photo, :user_profile_background, :user_date);';

			$prepare = $db->prepare($sql);

			// SQL文のプレースホルダーに値をバインドする
			$prepare->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
			$prepare->bindValue(':user_name', $_SESSION['user_name'], PDO::PARAM_STR);
			$prepare->bindValue(':user_email', $_SESSION['user_email'], PDO::PARAM_STR);
			// パスワードをハッシュ化
			$prepare->bindValue(':user_password', crypt($_SESSION['user_password']), PDO::PARAM_STR);
			$prepare->bindValue(':user_age', $_SESSION['user_age'], PDO::PARAM_STR);
			$prepare->bindValue(':user_gender', $_SESSION['user_gender'], PDO::PARAM_STR);
			$prepare->bindValue(':user_profile', $_SESSION['user_profile'], PDO::PARAM_STR);
			$prepare->bindValue(':user_profile_photo', $_SESSION['user_profile_photo'], PDO::PARAM_STR);
			$prepare->bindValue(':user_profile_background', $_SESSION['user_profile_background'], PDO::PARAM_STR);
			$prepare->bindValue(':user_date', $user_date, PDO::PARAM_STR);

			$prepare->execute();

		} catch (PDOException $e) {
			echo 'エラー' . entity_str($e->getMessage());
		}
	}
}