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
 * @property integer $is_special_query
 * @property integer $status
 * @property string $adate
 * @property string $udate
 * @property integer $sort_order
 */
class CategoriesControl extends CActiveRecord
{
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
			array('id_menu, id_parent, id_root, id_image_type, is_catalog, is_special_query, status, sort_order', 'numerical', 'integerOnly'=>true),
			array('id_menu, id_parent, id_root', 'length', 'max'=>10),
			array('view', 'length', 'max'=>50),
			array('flag', 'length', 'max'=>100),
			array('name', 'length', 'max'=>300),
			array('description', 'length', 'max'=>500),
			array('url, title_seo, desc_seo, key_seo', 'length', 'max'=>100),
			array('is_special_query', 'nview'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_category, id_menu, id_parent, id_root, view, name, content, description, url, title_seo, desc_seo, key_seo, is_catalog, status, adate, udate, sort_order', 'safe', 'on'=>'search'),
			array('content', 'safe', 'on'=>'insert, update'),
		);
	}

	public function nview($attribute,$params)
	{
		if (!$this->hasErrors())
		{
			if ($this->is_special_query == 1 && $this->view == 'default')
				$this->addError($attribute,'Для сециального дапроса view не должен быть default.');
		}
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
			'is_special_query' => 'Использовать особые SQL запросы',
			'status' => 'Статус',
			'adate' => 'Дата создания',
			'udate' => 'Дата изменения',
			'sort_order' => 'Номер',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_category',$this->id_category,true);
		$criteria->compare('id_menu',$this->id_menu,true);
		$criteria->compare('id_parent',$this->id_parent,true);
		$criteria->compare('id_root',$this->id_root,true);
		$criteria->compare('view',$this->view,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('title_seo',$this->title_seo,true);
		$criteria->compare('desc_seo',$this->desc_seo,true);
		$criteria->compare('key_seo',$this->key_seo,true);
		$criteria->compare('is_catalog',$this->is_catalog);
		$criteria->compare('status',$this->status);
		$criteria->compare('adate',$this->adate,true);
		$criteria->compare('udate',$this->udate,true);
		$criteria->compare('sort_order',$this->sort_order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>100,
			),
			'sort'=>array(
				'defaultOrder'=>'id_root, sort_order',
			),
		));
	}

	public function beforeSave()
	{
		$this->name = Functions::upperFirst($this->name);
		$this->udate = date('Y-m-d H:i:s');
		if (strlen($this->content) == 0)
			$this->content = '';
		if ($this->isNewRecord)
		{
			$this->url = Functions::translit($this->name,70);
			$this->adate = date('Y-m-d H:i:s');
			if ($this->id_parent > 0)
				$this->id_root = self::getUnitRoot($this->id_parent);
			else
			{
				$this->id_parent = 0;
				$this->id_root = 0;
			}
			$this->is_catalog = 0;
		}
		else
		{
			$this->id_root = self::getUnitRoot($this->id_parent);
			$this->is_catalog = (self::getExistsNodes($this->id_category)) ? 1 : 0;
		}
		return parent::beforeSave();
	}

	public static function getCategoryName($id)
	{
		$model = self::model()->findByPk($id);
		return $model->name;
	}

	public static function getUnitRoot($id)
	{
		do
		{
			$model = self::model()->findByPk($id);
			if (!$model)
				return -1;
			$id = $model->id_parent;
		}
		while ($model->id_parent != 0);

		return $model->id_category;
	}

	public function getRootName($id)
	{
		$rname = '--нет--';

		if ($id > 0)
		{
			$model = self::model()->findByPk($id);
			if ($model)
				$rname = $model->name;
		}

		return $rname;
	}

	public static function getExistsNodes($id)
	{
		$criteria = new CDbCriteria;
		$criteria->condition = 'id_category=:catid';
		$criteria->params = array(':catid'=>$id);
		$exists = NodesControl::model()->exists($criteria);

		return $exists;
	}

	public static function getList($withIdZero = false)
	{
		$res = array();
		if ($withIdZero)
			$res[0] = '--нет--';

		$criteria = new CDbCriteria;
		$criteria->condition = 'status=0';
		$criteria->order = 'id_parent, sort_order';
		$models = self::model()->findAll($criteria);
		foreach ($models as $model)
		{
			$root = '';
			if ($model->id_root > 0)
			{
				$model_root = self::model()->findByPk($model->id_root);
				if ($model_root)
					$root = ' ('.Functions::getSubText($model_root->name,50,true).') ';
			}
			$res[$model->id_category] = '['.$model->id_category.'] '.Functions::getSubText($model->name,50,true).$root;
		}

		return $res;
	}

	public static function getListWithImages()
	{
		$models = self::model()->findAll('id_image_type>0');
		return CHtml::listData($models,'id_category','name');
	}

	public static function getRootList()
	{
		$res = array();

		$criteria = new CDbCriteria;
		$criteria->condition = 'id_parent=0 and status=0';
		$criteria->order = 'sort_order, name';
		$models = self::model()->findAll($criteria);
		foreach ($models as $model)
			$res[$model->id_category] = Functions::getSubText($model->name,50,true);

		return $res;
	}

	public static function getViewsList()
	{
		return array(
			'default'=>'default',
			'myThroughDefault'=>'Сквозная категория (def)',
			'throughCoinsBills'=>'Сквозная категория - монеты и боны',
			'myCatalogDefault'=>'Каталог с товарами',
			'catalogCoins'=>'Каталог с товарами - монеты',
			'catalogBills'=>'Каталог с товарами - боны',
		);
	}

	public static function getStatus()
	{
		return array('0'=>'показ','1'=>'скрыть');
	}

	public static function getIsCatalog()
	{
		return array('0'=>'нет','1'=>'да');
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CategoriesControl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
