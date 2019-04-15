<?php
$this->pageTitle = 'Продажа монет, бонов, антиквариата, оригинальных vip подарков';
$this->pageDescription = '';
?>

<div id="index">
<?php
if ($categories)
{
	$j = 0;
	for ($i=0; $i<$cnt; $i++)
	{
		if (++$j > 3)
			$j = 1;
		if ($j == 1)
		{
?>
	<div class="row<?php echo ($i == 0) ? ' row-first' : ''; ?>">
<?php } ?>
		<div class="hoverme shadow cell<?php echo ($j == 1) ? ' cell-first' : ''; ?>">
			<div class="image-box"><?php echo CHtml::link(CHtml::image('/storage/images/'.$images[$categories[$i]['id_category']][0]['name'].'_medium.'.$images[$categories[$i]['id_category']][0]['ext'],null),array('categories/view','id'=>$categories[$i]['id_category'],'url'=>$categories[$i]['url'])); ?></div>
			<div class="title text-center"><?php echo CHtml::link(CHtml::encode($categories[$i]['name']),array('categories/view','id'=>$categories[$i]['id_category'],'url'=>$categories[$i]['url'])); ?></div>
		</div>
<?php if ($j == 3 || $i == ($cnt - 1)) { ?>
		<div class="clearfix"></div>
	</div>
<?php }}} ?>
	<div class="about">
		<h1>Интернет магазин Silver96</h1>
		<p>Разнообразный и богатый опыт новая модель организационной деятельности требуют от нас анализа систем массового участия. Идейные соображения высшего порядка, а также дальнейшее развитие различных форм деятельности способствует подготовки и реализации существенных финансовых и административных условий. Повседневная практика показывает, что рамки и место обучения кадров играет важную роль в формировании форм развития. Задача организации, в особенности же реализация намеченных плановых заданий требуют от нас анализа соответствующий условий активизации. Идейные соображения высшего порядка, а также рамки и место обучения кадров способствует подготовки и реализации дальнейших направлений развития.</p>
		<p>Значимость этих проблем настолько очевидна, что новая модель организационной деятельности позволяет выполнять важные задания по разработке форм развития. Разнообразный и богатый опыт укрепление и развитие структуры в значительной степени обуславливает создание соответствующий условий активизации.</p>
	</div>
<?php if ($news) { ?>
	<div class="news">
		<p class="title head">Последние новости</p>
<?php
foreach ($news as $nw)
{
	$content = ($nw->description != '') ? $nw->description : mb_substr(strip_tags($nw->content), 0, 200, 'utf-8').'...';
?>
		<div class="block">
<?php
	echo CHtml::link(CHtml::encode($nw->name), array('news/view', 'id'=>$nw->id_news, 'url'=>$nw->url));
	echo CHtml::encode($content);
?>
			<div class="news-date"><?php echo Functions::getDateCP($nw->adate); ?></div>
		</div>
<?php } ?>
		<?php echo CHtml::link('посмотреть все новости', array('news/index')); ?>
	</div>
<?php } ?>
</div><!-- /index -->
