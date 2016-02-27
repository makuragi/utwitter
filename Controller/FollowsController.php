<?php

class FollowsController extends AppController {

	// モデル使用定義
	public $uses = array('Follow', 'User');

	/**
	 * ユーザをフォローします
	 * @param string $follower_user_id
	 */
	public function follow ($follower_user_id = null) {
		$this->Follow->create();

		$follow = $this->Follow->save(array(
			'follow_user_id' => $this->Auth->User('id'),
			'follower_user_id' => $follower_user_id
		));

		if ($follow === false) {
			$this->Flash->error('ユーザ登録に失敗しました');
		}
		return $this->redirect($this->referer());
	}

	/**
	 * ユーザをフォロー解除します
	 * @param string $follower_user_id
	 */
	public function unfollow ($follower_user_id = null) {
		// idを取得
		$follow_id = $this->Follow->find('first', array(
			'conditions' => array(
				'follow_user_id' => $this->Auth->User('id'),
				'follower_user_id' => $follower_user_id,
				'Follow.delete_flag' => '0'
			),
			'fields' => array(
				'id'
			)
		));
		$this->Follow->id = $follow_id['Follow']['id'];
		// 単一カラム更新
		$this->Follow->saveField('delete_flag', '1');

		// 今のページへリダイレクト
		return $this->redirect($this->referer());
	}

	/**
	 * フォロー・フォロワー一覧を取得
	 * @param string $type
	 * @param string $user_id
	 */
	public function dispList ($type = null, $user_id = null) {

		// ログインユーザのフォローユーザidsを取得する
		$login_follow_user_ids = $this->getFollowUserIds('follow_user_id', 'follower_user_id', $this->Auth->User('id'));
		// ログインユーザのフォロワーユーザidsを取得する
		$login_follower_user_ids = $this->getFollowUserIds('follower_user_id', 'follow_user_id', $this->Auth->User('id'));

		if ($type === 'followUsers') {
			// 詳細ユーザのフォローユーザidsを取得する
			$follow_user_ids = $this->getFollowUserIds('follow_user_id', 'follower_user_id', $user_id);

			$user_list = $this->getUserList($follow_user_ids);
			$this->set('type', 'フォロー');
		} else if ($type === 'followers') {
			// 詳細ユーザのフォロワーユーザidsを取得する
			$follower_user_ids = $this->getFollowUserIds('follower_user_id', 'follow_user_id', $user_id);

			$user_list = $this->getUserList($follower_user_ids);
			$this->set('type', 'フォロワー');
		} else {
			// todo: 例外処理を投げる
		}

		$this->set('login_follow_user_ids', $login_follow_user_ids);
		$this->set('login_follower_user_ids', $login_follower_user_ids);
		$this->set('user_list', $user_list);
	}

	/**
	 * ユーザリストを返却します
	 * @param array $user_ids
	 * @return array $user_list
	 */
	private function getUserList ($user_ids) {
		$user_list = $this->User->find('all', array(
				'conditions' => array(
						'User.id' => $user_ids,
						'User.delete_flag' => '0'
				),
				'fields' => array(
						'User.id',
						'User.name',
						'User.profile_photo',
						'User.profile'
				)
		));
		return $user_list;
	}
}