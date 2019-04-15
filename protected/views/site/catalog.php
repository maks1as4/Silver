<?php
$this->pageTitle = 'Каталог товаров Silver96';
$this->pageDescription = '';
$this->breadcrumbs = array(
	'Каталог',
);
?>

<h1>Каталог товаров</h1>

<div id="catalog">
	<a href="javascript://" class="hide-all btn btn-small">Показать подрубрики</a>&nbsp;
	<a href="javascript://" class="show-all btn btn-small">Скрыть подрубрики</a>
	<div class="rows">
		<div class="row">
<?php for ($i=0; $i<count($left); $i++) { ?>
			<div class="shadow cell<?php echo ($i == 0) ? ' cell-first' : ''; ?>">
				<div class="image-box">
					<div class="title"><?php echo CHtml::link(CHtml::encode($left[$i]['name']),array('categories/view','id'=>$left[$i]['id_category'],'url'=>$left[$i]['url'])); ?></div>
					<?php echo CHtml::image('/storage/images/'.$images[$left[$i]['id_category']][0]['name'].'_big.'.$images[$left[$i]['id_category']][0]['ext']); ?>
				</div>
<?php
if (isset($subcategories[$left[$i]['id_category']]) && !empty($subcategories[$left[$i]['id_category']]))
{
	$render_name = ($left[$i]['is_flag']) ? '_catalog_flags' : '_catalog_list';
	$this->renderPartial($render_name,array(
		'subcategories'=>$subcategories[$left[$i]['id_category']],
	));
}
?>
			</div>
<?php } ?>
		</div>
		<div class="row row-last">
<?php for ($i=0; $i<count($right); $i++) { ?>
			<div class="shadow cell<?php echo ($i == 0) ? ' cell-first' : ''; ?>">
				<div class="image-box">
					<div class="title"><?php echo CHtml::link(CHtml::encode($right[$i]['name']),array('categories/view','id'=>$right[$i]['id_category'],'url'=>$right[$i]['url'])); ?></div>
					<?php echo CHtml::image('/storage/images/'.$images[$right[$i]['id_category']][0]['name'].'_big.'.$images[$right[$i]['id_category']][0]['ext'],null); ?>
				</div>
<?php
if (isset($subcategories[$right[$i]['id_category']]) && !empty($subcategories[$right[$i]['id_category']]))
{
	$render_name = ($right[$i]['is_flag']) ? '_catalog_flags' : '_catalog_list';
	$this->renderPartial($render_name,array(
		'subcategories'=>$subcategories[$right[$i]['id_category']],
	));
}
?>
			</div>
<?php } ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div><!-- /catalog -->
