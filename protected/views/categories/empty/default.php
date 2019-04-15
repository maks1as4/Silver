<?php $this->renderPartial('//categories/_header', array('root'=>$root, 'category'=>$category, 'breadcrumbs'=>$breadcrumbs)); ?>

<h1><?php echo CHtml::encode($category['name']); ?></h1>

<?php
if (strlen($category['content']) > 0) {
	if (!empty($category_img)) {
?>
<img src="/storage/images/<?php echo $category_img[0]['name'].'_default.'.$category_img[0]['ext']; ?>" style="float:left; margin:0 15px 15px 0;" />
<?php } ?>
<div><?php echo $category['content']; ?></div>
<?php } ?>