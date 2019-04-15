<?php
/*
$this->breadcrumbs=array(
	'News Controls'=>array('index'),
	$model->name=>array('view','id'=>$model->id_news),
	'Update',
);
*/

$this->menu=array(
	array('label'=>'Управление новостями', 'url'=>array('index')),
	array('label'=>'Создать новость', 'url'=>array('create')),
	array('label'=>'Просмотр новости', 'url'=>array('view', 'id'=>$model->id_news)),
);
?>

<h1>Изменить новость: <?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>