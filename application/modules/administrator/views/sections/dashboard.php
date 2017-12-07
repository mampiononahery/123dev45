<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li><a href="javascript:;">Accueil</a></li>
    <li class="active">Dashboard</li>
</ol>
<!-- end breadcrumb -->
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
            <div class="stats-number">&nbsp;</div>
            <div class="stats-desc">Votre espace de gestion</div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-blue">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-tags fa-users"></i></div>
            <div class="stats-title">Utilisateurs</div>
            <div class="stats-number">&nbsp;</div>
            <div class="stats-desc"><a href="<?php echo base_url('administrator/user') ?>">Voir les utilisateurs</a></div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-purple">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-database fa-fw"></i></div>
            <div class="stats-title">Types de document</div>
            <div class="stats-number">&nbsp;</div>
            <div class="stats-desc"><a href="<?php echo base_url('administrator/datatype') ?>">G&eacute;rer les types de document</a></div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-black">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-cog fa-fw"></i></div>
            <div class="stats-title">Couleurs et pr&eacute;f&eacute;rences</div>
            <div class="stats-number">&nbsp;</div>
            <div class="stats-desc"><a href="<?php echo base_url('administrator/color/') ?>">G&eacute;rer mes pr&eacute;f&eacute;rences</a></div>
        </div>
    </div>
    <!-- end col-3 -->
    <div class="col-md-12 col-sm-12">
        <?php echo isset($output) ? $output : ''; ?>
    </div>
</div>
<!-- end row -->