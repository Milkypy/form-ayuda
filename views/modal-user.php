<!--modal nuevo usuario-->
<div class="modal fade" id="modal-nuevo-usuario" tabindex="-1" aria-labelledby="modal-nuevo-usuario" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-nuevo-usuario">Nuevo usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="form-nuevo-usuario" action="" method="post">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-select" id="rol" name="rol" required>
                            <option value="1">Administrador</option>
                            <option value="2">Usuario</option>
                        </select>
                    </div>
                    <input type="hidden" name="action" value="create" />

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--modal editar usuario-->
<div class="modal fade" id="modal-editar-usuario" tabindex="-1" aria-labelledby="modal-editar-usuario"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-editar-usuario">Editar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="form-editar-usuario" method="post" action="">
                    <input type="hidden" id="id-editar" name="id">
                    <div class="mb-3">
                        <label for="nombre-editar" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre-editar" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="email-editar" class="form-label
                        ">Email</label>
                        <input type="email" class="form-control" id="email-editar" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="usuario-editar" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="usuario-editar" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="password-editar" class="form-label">Contraseña (reemplazará la anterior)</label>
                        <input type="password" class="form-control" id="password-editar" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="rol-editar" class="form-label
                        ">Rol</label>
                        <select class="form-select" id="rol-editar" name="rol" required>
                            <option value="1">Administrador</option>
                            <option value="2">Usuario</option>
                        </select>
                    </div>
                    <!--estado-->
                    <div class="mb-3">
                        <label for="estado-editar" class="form-label">Estado</label>
                        <select class="form-select" id="estado-editar" name="estado" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <input type="hidden" name="action" value="edit" />

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--modal eliminar usuario-->
<div class="modal fade" id="modal-eliminar-usuario" tabindex="-1" aria-labelledby="modal-eliminar-usuario"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-eliminar-usuario">Eliminar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="form-eliminar-usuario" action="" method="post">
                    <p>¿Estás seguro de eliminar este usuario?</p>
                    <p id="id-eliminar" class="text-center fw-bold"></p>
                    <p id="nombre-eliminar" class="text-center fw-bold"></p>
                    <div class="d-grid gap-2">
                        <input type="hidden" id="id-eliminar-input" name="id" />
                        <input type="hidden" name="action" value="delete" />
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>