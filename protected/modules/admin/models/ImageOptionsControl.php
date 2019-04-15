<?php

/**
 * This is the model class for table "{{image_option}}".
 *
 * The followings are the available columns in table '{{image_option}}':
 * @property string $id_image_option
 * @property string $id_image_type
 * @property string $suffix
 * @property integer $width
 * @property integer $height
 * @property string $bgcolor
 * @property integer $type
 */
class ImageOptionsControl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{image_options}}';
	}

	public function primaryKey()
	{
		return 'id_image_option';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_image_type, suffix, width, height', 'required'),
			array('width, height', 'numerical', 'integerOnly'=>true, 'min'=>3, 'max'=>3000),
			array('type', 'numerical', 'integerOnly'=>true, 'min'=>0, 'max'=>3),
			array('id_image_type', 'length', 'max'=>10),
			array('suffix, bgcolor', 'length', 'max'=>20),
			array('suffix', 'match', 'pattern'=>'/^([a-z0-9-]+)$/u', 'message'=>'Недопустимые символы, разрешено a-z0-9-'),
			array('suffix', 'exceptions'),
			array('suffix', 'doubleUnique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_image_option, id_image_type, suffix, width, height, bgcolor, type', 'safe', 'on'=>'search'),
		);
	}

	public function exceptions($attribute,$params)
	{
		if (!$this->hasErrors())
		{
			$sufExc = array('thumb','default','original');
			if (in_array($this->suffix,$sufExc))
				$this->addError($attribute,'Суффикс зарезервирован.');
		}
	}

	public function doubleUnique($attribute,$params)
	{
		if (!$this->hasErrors())
		{
			$exists = self::model()->exists('id_image_type=:itid and suffix=:suf',array(':itid'=>$this->id_image_type,':suf'=>$this->suffix));
			if ($exists)
				$this->addError($attribute,'Суффикс зарезервирован.');
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
			'imageType'=>array(self::BELONGS_TO,'ImageTypesControl','id_image_type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_image_option' => 'id',
			'id_image_type' => 'Тип картинок',
			'suffix' => 'Суффикс',
			'width' => 'Ширина',
			'height' => 'Высота',
			'bgcolor' => 'Бекграунд',
			'type' => 'Тип обрезки',
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

		$criteria->compare('id_image_option',$this->id_image_option,true);
		$criteria->compare('id_image_type',$this->id_image_type,true);
		$criteria->compare('suffix',$this->suffix,true);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('bgcolor',$this->bgcolor,true);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>100,
			),
			'sort'=>array(
				'defaultOrder'=>'id_image_type',
			),
		));
	}

	public function beforeSave()
	{
		if (strlen($this->bgcolor) == 0)
			$this->bgcolor = '255,255,255';
		return parent::beforeSave();
	}

	public static function getResizeTypes()
	{
		return array('0'=>'thumb','1'=>'adaptiveThumb','2'=>'resize','3'=>'resizeCanvas');
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ImageOptionControl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
