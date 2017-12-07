<script type="text/javascript">
    $(function () {
        $("#text-layout1").on('click', function () {
            var content = $('textarea#field-pattern').val() + "" + $('#text-layout1').text();
            $("#field-pattern").val(content);
        });
        $("#text-layout2").on('click', function () {
            var content = $('textarea#field-pattern').val() + "" + $('#text-layout2').text();
            $("#field-pattern").val(content);
        });
        $("#text-layout3").on('click', function () {
            var content = $('textarea#field-pattern').val() + "" + $('#text-layout3').text();
            $("#field-pattern").val(content);
        });
    });
</script>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard') ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo site_url('user/marketing/request') ?>">Marketing</a></li>
    <li class="breadcrumb-item active">Mod&egrave;le SMS</li>
</ol>
<p class="bg-yellow">Vous pouvez utiliser les textes suivants: <br />
    <strong id="text-layout1">%NOM%</strong> (pour d&eacute;signer le <strong>nom du client</strong>);
    <strong id="text-layout2">%PRENOM%</strong> (pour d&eacute;signer le <strong>pr&eacute;nom du client</strong>);<br />
    <strong id="text-layout3">%DATE%</strong> (pour indiquer la <strong>date du RDV</strong>);<br />
    <strong>Cliquez</strong> sur le texte pour l'ajouter &agrave; l'&eacute;diteur.
</p>
<p class="bg-yellow">Message limit&eacute; &agrave; 140 caract&egrave;res</p>
<?php echo isset($output) ? $output : ''; ?>