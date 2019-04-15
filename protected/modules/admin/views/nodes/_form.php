<?php
if (!$model->isNewRecord)
	$attributes = json_decode($model->attr,true,JSON_UNESCAPED_UNICODE);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nodes-control-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля <span class="required">*</span> обязательные для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_category'); ?>
		<?php echo $form->dropDownList($model,'id_category',CategoriesControl::getList(),array('empty'=>'--нет--')); ?>
		<?php echo $form->error($model,'id_category'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_node_type'); ?>
		<?php echo $form->dropDownList($model,'id_node_type',NodeTypesControl::getList()); ?>
		<?php echo $form->error($model,'id_node_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php $this->widget('application.extensions.ckeditor.ECKEditor', array(
			'model'=>$model,
			'attribute'=>'content',
			'language'=>'ru',
			'editorTemplate'=>'control',
			'width'=>'835px',
			'height'=>'500px',
		)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

<?php if (!$model->isNewRecord && $modelAttr){ ?>
	<div class="row">
		<b>Изменить атрибуты</b>
		<ul style="margin-top:10px;">
<?php
foreach($modelAttr as $attr)
{
	$prefix = (isset($attributes[$attr->translit]) && !empty($attributes[$attr->translit][0])) ? '[+]' : '[-]';
?>
			<li><?php echo CHtml::link($prefix.' '.$attr->name.' ('.$attr->translit.')',array('attrChange','id'=>$model->id_node,'translit'=>$attr->translit)); ?></li>
<?php } ?>
		</ul>
	</div>
<?php } ?>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>60,'maxlength'=>13)); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'existence'); ?>
		<?php echo $form->textField($model,'existence',array('size'=>60,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'existence'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title_seo'); ?>
		<?php echo $form->textField($model,'title_seo',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'title_seo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'desc_seo'); ?>
		<?php echo $form->textField($model,'desc_seo',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'desc_seo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'key_seo'); ?>
		<?php echo $form->textField($model,'key_seo',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'key_seo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',NodesControl::getStatus()); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sort_order'); ?>
		<?php echo $form->textField($model,'sort_order',array('size'=>3)); ?>
		<?php echo $form->error($model,'sort_order'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->