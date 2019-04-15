<?php

/**
 * This is the model class for table "{{news}}".
 *
 * The followings are the available columns in table '{{news}}':
 * @property string $id_news
 * @property string $url
 * @property string $name
 * @property string $content
 * @property string $description
 * @property string $image
 * @property string $ext
 * @property string $title_seo
 * @property string $desc_seo
 * @property string $key_seo
 * @property integer $status
 * @property string $adate
 * @property string $udate
 */
class News extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{news}}';
	}

	public function primaryKey()
	{
		return 'id_news';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, content', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('url, title_seo, desc_seo, key_seo', 'length', 'max'=>100),
			array('name', 'length', 'max'=>300),
			array('description', 'length', 'max'=>500),
			array('image', 'length', 'max'=>50),
			array('ext', 'length', 'max'=>4),
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
			'id_news' => 'id',
			'url' => 'url',
			'name' => 'Наименование',
			'content' => 'Контент',
			'description' => 'Описание',
			'image' => 'Картинка новости',
			'title_seo' => 'title',
			'desc_seo' => 'description',
			'key_seo' => 'keywords',
			'status' => 'Статус',
			'adate' => 'Дата создания',
			'udate' => 'Дата изменения',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return News the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
