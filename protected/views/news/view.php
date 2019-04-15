<?php
$this->pageTitle = ($news->title_seo) ? CHtml::encode($news->title_seo) : CHtml::encode($news->name);
$this->pageDescription = ($news->desc_seo) ? CHtml::encode($news->desc_seo) : '';
$this->breadcrumbs=array(
	'Новости'=>array('news/index'),
	CHtml::encode($news->name)
);
?>

<h1><?php echo CHtml::encode($news->name); ?></h1>

<?php if ($news->image != '') { ?>
<img src="/storage/images/news/<?php echo $news->image; ?>_small.<?php echo $news->ext; ?>" class="news-format" />
<?php } ?>
<p><?php echo $news->content; ?></p>
