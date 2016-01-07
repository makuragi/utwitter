<?php
class good_model {

	/**
	 * うついねを追加するメソッドです
	 * @param unknown $db
	 * @param unknown $login_id
	 * @param unknown $good_post_id
	 */
	public function createGood ($db, $login_id, $good_post_id) {
		try {

			// 現在日時を取得
			$good_date = date('Y-m-d H:i:s');

			// SQL文を作成
			$sql = 'INSERT INTO good_table (good_post_id, good_user_id, good_date)
			VALUES (:good_post_id, :good_user_id, :good_date)';

			$prepare= $db->prepare($sql);

			// SQL文のプレースホルダーに値をバインドする
			$prepare->bindValue(':good_post_id',intval($good_post_id) , PDO::PARAM_INT);
			$prepare->bindValue(':good_user_id',$login_id , PDO::PARAM_STR);
			$prepare->bindValue(':good_date',$good_date , PDO::PARAM_STR);

			return $prepare->execute();

		} catch (PDOException $e) {
			$errors[] = entity_str($e->getMessage());
		}
	}

	/**
	 * ユーザIDをキーにうついねを押したpost_id一覧を取得するメソッドです
	 * @param unknown $db
	 * @param unknown $user_id
	 * @return multitype:unknown
	 */
	public function getGoodPostId ($db, $user_id) {
		try {

			$good_list = array();

			// SQL文を作成
			$sql = 'SELECT good_post_id FROM good_table WHERE good_user_id = :user_id
			 AND good_delete_flag = 0';

			$prepare= $db->prepare($sql);

			// SQL文のプレースホルダーに値をバインドする
			$prepare->bindValue(':user_id',$user_id , PDO::PARAM_STR);

			$prepare->execute();

			$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

			if (is_array($result)) {
				foreach($result as $value) {
					$good_list[] = $value['good_post_id'];
				}
			}

			return $good_list;

		} catch (PDOException $e) {
			$errors[] = entity_str($e->getMessage());
		}
	}

	/**
	 * うついねを取り消すメソッドです
	 * @param unknown $db
	 * @param unknown $login_id
	 * @param unknown $good_post_id
	 */
	public function deleteGood ($db, $login_id, $good_post_id) {
		try {

			// SQL文を作成
			$sql = 'UPDATE good_table SET good_delete_flag = 1 WHERE
			good_post_id = :good_post_id AND good_user_id = :good_user_id';

			$prepare= $db->prepare($sql);

			// SQL文のプレースホルダーに値をバインドする
			$prepare->bindValue(':good_post_id',intval($good_post_id) , PDO::PARAM_INT);
			$prepare->bindValue(':good_user_id',$login_id , PDO::PARAM_STR);

			return $prepare->execute();

		} catch (PDOException $e) {
			$errors[] = entity_str($e->getMessage());
		}
	}

}