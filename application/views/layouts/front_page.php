<!DOCTYPE html>
<!-- WatzGaming - Startup Landing Page Template design by DSA79 (http://www.dsathemes.com) -->
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="fr"> <!--<![endif]-->
    <head>
        <!-- Basic -->
        <meta charset="utf-8">
        <title><?php echo $title_for_layout ?></title>
        <meta name="keywords" content="">
        <meta name="description" content="">		
        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">		
        <!-- CSS -->
        <link href="<?php echo base_url('assets/frontend/css/bootstrap.css') ?>" rel="stylesheet"> 		
        <link href="<?php echo base_url('assets/frontend/css/font-awesome.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/frontend/css/powercrm.css') ?>" rel="stylesheet">  
        <!-- Jquery -->
        <script src="<?php echo base_url('assets/frontend/js/jquery-2.1.0.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/frontend/js/bootstrap.min.js') ?>" type="text/javascript"></script>	
        <!-- Favicons -->	
        <link rel="shortcut icon" href="<?php echo base_url('assets/frontend/design/icons/favicon.ico') ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url('assets/frontend/design/icons/apple-touch-icon-114x114.png') ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url('assets/frontend/design/icons/apple-touch-icon-72x72.png') ?>">
        <link rel="apple-touch-icon" href="<?php echo base_url('assets/frontend/design/icons/apple-touch-icon.png') ?>">
        <!-- Google Fonts -->	
        <link href='http://fonts.googleapis.com/css?family=Lato:400,900italic,900,700italic,400italic,300italic,300,100italic,100' rel='stylesheet' type='text/css'>
        <link href="//fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
    </head>
    <body>
        <!-- HEADER
        ============================================= -->
        <header id="header">
            <div class="navbar navbar-fixed-top">	
                <div class="container">
                    <!-- Logo & Responsive Menu -->
                    <div class="navbar-header">
                        <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-menu">
                            <span class="sr-only">Toggle navigation</span> 
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?php echo base_url('/') ?>"><img src="<?php echo base_url('assets/frontend/design/logo.png') ?>" alt="logo" role="banner"></a>
                    </div>	<!-- End navbar-header -->
                    <!-- Navigation -->
                    <nav id="navigation-menu" class="collapse navbar-collapse"  role="navigation">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="<?php echo base_url('auth/login') ?>"><i class="fa fa-user" aria-hidden="true"></i></a></li>
                            <li><a href="<?php echo base_url('auth/logout') ?>"><i class="fa fa-sign-out" aria-hidden="true"></i></a></li>
                        </ul>
                    </nav><!-- End navbar-collapse -->
                </div><!-- End container -->
            </div><!-- End navbar -->
        </header><!-- END HEADER -->
        <!-- CONTENT WRAPPER
        ============================================= -->
        <div id="content-wrapper">
            <div class="main-wrapper container">
                <?php echo $content_for_layout; ?>
            </div>
            <!-- FOOTER
            ============================================= -->
            <footer id="footer">
                <div class="container">	
                    <div class="row">
                        <!-- Footer Navigation Menu -->
                        <div id="footer_nav" class="col-sm-6 col-md-4">
                            <div id="footer_copy">
                                <p>&copy; Copyright 2017 <span>PowerCRM</span> Tous droits r&eacute;serv&eacute;s</p>
                            </div>							
                        </div><!-- End Footer Navigation Menu -->
                    </div><!-- End row -->						
                </div><!-- End container -->		
            </footer><!-- END FOOTER -->
        </div><!-- END CONTENT WRAPPER -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </body>
</html>