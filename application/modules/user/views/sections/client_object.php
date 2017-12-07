<script type="text/javascript" src="<?php echo base_url('assets/libraries/grocery_crud/texteditor/ckeditor/ckeditor.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/libraries/grocery_crud/texteditor/ckeditor/adapters/jquery.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/libraries/grocery_crud/js/jquery_plugins/config/jquery.ckeditor.config.js') ?>"></script>


<link href='<?php echo base_url('assets/libraries/grocery_crud/css/ui/simple/jquery-ui-1.10.1.custom.min.css'); ?>' rel='stylesheet' type='text/css'>
<link href='<?php echo base_url('assets/libraries/grocery_crud/css/ui/simple/jquery-ui-1.10.1.custom.min.css'); ?>' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="<?php echo base_url('assets/libraries/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js'); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('assets/libraries/grocery_crud/js/jquery_plugins/ui/i18n/datepicker/jquery.ui.datepicker-fr.js'); ?>"></script>






<body  style="margin:0;">
	<?php echo isset($output) ? $output : ''; ?>
	
	
	
	
</body>


<script>

	console.log($("#list-report-success"));
	parent.alertsize($(".flexigrid").height()+$("#list-report-success").height()+10);

</script>
<style>

.ui-datepicker-trigger {
	border: none;
}

.ui-datepicker-trigger img {
	width: 15px;
	height: 20px;
}
		


</style>
<script type="text/javascript">

	
	$(document).ready(function(){
		
		

		$('.change_select').on("change",function(){
		
			if($(this).val() == '0' ||  $(this).val() ==0){
				$("#autre_id").show();
			
			}
			else{
			
				$("#autre_id").hide();
			}
		
		});
		
   
  


	});
	

		
		
		/*$('#field_2').datetimepicker({
			format: 'DD/MM/YYYY'
		});
		$('#field_7').datetimepicker({
			format: 'DD/MM/YYYY'
		});*/
    
	
	$('.picker').datepicker({
				
				showButtonPanel: true,
				changeMonth: true,
				changeYear: true,
				
				
				showOn: "button",
			  buttonImage: "https://greatermankato.com/sites/default/files/images/calendar.gif",
				
				yearRange: "-100:+0"
		});

</script>