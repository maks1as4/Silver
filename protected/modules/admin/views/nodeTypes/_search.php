<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_node_type'); ?>
		<?php echo $form->textField($model,'id_node_type',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'translit'); ?>
		<?php echo $form->textField($model,'translit',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comments'); ?>
		<?php echo $form->dropDownList($model,'comments',NodeTypesControl::getCommentStatus(),array('empty'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'adate'); ?>
		<?php echo $form->textField($model,'adate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'udate'); ?>
		<?php echo $form->textField($model,'udate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Поиск'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->