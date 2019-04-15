<?php
/*
$this->breadcrumbs=array(
	'Node Types Controls'=>array('index'),
	'Create',
);
*/

$this->menu=array(
	array('label'=>'Управление типом страниц', 'url'=>array('index')),
);
?>

<h1>Создать тип страницы</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>