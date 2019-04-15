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
class NewsControl extends CActiveRecord
{
	const IMAGES_DIR = 'webroot.storage.images.news';
	const IMAGES_QUALITY = 95;
	public $img;

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
			array('img', 'file', 'types'=>'png,jpg,jpeg,gif', 'allowEmpty'=>true, 'maxSize'=>1024*1024*2, 'tooLarge'=>'Картинка слишком большая, разрешенно не более 2 MB.', 'minSize'=>512, 'tooSmall'=>'Картинка слишком маленькая, разрешенно не менее 512 Byte.'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_news, url, name, content, description, title_seo, desc_seo, key_seo, status, adate, udate', 'safe', 'on'=>'search'),
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

		$criteria->compare('id_news',$this->id_news,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('title_seo',$this->title_seo,true);
		$criteria->compare('desc_seo',$this->desc_seo,true);
		$criteria->compare('key_seo',$this->key_seo,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('adate',$this->adate,true);
		$criteria->compare('udate',$this->udate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>100,
			),
			'sort'=>array(
				'defaultOrder'=>'adate desc',
			),
		));
	}

	public function beforeSave()
	{
		if ($img = CUploadedFile::getInstance($this,'img'))
		{
			$this->deleteImages();
			chmod($this->getImgPath(),0777); // открываем папку для записи
			$this->img = $img;
			$fileName = date('YmdHis').rand(1000,9999);
			$extension = $this->img->getExtensionName();
			$this->img->saveAs($this->getImgPath().$fileName.'.'.$extension);
			$this->image = $fileName;
			$this->ext = $extension;
			// Сохраняем картинки
			$ih = new CImageHandler();
			$ih->load($this->getImgPath().$fileName.'.'.$extension)->adaptiveThumb(70,70)->save($this->getImgPath().$fileName.'_thumb.'.$extension,false,self::IMAGES_QUALITY)->reload();
			$ih->adaptiveThumb(200,150)->save($this->getImgPath().$fileName.'_small.'.$extension,false,self::IMAGES_QUALITY)->reload();
			$ih->adaptiveThumb(300,250)->save($this->getImgPath().$fileName.'_big.'.$extension,false,self::IMAGES_QUALITY)->reload();
			$ih->thumb(1000,800)->save($this->getImgPath().$fileName.'_big.'.$extension,false,self::IMAGES_QUALITY);
			// Удаляем исходный фаил
			$imagePath = $this->getImgPath().$fileName.'.'.$extension;
			if (is_file($imagePath))
			{
				chmod($imagePath,0777); // открываем сохраненый файл для записи
				unlink($imagePath);
			}
			// Закрываем сохраненые файлы от записи
			$types = self::getImageTypes();
			foreach ($types as $type)
			{
				$imagePath = $this->getImgPath().$fileName.'_'.$type.'.'.$extension;
				if (is_file($imagePath))
					chmod($imagePath,0444);
			}
			chmod($this->getImgPath(),0555); // закрываем папку от записи
		}
		$this->name = Functions::upperFirst($this->name);
		$this->udate = date('Y-m-d H:i:s');
		if (strlen($this->content) == 0)
			$this->content = '';
		if ($this->isNewRecord)
		{
			$this->url = Functions::translit($this->name,70);
			$this->adate = date('Y-m-d H:i:s');
		}
		return parent::beforeSave();
	}

	protected function beforeDelete()
	{
		$this->deleteImages();
		return parent::beforeDelete();
	}

	public function deleteImages()
	{
		$types = self::getImageTypes();
		chmod($this->getImgPath(),0777); // открываем папку для записи
		foreach ($types as $type)
		{
			$imgPath = $this->getImgPath().$this->image.'_'.$type.'.'.$this->ext;
			if (is_file($imgPath))
			{
				chmod($imgPath,0777); // открываем сохраненый файл для записи
				unlink($imgPath);
			}
		}
		chmod($this->getImgPath(),0555); // закрываем папку от записи
    }

	public function getImgPath()
	{
		return Yii::getPathOfAlias(self::IMAGES_DIR).DIRECTORY_SEPARATOR;
	}

	public static function getStatus()
	{
		return array('0'=>'показ','1'=>'скрыть');
	}

	public static function getImageTypes()
	{
		return array('thumb', 'small', 'big', 'original');
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NewsControl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
