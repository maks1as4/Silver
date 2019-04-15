<?php $this->renderPartial('//categories/_header', array('root'=>$root, 'category'=>$category, 'breadcrumbs'=>$breadcrumbs)); ?>

<h1><?php echo CHtml::encode($category['name']); ?></h1>

<?php if ($nodes) { ?>
<div id="catalog-bills">
<?php foreach ($nodes as $node) { ?>
	<div class="row">
		<div class="image">
<?php
if (!empty($nodes_img[$node['id_node']]))
{
	$img = $nodes_img[$node['id_node']][0];
	echo CHtml::link(CHtml::image('/storage/images/'.$img['name'].'_default.'.$img['ext']), array('nodes/view', 'id'=>$node['id_node'], 'url'=>$node['url']));
}
else
	echo CHtml::link(CHtml::image('/images/no-image-250x110.png'), array('nodes/view', 'id'=>$node['id_node'], 'url'=>$node['url']));
?>
		</div>
		<div class="title">
			<div class="title-inner">
				<span class="flag <?php echo $category['flag']; ?>"></span>&nbsp;&nbsp;<?php echo CHtml::link(CHtml::encode($node['name']), array('nodes/view', 'id'=>$node['id_node'], 'url'=>$node['url'])); ?>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
<?php } ?>
</div><!-- /catalog-bills -->
<div class="paginator-box">
<?php $this->widget('MyLinkPager', array('pages'=>$pager)); ?>
</div>
<?php } ?>
