<header id="header">
	<div class="hleft">
		<div class="logo">
			<?php echo CHtml::link(CHtml::image('/images/logo.png'),Yii::app()->homeUrl); ?>
		</div><!-- /logo -->
		<div class="slogan text-center">
			Монеты, боны,<br />антиквариат,<br />подарки
		</div><!-- /slogan -->
	</div>
	<div class="hright">
		<div class="money">&nbsp;</div>
	</div>
	<div class="clearfix"></div>
	<div id="menu">
		<?php $this->widget('MainMenu'); ?>
	</div>
</header><!-- /header-->
