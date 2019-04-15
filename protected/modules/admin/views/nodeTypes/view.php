<?php
/*
$this->breadcrumbs=array(
	'Node Types Controls'=>array('index'),
	$model->name,
);
*/

$this->menu=array(
	array('label'=>'Управление типом страниц', 'url'=>array('index')),
	array('label'=>'Создать тип страницы', 'url'=>array('create')),
	array('label'=>'Изменить тип страницы', 'url'=>array('update', 'id'=>$model->id_node_type)),
	array('label'=>'Удалить тип страницы', 'url'=>'#', 'visible'=>NodeTypesControl::isCanDelete($model->id_node_type), 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_node_type),'confirm'=>'Вы уверены?')),
);
?>

<h1>Просмотр типа страницы: <?php echo $model->name; ?> (<?php echo $model->translit; ?>)</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_node_type',
		'translit',
		'name',
		'description',
		'comments',
		'adate',
		'udate',
	),
)); ?>
