<?php $this->renderPartial('//categories/_header', array('root'=>$root, 'category'=>$category, 'breadcrumbs'=>$breadcrumbs)); ?>

<h1><?php echo CHtml::encode($category['name']); ?></h1>

<?php
if ($categories)
{
	$cnt = count($categories);
	// делим все подкатегории на 3 части
	if ($cnt % 3 != 0)
	{
		$cel = floor($cnt / 3);
		$r1 = $r2 = $cel;
		$r1++;
		$ost = $cnt - $cel * 3;
		if ($ost == 2)
			$r2++;
	}
	else
		$r1 = $r2 = $cnt / 3;
	$r2 += $r1;
?>
<div id="through-coins-bills">
	<div class="row row-first">
		<ul>
<?php for ($i=0; $i<$r1; $i++) { ?>
			<li><span class="flag<?php echo ($categories[$i]['flag'] != '') ? ' '.$categories[$i]['flag'] : ''; ?>"></span>&nbsp;&nbsp;<?php echo CHtml::link(CHtml::encode($categories[$i]['name']),array('categories/view','id'=>$categories[$i]['id_category'],'url'=>$categories[$i]['url'])); ?></li>
<?php } ?>
		</ul>
	</div>
	<div class="row">
		<ul>
<?php for ($i=$r1; $i<$r2; $i++) { ?>
			<li><span class="flag<?php echo ($categories[$i]['flag'] != '') ? ' '.$categories[$i]['flag'] : ''; ?>"></span>&nbsp;&nbsp;<?php echo CHtml::link(CHtml::encode($categories[$i]['name']),array('categories/view','id'=>$categories[$i]['id_category'],'url'=>$categories[$i]['url'])); ?></li>
<?php } ?>
		</ul>
	</div>
	<div class="row">
		<ul>
<?php for ($i=$r2; $i<$cnt; $i++) { ?>
			<li><span class="flag<?php echo ($categories[$i]['flag'] != '') ? ' '.$categories[$i]['flag'] : ''; ?>"></span>&nbsp;&nbsp;<?php echo CHtml::link(CHtml::encode($categories[$i]['name']),array('categories/view','id'=>$categories[$i]['id_category'],'url'=>$categories[$i]['url'])); ?></li>
<?php } ?>
		</ul>
	</div>
</div><!-- /through-coins-bills -->
<?php } ?>
