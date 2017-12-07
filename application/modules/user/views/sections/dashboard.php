<!-- begin page-header -->
<h1 class="page-header">Bienvenu sur votre espace de gestion</h1>
<!-- end page-header -->
<!-- begin row -->
<div class="row">
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
            <div class="stats-title">Dashboard</div>
            <div class="stats-desc">Votre espace de gestion</div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-blue">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-tags fa-users"></i></div>
            <div class="stats-title">Clients</div>
            <div class="stats-desc"><a href="<?php echo site_url('user/client/') ?>">Voir les clients</a></div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-purple">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-calendar fa-fw"></i></div>
            <div class="stats-title">Agenda</div>
            <div class="stats-desc"><a href="<?php echo site_url('user/calendar/') ?>">Acc&eacute;der &agrave; mon agenda</a></div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-black">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-product-hunt fa-fw"></i></div>
            <div class="stats-title">Production</div>
            <div class="stats-desc"><a href="<?php echo site_url('user/production/') ?>">Voir les produits</a></div>
        </div>
    </div>
    <!-- end col-3 -->
    <div class="col-md-12 col-sm-12">
        <?php echo isset($output) ? $output : ''; ?>
    </div>
</div>
<!-- end row -->