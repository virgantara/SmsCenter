<?php
/* @var $this InboxController */
/* @var $model Inbox */

$this->breadcrumbs=array(
	'Setting'=>array('index'),
	
);


?>

<h1>Cek Pulsa</h1>

<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'group-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<div class="row">
	<label>Cek Pulsa</label>
	<?php 
	echo CHtml::textField('nomor',!empty($_POST['nomor']) ? $_POST['nomor'] : '');
	?>

<div class="row"><label>Hasil:</label>
<?php 
	echo CHtml::textArea('hasil_cek',$hasil,array('rows'=>10,'cols'=>20,'id'=>'hasil_cek'));
	?>
</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Cek'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
