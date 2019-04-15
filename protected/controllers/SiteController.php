<?php

class SiteController extends Controller
{
	public function actionIndex()
	{
		$this->mainMenuFlag = 'index';

		$cs = Yii::app()->clientScript;
		// Подключаем внешние файлы скриптов
		$cs->registerScriptFile('/js/jquery.hover.zoom.js', CClientScript::POS_END);
		// Подключаем внутренний скрипт
		$cs->registerScript('loading', '
			var src = \'\';
			$(\'div.hoverme\').find(\'img:first\').each(function() {
				src = $(this).attr(\'src\');
				$(this).attr(\'src\', src + \'?\' + new Date().getTime());
			});
			$(\'div.hoverme\').hoverZoom({
				zoom: 50,
				overlayColor: \'#541dfd\',
				overlayOpacity: 0.7
			});
			$(\'div.cell\').hover(
				function() {
					$(this).find(\'div.title\').find(\'a\').css(\'text-decoration\',\'underline\');
				},
				function() {
					$(this).find(\'div.title\').find(\'a\').css(\'text-decoration\',\'none\');
				}
			);
		', CClientScript::POS_READY);

		$categories_img = array();

		// Мини категория (root categories)
		$criteria = new CDbCriteria;
		$criteria->select = 't.id_category, t.name, t.url, cl.name as name_lang';
		$criteria->join = 'left join {{categories_lang}} cl on cl.id_category=t.id_category and cl.lang="'.Yii::app()->getLanguage().'"';
		$criteria->condition = 't.id_root=0 and t.`status`=0';
		$criteria->order = 't.sort_order';
		$categories = Categories::model()->findAll($criteria);

		// Определяем диапазон айдишников
		$ids = '(';
		foreach ($categories as $cat)
			$ids .= $cat->id_category.',';
		$ids = rtrim($ids,',');
		$ids .= ')';

		// Картинки категорий
		$criteria = new CDbCriteria;
		$criteria->select = 't.id_image, t.id_category, t.name, t.ext, t.title, t.alt, il.title as title_lang, il.alt as alt_lang';
		$criteria->join = 'left join {{images_lang}} il on il.id_image=t.id_image and il.lang="'.Yii::app()->getLanguage().'"';
		$criteria->condition = 't.id_category in '.$ids;
		$criteria->order = 't.id_category, t.sort_order, t.id_image';
		$cats_img = Images::model()->findAll($criteria);
		foreach ($cats_img as $img)
		{
			$categories_img[$img->id_category][] = array(
				'id_image'=>$img->id_image,
				'name'=>$img->name,
				'ext'=>$img->ext,
				'title'=>$img->title,
				'alt'=>$img->alt,
				'title_lang'=>$img->title_lang,
				'alt_lang'=>$img->alt_lang,
			);
		}
		unset($ids);
		unset($cats_img); // чистим мусор, ибо не пригодится более

		// Последние новости
		$criteria = new CDbCriteria;
		$criteria->condition = '`status` = 0';
		$criteria->order = 'adate desc';
		$criteria->limit = 2;
		$news = News::model()->findAll($criteria);

		$this->render('index',array(
			'categories'=>$categories,
			'images'=>$categories_img,
			'cnt'=>count($categories),
			'news'=>$news,
		));
	}

	public function actionCatalog()
	{
		$this->mainMenuFlag = 'catalog';

		$cs = Yii::app()->clientScript;
		// Подключаем внутренний скрипт
		$cs->registerScript('loading', '
			$(\'div.slide\').hide();
			$(\'a.hide-all\').click(function() {
				$(\'div.slide\').slideDown(\'fast\');
			});
			$(\'a.show-all\').click(function() {
				$(\'div.slide\').slideUp(\'fast\');
			});
			$(\'div.image-box\').click(function() {
				$(this).parent(\'div.cell\').find(\'div.slide\').slideToggle(\'fast\');
				return false;
			});
		', CClientScript::POS_READY);

		$left = $right = $subcategories = $categories_img = array();

		// Корневые категории и подкатегории
		$categories = Yii::app()->db->createCommand()
					->select('t.id_category, t.name, cl1.name as name_lang, t.url, c2.id_category as sub_id, c2.name as sub_name, cl2.name as sub_name_lang, c2.url as sub_url, c2.flag as sub_flag')
					->from('{{categories}} t')
					->leftJoin('{{categories}} c2', 'c2.id_parent = t.id_category and c2.`status`=0')
					->leftJoin('{{categories_lang}} cl1', 'cl1.id_category=t.id_category and cl1.lang="'.Yii::app()->getLanguage().'"')
					->leftJoin('{{categories_lang}} cl2', 'cl2.id_category=c2.id_category and cl2.lang="'.Yii::app()->getLanguage().'"')
					->where('t.id_root=0 and t.`status`=0')
					->order('t.sort_order, t.name, c2.sort_order, c2.name')
					->queryAll();

		// Определяем диапазон айдишников
		$ids = '(';
		$prev_id = 0;
		foreach ($categories as $cat)
		{
			if ($prev_id != $cat['id_category'])
			{
				$ids .= $cat['id_category'].',';
				$prev_id = $cat['id_category'];
			}
		}
		$ids = rtrim($ids,',');
		$ids .= ')';

		// Картинки категорий
		$criteria = new CDbCriteria;
		$criteria->select = 't.id_image, t.id_category, t.name, t.ext, t.title, t.alt, il.title as title_lang, il.alt as alt_lang';
		$criteria->join = 'left join {{images_lang}} il on il.id_image=t.id_image and il.lang="'.Yii::app()->getLanguage().'"';
		$criteria->condition = 't.id_category in '.$ids;
		$criteria->order = 't.id_category, t.sort_order, t.id_image';
		$cats_img = Images::model()->findAll($criteria);
		foreach ($cats_img as $img)
		{
			$categories_img[$img->id_category][] = array(
				'id_image'=>$img->id_image,
				'name'=>$img->name,
				'ext'=>$img->ext,
				'title'=>$img->title,
				'alt'=>$img->alt,
				'title_lang'=>$img->title_lang,
				'alt_lang'=>$img->alt_lang,
			);
		}
		unset($ids);
		unset($cats_img); // чистим мусор, ибо не пригодится более

		// Заранее формируем левую и правую часть контента
		$prev_id = 0;
		$is_left = true;
		foreach ($categories as $cat)
		{
			if ($prev_id != $cat['id_category'])
			{
				$tmp_array = array(
					'id_category'=>$cat['id_category'],
					'name'=>$cat['name'],
					'name_lang'=>$cat['name_lang'],
					'url'=>$cat['url'],
					'is_flag'=>($cat['id_category'] == 1847 || $cat['id_category'] == 1848) ? true : false,
				);
				if ($is_left)
					$left[] = $tmp_array;
				else
					$right[] = $tmp_array;
				$is_left = !$is_left;
				$prev_id = $cat['id_category'];
			}

			if ($cat['sub_id'] !== null)
			{
				$subcategories[$cat['id_category']][] = array(
					'id_category'=>$cat['sub_id'],
					'name'=>$cat['sub_name'],
					'name_lang'=>$cat['sub_name_lang'],
					'url'=>$cat['sub_url'],
					'flag'=>$cat['sub_flag'],
				);
			}
		}

		unset($tmp_array);
		unset($categories); // чистим мусор, ибо не пригодится более

		$this->render('catalog',array(
			'left'=>$left,
			'right'=>$right,
			'subcategories'=>$subcategories,
			'images'=>$categories_img,
		));
	}

	public function actionContact()
	{
		$this->mainMenuFlag = 'contact';

		$cs = Yii::app()->clientScript;
		// Подключаем внешние файлы скриптов
		$cs->registerCssFile('/css/bootstrap.form.css', 'screen');

		$model = new ContactForm;
		if (isset($_POST['ContactForm']))
		{
			$model->attributes = $_POST['ContactForm'];
			if ($model->validate())
			{
				$br = "\r\n";
				// Формируем тело письма
				$mailbody  = 'Имя: '.$model->name.$br;
				$mailbody .= 'Email: '.$model->email.$br.$br;
				$mailbody .= $model->body;

				// Определяем данные письма
				$par = array(
					'name'=>array('Имя',$model->name),     // имя отправителя
					'email'=>array('E-mail',$model->email) // телефон отправителя
				);

				// Записываем в БД данные для отправки письма
				$mails = new Mails();
				$mails->from_name = 'Robot silver96';
				$mails->mailto = 'info@silver96.ru';
				$mails->replyto = 'robot@silver96.ru';
				$mails->title = 'Сообщение со страницы контактов';
				$mails->message = $mailbody;
				$mails->params = json_encode($par,JSON_UNESCAPED_UNICODE);
				$mails->type = 1;
				$mails->hash = '';
				$mails->sended = 0;
				$mails->error = '';
				$mails->adate = date('Y-m-d H:i:s');
				$mails->sdate = null;
				if ($mails->save(false))
				{
					$mails->hash = $mails->getPrimaryKey().'-'.md5($mails->getPrimaryKey().$d);
					$mails->save(false);
				}

				// Запускаем параллельный скрипт, который отправит письмо
				$arg = Functions::prepareArguments(array(
					'id'=>$mails->getPrimaryKey()
				));
				$console = new TConsoleRunner('console.php');
				$console->run('mailer send'.$arg);

				// Письмо отправленно
				Yii::app()->user->setFlash('contacted','Письмо отправлено. Спасибо, что написали нам, мы ответим Вам в ближайшее время.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}


}