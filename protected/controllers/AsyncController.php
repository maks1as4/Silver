<?php

class AsyncController extends Controller
{
	public function actionCaptcha()
	{
		$captchastring = '1234567890';
		$captchastring = substr(str_shuffle($captchastring), 0, 5);

		Yii::app()->session->add('code', $captchastring);

		$image = imagecreatefrompng('images/captchabg.png');
		$colour = imagecolorallocate($image, 130, 130, 130);
		$font = 'fonts/smb2.ttf';
		$rotate = rand(-7, 7);
		imagettftext($image, 18, $rotate, 10, 35, $colour, $font, $captchastring);
		header('Content-type: image/png');
		imagepng($image);
	}

	public function actionVerifyOrderModal()
	{
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
		{
			$status = true; // по умолчанию проверка пройдена
			$error = array();

			// Валидация формы
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

			// Комментарий к заказу (order-comment)
			$comment = $_REQUEST['comment'];

			// Капча (order-captcha)
			$captcha = $_REQUEST['captcha'];
			if (strlen($captcha) == 0) // каптча не должна быть пустой
			{
				$error['order-captcha'] = 'введите код';
				$status = false;
			}
			if ($captcha != Yii::app()->session->get('code') && 
			    !array_key_exists('order-captcha', $error)) // каптча должна совпадать
			{
				$error['order-captcha'] = 'код не совпадает';
				$status = false;
			}

			// Валидация пройдена
			if ($status)
			{
				Yii::app()->session->add('code', null);
				$br = "\r\n";
				$d = date('Y-m-d H:i:s');

				// Получаем зашифрованные данные и получаем данные о товаре из БД
				$pid = Functions::xorCoding(base64_decode($_REQUEST['tab']), Yii::app()->params['xorPassword']); // id товара
				$node = Nodes::model()->findByPk($pid);
				$pname = ($node) ? $node->name : '--нет--';

				// Формируем тело письма
				$mailbody  = 'Интересуемый товар: "'.$pname.'" [ id='.$pid.' ]'.$br.$br;
				$mailbody .= 'Имя отправителя: '.$name.$br;
				$mailbody .= 'Телефон отправителя: '.$phone;
				if (strlen($comment) > 0)
					$mailbody .= $br.$br.'Коментарий:'.$br.$comment;

				// Определяем данные письма
				$par = array(
					'id'=>array('id товара',$pid),   // идентификатор товара
					'tovar'=>array('Товар',$pname),  // наименование товара
					'name'=>array('Имя',$name),      // имя отправителя
					'phone'=>array('Телефон',$phone) // телефон отправителя
				);

				// Записываем в БД данные для отправки
				$model = new Mails();
				$model->from_name = 'Robot silver96';
				$model->mailto = 'order@silver96.ru';
				$model->replyto = 'robot@silver96.ru';
				$model->title = 'Быстрый заказ с сайта';
				$model->message = $mailbody;
				$model->params = json_encode($par,JSON_UNESCAPED_UNICODE);
				$model->type = 2;
				$model->hash = '';
				$model->sended = 0;
				$model->error = '';
				$model->adate = $d;
				$model->sdate = null;
				if ($model->save(false))
				{
					$model->hash = $model->getPrimaryKey().'-'.md5($model->getPrimaryKey().$d);
					$model->save(false);
				}

				// Запускаем параллельный скрипт, который отправит письмо
				$arg = Functions::prepareArguments(array(
					'id'=>$model->getPrimaryKey()
				));
				$console = new TConsoleRunner('console.php');
				$console->run('mailer send'.$arg);
			}

			$json_array = array('status'=>$status, 'error'=>$error);
			echo json_encode($json_array);
		}
		else
			throw new CHttpException(404);
	}

	public function actionVerifyPutIn()
	{
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
		{
			$status = true; // по умолчанию проверка пройдена
			$content = 'Корзина';

			// Получаем и проверяем идентификатор товара
			$pid = Functions::xorCoding(base64_decode($_REQUEST['tab']), Yii::app()->params['xorPassword']);
			$node = Nodes::model()->findByPk($pid);
			if (!$node || $node->price == 0)
				$status = false;

			// Колличество товара
			$cnt = $_REQUEST['cnt'];
			if (!is_int($cnt) && $cnt <= 0)
				$status = false;

			// Вадидация пройдена
			if ($status)
			{
				Yii::app()->ShoppingCart->put($node, $cnt);
				if (Yii::app()->ShoppingCart->count_in_basket > 0)
					$content = 'Корзина<span class="badge badge-important badge-basket">'.Yii::app()->ShoppingCart->count_in_basket.'</span>';
			}

			$json_array = array('status'=>$status, 'content'=>$content);
			echo json_encode($json_array);
		}
		else
			throw new CHttpException(404);
	}

	public function actionDeleteBasketItem()
	{
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
		{
			$status = true; // по умолчанию проверка пройдена

			$id = $_REQUEST['item'];
			if (Yii::app()->ShoppingCart->isset_in_basket($id))
				Yii::app()->ShoppingCart->delFromBasket($id);
			else
				$status = false;

			$json_array = array('status'=>$status);
			echo json_encode($json_array);
		}
		else
			throw new CHttpException(404);
	}

	public function actionDeleteBasketItems()
	{
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
		{
			$status = true; // по умолчанию проверка пройдена

			if (Yii::app()->ShoppingCart->getShoppingList())
				Yii::app()->ShoppingCart->clear();
			else
				$status = false;

			$json_array = array('status'=>$status);
			echo json_encode($json_array);
		}
		else
			throw new CHttpException(404);
	}
}