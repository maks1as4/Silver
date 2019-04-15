<?php if(Yii::app()->user->hasFlash('deleteImage')){ ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('deleteImage'); ?>
</div>
<?php } ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'news-control-form',
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля <span class="required">*</span> обязательные для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
<?php
if ($model->image != '')
{
	echo CHtml::image('/storage/images/news/'.$model->image.'_small.'.$model->ext,null,array('style'=>'margin:5px 0;')).'<br />';
	echo CHtml::link('[ удалить картинку ]',array('deleteImage','id'=>$model->id_news),array('confirm'=>'Вы уверены?')).'<br /><br />';
}
?>
		<?php echo $form->fileField($model,'img'); ?>
		<?php echo $form->error($model,'img'); ?>
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
		<?php echo $form->dropDownList($model,'status',NewsControl::getStatus()); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->