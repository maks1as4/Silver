<?php
/*
$this->breadcrumbs=array(
	'Nodes Controls'=>array('index'),
	'Manage',
);
*/

$this->menu=array(
	array('label'=>'Создать страницу', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#nodes-control-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление страницами</h1>

<?php echo CHtml::link('Расширеный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'nodes-control-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_node'=>array(
			'name'=>'id_node',
			'headerHtmlOptions'=>array('width'=>'50'),
			'htmlOptions'=>array('style'=>'text-align:right'),
		),
		'id_node_type'=>array(
			'name'=>'id_node_type',
			'value'=>'$data->nodeType->name',
			'filter'=>NodeTypesControl::getList(),
		),
		'id_category'=>array(
			'name'=>'id_category',
			'value'=>'($data->id_category > 0) ? $data->category->name : "--нет--"',
			'filter'=>CategoriesControl::getList(true),
		),
		'name'=>array(
			'name'=>'name',
			'headerHtmlOptions'=>array('width'=>'300'),
		),
		'status'=>array(
			'name'=>'status',
			'value'=>'($data->status == 0) ? "показ" : "скрыта"',
			'filter'=>NodesControl::getStatus(),
		),
		'sort_order'=>array(
			'name'=>'sort_order',
			'headerHtmlOptions'=>array('width'=>'50'),
		),
		/*
		'view',
		'content',
		'description',
		'attr',
		'url',
		'price',
		'existence',
		'title_seo',
		'desc_seo',
		'key_seo',
		'adate',
		'udate',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
