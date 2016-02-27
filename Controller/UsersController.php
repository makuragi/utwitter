<?php

class UsersController extends AppController {

	// モデル使用定義
	public $uses = array('User', 'Post', 'Follow');

	public function beforeFilter() {
		$this->Auth->allow(array('index', 'signup', 'confirm', 'complete'));
	}

	public function index() {
		// ログインしていた場合home画面に遷移
		$this->isUserLoggedIn();
	}

	/**
	 * ユーザ新規登録
	 */
	public function signup() {

		// ログインしていた場合home画面に遷移
		$this->isUserLoggedIn();

		$this->render('signup');
	}

	/**
	 * ユーザ新規登録確認
	 */
	public function confirm() {
		// ログインしていた場合home画面に遷移
		$this->isUserLoggedIn();

		if ($this->request->is('post')) {

			// バリデーション用にセット
			$this->User->set($this->request->data);

			// バリデーション
			if (!$this->User->validates()) {
				$this->render('signup');
			} else {
				if (mb_strlen($this->request->data['User']['profile_photo']['name']) !== 0) {
					// 画像を一時フォルダに移す
					$path = WWW_ROOT . 'img' . DS . 'tmp';
					//ファイルの拡張子を取得
					$ext = pathinfo($this->request->data['User']['profile_photo']['name'], PATHINFO_EXTENSION);
					// ファイル名を日付時刻ランダム文字列で作成
					$file_name = uniqid() . date('YmdHis') . '.' . $ext;
					move_uploaded_file($this->request->data['User']['profile_photo']['tmp_name'], $path . DS .$file_name);
				} else {
					$file_name = null;
				}
				$this->set('file_name', $file_name);
				$this->set('data', $this->request->data);
				$this->render('confirm');
			}
		}
	}

	/**
	 * ユーザ新規登録完了
	 */
	public function complete() {
		// ログインしていた場合home画面に遷移
		$this->isUserLoggedIn();
		if ($this->request->is('post')) {
			//画像をtmpからuserへ移動
			if (mb_strlen($this->request->data['User']['profile_photo']) !== 0) {
				$path = WWW_ROOT . 'img' . DS;
				if(!rename($path . 'tmp' . substr($this->request->data['User']['profile_photo'], 4), $path . $this->request->data['User']['profile_photo'])) {
					$this->Flash->error('画像が移動できませんでした');
				}
			}
			// モデルに設定されたIDを初期化
			$this->User->create();
			$user = $this->User->save($this->request->data['User'], $validate = false);
			if ($user === false) {
				$this->Flash->error('ユーザ登録に失敗しました');
			} else {
				$this->Flash->success('ユーザ登録が完了しました');
				$this->redirect(array("controller" => "users", "action" => "login"));
			}
		}
	}

	/**
	 * ログイン処理
	 */
	public function login() {

		// ログインしていた場合home画面に遷移
		$this->isUserLoggedIn();

		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->Session->setFlash('ログインに成功しました');
				return $this->redirect(array('controller' => 'homes', 'action' => 'index'));
			} else {
				$this->Session->setFlash(
					'IDとパスワードの組み合わせが違います'
				);
			}
		}
	}

	/**
	 * ログアウト処理
	 */
	public function logout() {
		$this->Auth->logout();
		return $this->redirect('/');
	}

	/**
	 * ユーザ詳細
	 */
	public function detail($id = null) {
		$user_post_list = $this->User->find('first', array(
			'conditions' => array(
				'User.id' => $id
			)
		));
		// ユーザのフォロー件数を取得
		$follow_count = $this->count('Follow', array('follow_user_id' => $id));
		// ユーザのフォロワー件数を取得
		$follower_count = $this->count('Follow', array('follower_user_id' => $id));

		$follow_user_ids = $this->getFollowUserIds('follow_user_id', 'follower_user_id', $this->Auth->User('id'));

		$this->set('user_id', $id);
		$this->set('follow_user_ids', $follow_user_ids);
		$this->set('follow_count', $follow_count);
		$this->set('follower_count', $follower_count);
		$this->set('user_post_list', $user_post_list);
	}

	/**
	 * ユーザがログインしているかチェックする
	 */
	private function isUserLoggedIn () {
		if($this->Auth->loggedIn()) {
			$this->redirect(array('controller' => 'homes', 'action' => 'index'));
		}
	}
}