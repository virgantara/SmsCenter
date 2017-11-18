<?php
/* @var $this OutboxController */
/* @var $model Outbox */

$this->breadcrumbs=array(
	'Outboxes'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Sent', 'url'=>array('index')),
	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#sent-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Pesan Terkirim</h1>


<script type="text/javascript">
    
	function updateData(){
		 $('#sent-grid').yiiGridView.update('sent-grid', {
            url:'?r=outbox/sent&filter='+$('#search').val()+'&size='+$('#size').val() 
        });
	}

    $(document).ready(function(){
        $('#search, #size, #kode_prodi').change(function(){
           	updateData();
        });

        $('#pencarian').click(function(){
           	updateData();
        });
    });
</script>
<?php 
 foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div style="color:green">' . $message . "</div>\n";
    }
    
?>
 <div class="pull-right">
Data per halaman
<?php echo CHtml::dropDownList('Outbox[PAGESIZE]',isset($_GET['size'])?$_GET['size']:'',array(10=>10,50=>50,100=>100,200=>200),array('id'=>'size','size'=>1)); ?>
<?php
echo CHtml::textField('Outbox[SEARCH]','',array('placeholder'=>'Cari','id'=>'search')); 
?>   
<?php
echo CHtml::button("Cari",array("id"=>"pencarian"));
?>
</div> 
<?php
echo CHtml::button("Hapus Item Terpilih",array("id"=>"butt"));
?>
<?php $this->widget('application.components.ComplexGridView', array(
	'id'=>'sent-grid',
	'dataProvider'=>$model->search(),
	// 'filter'=>$model,
	'columns'=>array(
		array(
			'header' => 'No',
			'value'	=> '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
		),
 
		'DestinationNumber',
		'SendingDateTime',
		'TextDecoded',
		'Status',
		
		 array(
                'class'=>'CCheckBoxColumn',  //Tambahkan kolom untuk checkbos.
                'selectableRows'=>2,         //MULTIPLE ROWS CAN BE SELECTED.
                ),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {delete}',
			'buttons' => array(
      			'delete' => array(
      				'label'=>'Hapus',
                    'url'=>'Yii::app()->createUrl("outbox/deleteSent", array("id"=>$data->ID))',
                    
      			),
      		),
		),
	),
	'pager'=>array(

                'firstPageLabel'=>'First',
                'prevPageLabel'=>'Prev',
                'nextPageLabel'=>'Next',        
                'lastPageLabel'=>'Last',  
   				'firstPageCssClass'=>'btn',
                'previousPageCssClass'=>'btn',
                'nextPageCssClass'=>'btn',        
                'lastPageCssClass'=>'btn',
			    'hiddenPageCssClass'=>'disabled',
			    'internalPageCssClass'=>'btn',
			    'selectedPageCssClass'=>'selected',
			    'maxButtonCount'=>5,
        ),

)); ?>


<?php
Yii::app()->clientScript->registerScript('delete','
$("#butt").click(function(){

        var checked=$("#sent-grid").yiiGridView("getChecked","sent-grid_c5"); 
        var count=checked.length;
        if(count>0 && confirm("Do you want to delete these "+count+" item(s)"))
        {
                $.ajax({
                        data:{checked:checked},
                        url:"'.CHtml::normalizeUrl(array('outbox/removeSent')).'",
                        success:function(data){$("#sent-grid").yiiGridView("update",{});},              
                });
        }
        });
');
?>
