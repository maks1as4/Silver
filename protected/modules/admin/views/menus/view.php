<?php
/*
$this->breadcrumbs=array(
	'Menu Controls'=>array('index'),
	$model->name,
);
*/

$this->menu=array(
	array('label'=>'Управление меню', 'url'=>array('index')),
	array('label'=>'Создать меню', 'url'=>array('create')),
	array('label'=>'Изменить меню', 'url'=>array('update', 'id'=>$model->id_menu)),
	array('label'=>'Удалить меню', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_menu),'confirm'=>'Вы уверенны?')),
);
?>

<h1>Просмотр меню: <?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_menu',
		'name',
		'description',
		'icon',
	),
)); ?>
