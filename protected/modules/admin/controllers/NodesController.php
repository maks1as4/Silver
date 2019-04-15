<?php

class NodesController extends Controller
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
				'actions'=>array('create', 'update', 'delete', 'attrChange'),
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
		$model=new NodesControl;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['NodesControl']))
		{
			$model->attributes=$_POST['NodesControl'];
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

		if(isset($_POST['NodesControl']))
		{
			$model->attributes=$_POST['NodesControl'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
			'modelAttr'=>AttributeTypesControl::model()->findAll('id_node_type=:ntid',array(':ntid'=>$model->nodeType->id_node_type)),
		));
	}

	public function actionAttrChange($id,$translit)
	{
		$model = $this->loadModel($id);
		$modelAttr = AttributeTypesControl::model()->find('id_node_type=:ntid and translit=:tr',array(':ntid'=>$model->nodeType->id_node_type,':tr'=>$translit));
		if ($modelAttr===null)
			throw new CHttpException(404,'The requested page does not exist.');

		$attr = json_decode($model->attr,true,JSON_UNESCAPED_UNICODE);

		$validModel = new AttrChangeControl;
		if (isset($attr[$modelAttr->translit]) && !empty($attr[$modelAttr->translit][0]))
			$validModel->attr = $attr[$modelAttr->translit][0];

		if (isset($_POST['AttrChangeControl']))
		{
			$validModel->attr = $_POST['AttrChangeControl']['attr'];
			switch ($modelAttr->type)
			{
				case 0: {$validModel->setScenario('string'); break;} // string
				case 1: {$validModel->setScenario('integer'); break;} // integer
				case 2: {$validModel->setScenario('decimal'); break;} // decimal
				case 3: {$validModel->setScenario('boolean'); break;} // boolean
				case 4: {$validModel->setScenario('link'); break;} // link
				case 5: {$validModel->setScenario('enum'); break;} // enum
				case 6: {$validModel->setScenario('image'); break;} // image
				case 7: {$validModel->setScenario('file'); break;} // file
				case 8: {$validModel->setScenario('date'); break;} // date
				default:
					throw new CHttpException(404,'The requested attribute type not exist.');
			}

			if ($validModel->validate())
			{
				if (strlen($validModel->attr) > 0)
				{
					$attr[$modelAttr->translit][0] = $validModel->attr;
					$attr[$modelAttr->translit][1] = $modelAttr->name;
					$attr[$modelAttr->translit][2] = $modelAttr->id_attribute_type;
				}
				else
				{
					if (isset($attr[$modelAttr->translit]))
						unset($attr[$modelAttr->translit]);
				}

				$json_attr = json_encode($attr,JSON_UNESCAPED_UNICODE);
				$model->attr = $json_attr;
				if ($model->save(false))
				{
					Yii::app()->user->setFlash('success','Значение успешно сохранено.');
					$this->refresh();
				}
			}
		}

		$this->render('attrChange',array(
			'validModel'=>$validModel,
			'model'=>$model,
			'modelAttr'=>$modelAttr,
			'attr'=>$attr,
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
		$model=new NodesControl('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['NodesControl']))
			$model->attributes=$_GET['NodesControl'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return NodesControl the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=NodesControl::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param NodesControl $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='nodes-control-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
