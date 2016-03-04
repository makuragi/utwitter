<?php

class GoodsController extends AppController {
	// モデル使用定義
	public $uses = array('Good');

	public function good($post_id = null) {

		$this->Good->create();
		$good = $this->Good->save(array(
			'user_id' => $this->Auth->User('id'),
			'post_id' => $post_id
		));
		if ($good === false) {
			$this->Flash->error('うついねに失敗しました');
		}

		// 今のページへリダイレクト
		return $this->redirect($this->referer());
	}

	public function bad($post_id = null) {

		// idを取得
		$good_id = $this->Good->find('first', array(
			'conditions' => array(
				'Good.user_id' => $this->Auth->User('id'),
				'Good.post_id' => $post_id,
				'Good.delete_flag' => '0'
			),
			'fields' => array(
				'Good.id'
			)
		));

		$this->Good->id = $good_id['Good']['id'];
		// 単一カラム更新
		$this->Good->saveField('delete_flag', '1');

		// 今のページへリダイレクト
		return $this->redirect($this->referer());
	}
}
