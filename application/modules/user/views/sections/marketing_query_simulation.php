

<style>
	.masque img{
		width: 15px;
		height: auto;
		cursor:pointer;
	}
	

</style>

<div class="flexigrid content-wrapper">
        <div class="mDiv">
            <div class="ftitle" style="width: 150px;display: inline-block;">
                <div class="ftitle-left">Afficher les Chiens</div>
				
					<div class="switch clear">
						<input class="switch-input"  type="radio" id="switch-on" name="switch-alert" value="1"<?php echo isset($switch_on) && $switch_on ? ' checked="checked"' : '' ?>/>
						<label for="switch-on" class="switch-label switch-label-off">oui</label>
						<input class="switch-input"  type="radio" id="switch-off" name="switch-alert" value="0"<?php echo isset($switch_off) && $switch_off ? ' checked="checked"' : '' ?>/>
						<label for="switch-off" class="switch-label switch-label-on">non</label>
						<span class="switch-selection"></span>
					</div>
				
				
            </div>
			<span style="margin: 0;padding: 6px;position: relative;top: -20px;" class="btn btn-large" id="dedoublone"> Dedoublonage </span>
        </div>
		 
    </div>
<div class="flexigrid" style="width: 100%;" data-unique-hash="ecd0d0e5a802371936b151b3bc1b7449">
    <div id="main-table-box" class="main-table-box">
        <div class="tDiv">
            <div class="tDiv3">
                <?php if (isset($current_table) && isset($ids)): ?>
                    <a class="export-anchor" data-url="" target="_blank">
                        <div class="fbutton">
                            <div>
                                <!--<a href="<?php echo ""; // site_url('user/ajax/export_all?table=' . $current_table . '&ids=' . $ids) ?>"><span class="export">Exporter</span></a>-->
								<a href="#" id="exporter_excel"><span class="export">Exporter</span></a>
							</div>
                        </div>
                    </a>
                <?php endif; ?>
                <div class="btnseparator"></div>
            </div>
            <div class="clear"></div>
        </div>
        <?php 
	if(!empty($result[$indice])){
	
		$item = get_object_vars($result[$indice]);
		$keys = array_keys($item);
		$column_width = (int)(80/count($keys));
								
	}
	
	?>
        <div id="ajax_list" class="ajax_list">
            <div class="bDiv">
                <?php $total_col = 6; ?>
                <table cellspacing="0" cellpadding="0" border="0" id="flex1">
                    <thead>
					
						<?php if(!empty($result[$indice])){//foreach ($result[$indice] AS $entity): ?>
                            <tr class="hDiv">
                                <?php
                                $item = get_object_vars($result[$indice]);
                                $keys = array_keys($item);
								$icol = 0;
                                ?>
                                <?php foreach ($keys AS $key): ?>
                                    <th width='<?php echo $column_width ?>%' class='th_<?php echo $icol; ?>  th_tous' rel="th_<?php echo $icol; ?>" data="<?php echo $key; ?>">
										<div class="masque" style="padding: 0px;"><img class="masque_col" src="<?php echo site_url("assets/backend/design/masque.png"); ?>" /></div>
                                        <div class="text-left text-left field-sorting  " id="<?php echo $key; ?>" rel="<?php echo $key; ?>"><?php echo lang($key) ?>
										
										
										
										</div>
                                    </th>
                                <?php
								$icol ++;

								endforeach; ?>
                                 
                            </tr>
                        <?php } //endforeach; ?>
						
						<?php //foreach ($result AS $entity): ?>
						<tr>
							<?php
							if(!empty($result[$indice])){
                                $item = get_object_vars($result[$indice]);
                                $keys = array_keys($item);
                                ?>
							<?php 
							
							$icol = 0;
							foreach ($keys AS $key): ?>
                            <th class="action_toogle th_<?php echo $icol; ?>  th_tous">
								<input type="text" name="<?php echo $key; ?>" placeholder="<?php echo "rechercher"; ?>" class="get_action_toogle_search seach_flexigrid search_<?php echo $key; ?>"/>
								<i class="action_toogle_search fa fa-search" aria-hidden="true" style="color: blue;" ></i>
							</th>
							<?php 
							
							$icol++;
							endforeach; ?>
							<?php } ?> 

							
						</tr>
                        <?php //endforeach; ?>
					
					
					
                        
                    </thead>
                    <tbody>
						<?php $list_client = array();

							$id= 1;
						?>
                        <?php foreach ($result AS $entity): ?>
                            <tr>
                                <?php
                                $item = get_object_vars($result[$indice]);
                                $keys = array_keys($item);
								$keys[] = "Action";
								$icol = 0;
                                ?>
                                <?php foreach ($keys AS $key): 
								
									if($key=="client_id")
									{
									   if(!in_array($entity->$key,$list_client)){
												$list_client[] = $entity->$key;
									   }
									}
									
									$name_afficher = "";//$entity->object_name;
									
								?>
                                    <?php if($key=="Action") { 
									
									
									
									
									
									?>
									
									<?php } else { ?>
										<td class="th_<?php echo $icol; ?>  th_tous">
											<div class="text-left"><?php echo !empty($entity->$key) ? $entity->$key : "" ;?></div>
										</td>
									<?php } ?>
                                <?php 
								$id++;
								$icol++;
								endforeach; ?>  
								
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
		<div class="sDiv quickSearchBox" id="quickSearchBox">
			<div class="sDiv2">
				
			</div>
			<div class="search-div-clear-button">
				<input value="Initialiser le filtrage" id="search_clear" class="search_clear" type="button">
			</div>
		</div>
    </div>
	<form id="swit_form_chien">
	<?php if(sizeof($list_client)) {
	
	foreach($list_client as $client_id){ ?>
	
			<input type="hidden" name="client_id[]" value="<?php echo $client_id; ?>" />

	
	<?php }
	
	
	} ?>
	
		</form>
