<script type="text/javascript">
    $(document).ready(function ($) {
        $(".clickable-row").click(function () {
            window.location = $(this).data("href");
        });
        $(".not-acquitted").closest('tr').addClass('bg-asphalt');
    });
</script>
<?php
$column_width = (int) (80 / count($columns));

if (!empty($list)) {
    ?><div class="bDiv" >
	
	<input type='hidden' id='namesearch'  name='namesearch' />
	<input type='hidden' id='namesearchval'  name='namesearchval' />
        <table cellspacing="0" cellpadding="0" border="0" id="flex1">
            <thead>
                <tr class='hDiv'>
                    <?php foreach ($columns as $column) { ?>
                        <th width='<?php echo $column_width ?>%'>
                            <div class="text-left field-sorting <?php if (isset($order_by[0]) && $column->field_name == $order_by[0]) { ?><?php echo $order_by[1] ?><?php } ?>" 
                                 rel='<?php echo $column->field_name ?>'>
                                     <?php echo $column->display_as ?>
                            </div>
                        </th>
                    <?php } ?>
                    <?php if (!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)) { ?>
                        <th align="left" abbr="tools" axis="col1" class="" width='20%'>
                            <div class="text-right">
                                <?php echo $this->l('list_actions'); ?>
                            </div>
                        </th>
                    <?php } ?>
                </tr>
                <tr>
                    <?php foreach($columns as $column){?>
                        <th class="action_toogle">
                            <input type="text" name="<?php echo $column->field_name; ?>" placeholder="<?php echo $this->l('list_search').' '.$column->display_as; ?>" class="get_action_toogle_search seach_flexigrid search_<?php echo $column->field_name; ?>"/>
                            <i class="action_toogle_search fa fa-search" aria-hidden="true" style="color: blue;" onClick="action_toogle_search()"></i>
                        </th>
                    <?php }?>
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
                        <?php } else { ?>
                        <tr class="<?php echo ($num_row % 2 == 1) ? 'erow' : ''?>">
                        <?php } ?>
                        <?php foreach ($columns as $column) { ?>
                            <td width='<?php echo $column_width ?>%' class='<?php if (isset($order_by[0]) && $column->field_name == $order_by[0]) { ?>sorted<?php } ?>'>
                                <div class='text-left<?php echo (ucfirst($subject) == 'Alerte' &&  $row->{$column->field_name} == 'non' ? ' not-acquitted' : '')?>'><?php echo $row->{$column->field_name} != '' ? $row->{$column->field_name} : '&nbsp;'; ?></div>
                            </td>
                        <?php } ?>
                        <?php if (!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)) { ?>
                            <td align="left" width='20%'>
                                <div class='tools'>				
                                    <?php if (!$unset_delete) { ?>
                                        <a href='<?php echo $row->delete_url ?>' title='<?php echo $this->l('list_delete') ?> <?php echo $subject ?>' class="delete-row" >
                                            <span class='delete-icon'></span>
                                        </a>
                                    <?php } ?>
                                    <?php if (!$unset_edit) { ?>
                                        <a href='<?php echo $row->edit_url ?>' title='<?php echo $this->l('list_edit') ?> <?php echo $subject ?>' class="edit_button"><span class='edit-icon'></span></a>
                                    <?php } ?>
                                    <?php if (!$unset_read) { ?>
                                        <a href='<?php echo $row->read_url ?>' title='<?php echo $this->l('list_view') ?> <?php echo $subject ?>' class="edit_button"><span class='read-icon'></span></a>
                                    <?php } ?>
                                    <?php
                                    if (!empty($row->action_urls)) {
                                        foreach ($row->action_urls as $action_unique_id => $action_url) {
                                            $action = $actions[$action_unique_id];
											
											if( $action->label=="Acquitter" ){
												if($row->acquitted!="oui"){ ?>
														 <a href="<?php echo $action_url; ?>" class="<?php echo $action->css_class; ?> crud-action" title="<?php echo $action->label ?>"><?php
														if (!empty($action->image_url)) {
															?><img src="<?php echo $action->image_url; ?>" alt="<?php echo $action->label ?>" /><?php
														}
														?></a>	
												
												<?php }
											}
                                            else { ?>
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
