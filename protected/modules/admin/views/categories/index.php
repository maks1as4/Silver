<?php

/*
$this->breadcrumbs=array(
	'Categories Controls'=>array('index'),
	'Manage',
);
*/

$this->menu=array(
	array('label'=>'Создать категорию', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#categories-control-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление категориями</h1>

<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'categories-control-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_category'=>array(
			'name'=>'id_category',
			'headerHtmlOptions'=>array('width'=>'50'),
			'htmlOptions'=>array('style'=>'text-align:right'),
		),
		'id_root'=>array(
			'name'=>'id_root',
			'header'=>'Рубрика',
			'value'=>'CategoriesControl::getRootName($data->id_root)',
		),
		'name'=>array(
			'name'=>'name',
			'headerHtmlOptions'=>array('width'=>'250'),
		),
		'is_catalog'=>array(
			'name'=>'is_catalog',
			'value'=>'($data->is_catalog == 0) ? "нет" : "да"',
			'filter'=>CategoriesControl::getIsCatalog(),
		),
		'status'=>array(
			'name'=>'status',
			'value'=>'($data->status == 0) ? "показ" : "скрыта"',
			'filter'=>CategoriesControl::getStatus(),
		),
		'sort_order'=>array(
			'name'=>'sort_order',
			'headerHtmlOptions'=>array('width'=>'50'),
		),
		/*
		'view',
		'content',
		'description',
		'url',
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
