<?php
/*
$this->breadcrumbs=array(
	'Image Option Controls'=>array('index'),
	$model->id_image_option=>array('view','id'=>$model->id_image_option),
	'Update',
);
*/

$this->menu=array(
	array('label'=>'Управление видом картинок', 'url'=>array('index')),
	array('label'=>'Создать вид картинки', 'url'=>array('create')),
	array('label'=>'Удалить вид картинки', 'url'=>'#', 'visible'=>($model->suffix!='thumb' && $model->suffix!='default' && $model->suffix!='original'), 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_image_option),'confirm'=>'Вы уверены?')),
);
?>

<h1>Изменить вид картинки: <?php echo $model->suffix; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>