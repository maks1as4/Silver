<?php
/*
$this->breadcrumbs=array(
	'Images Controls'=>array('index'),
	$model->name,
);
*/

$this->menu=array(
	array('label'=>'Управление картинками', 'url'=>array('index')),
	array('label'=>'Создать картинку', 'url'=>array('create')),
	array('label'=>'Изменить картинку', 'url'=>array('update', 'id'=>$model->id_image)),
	array('label'=>'Удалить картинку', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_image),'confirm'=>'Вы уверены?')),
);
?>

<h1>Просмотр картинки: <?php echo $model->name; ?></h1>

<div style="margin-top:110px;">
	<div style="margin-bottom:10px;"><?php echo CHtml::image('/storage/images/'.$model->name.'_original.'.$model->ext,null); ?></div>
	<div style="margin-bottom:10px;"><?php echo CHtml::image('/storage/images/'.$model->name.'_default.'.$model->ext,null); ?></div>
	<div style="margin-bottom:10px;"><?php echo CHtml::image('/storage/images/'.$model->name.'_thumb.'.$model->ext,null); ?></div>
</div>
