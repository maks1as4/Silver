<div class="row">
<?php if ($news->image != '') { ?>
	<div class="image"><?php echo CHtml::link(CHtml::image('/storage/images/news/'.$news->image.'_small.'.$news->ext),array('news/view', 'id'=>$news->id_news, 'url'=>$news->url)); ?></div>
<?php } ?>
	<div class="announce-<?php echo ($news->image != '') ? 'half' : 'full'; ?>">
		<?php echo CHtml::link(CHtml::encode($news->name),array('news/view', 'id'=>$news->id_news, 'url'=>$news->url),array('class'=>'news-title')); ?>
		<?php echo CHtml::encode($content); ?>
		<div class="news-date"><?php echo Functions::getDateCP($news->adate); ?></div>
	</div>
	<div class="clearfix"></div>
</div>
