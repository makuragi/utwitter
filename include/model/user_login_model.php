<?php

// todo model全般、htmlエスケープ処理の実装

class user_login_model {

	/**
	 * ユーザIDとパスワードの組み合わせでチェック
	 * @param unknown $login_id
	 * @param unknown $login_pass
	 * @return boolean
	 */
	public function loginCheck ($login_id, $login_pass) {
		try {
			// DBコネクトオブジェクト取得
			$db = get_db_connect();

			// SQL文を作成
			$sql = 'SELECT COUNT(*) as count FROM user_table
			WHERE user_id = :login_id AND user_password = :login_pass';

			$prepare = $db->prepare($sql);

			// SQL文のプレースホルダーに値をバインドする
			$prepare->bindValue(':login_id',$login_id , PDO::PARAM_STR);
			$prepare->bindValue(':login_pass',$login_pass , PDO::PARAM_STR);

			$prepare->execute();

			// 結果セットを取得(引数には戻り値の型を入力)
			$result = $prepare->fetch(PDO::FETCH_ASSOC);

			if (intval($result['count']) > 0) {
				return true;
			} else {
				return false;
			}

		} catch (PDOException $e) {
			echo 'エラー' . $e->getMessage();
		}
	}
}
