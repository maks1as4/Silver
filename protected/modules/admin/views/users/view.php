<?php
/*
$this->breadcrumbs=array(
	'Users Controls'=>array('index'),
	$model->id,
);
*/

$this->menu=array(
	array('label'=>'Просомтр пользователей', 'url'=>array('index')),
	array('label'=>'Создать пользователя', 'url'=>array('create')),
	array('label'=>'Изменить пользователя', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить пользователя', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверенны?')),
);
?>

<h1>Просмотр пользователя: <?php echo $model->username; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'password',
		'email',
		'avatar',
		'role',
		'status',
		'adate',
		'udate',
	),
)); ?>
