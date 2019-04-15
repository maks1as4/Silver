<?php
/*
$this->breadcrumbs=array(
	'News Controls'=>array('index'),
	$model->name,
);
*/

$this->menu=array(
	array('label'=>'Управление новостями', 'url'=>array('index')),
	array('label'=>'Создать новость', 'url'=>array('create')),
	array('label'=>'Изменить новость', 'url'=>array('update', 'id'=>$model->id_news)),
	array('label'=>'Удалить новость', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_news),'confirm'=>'Вы уверены?')),
);
?>

<h1>Просмотр новости: <?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_news',
		'url',
		'name',
		'content',
		'description',
		'image',
		'ext',
		'title_seo',
		'desc_seo',
		'key_seo',
		'status',
		'adate',
		'udate',
	),
)); ?>
