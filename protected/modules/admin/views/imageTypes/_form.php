<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'image-types-control-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля <span class="required">*</span> обязательные для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

<?php if ($model->isNewRecord){ ?>
	<div class="row">
		<?php echo $form->labelEx($model,'translit'); ?>
		<?php echo $form->textField($model,'translit',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'translit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',ImageTypesControl::getImageTypes()); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>
<?php } ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->