<?php $this->renderPartial('//categories/_header', array('root'=>$root, 'category'=>$category, 'breadcrumbs'=>$breadcrumbs)); ?>

<h1><?php echo CHtml::encode($category['name']); ?></h1>

<?php if ($nodes){ ?>
<div>
<?php foreach ($nodes as $node) { ?>
	<div style="margin:10px 0; border-bottom:1px solid #acacac;">
<?php
if (!empty($nodes_img[$node['id_node']]))
{
	$img = $nodes_img[$node['id_node']][0];
?>
		<img src="/storage/images/<?php echo $img['name'].'_default.'.$img['ext']; ?>" style="width:100px; heigth:100px; margin-right:10px;" />
<?php } ?>
	<?php echo CHtml::link(CHtml::encode($node['name']), array('nodes/view', 'id'=>$node['id_node'], 'url'=>$node['url'])); ?>
	</div>
<?php } ?>
</div>
<?php } ?>

<div class="paginator-box">
<?php $this->widget('MyLinkPager', array('pages'=>$pager)); ?>
</div>

<?php
if (strlen($category['content']) > 0) {
	if ($category_img) {
?>
<img src="/storage/images/<?php echo $category_img[0]['name'].'_default.'.$category_img[0]['ext']; ?>" style="float:left; margin:0 15px 15px 0;" />
<?php } ?>
<div><?php echo $category['content']; ?></div>
<?php } ?>
