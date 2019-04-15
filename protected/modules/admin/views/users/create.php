<?php
/*
$this->breadcrumbs=array(
	'Users Controls'=>array('index'),
	'Create',
);
*/

$this->menu=array(
	array('label'=>'Управление пользователями', 'url'=>array('index')),
);
?>

<h1>Создать пользователя</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>