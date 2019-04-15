<?php
$this->pageTitle = 'Новости Silver96';
$this->pageDescription = '';
$this->breadcrumbs = array(
	'Новости',
);
?>

<h1>Новости</h1>

<?php if ($news) { ?>
<div id="news">
<?php
foreach ($news as $new)
{
	$content = ($new->description != '') ? $new->description : mb_substr(strip_tags($new->content), 0, 350, 'utf-8').'...';
	$this->renderPartial('_index',array(
		'news'=>$new,
		'content'=>$content,
	));
}
?>
</div><!-- /news -->
<?php } ?>
