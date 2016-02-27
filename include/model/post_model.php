<?php

class post_model {

	/**
	 * 投稿をDB登録する
	 * @param unknown $db
	 * @param unknown $login_id
	 * @param unknown $color_id
	 * @param unknown $post_body
	 */
	public function postCreate($db, $login_id, $color_id, $post_body) {

		try {

			// 現在日時を取得
			$post_date = date('Y-m-d H:i:s');

			// SQL文を作成
			$sql = 'INSERT INTO post_table (user_id, color_id, post_body, post_date, update_at)
			VALUES (:user_id, :color_id, :post_body, :post_date, :update_at);';

			$prepare = $db->prepare($sql);

			$prepare->bindValue(':user_id', $login_id, PDO::PARAM_STR);
			$prepare->bindValue(':color_id', intval($color_id), PDO::PARAM_INT);
			$prepare->bindValue(':post_body', $post_body, PDO::PARAM_STR);
			$prepare->bindValue(':post_date', $post_date, PDO::PARAM_STR);
			$prepare->bindValue(':update_at', $post_date, PDO::PARAM_STR);


			if (!$prepare->execute()) {
				$errors[] = 'DB登録処理に失敗しました';
			}

		} catch (PDOException $e) {
			$errors[] = entity_str($e->getMessage());
		}
	}

	/**
	 * リプライ処理をおこなう
	 * @param unknown $db
	 * @param unknown $user_id
	 * @param unknown $parent_post_id
	 * @param unknown $color_id
	 * @param unknown $post_body
	 */
	public function replyCreate($db, $user_id, $parent_post_id, $color_id, $post_body) {

		try {

			// トランザクションを開始する
			$db->beginTransaction();

			// 現在日時を取得
			$cuttent_time = date('Y-m-d H:i:s');

			// SQL文を作成
			$sql = 'INSERT INTO post_table (user_id, parent_post_id, color_id, post_body, post_date, update_at)
			VALUES (:user_id, :parent_post_id, :color_id, :post_body, :post_date, :update_at);';

			$prepare = $db->prepare($sql);

			$prepare->bindValue(':user_id', $user_id, PDO::PARAM_STR);
			$prepare->bindValue(':parent_post_id', intval($parent_post_id), PDO::PARAM_INT);
			$prepare->bindValue(':color_id', intval($color_id), PDO::PARAM_INT);
			$prepare->bindValue(':post_body', $post_body, PDO::PARAM_STR);
			$prepare->bindValue(':post_date', $cuttent_time, PDO::PARAM_STR);
			$prepare->bindValue(':update_at', $cuttent_time, PDO::PARAM_STR);

			if (!$prepare->execute()) {
				$errors[] = 'DB登録処理に失敗しました';
				return false;
			}

			// 結果セットを開放
			$prepare = null;

			$sql = 'UPDATE post_table SET update_at = :update_at WHERE post_id = :parent_post_id_one
			OR parent_post_id = :parent_post_id_second';

			$prepare = $db->prepare($sql);

			$prepare->bindValue(':update_at', $cuttent_time, PDO::PARAM_STR);
			$prepare->bindValue(':parent_post_id_one', intval($parent_post_id), PDO::PARAM_INT);
			$prepare->bindValue(':parent_post_id_second', intval($parent_post_id), PDO::PARAM_INT);

			if (!$prepare->execute()) {
				$errors[] = 'DB登録処理に失敗しました';
				return false;
			}

			// コミット
			$db->commit();

			return true;

		} catch (PDOException $e) {
			$db->rollBack();
			$errors[] = entity_str($e->getMessage());
		}
	}

}