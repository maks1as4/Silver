<?php

class AttrChangeControl extends CFormModel
{
	public $attr;

	public function rules()
	{
		return array(
			array('attr', 'length', 'max'=>5000, 'on'=>'string, enum, link, image, file'),
			array('attr', 'match', 'pattern'=>'/^([а-яёa-z0-9-_+!?.,;:°*&$%#№@<>|`~\(\){}\[\]\/\s]+)$/ui', 'message'=>'Недопустимые символы.', 'on'=>'string, enum'),
			array('attr', 'match', 'pattern'=>'/^([a-z0-9-_.\/]+)$/u', 'message'=>'Недопустимые символы.', 'on'=>'image, file'),
			array('attr', 'numerical', 'integerOnly'=>true, 'on'=>'integer'),
			array('attr', 'numerical', 'integerOnly'=>false, 'on'=>'decimal'),
			array('attr', 'boolean', 'on'=>'boolean'),
			array('attr', 'url', 'validSchemes'=>array('http','https','ftp'), 'on'=>'link'),
			array('attr', 'date', 'format'=>'yyyy-MM-dd HH:mm:ss', 'on'=>'date'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'attr' => 'Значение',
		);
	}
}