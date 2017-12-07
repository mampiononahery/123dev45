<script type="text/javascript">
    $(document).ready(function ($) {
        $(".clickable-row").click(function () {
            window.location = $(this).data("href");
        });
        $(".not-acquitted").closest('tr').addClass('bg-asphalt');
		
		$('.search_clear').click(function(){
		
			//var param = {col : col};
			$.ajax({
			
				method:'POST',
				url:"<?php echo site_url("user/client/unset_session_export") ?>",
				data:{},
				success:function(response){
				
				}
			
			
			});           
		
		});
		
		
		$(".masque_col").on("click",function(){
			var rel = $(this).parent().parent().attr("rel");
			var col = $(this).parent().parent().attr("data");
			
			
			$("."+rel).hide();
			
			var param = {col : col};
			$.ajax({
			
				method:'POST',
				url:"<?php echo site_url("user/client/set_session_export") ?>",
				data:param,
				success:function(response){
				
				}
			
			
			});
		});
    });
	
	
</script>
<style>
	.masque img{
		width: 15px;
		height: auto;
		cursor:pointer;
	}

</style>
<?php
$column_width = (int) (80 / count($columns));

if (!empty($list)) {
    ?><div class="bDiv" >
	
	<input type='hidden' id='namesearch'  name='namesearch' />
	<input type='hidden' id='namesearchval'  name='namesearchval' />
        <table cellspacing="0" cellpadding="0" border="0" id="flex1">
            <thead>
                <tr class='hDiv'>
					<div id="hidden-operations" class="hidden-operations"></div>
                    <?php 
					$icol = 0;
					foreach ($columns as $column) { ?>
                        <th width='<?php echo $column_width ?>%' class='th_<?php echo $icol; ?>  th_tous' data="<?php echo $column->field_name; ?>" rel="th_<?php echo $icol; ?>">
							<div class="masque" style="float:right;"><img class="masque_col" src="<?php echo site_url("assets/backend/design/masque.png"); ?>" /></div>
                            <div class="text-left field-sorting <?php if (isset($order_by[0]) && $column->field_name == $order_by[0]) { ?><?php echo $order_by[1] ?><?php } ?>" 
                                 rel='<?php echo $column->field_name ?>'>
								 
                                     <?php echo $column->display_as ?>
									
                            </div>
                        </th>
                    <?php 
					
						$icol++;
					} ?>
                    <?php if (!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)) { ?>
                        <th align="left" abbr="tools" axis="col1" class="" width='20%'>
                            <div class="text-right">
                                <?php echo $this->l('list_actions'); ?>
                            </div>
                        </th>
                    <?php } ?>
                </tr>
                <tr>
                    <?php 
					
					$icol = 0;
					foreach($columns as $column){
					if( $column->field_name == "sending_date" ) $sending_field = $icol;
					?>
                        <th class="action_toogle th_<?php echo $icol; ?>  th_tous">
                            <input type="text" name="<?php echo $column->field_name; ?>" placeholder="<?php echo $this->l('list_search').' '.$column->display_as; ?>" class="get_action_toogle_search seach_flexigrid search_<?php echo $column->field_name; ?>"/>
                            <i class="action_toogle_search fa fa-search" aria-hidden="true" style="color: blue;" onClick="action_toogle_search()"></i>
                        </th>
                    <?php 
					$icol++;
					
					}?>
                    <?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
                        <th>
                            
                        </th>
                    <?php }?>
                </tr>
            </thead>		
            <tbody>
                <?php foreach ($list as $num_row => $row) { ?>
                    <?php if (!$unset_read) { ?>
                        <tr data-href="<?php echo $row->read_url ?>" class="clickable-row<?php echo ($num_row % 2 == 1) ? " erow" : "" ?>">
                        <?php } else if(!$unset_edit) { ?>
                        <tr data-href="<?php echo $row->edit_url ?>"class="clickable-row<?php echo ($num_row % 2 == 1) ? 'erow' : ''?>">
                        <?php }
						else{
						?>
						 <tr class="<?php echo ($num_row % 2 == 1) ? 'erow' : ''?>">
						
						<?php }


						?>
                        <?php 
						
						$icol = 0;
						foreach ($columns as $column) { ?>
                            <td width='<?php echo $column_width ?>%' class='th_<?php echo $icol; ?>  th_tous <?php if (isset($order_by[0]) && $column->field_name == $order_by[0]) { ?>sorted<?php } ?>'>
                                <div class='text-left<?php echo (ucfirst($subject) == 'Alerte' &&  $row->{$column->field_name} == 'non' ? ' not-acquitted' : '')?>'><?php 
                                
                                $tst = substr(str_replace("/","-",$row->{$column->field_name}),0,10);
                                if ( $column->field_name == "sending_date"  && strtotime($tst) < strtotime("01-01-2000") ) {
                                 echo "<b>immédiat</b> ";
                                } else {
                                echo $row->{$column->field_name} != '' ? $row->{$column->field_name} : '&nbsp;';
                                } 
                                ?></div>
                            </td>
                        <?php 
						
						$icol++;
						} ?>
                        <?php if (!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)) { ?>
                            <td align="left" width='20%'>
                                <div class='tools'>				
                                    <?php if (!$unset_delete && isset($row->{'sending_date'}) ) { 
                                       if ( strtotime(substr(str_replace("/","-",$row->{'sending_date'}),0,10)) > time()) { ?>
                                        <a href='<?php echo $row->delete_url ?>' title='<?php echo $this->l('list_delete') ?> <?php echo $subject ?>' class="delete-row" >
                                            <span class='delete-icon'></span>
                                        </a>
                                    <?php 
                                       }
                                       } else {?>
                                       <a href='<?php echo $row->delete_url ?>' title='<?php echo $this->l('list_delete') ?> <?php echo $subject ?>' class="delete-row" >
                                            <span class='delete-icon'></span>
                                       </a>
                                    <?php   } ?>
                                    <?php if (!$unset_edit && isset($row->{'sending_date'}) ) {
                                      if ( strtotime(substr(str_replace("/","-",$row->{'sending_date'}),0,10)) > time()) { ?>
                                        <a href='<?php echo $row->edit_url ?>' title='<?php echo $this->l('list_edit') ?> <?php echo $subject ?>' class="edit_button"><span class='edit-icon'></span></a>
                                    <?php 
                                        }
                                        } else {?>
                                        <a href='<?php echo $row->edit_url ?>' title='<?php echo $this->l('list_edit') ?> <?php echo $subject ?>' class="edit_button"><span class='edit-icon'></span></a>
                                    <?php 
                                        }
                                        
                                     if (!$unset_read){  ?>
                                        <a href='<?php echo $row->read_url ?>' title='<?php echo $this->l('list_view') ?> <?php echo $subject ?>' class="edit_button"><span class='read-icon'></span></a>
                                    <?php } ?>
                                    <?php
                                    if (!empty($row->action_urls)) {
                                        foreach ($row->action_urls as $action_unique_id => $action_url) {
                                            $action = $actions[$action_unique_id];
											
											if(!empty($row->acquitted)){
												
												if($row->acquitted=="oui")
												{
													if($action->label!="Acquitter")
													{
														?> <a href="<?php echo $action_url; ?>" class="<?php echo $action->css_class; ?> crud-action" title="<?php echo $action->label ?>"><?php
														if (!empty($action->image_url)) {
															?><img src="<?php echo $action->image_url; ?>" alt="<?php echo $action->label ?>" /><?php
														}
														?></a>
													
														<?php 
													}
												}
												else
												{
														?><a href="<?php echo $action_url; ?>" class="<?php echo $action->css_class; ?> crud-action" title="<?php echo $action->label ?>"><?php
														if (!empty($action->image_url)) {
															?><img src="<?php echo $action->image_url; ?>" alt="<?php echo $action->label ?>" /><?php
														}
														?></a>
													
												<?php }
													
											
											}
											else{
                                            ?>
                                            <a href="<?php echo $action_url; ?>" class="<?php echo $action->css_class; ?> crud-action" title="<?php echo $action->label ?>"><?php
                                                if (!empty($action->image_url)) {
                                                    ?><img src="<?php echo $action->image_url; ?>" alt="<?php echo $action->label ?>" /><?php
                                                }
                                                ?></a>		
                                            <?php
											}
                                        }
                                    }
                                    ?>					
                                    <div class='clear'></div>
                                </div>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>        
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->l('list_no_items'); ?>
    <br/>
    <br/>
<?php } ?>	
