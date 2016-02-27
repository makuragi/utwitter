<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	// Componentの使用
	public $components = array(
		'Auth' => array(
			'loginAction' => array(
				'controller' => 'users',
				'action' => 'login'
			),
			'authError' => 'Did you really think you are allowed to see that?',
			'authenticate' => array(
				'Form' => array(
					'userModel' => 'User',
					'fields' => array(
						'username' => 'id',
						'password' => 'password'
					),
					'passwordHasher' => 'Blowfish'
				)
			)
		)
		,'Flash', 'Session');


	/**
	 * カウント数を返却する
	 * @param string $model_name
	 * @param array $target
	 * @return boolean|int $count
	 */
	public function count ($model_name, $target) {
		if (!is_array($target)) return false;
		$key = key($target);
		$count = $this->$model_name->find('count', array(
				'conditions' => array(
						$key => $target[$key],
						$model_name . '.delete_flag' => '0'
				)
		));
		return $count;
	}

	/**
	 * フォロー・フォロワーユーザidsを返却します
	 * @param string $key_column
	 * @param string $target_column
	 * @param String $user_id
	 * @return array $user_ids
	 */
	public function getFollowUserIds ($key_column, $target_column, $user_id) {
		$user_ids = $this->Follow->find('list', array(
				'conditions' => array(
						$key_column => $user_id,
						'Follow.delete_flag' => '0'
				),
				'fields' => array($target_column)
		));
		return $user_ids;
	}
}
