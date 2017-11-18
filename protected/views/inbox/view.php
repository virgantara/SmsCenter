<?php
/* @var $this InboxController */
/* @var $model Inbox */

$this->breadcrumbs=array(
	'Inboxes'=>array('index'),
	$model->ID,
);

$this->menu=array(
	array('label'=>'Balas Pesan', 'url'=>array('outbox/instant','id'=>$model->ID)),
	array('label'=>'Hapus Pesan', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pesan', 'url'=>array('admin')),
);
?>

<h1>View Inbox #<?php echo $model->ID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'SenderNumber',
		
		'TextDecoded',
		'ReceivingDateTime',
	),
)); ?>
