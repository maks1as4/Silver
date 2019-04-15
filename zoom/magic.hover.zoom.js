(function($){
	$.fn.extend({
		hoverZoom: function(settings) {

			var defaults = {
				overlay: true,
				overlayColor: '#2e9dbd',
				overlayOpacity: 0.7,
				zoom: 25,
				speed: 300
			};

			var settings = $.extend(defaults, settings);

			return this.each(function() {

				var s = settings;
				var hz = $(this);
				var image = $('img', hz);
				var dest = null;

				if (jQuery.browser.msie)
				{
					dest = 'javascript://';
				}

				image.load(dest, function() {

					if (s.overlay === true) {
						$(this).parent().append('<div class="zoomOverlay" />');
						$(this).parent().find('.zoomOverlay').css({
							opacity: 0,
							display: 'block',
							backgroundColor: s.overlayColor
						});
					}

					var width = $(this).width();
					var height = $(this).height();
					var k = width / height;

					$(this).parent().css('background-image', 'none');
					hz.bind({
						mouseenter: function(e) {
							$('img', this).stop().animate({
								height: height + s.zoom,
								marginLeft: -(Math.round(s.zoom / k)),
								marginTop: -(s.zoom)
							}, s.speed);
							if (s.overlay === true) {
								$('img', this).parent().find('.zoomOverlay').stop().animate({
									opacity: s.overlayOpacity
								}, s.speed);
							}
						},
						mouseleave: function(e) {
							$('img', this).stop().animate({
								height: height,
								marginLeft: 0,
								marginTop: 0
							}, s.speed);
							if (s.overlay === true) {
								$('img', this).parent().find('.zoomOverlay').stop().animate({
									opacity: 0
								}, s.speed);
							}
						},
						click: function(e) {
							var link = $('a:first', this).attr('href');
							window.location = link;
						}
					});
				});
			});
		}
	});
})(jQuery);