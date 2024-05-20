<?php

//gestion de usuarioss
require_once __DIR__ . '/../controller/ctrl-user.php';
$usuarioCtrl = new UserCtrl();


//crear usuario via post
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && !empty($_POST['action'])) {
    switch ($_POST['action']) {
        case 'create':
            $user = array(
                'nombre' => $_POST['nombre'],
                'email' => $_POST['email'],
                'usuario' => $_POST['usuario'],
                'password' => $_POST['password'],
                'rol' => $_POST['rol']
            );
            $toast = $usuarioCtrl->createUserCtrl($user);
            break;
        case 'edit':
            $user = array(
                'user_id' => $_POST['id'],
                'nombre' => $_POST['nombre'],
                'email' => $_POST['email'],
                'usuario' => $_POST['usuario'],
                'rol' => $_POST['rol'],
                'estado' => $_POST['estado']
            );
            $toast = $usuarioCtrl->updateUserCtrl($user);
            break;
        case 'delete':
            $user = $_POST['id'];
            $toast = $usuarioCtrl->deleteUserCtrl($user);
            break;
    }
}

$usuarios = $usuarioCtrl->getUsersCtrl();
?>

<!DOCTYPE html>
<html lang="es">

<?php require 'views/head.php'; ?>
<?php require 'views/nav-bar.php'; ?>

<body>
    <main class="container">
        <h1>Admin usuarios</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-nuevo-usuario">
            Agregar usuario
        </button>
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Fecha creado</th>
                    <th>Última modificación</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($usuarios['error'])) {
                    echo "<tr><td colspan='5'>" . $usuarios['error'] . "</td></tr>";
                } else {
                    foreach ($usuarios as $usuario):
                        ?>
                        <tr>
                            <td>
                                <button class="btn btn-sm"
                                    data-user="<?= htmlspecialchars(json_encode($usuario, JSON_UNESCAPED_UNICODE)) ?>"
                                    onclick="showEditModal(this)">🖊️</button>
                                <button class="btn btn-sm" data-id-user="<?= $usuario['user_id'] ?>"
                                    data-name="<?= $usuario['nombre'] ?>" onclick="showDeleteModal(this)">✖️</button>
                            </td>
                            <td><?= $usuario['user_id'] ?></td>
                            <td><?= $usuario['nombre'] ?></td>
                            <td><?= $usuario['email'] ?></td>
                            <td><?= $usuario['usuario'] ?></td>
                            <td><?= $usuario['rol'] == 1 ? 'Administrador' : 'Usuario' ?></td>
                            <td><?= $usuario['estado'] == 1 ? 'Activo' : 'Inactivo' ?></td>
                            <td><?= date_format(new DateTime($usuario['fecha_creado']), 'Y-m-d H:i') ?></td>
                            <td><?= date_format(new DateTime($usuario['last_mod']), 'Y-m-d H:i') ?></td>

                            <?php
                    endforeach;
                }
                ?>
            </tbody>
        </table>

    </main>
    <?php require 'views/toast.php'; ?>
    <?php require 'views/modal-user.php'; ?>
    <?php require 'views/modal-logout.php'; ?>


    <script src="public/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/toast.js"></script>
    <?php if (isset($toast)): ?>
        <script>
            showToast(
                '<?= $toast['message'] ?>',
                '<?= $toast['success'] ? 'success' : 'danger' ?>');    
        </script>
    <?php endif; ?>

    <!--evitar que se envié el formulario al recargar la página-->
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        //mostrar modal editar usuario
        function showEditModal(button) {
            let user = JSON.parse(button.getAttribute('data-user'));
            let form = document.getElementById('form-editar-usuario');
            form['id'].value = user.user_id;
            form['nombre'].value = user.nombre;
            form['email'].value = user.email;
            form['usuario'].value = user.usuario;
            form['rol'].value = user.rol;
            let modal = new bootstrap.Modal(document.getElementById('modal-editar-usuario'));
            modal.show();
        }

        function showDeleteModal(button) {
            let id = button.getAttribute('data-id-user');
            let name = button.getAttribute('data-name');
            let form = document.getElementById('form-eliminar-usuario');
            form.querySelector('#id-eliminar').textContent = 'ID USUARIO N°' + id;
            form.querySelector('#id-eliminar-input').value = id;
            form.querySelector('#nombre-eliminar').textContent = name;
            let modal = new bootstrap.Modal(document.getElementById('modal-eliminar-usuario'));
            modal.show();
        }
    </script>
</body>

</html>