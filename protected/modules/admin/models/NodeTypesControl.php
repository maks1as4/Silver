<?php

/**
 * This is the model class for table "{{node_types}}".
 *
 * The followings are the available columns in table '{{node_types}}':
 * @property string $id_node_type
 * @property string $id_image_type
 * @property string $translit
 * @property integer $pages
 * @property string $view
 * @property string $name
 * @property string $description
 * @property integer $comments
 * @property string $adate
 * @property string $udate
 */
class NodeTypesControl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{node_types}}';
	}

	public function primaryKey()
	{
		return 'id_node_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, translit, view', 'required'),
			array('name', 'match', 'pattern'=>'/^([а-яa-z0-9-_.,\s]+)$/ui', 'message'=>'Недопустимые символы, разрешено а-я a-z 0-9 -_.,'),
			array('translit', 'match', 'pattern'=>'/^([a-z0-9-]+)$/u', 'message'=>'Недопустимые символы, разрешено a-z0-9-'),
			array('translit', 'unique'),
			array('view', 'length', 'max'=>50),
			array('id_image_type, comments, pages', 'numerical', 'integerOnly'=>true),
			array('translit, name', 'length', 'min'=>3, 'max'=>255),
			array('description', 'length', 'max'=>1024),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_node_type, translit, name, description, comments, adate, udate', 'safe', 'on'=>'search'),
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
			'id_node_type' => 'id',
			'id_image_type' => 'Тип картинки',
			'translit' => 'Машинное наименование (англ.)',
			'pages'=> 'Колличество товаров на странице (0 - нет ограничений)',
			'view' => 'Вид',
			'name' => 'Наименование',
			'description' => 'Описание',
			'comments' => 'Комментарии для страниц',
			'adate' => 'Дата создания',
			'udate' => 'Дата изменения',
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

		$criteria->compare('id_node_type',$this->id_node_type,true);
		$criteria->compare('translit',$this->translit,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('comments',$this->comments);
		$criteria->compare('adate',$this->adate,true);
		$criteria->compare('udate',$this->udate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>100,
			),
			'sort'=>array(
				'defaultOrder'=>'id_node_type',
			),
		));
	}

	public function beforeSave()
	{
		$this->name = Functions::upperFirst($this->name);
		$this->udate = date('Y-m-d H:i:s');
		if ($this->isNewRecord)
			$this->adate = date('Y-m-d H:i:s');
		if (empty($this->pages))
			$this->pages = 30;
		return parent::beforeSave();
	}

	public static function getList()
	{
		$models = self::model()->findAll(array('order'=>'name'));
		return CHtml::listData($models,'id_node_type','name');
	}

	public static function getViewsList()
	{
		return array(
			'default'=>'default',
			'myDefault'=>'Товар (def)',
			'nodeCoins'=>'Вид для монет',
			'nodeBills'=>'Вид для банкнотов',
		);
	}

	public static function getCommentStatus()
	{
		return array('0'=>'выкл.','1'=>'вкл.');
	}

	public static function isCanDelete($id)
	{
		$res = NodesControl::model()->exists('id_node_type=:int',array(':int'=>$id));
		return !$res;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NodeTypesControl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
