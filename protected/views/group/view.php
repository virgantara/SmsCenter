<?php
/* @var $this GroupController */
/* @var $model Group */

$baseUrl = Yii::app()->baseUrl; 
 $cs = Yii::app()->getClientScript();

$cs->registerCssFile('css/multiplecombobox-styles.css');

$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$model->group_id,
);

$this->menu=array(
	array('label'=>'List Group', 'url'=>array('index')),
	array('label'=>'Create Group', 'url'=>array('create')),
	array('label'=>'Update Group', 'url'=>array('update', 'id'=>$model->group_id)),
	array('label'=>'Delete Group', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->group_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Group', 'url'=>array('admin')),
);
?>

<h1>View Group #<?php echo $model->group_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'group_id',
		'group_name',
		'group_code',
	),
)); ?>


<h1>Kontak Grup</h1>


<script type="text/javascript">
    
	function updateData(){
		 $('#kontak-grid').yiiGridView.update('kontak-grid', {
            url:'?r=group/view&id=<?php echo $model->group_id;?>&filter='+$('#search').val()+'&size='+$('#size').val() 
        });
	}

    $(document).ready(function(){
        $('#search, #size').change(function(){
           	updateData();
        });

        $('#pencarian').click(function(){
           	updateData();
        });
    });
</script>
 <div class="pull-right">
Data per halaman
<?php echo CHtml::dropDownList('Kontak[PAGESIZE]',isset($_GET['size'])?$_GET['size']:'',array(10=>10,50=>50,100=>100,200=>200),array('id'=>'size','size'=>1)); 
echo CHtml::textField('Kontak[SEARCH]','',array('placeholder'=>'Cari','id'=>'search')); 
echo CHtml::button("Cari",array("id"=>"pencarian"));
?>
</div> 
Dari kontak : <br>
	<select multiple name="kontak" id="kontak">
		<?php 
			$k = Kontak::model()->findAll();

			foreach($k as $g)
			{
				echo '<option value="'.$g->kontak_id.'">'.strtoupper($g->contact_name).'</option>';
			}
		?>
	</select>
	<br>
<?php
echo CHtml::button("Tambahkan ke grup",array("id"=>"add_grup"));
echo ' ';
echo CHtml::button("Hapus Kontak Dari Grup",array("id"=>"butt"));


 $this->widget('application.components.ComplexGridView', array(
	'id'=>'kontak-grid',
	'dataProvider'=>$kontakGroup->search(),
	'columns'=>array(
		array(
			'header' => 'No',
			'value'	=> '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
		),
 
		'kontak.contact_name',
		'kontak.contact_phone',
		// 'TextDecoded',
		
		
		 array(
                'class'=>'CCheckBoxColumn',  //Tambahkan kolom untuk checkbos.
                'selectableRows'=>2,         //MULTIPLE ROWS CAN BE SELECTED.
                ),

		 array(
		 	'class'=>'CButtonColumn',
      		'template'=>'{delete}',
      		'buttons' => array(
      			'delete' => array(
	              'url'=>'Yii::app()->createUrl("group/removeKontakSingle/", array("id"=>$data->id_kontak_group))',   
	            ),
      		)
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

        var checked=$("#kontak-grid").yiiGridView("getChecked","kontak-grid_c3"); 
        var count=checked.length;
        if(count>0 && confirm("Do you want to delete these "+count+" item(s)"))
        {
                $.ajax({
                        data:{checked:checked},
                        url:"'.Yii::app()->createUrl('group/removeKontak',array('group_id'=>$model->group_id)).'",
                        success:function(data){$("#kontak-grid").yiiGridView("update",{});},              
                });
        }
        });
');
?>

<?php 

$cs->registerScriptFile($baseUrl.'/js/jquery-ui.min.js');
$cs->registerScriptFile($baseUrl.'/js/jquery.multiplecombobox.min.js');
?>

<script type="text/javascript">
	$(document).ready(function(){
		$( "#kontak" ).multicombobox();

		$('#add_grup').on('click', function() {
			var dataku = $( "#kontak" ).multicombobox('val');
			$.ajax({
				type : 'POST',
				url : '<?php echo Yii::app()->createUrl('group/ajaxAddToGroup');?>',
				// dataType : 'json',
				data : 'data='+dataku+'&gid=<?php echo $model->group_id;?>',
				// contentType : 'application/json; charset=utf-8',
				success : function(response){
					var response = jQuery.parseJSON(response);
					
					updateData();
				},
				
			});
			
		});
	});
</script>
