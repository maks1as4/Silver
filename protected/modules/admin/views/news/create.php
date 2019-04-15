<?php
/*
$this->breadcrumbs=array(
	'News Controls'=>array('index'),
	'Create',
);
*/

$this->menu=array(
	array('label'=>'Управление новостями', 'url'=>array('index')),
);
?>

<h1>Создать новость</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>