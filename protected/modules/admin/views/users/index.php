<?php
/*
$this->breadcrumbs=array(
	'Users Controls'=>array('index'),
	'Manage',
);
*/

$this->menu=array(
	array('label'=>'Создать пользователя', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#users-control-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление пользователями</h1>

<?php echo CHtml::link('Расширеный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-control-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id'=>array(
			'name'=>'id',
			'headerHtmlOptions'=>array('width'=>'50'),
			'htmlOptions'=>array('style'=>'text-align:right'),
		),
		'username',
		'role'=>array(
			'name'=>'role',
			'headerHtmlOptions'=>array('width'=>'70'),
			'htmlOptions'=>array('style'=>'text-align:center'),
			'filter'=>UsersControl::getAllRoles(),
		),
		'status'=>array(
			'name'=>'status',
			'value'=>'UsersControl::getStatus($data->status)',
			'htmlOptions'=>array('style'=>'text-align:center'),
			'filter'=>UsersControl::getAllStatus(),
		),
		/*
		'password',
		'avatar',
		'email',
		'status',
		'adate',
		'udate',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
