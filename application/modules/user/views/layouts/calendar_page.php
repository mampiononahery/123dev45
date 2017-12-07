<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title><?php echo $title_for_layout ?></title> 
        <meta name="keywords" content="HTML5 Template" />
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width,  minimum-scale=1,  maximum-scale=1">

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

        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/jquery-ui.min.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/bootstrap.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/style.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/style-responsive.min.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/default.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/font-awesome.min.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/app.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/libraries/dhtmlxScheduler/dhtmlxscheduler.css') ?>">
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/libraries/dhtmlxScheduler/dhtmlxscheduler_flat.css') ?>">
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/libraries/dhtmlxScheduler/dhtmlxscheduler.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/jquery.switchbutton.css') ?>">
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/bootstrap-select.min.css') ?>">
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/calendar.css') ?>">

        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/frontend/design/icons/favicon.ico') ?>" />
        <script type="text/javascript" src="<?php echo base_url('assets/backend/js/jquery.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/backend/js/pace.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/backend/js/moment.js') ?>" type="text/javascript"></script>
        
        <script type="text/javascript">
            $(function () {
                $('.action-btn').on('click', function (e) {
                    e.preventDefault();
                    $source = $(this).attr('href');
                    $.ajax({
                        url: $source,
                        dataType: "json",
                        success: function (data) {
                            if (data.update_status) {
                                var element_id = ".check_alerte_" + data.alerte_id;
                                $('ul.navbar-nav > li').first().addClass('open');
                                $(element_id).append('<span class="notice">Alerte acquitt&eacute;e</span>');
                                setTimeout(function () {
                                    $nb = parseInt($('ul.navbar-nav span.label').text());
                                    if ($nb >= 1) {
                                        $('ul.navbar-nav span.label').text($nb - 1);
                                    }
                                    $(element_id).remove();
                                }, 2000);
                            }
                        },
                        error: function () {
                            alert("Erreur pendant le chargement...");
                        }
                    });
                });
            });
        </script>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body<?php echo isset($birthday_is_closed) && $birthday_is_closed ? ' class="alerte_birthday"' : '' ?>>
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
                        <?php if (isset($user) && !empty($user->photo_use)): ?>
                            <a href="<?php echo site_url('/') ?>" class="navbar-brand"><img class="logo" src="<?php echo site_url('assets/uploads/profile/' . $user->photo_use) ?>" alt="logo"/></a>
                        <?php else: ?>
                            <a href="<?php echo site_url('/') ?>" class="navbar-brand"><img class="logo" src="<?php echo site_url('assets/frontend/design/logo.png') ?>" alt="logo"/></a>
                        <?php endif; ?>
                        <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <!-- end mobile sidebar expand / collapse button -->
                    <!-- begin header navigation right -->
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (isset($alertes)) : ?>
                            <li class="dropdown">
                                <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label"><?php echo sizeof($alertes) ?></span>
                                </a>
                                <ul class="dropdown-menu media-list pull-right animated fadeInDown">
                                    <li class="dropdown-header">Notifications (<?php echo sizeof($alertes) ?>)</li>
                                    <?php foreach ($alertes AS $alerte): ?>
                                        <li class="media check_alerte_<?php echo $alerte->alerte_id ?>">
                                            <div class="media-left"><i class="fa fa-bell-o media-object bg-red"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">
                                                    <a href="<?php echo site_url('user/alerte/index/read/' . $alerte->alerte_id) ?>">
                                                        Alerte client "<strong><i><?php echo ucfirst($alerte->nom . ' ' . $alerte->prenom) ?></i></strong>"</a></h6>
                                                <div class="text-muted f-s-11">
                                                    <?php echo $alerte->dt_real ?>
                                                    <a class="action-btn" href="<?php echo site_url('user/ajax/close_alerte/' . $alerte->alerte_id) ?>" title="Acquitter"><i class="fa fa-check" aria-hidden="true"></i> Acquitter</a>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <li class="dropdown navbar-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user-o" aria-hidden="true"></i>&nbsp;<span class="hidden-xs">Mon compte</span> <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu animated fadeInLeft">
                                <li class="arrow"></li>
                                <li><a href="<?php echo site_url('user/dashboard/profile') ?>">Mon profil</a></li>
                                <li><a href="<?php echo site_url('user/calendar/resource') ?>">G&eacute;rer les ressources</a></li>
                                <li><a href="<?php echo site_url('user/marketing/sms') ?>">Envoi SMS</a></li>
								<li>
									<a onClick="window.open('<?php echo site_url('user/ajax/generer_lien_ical') ?>')"  title="Ical">
										
										Ical
									</a>
								</li>

                                <li><a href="<?php echo site_url('user/marketing/sms_pattern') ?>">Mod&egrave;les SMS</a></li>
                                <li><a href="<?php echo site_url('user/marketing/sms_cron_setting') ?>">Param&egrave;tres de notification SMS</a></li>
                                <li><a href="<?php echo site_url('user/marketing/sms_rdv_setting') ?>">Notification RDV par SMS</a></li>
                                <li><a href="<?php echo site_url('user/dashboard/password/') ?>">G&eacute;rer mot de passe</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo site_url('auth/logout') ?>">Se d&eacute;connecter</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- end header navigation right -->
                </div>
                <!-- end container-fluid -->
            </div>
            <!-- end #header -->
            <!-- begin #sidebar -->
            <div id="sidebar" class="sidebar">
                <!-- begin sidebar scrollbar -->
                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;">
                    <div data-scrollbar="true" data-height="100%" data-init="true" style="margin-top: 0px; overflow: hidden; width: auto; height: 100%;">
                        <!-- begin sidebar nav--> 
                        <ul class="nav">
                            <li class="has-sub active">
                                <a href="javascript:;" title="Dashboard">
                                    <b class="caret pull-right"></b>
                                    <i class="fa fa-laptop"></i>
                                    <span>Dashboard</span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="active"><a href="<?php echo site_url('user/dashboard') ?>">Tableau de bord</a></li>
                                    <li><a href="<?php echo site_url('user/dashboard/profile') ?>">Mon profil</a></li>
                                    <li><a href="<?php echo site_url('user/calendar/resource') ?>">G&eacute;rer les ressources</a></li>
                                    <li><a href="<?php echo site_url('user/marketing/sms') ?>">Envoi SMS</a></li>
                                    <li><a href="<?php echo site_url('user/marketing/sms_pattern') ?>">Mod&egrave;les SMS</a></li>
                                    <li><a href="<?php echo site_url('user/marketing/sms_cron_setting') ?>">Param&egrave;tres de notification SMS</a></li>
                                    <li><a href="<?php echo site_url('user/marketing/sms_rdv_setting') ?>">Notification RDV par SMS</a></li>
                                    <li><a href="<?php echo site_url('user/dashboard/password/') ?>">G&eacute;rer mot de passe</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo site_url('user/client') ?>" title="Mes clients">
                                    <i class="fa fa-user"></i>
                                    <span>Mes clients</span> 
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('user/artisan') ?>" title="Mes artisans">
                                    <i class="fa fa-star"></i> 
                                    <span>Mes artisans</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('user/alerte/') ?>" title="Mes alertes">
                                    <i class="fa fa-bell-o"></i>
                                    <span>Mes alertes</span> 
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('user/production') ?>" title="Production">
                                    <i class="fa fa-th"></i>
                                    <span>Production</span>
                                </a>
                            </li>
							
                            <li>
                                <a href="<?php echo site_url('user/calendar') ?>" title="Agenda">
                                    <i class="fa fa-calendar-plus-o"></i>
                                    <span>Agenda</span>
                                </a>
                            </li>
							
							
                            <li class="has-sub">
                                <a href="javascript:;" title="Marketing">
                                    <b class="caret pull-right"></b>
                                    <i class="fa fa-area-chart"></i>
                                    <span>Marketing</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="<?php echo site_url('user/marketing/request') ?>">Cr&eacute;er une requ&ecirc;te</a></li>
                                    <li><a href="<?php echo site_url('user/marketing/listing') ?>">Mes requ&ecirc;tes</a></li>
                                    <li><a href="<?php echo site_url('user/marketing/campagne') ?>">Mes Campagnes SMS</a></li>
                                    <li><a href="<?php echo site_url('user/marketing/stats') ?>">Statistiques</a></li>
                                </ul>
                            </li>
                            <!-- begin sidebar minify button--> 
                            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
                            <!-- end sidebar minify button--> 
                        </ul>
                        <!-- end sidebar nav--> 
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

        <script type="text/javascript" src="<?php echo base_url('assets/backend/js/jquery-ui.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/backend/js/bootstrap.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/backend/js/bootstrap-select.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/libraries/dhtmlxScheduler/dhtmlxscheduler.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/libraries/dhtmlxScheduler/ext/dhtmlxscheduler_editors.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/libraries/dhtmlxScheduler/ext/dhtmlxscheduler_tooltip.js') ?>"></script>

        <script src="<?php echo base_url('assets/libraries/dhtmlxScheduler/locale/locale_fr.js') ?>" charset="utf-8"></script>
        <script src="<?php echo base_url('assets/backend/js/jquery.switchbutton.js') ?>" charset="utf-8"></script>
        <script src="<?php echo base_url('assets/backend/js/app.min.js') ?>"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                App.init();

                /* CALENDAR */
                $("body").delegate("input[name='ref']", "change", function () {
                    $('.dhx_cal_radio label').removeClass('active');
                    $("input[name='ref']").each(function (index) {
                        if ($(this).is(':checked')) {
                            $(".dhx_cal_radio label").eq(index).addClass('active');
                        }
                    });
                });
                $("body").delegate(".qte", "change", function () {
                    var qte = parseFloat($(this).val());
                    var prix = parseFloat($(this).parents('td').siblings('.prixttcwrapper').find('.prod_prix_ttc').val());
                    var allTot = 0;
                    var remise = parseInt($(this).parents('td').siblings('.remisewrapper').find('.remise').val());
                    var totalRemise = (((remise * prix) / 100) * qte).toFixed(2);
                    var totalTTC = (prix * qte) - totalRemise;
                    $(this).parents('td').siblings('.totalttcwrapper').find('.prix_ttc').val((totalTTC.toFixed(2)));
                    $(".totalttcwrapper .prix_ttc").each(function (index) {
                        allTot = parseFloat($('.totalttcwrapper .prix_ttc').eq(index).val()) + allTot;
                    });
                    $('.allTot').text(allTot);
                });
                $("body").delegate(".r-plus", "click", function () {
                    var remise = parseInt($(this).siblings('.remise').val());
                    var prix = parseFloat($(this).parents('td').siblings('.prixttcwrapper').find('.prod_prix_ttc').val());
                    var qte = parseInt($(this).parents('td').siblings('.qtewrapper').find('.qte').val());
                    if (remise < 101) {
                        $(this).siblings('.remise').val(remise + 1);
                        remise = remise + 1;
                        var totalRemise = (((remise * prix) / 100) * qte).toFixed(2);
                        var totalTTC = (prix * qte) - totalRemise;
                        $(this).parents('td').siblings('.totalttcwrapper').find('.prix_ttc').val(totalTTC.toFixed(2));
                    }
                    var allTot = 0;
                    $(".totalttcwrapper .prix_ttc").each(function (index) {
                        allTot = parseFloat($('.totalttcwrapper .prix_ttc').eq(index).val()) + allTot;
                    });
                    $('.allTot').text(allTot.toFixed(2));
                });
                $("body").delegate(".r-moins", "click", function () {
                    var remise = parseInt($(this).siblings('.remise').val());
                    var prix = parseFloat($(this).parents('td').siblings('.prixttcwrapper').find('.prod_prix_ttc').val());
                    var qte = parseInt($(this).parents('td').siblings('.qtewrapper').find('.qte').val());
                    if (remise > 0) {
                        $(this).siblings('.remise').val(remise - 1);
                        remise = remise - 1;
                        var totalRemise = (((remise * prix) / 100) * qte).toFixed(2);
                        var totalTTC = (prix * qte) - totalRemise;
                        $(this).parents('td').siblings('.totalttcwrapper').find('.prix_ttc').val(totalTTC.toFixed(2));
                    }
                    var allTot = 0;
                    $(".totalttcwrapper .prix_ttc").each(function (index) {
                        allTot = parseFloat($('.totalttcwrapper .prix_ttc').eq(index).val()) + allTot;
                    });
                    $('.allTot').text(allTot.toFixed(2));
                });
                $("body").delegate(".remise", "change", function () {
                    var remise = parseFloat($(this).val());
                    var prix = parseFloat($(this).parents('td').siblings('.prixttcwrapper').find('.prod_prix_ttc').val());
                    var allTot = 0;
                    var qte = parseInt($(this).parents('td').siblings('.qtewrapper').find('.qte').val());
                    var totalRemise = (((remise * prix) / 100) * qte).toFixed(2);
                    var totalTTC = (prix * qte) - totalRemise;
                    $(this).parents('td').siblings('.totalttcwrapper').find('.prix_ttc').val((totalTTC.toFixed(2)));
                    $(".totalttcwrapper .prix_ttc").each(function (index) {
                        allTot = parseFloat($('.totalttcwrapper .prix_ttc').eq(index).val()) + allTot;
                    });
                    $('.allTot').text(allTot);
                });
                /* END CALENDAR */
            });
        </script>
    </body>
</html>