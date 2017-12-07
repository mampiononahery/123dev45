<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard') ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo site_url('user/marketing/request') ?>">Marketing</a></li>
    <li class="breadcrumb-item active">Statistique</li>
</ol>
<form method="POST" id="form_recherche" action ="<?php echo site_url("user/marketing/stats"); ?>">
<div class="row">
	<div style="width:160px;float: left;">
		<div class="form-display-as-box" id="dt_nais_display_as_box">
	Filtre par période :
</div>
		  
		  <select  id="filtre_periode" name="periode" class="chosen-select" data-placeholder="Sélectionner Titre">
		  
		  
		  <option value="1" <?php echo $periode==1 ? "selected": "";?> > Mois en cours</option>
		  <option value="2" <?php echo $periode==2 ? "selected": "";?> >6 derniers mois</option>
		  <option value="3" <?php echo $periode==3 ? "selected": "";?> >Année en cours</option>
		  
		  </select>
		  
		
	</div>
	<div style="width:160px;float: left;">
	
		
		

<div class="form-display-as-box" id="dt_nais_display_as_box">
	Date de début :
</div>
<div class="form-input-box" id="dt_nais_input_box">
                        <input id="date_debut" name="date_debut" value="" maxlength="10" placeholder="taper ici YYYY-mm-dd" class="datepicker-input form-control hasDatepicker" type="text">
		<a aria-disabled="false" role="button" class="datepicker-input-clear ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" tabindex="-1"><span class="ui-button-text">Initialiser</span></a> (YYYY-mm-dd)
</div>
<div class="clear"></div>
                
	
		
	</div>
	
	<div style="width:160px;float: left;">
	
		
		

<div class="form-display-as-box" id="dt_nais_display_as_box">
	Date de fin :
</div>
<div class="form-input-box" id="dt_nais_input_box">
                        <input id="dt_fin" name="dt_fin" value="" placeholder="taper ici YYYY-mm-dd" maxlength="10" class="datepicker-input form-control hasDatepicker" type="text">
		<a aria-disabled="false" role="button" class="datepicker-input-clear ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" tabindex="-1"><span class="ui-button-text">Initialiser</span></a> (YYYY-mm-dd)
</div>
<div class="clear"></div>
                
	
		
	</div>

	<div style="width:160px;float: left;">
	<div class="form-display-as-box" id="dt_nais_display_as_box" style="min-height:25px;">
	       
	</div>
	<span class="btn btn-large" id="valider_recherche"><i class="fa fa-search"> Valider</i></span>
	</div>
	
	
	
	
	
</div>
</form>
<div id="id_recherche">
<?php echo isset($output) ? $output : ''; ?>

<div class="flexigrid" style="width: 50%;" data-unique-hash="ecd0d0e5a802371936b151b3bc1b7449">
    <div id="main-table-box" class="main-table-box">
        <div class="tDiv">

			<div class="tDiv3">
			</div>
		</div>
		<div id="ajax_list" class="ajax_list">
            <div class="bDiv">
               
                <table cellspacing="0" cellpadding="0" border="0" id="flex1">
                    <thead>
						<tr class="hDiv">
							<td>Total  sms   envoyé </td>
							<td>Date</td>
						</tr>
					</thead>
					 <tbody>
						<?php if(!empty($total_sms)){
							foreach($total_sms as $t){ ?>
								
								<tr>
									<td><?php echo $t["nombre_sms"];?></td>
									<td><?php echo $t["dt_envoie"];?></td>
								</tr>
								
							<?php }

						}?>
					 </tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>

	$(document).ready(function(){
	
	//edit-button
	
	
	$("#edit-button").hide();
	$("#filtre_periode").on("change",function(){
		$("#form_recherche").submit();
			/*var param = {
				date_debut :$("#date_debut").val(),
				date_fin:$("#dt_fin").val(),
				periode :$(this).val()
			
			};
			$.ajax({
				  method:"POST",
				  url :"<?php echo site_url("user/marketing/recherche_stats")?>",
				  data : param,
				  success:function(reponse){
						$("#id_recherche").html(reponse);
					  
				  }
				  
			  });
		
			*/
	});
		
		$("#valider_recherche").on("click",function(){
			$("#form_recherche").submit();
			/*var param = {
				date_debut :$("#date_debut").val(),
				date_fin:$("#dt_fin").val()
			
			};
			$.ajax({
				  method:"POST",
				  url :"<?php echo site_url("user/marketing/recherche_stats")?>",
				  data : param,
				  success:function(reponse){
						$("#id_recherche").html(reponse);
					  
				  }
				  
			  });
			*/	
		});
	
	});


</script>




