<?php
$this->renderPartial('//categories/_header', array('root'=>$root, 'category'=>$category, 'breadcrumbs'=>$breadcrumbs));
$cs = Yii::app()->clientScript;
// Подключаем внешние файлы скриптов
$cs->registerScriptFile('/js/jquery.hover.zoom.js', CClientScript::POS_END);
// Подключаем внутренний скрипт
$cs->registerScript('loading', '
	var src = \'\';
	$(\'div.hoverme\').find(\'img:first\').each(function(){
		src = $(this).attr(\'src\');
		$(this).attr(\'src\', src + \'?\' + new Date().getTime());
	});
	$(\'div.hoverme\').hoverZoom({
		zoom: 20,
		overlayColor: \'#541dfd\',
		overlayOpacity: 0.7
	});
	$(\'div.cell\').hover(
		function() {
			$(this).find(\'div.title\').find(\'a\').css(\'text-decoration\',\'underline\');
		},
		function() {
			$(this).find(\'div.title\').find(\'a\').css(\'text-decoration\',\'none\');
		}
	);
', CClientScript::POS_READY);
?>

<h1><?php echo CHtml::encode($category['name']); ?></h1>

<?php
if ($categories)
{
	$cnt = count($categories);
	$maxheight = array();
	$j = $max = 0;
	foreach ($categories as $key=>$category)
	{
		$j++;
		$rows = Functions::getRowsCnt($category['name'],20);
		if ($rows > $max)
			$max = $rows;
		if ($j == 4 || $key == ($cnt - 1))
		{
			$maxheight[] = $max;
			$j = $max = 0;
		}
	}
?>
<div id="catalog-blocks">
<?php
$j = 0;
for ($i=0; $i<$cnt; $i++)
{
	$hclass = 'cell-height'.$maxheight[floor($i/4)];
	$img = $categories_img[$categories[$i]['id_category']][0];
	$img = (isset($img)) ? CHtml::image('/storage/images/'.$img['name'].'_small.'.$img['ext'],null)
						 : CHtml::image('/images/no-image-192x150.png',null);
	if (++$j > 4)
		$j = 1;
	if ($j == 1)
	{
?>
	<div class="row<?php echo ($i == 0) ? ' row-first' : ''; ?>">
<?php } ?>
		<div class="hoverme shadow cell<?php echo ($j == 1) ? ' cell-first' : ''; ?> <?php echo $hclass; ?>">
			<div class="image-box"><?php echo CHtml::link($img,array('categories/view','id'=>$categories[$i]['id_category'],'url'=>$categories[$i]['url'])); ?></div>
			<div class="title text-center"><?php echo CHtml::link(CHtml::encode($categories[$i]['name']),array('categories/view','id'=>$categories[$i]['id_category'],'url'=>$categories[$i]['url'])); ?></div>
		</div>
<?php if ($j == 4 || $i == ($cnt - 1)) { ?>
		<div class="clearfix"></div>
	</div>
<?php }} ?>
</div><!-- /catalog-blocks -->
<?php } ?>
