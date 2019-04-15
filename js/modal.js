$(document).ready(function() {
	$('#delete-basket-items').click(function() {
		var title = $(this).attr('mod-title');
		var message = $(this).attr('mod-message');
		$.modal($('#confirm-modal'), {
			overlayClose: false,
			opacity: 50,
			overlayCss: {backgroundColor:'#555566'},
			closeClass: 'modal-close',
			onShow: function (dialog) {
				$('#confirm-title').text(title);
				$('#confirm-message').text(message);
				$('#confirm-ok').click(function() {
					$.ajax({
						type: 'POST',
						url: '/async/deleteBasketItems',
						dataType: 'json',
						success: function(data) {
							if (data !== null) {
								if (data.status) {
									location.reload();
								} else {
									alert('В корзине нет товаров.');
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
	$('a.delete-basket-item').bind('click', function() {
		var item = $(this).attr('bitem');
		var title = $(this).attr('mod-title');
		var message = $(this).attr('mod-message');
		$.modal($('#confirm-modal'), {
			overlayClose: false,
			opacity: 50,
			overlayCss: {backgroundColor:'#555566'},
			closeClass: 'modal-close',
			onShow: function (dialog) {
				$('#confirm-title').text(title);
				$('#confirm-message').text(message);
				$('#confirm-ok').click(function() {
					$.ajax({
						type: 'POST',
						url: '/async/deleteBasketItem',
						data: {
							'item': item
						},
						dataType: 'json',
						success: function(data) {
							if (data !== null) {
								if (data.status) {
									location.reload();
								} else {
									alert('Не корректный идентификатор.');
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
	$('#quick-order').click(function() {
		$('.stick').hide();
		var Product = $('#product-name');
		var Name = $('#order-name');
		var Phone = $('#order-phone');
		var Comment = $('#order-comment');
		var Captcha = $('#order-captcha');
		$.modal($('#order-modal'), {
			overlayClose: false,
			opacity: 50,
			overlayCss: {backgroundColor:'#555566'},
			closeClass: 'modal-close',
			onShow: function (dialog) {
				Comment.find('textarea.mod').html('Здравствуйте!&#13;&#10;Меня заинтересовал товар: "' + Product.text() + '"');
				Phone.find('input[type="text"].mod').mask('+7 (999) 999-9999');
				Captcha.find('img').attr('src', '/async/captcha?id='+Math.random()+'');
				$('#order-refresh').click(function() {
					Captcha.find('img').attr('src', '/async/captcha?id='+Math.random()+'');
					Captcha.find('input[type="text"].mod').val('').focus();
				});
				$('input[type="text"].mod').bind('focus', function() {
					$(this).parent().removeClass('error').find('span.error-message-modal').empty();
				});
				$('#order-ok').click(function() {
					$('span.error-message-modal').empty();
					$('div.row-modal').removeClass('error');
					$.ajax({
						type: 'POST',
						url: '/async/verifyOrderModal',
						data: {
							'tab': Product.attr('tab-params'),
							'name': Name.find('input[type="text"].mod').val(),
							'phone': Phone.find('input[type="text"].mod').val(),
							'comment': Comment.find('textarea.mod').val(),
							'captcha': Captcha.find('input[type="text"].mod').val()
						},
						dataType: 'json',
						success: function(data) {
							if (data !== null) {
								if (data.status) {
									$.modal.close();
									$.stickr({
										note: '<p class="title">Спасибо. Ваш заказ отправлен!</p><p>Мы перезвоним вам в ближайшее время.</p>',
										className: 'stick-rounded',
										position: {'left':'50%', 'top':'50%'},
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
					Name.find('input[type="text"].mod').focus();
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

	// Orderbox functions
	$('#increase').click(function() {
		var edit = $('#product-cnt');
		var max = edit.attr('max-value');
		if (edit.val() > 0) {
			if (edit.val() == max)
				edit.val(max);
			else
				edit.val(Number(edit.val()) + 1);
		}
	});
	$('#decrease').click(function() {
		var edit = $('#product-cnt');
		if (edit.val() > 0) {
			if (edit.val() == 1)
				edit.val(1);
			else
				edit.val(Number(edit.val()) - 1);
		}
	});
	$('#product-cnt').numberMask({beforePoint:4});
	$('#product-cnt').keyup(function() {
		var max = $(this).attr('max-value');
		if ($(this).val() <= 0)
			$(this).val(1);
		if ($(this).val() > Number(max))
			$(this).val(max);
	});
	$('#product-buy').click(function() {
		if ($('#product-cnt').val() > 0) {
			$.ajax({
				type: 'POST',
				url: '/async/verifyPutIn',
				data: {
					'tab': $('#product-name').attr('tab-params'),
					'cnt': $('#product-cnt').val()
				},
				dataType: 'json',
				success: function(data) {
					if (data.status) {
						$('#menu-basket').css({'color':'#b94a48'}).html(data.content);
					}
				},
				error: function() {
					alert('Сообщение не отправлено! Ошибка: сбой программы.');
				},
				timeout: 5000
			});
		}
		return false;
	});
});