$(document).ready(function() {
	$('#show-order-modal').click(function() {
		$('.stick').hide();
		var Subject = $('#order-subject');
		var Name = $('#order-name');
		var Phone = $('#order-phone');
		var Date = $('#order-date');
		var Comment = $('#order-comment');
		var Cost = $('#order-cost');
		var Captcha = $('#order-captcha');
		$.modal($('#order-modal'), {
			overlayClose: true,
			opacity: 70,
			overlayCss: {backgroundColor:'#555555'},
			closeClass: 'modal-close',
			onShow: function (dialog) {
				Phone.find('input[type="text"].mod').mask('+7 (999) 999-9999');
				Captcha.find('img').attr('src', '/modal/captcha.php?id='+Math.random()+'');
				$('#order-refresh').click(function() {
					Captcha.find('img').attr('src', '/modal/captcha.php?id='+Math.random()+'');
					Captcha.find('input[type="text"].mod').val('').focus();
				});
				$('input[type="text"].mod').bind('focus', function() {
					$(this).parent().removeClass('error').find('span.error-message-modal').empty();
				});
				$('#order-ok').click(function() {
					$('span.error-message-modal').empty();
					$('div.rowmod').removeClass('error');
					$.ajax({
						type: 'POST',
						url: '/modal/order/verify.php',
						data: {
							'subject': Subject.find('select.mod option:selected').text(),
							'name': Name.find('input[type="text"].mod').val(),
							'phone': Phone.find('input[type="text"].mod').val(),
							'date': Date.find('input[type="text"].mod').val(),
							'comment': Comment.find('textarea.mod').val(),
							'cost': Cost.find('input[type="checkbox"].mod').prop('checked'),
							'captcha': Captcha.find('input[type="text"].mod').val()
						},
						dataType: 'json',
						success: function(data) {
							if (data !== null) {
								if (data.status) {
									$.modal.close();
									$.stickr({
										note: 'Ваша заявка была отправлена.',
										className: 'stick-rounded',
										position: {'left':'50%', 'top':'30px'},
										time: 4000,
										speed: 3000
									});
								} else {
									$.each(data.error, function(key, value) {
										$('#' + key).addClass('error').find('span.error-message-modal').append(value);
									});
								}
							} else {
								alert('Сообщение не отправлено! Ошибка: передача данных не завершена.');
							}
						},
						error: function() {
							alert('Сообщение не отправлено! Ошибка: сбой программы.');
						},
						timeout: 5000
					});
					return false;
				});
			},
			onOpen: function(dialog) {
				dialog.overlay.fadeIn(100, function() {
					dialog.container.fadeIn(300);
					dialog.data.show();
				});
			},
			onClose: function(dialog) {
				dialog.container.fadeOut(300, function() {
					dialog.overlay.fadeOut(100);
					dialog.data.hide();
					$.modal.close();
				});
			}
		});
		return false;
	});
});