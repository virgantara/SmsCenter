<?php
/* @var $this OutboxController */
/* @var $model Outbox */
/* @var $form CActiveForm */

 $baseUrl = Yii::app()->baseUrl; 
 $cs = Yii::app()->getClientScript();

$cs->registerCssFile('css/multiplecombobox-styles.css');
?>

<div class="form">

	Dari kontak : <br>
	<select multiple name="kontak" id="kontak">
		<?php 
			$kontak = Kontak::model()->findAll();

			foreach($kontak as $g)
			{
				echo '<option value="'.$g->kontak_id.'">'.strtoupper($g->contact_name).'</option>';
			}
		?>
	</select>
	<br>

	Dari grup : <br>
	<select multiple name="groups" id="groups">
		<?php 
			$group = Group::model()->findAll();

			foreach($group as $g)
			{
				echo '<option value="'.$g->group_id.'">'.strtoupper($g->group_name).'</option>';
			}
		?>
	</select>
	
	
	<br>

	<div class="row">
		Pesan :<br>
		<?php echo CHtml::textArea('TextDecoded','',array('rows'=>6, 'cols'=>50,'id'=>'pesanarea')); ?>

	</div>

	

	<div class="row buttons">
		<?php echo CHtml::submitButton('Kirim',array('id'=>'btnSend')); ?>
	</div>



</div><!-- form -->

<?php 
$cs->registerScriptFile($baseUrl.'/js/jquery.min.js');
$cs->registerScriptFile($baseUrl.'/js/jquery-ui.min.js');
$cs->registerScriptFile($baseUrl.'/js/jquery.multiplecombobox.min.js');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$( "#groups, #kontak" ).multicombobox();

		$('#btnSend').on('click', function() {
			var dataku = $( "#kontak" ).multicombobox('val')+'#'+$( "#groups" ).multicombobox('val');
			$.ajax({
				type : 'POST',
				url : '<?php echo Yii::app()->createUrl('outbox/sendMessage');?>',
				// dataType : 'json',
				data : 'data='+dataku+'&msg='+$('#pesanarea').val(),
				// contentType : 'application/json; charset=utf-8',
				success : function(response){
					var response = jQuery.parseJSON(response);
					// console.log(response);
					alert(response.status);
				},
				
			});
			
		});
	});
</script>