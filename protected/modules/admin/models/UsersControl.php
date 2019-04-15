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
class UsersControl extends CActiveRecord
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
			array('username, email', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('username, avatar', 'length', 'max'=>50),
			array('password', 'required', 'on'=>'insert, password'),
			array('password', 'match', 'pattern'=>'/^([a-z0-9-_]+)$/ui', 'message'=>'Недопустимые символы, разрешено a-z-_.', 'on'=>'insert, password'),
			array('password', 'length', 'min'=>3, 'max'=>30, 'on'=>'insert, password'),
			array('email', 'length', 'max'=>100),
			array('role', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, email, avatar, role, status, adate, udate', 'safe', 'on'=>'search'),
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
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('adate',$this->adate,true);
		$criteria->compare('udate',$this->udate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave()
	{
		if ($this->isNewRecord)
		{
			$this->adate = date('Y-m-d H:i:s');
			$this->password = md5(Yii::app()->params['salt'].$this->password);
			if (empty($this->role))
				$this->role = 'user';
			$this->status = 0;
		}
		$this->udate = date('Y-m-d H:i:s');
		if ($this->scenario == 'password')
			$this->password = md5(Yii::app()->params['salt'].$this->password);

		return parent::beforeSave();
	}

	public static function getAllRoles()
	{
		return array('user'=>'user','moder'=>'moder','admin'=>'admin');
	}

	public static function getStatus($status)
	{
		switch ($status)
		{
			case '0': return 'активен'; break;
			case '1': return 'бан'; break;
			case '2': return 'подтверждение'; break;
		}
	}

	public static function getAllStatus()
	{
		return array(0=>'активен',1=>'бан',2=>'подтверждение');
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersControl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
