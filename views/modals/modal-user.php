<!-- modal nuevo usuario -->
<div class="modal fade" id="modal-nuevo-usuario" tabindex="-1" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-nuevo-usuarioLabel">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <form id="formUsuario" action="" method="post">
                    <!--nombre-->
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <!--email-->
                    <div class="mb-3">
                        <label for="email-editar" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email-editar" name="email" required>
                    </div>
                    <!--usuario-->
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" maxlength="40"
                            minlength="20" required>
                    </div>
                    <!--contraseña-->
                    <div class="mb-3">
                        <label for="pass" class="form-label">Contraseña</label>
                        <input type="text" class="form-control" id="pass" maxlength="8" max="8" minlength="8"
                            name="password" required>
                        <div class="d-flex flex-row justify-content-between align-items-center p-1">
                            <small class="text-muted">8 caracteres</small>
                            <div>
                                <a class="btn btn-sm btn-outline-info me-2" onclick="setPassword('pass')">Generar
                                    contraseña</a>
                                <a class="btn btn-sm btn-outline-secondary" onclick="cleanPassword('pass')">limpiar</a>
                            </div>
                        </div>
                    </div>
                    <!--rol-->
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-select" id="rol" name="rol" required>
                            <option value="" selected>Seleccione una opción</option>
                            <option value="0">Sys Admin</option>
                            <option value="1">Administrador</option>
                            <option value="2">Usuario</option>
                        </select>
                    </div>
                    <!--estado-->
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="" selected>Seleccione una opción</option>
                            <option value="1">Habilitado</option>
                            <option value="0">Inhabilitado</option>
                        </select>
                    </div>

                    <input type="hidden" name="action" value="create">
                    <button type="submit" class="btn btn-primary">Guardar</button>
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
                    <!--contraseña-->
                    <div class="mb-3">
                        <label for="pass" class="form-label">Contraseña</label>
                        <input type="text" class="form-control" id="pass_edit" maxlength="40" minlength="20"
                            name="pass">
                        <div class="d-flex flex-row justify-content-between align-items-center p-1">
                            <small class="text-muted">8 caracteres</small>
                            <div>
                                <a class="btn btn-sm btn-outline-info me-2" onclick="setPassword('pass_edit')">Generar
                                    contraseña</a>
                                <a class="btn btn-sm btn-outline-secondary"
                                    onclick="cleanPassword('pass_edit')">limpiar</a>
                            </div>
                        </div>
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
    <div class="modal-dialog modal-dialog-centered">
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