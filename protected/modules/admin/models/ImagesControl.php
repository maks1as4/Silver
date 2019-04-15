<?php

/**
 * This is the model class for table "{{images}}".
 *
 * The followings are the available columns in table '{{images}}':
 * @property string $id_image
 * @property string $id_category
 * @property string $id_node
 * @property string $name
 * @property string $ext
 * @property string $title
 * @property string $alt
 * @property string $adate
 * @property string $udate
 * @property integer $sort_order
 */
class ImagesControl extends CActiveRecord
{
	const IMAGES_DIR = 'webroot.storage.images';
	const IMAGES_QUALITY = 95;
	public $img;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{images}}';
	}

	public function primaryKey()
	{
		return 'id_image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_category, id_node', 'length', 'max'=>10),
			array('id_category', 'oneid'),
			array('id_category', 'reqid'),
			array('name', 'length', 'max'=>50),
			array('ext', 'length', 'max'=>4),
			array('title, alt', 'length', 'max'=>255),
			array('sort_order', 'numerical', 'integerOnly'=>true),
			array('img', 'file', 'types'=>'png,jpg,jpeg,gif', 'allowEmpty'=>false, 'maxSize'=>1024*1024*3, 'tooLarge'=>'Картинка слишком большая, разрешенно не более 3 MB.', 'minSize'=>512, 'tooSmall'=>'Картинка слишком маленькая, разрешенно не менее 512 Byte.', 'on'=>'insert'),
			array('img', 'file', 'types'=>'png,jpg,jpeg,gif', 'allowEmpty'=>true, 'maxSize'=>1024*1024*3, 'tooLarge'=>'Картинка слишком большая, разрешенно не более 3 MB.', 'minSize'=>512, 'tooSmall'=>'Картинка слишком маленькая, разрешенно не менее 512 Byte.', 'on'=>'update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_image, id_category, id_node, name, ext', 'safe', 'on'=>'search'),
		);
	}

	public function oneid($attribute,$params)
	{
		if (!$this->hasErrors())
		{
			if ($this->id_category > 0 && $this->id_node > 0)
				$this->addError($attribute,'Картинка выбирается или для категории или для страницы.');
		}
	}

	public function reqid($attribute,$params)
	{
		if (!$this->hasErrors())
		{
			if ($this->id_category == 0 && $this->id_node == 0)
				$this->addError($attribute,'Картинка должна быть прикреплена к категории или к странице.');
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
			'id_image' => 'id',
			'id_category' => 'Категория',
			'id_node' => 'Страница',
			'img' => 'Изображение',
			'name' => 'Наименование картинки',
			'ext' => 'Расширение',
			'title' => 'Заголовок (title)',
			'alt' => 'Описание (alt)',
			'sort_order' => 'Порядковый номер',
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

		$criteria->compare('id_image',$this->id_image,true);
		$criteria->compare('id_category',$this->id_category,true);
		$criteria->compare('id_node',$this->id_node,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('ext',$this->ext,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>50,
			),
			'sort'=>array(
				'defaultOrder'=>'id_image desc',
			),
		));
	}

	public function beforeSave()
	{
		$this->udate = date('Y-m-d H:i:s');
		if ($this->isNewRecord)
			$this->adate = date('Y-m-d H:i:s');

		if ($img = CUploadedFile::getInstance($this,'img'))
		{
			$this->deleteImages();
			chmod($this->getImgPath(),0777); // открываем папку для записи
			$this->img = $img;
			$fileName = date('YmdHis').rand(1000,9999);
			$extension = $this->img->getExtensionName();
			$this->img->saveAs($this->getImgPath().$fileName.'.'.$extension);
			$this->name = $fileName;
			$this->ext = $extension;
			// Определяем картинка для категории или для страницы
			if ($this->id_category > 0)
			{
				$m = CategoriesControl::model()->find('id_category=:catid',array(':catid'=>$this->id_category));
				$tmpId = $m->id_image_type;
			}
			else
			{
				$m = Yii::app()->db->createCommand()
				   ->select('')
				   ->from('{{nodes}} n')
				   ->join('{{node_types}} t', 'n.id_node_type = t.id_node_type')
				   ->where('n.id_node=:nid',array(':nid'=>$this->id_node))
				   ->queryRow();
				$tmpId = $m['id_image_type'];
			}
			$options = ImageOptionsControl::model()->findAll('id_image_type=:iit',array(':iit'=>$tmpId));
			if ($options)
			{
				$ih = new CImageHandler();
				$ih->load($this->getImgPath().$fileName.'.'.$extension);
				foreach ($options as $option)
				{
					//Флаг: 0 - thumb, 1 - adaptiveThumb, 2 - resize, 3 - resizeCanvas
					switch ($option->type)
					{
						case '0': // thumb
						{
							$ih->thumb($option->width,$option->height)->save($this->getImgPath().$fileName.'_'.$option->suffix.'.'.$extension,false,self::IMAGES_QUALITY)->reload();
							break;
						}
						case '1': // adaptiveThumb
						{
							$ih->adaptiveThumb($option->width,$option->height)->save($this->getImgPath().$fileName.'_'.$option->suffix.'.'.$extension,false,self::IMAGES_QUALITY)->reload();
							break;
						}
						case '2': // resize
						{
							$ih->resize($option->width,$option->height,false)->save($this->getImgPath().$fileName.'_'.$option->suffix.'.'.$extension,false,self::IMAGES_QUALITY)->reload();
							break;
						}
						case '3': // resizeCanvas
						{
							$colors = explode(',',$option->bgcolor);
							$ih->resizeCanvas($option->width,$option->height,array($colors[0],$colors[1],$colors[2]))->save($this->getImgPath().$fileName.'_'.$option->suffix.'.'.$extension,false,self::IMAGES_QUALITY)->reload();
							break;
						}
					}
				}
				// удаляем исходный фаил
				$imagePath = $this->getImgPath().$fileName.'.'.$extension;
				if (is_file($imagePath))
				{
					chmod($imagePath,0777); // открываем сохраненый файл для записи
					unlink($imagePath);
				}
				// закрываем сохраненые файлы от записи
				foreach ($options as $option)
				{
					$imagePath = $this->getImgPath().$fileName.'_'.$option->suffix.'.'.$extension;
					if (is_file($imagePath))
						chmod($imagePath,0444);
				}
			}
			chmod($this->getImgPath(),0555); // закрываем папку от записи
		}
		return parent::beforeSave();
	}

	protected function beforeDelete()
	{
		$this->deleteImages();
		return parent::beforeDelete();
	}

	public function getImgPath()
	{
		return Yii::getPathOfAlias(self::IMAGES_DIR).DIRECTORY_SEPARATOR;
	}

	public function deleteImages()
	{
		// Определяем картинка для категории или для страницы
		if ($this->id_category > 0)
		{
			$m = CategoriesControl::model()->find('id_category=:catid',array(':catid'=>$this->id_category));
			$tmpId = $m->id_image_type;
		}
		else
		{
			$m = Yii::app()->db->createCommand()
			   ->select('')
			   ->from('{{nodes}} n')
			   ->join('{{node_types}} t', 'n.id_node_type = t.id_node_type')
			   ->where('n.id_node=:nid',array(':nid'=>$this->id_node))
			   ->queryRow();
			$tmpId = $m['id_image_type'];
		}
		$options = ImageOptionsControl::model()->findAll('id_image_type=:iit',array(':iit'=>$tmpId));

		chmod($this->getImgPath(),0777); // открываем папку для записи
		foreach ($options as $option)
		{
			$imagePath = $this->getImgPath().$this->name.'_'.$option->suffix.'.'.$this->ext;
			if (is_file($imagePath))
			{
				chmod($imagePath,0777); // открываем сохраненый файл для записи
				unlink($imagePath);
			}
		}
		chmod($this->getImgPath(),0555); // закрываем папку от записи
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ImagesControl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
