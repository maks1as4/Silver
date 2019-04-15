<?php

/**
 * This is the model class for table "{{images_lang}}".
 *
 * The followings are the available columns in table '{{images_lang}}':
 * @property string $id_image_lang
 * @property string $id_image
 * @property string $lang
 * @property string $title
 * @property string $alt
 */
class ImagesLang extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{images_lang}}';
	}

	public function primaryKey()
	{
		return 'id_image_lang';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_image, lang', 'required'),
			array('id_image, lang', 'length', 'max'=>10),
			array('title, alt', 'length', 'max'=>500),
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
			'id_image_lang' => 'Id Image Lang',
			'id_image' => 'Id Image',
			'lang' => 'Lang',
			'title' => 'Title',
			'alt' => 'Alt',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ImagesLang the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
