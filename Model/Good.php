<?php

class Good extends AppModel {

	public $belongsTo = array(
		'User' => array(
				'className' => 'User',
				'foreignKey' => 'user_id',
				'conditions' => array(
					'User.delete_flag' => '0'
				),
				'fields' => array(
					'id',
					'name',
					'profile_photo'
				)
		)
	);
}