<?php
/*
$this->breadcrumbs=array(
	'Attribute Types Controls'=>array('index'),
	'Manage',
);
*/

$this->menu=array(
	array('label'=>'Создать атрибуту', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#attribute-types-control-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление атрибутами</h1>

<?php echo CHtml::link('Расширеный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'attribute-types-control-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_attribute_type'=>array(
			'name'=>'id_attribute_type',
			'headerHtmlOptions'=>array('width'=>'50'),
			'htmlOptions'=>array('style'=>'text-align:right'),
		),
		'id_node_type'=>array(
			'name'=>'id_node_type',
			'value'=>'$data->nodeType->name',
			'filter'=>NodeTypesControl::getList(),
		),
		'name',
		/*
		'translit',
		'type',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
