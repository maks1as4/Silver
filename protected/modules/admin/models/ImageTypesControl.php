<?php

/**
 * This is the model class for table "{{image_types}}".
 *
 * The followings are the available columns in table '{{image_types}}':
 * @property string $id_image_type
 * @property string $translit
 * @property string $name
 * @property integer $type
 */
class ImageTypesControl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{image_types}}';
	}

	public function primaryKey()
	{
		return 'id_image_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('translit, name', 'required'),
			array('name', 'match', 'pattern'=>'/^([а-яa-z0-9-_.,\s]+)$/ui', 'message'=>'Недопустимые символы, разрешено а-я a-z 0-9 -_.,'),
			array('translit', 'match', 'pattern'=>'/^([a-z0-9-]+)$/u', 'message'=>'Недопустимые символы, разрешено a-z0-9-'),
			array('translit', 'unique'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('translit, name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_image_type, translit, name, type', 'safe', 'on'=>'search'),
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
			'id_image_type' => 'id',
			'translit' => 'Машинное наименование (англ.)',
			'name' => 'Наименование',
			'type' => 'Тип',
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

		$criteria->compare('id_image_type',$this->id_image_type,true);
		$criteria->compare('translit',$this->translit,true);
		$criteria->compare('name',$this->name,true);
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
		$this->name = Functions::upperFirst($this->name);
		return parent::beforeSave();
	}

	public function beforeDelete()
	{
		ImageOptionsControl::model()->deleteAll('id_image_type=:iit',array(':iit'=>$this->id_image_type));
		return parent::beforeDelete();
	}

	public function afterSave()
	{
		if ($this->isNewRecord)
		{
			$option = new ImageOptionsControl;

			// 70x70 thumb
			$option->id_image_type = $this->id_image_type;
			$option->suffix = 'thumb';
			$option->width = 70;
			$option->height = 70;
			$option->bgcolor = '255,255,255';
			$option->type = 1;
			$option->save(false);

			$option->id_image_option = false;
			$option->isNewRecord = true;

			// 200x200 default
			$option->id_image_type = $this->id_image_type;
			$option->suffix = 'default';
			$option->width = 200;
			$option->height = 200;
			$option->bgcolor = '255,255,255';
			$option->type = 1;
			$option->save(false);

			$option->id_image_option = false;
			$option->isNewRecord = true;

			// 1000x800 original
			$option->id_image_type = $this->id_image_type;
			$option->suffix = 'original';
			$option->width = 1000;
			$option->height = 800;
			$option->bgcolor = '255,255,255';
			$option->type = 0;
			$option->save(false);
		}
		return parent::afterSave();
	}

	public static function getList()
	{
		$models = self::model()->findAll(array('order'=>'name'));
		return CHtml::listData($models,'id_image_type','name');
	}

	public static function getSplitedList($split)
	{
		$res = array();
		$res[0] = '--нет--';
		$models = self::model()->findAll('type=:tp',array(':tp'=>$split));
		foreach ($models as $model)
			$res[$model->id_image_type] = $model->name.' ('.$model->translit.')';
		return $res;
	}

	public static function getImageTypes()
	{
		return array('0'=>'category','1'=>'node');
	}

	public static function isCanDelete($id,$type)
	{
		$res = true; // по умолчанию false, так как на выходе отрицание

		if ($type == 0) // category
			$res = CategoriesControl::model()->exists('id_image_type=:iit',array(':iit'=>$id));
		elseif ($type == 1) // node
			$res = NodeTypesControl::model()->exists('id_image_type=:iit',array(':iit'=>$id));

		return !$res;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ImageTypesControl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
