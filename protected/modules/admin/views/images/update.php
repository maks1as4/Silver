<?php
/*
$this->breadcrumbs=array(
	'Images Controls'=>array('index'),
	$model->name=>array('view','id'=>$model->id_image),
	'Update',
);
*/

$this->menu=array(
	array('label'=>'Управление картинками', 'url'=>array('index')),
	array('label'=>'Создать картинку', 'url'=>array('create')),
	array('label'=>'Просмотр картинки', 'url'=>array('view', 'id'=>$model->id_image)),
);
?>

<h1>Изменить картинку: <?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>