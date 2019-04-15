<?php
/*
$this->breadcrumbs=array(
	'Node Types Controls'=>array('index'),
	$model->name=>array('view','id'=>$model->id_node_type),
	'Update',
);
*/

$this->menu=array(
	array('label'=>'Управление типом страниц', 'url'=>array('index')),
	array('label'=>'Создать тип страницы', 'url'=>array('create')),
	array('label'=>'Просмотр типа страницы', 'url'=>array('view', 'id'=>$model->id_node_type)),
);
?>

<h1>Изменить тип страницы: <?php echo $model->name; ?> (<?php echo $model->translit; ?>)</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>