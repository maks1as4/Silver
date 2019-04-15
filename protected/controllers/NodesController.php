<?php

class NodesController extends Controller
{
	public function actionView($id, $url)
	{
		$this->mainMenuFlag = 'catalog';

		$cs = Yii::app()->clientScript;
		// Подключаем внешние файлы скриптов
		$cs->registerCssFile('/css/bootstrap.form.css', 'screen');
		$cs->registerScriptFile('/js/jquery.simplemodal.1.4.4.min.js', CClientScript::POS_END);
		$cs->registerScriptFile('/js/jquery.maskedinput.min.js', CClientScript::POS_END);
		$cs->registerScriptFile('/js/jquery.numberMask.min.js', CClientScript::POS_END);
		$cs->registerScriptFile('/js/jquery.stickr.min.js', CClientScript::POS_END);
		$cs->registerScriptFile('/js/modal.js', CClientScript::POS_END);

		// Windows
		$this->pageWindows = '
		<div id="order-modal" class="modalbox">
			<div class="header">
				<div class="title">Быстрый заказ</div>
				<a href="javascript://" class="modal-close close-modal-x" rel="nofollow" title="закрыть"></a>
			</div>
			<div class="body">
				<div id="order-name" class="row-modal">
					<span class="title">Ваше имя:</span><span class="field-required">*</span><span class="error-message-modal"></span><br />
					<input type="text" class="edit edit300 mod" maxlength="100" />
				</div>
				<div id="order-phone" class="row-modal">
					<span class="title">Телефон для связи:</span><span class="field-required">*</span><span class="error-message-modal"></span><br />
					<input type="text" class="edit edit300 mod" maxlength="20" />
				</div>
				<div id="order-comment" class="row-modal">
					<span class="title">Комментарий к заказу:</span><br />
					<textarea class="memo memo445x200 error mod"></textarea>
				</div>
				<div id="order-captcha" class="row-modal">
					<span class="title">Введите код с картинки:</span><span class="field-required">*</span><span class="error-message-modal"></span><br />
					<input type="text" class="edit edit200 mod" maxlength="5" />
					<div class="captcha-outer">
						<img src="/async/captcha" />&nbsp;&nbsp;
						<a href="javascript://" id="order-refresh" class="btn" rel="nofollow"><i class="icon-repeat"></i>&nbsp;обновить</a>
					</div>
				</div>
			</div>
			<div class="footer">
				<div class="pull-left"><a href="javascript://" id="order-ok" class="btn btn-orange" rel="nofollow">Отправить</a></div>
				<div class="pull-left close-outer"><a href="javascript://" class="modal-close close-modal-c" rel="nofollow">закрыть</a></div>
			</div>
		</div><!-- /order-modal -->
		';

		$node = $node_img = array();

		// Страница
		$criteria = new CDbCriteria;
		$criteria->select = 't.*, nt.`view`, nl.name as name_lang, nl.content as content_lang, nl.description as description_lang, nl.attr as attr_lang, nl.title_seo as title_seo_lang, nl.desc_seo as desc_seo_lang, nl.key_seo as key_seo_lang';
		$criteria->join = 'join {{node_types}} nt on nt.id_node_type=t.id_node_type ';
		$criteria->join .= 'left join {{nodes_lang}} nl on nl.id_node=t.id_node and nl.lang="'.Yii::app()->getLanguage().'"';
		$criteria->condition = 't.id_node=:nid and t.url=:u and t.`status`=0';
		$criteria->params = array(':nid'=>$id,':u'=>$url);
		$node = Nodes::model()->find($criteria);
		if (!$node)
			throw new CHttpException(404);

		// Картинки страницы
		$criteria = new CDbCriteria;
		$criteria->select = 't.id_image, t.name, t.ext, t.title, t.alt, il.title as title_lang, il.alt as alt_lang';
		$criteria->join = 'left join {{images_lang}} il on il.id_image=t.id_image and il.lang="'.Yii::app()->getLanguage().'"';
		$criteria->condition = 't.id_node=:nid';
		$criteria->params = array(':nid'=>$id);
		$criteria->order = 't.sort_order, t.id_image';
		$node_img = Images::model()->findAll($criteria);

		$this->render($node->view, array(
			'breadcrumbs'=>Categories::getCategoriesNodeBreadcrumbs($node['id_category'], $node['name']),
			'attr'=>($node['attr'] != '') ? json_decode($node['attr'],true,JSON_UNESCAPED_UNICODE) : array(),
			'node'=>$node,
			'node_img'=>$node_img,
		));
	}
}