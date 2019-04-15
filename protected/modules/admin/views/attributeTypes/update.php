<?php
/*
$this->breadcrumbs=array(
	'Attribute Types Controls'=>array('index'),
	$model->name=>array('view','id'=>$model->id_attribute_type),
	'Update',
);
*/

$this->menu=array(
	array('label'=>'Управление атрибутами', 'url'=>array('index')),
	array('label'=>'Создать атрибуту', 'url'=>array('create')),
	array('label'=>'Просмотр атрибуты', 'url'=>array('view', 'id'=>$model->id_attribute_type)),
);
?>

<h1>Изменить атрибуту: <?php echo $model->name; ?> (<?php echo $model->translit; ?>)</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>