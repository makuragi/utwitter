<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	public function alphaNumeric($check) {
		$value = array_values($check);  // 配列の添字を数値添字に変換
		$value = $value[0];     // 最初の値を取る
		return preg_match('/^[a-zA-Z0-9]+$/', $value);
	}
}
