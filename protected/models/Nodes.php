<?php

/**
 * This is the model class for table "{{nodes}}".
 *
 * The followings are the available columns in table '{{nodes}}':
 * @property string $id_node
 * @property string $id_category
 * @property string $id_node_type
 * @property string $name
 * @property string $content
 * @property string $description
 * @property string $attr
 * @property decimal $price
 * @property integer $existence
 * @property string $url
 * @property string $title_seo
 * @property string $desc_seo
 * @property string $key_seo
 * @property integer $status
 * @property string $adate
 * @property string $udate
 * @property integer $sort_order
 */
class Nodes extends CActiveRecord
{
	public $name_lang;
	public $content_lang;
	public $description_lang;
	public $attr_lang;
	public $title_seo_lang;
	public $desc_seo_lang;
	public $key_seo_lang;
	public $view;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{nodes}}';
	}

	public function primaryKey()
	{
		return 'id_node';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_node_type, name', 'required'),
			array('id_category, id_node_type, status, sort_order, existence', 'numerical', 'integerOnly'=>true),
			array('id_category, id_node_type, existence', 'length', 'max'=>10),
			array('name', 'length', 'max'=>300),
			array('description', 'length', 'max'=>500),
			array('url, title_seo, desc_seo, key_seo', 'length', 'max'=>100),
			array('price', 'numerical', 'integerOnly'=>false),
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
			'id_node' => 'id',
			'id_category' => 'Категория',
			'id_node_type' => 'Тип страницы',
			'name' => 'Наименование',
			'content' => 'Контент',
			'description' => 'Описание',
			'attr' => 'Атрибуты',
			'price' => 'Цена',
			'existence' => 'Наличие',
			'url' => 'url',
			'title_seo' => 'title',
			'desc_seo' => 'description',
			'key_seo' => 'keywords',
			'status' => 'Статус',
			'adate' => 'Дата создания',
			'udate' => 'Дата изменения',
			'sort_order' => 'Номер',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Nodes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
