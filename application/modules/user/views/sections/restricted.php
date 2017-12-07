<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard') ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">Restriction</li>
</ol>
<p class="bg-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;Votre compte ne permet pas d'acc&egrave;der &agrave; cette fonctionnalit&eacute;. 
    Merci de contacter notre service commercial</p>
<?php echo isset($output) ? $output : ''; ?>