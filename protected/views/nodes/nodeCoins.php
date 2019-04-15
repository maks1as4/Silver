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

<div id="node-coins">
	<div class="images">
		<div class="left-image">
<?php if (!empty($img1)) { ?>
			<img src="/storage/images/<?php echo $img1['name']; ?>_default.<?php echo $img1['ext']; ?>" alt="<?php echo $img1['alt']; ?>" title="<?php echo $img1['title']; ?>" />
<?php } else { ?>
			<img src="/images/no-image-250x250.png" />
<?php } ?>
		</div>
		<div class="right-image">
<?php if (!empty($img2)) { ?>
			<img src="/storage/images/<?php echo $img2['name']; ?>_default.<?php echo $img2['ext']; ?>" alt="<?php echo $img2['alt']; ?>" title="<?php echo $img2['title']; ?>" />
<?php }else{ ?>
			<img src="/images/no-image-250x250.png" />
<?php } ?>
		</div>
		<div class="clearfix"></div>
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
<?php if (isset($attr['coins-country'])) { ?>
			<tr>
				<td class="first"><?php echo $attr['coins-country'][1]; ?></td>
				<td><?php echo $attr['coins-country'][0]; ?></td>
			</tr>
<?php } ?>
<?php if (isset($attr['coins-period'])) { ?>
			<tr>
				<td class="first"><?php echo $attr['coins-period'][1]; ?></td>
				<td><?php echo $attr['coins-period'][0]; ?></td>
			</tr>
<?php } ?>
<?php if (isset($attr['coins-coinage'])) { ?>
			<tr>
				<td class="first"><?php echo $attr['coins-coinage'][1]; ?></td>
				<td><?php echo $attr['coins-coinage'][0]; ?></td>
			</tr>
<?php } ?>
<?php if (isset($attr['coins-rating'])) { ?>
			<tr>
				<td class="first"><?php echo $attr['coins-rating'][1]; ?></td>
				<td><?php echo $attr['coins-rating'][0]; ?></td>
			</tr>
<?php } ?>
<?php if (isset($attr['coins-year'])) { ?>
			<tr>
				<td class="first"><?php echo $attr['coins-year'][1]; ?></td>
				<td><?php echo $attr['coins-year'][0]; ?></td>
			</tr>
<?php } ?>
<?php if (isset($attr['coins-material'])) { ?>
			<tr>
				<td class="first"><?php echo $attr['coins-material'][1]; ?></td>
				<td><?php echo $attr['coins-material'][0]; ?></td>
			</tr>
<?php } ?>
<?php if (isset($attr['coins-herd'])) { ?>
			<tr>
				<td class="first"><?php echo $attr['coins-herd'][1]; ?></td>
				<td><?php echo $attr['coins-herd'][0]; ?></td>
			</tr>
<?php } ?>
<?php if (isset($attr['coins-shape'])) { ?>
			<tr>
				<td class="first"><?php echo $attr['coins-shape'][1]; ?></td>
				<td><?php echo $attr['coins-shape'][0]; ?></td>
			</tr>
<?php } ?>
<?php if (isset($attr['coins-ratio'])) { ?>
			<tr>
				<td class="first"><?php echo $attr['coins-ratio'][1]; ?></td>
				<td><?php echo $attr['coins-ratio'][0]; ?></td>
			</tr>
<?php } ?>
<?php if (isset($attr['coins-weight'])) { ?>
			<tr>
				<td class="first"><?php echo $attr['coins-weight'][1]; ?></td>
				<td><?php echo $attr['coins-weight'][0]; ?></td>
			</tr>
<?php } ?>
<?php if (isset($attr['coins-diameter'])) { ?>
			<tr>
				<td class="first"><?php echo $attr['coins-diameter'][1]; ?></td>
				<td><?php echo $attr['coins-diameter'][0]; ?></td>
			</tr>
<?php } ?>
<?php if (isset($attr['coins-thickness'])) { ?>
			<tr>
				<td class="first"><?php echo $attr['coins-thickness'][1]; ?></td>
				<td><?php echo $attr['coins-thickness'][0]; ?></td>
			</tr>
<?php } ?>
		</table><!-- /params -->
<?php } ?>
<?php if (strlen($node['content']) > 0) { ?>
		<p class="head">Описание</p>
		<div class="desc"><?php echo $node['content']; ?></div>
<?php } ?>
	</div>
</div><!-- /node-coins -->
