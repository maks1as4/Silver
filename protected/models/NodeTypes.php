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
class NodeTypes extends CActiveRecord
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
			array('translit, name, view', 'required'),
			array('id_image_type, comments', 'numerical', 'integerOnly'=>true),
			array('translit, name', 'length', 'max'=>150),
			array('view', 'length', 'max'=>50),
			array('description', 'length', 'max'=>500),
			array('translit', 'unique'),
			array('pages', 'numerical', 'integerOnly'=>true),
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

	public static function getPagesCntByCategory($cid)
	{
		$res = 0;

		$node = Yii::app()->db->createCommand()
			  ->select('nt.pages')
			  ->from('{{nodes}} n')
			  ->join('{{node_types}} nt', 'nt.id_node_type=n.id_node_type')
			  ->where('n.id_category=:catid', array(':catid'=>$cid))
			  ->limit('1')
			  ->queryAll();
		if (isset($node[0]['pages']))
			$res = $node[0]['pages'];

		return $res;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NodeTypes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
