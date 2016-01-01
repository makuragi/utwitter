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


/** todo 削除対象
 * セッションの値が存在するか判定する
 * @param unknown $name
 * @return boolean
 */
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

/** todo: 名称をキャメルケースに変更
 * DBハンドルを取得
 * @return obj $db DBハンドル
 */
function get_db_connect() {

	// コネクション取得
	$db = new PDO(DSN, DB_USER, DB_PASSWD);
	// プリペアドステートメントのエミュレーションを無効にする
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	// エラー発生時、例外を投げる
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	return $db;
}

/**
 * ランダム文字列生成 (英数字)
 * $length: 生成する文字数
 */
function makeRandStr($length = 8) {
	static $chars;
	if (!$chars) {
		$chars = array_flip(array_merge(
				range('a', 'z'), range('A', 'Z'), range('0', '9')
		));
	}
	$str = '';
	for ($i = 0; $i < $length; ++$i) {
		$str .= array_rand($chars);
	}
	return $str;
}

/** todo: 名称をキャメルケースに変更
 * 特殊文字をHTMLエンティティに変換する
 * @param str  $str 変換前文字
 * @return str 変換後文字
 */
function entity_str($str) {
	return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}


/**
* 入力チェック
* @param unknown $name
* @param string $default
* @return unknown|string
*/

function isExist($name) {
    if (mb_strlen($name) > 0)  return true;
}

/**
*
* @param unknown $name
* @param unknown $maxlen
* @return boolean
*/

function isOvertext($name, $maxlen) {
	if (mb_strlen($name) <= $maxlen) return true;
}

    /**
     *
     * @param unknown $name
     * @param unknown $minlen
     * @return boolean
     */

    function istext($name, $minlen) {
        if (mb_strlen($name) >= $minlen)
            return true;
    }

    /**
     *
     * @param unknown $name
     * @return boolean
     */

    function isOnlyAbc($name){
        if (preg_match("/^[a-zA-Z0-9]+$/", $name)) return true;
    }

    /**
     *
     * @param unknown $name
     * @return boolean
     */

    function isOnlyNumber($name){
        if (preg_match("/^[0-9]+$/", $name)) return true;
    }

    /**
     *
     * @param unknown $name
     * @return boolean
     */
    function isOnlyKana($name){
        if(preg_match("/^[ぁ-んァ-ヶー一-龠]+$-u/", $name)) return true;
    }

    /**
     *
     * @param unknown $name
     * @return boolean
     */

    function isCorrectEmail($name) {
    	if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/" , $name)) return true;
    }

/**
 * php.iniのpost_max_sizeを超えたデータが送信されていないかチェック
 * @return boolean
 */
function checkPostMaxSize() {
	$max_size = ini_get('post_max_size');
	// post_max_sizeが8Mのように設定されていた場合に整数にする
	$multiple = 1;
	$unit = substr($max_size, -1);
	if ($unit == 'M') {
		$multiple = 1024 * 1024;
	} else if ($unit == 'K') {
		$multiple = 1024;
	} else if ($unit == 'G') {
		$multiple = 1024 * 1024 * 1024;
	}
	$max_size = substr($max_size, 0, mb_strlen($max_size) - 1) * $multiple;

	// post_max_sizeを超えたデータがPOSTされたかどうかチェック
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['CONTENT_LENGTH'] > $max_size) {
		return false;
	} else {
		return true;
	}
}

/**
 * 画像アップロードファイルをチェックする
 * @param unknown $i
 * @return multitype:boolean string multitype:string
 */
function checkFile($i) {
	$error_msg = array();
	$ext = '';

	$size = $_FILES['user_profile_photo']['size'][$i];
	$error = $_FILES['user_profile_photo']['error'][$i];
	$img_type = $_FILES['user_profile_photo']['type'][$i];
	$tmp_name = $_FILES['user_profile_photo']['tmp_name'][$i];

	if ($error != UPLOAD_ERR_OK) {
		if ($error == UPLOAD_ERR_NO_FILE) {
			// アップロードされなかった場合はエラー処理を行わない
		} else if ($error == UPLOAD_ERR_INI_SIZE || $error == UPLOAD_ERR_FORM_SIZE) {
			$error_msg[] = 'ファイルサイズは100kb以下にしてください';
		} else {
			$error_msg[] = 'アップロードエラーです';
		}
		return array(false, $ext, $error_msg);
	} else {
		if ($img_type == 'image/gif') {
			$ext = '.gif';
		} else if ($img_type == 'image/jpeg' || $img_type == 'image/pjpeg') {
			$ext = '.jpg';
		} else if ($img_type == 'image/png' || $img_type == 'image/x-png') {
			$ext = '.png';
		}

		// 画像ファイルのMIMEタイプを判定します
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$finfoType = $finfo->file($tmp_name);

		// 画像ファイルのサイズ下限をチェックします
		if ($size == 0) {
			$error_msg[] = 'ファイルが存在しないか空のファイルです';
			// 画像ファイルのサイズ上限をチェックします
		} else if ($size > FILE_MAX_SIZE) {
			$error_msg[] = 'ファイルサイズは100kb以下にしてください';
		// 送信されたMIMEタイプと、画像ファイルのMIMEタイプが一致するかを確認します
		} else if ($img_type != $finfoType) {
			$error_msg[] = 'MIMEタイプが一致しません';
		// 画像ファイルの拡張子をチェックします
		} else if ($ext != '.gif' && $ext != '.jpg' && $ext != '.png') {
			$error_msg[] = 'アップロード可能なファイルはgif, jpg, pngのみです';
		} else {
			return array(true, $ext, $error_msg);
		}
	}
	return array(false, $ext, $error_msg);
}