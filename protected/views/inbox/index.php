<?php
/* @var $this InboxController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Inboxes',
);

$this->menu=array(
	array('label'=>'Create Inbox', 'url'=>array('create')),
	array('label'=>'Manage Inbox', 'url'=>array('admin')),
);
?>

<h1>Inboxes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
