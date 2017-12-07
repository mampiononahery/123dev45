<script type="text/javascript">








    $(document).ready(function () {
        var cities = new Array();
        if ($("input#field-cp").length) {
            $('#field-cp').autocomplete({
                source: function (request, response) {
                    $.getJSON("<?php echo site_url('user/ajax/search_cities') ?>?criteria=" + request.term, function (data) {
                        response($.map(data, function (item) {
                            cities[item.postal_code] = item.name
                            return item.postal_code;
                        }));
                    });
                },
                minLength: 2,
                delay: 100,
                select: function (event, ui) {
                    selected = ui.item.value;
                    $('#field-ville').val(cities[ui.item.value]);
                }
            });
        }
        $('.export-anchor').attr('data-url', '<?php echo site_url('user/client/export_all') ?>');
        <?php if (isset($action_read) && $action_read) : ?>
        $('input[type="text"], textarea').attr('readonly', 'readonly');
        $('input[type="radio"], select').attr('disabled', 'disabled');
        <?php endif; ?>
		
    });
</script>




<?php if (!empty($client) && isset($client)): ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?php echo site_url('user/client') ?>">Mes clients</a></li>
        <li class="breadcrumb-item active">Fiche client <strong><?php echo ucwords($client->nom . ' ' . $client->prenom) ?></strong></li>
    </ol>
	
	
	
    <?php if (isset($order_stories)): ?>
       
    <?php endif; ?>
    <div class="flexigrid">
        <?php
        $condition_true = "<span class=\"condition_true\"\>Envoi SMS activ&eacute;</span>";
        $condition_false = "<span class=\"condition_false\"\>Envoi SMS d&eacute;sactiv&eacute;</span>";
        $action_true = "<a href=\"" . site_url('user/client/sms_desactivation/' . $client->client_id) . "\">D&eacute;sactiver</buton>";
        $action_false = "<a href=\"" . site_url('user/client/sms_activation/' . $client->client_id) . "\">Activer</buton>";
        ?>
        <div class="widget_maged">
            <div class="widget widget-stats bg-orange-lighter">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-birthday-cake fa-fw"></i></div>
                <div class="stats-title"><?php echo $client->sms_versaire ? $condition_true : $condition_false; ?></div>
                <div class="stats-desc"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;<?php echo $client->sms_versaire ? $action_true : $action_false; ?></div>
            </div>
        </div>
        <div class="widget_maged">
            <div class="widget widget-stats bg-green-darker">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-file-text-o fa-fw"></i></div>
                <div class="stats-title">Documents</div>
                <div class="stats-desc"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;<a href="<?php echo site_url('user/client/data/' . $client->client_id) ?>">G&eacute;rer</a></div>
            </div>
        </div>
        <div class="widget_maged">
            <div class="widget widget-stats bg-aqua">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-file-pdf-o fa-fw"></i></div>
                <div class="stats-title">Contrats</div>
                <div class="stats-desc"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;<a href="<?php echo site_url('user/client/contract/' . $client->client_id) ?>">G&eacute;rer contrats</a></div>
            </div>
        </div>
        <div class="widget_maged">
            <div class="widget widget-stats bg-green-lighter">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-bell-o fa-fw"></i></div>
                <div class="stats-title">Alertes</div>
                <div class="stats-desc"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;<a href="<?php echo site_url('user/client/alerte/' . $client->client_id) ?>">G&eacute;rer alertes</a></div>
            </div>
        </div>
        <div class="widget_maged">
            <div class="widget widget-stats bg-purple">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-calendar-check-o fa-fw"></i></div>
                <div class="stats-title">RDV</div>
                <div class="stats-desc"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;<a href="<?php echo site_url('user/client/rdv/' . $client->client_id) ?>">G&eacute;rer RDV</a></div>
            </div>
        </div>
        <div class="widget_maged">
            <div class="widget widget-stats bg-yellow-darker">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-sticky-note-o fa-fw"></i></div>
                <div class="stats-title">Notes</div>
                <div class="stats-desc"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;<a href="<?php echo site_url('user/client/notice/' . $client->client_id) ?>">G&eacute;rer notes</a></div>
            </div>
        </div>
        <!-- Nouveau -->
        <div class="widget_maged">
            <div class="widget widget-stats bg-yellow-darker" style="background: #d899f0;">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-sticky-note-o fa-fw"></i></div>
                <div class="stats-title">Mes Achats</div>
                <div class="stats-desc"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;<a href="<?php echo site_url('user/client/historique_achat/' . $client->client_id) ?>">G&eacute;rer achat</a></div>
            </div>
        </div>
    </div>
<?php else: ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?php echo site_url('user/client') ?>">Mes clients</a></li>
        <li class="breadcrumb-item active">Fiche</li>
    </ol>
    <p class="bg-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;Veuillez ouvrir la fiche de votre client pour voir les documents rattach&eacute;s</p>
<?php endif; ?>
<?php echo isset($output) ? $output : ''; ?>
<?php if (!empty($client) && isset($client)): ?>
    <iframe id="myiframe" width="100%" frameborder='0' scrolling="no"src="<?php echo site_url('user/object/index/' . $client->client_id) ?>"></iframe>
    <!-- <div id="content_type"></div> -->
<?php endif; ?>


<script type="text/javascript">

        function alertsize(pixels){
            pixels+=32;
            document.getElementById('myiframe').style.height=pixels+"px";
        }
		function alertsize2(pixels){
            pixels+=32;
            document.getElementById('myiframe_achat').style.height=pixels+"px";
        }
		
		//$("#sms_versaire_field_box").hide();
 
    
</script>