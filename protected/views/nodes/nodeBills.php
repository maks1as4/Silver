<?php
$this->pageTitle = ($node['title_seo'] != '') ? $node['title_seo'] : $node['name'];
$this->pageDescription = ($node['desc_seo'] != '') ? $node['desc_seo'] : '';
$this->pageKeywords = ($node['key_seo'] != '') ? $node['key_seo'] : '';
$this->breadcrumbs = $breadcrumbs;

$img1 = $img2 = array();
if ($node_img)
{
	$i = 1;
	foreach ($node_img as $ni)
	{
		if ($i == 1)
			$img1 = array('name'=>$ni->name,'ext'=>$ni->ext,'title'=>$ni->title,'alt'=>$ni->alt,'title_lang'=>$ni->title_lang,'alt_lang'=>$ni->alt_lang);
		elseif ($i == 2)
			$img2 = array('name'=>$ni->name,'ext'=>$ni->ext,'title'=>$ni->title,'alt'=>$ni->alt,'title_lang'=>$ni->title_lang,'alt_lang'=>$ni->alt_lang);
		else
			break;
		$i++;
	}
}
?>

<h1 id="product-name" tab-params="<?php echo base64_encode(Functions::xorCoding($node['id_node'],Yii::app()->params['xorPassword'])); ?>"><?php echo CHtml::encode($node['name']); ?></h1>

<div id="node-bills">
	<div class="images">
		<div>
<?php if (!empty($img1)) { ?>
			<img src="/storage/images/<?php echo $img1['name']; ?>_default.<?php echo $img1['ext']; ?>" alt="<?php echo $img1['alt']; ?>" title="<?php echo $img1['title']; ?>" />
<?php }else{ ?>
			<img src="/images/no-image-350x154.png" />
<?php } ?>
		</div>
		<div class="last">
<?php if (!empty($img2)) { ?>
			<img src="/storage/images/<?php echo $img2['name']; ?>_default.<?php echo $img2['ext']; ?>" alt="<?php echo $img2['alt']; ?>" title="<?php echo $img2['title']; ?>" />
<?php }else{ ?>
			<img src="/images/no-image-350x154.png" />
<?php } ?>
		</div>
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
<?php if (!empty($attr)) { ?>
		<p class="head">Параметры</p>
		<table id="params">
<?php if (isset($attr['bills-country'])) { ?>
			<tr>
				<td class="first"><?php echo $attr['bills-country'][1]; ?></td>
				<td><?php echo $attr['bills-country'][0]; ?></td>
			</tr>
<?php } ?>
<?php if (isset($attr['bills-period'])) { ?>
			<tr>
				<td class="first"><?php echo $attr['bills-period'][1]; ?></td>
				<td><?php echo $attr['bills-period'][0]; ?></td>
			</tr>
<?php } ?>
<?php if (isset($attr['bills-rating'])) { ?>
			<tr>
				<td class="first"><?php echo $attr['bills-rating'][1]; ?></td>
				<td><?php echo $attr['bills-rating'][0]; ?></td>
			</tr>
<?php } ?>
<?php if (isset($attr['bills-year'])) { ?>
			<tr>
				<td class="first"><?php echo $attr['bills-year'][1]; ?></td>
				<td><?php echo $attr['bills-year'][0]; ?></td>
			</tr>
<?php } ?>
<?php if (isset($attr['bills-length'])) { ?>
			<tr>
				<td class="first"><?php echo $attr['bills-length'][1]; ?></td>
				<td><?php echo $attr['bills-length'][0]; ?></td>
			</tr>
<?php } ?>
<?php if (isset($attr['bills-width'])) { ?>
			<tr>
				<td class="first"><?php echo $attr['bills-width'][1]; ?></td>
				<td><?php echo $attr['bills-width'][0]; ?></td>
			</tr>
<?php } ?>
		</table><!-- /params -->
<?php } ?>
<?php if (strlen($node['content']) > 0) { ?>
		<p class="head">Описание</p>
		<div class="desc"><?php echo $node['content']; ?></div>
<?php } ?>
	</div>
</div><!-- /node-bills -->
