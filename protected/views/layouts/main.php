<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<?php if ($this->pageDescription != '') { ?>
<meta name="description" content="<?php echo CHtml::encode($this->pageDescription); ?>" />
<?php } ?>
<?php if ($this->pageKeywords != '') { ?>
<meta name="keywords" content="<?php echo CHtml::encode($this->pageKeywords); ?>" />
<?php } ?>
<?php Yii::app()->getClientScript()->registerCoreScript('jquery'); ?>
</head>
<body>
<div id="wrapper">
	<?php $this->renderPartial('//layouts/_header'); ?>
	<div id="middle">
		<?php echo $content; ?>
	</div><!-- /middle-->
</div><!-- /wrapper -->
<?php $this->renderPartial('//layouts/_footer'); ?>
</body>
</html>