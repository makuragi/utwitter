<?php

App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {

	public $validate = array(
		'id' => array (
			'idRule1' => array (
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'アルファベットまたは数字を入力してください'
			),
			'idRule2' => array(
				'rule' => array('maxlength', 20),
				'message' => 'IDは20文字以内で入力してください'
			),
			'idRule3' => array(
				'rule' => 'checkIdUnique',
				'message' => 'そのIDは既に使われています'
			)
		),
		'name' => array(
			'nameRule1' => array(
				'rule' => array('maxlength', 20),
				'required' => true,
				'message' => 'ユーザ名は20文字以内で入力してください'
			)
		),
		'email' => array(
			'emailRule1' => array(
				'rule' => array('email', true),
				'required' => true,
				'message' => '有効なメールアドレスを入力してください'
			),
			'emailRule2' => array(
				'rule' => array('maxlength', 20),
				'message' => 'メールアドレスは40文字以内で入力してください'
			),
			'emailRule3' => array(
				'rule' => 'isUnique',
				'message' => 'このメールアドレスはすでに登録されています'
			)
		),
		'password' => array(
			'passwordRule1' => array(
				'rule' => array('between', 8, 20),
				'required' => true,
				'message' => 'パスワードは8文字以上20文字以下で入力してください'
			),
			'passwordRule2' => array(
				'rule' => 'alphaNumeric',
				'message' => 'アルファベットまたは数字を入力してください'
			)
		),
		'password_confirm' => array(
			'password_confirmRule1' => array(
				'rule' => 'validate_passwords',
				'message' => 'パスワードが一致しません'
			)
		),
		'birthdate' => array(
			'birthdateRule' => array(
				'rule' => 'date',
				'required' => true,
				'message' => '正しい日付を入力してください'
			)
		),
		'gender' => array(
			'genderRule1' => array(
				'rule' => 'notBlank',
				'message' => '性別を選択してください'
			)
		),
		'profile' => array(
			'profileRule1' => array(
				'rule' => array('maxLength', 200),
				'allowEmpty' => true,
				'message' => '自己紹介は200文字以内で入力してください'
			)
		),
		'profile_photo' => array(
			'profile_photoRule1' => array(
				'rule' => 'uploadError',
				'allowEmpty' => true,
				'message' => '画像をアップロードできませんでした'
			),
			'profile_photoRule2' => array(
				'rule' => array('extension', array( 'jpg', 'jpeg', 'png', 'gif')),
				'message' => 'ファイル形式はJPEG, PNG, GIFいずれかのファイルを選択してください'
			),
			'profile_photoRule3' => array(
				'rule' => array('mimeType', array('image/jpeg', 'image/png', 'image/gif')),
				'message' => 'MIMEタイプはJPEG, PNG, GIFいずれかのファイルを選択してください'
			),
			'profile_photoRule4' => array(
				'maxFileSize' => array(
					'rule' => array('fileSize', '<=', '10MB'),
					'message' => 'ファイルサイズが10MB以下のファイルを選択してください'
				),
				'minFileSize' => array(
					'rule' => array('fileSize', '>', 0),
					'message' => 'ファイルサイズが不正です'
				)
			)
		)
	);

	public function beforeValidate($options = array()){
		if(empty($this->data[$this->alias]['id'])) {
			return true;
		}
		else {
			if(empty($this->data[$this->alias]["profile_photo"]["name"])){
				unset($this->data[$this->alias]["profile_photo"]);
			}
			return true; //this is required, otherwise validation will always fail
		}
	}

	/**
	 * パスワードをハッシュ化させる
	 * @param unknown $options
	 * @return boolean
	 */
	public function beforeSave($options = array()) {
		// make a password for digest auth.
		$passwordHasher = new BlowfishPasswordHasher();
		$this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
		return true;
	}

	/**
	 * IDがユニークかチェックする関数
	 * @return boolean
	 */
	public function checkIdUnique(){
		$this->recursive = -1;
		$found = $this->find('all', array(
						'conditions' => array($this->alias . '.' . 'id' => $this->data[$this->alias]['id'])
					)
				);
		return !$found;
	}

	public function validate_passwords() {
		return $this->data[$this->alias]['password'] === $this->data[$this->alias]['password_confirm'];
	}
}