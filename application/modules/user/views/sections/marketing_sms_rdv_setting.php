<link href="<?php echo site_url('assets/libraries/grocery_crud/themes/flexigrid/css/flexigrid.css') ?>" rel="stylesheet"> 
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard') ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo site_url('user/marketing/request') ?>">Marketing</a></li>
    <li class="breadcrumb-item active">Notification RDV</li>
</ol>
<div class="flexigrid crud-form" style="width: 100%;">
    <div id="main-table-box">
        <form id="sms-rdv-setting" class="form-inline" method="post">
            <p class="bg-yellow">Cet outil vous permet d'activer ou de d&eacute;sactiver par d&eacute;faut, les notifications SMS lors de la cr&eacute;tion de RDV.
                Les notifications seront envoy&eacute; la veille du RDV (J-1)</p>
            <div class="form-div">
                <div class="form-field-box odd">
                    <div class="form-display-as-box">
                        <label for="sms-notification">Activer notification SMS</label>
                        <input type="checkbox" id="sms-notification" name="sms-notification" <?php echo isset($current_setting) && $current_setting->rdv_notification ? ' checked="checked"' : '' ?>/>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="form-field-box odd">
                    <input type="submit" value="Enregistrer" id="submit" name="submit" />
                </div>
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>