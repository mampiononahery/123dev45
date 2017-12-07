<?php
$login = array(
    'name' => 'login',
    'id' => 'login',
    'value' => set_value('login'),
    'maxlength' => 80,
    'size' => 30,
);
$login_label = 'Login';
$password = array(
    'name' => 'password',
    'id' => 'password',
    'size' => 30,
);
?>
<div class="row">
    <div class="col-sm-6 col-sm-offset-3 form-box">
        <div class="form-top">
            <div class="form-top-left">
                <h3>Authentification</h3>
                <p>Veuillez entrer vos identifiants</p>
            </div>
            <div class="form-top-right">
                <i class="fa fa-key"></i>
            </div>
        </div>
        <div class="form-bottom">
            <?php echo form_open($this->uri->uri_string()); ?>
            <div class="form-group">
                <label class="sr-only" for="login">Identifiant</label>
                <input type="text" required="required" name="login" placeholder="Identifiant..." class="form-username form-control" id="login">
                <?php if (isset($referer)): ?>
                    <input type="hidden" name="referer" value="<?php echo $referer ?>">
                <?php endif; ?>
                <?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']]) ? $errors[$login['name']] : ''; ?>
            </div>
            <div class="form-group">
                <label class="sr-only" for="password">Mot de passe</label>
                <input type="password" required name="password" placeholder="Mot de passe..." class="form-password form-control" id="password">
                <?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']]) ? $errors[$password['name']] : ''; ?>
            </div>
            <?php echo form_submit('submit', 'Se connecter'); ?>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<?php echo form_close(); ?>