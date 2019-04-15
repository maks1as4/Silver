<?php

/*
$this->breadcrumbs=array(
	'Menu Controls'=>array('index'),
	'Create',
);
*/

$this->menu=array(
	array('label'=>'Управление меню', 'url'=>array('index')),
);
?>

<h1>Создать меню</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>