<h2 class="ui header">Panel de Tareas</h2>
<?php
$_title = htmlspecialchars($task['title'], ENT_QUOTES, 'UTF-8');
$_description = htmlspecialchars($task['description'], ENT_QUOTES, 'UTF-8');
$_status = $task['status'];
$_id = $task['id'];
if (isset($res)) {
    $cls = ($res['success']) ? 'success' : 'error';
    $titlemsg = ($res['success']) ? '¡Exito!' : '¡Error!';
    $msg = ($res['success']) ? 'Guardado correctamente' : $res['message'];
?>
    <div id="<?php echo $cls; ?>-message" class="ui <?php echo $cls; ?> message">
        <div class="header"><?php echo $titlemsg; ?></div>
        <p id="<?php echo $cls; ?>-text"><?php echo $msg; ?></p>
    </div>
<?php
}
?>


<div id="taskModal" class="">
    <div class="header"></div>
    <div class="content">
        <form id="taskForm" method="POST" class="ui form" action='<?php echo BASE_URL; ?>/tasks/edit/<?php echo $id; ?>'>
            <input type="hidden" id="taskId" name="id" value="<?php echo $_id; ?>">
            <div class="field">
                <label>Título</label>
                <input maxlength='255'  value="<?php echo isset($_title) ? $_title : ''; ?>" type="text" id="taskTitle" name="title" placeholder="Título">
            </div>
            <div class="field">
                <label>Descripción</label>
                <textarea id="taskDescription" name="description" placeholder="Descripción"><?php echo isset($_description) ? $_description : ''; ?></textarea>
            </div>
            <div class="field">
                <label>Estado</label>
                <select id="taskStatus" name="status" class="ui dropdown">
                    <option <?php echo (isset($_status) && $_status == 'pendiente') ? 'selected' : ''; ?> value="pendiente">Pendiente</option>
                    <option <?php echo (isset($_status) && $_status == 'en progreso') ? 'selected' : ''; ?> value="en progreso">En Progreso</option>
                    <option <?php echo (isset($_status) && $_status == 'completada') ? 'selected' : ''; ?> value="completada">Completada</option>
                </select>
            </div>
            <button type="submit" class="ui primary button">Guardar</button>
            <a class="ui primary button" href='<?php echo BASE_URL; ?>/tasks'>Regresar</a>
        </form>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>