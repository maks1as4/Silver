<?php

class NewsController extends Controller
{
	public function actionIndex()
	{
		$this->mainMenuFlag = 'news';
		
		$criteria = new CDbCriteria;
		$criteria->condition = '`status`=0';
		$criteria->order = 'adate desc';

		// Пагинатор
		$pager = new CPagination(News::model()->count($criteria));
		$pager->pageSize = 30;
		$pager->applyLimit($criteria);

		$news = News::model()->findAll($criteria);

		$this->render('index',array(
			'news'=>$news,
			'pager'=>$pager,
		));
	}

	public function actionView($id, $url)
	{
		$news = News::model()->find('id_news=:nid and url=:u and `status`=0',array(':nid'=>$id,':u'=>$url));
		if (!$news)
			throw new CHttpException(404);

		$this->render('view',array(
			'news'=>$news,
		));
	}
}