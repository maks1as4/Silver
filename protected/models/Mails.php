<?php

/**
 * This is the model class for table "{{mails}}".
 *
 * The followings are the available columns in table '{{mails}}':
 * @property string $id_mail
 * @property string $from_name
 * @property string $mailto
 * @property string $replyto
 * @property string $title
 * @property string $message
 * @property string $params
 * @property integer $type
 * @property string $hash
 * @property integer $sended
 * @property string $error
 * @property string $adate
 * @property string $sdate
 */
class Mails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mails}}';
	}

	public function primaryKey()
	{
		return 'id_mail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from_name, mailto, replyto, title, message, adate', 'required'),
			array('type, sended', 'numerical', 'integerOnly'=>true),
			array('from_name', 'length', 'max'=>100),
			array('mailto', 'length', 'max'=>500),
			array('replyto', 'length', 'max'=>100),
			array('title', 'length', 'max'=>500),
			array('hash', 'length', 'max'=>50),
			array('error', 'length', 'max'=>150),
			array('params, sdate', 'safe'),
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
			'id_mail' => 'id',
			'from_name' => 'Имя отправителя',
			'mailto' => 'Адрес получателя',
			'replyto' => 'Адрес для ответа',
			'title' => 'Тема',
			'message' => 'Сообщение',
			'params' => 'Поля сообщения',
			'type' => 'Тип отправки', // 0-unknow, 1-contact, 2-quikOrder
			'hash' => 'hash код',
			'sended' => 'Флаг отправки', // 0-не отправлено, 1-отправлено
			'error' => 'Ошибка',
			'adate' => 'Дата создания',
			'sdate' => 'Дата отправки',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Mails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
