<?php
/* @var $this OutboxController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Outboxes',
);

$this->menu=array(
	array('label'=>'Create Outbox', 'url'=>array('create')),
	array('label'=>'Manage Outbox', 'url'=>array('admin')),
);
?>

<h1>Outboxes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
