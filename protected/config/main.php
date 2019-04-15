<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Silver96',
	'timeZone'=>'Asia/Yekaterinburg',
	'sourceLanguage'=>'en',
	'language'=>'ru',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.components.ImageHandler.CImageHandler',
	),

	'modules'=>array(
		'admin',
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'cl7Gh3Jh',
			'ipFilters'=>array('5.189.62.206'),
		),
		*/
	),

	// application components
	'components'=>array(

		'ShoppingCart'=>array(
			'class'=>'application.components.ShoppingCart.CShoppingCart',
		),

		'authManager'=>array(
			'class'=>'PhpAuthManager',
			'defaultRoles'=>array('guest'),
		),

		'user'=>array(
			'class'=>'WebUser',
			'loginUrl'=>array('users/login'),
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>require(dirname(__FILE__).'/url.php'),
		),

		'db'=>require(dirname(__FILE__).'/database.php'),

		/*
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		*/

		// scripts
		'clientScript'=>array(
			'scriptMap'=>array(
				'jquery.js'=>'http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.js',
				'jquery.min.js'=>'http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js'
			)
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);
