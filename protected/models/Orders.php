<?php

/**
 * This is the model class for table "{{orders}}".
 *
 * The followings are the available columns in table '{{orders}}':
 * @property string $id_order
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $comment
 * @property string $products
 * @property integer $status
 * @property string $adate
 * @property string $udate
 */
class Orders extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{orders}}';
	}

	public function primaryKey()
	{
		return 'id_order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, phone', 'required'),
			array('id_order, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('phone', 'length', 'max'=>20),
			array('email', 'length', 'max'=>100),
			array('phone', 'match', 'pattern'=>'/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', 'message'=>'Некорректный номер телефона.'),
			array('email', 'email'),
			array('comment, products, status, adate, udate', 'safe'),
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
			'id_order' => 'id',
			'name' => 'Ваше имя',
			'phone' => 'Телефон для связи',
			'email' => 'Ваш e-mail',
			'comment' => 'Комментарий к заказу',
			'products' => 'Список заказанной продукции',
			'status' => 'Статус',
			'adate' => 'Дата добавления',
			'udate' => 'Дата изменения',
		);
	}

	public function beforeSave()
	{
		if ($this->isNewRecord)
		{
			$this->adate = date('Y-m-d H:i:s');
			$this->status = 0;
		}
		$this->udate = date('Y-m-d H:i:s');
		if (strlen($this->comment) == 0)
			$this->comment = '';
		return parent::beforeSave();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Orders the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
