<?php

class SideMenu extends CWidget
{
	public function run()
	{
		// Рубрика "Монеты" [ID:1847] и подрубрики
		$criteria = new CDbCriteria;
		$criteria->select = 't.id_category, t.name, t.url, t.flag, cl.name as name_lang';
		$criteria->join = 'left join {{categories_lang}} cl on cl.id_category=t.id_category and cl.lang="'.Yii::app()->getLanguage().'"';
		$criteria->condition = '(t.id_category=1847 or t.id_parent=1847) and t.`status`=0';
		$criteria->order = 't.id_parent, t.name';
		$modelsCoin = Categories::model()->findAll($criteria);
		if ($modelsCoin[0]['id_category'] != '1847')
			$modelsCoin = null;

		// Рубрика "Банкноты" [ID:1848] и подрубрики
		$criteria = new CDbCriteria;
		$criteria->select = 't.id_category, t.name, t.url, t.flag, cl.name as name_lang';
		$criteria->join = 'left join {{categories_lang}} cl on cl.id_category=t.id_category and cl.lang="'.Yii::app()->getLanguage().'"';
		$criteria->condition = '(t.id_category=1848 or t.id_parent=1848) and t.`status`=0';
		$criteria->order = 't.id_parent, t.name';
		$modelsBill = Categories::model()->findAll($criteria);
		if ($modelsBill[0]['id_category'] != '1848')
			$modelsBill = null;

		// Рубрики без меню
		$criteria = new CDbCriteria;
		$criteria->select = 't.id_category, t.name, t.url, cl.name as name_lang';
		$criteria->join = 'left join {{categories_lang}} cl on cl.id_category=t.id_category and cl.lang="'.Yii::app()->getLanguage().'"';
		$criteria->condition = 't.id_root=0 and t.id_menu=0 and t.`status`=0';
		$criteria->order = 't.sort_order, t.id_category';
		$modelsOther = Categories::model()->findAll($criteria);

		$this->render('sideMenu',array(
			'modelsCoin'=>$modelsCoin,
			'modelsBill'=>$modelsBill,
			'modelsOther'=>$modelsOther,
		));
	}
}