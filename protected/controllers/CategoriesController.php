<?php

class CategoriesController extends Controller
{
	public function actionView($id, $url)
	{
		$this->mainMenuFlag = 'catalog';

		$category = $category_img = $categories = $nodes = $pager = $root = null;
		$categories_img = $nodes_img = array();

		/**
		* Категория
		**/
		$criteria = new CDbCriteria;
		$criteria->select = 't.*, cl.name as name_lang, cl.content as content_lang, cl.description as description_lang, cl.title_seo as title_seo_lang, cl.desc_seo as desc_seo_lang, cl.key_seo as key_seo_lang';
		$criteria->join = 'left join {{categories_lang}} cl on cl.id_category=t.id_category and cl.lang="'.Yii::app()->getLanguage().'"';
		$criteria->condition = 't.id_category=:cid and t.url=:u and t.`status`=0';
		$criteria->params = array(':cid'=>$id,':u'=>$url);
		$category = Categories::model()->find($criteria);
		if (!$category)
			throw new CHttpException(404);

		// Картинки категории
		$criteria = new CDbCriteria;
		$criteria->select = 't.id_image, t.name, t.ext, t.title, t.alt, il.title as title_lang, il.alt as alt_lang';
		$criteria->join = 'left join {{images_lang}} il on il.id_image=t.id_image and il.lang="'.Yii::app()->getLanguage().'"';
		$criteria->condition = 't.id_category=:catid';
		$criteria->params = array(':catid'=>$id);
		$criteria->order = 't.sort_order, t.id_image';
		$category_img = Images::model()->findAll($criteria);
		// ====================================================================

		/**
		* Root категория, если таковая есть
		**/
		if ($category->id_root > 0)
			$root = Categories::model()->findByPk($category->id_root);
		// ====================================================================

		/**
		* Стандартные SQL запросы
		**/
		if ($category->is_special_query == 0)
		{
			/**
			* Прикрепленные категории
			**/
			$criteria = new CDbCriteria;
			$criteria->select = 't.*, cl.name as name_lang, cl.content as content_lang, cl.description as description_lang, cl.title_seo as title_seo_lang, cl.desc_seo as desc_seo_lang, cl.key_seo as key_seo_lang';
			$criteria->join = 'left join {{categories_lang}} cl on cl.id_category=t.id_category and cl.lang="'.Yii::app()->getLanguage().'"';
			$criteria->condition = 't.id_parent=:cid and t.`status`=0';
			$criteria->params = array(':cid'=>$id);
			$criteria->order = 't.sort_order, t.id_category';
			$categories = Categories::model()->findAll($criteria);
			if ($categories)
			{
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
				unset($cats_img); // чистим мусор, ибо не пригодится более
			}
			// ====================================================================

			/**
			* Если категория является каталогом,
			* то загружаем прикрепленные страницы
			**/
			if ($category->is_catalog == 1)
			{
				$criteria = new CDbCriteria;
				$criteria->select = 't.*, nl.name as name_lang, nl.content as content_lang, nl.description as description_lang, nl.attr as attr_lang, nl.title_seo as title_seo_lang, nl.desc_seo as desc_seo_lang, nl.key_seo as key_seo_lang';
				$criteria->join = 'left join {{nodes_lang}} nl on nl.id_node=t.id_node and nl.lang="'.Yii::app()->getLanguage().'"';
				$criteria->condition = 't.id_category=:cid and t.`status`=0';
				$criteria->params = array(':cid'=>$id);
				$criteria->order = 't.sort_order, t.id_node';
				// Пагинатор
				$pager = new CPagination(Nodes::model()->count($criteria));
				$pager->pageSize = NodeTypes::getPagesCntByCategory($id);
				$pager->applyLimit($criteria);
				$nodes = Nodes::model()->findAll($criteria);

				if ($nodes)
				{
					// Определяем диапазон айдишников
					$ids = '(';
					foreach ($nodes as $node)
						$ids .= $node->id_node.',';
					$ids = rtrim($ids,',');
					$ids .= ')';

					$criteria = new CDbCriteria;
					$criteria->select = 't.id_image, t.id_node, t.name, t.ext, t.title, t.alt, il.title as title_lang, il.alt as alt_lang';
					$criteria->join = 'left join {{images_lang}} il on il.id_image=t.id_image and il.lang="'.Yii::app()->getLanguage().'"';
					$criteria->condition = 't.id_node in '.$ids;
					$criteria->order = 't.id_node, t.sort_order, t.id_image';
					$nod_img = Images::model()->findAll($criteria);

					foreach ($nod_img as $img)
					{
						$nodes_img[$img->id_node][] = array(
							'id_image'=>$img->id_image,
							'name'=>$img->name,
							'ext'=>$img->ext,
							'title'=>$img->title,
							'alt'=>$img->alt,
							'title_lang'=>$img->title_lang,
							'alt_lang'=>$img->alt_lang,
						);
					}
					unset($nod_img); // чистим мусор, ибо не пригодится более
					unset($ids);
				}
			}
			// ====================================================================

			if ($category->view == 'default')
			{
				// Определяем тип категории
				// through - сквазная, узел
				// catalog - каталог (со страницами)
				// throughCatalog - сквазная со страницами
				// empty - заглушка (ничего не прикреплено)
				if ($categories && $nodes) // throughCatalog
					$view = 'throughCatalog';
				elseif ($categories && !$nodes) // through
					$view = 'through';
				elseif (!$categories && $nodes) // catalog
					$view = 'catalog';
				else // empty
					$view = 'empty';
				$view .= '/default';
			}
			else
				$view = $category->view;

			$this->render('//categories/'.$view, array(
				'breadcrumbs'=>Categories::getCategoriesBreadcrumbs($id),
				'category'=>$category,
				'category_img'=>$category_img,
				'categories'=>$categories,
				'categories_img'=>$categories_img,
				'nodes'=>$nodes,
				'nodes_img'=>$nodes_img,
				'pager'=>$pager,
				'root'=>$root,
			));
		}
		/**
		* Измененые SQL запросы
		**/
		else
		{
			$this->render('//categories/'.$category->view, array(
				'breadcrumbs'=>Categories::getCategoriesBreadcrumbs($id),
				'category'=>$category,
				'category_img'=>$category_img,
				'root'=>$root,
			));
		}
	}
}