<?php



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
