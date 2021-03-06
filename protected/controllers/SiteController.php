<?php

class SiteController extends Controller
{

	public $RUNNING_STATUS = "";
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function actionCekPulsa()
	{

		$hasil = '';
		if(!empty($_POST['nomor']))
		{
			$hasil = Yii::app()->helper->cekPulsa($_POST['nomor']);
		}

		$this->render('cekpulsa',array(
			'hasil' => $hasil
		));
	}


	// public function actionCekPulsa()
	// {
	// 	if(Yii::app()->request->getIsAjaxRequest())
 //        {
 //        	$nomor = $_POST['nomor'];
 //        	$response = Yii::app()->helper->cekPulsa($nomor);

	// 		echo $response;
 //        }
	// }

	public function actionCheckNotif()
	{
		// if(Yii::app()->request->getIsAjaxRequest())
  //       {
        	$result = array();
        	$new_notif = 0;
        	$criteria=new CDbCriteria;
			$criteria->addCondition('notif_count <> 0');
        	$notif = Notification::model()->find($criteria);
        	if(!empty($notif)){
        		$new_notif = 1;
        		$notif->delete();
        	}

        	$result = array(
        		'newNotif' => $new_notif,
        		'totalUnread' => Inbox::model()->countUnread(),
        	);
        	echo json_encode($result);
        // }
	}

	public function actionAjaxUpdateNotif()
	{
		if(Yii::app()->request->getIsAjaxRequest())
        {


        	$criteria=new CDbCriteria;
			$criteria->addCondition('notif_count <> 0');
        	$notif = Notification::model()->find($criteria);
        	if(!empty($notif)){
        		$notif->delete();
        	}
        }
	}

	public function actionGetStatus()
	{
		echo Yii::app()->helper->cekGammu() ? 'RUNNING' : 'STOP';
	}

	public function actionSetting()
	{
		$this->render('setting');
	}

	public function actionStartService()
	{

		if(!Yii::app()->helper->cekGammu())
		{
			Yii::app()->helper->startGammu();
		}

		echo 'Service Started';
        
	}

	public function actionStopService()
	{
		if(Yii::app()->helper->cekGammu())
		{
			Yii::app()->helper->stopGammu();
			echo 'Service Stopped';
		}
	}

	public function actionMaster()
	{
		$this->render('master');
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->redirect(Yii::app()->createUrl('inbox/index'));
	}

	public function actionHome()
	{
		$this->render('home');
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

	public function actionLogin()
	{
	
		$model=new User;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['User']))
		{
		
			
			$model->attributes=$_POST['User'];
			$result = $model->login();
			// validate user input and redirect to the previous page if valid
			switch($result)
			{
				case UserIdentity::ERROR_NONE:
					
					$time_expiration = time()+60*60*24*7; 
					$tahunaktif = Tahunakademik::model()->findByAttributes(array('buka'=> 'Y'));	
					$cookie = new CHttpCookie('tahunaktif', $tahunaktif->tahun_id);
					$cookie->expire = $time_expiration; 
					Yii::app()->request->cookies['tahunaktif'] = $cookie;	
					$this->redirect(Yii::app()->createUrl('jadwal/index'));
					
					break;
				case UserIdentity::ERROR_USERNAME_INVALID:
				case UserIdentity::ERROR_PASSWORD_INVALID:
					$model->addError('username','Incorrect username or password.');
					
					break;
				case UserIdentity::ERROR_USER_INACTIVE:

					$model->addError('username','Akun Anda belum aktif. Silakan menghubungi Administrator.');
					
					break;
			}
			
		}
		
		
		
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(array('site/login'));
	}
	
}