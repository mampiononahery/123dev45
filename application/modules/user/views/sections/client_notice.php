<?php if (isset($client)) : ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?php echo site_url('user/client') ?>">Mes clients</a></li>
        <li class="breadcrumb-item active">Alertes</li>
    </ol>

    <div class="flexigrid">
        <div class="col-md-2 col-sm-6">
            <div class="widget widget-stats bg-green-darker">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-file-text-o fa-fw"></i></div>
                <div class="stats-title">Documents</div>
                <div class="stats-desc"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;<a href="<?php echo site_url('user/client/data/' . $client->client_id) ?>">G&eacute;rer</a></div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6">
            <div class="widget widget-stats bg-aqua">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-file-pdf-o fa-fw"></i></div>
                <div class="stats-title">Contrats</div>
                <div class="stats-desc"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;<a href="<?php echo site_url('user/client/contract/' . $client->client_id) ?>">G&eacute;rer contrats</a></div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6">
            <div class="widget widget-stats bg-green-lighter">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-bell-o fa-fw"></i></div>
                <div class="stats-title">Alertes</div>
                <div class="stats-desc"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;<a href="<?php echo site_url('user/client/alerte/' . $client->client_id) ?>">G&eacute;rer alertes</a></div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6">
            <div class="widget widget-stats bg-purple">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-calendar-check-o fa-fw"></i></div>
                <div class="stats-title">RDV</div>
                <div class="stats-desc"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;<a href="<?php echo site_url('user/client/rdv/' . $client->client_id) ?>">G&eacute;rer RDV</a></div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6">
            <div class="widget widget-stats bg-yellow-darker">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-sticky-note-o fa-fw"></i></div>
                <div class="stats-title">Notes</div>
                <div class="stats-desc"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;<a href="<?php echo site_url('user/client/notice/' . $client->client_id) ?>">G&eacute;rer notes</a></div>
            </div>
        </div>
    </div>

    <div class="flexigrid content-wrapper">
        <div class="mDiv">
            <div class="ftitle">
                <div class="ftitle-left">Info client</div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="form-div">
            <ul>
                <li>Genre: <?php echo $client->genre ?></li>
                <li>Nom: <?php echo $client->nom ?></li>
                <li>Pr&eacute;nom: <?php echo $client->prenom ?></li>
            </ul>
        </div>
    </div>
<?php else: ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Mes notes</li>
    </ol>
<?php endif; ?>
<?php echo isset($output) ? $output : ''; ?>