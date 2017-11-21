<?php
/* @var $this OutboxController */
/* @var $model Outbox */

$this->breadcrumbs=array(
	'Outboxes'=>array('index'),
	'Create',
);

?>

<h1>Pesan Baru</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>