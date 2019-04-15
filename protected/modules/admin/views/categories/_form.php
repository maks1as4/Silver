<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'categories-control-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля <span class="required">*</span> обязательные для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_parent'); ?>
		<?php echo $form->dropDownList($model,'id_parent',CategoriesControl::getList(),array('empty'=>'--root--')); ?>
		<?php echo $form->error($model,'id_parent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_menu'); ?>
		<?php echo $form->dropDownList($model,'id_menu',MenusControl::getList(),array('empty'=>'--нет--')); ?>
		<?php echo $form->error($model,'id_menu'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_image_type'); ?>
		<?php echo $form->dropDownList($model,'id_image_type',ImageTypesControl::getSplitedList(0)); ?>
		<?php echo $form->error($model,'id_image_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'view'); ?>
		<?php echo $form->dropDownList($model,'view',CategoriesControl::getViewsList()); ?>
		<?php echo $form->error($model,'view'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_special_query'); ?>
		<?php echo $form->dropDownList($model,'is_special_query',array('0'=>'Нет','1'=>'Да')); ?>
		<?php echo $form->error($model,'is_special_query'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'flag'); ?>
		<?php echo $form->textField($model,'flag',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'flag'); ?>
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
		<?php echo $form->dropDownList($model,'status',CategoriesControl::getStatus()); ?>
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