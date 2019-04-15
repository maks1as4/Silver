<?php
/*
$this->breadcrumbs=array(
	'Nodes Controls'=>array('index'),
	$model->name,
);
*/

$this->menu=array(
	array('label'=>'Управление страницами', 'url'=>array('index')),
	array('label'=>'Создать страницу', 'url'=>array('create')),
	array('label'=>'Изменить страницу', 'url'=>array('update', 'id'=>$model->id_node)),
	array('label'=>'Удалить страницу', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_node),'confirm'=>'Вы уверены?')),
);
?>

<h1>Просмотр страницы: <?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_node',
		'id_category',
		'id_node_type',
		'view',
		'name',
		'content',
		'description',
		'attr',
		'url',
		'title_seo',
		'desc_seo',
		'key_seo',
		'status',
		'adate',
		'udate',
		'sort_order',
	),
)); ?>
