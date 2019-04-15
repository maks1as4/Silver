<?php
/*
$this->breadcrumbs=array(
	'Attribute Types Controls'=>array('index'),
	$model->name,
);
*/

$this->menu=array(
	array('label'=>'Управление атрибутами', 'url'=>array('index')),
	array('label'=>'Создать атрибуту', 'url'=>array('create')),
	array('label'=>'Изменить атрибуту', 'url'=>array('update', 'id'=>$model->id_attribute_type)),
	array('label'=>'Удалить атрибуту', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_attribute_type),'confirm'=>'Вы уверены?')),
);
?>

<h1>Просмотр атрибуты: <?php echo $model->name; ?> (<?php echo $model->translit; ?>)</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_attribute_type',
		'id_node_type',
		'translit',
		'name',
		'type',
	),
)); ?>
