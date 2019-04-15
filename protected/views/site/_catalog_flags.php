<?php
$cnt = count($subcategories);
$len = ($cnt % 2 == 0) ? $cnt / 2 : ($cnt + 1) / 2;
?>
<div class="rubrics-flag slide">
	<div class="block">
		<ul>
<?php for ($i=0; $i<$len; $i++) { ?>
			<li><span class="flag <?php echo $subcategories[$i]['flag']; ?>"></span>&nbsp;&nbsp;<?php echo CHtml::link(CHtml::encode($subcategories[$i]['name']),array('categories/view','id'=>$subcategories[$i]['id_category'],'url'=>$subcategories[$i]['url'])); ?></li>
<?php } ?>
		</ul>
	</div>
	<div class="block right-block">
		<ul>
<?php for ($i=$len; $i<$cnt; $i++) { ?>
			<li><span class="flag <?php echo $subcategories[$i]['flag']; ?>"></span>&nbsp;&nbsp;<?php echo CHtml::link(CHtml::encode($subcategories[$i]['name']),array('categories/view','id'=>$subcategories[$i]['id_category'],'url'=>$subcategories[$i]['url'])); ?></li>
<?php } ?>
		</ul>
	</div>
	<div class="clearfix"></div>
</div>
