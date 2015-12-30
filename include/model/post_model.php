<?php

class post_model {

	/**
	 * 投稿をDB登録する
	 * @param unknown $login_id
	 * @param unknown $color_id
	 * @param unknown $post_body
	 */
	public function postCreate($login_id, $color_id, $post_body) {

		try {
			$db = get_db_connect();

			// 現在日時を取得
			$post_date = date('Y-m-d H:i:s');

			// SQL文を作成
			$sql = 'INSERT INTO post_table (user_id, color_id, post_body, post_date)
			VALUES (:user_id, :color_id, :post_body, :post_date);';

			$prepare = $db->prepare($sql);

			$prepare->bindValue(':user_id', $login_id, PDO::PARAM_STR);
			$prepare->bindValue(':color_id', intval($color_id), PDO::PARAM_INT);
			$prepare->bindValue(':post_body', $post_body, PDO::PARAM_STR);
			$prepare->bindValue(':post_date', $post_date, PDO::PARAM_STR);

			if (!$prepare->execute()) {
				$errors[] = 'DB登録処理に失敗しました';
			}

		} catch (PDOException $e) {
			$errors[] = entity_str($e->getMessage());
		}
	}

}