</div><?php if(sizeof($list_client)) { ?>

	<?php } ?>

<input type="hidden" id="namesearch" name="namesearch" value="" />
<input type="hidden" id="namesearchval" name="namesearchval" value="" />

<script>

		//$("input[type='radio'][name='switch-alert']").val(0);
		$("#exporter_excel").on("click",function()
		{
			
			var form = $("#search-form").serialize();
			var url =  "<?php echo site_url('user/ajax/get_query_simulation/0') ?>";
			window.open(url+"?"+form);
			
		});
		function test_change(elem,id_client){
			console.log($(elem).val());
			if ($(elem).val()=="1" || $(elem).val()=="1")
			{
				$.ajax({
					url: "<?php echo site_url('user/ajax/query_simulation') ?>/"+id_client,
					type: "post",
					data: $("#search-form").serialize(),
					success: function (html) {
						$('#search-results').html(html);
						
					},
					error: function () {
						alert("Erreur pendant le chargement...");
					}
				});
				
				//$(this).attr("checked",true);
			}
			else{
				// UNSET AJAX TEST
				$.ajax({
					url: "<?php echo site_url('user/ajax/query_simulation') ?>/0",
					type: "post",
					data: $("#search-form").serialize(),
					success: function (html) {
						$('#search-results').html(html);
						
					},
					error: function () {
						alert("Erreur pendant le chargement...");
					}
				});
			}
			
		}
		$("#dedoublone").on("click",function(){
			$.ajax({
				url: "<?php echo site_url('user/ajax/query_simulation') ?>/0?is_dedoublonage=1",
				type: "post",
				data: $("#search-form").serialize(),
				success: function (html) {
					$('#search-results').html(html);
					
				},
				error: function () {
					alert("Erreur pendant le chargement...");
				}
			});
		});
		
		
        $("input[type='radio'][name='switch-alert']").on("change",function () {
			var id_client = 1;
			if ($(this).val()=="1" || $(this).val()=="1")
				{
					$.ajax({
						url: "<?php echo site_url('user/ajax/query_simulation') ?>/"+id_client,
						type: "post",
						data: $("#search-form").serialize(),
						success: function (html) {
							$('#search-results').html(html);
							
						},
						error: function () {
							alert("Erreur pendant le chargement...");
						}
					});
					
					//$(this).attr("checked",true);
				}
				else{
					// UNSET AJAX TEST
					$.ajax({
						url: "<?php echo site_url('user/ajax/query_simulation') ?>/0",
						type: "post",
						data: $("#search-form").serialize(),
						success: function (html) {
							$('#search-results').html(html);
							
						},
						error: function () {
							alert("Erreur pendant le chargement...");
						}
					});
				}
        });
		
  $(".search_clear").on("click",function(){
  
	  $(".th_tous").show();
  });
