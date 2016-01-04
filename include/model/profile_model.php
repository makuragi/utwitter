<?php
class profile_model {

	/**
	 * ユーザプロフィールを更新する
	 * @param unknown $user_id
	 * @param unknown $user_name
	 * @param unknown $user_profile
	 * @param unknown $user_profile_photo
	 */
	public function profileEdit ($user_id, $user_name, $user_profile, $user_profile_photo) {
		try {
			// DBコネクトオブジェクト取得
			$db = get_db_connect();

			// SQL文を作成
			$sql = 'UPDATE user_table SET user_name = :user_name, user_profile = :user_profile, user_profile_photo = :user_profile_photo
			WHERE user_id = :user_id AND user_delete_flag = 0';

			// SQL文のプレースホルダーに値をバインドする
			$prepare->bindValue(':user_name', $user_name, PDO::PARAM_STR);
			$prepare->bindValue(':user_profile', $user_profile, PDO::PARAM_STR);
			$prepare->bindValue(':user_profile_photo',$user_profile_photo, PDO::PARAM_STR);
			$prepare->bindValue(':user_id',$user_id , PDO::PARAM_STR);

			// 成功したときにtrue失敗したときにfalseを返す
			return $prepare->execute();

		} catch(PDOException $e) {
			$errors[] = entity_str($e->getMessage());
		}

	}

}