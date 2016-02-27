<?php
class profile_model {

	/**
	 * ユーザプロフィールを更新する
	 * @param unknown $db
	 * @param unknown $user_id
	 * @param unknown $user_name
	 * @param unknown $user_profile
	 * @return boolean
	 */
	public function profileEdit ($db, $user_id, $user_name, $user_profile, $user_profile_photo) {
		try {

			// SQL文を作成
			$sql = 'UPDATE user_table SET user_name = :user_name, user_profile = :user_profile,
			user_profile_photo = :edit_user_profile_photo WHERE user_id = :user_id AND user_delete_flag = 0';

			$prepare= $db->prepare($sql);

			// SQL文のプレースホルダーに値をバインドする
			$prepare->bindValue(':user_name', $user_name, PDO::PARAM_STR);
			$prepare->bindValue(':user_profile', $user_profile, PDO::PARAM_STR);
			$prepare->bindValue(':user_id',$user_id , PDO::PARAM_STR);
			$prepare->bindValue(':edit_user_profile_photo',$user_profile_photo , PDO::PARAM_STR);

			// 成功したときにtrue失敗したときにfalseを返す
			return $prepare->execute();

		} catch(PDOException $e) {
			$errors[] = entity_str($e->getMessage());
		}

	}

}