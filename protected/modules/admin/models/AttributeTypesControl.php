<?php

/**
 * This is the model class for table "{{attribute_types}}".
 *
 * The followings are the available columns in table '{{attribute_types}}':
 * @property string $id_attribute_type
 * @property string $id_node_type
 * @property string $translit
 * @property string $name
 * @property integer $type
 * @property string $adate
 * @property string $udate
 */
class AttributeTypesControl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{attribute_types}}';
	}

	public function primaryKey()
	{
		return 'id_attribute_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_node_type, translit, name', 'required'),
			array('name', 'match', 'pattern'=>'/^([а-яa-z0-9\(\)-_.,\/\s]+)$/ui', 'message'=>'Недопустимые символы, разрешено а-я a-z 0-9 -_.,'),
			array('translit', 'match', 'pattern'=>'/^([a-z0-9-]+)$/u', 'message'=>'Недопустимые символы, разрешено a-z0-9-'),
			array('translit', 'unique'),
			array('id_node_type, type', 'numerical', 'integerOnly'=>true),
			array('id_node_type', 'length', 'max'=>10),
			array('translit, name', 'length', 'min'=>3, 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_attribute_type, id_node_type, translit, name, type, adate, udate', 'safe', 'on'=>'search'),
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
			'nodeType'=>array(self::BELONGS_TO,'NodeTypesControl','id_node_type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_attribute_type' => 'id',
			'id_node_type' => 'Тип страницы',
			'translit' => 'Машинное наименование (англ.)',
			'name' => 'Наименование',
			'type' => 'Тип атрибуты',
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

		$criteria->compare('id_attribute_type',$this->id_attribute_type,true);
		$criteria->compare('id_node_type',$this->id_node_type,true);
		$criteria->compare('translit',$this->translit,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type);
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

	public function beforeValidate()
	{
		if ($this->isNewRecord)
			$this->translit = $this->nodeType->translit.'-'.$this->translit;
		return parent::beforeValidate();
	}

	public function beforeSave()
	{
		$this->name = Functions::upperFirst($this->name);
		$this->udate = date('Y-m-d H:i:s');
		if ($this->isNewRecord)
			$this->adate = date('Y-m-d H:i:s');
		return parent::beforeSave();
	}

	public static function getTypes()
	{
		return array('0'=>'string','1'=>'integer','2'=>'decimal','3'=>'boolean','4'=>'link','5'=>'enum','6'=>'image','7'=>'file','8'=>'date');
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AttributeTypesControl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
