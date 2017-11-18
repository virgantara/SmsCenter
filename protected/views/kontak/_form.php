<?php
/* @var $this KontakController */
/* @var $model Kontak */
/* @var $form CActiveForm */

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'kontak-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_name'); ?>
		<?php echo $form->textField($model,'contact_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'contact_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_phone'); ?>
		<?php echo $form->textField($model,'contact_phone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'contact_phone'); ?>
	</div>

	<div class="row">
		Ke grup : <br>
		<?php 
			$group = Group::model()->findAll();

			foreach($group as $g)
			{
				$kg = KontakGroup::model()->findByAttributes(array('kontak_id'=>$model->kontak_id,'group_id'=>$g->group_id));

				if(!empty($kg))
					echo '<label><input type="checkbox" checked name="group[]" value="'.$g->group_id.'"> &nbsp;'.strtoupper($g->group_name).'</label>';
				else
					echo '<label><input type="checkbox" name="group[]" value="'.$g->group_id.'"> &nbsp;'.strtoupper($g->group_name).'</label>';
			}
		?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

