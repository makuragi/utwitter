<?php

require_once 'const.php';

/**
 * リクエストメソッドがPOSTかどうか判定する
 * @return boolean
 */
function isPost() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		return true;
	}
}

function isSessionExist($name) {
	if (isset($_SESSION[$name])) return true;
	return false;
}

/**
 * GETから値を取得
 * @param unknown $name
 * @param string $default
 * @return unknown|string
 */
function getGet($name, $default = null) {
	if (isset($_GET[$name])) {
		return $_GET[$name];
	}

	return $default;
}

/**
 * POSTから値を取得
 * @param unknown $name
 * @param string $default
 * @return unknown|string
 */
function getPost($name, $default = null) {
	if (isset($_POST[$name])) {
		return $_POST[$name];
	}

	return $default;
}

/**
 * DBハンドルを取得
 * @return obj $db DBハンドル
 */
function get_db_connect() {

	// コネクション取得
	$db = new PDO(DSN, DB_USER, DB_PASSWD);
	// プリペアドステートメントのエミュレーションを無効にする
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	// エラー発生時、例外を投げる
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $db;
}

/**
 * DBとのコネクション切断
 * @param obj $db DBハンドル
 */
function close_db_connect($db) {
	// 接続を閉じる
	$db = null;
}

/**
 * 特殊文字をHTMLエンティティに変換する
 * @param str  $str 変換前文字
 * @return str 変換後文字
 */
function entity_str($str) {
	return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}