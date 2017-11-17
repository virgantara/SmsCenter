<?php
/* @var $this KontakController */
/* @var $model Kontak */

$this->breadcrumbs=array(
	'Kontaks'=>array('index'),
	$model->kontak_id=>array('view','id'=>$model->kontak_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Kontak', 'url'=>array('index')),
	array('label'=>'Create Kontak', 'url'=>array('create')),
	array('label'=>'View Kontak', 'url'=>array('view', 'id'=>$model->kontak_id)),
	array('label'=>'Manage Kontak', 'url'=>array('admin')),
);
?>

<h1>Update Kontak <?php echo $model->kontak_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>