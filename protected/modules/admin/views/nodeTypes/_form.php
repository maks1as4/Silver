<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'node-types-control-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля <span class="required">*</span> обязательные для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

<?php if ($model->isNewRecord){ ?>
	<div class="row">
		<?php echo $form->labelEx($model,'translit'); ?>
		<?php echo $form->textField($model,'translit',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'translit'); ?>
	</div>
<?php } ?>

	<div class="row">
		<?php echo $form->labelEx($model,'view'); ?>
		<?php echo $form->dropDownList($model,'view',NodeTypesControl::getViewsList()); ?>
		<?php echo $form->error($model,'view'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_image_type'); ?>
		<?php echo $form->dropDownList($model,'id_image_type',ImageTypesControl::getSplitedList(1)); ?>
		<?php echo $form->error($model,'id_image_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comments'); ?>
		<?php echo $form->dropDownList($model,'comments',NodeTypesControl::getCommentStatus()); ?>
		<?php echo $form->error($model,'comments'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pages'); ?>
		<?php echo $form->textField($model,'pages',array('size'=>5)); ?>
		<?php echo $form->error($model,'pages'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->