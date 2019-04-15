<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/control/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/control/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/control/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/control/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/control/form.css" />

	<title>Админка</title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo" style="float: left;"><?php echo CHtml::link('Админка',array('/admin')); ?></div>
		<div style="float: left; padding-top: 19px; font-size: 16px;">
			<?php echo CHtml::link('на сайт',array('/site/index')); ?> | 
			<?php echo CHtml::link('выход',array('/users/logout')); ?>
		</div>
		<div style="clear: both;"></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				//array('label'=>'Главная', 'url'=>array('/admin')),
				array('label'=>'Меню', 'url'=>array('/admin/menus')),
				array('label'=>'Категории', 'url'=>array('/admin/categories')),
				array('label'=>'Типы страниц', 'url'=>array('/admin/nodeTypes')),
				array('label'=>'Страницы', 'url'=>array('/admin/nodes')),
				array('label'=>'Атрибуты', 'url'=>array('/admin/attributeTypes')),
				array('label'=>'Тип картинок', 'url'=>array('/admin/imageTypes')),
				array('label'=>'Вид картинок', 'url'=>array('/admin/imageOptions')),
				array('label'=>'Картинки', 'url'=>array('/admin/images')),
				array('label'=>'Пользователи', 'url'=>array('/admin/users')),
				array('label'=>'Новости', 'url'=>array('/admin/news')),
				//array('label'=>'На сайт', 'url'=>array('/site/index')),
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
