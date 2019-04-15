<?php

/**
 * This is the model class for table "{{users}}".
 *
 * The followings are the available columns in table '{{users}}':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $avatar
 * @property string $role
 * @property integer $status
 * @property string $adate
 * @property string $udate
 */
class Users extends CActiveRecord
{
	const ROLE_ADMIN = 'admin';
	const ROLE_MODER = 'moder';
    const ROLE_USER = 'user';
	const ROLE_BANNED = 'banned';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{users}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, email, adate, udate', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('username, password, avatar', 'length', 'max'=>50),
			array('email', 'length', 'max'=>100),
			array('role', 'length', 'max'=>10),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'id',
			'username' => 'Логин',
			'password' => 'Пароль',
			'email' => 'E-mail',
			'avatar' => 'Аватар',
			'role' => 'Роль',
			'status' => 'Статус',
			'adate' => 'Дата создания',
			'udate' => 'Дата изменения',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
