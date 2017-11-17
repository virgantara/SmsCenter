<?php
/* @var $this KontakController */
/* @var $model Kontak */

$this->breadcrumbs=array(
	'Kontaks'=>array('index'),
	$model->kontak_id,
);

$this->menu=array(
	array('label'=>'List Kontak', 'url'=>array('index')),
	array('label'=>'Create Kontak', 'url'=>array('create')),
	array('label'=>'Update Kontak', 'url'=>array('update', 'id'=>$model->kontak_id)),
	array('label'=>'Delete Kontak', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->kontak_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Kontak', 'url'=>array('admin')),
);
?>

<h1>View Kontak #<?php echo $model->kontak_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'kontak_id',
		'contact_name',
		'contact_phone',
	),
)); ?>
