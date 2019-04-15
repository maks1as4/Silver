<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_node'); ?>
		<?php echo $form->textField($model,'id_node',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_category'); ?>
		<?php echo $form->dropDownList($model,'id_category',CategoriesControl::getList(true),array('empty'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_node_type'); ?>
		<?php echo $form->dropDownList($model,'id_node_type',NodeTypesControl::getList(),array('empty'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>300)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',NodesControl::getStatus(),array('empty'=>'')); ?>
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