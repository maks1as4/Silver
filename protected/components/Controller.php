<?php

class Controller extends CController
{
	public $layout = '//layouts/default'; 	// layout
	public $menu = array(); 				// side menu
	public $breadcrumbs = array(); 			// breadcrumb
	public $mainMenuFlag = '';

	// Meta SEO
	public $pageDescription = '';
	public $pageKeywords = '';

	// Windows
	public $pageWindows = '';

	protected function beforeAction($action)
	{
		$cs = Yii::app()->clientScript;
		// Подключаем внешние файлы скриптов
		$cs->registerCssFile('/css/reset.css');
		$cs->registerCssFile('/css/bootstrap.limit.css', 'screen');
		$cs->registerCssFile('/css/style.css', 'screen');
		$cs->registerCssFile('/css/flags.css', 'screen');
		$cs->registerScriptFile('/js/menu.js', CClientScript::POS_END);

		return parent::beforeAction($action);
	}
}