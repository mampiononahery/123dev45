<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title><?php echo $title_for_layout ?></title> 
        <meta name="keywords" content="HTML5 Template" />
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width,  minimum-scale=1,  maximum-scale=1">

        <script type="text/javascript" src="<?php echo base_url('assets/backend/js/jquery.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/backend/js/jquery-ui.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/backend/js/bootstrap.min.js') ?>"></script>

        <?php if (isset($css_files)): ?>
            <?php foreach ($css_files as $file): ?>
                <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (isset($js_files)): ?>
            <?php foreach ($js_files as $file): ?>
                <script type="text/javascript" src="<?php echo $file; ?>"></script>
            <?php endforeach; ?>
        <?php endif; ?>

        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/js/jquery-ui.min.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/bootstrap.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/animate.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/style.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/style-responsive.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/default.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/font-awesome.min.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/app.css') ?>" />
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/frontend/design/icons/favicon.ico') ?>" />
        <script type="text/javascript" src="<?php echo base_url('assets/backend/js/pace.min.js') ?>"></script>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <!-- begin #page-loader -->
        <div id="page-loader" class="fade in"><span class="spinner"></span></div>
        <!-- end #page-loader -->

        <!-- begin #page-container -->
        <div id="page-container" class="fade page-sidebar-minified page-sidebar-fixed page-header-fixed">
            <!-- begin #header -->
            <div id="header" class="header navbar navbar-default navbar-fixed-top">
                <!-- begin container-fluid -->
                <div class="container-fluid">
                    <!-- begin mobile sidebar expand / collapse button -->
                    <div class="navbar-header">
                        <a href="<?php echo base_url('/') ?>" class="navbar-brand"><img class="logo" src="<?php echo base_url('assets/frontend/design/logo.png') ?>" alt="logo"/></a>
                        <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <!-- end mobile sidebar expand / collapse button -->
                    <!-- begin header navigation right -->
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown navbar-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user-o" aria-hidden="true"></i>&nbsp;<span class="hidden-xs">Mon compte</span> <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu animated fadeInLeft">
                                <li class="arrow"></li>
                                <li><a href="<?php echo base_url('administrator/dashboard/profile') ?>">Mon profil</a></li>
                                <li><a href="<?php echo base_url('administrator/dashboard/password/') ?>">Mot de passe</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo base_url('auth/logout') ?>">Se d&eacute;connecter</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- end header navigation right -->
                </div>
                <!-- end container-fluid -->
            </div>
            <!-- end #header -->
            <!-- begin #sidebar -->
            <div id="sidebar" class="sidebar sidebar-admin">
                <!-- begin sidebar scrollbar -->
                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;">
                    <div data-scrollbar="true" data-height="100%" data-init="true" style="margin-top: 0px; overflow: hidden; width: auto; height: 100%;">
                        <!-- begin sidebar nav -->
                        <ul class="nav">
                            <li class="active">
                                <a href="<?php echo base_url('administrator/dashboard') ?>" title="Dashboard">
                                    <i class="fa fa-laptop"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('administrator/user') ?>" title="Utilisateurs">
                                    <i class="fa fa-user"></i>
                                    <span>Utilisateurs</span> 
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('administrator/datatype') ?>" title="Types de document">
                                    <i class="fa fa-database"></i> 
                                    <span>Types de document</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('administrator/color/') ?>" title="Couleurs">
                                    <i class="fa fa-diamond"></i>
                                    <span>Couleurs</span> 
                                </a>
                            </li>
                            <li class="has-sub">
                                <a href="javascript:;" title="Champs entit&eacute; client">
                                    <b class="caret pull-right"></b>
                                    <i class="fa fa-cog"></i>
                                    <span>Champs entit&eacute; client</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="<?php echo base_url('administrator/field/') ?>">Champs</a></li>
                                    <li><a href="<?php echo base_url('administrator/field/option/') ?>">Options</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo base_url('administrator/sms/') ?>" title="SMS">
                                    <i class="fa fa-envelope-o"></i>
                                    <span>SMS</span>
                                </a>
                            </li>
                            <li class="has-sub">
                                <a href="javascript:;" title="Objet client">
                                    <b class="caret pull-right"></b>
                                    <i class="fa fa-cubes"></i>
                                    <span>Objets clients</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="<?php echo base_url('administrator/object/') ?>">Objets</a></li>
                                    <li><a href="<?php echo base_url('administrator/field/object/') ?>">Champs objets</a></li>
                                </ul>
                            </li>
                            <!-- begin sidebar minify button -->
                            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
                            <!-- end sidebar minify button -->
                        </ul>
                        <!-- end sidebar nav -->
                    </div><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 400.3px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                <!-- end sidebar scrollbar -->
            </div>
            <div class="sidebar-bg"></div>
            <!-- end #sidebar -->

            <!-- begin #content -->
            <div id="content" class="content">
                <?php echo $content_for_layout; ?>
            </div>
            <!-- end #content -->
            
            <!-- begin scroll to top btn -->
            <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
            <!-- end scroll to top btn -->
        </div>
        <script src="<?php echo base_url('assets/backend/js/app.min.js') ?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                App.init();
            });
        </script>
    </body>
</html>