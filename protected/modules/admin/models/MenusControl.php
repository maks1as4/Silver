<?php

/**
 * This is the model class for table "{{menu}}".
 *
 * The followings are the available columns in table '{{menu}}':
 * @property string $id_menu
 * @property string $name
 * @property string $description
 * @property string $icon
 */
class MenusControl extends CActiveRecord
{
	const ICONS_DIR = 'webroot.storage.images.icons';
	const ICONS_QUALITY = 95;
	public $img;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{menus}}';
	}

	public function primaryKey()
	{
		return 'id_menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>300),
			array('description', 'length', 'max'=>500),
			array('icon', 'length', 'max'=>50),
			array('img', 'file', 'types'=>'png,jpg,jpeg,gif', 'allowEmpty'=>true, 'maxSize'=>1024*1024*2, 'tooLarge'=>'Иконка слишком большая, разрешенно не более 2 MB.', 'minSize'=>512, 'tooSmall'=>'Иконка слишком маленькая, разрешенно не менее 512 Byte.', 'on'=>'create, update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_menu, name, description, icon', 'safe', 'on'=>'search'),
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
			'id_menu' => 'id',
			'name' => 'Наименование',
			'description' => 'Описание',
			'icon' => 'Картинка меню',
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

		$criteria->compare('id_menu',$this->id_menu,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('icon',$this->icon,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>100,
			),
			'sort'=>array(
				'defaultOrder'=>'id_menu',
			),
		));
	}

	public function beforeSave()
	{
		if ($img = CUploadedFile::getInstance($this,'img'))
		{
			$this->deleteIcon();
			chmod($this->getImgPath(),0777); // открываем папку для записи
			$this->icon = $img;
			$fileName = date('YmdHis').rand(1000,9999).'.'.$this->icon->getExtensionName();
			$this->icon->saveAs($this->getImgPath().$fileName);
			$this->icon = $fileName;
			$ih = new CImageHandler();
			$ih->load($this->getImgPath().$fileName)->adaptiveThumb(300,200)->save($this->getImgPath().$fileName,false,self::ICONS_QUALITY);
			chmod($this->getImgPath().$fileName,0444); // закрываем сохраненый файл от записи
			chmod($this->getImgPath(),0555); // закрываем папку от записи
		}
		return parent::beforeSave();
	}

	protected function beforeDelete()
	{
		$this->deleteIcon();
		return parent::beforeDelete();
	}

	public function deleteIcon()
	{
		chmod($this->getImgPath(),0777); // открываем папку для записи
		$iconPath = $this->getImgPath().$this->icon;
		if (is_file($iconPath))
		{
			chmod($iconPath,0777); // открываем сохраненый файл для записи
			unlink($iconPath);
		}
		chmod($this->getImgPath(),0555); // закрываем папку от записи
    }

	public function getImgPath()
	{
		return Yii::getPathOfAlias(self::ICONS_DIR).DIRECTORY_SEPARATOR;
	}

	public static function getList($withIdZero = false)
	{
		$res = array();
		if ($withIdZero)
			$res[0] = '--нет--';

		$criteria = new CDbCriteria;
		$criteria->order = 'id_menu';
		$models = self::model()->findAll($criteria);
		foreach ($models as $model)
			$res[$model->id_menu] = Functions::getSubText($model->name,50,true);

		return $res;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MenuControl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
