<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'image-option-control-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля <span class="required">*</span> обязательные для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_image_type'); ?>
		<?php echo $form->dropDownList($model,'id_image_type',ImageTypesControl::getList()); ?>
		<?php echo $form->error($model,'id_image_type'); ?>
	</div>

<?php if ($model->isNewRecord){ ?>
	<div class="row">
		<?php echo $form->labelEx($model,'suffix'); ?>
		<?php echo $form->textField($model,'suffix',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'suffix'); ?>
	</div>
<?php } ?>

	<div class="row">
		<?php echo $form->labelEx($model,'width'); ?>
		<?php echo $form->textField($model,'width'); ?>
		<?php echo $form->error($model,'width'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'height'); ?>
		<?php echo $form->textField($model,'height'); ?>
		<?php echo $form->error($model,'height'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bgcolor'); ?>
		<?php echo $form->textField($model,'bgcolor',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'bgcolor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',ImageOptionsControl::getResizeTypes()); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->