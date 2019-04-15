<?php

class NewsController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl',
			'postOnly + delete',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index', 'view'),
				'roles'=>array(Users::ROLE_MODER),
			),
			array('allow',
				'actions'=>array('create', 'update', 'delete', 'deleteImage'),
				'roles'=>array(Users::ROLE_ADMIN),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new NewsControl;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['NewsControl']))
		{
			$model->attributes=$_POST['NewsControl'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['NewsControl']))
		{
			$model->attributes=$_POST['NewsControl'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new NewsControl('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['NewsControl']))
			$model->attributes=$_GET['NewsControl'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionDeleteImage($id)
	{
		$model = $this->loadModel($id);
		$types = NewsControl::getImageTypes();
		chmod(Yii::getPathOfAlias(NewsControl::IMAGES_DIR).DIRECTORY_SEPARATOR,0777); // открываем папку для записи
		foreach ($types as $type)
		{
			$imgPath = Yii::getPathOfAlias(NewsControl::IMAGES_DIR).DIRECTORY_SEPARATOR.$model->image.'_'.$type.'.'.$model->ext;
			if (is_file($imgPath) && $model->image != '')
			{
				chmod($imgPath,0777); // открываем сохраненый файл для записи
				unlink($imgPath);
			}
		}
		chmod(Yii::getPathOfAlias(NewsControl::IMAGES_DIR).DIRECTORY_SEPARATOR,0555); // закрываем папку от записи
		$model->image = '';
		$model->ext = '';
		if ($model->save(false))
			Yii::app()->user->setFlash('deleteImage','Картинка была успешно удалена.');
		$this->redirect(array('update','id'=>$id));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return NewsControl the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=NewsControl::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param NewsControl $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-control-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
