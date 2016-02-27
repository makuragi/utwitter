<?php

class Follow extends AppModel {
	public $belongsTo = array(
		'FollowUser' => array(
			'className' => 'User',
			'foreignKey' => 'follow_user_id'
		),
		'Follower' => array(
			'className' => 'User',
			'foreignKey' => 'follower_user_id'
		)
	);
}