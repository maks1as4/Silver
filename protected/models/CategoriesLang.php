<?php

/**
 * This is the model class for table "{{categories_lang}}".
 *
 * The followings are the available columns in table '{{categories_lang}}':
 * @property string $id_category_lang
 * @property string $id_category
 * @property string $lang
 * @property string $name
 * @property string $content
 * @property string $description
 * @property string $title_seo
 * @property string $desc_seo
 * @property string $key_seo
 */
class CategoriesLang extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{categories_lang}}';
	}

	public function primaryKey()
	{
		return 'id_category_lang';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_category, lang, content', 'required'),
			array('id_category, lang', 'length', 'max'=>10),
			array('name', 'length', 'max'=>600),
			array('description', 'length', 'max'=>1000),
			array('title_seo, desc_seo, key_seo', 'length', 'max'=>100),
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
			'id_category_lang' => 'Id Category Lang',
			'id_category' => 'Id Category',
			'lang' => 'Lang',
			'name' => 'Name',
			'content' => 'Content',
			'description' => 'Description',
			'title_seo' => 'Title Seo',
			'desc_seo' => 'Desc Seo',
			'key_seo' => 'Key Seo',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CategoriesLang the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
