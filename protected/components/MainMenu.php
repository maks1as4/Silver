<?php

class MainMenu extends CWidget
{
	public function run()
	{
		$basket_append = '';
		$basket_color = 'black';
		if (Yii::app()->ShoppingCart->getShoppingList())
		{
			$basket_append = '<span class="badge badge-important badge-basket">'.Yii::app()->ShoppingCart->count_in_basket.'</span>';
			$basket_color = 'red';
		}

		$menu = array(
			array(
				'name'=>'index',
				'title'=>'Главная',
				'url'=>array('/site/index'),
				'active'=>false,
				'color'=>'black',
				'id'=>'',
			),
			array(
				'name'=>'catalog',
				'title'=>'Каталог',
				'url'=>array('/site/catalog'),
				'active'=>false,
				'color'=>'black',
				'id'=>'',
			),
			array(
				'name'=>'order',
				'title'=>'Корзина'.$basket_append,
				'url'=>array('/order/index'),
				'active'=>false,
				'color'=>$basket_color,
				'id'=>'menu-basket',
			),
			array(
				'name'=>'contact',
				'title'=>'Контакты',
				'url'=>array('/site/contact'),
				'active'=>false,
				'color'=>'black',
				'id'=>'',
			),
			array(
				'name'=>'news',
				'title'=>'Новости',
				'url'=>array('/news/index'),
				'active'=>false,
				'color'=>'black',
				'id'=>'',
			)
		);

		$cnt = count($menu);

		for ($i=0; $i<$cnt; $i++)
		{
			if ($menu[$i]['name'] == Yii::app()->controller->mainMenuFlag)
				$menu[$i]['active'] = true;
		}

		$this->render('mainMenu',array(
			'menu'=>$menu,
			'cnt'=>$cnt,
		));
	}
}