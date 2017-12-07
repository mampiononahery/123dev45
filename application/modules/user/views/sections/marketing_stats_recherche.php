
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
