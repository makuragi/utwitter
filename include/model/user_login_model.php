<?php

// todo model全般、htmlエスケープ処理の実装

class user_login_model {

	/**
	 * ユーザIDとパスワードの組み合わせでチェック
	 * @param unknown $db
	 * @param unknown $login_id
	 * @param unknown $login_pass
	 * @return boolean
	 */
	public function loginCheck ($db, $login_id, $login_pass) {
		try {

			// SQL文を作成
			$sql = 'SELECT user_id, user_password FROM user_table
			WHERE user_id = :login_id';

			$prepare = $db->prepare($sql);

			// SQL文のプレースホルダーに値をバインドする
			$prepare->bindValue(':login_id',$login_id , PDO::PARAM_STR);

			$prepare->execute();

			// 結果セットを取得(引数には戻り値の型を入力)
			$result = $prepare->fetch(PDO::FETCH_ASSOC);

			if (count($result) > 0 && crypt($login_pass, $result['user_password']) === $result['user_password']) {
				return true;
			} else {
				return false;
			}

		} catch (PDOException $e) {
			echo 'エラー' . entity_str($e->getMessage());
		}
	}
}
