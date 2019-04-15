<?php
/*
$this->breadcrumbs=array(
	'Attribute Types Controls'=>array('index'),
	'Create',
);
*/

$this->menu=array(
	array('label'=>'Управление атрибутами', 'url'=>array('index')),
);
?>

<h1>Создать атрибуту</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>