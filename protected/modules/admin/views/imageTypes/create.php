<?php
/*
$this->breadcrumbs=array(
	'Image Types Controls'=>array('index'),
	'Create',
);
*/

$this->menu=array(
	array('label'=>'Управление типом картинок', 'url'=>array('index')),
);
?>

<h1>Создать тип картинок</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>