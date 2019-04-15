<?php
/*
$this->breadcrumbs=array(
	'Images Controls'=>array('index'),
	'Create',
);
*/

$this->menu=array(
	array('label'=>'Управление картинками', 'url'=>array('index')),
);
?>

<h1>Создать картинку</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>