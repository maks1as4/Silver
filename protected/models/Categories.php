<?php

/**
 * This is the model class for table "{{categories}}".
 *
 * The followings are the available columns in table '{{categories}}':
 * @property string $id_category
 * @property string $id_menu
 * @property string $id_parent
 * @property string $id_root
 * @property string $id_image_type
 * @property string $view
 * @property string $flag
 * @property string $name
 * @property string $content
 * @property string $description
 * @property string $url
 * @property string $title_seo
 * @property string $desc_seo
 * @property string $key_seo
 * @property integer $is_catalog
 * @property integer $status
 * @property string $adate
 * @property string $udate
 * @property integer $sort_order
 */
class Categories extends CActiveRecord
{
	public $name_lang;
	public $content_lang;
	public $description_lang;
	public $title_seo_lang;
	public $desc_seo_lang;
	public $key_seo_lang;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{categories}}';
	}

	public function primaryKey()
	{
		return 'id_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, view', 'required'),
			array('id_menu, id_parent, id_root, id_image_type, is_catalog, status, sort_order', 'numerical', 'integerOnly'=>true),
			array('id_menu, id_parent, id_root', 'length', 'max'=>10),
			array('view', 'length', 'max'=>50),
			array('flag', 'length', 'max'=>100),
			array('name', 'length', 'max'=>300),
			array('description', 'length', 'max'=>500),
			array('url, title_seo, desc_seo, key_seo', 'length', 'max'=>100),
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
			'id_category' => 'id',
			'id_menu' => 'Меню',
			'id_parent' => 'Родитель',
			'id_root' => 'Корень',
			'id_image_type' => 'Тип картинки',
			'view' => 'Вид',
			'flag' => 'Иконка флага',
			'name' => 'Наименование',
			'content' => 'Контент',
			'description' => 'Описание',
			'url' => 'url',
			'title_seo' => 'title',
			'desc_seo' => 'description',
			'key_seo' => 'keywords',
			'is_catalog' => 'Каталог',
			'status' => 'Статус',
			'adate' => 'Дата создания',
			'udate' => 'Дата изменения',
			'sort_order' => 'Номер',
		);
	}

	public static function getCategoriesBreadcrumbs($id)
	{
		$res = $tmp = array();

		do
		{
			$model = self::model()->findByPk($id);
			if (!$model)
				break;
			$id = $model->id_parent;
			$tmp[] = array('id_category'=>$model->id_category, 'name'=>$model->name, 'url'=>$model->url);
		}
		while ($model->id_parent != 0);

		$res['Каталог'] = array('site/catalog');
		for ($i=(count($tmp)-1); $i>=0; $i--)
		{
			if ($i > 0)
				$res[$tmp[$i]['name']] = array('categories/view', 'id'=>$tmp[$i]['id_category'], 'url'=>$tmp[$i]['url']);
			else
				$res[] = $tmp[$i]['name'];
		}

		return $res;
	}

	public static function getCategoriesNodeBreadcrumbs($cid, $name)
	{
		$res = $tmp = array();

		do
		{
			$model = self::model()->findByPk($cid);
			if (!$model)
				break;
			$cid = $model->id_parent;
			$tmp[] = array('id_category'=>$model->id_category, 'name'=>$model->name, 'url'=>$model->url);
		}
		while ($model->id_parent != 0);

		$res['Каталог'] = array('site/catalog');
		for ($i=(count($tmp)-1); $i>=0; $i--)
			$res[$tmp[$i]['name']] = array('categories/view', 'id'=>$tmp[$i]['id_category'], 'url'=>$tmp[$i]['url']);
		$res[] = $name;

		return $res;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Categories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
