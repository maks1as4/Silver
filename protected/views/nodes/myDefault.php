<?php
$this->pageTitle = ($node['title_seo'] != '') ? $node['title_seo'] : $node['name'];
$this->pageDescription = ($node['desc_seo'] != '') ? $node['desc_seo'] : '';
$this->pageKeywords = ($node['key_seo'] != '') ? $node['key_seo'] : '';
$this->breadcrumbs = $breadcrumbs;

$img = array();
if ($node_img)
	$img = CHtml::image('/storage/images/'.$node_img[0]['name'].'_big.'.$node_img[0]['ext'],$node_img[0]['alt_lang']);
else
	$img = CHtml::image('/images/no-image-250x200.png',null);
?>

<h1 id="product-name" tab-params="<?php echo base64_encode(Functions::xorCoding($node['id_node'],Yii::app()->params['xorPassword'])); ?>"><?php echo CHtml::encode($node['name']); ?></h1>

<div id="my-default">
	<div class="images">
		<?php echo $img; ?>
	</div>
	<div class="sellbox-outer">
<?php
$this->renderPartial('_sellbox',array(
	'price'=>$node['price'],
	'existence'=>$node['existence'],
));
?>
	</div>
	<div class="clearfix"></div>
	<div class="line">
<?php if ($attr) { ?>
		<p class="head">Параметры</p>
		<table id="params">
<?php foreach ($attr as $a) { ?>
			<tr>
				<td class="first"><?php echo $a[1]; ?></td>
				<td><?php echo $a[0]; ?></td>
			</tr>
<?php } ?>
		</table>
<?php } ?>
<?php if (strlen($node['content']) > 0) { ?>
		<p class="head">Описание</p>
		<div class="desc"><?php echo $node['content']; ?></div>
<?php } ?>
	</div>
</div><!-- /my-default -->
