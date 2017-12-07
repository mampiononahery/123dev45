<?php if (isset($view_mode) && $view_mode): ?>
    <script type="text/javascript">
        $(document).ready(function ($) {
            $('.switch-input').prop("disabled", true);
        });
    </script>
<?php endif; ?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard') ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">Ressources</li>
</ol>
<?php echo isset($output) ? $output : ''; ?>