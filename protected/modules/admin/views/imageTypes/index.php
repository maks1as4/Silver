<?php
/*
$this->breadcrumbs=array(
	'Image Types Controls'=>array('index'),
	'Manage',
);
*/

$this->menu=array(
	array('label'=>'Создать тип картинок', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#image-types-control-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление типом картинок</h1>

<?php echo CHtml::link('Расширеный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'image-types-control-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_image_type'=>array(
			'name'=>'id_image_type',
			'headerHtmlOptions'=>array('width'=>'50'),
			'htmlOptions'=>array('style'=>'text-align:right'),
		),
		'name',
		'type'=>array(
			'name'=>'type',
			'value'=>'($data->type == 0) ? "category" : "node"',
			'filter'=>ImageTypesControl::getImageTypes(),
		),
		/*
		'translit',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
			'buttons'=>array(
				'delete'=>array('visible'=>'ImageTypesControl::isCanDelete($data->id_image_type,$data->type)'),
			),
		),
	),
)); ?>
