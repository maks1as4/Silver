<?php
/*
$this->breadcrumbs=array(
	'Image Option Controls'=>array('index'),
	'Manage',
);
*/

$this->menu=array(
	array('label'=>'Создать вид картинки', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#image-option-control-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление видом картинок</h1>

<?php echo CHtml::link('Расширеный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'image-option-control-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_image_option'=>array(
			'name'=>'id_image_option',
			'headerHtmlOptions'=>array('width'=>'50'),
			'htmlOptions'=>array('style'=>'text-align:right'),
		),
		'id_image_type'=>array(
			'name'=>'id_image_type',
			'value'=>'$data->imageType->name',
			'filter'=>ImageTypesControl::getList(),
		),
		'suffix',
		/*
		'type',
		'width',
		'height',
		'bgcolor',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
			'buttons'=>array(
				'delete'=>array('visible'=>'($data->suffix!="thumb" && $data->suffix!="default" && $data->suffix!="original")'),
			),
		),
	),
)); ?>
