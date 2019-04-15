<?php
/*
$this->breadcrumbs=array(
	'Image Types Controls'=>array('index'),
	$model->name=>array('view','id'=>$model->id_image_type),
	'Update',
);
*/

$this->menu=array(
	array('label'=>'Управление типом картинок', 'url'=>array('index')),
	array('label'=>'Создать тип картинок', 'url'=>array('create')),
	array('label'=>'Удалить тип картинок', 'url'=>'#', 'visible'=>ImageTypesControl::isCanDelete($model->id_image_type,$model->type), 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_image_type),'confirm'=>'Вы уверены?')),
);
?>

<h1>Изменить тип картинки: <?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>