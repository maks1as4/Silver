<?php

session_start();

if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
{
	$status = true; // по умолчанию проверка пройдена
	$error = array();

	// Валидация формы
	// Тема письма (order-subject)
	$subject = $_REQUEST['subject'];

	// Имя (order-name)
	$name = preg_replace('/[\s]{2,}/', ' ', trim($_REQUEST['name']));
	if (strlen($name) == 0) // поле имя не должно быть пустым
	{
		$error['order-name'] = 'заполните ваше имя';
		$status = false;
	}

	// Телефон (order-phone)
	$phone = $_REQUEST['phone'];
	if (strlen($phone) == 0) // поле телефон не должно быть пустым
	{
		$error['order-phone'] = 'заполните телефон для связи с вами';
		$status = false;
	}
	if (!preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', $phone) &&
		!array_key_exists('order-phone', $error)) // телефон должен быть по маске
	{
		$error['order-phone'] = 'некорректный номер телефона';
		$status = false;
	}

	// Дата для связи (order-date)
	$date = $_REQUEST['date'];

	// Комментарий к заказу (order-comment)
	$comment = $_REQUEST['comment'];

	// Уточнить цену
	$cost = ($_REQUEST['cost'] == "true") ? true : false;

	// Капча (order-captcha)
	$captcha = $_REQUEST['captcha'];
	if (strlen($captcha) == 0) // каптча не должна быть пустой
	{
		$error['order-captcha'] = 'введите код';
		$status = false;
	}
	if ($captcha != $_SESSION['cap'] &&
	    !array_key_exists('order-captcha', $error)) // каптча должна совпадать
	{
		$error['order-captcha'] = 'код не совпадает';
		$status = false;
	}

	// Валидация пройдена
	if ($status)
	{
		unset($_SESSION['cap']);
		include_once('../sender.php');
		$br = "\r\n";
		$mailbody  = $subject.$br.$br;
		$mailbody .= 'Имя отправителя: '.$name.$br;
		$mailbody .= 'Телефон отправителя: '.$phone.$br;
		$mailbody .= (strlen($date) > 0) ? 'Удобное время: '.$date.$br.$br : $br;
		$mailbody .= (strlen($comment) > 0) ? 'Коментарий:'.$br.$comment.$br.$br : $br;
		if ($cost)
			$mailbody .= '* Уточнить цену с заказчиком';
		sendEmail('Robot','robot@td-interstroy.ru','site@uptc.ru','Заявка с сайта',$mailbody);
	}

	$json_array = array('status'=>$status, 'error'=>$error);
	echo json_encode($json_array);
}