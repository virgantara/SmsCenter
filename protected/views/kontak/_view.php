<?php
/* @var $this KontakController */
/* @var $data Kontak */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kontak_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kontak_id), array('view', 'id'=>$data->kontak_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_name')); ?>:</b>
	<?php echo CHtml::encode($data->contact_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_phone')); ?>:</b>
	<?php echo CHtml::encode($data->contact_phone); ?>
	<br />


</div>