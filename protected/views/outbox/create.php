<?php
/* @var $this OutboxController */
/* @var $model Outbox */

$this->breadcrumbs=array(
	'Outboxes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Outbox', 'url'=>array('index')),
	array('label'=>'Manage Outbox', 'url'=>array('admin')),
);
?>

<h1>Create Outbox</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>