<?php

/*
$this->breadcrumbs=array(
	'Categories Controls'=>array('index'),
	$model->name=>array('view','id'=>$model->id_category),
	'Update',
);
*/

$this->menu=array(
	array('label'=>'Управление категориями', 'url'=>array('index')),
	array('label'=>'Создать категорию', 'url'=>array('create')),
	array('label'=>'Просмотр категории', 'url'=>array('view', 'id'=>$model->id_category)),
);
?>

<h1>Изменить категорию: <?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>