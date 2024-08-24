<h1 class="ui header">Registrate</h1>
<?php
if (isset($res)) {
    $cls = ($res['success']) ? 'success' : 'error';
    $title = ($res['success']) ? '¡Exito!' : '¡Error!';
    $msg = $res['message'];
?>
    <div id="<?php echo $cls; ?>-message" class="ui <?php echo $cls; ?> message">
        <div class="header"><?php echo $title; ?></div>
        <p id="<?php echo $cls; ?>-text"><?php echo $msg; ?></p>
    </div>
<?php
}
?>
<form action="<?php echo BASE_URL ?>/register" method="post" class="ui form" id="register-form" style="">
    <div class="field">
        <label>Nombre de Usuario</label>
        <input type="text" maxlength='255' name="username" placeholder="Nombre de Usuario" required>
    </div>
    <div class="field">
        <label>Contraseña</label>
        <input type="password" maxlength='255' name="password" placeholder="Contraseña" required>
    </div>
    <div class="field">
        <label>Confirma Contraseña</label>
        <input type="password" maxlength='255' name="confirm_password" placeholder="Confirm Contraseña" required>
    </div>
    <button class="ui primary button" type="submit">Registrar</button>
</form>

<div class="toggle-link">
    <a href="<?php echo BASE_URL ?>/login">Ya tienes cuenta? Inicia sesión</a>
</div>