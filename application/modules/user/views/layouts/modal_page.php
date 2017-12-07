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
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/style.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/backend/css/app.css') ?>" />
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php echo $content_for_layout; ?>
        <script type="text/javascript" src="<?php echo base_url('assets/backend/js/jquery-ui.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/backend/js/bootstrap.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/backend/js/bootstrap-select.min.js') ?>"></script>
    </body>
</html>