<?php
$this->menu=array(
	array('label'=>'Изменить страницу', 'url'=>array('update', 'id'=>$model->id_node)),
	array('label'=>'Управление страницами', 'url'=>array('index')),
);

$note = '';
switch ($modelAttr->type)
{
	case 0: {$note = 'Не более 5000 символов, разрешенно: а-яёa-z0-9-_+!?.,;:*&$%#№@<>|`~(){}[]/'; break;} // string
	case 1: {$note = 'Только целые числа.'; break;} // integer
	case 2: {$note = 'Целые и дробные числа, например: -12.34'; break;} // decimal
	case 3: {$note = 'Только 0 или 1'; break;} // boolean
	case 4: {$note = 'Не более 5000 символов. Данные в формате url (обязательно вначале http:// или https:// или ftp://),<br />например: http://www.uptc.ru/price/pogrujnie-bitovie-nasosi-tipa-bcp_14'; break;} // link
	case 5: {$note = 'Не более 5000 символов, разрешенно: а-яёa-z0-9-_+!?.,;:*&$%#№@<>|`~(){}[]/'; break;} // enum
	case 6: {$note = 'Не более 5000 символов, разрешенно: a-z0-9-_./'; break;} // image
	case 7: {$note = 'Не более 5000 символов, разрешенно: a-z0-9-_./'; break;} // file
	case 8: {$note = 'Дата и время в формате: yyyy-MM-dd HH:mm:ss'; break;} // date
}
?>

<h1>Страница: "<?php echo $model->name; ?>", атрибут: "<?php echo $modelAttr->name; ?> (<?php echo $modelAttr->translit; ?>)"</h1>

<?php if(Yii::app()->user->hasFlash('success')){ ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('success'); ?>
</div>

<?php } ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nodes-attr-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo $note; ?></p>

	<div class="row">
		<?php echo $form->labelEx($validModel,'attr'); ?>
		<?php echo $form->textField($validModel,'attr',array('size'=>80,'maxlength'=>5000)); ?>
		<?php echo $form->error($validModel,'attr'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->