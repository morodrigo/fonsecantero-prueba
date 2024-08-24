<h2 class="ui header">Panel de Tareas</h2>
<?php
//var_dump($res);
if (isset($res)) {
    $cls = ($res['success']) ? 'success' : 'error';
    $title = ($res['success']) ? '¡Exito!' : '¡Error!';
    $msg = ($res['success']) ? 'Guardado correctamente' : $res['message'];
?>
    <div id="<?php echo $cls; ?>-message" class="ui <?php echo $cls; ?> message">
        <div class="header"><?php echo $title; ?></div>
        <p id="<?php echo $cls; ?>-text"><?php echo $msg; ?></p>
    </div>
<?php
}
?>


<div id="taskModal" class="">
    <div class="header"></div>
    <div class="content">
        <form id="taskForm" method="POST" class="ui form" action='<?php echo BASE_URL; ?>/tasks/create'>
            <div class="field">
                <label>Título</label>
                <input type="text" maxlength='255' id="taskTitle" name="title" placeholder="Título">
            </div>
            <div class="field">
                <label>Descripción</label>
                <textarea id="taskDescription" name="description" placeholder="Descripción"></textarea>
            </div>
            <div class="field">
                <label>Estado</label>
                <select id="taskStatus" name="status" class="ui dropdown">
                    <option value="pendiente">Pendiente</option>
                    <option value="en progreso">En Progreso</option>
                    <option value="completada">Completada</option>
                </select>
            </div>
            <button type="submit" class="ui primary button">Guardar</button>
            <a class="ui primary button" href='<?php echo BASE_URL; ?>/tasks'>Regresar</a>
        </form>
    </div>
</div>