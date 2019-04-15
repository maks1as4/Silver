<?php

/**
 * This is the model class for table "{{images}}".
 *
 * The followings are the available columns in table '{{images}}':
 * @property string $id_image
 * @property string $id_category
 * @property string $id_node
 * @property string $name
 * @property string $ext
 * @property string $title
 * @property string $alt
 * @property string $adate
 * @property string $udate
 * @property integer $sort_order
 */
class Images extends CActiveRecord
{
	public $title_lang;
	public $alt_lang;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{images}}';
	}

	public function primaryKey()
	{
		return 'id_image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, ext', 'required'),
			array('id_category, id_node', 'length', 'max'=>10),
			array('name', 'length', 'max'=>50),
			array('ext', 'length', 'max'=>4),
			array('title, alt', 'length', 'max'=>255),
			array('sort_order', 'numerical', 'integerOnly'=>true),
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
			'id_image' => 'id',
			'id_category' => 'Категория',
			'id_node' => 'Страница',
			'name' => 'Наименование картинки',
			'ext' => 'Расширение',
			'title' => 'Заголовок (title)',
			'alt' => 'Описание (alt)',
			'sort_order' => 'Порядковый номер',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Images the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
