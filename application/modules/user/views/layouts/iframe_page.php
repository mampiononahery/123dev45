<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title><?php echo $title_for_layout ?></title> 
        <meta name="keywords" content="HTML5 Template" />
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width,  minimum-scale=1,  maximum-scale=1">

        <script type="text/javascript" src="<?php echo site_url('assets/backend/js/jquery.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo site_url('assets/backend/js/jquery-ui.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo site_url('assets/backend/js/bootstrap.min.js') ?>"></script>

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
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/frontend/design/icons/favicon.ico') ?>" />
        <script type="text/javascript" src="<?php echo base_url('assets/backend/js/pace.min.js') ?>"></script>

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
         <?php echo $content_for_layout; ?>

        <script src="<?php echo base_url('assets/backend/js/app.min.js') ?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                App.init();
            });
        </script>
    </body>
</html>