<?php

/*
$this->breadcrumbs=array(
	'Categories Controls'=>array('index'),
	$model->name,
);
*/

$this->menu=array(
	array('label'=>'Управление категориями', 'url'=>array('index')),
	array('label'=>'Создать категорию', 'url'=>array('create')),
	array('label'=>'Изменить категорию', 'url'=>array('update', 'id'=>$model->id_category)),
	array('label'=>'Удалить категорию', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_category),'confirm'=>'Вы уверенны?')),
);
?>

<h1>Просмотр категории: <?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_category',
		'id_parent',
		'view',
		'name',
		'content',
		'description',
		'url',
		'title_seo',
		'desc_seo',
		'key_seo',
		'is_catalog',
		'status',
		'adate',
		'udate',
		'sort_order',
	),
)); ?>
