<?php
/* @var $this OutboxController */
/* @var $model Outbox */

$this->breadcrumbs=array(
	'Outboxes'=>array('index'),
	$model->ID=>array('view','id'=>$model->ID),
	'Update',
);

?>

<h1>Update Outbox <?php echo $model->ID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>