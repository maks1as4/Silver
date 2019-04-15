<?php
/*
$this->breadcrumbs=array(
	'Журнал пользователей'=>array('index'),
	$model->username=>array('view','id'=>$model->id),
	'Изменить пароль',
);
*/

$this->menu=array(
	array('label'=>'Управление пользователями', 'url'=>array('index')),
	array('label'=>'Изменить пользователя', 'url'=>array('update', 'id'=>$model->id)),
);
?>

<div class="form">

<h1>Изменить пароль пользователя: <?php echo $model->username; ?></h1>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-password-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->passwordField($model,'password',array('value'=>'','size'=>50,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->