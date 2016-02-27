<?php

class HomesController extends AppController {

	// モデル使用定義
	public $uses = array('User', 'Post', 'Follow');

	public function index() {

		// ログインユーザのうつぶやき件数を取得
		$post_count = $this->count('Post', array('User.id' => $this->Auth->user('id')));
		// ログインユーザのフォロー件数を取得
		$follow_count = $this->count('Follow', array('follow_user_id' => $this->Auth->user('id')));
		// ログインユーザのフォロワー件数を取得
		$follower_count = $this->count('Follow', array('follower_user_id' => $this->Auth->user('id')));

		// フォローしているユーザのIDを取得
		$follow_user_ids = $this->Follow->find('list', array(
			'conditions' => array(
				'Follow.follow_user_id' => $this->Auth->User('id'),
				'Follow.delete_flag' => '0'
			),
			'fields' => array(
				'Follow.follower_user_id'
			)
		));

		// ユーザ一覧を取得
		$user_list = $this->User->find('all', array(
			'conditions' => array(
					'User.id !=' => $this->Auth->User('id'),
					'delete_flag' => '0'
			),
			'fields' => array(
				'User.id',
				'User.name',
				'User.profile_photo',
				'User.profile'
			)
		));
		// うつぶやき一覧(返信以外)を取得
		$post_list = $this->Post->find('all', array(
			'conditions' => array(
				'User.id' => array_merge($follow_user_ids, array($this->Auth->User('id'))),
				'Post.parent_post_id' => null,
				'User.delete_flag' => '0',
				'Post.delete_flag' => '0'
			),
			'fields' => array(
				'User.id',
				'User.name',
				'User.profile_photo',
				'Post.id',
				'Post.parent_post_id',
				'Post.created',
				'Post.body'
			),
			'order' => array(
				'Post.created DESC'
			)
		));

		// うつぶやき一覧(返信)を取得
		$reply_list = $this->Post->find('all', array(
				'conditions' => array(
						'Post.parent_post_id !=' => null,
						'User.delete_flag' => '0',
						'Post.delete_flag' => '0'
				),
				'fields' => array(
						'User.id',
						'User.name',
						'User.profile_photo',
						'Post.id',
						'Post.parent_post_id',
						'Post.created',
						'Post.body'
				),
				'order' => array(
						'Post.created'
				)
		));

		$this->set('follow_user_ids', $follow_user_ids);
		$this->set('post_count', $post_count);
		$this->set('follow_count', $follow_count);
		$this->set('follower_count', $follower_count);
		$this->set('user_list', $user_list);
		$this->set('post_list', $post_list);
		$this->set('reply_list', $reply_list);
	}

	public function postCreate() {
		if ($this->request->is('post')) {
			if ($this->Post->save($this->request->data)) {
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error('うついーとできませんでした');
			}
		}
		// Viewを使わない
		$this->autoRender = false;
	}

}