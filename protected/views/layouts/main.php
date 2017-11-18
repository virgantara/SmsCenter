<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php
$unread = Inbox::model()->countUnread();

$unread = $unread >= 1 ? ' ('.$unread.')' : '';

		 $this->widget('zii.widgets.CMenu',array(
		 	'encodeLabel' => false,
			'items'=>array(
				array('label'=>'Instant SMS', 'url'=>array('/outbox/instant')),
				array('label'=>'Sms Baru', 'url'=>array('/outbox/create')),
				array('label'=>'Inbox<span id="unread">'.$unread.'</span>', 'url'=>array('/inbox/index')),
				array('label'=>'Outbox', 'url'=>array('/outbox/index')),
				array('label'=>'Pesan Terkirim', 'url'=>array('/outbox/sent')),
				array('label'=>'Kontak', 'url'=>array('/kontak/index')),
				array('label'=>'Grup', 'url'=>array('/group/index')),
				array('label'=>'Setting', 'url'=>array('/site/setting')),
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Head Office : Main Campus University of Darussalam Gontor Demangan Siman Ponorogo East Java Indonesia 63471<br>
Phone : (+62352) 483762, Fax : (+62352) 488182, Email : rektorat@unida.gontor.ac.id
	</div><!-- footer -->

</div><!-- page -->

</body>
<script type="text/javascript">
	setInterval(function(){ 
		 $.ajax({
		 	type : 'POST',
		 	url : '<?php echo Yii::app()->createUrl('inbox/countTotalUnread');?>',
		 	success : function(data){
		 		var total = eval(data);

		 		if(total >= 1)
		 			$('#unread').html(' ('+total+')');
		 		else
		 			$('#unread').html('');
		 	}
		 });
	}, 1000);
</script>
</html>
