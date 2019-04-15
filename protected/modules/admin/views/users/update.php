<?php
/*
$this->breadcrumbs=array(
	'Users Controls'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);
*/

$this->menu=array(
	array('label'=>'Управление пользователями', 'url'=>array('index')),
	array('label'=>'Создать пользователя', 'url'=>array('create')),
	array('label'=>'Просмотр пользователя', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Изменить пользователя: <?php echo $model->username; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>