<?php

/*
$this->breadcrumbs=array(
	'Menu Controls'=>array('index'),
	$model->name=>array('view','id'=>$model->id_menu),
	'Update',
);
*/

$this->menu=array(
	array('label'=>'Управление меню', 'url'=>array('index')),
	array('label'=>'Создать меню', 'url'=>array('create')),
	array('label'=>'Просмотр меню', 'url'=>array('view', 'id'=>$model->id_menu)),
);
?>

<h1>Изменить меню: <?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>