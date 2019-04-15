<?php $this->beginContent('//layouts/main'); ?>
<div id="container">
	<main id="content">
<?php if (!empty($this->breadcrumbs)){ ?>
		<div id="breadcrumbs">
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
			)); ?>
		</div><!-- /breadcrumbs -->
<?php } ?>
		<?php echo $content; ?>
	</main><!-- /content -->
</div><!-- /container-->
<aside id="left-sidebar">
	<?php $this->widget('SideMenu'); ?>
</aside><!-- /left-sidebar -->
<?php $this->endContent(); ?>