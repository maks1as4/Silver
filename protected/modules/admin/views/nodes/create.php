<?php
/*
$this->breadcrumbs=array(
	'Nodes Controls'=>array('index'),
	'Create',
);
*/

$this->menu=array(
	array('label'=>'Управление страницами', 'url'=>array('index')),
);
?>

<h1>Создать страницу</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>