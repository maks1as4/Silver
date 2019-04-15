<div class="rubrics-list slide">
	<ul>
<?php foreach ($subcategories as $sub) { ?>
		<li><?php echo CHtml::link(CHtml::encode($sub['name']),array('categories/view','id'=>$sub['id_category'],'url'=>$sub['url'])); ?></li>
<?php } ?>
	</ul>
</div>