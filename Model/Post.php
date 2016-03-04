<?php

class Post extends AppModel {

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		)
	);
	public $hasMany = array(
		'Good' => array(
			'className' => 'Good',
			'foreignKey' => 'post_id',
			'conditions' => array(
				'delete_flag' => '0'
			),
			'fields' => array(
				'post_id',
				'user_id',
			)
		)
	);
}