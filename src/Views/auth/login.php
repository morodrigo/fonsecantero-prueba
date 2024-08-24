<h1 class="ui header">Inicia sesión</h1>
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

<form action="<?php echo BASE_URL ?>/login" method="post" class="ui form" id="login-form">
    <div class="field">
        <label>Nombre de Usuario</label>
        <input type="text" maxlength='255' name="username" placeholder="Nombre de Usuario" required>
    </div>
    <div class="field">
        <label>Contraseña</label>
        <input type="password" maxlength='255' name="password" placeholder="Contraseña" required>
    </div>
    <button class="ui primary button" type="submit">Entrar</button>
</form>




<div class="toggle-link">
    <a href="<?php echo BASE_URL ?>/register">No tienes cuenta? Registrate aqui</a>
</div>