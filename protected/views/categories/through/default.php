<?php $this->renderPartial('//categories/_header', array('root'=>$root, 'category'=>$category, 'breadcrumbs'=>$breadcrumbs)); ?>

<h1><?php echo CHtml::encode($category['name']); ?></h1>

<?php if ($categories) { ?>
<div style="margin-bottom:30px;">
<?php foreach ($categories as $cat) { ?>
	<div style="margin:10px 0; border-bottom:1px solid #acacac;">
<?php
if (!empty($categories_img[$cat['id_category']]))
{
	$img = $categories_img[$cat['id_category']][0];
?>
		<img src="/storage/images/<?php echo $img['name'].'_default.'.$img['ext']; ?>" style="width:100px; heigth:100px; margin-right:10px;" />
<?php } ?>
		<?php echo CHtml::link(CHtml::encode($cat['name']), array('categories/view', 'id'=>$cat['id_category'], 'url'=>$cat['url'])); ?>
	</div>
<?php } ?>
</div>
<?php } ?>

<?php
if (strlen($category['content']) > 0) {
	if ($category_img) {
?>
<img src="/storage/images/<?php echo $category_img[0]['name'].'_default.'.$category_img[0]['ext']; ?>" style="float:left; margin:0 15px 15px 0;" />
<?php } ?>
<div><?php echo $category['content']; ?></div>
<?php } ?>
