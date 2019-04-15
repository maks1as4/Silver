<ul>
<?php if ($modelsCoin) { ?>
	<li>
		<?php echo CHtml::link(CHtml::encode($modelsCoin[0]['name']),array('categories/view','id'=>$modelsCoin[0]['id_category'],'url'=>$modelsCoin[0]['url']),array('class'=>'outer outer-first close')); ?>
		<div class="list">
			<ul>
<?php
$coins_cnt = count($modelsCoin);
for ($i=1; $i<$coins_cnt; $i++) {
?>
				<li class="inner<?php echo ($i == 1) ? ' inner-first' : ''; ?>">
					<span class="flag<?php echo ($modelsCoin[$i]['flag'] != '') ? ' '.$modelsCoin[$i]['flag'] : ''; ?>"></span>&nbsp;
					<?php echo CHtml::link(CHtml::encode($modelsCoin[$i]['name']),array('categories/view','id'=>$modelsCoin[$i]['id_category'],'url'=>$modelsCoin[$i]['url'])); ?>
				</li>
<?php } ?>
			</ul>
		</div>
	</li>
<?php } ?>
<?php if ($modelsBill) { ?>
	<li>
		<?php echo CHtml::link(CHtml::encode($modelsBill[0]['name']),array('categories/view','id'=>$modelsBill[0]['id_category'],'url'=>$modelsBill[0]['url']),array('class'=>'outer close')); ?>
		<div class="list">
			<ul>
<?php
$bills_cnt = count($modelsBill);
for ($i=1; $i<$bills_cnt; $i++) {
?>
				<li class="inner<?php echo ($i == 1) ? ' inner-first' : ''; ?>">
					<span class="flag<?php echo ($modelsBill[$i]['flag'] != '') ? ' '.$modelsBill[$i]['flag'] : ''; ?>"></span>&nbsp;
					<?php echo CHtml::link(CHtml::encode($modelsBill[$i]['name']),array('categories/view','id'=>$modelsBill[$i]['id_category'],'url'=>$modelsBill[$i]['url'])); ?>
				</li>
<?php } ?>
			</ul>
		</div>
	</li>
<?php } ?>
<?php
if ($modelsOther) {
	foreach ($modelsOther as $model) {
?>
	<li><?php echo CHtml::link(CHtml::encode($model->name),array('categories/view','id'=>$model->id_category,'url'=>$model->url),array('class'=>'outer')); ?></li>
<?php }} ?>
</ul>
