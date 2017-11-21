<?php
/* @var $this OutboxController */
/* @var $model Outbox */
/* @var $form CActiveForm */

 $baseUrl = Yii::app()->baseUrl; 
 $cs = Yii::app()->getClientScript();

$cs->registerCssFile('css/multiplecombobox-styles.css');

$nomor_tujuan = !empty($model->DestinationNumber) ? $model->DestinationNumber : '';

?>

<div class="form">

	Nomor : <br>
	<small style="color: orange">Bila lebih dari satu nomor, pisahkan dengan tanda titik koma(;) </small>
	<br>
	<?php echo CHtml::textArea('nomor_tujuan',$nomor_tujuan,array('rows'=>6, 'cols'=>50,'id'=>'nomor_tujuan')); ?>
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
?>
<script type="text/javascript">
	$(document).ready(function(){

		$('#btnSend').on('click', function() {
			var dataku = $('#nomor_tujuan').val();
			dataku = dataku.split(";");
			
			var dataObj = new Object();
			dataObj.phones = dataku;
			dataObj.message = $('#pesanarea').val();

			var dataJson = JSON.parse(JSON.stringify(dataObj));


			$.ajax({
				type : 'POST',
				url : '<?php echo Yii::app()->createUrl('outbox/ajaxInstant');?>',
				dataType : 'json',
				data : dataJson,

				success : function(response){
					// var response = jQuery.parseJSON(response);
					// console.log(response);
					alert(response.status);
				},
				
			});
			
		});
	});
</script>