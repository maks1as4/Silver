<?php

/**
 * This is the model class for table "{{image_types}}".
 *
 * The followings are the available columns in table '{{image_types}}':
 * @property string $id_image_type
 * @property string $translit
 * @property string $name
 * @property integer $type
 */
class ImageTypes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{image_types}}';
	}

	public function primaryKey()
	{
		return 'id_image_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('translit, name', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('translit, name', 'length', 'max'=>255),
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
			'id_image_type' => 'id',
			'translit' => 'Машинное наименование (англ.)',
			'name' => 'Наименование',
			'type' => 'Тип',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ImageTypes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
