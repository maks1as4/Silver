<?php
/*
$this->breadcrumbs=array(
	'Nodes Controls'=>array('index'),
	$model->name=>array('view','id'=>$model->id_node),
	'Update',
);
*/

$this->menu=array(
	array('label'=>'Управление страницами', 'url'=>array('index')),
	array('label'=>'Создать страницу', 'url'=>array('create')),
	array('label'=>'Просмотр страницы', 'url'=>array('view', 'id'=>$model->id_node)),
);
?>

<h1>Изменить страницу: <?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'modelAttr'=>$modelAttr)); ?>