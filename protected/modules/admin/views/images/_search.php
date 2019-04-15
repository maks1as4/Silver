<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_image'); ?>
		<?php echo $form->textField($model,'id_image',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_category'); ?>
		<?php echo $form->dropDownList($model,'id_category',CategoriesControl::getListWithImages(),array('empty'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_node'); ?>
		<?php echo $form->dropDownList($model,'id_node',NodesControl::getListWithImages(),array('empty'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Поиск'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->