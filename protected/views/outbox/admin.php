<?php
/* @var $this OutboxController */
/* @var $model Outbox */

$this->breadcrumbs=array(
	'Outboxes'=>array('index'),
	'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#outbox-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<script type="text/javascript">
	function updateData(){
		 $('#outbox-grid').yiiGridView.update('outbox-grid', {
            url:'?r=outbox/admin' 
        });
	}
</script>


<h1>Outboxes</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'outbox-grid',
	'dataProvider'=>$model->search(),
	// 'filter'=>$model,
	'columns'=>array(
		'DestinationNumber',
		'SendingDateTime',
		'TextDecoded',
		'DeliveryReport',
		/*
		'DestinationNumber',
		'Coding',
		'UDH',
		'Class',
		'TextDecoded',
		'ID',
		'MultiPart',
		'RelativeValidity',
		'SenderID',
		'SendingTimeOut',
		'DeliveryReport',
		'CreatorID',
		*/
	
	),
)); ?>

<script type="text/javascript">
    setInterval(function(){ 
        updateData();
    },3000);
</script>
