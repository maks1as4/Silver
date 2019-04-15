<?php

/**
 * This is the model class for table "{{image_option}}".
 *
 * The followings are the available columns in table '{{image_option}}':
 * @property string $id_image_option
 * @property string $id_image_type
 * @property string $suffix
 * @property integer $width
 * @property integer $height
 * @property string $bgcolor
 * @property integer $type
 */
class ImageOptions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{image_options}}';
	}

	public function primaryKey()
	{
		return 'id_image_option';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_image_type, suffix, width, height', 'required'),
			array('width, height, type', 'numerical', 'integerOnly'=>true),
			array('id_image_type', 'length', 'max'=>10),
			array('suffix, bgcolor', 'length', 'max'=>20),
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
			'id_image_option' => 'id',
			'id_image_type' => 'Тип картинок',
			'suffix' => 'Суффикс',
			'width' => 'Ширина',
			'height' => 'Высота',
			'bgcolor' => 'Бекграунд',
			'type' => 'Тип обрезки',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ImageOption the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
