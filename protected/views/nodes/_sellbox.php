<?php $x = (($price - floor($price)) > 0) ? 2 : 0; ?>
<!--noindex-->
<div id="sellbox">
	<div class="title text-center">цена / наличие</div>
	<div class="price">
<?php if ($price > 0) { ?>
		<?php echo number_format($price, $x, ',', ' '); ?> &#8381;
<?php }else{ ?>
		<span class="noprice">цена неизвестна</span>
<?php } ?>
		<br /><span class="existence">наличие: <strong><?php echo $existence; ?> шт.</strong></span>
	</div>
<?php if ($price > 0) { ?>
	<div class="title title-add text-center">добавить в корзину</div>
	<form class="form-inline">
		<div class="indent">
			<a href="javascript://" id="decrease" class="btn<?php echo ($existence <= 0) ? ' disabled' : ''; ?>" rel="nofollow">-</a>&nbsp;
			<input type="text" value="<?php echo ($existence > 0) ? '1' : '0'; ?>" id="product-cnt" class="cnt" max-value="<?php echo $existence; ?>"<?php echo ($existence <= 0) ? ' disabled' : ''; ?> />&nbsp;
			<a href="javascript://" id="increase" class="btn<?php echo ($existence <= 0) ? ' disabled' : ''; ?>" rel="nofollow">+</a>
		</div>
		<!--div class="go-basket text-center"><a href="javascript://">перейти к отормлению заявки</a></div-->
		<a href="javascript://" id="product-buy" class="send btn btn-primary<?php echo ($existence <= 0) ? ' disabled' : ''; ?>" rel="nofollow">в корзину</a>
	</form>
<?php if ($existence > 0) { ?>
	<div class="quick-order text-center"><a href="javascript://" id="quick-order" class="dashed" rel="nofollow">быстрый заказ</a></div>
<?php } ?>
<?php } ?>
</div><!-- /sellbox -->
<!--/noindex-->
