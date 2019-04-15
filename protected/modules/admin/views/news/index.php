<?php
/*
$this->breadcrumbs=array(
	'News Controls'=>array('index'),
	'Manage',
);
*/

$this->menu=array(
	array('label'=>'Создать новость', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#news-control-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление новостями</h1>

<?php echo CHtml::link('Расширеный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'news-control-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_news'=>array(
			'name'=>'id_news',
			'headerHtmlOptions'=>array('width'=>'50'),
			'htmlOptions'=>array('style'=>'text-align:right'),
		),
		'name',
		'status'=>array(
			'name'=>'status',
			'value'=>'($data->status == 0) ? "показ" : "скрыта"',
			'filter'=>NewsControl::getStatus(),
		),
		'adate',
		'udate',
		/*
		'url',
		'content',
		'description',
		'title_seo',
		'desc_seo',
		'key_seo',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
