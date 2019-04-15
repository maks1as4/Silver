<?php

/**
 * This is the model class for table "{{attribute_types}}".
 *
 * The followings are the available columns in table '{{attribute_types}}':
 * @property string $id_attribute_type
 * @property string $id_node_type
 * @property string $translit
 * @property string $name
 * @property integer $type
 * @property string $adate
 * @property string $udate
 */
class AttributeTypes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{attribute_types}}';
	}

	public function primaryKey()
	{
		return 'id_attribute_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_node_type, translit, name', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('id_node_type', 'length', 'max'=>10),
			array('translit, name', 'length', 'max'=>150),
			array('translit', 'unique'),
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
			'id_attribute_type' => 'id',
			'id_node_type' => 'Тип страницы',
			'translit' => 'Машинное наименование (англ.)',
			'name' => 'Наименование',
			'type' => 'Тип атрибуты',
			'adate' => 'Дата создания',
			'udate' => 'Дата изменения',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AttributeTypes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
