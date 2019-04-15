<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Swish jQuery Zoom Hover Effect Plugin Freebie</title>
<style type="text/css">
body {
	font: 14px Arial, sans-serif;
}



.zoom {
	width: 260px;
	height: 200px;
	display: block;
	position: relative;
	overflow: hidden;
}
.zoomOverlay {
	position: absolute;
	top: 0;
	left: 0;
	bottom: 0;
	right: 0;
	display: none;
	background-image: url('zoom.png');
	background-repeat: no-repeat;
	background-position: center;
}



div.row {
	width: 830px;
	margin-top: 25px;
}
div.row-first {
	margin-top: 0 !important;
}
div.cell {
	float: left;
	width: 260px;
	height: 260px;
	margin-left: 25px;
	cursor: pointer;
}
div.cell-first {
	margin-left: 0 !important;
}
div.cell div.title {
	width: 256px;
	margin: 16px 2px 0 2px;
}
div.cell div.title a {
	font-size: 22px;
	color: #333333;
	text-decoration: none;
}
div.cell div.title a:hover {
	text-decoration: underline;
	color: #000000;
}
.shadow {
	-webkit-box-shadow: 0 0 16px 0 #464646;
	   -moz-box-shadow: 0 0 16px 0 #464646;
			box-shadow: 0 0 16px 0 #464646;
}
.text-center {
	text-align: center;
}
.text-right {
	text-align: right;
}
.text-left {
	text-align: left;
}
.clearfix {
  *zoom: 1;
}
.clearfix:before,
.clearfix:after {
  display: table;
  line-height: 0;
  content: "";
}
.clearfix:after {
  clear: both;
}
</style>
<script src="jquery-1.10.2.min.js"></script>
<script src="jquery.mb.browser.min.js"></script>
<script src="magic.hover.zoom.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.hoverme').hoverZoom({
		zoom: 50,
		overlayColor: '#541dfd',
		overlayOpacity: 0.7
	});

	$('div.cell').hover(
		function() {
			$(this).find('div.title').find('a').css('text-decoration','underline');
		},
		function() {
			$(this).find('div.title').find('a').css('text-decoration','none');
		}
	);
});
</script>
</head>
<body>
<div style="margin:100px 0 0 200px;">
	<div class="row row-first">
		<div class="shadow cell cell-first hoverme">
			<div class="image-box"><a href="http://silver96.ru/categories/1847?url=moneti" class="zoom"><img src="201603211754192338_medium.jpg" /></a></div>
			<div class="title text-center"><a href="http://silver96.ru/categories/1847?url=moneti">Монеты</a></div>
		</div>
		<div class="shadow cell hoverme">
			<div class="image-box"><a href="http://silver96.ru/categories/1848?url=banknoti" class="zoom"><img src="201603211754353723_medium.jpg" /></a></div>
			<div class="title text-center"><a href="http://silver96.ru/categories/1848?url=banknoti">Банкноты</a></div>
		</div>
		<div class="shadow cell hoverme">
			<div class="image-box"><a href="http://silver96.ru/categories/1852?url=antikvarnaya-mebel" class="zoom"><img src="201603211755526073_medium.jpg" /></a></div>
			<div class="title text-center"><a href="http://silver96.ru/categories/1852?url=antikvarnaya-mebel">Подарки</a></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
</body>
</html>