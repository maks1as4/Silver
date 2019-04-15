<?php
$this->pageTitle = 'Корзина';
$this->pageDescription = '';
$this->breadcrumbs = array(
	'Корзина',
);
?>

<h1>Ваш заказ</h1>

<?php if (Yii::app()->user->hasFlash('sended')) { ?>
<div class="alert alert-success">
	<?php echo Yii::app()->user->getFlash('sended'); ?>
</div>
<?php } ?>

<div id="basket">
<?php if ($basketList) { ?>
	<table class="basket">
		<tr>
			<th class="text-center">#</th>
			<th class="name text-left">Наименование</th>
			<th class="text-center">Кол.</th>
			<th class="text-center">Сумма (руб.)</th>
			<th></th>
		</tr>
<?php
foreach ($basketList as $key=>$bl)
{
	$sum = Yii::app()->ShoppingCart->getSumToPosition($bl['id']);
	$x = (($sum - floor($sum)) > 0) ? 2 : 0;
?>
		<tr>
			<td class="num text-center"><?php echo ($key + 1); ?></td>
			<td class="name text-left"><?php echo CHtml::link(CHtml::encode($bl['name']), array('/nodes/view', 'id'=>$bl['id'], 'url'=>$bl['url']), array('target'=>'_blank')); ?></td>
			<td class="cnt text-center"><?php echo $bl['count']; ?></td>
			<td class="price text-right"><?php echo number_format($sum, $x, ',', ' '); ?></td>
			<td class="del text-center"><?php echo CHtml::link('<i class="icon-delete-16"></i>', array('/order/delete', 'id'=>$bl['id']), array('class'=>'delete-basket-item', 'bitem'=>$bl['id'], 'mod-title'=>'Подтвердите удаление', 'mod-message'=>'Вы уверены, что хотите удалить из корзины данный товар?')); ?></td>
		</tr>
<?php } ?>
	</table>
	<div class="total">
		<div class="clear-all"><?php echo CHtml::link('Очистить корзину', array('/order/clear'), array('id'=>'delete-basket-items', 'class'=>'btn', 'mod-title'=>'Подтвердите удаление', 'mod-message'=>'Вы уверены, что хотите удалить из корзины все товары?')); ?></div>
		<div class="res text-right">Итого в корзине: <?php echo Yii::app()->ShoppingCart->count_in_basket; ?> позиций(я) на сумму <?php echo Functions::getFormatedPrice(Yii::app()->ShoppingCart->sum); ?></div>
		<div class="clearfix"></div>
	</div>
	<div class="form">
		<p class="head">Оформите данные для заказа</p>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

		<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('maxlength'=>150,'class'=>'edit300')); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'phone'); ?>
			<?php echo $form->textField($model,'phone',array('maxlength'=>20,'class'=>'edit300')); ?>
			<?php echo $form->error($model,'phone'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email',array('maxlength'=>100,'class'=>'edit300')); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'comment'); ?>
			<?php echo $form->textArea($model,'comment',array('class'=>'memo400x300')); ?>
			<?php echo $form->error($model,'comment'); ?>
		</div>

		<div class="row buttons">
			<?php echo CHtml::submitButton('Отправить заказ',array('class'=>'btn btn-primary')); ?>
		</div>

<?php $this->endWidget(); ?>
	</div><!-- form -->
<?php }else{ ?>
	<p class="empty">Корзина пуста.</p>
<?php } ?>
</div><!-- /basket -->
