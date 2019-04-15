<?php

/*
$this->breadcrumbs=array(
	'Categories Controls'=>array('index'),
	'Create',
);
*/

$this->menu=array(
	array('label'=>'Управление категориями', 'url'=>array('index')),
);
?>

<h1>Создать категорию</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>