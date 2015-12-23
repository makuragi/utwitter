<?php


class user_model {


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
			$prepare->bindValue(':user_password', $_SESSION['user_password'], PDO::PARAM_STR);
			$prepare->bindValue(':user_age', $_SESSION['user_age'], PDO::PARAM_STR);
			$prepare->bindValue(':user_gender', $_SESSION['user_gender'], PDO::PARAM_STR);
			$prepare->bindValue(':user_profile', $_SESSION['user_profile'], PDO::PARAM_STR);
			$prepare->bindValue(':user_profile_photo', $_SESSION['user_profile_photo'], PDO::PARAM_STR);
			$prepare->bindValue(':user_profile_background', $_SESSION['user_profile_background'], PDO::PARAM_STR);
			$prepare->bindValue(':user_date', $user_date, PDO::PARAM_STR);

			$prepare->execute();

			close_db_connect($db);

		} catch (PDOException $e) {
			echo 'エラー' . $e->getMessage();
		}


	}


}