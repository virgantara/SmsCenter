<?php
/* @var $this KontakController */
/* @var $model Kontak */

$this->breadcrumbs=array(
	'Kontaks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Kontak', 'url'=>array('index')),
	array('label'=>'Manage Kontak', 'url'=>array('admin')),
);
?>

<h1>Create Kontak</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>