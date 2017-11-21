<?php

class OutboxController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','admin','delete','create','update','sent','sendMessage','instant','ajaxInstant','deleteSent','removeSent'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionRemoveSent()
	{
		if(Yii::app()->request->getIsAjaxRequest())
        {
            $checkedIDs=$_GET['checked'];
            foreach($checkedIDs as $id){
            	$model = Sentitems::model()->findByAttributes(array('ID'=>$id));
            	$model->delete();
            }
                    
        }
	}

	public function actionDeleteSent($id)
	{
		$model = Sentitems::model()->findByAttributes(array('ID'=>$id));
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}


	public function actionInstant($id='')
	{
		$model=new Outbox;

		if(!empty($id))
		{
			$inbox = Inbox::model()->findByPk($id);
			$model->DestinationNumber = $inbox->SenderNumber; 
		}

		$this->render('instant',array(
			'model'=>$model,
		));
	}

	public function actionAjaxInstant()
	{
		if(Yii::app()->request->isAjaxRequest)
		{

			// print_r($_POST['phones']);exit;
			if(isset($_POST['phones']))
			{

				$phones = $_POST['phones'];
				$message = $_POST['message'];

				foreach($phones as $phone)
				{
					$outbox = new Outbox;
					$outbox->DestinationNumber = $phone;
					$outbox->TextDecoded = $message;
					$outbox->save();
				}
				

				$response = array(
					'status' => 'Pesan Terkirim',
					// 'message' => $_POST['kontak']
				);

				echo json_encode($response);	
			}
		}
	}

	public function actionSendMessage()
	{
		if(Yii::app()->request->isAjaxRequest)
		{

			if(isset($_POST['data']))
			{

				$data = $_POST['data'];

				$data = explode('#', $data);

				// Send kontak
				if(!empty($data[0]))
				{
					$k = $data[0];
					$k = explode(',', $k);
				// print_r($k);exit;
					foreach($k as $d)
					{

						$kontak = Kontak::model()->findByPk($d);

						if(!empty($kontak))
						{
							$outbox = new Outbox;
							$outbox->DestinationNumber = $kontak->contact_phone;
							$outbox->TextDecoded = $_POST['msg'];
							$outbox->save();
						}
					}	

				}

				// send grup
				if(!empty($data[1]))
				{

					$k = $data[1];
					$k = explode(',', $k);
					foreach($k as $d)
					{
					
						$group = Group::model()->findByPk($d);

						if(!empty($group))
						{

							$criteria=new CDbCriteria;
							$criteria->join = 'JOIN kontak_group kg ON kg.kontak_id = t.kontak_id';
							$criteria->addCondition('kg.group_id='.$group->group_id);
							$model = Kontak::model()->findAll($criteria);	
							foreach($model as $kontak)
							{
								$outbox = new Outbox;
								$outbox->DestinationNumber = $kontak->contact_phone;
								$outbox->TextDecoded = $_POST['msg'];
								$outbox->save();
							}
						}
						
					}	
				}
				$response = array(
					'status' => 'Pesan Terkirim',
					// 'message' => $_POST['kontak']
				);

				echo json_encode($response);	
			}
		}
	}

	public function actionSent()
	{
		$model=new Sentitems('search');
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['filter']))
			$model->SEARCH=$_GET['filter'];

		if(isset($_GET['size']))
			$model->PAGE_SIZE=$_GET['size'];

		if(isset($_GET['Inbox']))
			$model->attributes=$_GET['Inbox'];

		$this->render('sent',array(
			'model'=>$model,
		));
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
		$model=new Outbox;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Outbox']))
		{
			$model->attributes=$_POST['Outbox'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->ID));
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

		if(isset($_POST['Outbox']))
		{
			$model->attributes=$_POST['Outbox'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->ID));
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->actionAdmin();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Outbox('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Outbox']))
			$model->attributes=$_GET['Outbox'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Outbox the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Outbox::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Outbox $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='outbox-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
