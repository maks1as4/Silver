<?php

return array(
	// site
	''=>array('site/index'),
	'contacts'=>array('site/contact'),
	// basket
	'basket'=>array('order/index'),
	// news
	'news'=>array('news/index'),
	'news/<id:\d+>-<url:[a-z0-9-]+>'=>array('news/view'),
	// categories
	'catalog'=>array('site/catalog'),
	'category/<id:\d+>-<url:[a-z0-9-]+>'=>array('categories/view'),
	// nodes
	'product/<id:\d+>-<url:[a-z0-9-]+>'=>array('nodes/view'),
	// default
	'<controller:\w+>/<id:\d+>'=>'<controller>/view',
	'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
	'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
);
