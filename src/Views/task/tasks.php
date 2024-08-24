
        <h2 class="ui header">Panel de Tareas</h2>
        <a href='<?php echo BASE_URL; ?>/tasks/create'><button class="ui primary button">Agregar Tarea</button></a>

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

        <table id="tasksTable" class="ui celled table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($tasks as $i => $k) {
                ?>
                    <tr>
                        <td><?php echo $k['id'] ?></td>
                        <td><?php echo $k['title'] ?></td>
                        <td><?php echo $k['description'] ?></td>
                        <td><?php echo $k['status'] ?></td>
                        <td>
                            <a class="ui button " href='<?php echo BASE_URL; ?>/tasks/edit/<?php echo $k['id'] ?>'>
                                Editar
                            </a>
                            <a class="ui button delete" href="<?php echo BASE_URL; ?>/tasks/delete/<?php echo $k['id'] ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
  