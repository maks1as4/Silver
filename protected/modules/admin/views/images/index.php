<?php
/*
$this->breadcrumbs=array(
	'Images Controls'=>array('index'),
	'Manage',
);
*/

$this->menu=array(
	array('label'=>'Создать картинку', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#images-control-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление картинками</h1>

<?php echo CHtml::link('Расширеный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'images-control-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'header'=>'Превью',
			'value'=>'(is_file(Yii::getPathOfAlias(ImagesControl::IMAGES_DIR).DIRECTORY_SEPARATOR.$data->name."_thumb.".$data->ext)) ? CHtml::image(Yii::app()->getBaseUrl(true)."/storage/images/".$data->name."_thumb.".$data->ext,$data->alt) : ""',
			'headerHtmlOptions'=>array('width'=>'80'),
			'htmlOptions'=>array('style'=>'text-align:center'),
			'type'=>'raw',
		),
		'id_category'=>array(
			'name'=>'id_category',
			'value'=>'($data->id_category > 0) ? CategoriesControl::getCategoryName($data->id_category) : "--нет--"',
			'filter'=>CategoriesControl::getListWithImages(),
		),
		'id_node'=>array(
			'name'=>'id_node',
			'value'=>'($data->id_node > 0) ? NodesControl::getNodeName($data->id_node) : "--нет--"',
			'filter'=>NodesControl::getListWithImages(),
		),
		'sort_order'=>array(
			'name'=>'sort_order',
			'headerHtmlOptions'=>array('width'=>'50'),
		),
		/*
		'id_image',
		'name',
		'ext',
		'title',
		'alt',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
