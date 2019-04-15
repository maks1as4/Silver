<?php
/*
$this->breadcrumbs=array(
	'Image Option Controls'=>array('index'),
	'Create',
);
*/

$this->menu=array(
	array('label'=>'Управление видом картинок', 'url'=>array('index')),
);
?>

<h1>Создать вид картинки</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>