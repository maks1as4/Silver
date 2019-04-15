<?php
$this->pageTitle = 'Контакты';
$this->breadcrumbs = array(
	'Контакты',
);
?>

<h1>Контакты</h1>

<?php if (Yii::app()->user->hasFlash('contacted')) { ?>
<div class="alert alert-success">
	<?php echo Yii::app()->user->getFlash('contacted'); ?>
</div>
<?php } ?>

<div id="contacts">
	<table>
		<tr>
			<td class="bld text-right">Тел.:</td>
			<td>+7 999 9999999</td>
		</tr>
		<tr>
			<td class="bld text-right">E-mail:</td>
			<td>info@silver96.ru</td>
		</tr>
	</table>
</div><!-- /contacts -->

<div class="form">
	<p class="head">Написать нам</p>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательные для заполнения.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('class'=>'edit300')); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('class'=>'edit300')); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body',array('class'=>'memo400x300')); ?>
		<?php echo $form->error($model,'body'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Отправить сообщение',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
