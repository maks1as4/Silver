<?php
/*
$this->breadcrumbs=array(
	'Node Types Controls'=>array('index'),
	'Manage',
);
*/

$this->menu=array(
	array('label'=>'Создать тип страницы', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#node-types-control-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление типом страниц</h1>

<?php echo CHtml::link('Расширеный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'node-types-control-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_node_type'=>array(
			'name'=>'id_node_type',
			'headerHtmlOptions'=>array('width'=>'50'),
			'htmlOptions'=>array('style'=>'text-align:right'),
		),
		'name',
		'comments'=>array(
			'name'=>'comments',
			'value'=>'($data->comments == 0) ? "выкл." : "вкл."',
			'filter'=>NodeTypesControl::getCommentStatus(),
			'header'=>'Комментарии',
			'headerHtmlOptions'=>array('width'=>'50'),
		),
		/*
		'translit',
		'description',
		'adate',
		'udate',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}{update}{delete}',
			'buttons'=>array(
				'delete'=>array('visible'=>'NodeTypesControl::isCanDelete($data->id_node_type)'),
			),
		),
	),
)); ?>
