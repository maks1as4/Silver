<footer id="footer">
	<div class="fleft"><?php echo CHtml::link('www.silver96.ru',Yii::app()->homeUrl); ?></div>
	<div class="fright text-right"><?php echo date('Y'); ?> г.</div>
</footer><!-- /footer -->

<?php if ($this->pageWindows != '') { ?>
<!--noindex-->
<?php echo $this->pageWindows; ?>
<!--/noindex-->
<?php } ?>
