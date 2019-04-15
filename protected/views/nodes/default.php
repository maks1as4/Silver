<?php
$this->pageTitle = ($node['title_seo'] != '') ? $node['title_seo'] : $node['name'];
$this->pageDescription = ($node['desc_seo'] != '') ? $node['desc_seo'] : '';
$this->pageKeywords = ($node['key_seo'] != '') ? $node['key_seo'] : '';
$this->breadcrumbs = $breadcrumbs;
?>

<h1 id="product-name" tab-params="<?php echo base64_encode(Functions::xorCoding($node['id_node'],Yii::app()->params['xorPassword'])); ?>"><?php echo CHtml::encode($node['name']); ?></h1>

<?php if ($node_img) { ?>
<div style="margin-bottom:20px;">
<?php foreach ($node_img as $img){ ?>
<img src="/storage/images/<?php echo $img['name'].'_default.'.$img['ext']; ?>" />
<?php } ?>
</div>
<?php } ?>

<?php if (strlen($node['content']) > 0) { ?>
<div><?php echo $node['content']; ?></div>
<?php } ?>