<link href="<?php echo site_url('assets/libraries/grocery_crud/themes/flexigrid/css/flexigrid.css') ?>" rel="stylesheet"> 
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard') ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo site_url('user/marketing/request') ?>">Marketing</a></li>
    <li class="breadcrumb-item active">Notification RDV</li>
</ol>
<div class="flexigrid crud-form" style="width: 100%;">
    <div id="main-table-box">
        <form id="sms-rdv-setting" class="form-inline" method="post">
            <p class="bg-yellow">Cet outil permet de d&eacute;finir les timings d'envoi de message de notification. 
                <br />Par d&eacute;faut les notifications sont envoy&eacute;es <strong>7 jours &agrave; l'avance pour les notifications d'anniversaire</strong> et <strong>1 jour pour les RDV.</strong></p>
            <div class="form-div">
                <div class="form-field-box odd">
                    <div class="form-display-as-box">
                        <label for="rdv_notification_start">Timing RDV</label>
                        <input type="text" id="rdv_notification_start" name="rdv_notification_start" value="<?php echo isset($current_setting) ? $current_setting->rdv_notification_start : 1 ?>"/>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="form-field-box even">
                    <div class="form-display-as-box">
                        <label for="birthday_notification_start">Timing anniversaire</label>
                        <input type="text" id="birthday_notification_start" name="birthday_notification_start" value="<?php echo isset($current_setting) ? $current_setting->birthday_notification_start : 7 ?>"/>
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