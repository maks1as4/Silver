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
class NodesControl extends CActiveRecord
{
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
			array('id_category', 'equally', 'on'=>'insert, update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_node, id_category, id_node_type, name, content, description, attr, url, title_seo, desc_seo, key_seo, status, adate, udate, sort_order', 'safe', 'on'=>'search'),
			array('content, attr', 'safe', 'on'=>'insert, update'),
		);
	}

	public function equally($attribute,$params)
	{
		if(!$this->hasErrors() && $this->id_category > 0)
		{
			$cnt = self::model()->count('id_category=:catid',array(':catid'=>$this->id_category));
			if ($cnt > 0)
			{
				$model = self::model()->find('id_category=:catid',array(':catid'=>$this->id_category));
				if ($this->id_node_type != $model->id_node_type)
					$this->addError($attribute,'Категория зарезервированна под тип страниц: '.$model->nodeType->name);
			}
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
			'category'=>array(self::BELONGS_TO,'CategoriesControl','id_category'),
			'nodeType'=>array(self::BELONGS_TO,'NodeTypesControl','id_node_type'),
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

		$criteria->compare('id_node',$this->id_node,true);
		$criteria->compare('id_category',$this->id_category,true);
		$criteria->compare('id_node_type',$this->id_node_type,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('attr',$this->attr,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('title_seo',$this->title_seo,true);
		$criteria->compare('desc_seo',$this->desc_seo,true);
		$criteria->compare('key_seo',$this->key_seo,true);
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
				'defaultOrder'=>'id_category, sort_order',
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
			if (strlen($this->attr) == 0)
				$this->attr = '';
			$this->url = Functions::translit($this->name,70);
			$this->adate = date('Y-m-d H:i:s');
		}
		else
		{
			$curr = self::findByPk($this->id_node);
			if ($curr->id_category > 0 && $curr->id_category != $this->id_category)
			{
				$cnt = self::model()->count('id_category=:catid',array(':catid'=>$curr->id_category));
				if ($cnt < 2)
					CategoriesControl::model()->updateByPk($curr->id_category,array('is_catalog'=>0));
			}
		}
		if ($this->id_category > 0)
			CategoriesControl::model()->updateByPk($this->id_category,array('is_catalog'=>1));
		return parent::beforeSave();
	}

	protected function beforeDelete()
	{
		if ($this->id_category > 0)
		{
			$cnt = self::model()->count('id_category=:catid',array(':catid'=>$this->id_category));
			if ($cnt < 2)
				CategoriesControl::model()->updateByPk($this->id_category,array('is_catalog'=>0));
		}
		return parent::beforeDelete();
	}

	public static function getNodeName($id)
	{
		$model = self::model()->findByPk($id);
		return $model->name;
	}

	public static function getListWithImages()
	{
		$res = array();

		$models = Yii::app()->db->createCommand()
				->select('n.id_node, n.name')
				->from('{{nodes}} n')
				->join('{{node_types}} t', 'n.id_node_type = t.id_node_type')
				->where('t.id_image_type > 0')
				->queryAll();
		foreach ($models as $model)
			$res[$model['id_node']] = $model['name'];

		return $res;
	}

	public static function getStatus()
	{
		return array('0'=>'показ','1'=>'скрыть');
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NodesControl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