$('.ajax_list').on('click','.field-sorting', function(){


	var test = $(this).attr('rel');
	
	var class_val = "";
	if($(this).hasClass('desc')){

		
		$(this).removeClass('desc');
		$(this).addClass('asc');
		class_val = "asc";

		$("#sort_val").val('asc');
		$("#sort_col").val($(this).attr('rel'));
	}
	else{
		$(this).removeClass('asc');
		$(this).addClass('desc');
		$("#sort_val").val('desc');
		$("#sort_col").val($(this).attr('rel'));
		class_val = "desc";
	}
	// mISE à jour
	
	//$('#search-results').html('recherche en cours');
	$.ajax({
		url: "<?php echo site_url('user/ajax/query_simulation') ?>",
		type: "post",
		data: $("#search-form").serialize(),
		success: function (html) {
			$html = html;
			$('#ajax-loader').show();
			$("#namesearchval").val("");
			setTimeout(function () {
				$('#ajax-loader').hide();
				$('#search-results').html($html);
				
				$("#"+test).addClass(class_val);
			}, 2000);
		},
		error: function () {
			alert("Erreur pendant le chargement...");
		}
	});


});


$('.ajax_list').on('click','.action_toogle_search',function(){
	
		var is_show = $(this).parent('.action_toogle').find('.get_action_toogle_search').css('display');
		var name_val = $("#namesearchval").val();
		
		console.log(name_val);
		if(name_val!=='')
		{
		
				
				$('#search-results').html('recherche en cours');
				$.ajax({
					url: "<?php echo site_url('user/ajax/query_simulation') ?>",
					type: "post",
					data: $("#search-form").serialize(),
					success: function (html) {
						$html = html;
						$('#ajax-loader').show();
						$("#namesearchval").val("");
						setTimeout(function () {
							$('#ajax-loader').hide();
							$('#search-results').html($html);
						}, 2000);
					},
					error: function () {
						alert("Erreur pendant le chargement...");
					}
				});
	
			
			
			
		}
		if(is_show == 'none'){
			$(this).parent('.action_toogle').find('.get_action_toogle_search').show();
		}else{
			$(this).parent('.action_toogle').find('.get_action_toogle_search').hide();
        }
	});
	
	
	$('.ajax_list').on('keyup','.seach_flexigrid', function(){
		
			
		$("#namesearch").val($(this).attr('name'));
		$("#namesearchval").val($(this).val());
		

	});
	
	
	function recherche_par_ajax()
	{
	
	}
	$(".masque_col").on("click",function(){
		var rel = $(this).parent().parent().attr("rel");
		$("."+rel).hide();
		var col = $(this).parent().parent().attr("data");
				
		var param = {col : col};
		$.ajax({
			method:'POST',
			url:"<?php echo site_url("user/client/set_session_export") ?>",
			data:param,
			success:function(response){
			
			}
		
		
		});
	
});


</script>

<style>
.get_action_toogle_search {
    display: none;
    width: 80%;
}
</style>