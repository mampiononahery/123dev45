<link href="<?php echo site_url('assets/libraries/grocery_crud/themes/flexigrid/css/flexigrid.css') ?>" rel="stylesheet"> 
<script type="text/javascript">
    $(document).ready(function () {
        $(".sms-summary").hide();
        $(".sms-error").hide();
        $("#sms-form").submit(function (event) {
            event.preventDefault();
            var $form = $(this);
            url = $form.attr('action');
            var posting = $.post(url, {sms_contact: $('#sms-contact').val(), sms_text: $('#sms-text').val()});
            posting.done(function (data) {
                if (data.state) {
                    $("#sms-form").hide();
                    $(".sms-summary").show();
                    $(".sms-summary .message_destination_number").html(data.contact);
                    $(".sms-summary .message_body").html(data.text);
                } else {
                    $(".sms-error").show();
                    $(".sms-error .message_destination_number").html(data.contact);
                    $(".sms-error .message_body").html(data.text);
                }
            });
        });
        $("#sms-contact-client").on('change', function () {
            if (this.value !== '0') {
                $("#sms-contact").val(this.value);
            } else {
                $("#sms-contact").val('');
            }
        });
    });
</script>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard') ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo site_url('user/marketing/request') ?>">Marketing</a></li>
    <li class="breadcrumb-item active">Envoi SMS</li>
</ol>
<?php echo isset($output) ? $output : ''; ?>
<div class="flexigrid crud-form" style="width: 100%;">
    <div id="main-table-box">
        <div class="flexigrid sms-summary form-inline">
            <p>Message "<span class="message_body"></span>" envoy&eacute; au <span class="message_destination_number"></span></p>
        </div>
        <div class="flexigrid sms-error form-inline">
            <p>Erreur d'envoi du message "<span class="message_body"></span>" au <span class="message_destination_number"></span>
                <br />Veuillez v&eacute;rifier les donn&eacute;es entr&eacute;es et r&eacute;essayer</p>
        </div>
        <form id="sms-form" class="form-inline" action="<?php echo site_url('user/ajax/sms_sending') ?>" method="post">
            <div class="form-div">
                <div class="form-field-box even">
                    <div class="form-display-as-box"><label for="sms-contact-client">Choisir un client</label></div>
                    <div class="form-input-box">
                        <select id="sms-contact-client">
                            <option value="0">-- Veuillez choisir un client --</option>
                            <?php foreach ($clients AS $client): ?>
                                <?php if (!empty($client->tel_mobile)) : ?>
                                    <option value="<?php echo $client->tel_mobile ?>"><?php echo $client->nom ?> <?php echo $client->prenom ?> (<?php echo $client->tel_mobile ?>)</option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="form-field-box odd">
                    <div class="form-display-as-box"><label for="sms-contact">OU envoyer au</label></div>
                    <div class="form-input-box"><input placeholder="[00][code][numero]" type="tel" id="sms-contact" name="sms-contact" required="required"/>&nbsp<span class="contact-format">ex: <i>00</i><i class="code">33</i>123456789 (sans espace)</span></div>
                    <div class="clear"></div>
                </div>
                <div class="form-field-box even">
                    <div class="form-display-as-box"><label for="sms-text">Message</label></div>
                    <div class="form-input-box"><textarea id="sms-text" name="sms-text" required="required"></textarea></div>
                    <div class="clear"></div>
                </div>
                <div class="form-field-box odd">
                    <input type="submit" value="Envoyer" id="submit-sms-form" name="submit-sms-form" />
                </div>
            </div>
        </form>
    </div>
</div>