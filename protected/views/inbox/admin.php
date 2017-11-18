<?php
/* @var $this InboxController */
/* @var $model Inbox */

$this->breadcrumbs=array(
	'Inboxes'=>array('index'),
	'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#inbox-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<style type="text/css">
	.read { 
	    background-color: orange; 
	}
</style>
<h1>Inbox</h1>


<script type="text/javascript">
    
	function updateData(){
		 $('#inbox-grid').yiiGridView.update('inbox-grid', {
            url:'?r=inbox/admin&filter='+$('#search').val()+'&size='+$('#size').val() 
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
<?php echo CHtml::dropDownList('Inbox[PAGESIZE]',isset($_GET['size'])?$_GET['size']:'',array(10=>10,50=>50,100=>100,200=>200),array('id'=>'size','size'=>1)); ?>
<?php
echo CHtml::textField('Inbox[SEARCH]','',array('placeholder'=>'Cari','id'=>'search')); 
?>   
<?php
echo CHtml::button("Cari",array("id"=>"pencarian"));
?>
</div> 
<?php
echo CHtml::button("Hapus Item Terpilih",array("id"=>"butt"));
?>
<?php $this->widget('application.components.ComplexGridView', array(
	'id'=>'inbox-grid',
	'dataProvider'=>$model->search(),
	'rowCssClassExpression' => '$data->Processed == "false" ? "read" : ""',
	// 'filter'=>$model,
	'columns'=>array(
		array(
			'header' => 'No',
			'value'	=> '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
		),
 
		'SenderNumber',
		'ReceivingDateTime',
		'TextDecoded',
		
		
		 array(
                'class'=>'CCheckBoxColumn',  //Tambahkan kolom untuk checkbos.
                'selectableRows'=>2,         //MULTIPLE ROWS CAN BE SELECTED.
                ),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {reply} {delete}',
      		'buttons' => array(
      			'reply' => array(
      				'label'=>'Balas',
                    'url'=>'Yii::app()->createUrl("outbox/instant", array("id"=>$data->ID))',
                    'imageUrl'=>'images/reply.png',

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

        var checked=$("#inbox-grid").yiiGridView("getChecked","inbox-grid_c4"); 
        var count=checked.length;
        if(count>0 && confirm("Do you want to delete these "+count+" item(s)"))
        {
                $.ajax({
                        data:{checked:checked},
                        url:"'.CHtml::normalizeUrl(array('inbox/removeSelected')).'",
                        success:function(data){$("#inbox-grid").yiiGridView("update",{});},              
                });
        }
        });
');
?>
