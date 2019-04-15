<?php

class OrderController extends Controller
{
	public function actionIndex()
	{
		$this->mainMenuFlag = 'order';

		$cs = Yii::app()->clientScript;
		// Подключаем внешние файлы скриптов
		$cs->registerCssFile('/css/bootstrap.form.css', 'screen');
		$cs->registerScriptFile('/js/jquery.simplemodal.1.4.4.min.js', CClientScript::POS_END);
		$cs->registerScriptFile('/js/jquery.maskedinput.min.js', CClientScript::POS_END);
		$cs->registerScriptFile('/js/jquery.numberMask.min.js', CClientScript::POS_END);
		$cs->registerScriptFile('/js/jquery.stickr.min.js', CClientScript::POS_END);
		$cs->registerScriptFile('/js/modal.js', CClientScript::POS_END);
		// Подключаем внутренний скрипт
		$cs->registerScript('loading', '
			$(\'#Orders_phone\').mask(\'+7 (999) 999-9999\');
		', CClientScript::POS_READY);

		// Windows
		$this->pageWindows = '
		<div id="confirm-modal" class="modalbox">
			<div class="header">
				<div id="confirm-title" class="title"></div>
				<a href="javascript://" class="modal-close close-modal-x" rel="nofollow" title="закрыть"></a>
			</div>
			<div class="body">
				<p id="confirm-message"></p>
			</div>
			<div class="footer">
				<div class="pull-left yes"><a href="javascript://" id="confirm-ok" class="btn btn-orange button70" rel="nofollow">Да</a></div>
				<div class="pull-left no"><a href="javascript://" class="btn button70 modal-close" rel="nofollow">Нет</a></div>
			</div>
		</div><!-- /confirm-modal -->
		';

		$basketList = Yii::app()->ShoppingCart->getShoppingList();

		$model = new Orders;
		if (isset($_POST['Orders']) && $basketList)
		{
			$model->attributes = $_POST['Orders'];
			// Формируем список заказанной продукции
			$products = array();
			$ids = '(';
			foreach ($basketList as $blist)
			{
				$products[$blist['id']] = array(
					$blist['name'],
					$blist['count']
				);
				$ids .= $blist['id'].',';
			}
			$ids = rtrim($ids,',').')';
			$model->products = json_encode($products,JSON_UNESCAPED_UNICODE);

			if ($model->save())
			{
				// Формируем тело письма - уведомления о заказе
				$br = "\r\n";
				$mailbody = 'Имя заказчика: '.$model->name.$br;
				$mailbody .= 'Номер заказчика: '.$model->phone.$br;
				if ($model->email != '')
					$mailbody .= 'E-mail заказчика: '.$model->email.$br;
				$mailbody .= $br.'Список товаров:'.$br;
				foreach ($basketList as $blist)
				{
					$mailbody .= $blist['name'].' | '.$blist['count'].' шт.'.$br;
				}
				$mailbody .= $br.'Дата заказа: '.date('Y-m-d H:i:s');

				// Определяем данные письма
				$par = array(
					'ids'=>array('Идентификаторы заказанных товаров',$ids), // идентификаторы товаров
					'name'=>array('Имя',$model->name),      // имя отправителя
					'phone'=>array('Телефон',$model->phone) // телефон отправителя
				);

				// Записываем в БД данные для отправки уведомления
				$mails = new Mails();
				$mails->from_name = 'Robot silver96';
				$mails->mailto = 'order@silver96.ru';
				$mails->replyto = 'robot@silver96.ru';
				$mails->title = 'Заказ из корзины';
				$mails->message = $mailbody;
				$mails->params = json_encode($par,JSON_UNESCAPED_UNICODE);
				$mails->type = 3;
				$mails->hash = '';
				$mails->sended = 0;
				$mails->error = '';
				$mails->adate = $model->adate;
				$mails->sdate = null;
				if ($mails->save(false))
				{
					$mails->hash = $mails->getPrimaryKey().'-'.md5($mails->getPrimaryKey().$model->adate);
					$mails->save(false);
				}

				// Запускаем параллельный скрипт, который отправит письмо
				$arg = Functions::prepareArguments(array(
					'id'=>$mails->getPrimaryKey()
				));
				$console = new TConsoleRunner('console.php');
				$console->run('mailer send'.$arg);

				// Заявка отправленна
				Yii::app()->ShoppingCart->clear();
				Yii::app()->user->setFlash('sended','Заявка отправлена. Мы ответим Вам в ближайшее время.');
				$this->refresh();
			}
		}

		$this->render('index', array(
			'model'=>$model,
			'basketList'=>$basketList,
		));
	}

	public function actionDelete($id)
	{
		Yii::app()->ShoppingCart->delFromBasket($id);
		$this->redirect('/order/index');
	}

	public function actionClear()
	{
		Yii::app()->ShoppingCart->clear();
		$this->redirect('/order/index');
	}
}