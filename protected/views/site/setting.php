<?php
/* @var $this InboxController */
/* @var $model Inbox */

$this->breadcrumbs=array(
	'Setting'=>array('index'),
	
);


?>

<h1>Setting</h1>

<div class="form">

Gammu Service Status : 
<div id="status" style="text-align: center;padding-top: 15px;padding-bottom: 15px"></div>

<button id="btnStart">Start</button>
<button id="btnStop">Stop</button>
<br>
<div id="response" style="display:none;"></div>

</div><!-- form -->
<?php 
 $baseUrl = Yii::app()->baseUrl; 
 $cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/jquery.min.js');
?>
<script type="text/javascript">

	$('#btnStart').click(function(){
		$.ajax({
			'type' : 'POST',
			'url' : '<?php echo Yii::app()->createUrl('site/StartService');?>',
			'success' : function(data){
				$('#response').show();
				$('#response').html(data);
				readStatus();
			}
		});
	});

	$('#btnStop').click(function(){
		$.ajax({
			'type' : 'POST',
			'url' : '<?php echo Yii::app()->createUrl('site/StopService');?>',
			'success' : function(data){
				$('#response').show();
				$('#response').html(data);
				readStatus();
			}
		});
	});

	function readStatus(){
		$.ajax({
			'type' : 'POST',
			'url' : '<?php echo Yii::app()->createUrl('site/GetStatus');?>',
			'success' : function(data){
				if(data == 'RUNNING'){
					$('#status').html('<div id="status" style="background-color:green;color:white;text-align: center;padding-top: 15px;padding-bottom: 15px">RUNNING</div>');
				}

				else if(data == 'STOP'){
					$('#status').html('<div id="status" style="background-color:red;color:white;text-align: center;padding-top: 15px;padding-bottom: 15px">STOP</div>');
				}
				
			}
		});
	}

	readStatus() ;

	setInterval(function(){
	    readStatus() ;
	}, 5000);
</script>