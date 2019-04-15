<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'images-control-form',
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля <span class="required">*</span> обязательные для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_category'); ?>
		<?php echo $form->dropDownList($model,'id_category',CategoriesControl::getListWithImages(),array('empty'=>'')); ?>
		<?php echo $form->error($model,'id_category'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_node'); ?>
		<?php echo $form->dropDownList($model,'id_node',NodesControl::getListWithImages(),array('empty'=>'')); ?>
		<?php echo $form->error($model,'id_node'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'img'); ?>
<?php
if (!$model->isNewRecord && $model->name != '')
{
	$img = CHtml::image('/storage/images/'.$model->name.'_default.'.$model->ext,null);
?>
		<div style="margin:5px 0;"><?php echo CHtml::link($img,array('view','id'=>$model->id_image)); ?></div>
<?php } ?>
		<?php echo $form->fileField($model,'img'); ?>
		<?php echo $form->error($model,'img'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alt'); ?>
		<?php echo $form->textField($model,'alt',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'alt'); ?>
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