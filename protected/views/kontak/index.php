<?php
/* @var $this KontakController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Kontaks',
);

$this->menu=array(
	array('label'=>'Create Kontak', 'url'=>array('create')),
	array('label'=>'Manage Kontak', 'url'=>array('admin')),
);
?>

<h1>Kontaks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
