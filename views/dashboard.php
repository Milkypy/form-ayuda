<?php

//dashboard.php
require_once __DIR__ . '../../controller/ctrl-solicitudes.php';
$solicitud = new SolicitudCtrl();
$solicitudes = $solicitud->getFullSolicitudesCtrl();

$title = 'Dashboard | Solicitudes de Ayuda';
?>

<!DOCTYPE html>
<html lang="es">

<?php require 'head.php'; ?>

<body>

    <?php require 'nav-bar.php'; ?>
    <main class="p-3 d-flex flex-column">
        <div class="d-flex flex-column flex-lg-row  gap-4">
            <h3 class="flex-grow-1">Solicitudes de Ayuda</h3>
            <div class="">
                <a href="/excel" class="btn btn-success">Descargar Excel</a>
            </div>
        </div>
        <div class="rounded overflow-auto">
            <table class="table text-center table-sm rounded table-bordered table-striped " style="font-size: smaller;">
                <thead class="align-top">
                    <tr>
                        <th scope="col">Folio</th>
                        <th scope="col">Fecha Ingreso</th>
                        <th scope="col">Sector</th>
                        <th scope="col">Prioridad</th>
                        <th scope="col">Items</th>
                        <th scope="col">Última Modificación</th>
                        <th scope="col">Creado por</th>
                        <th scope="col">Calle</th>
                        <th scope="col">Número</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido Paterno</th>
                        <th scope="col">Apellido Materno</th>
                        <th scope="col">Rut</th>
                        <th scope="col">Observaciones</th>
                        <th scope="col">Fono</th>
                        <th scope="col">Mail</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <?php
                    if (is_array($solicitudes)) {
                        foreach ($solicitudes as $solicitud) {
                            echo '<tr class="tex-center">';
                            echo '<td>' . $solicitud['folio_id'] . '</td>';
                            echo '<td>' . date('y-m-d H:i\h\r\s', strtotime($solicitud['fecha_ingreso'])) . '</td>';
                            echo '<td>' . $solicitud['sector'] . '</td>';
                            echo '<td>' . ($solicitud['prioridad'] == 1 ? 'Común' : 'Menores de Edad/Adulto Mayor') . '</td>';
                            //estiliza el estado de la solicitud
                            if ($solicitud['estado'] == 0) {
                                echo '<td><span class="badge bg-secondary">Recibida</span></td>';
                            } else {
                                echo '<td><span class="badge bg-success">Entregada</span></td>';
                            }
                            echo '<td>';
                            // obtiene los items de la solicitud
                            foreach ($solicitud['items'] as $item) {
                                echo '<span class="badge bg-dark">' . $item . '</span> <br>';
                            }
                            echo '</td>';
                            echo '<td>' . date('y-m-d H:i\h\r\s', strtotime($solicitud['last_mod'])) . '</td>';
                            echo '<td>' . ($solicitud['creado_por'] ?? 'NA') . '</td>';
                            echo '<td>' . $solicitud['calle'] . '</td>';
                            echo '<td>' . $solicitud['num_calle'] . '</td>';
                            echo '<td>' . $solicitud['nombre'] . '</td>';
                            echo '<td>' . $solicitud['apaterno'] . '</td>';
                            echo '<td>' . $solicitud['amaterno'] . '</td>';
                            echo '<td>' . $solicitud['rut'] . '</td>';
                            echo '<td>' . $solicitud['observaciones'] . '</td>';
                            echo '<td>' . $solicitud['fono'] . '</td>';
                            echo '<td>' . $solicitud['mail'] . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="16">' . $solicitudes . '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script>
            new DataTable(".table", {
                // searchable: true,
                fixedHeight: true,
                sortable: true,
                fixedHeader: true,
                pagination: true,
                language: {
                    search: "Buscar:",
                    searchPlaceholder: "Buscar...",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior",
                    },
                    lengthMenu: "Mostrar _MENU_ registros",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron registros",
                    emptyTable: "No hay registros",
                    entriesPerPage: "Mostrando _MENU_ registros por página",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                },
                labels: {
                    placeholder: "Buscar...",
                    perPage: "{select} registros por página",
                    noRows: "No se encontraron registros",
                    info: "Mostrando {start} a {end} de {rows} registros",
                },
                // ajax: {
                //     url: "api/api-solicitudes.php",
                //     method: "GET",
                //     data: {
                //         action: "getFullSolicitudes",
                //     },
                //     dataSrc: "data",
                // },
                columns: [
                    { data: "folio_id", title: "ID de Folio" },
                    { data: "fecha_ingreso", title: "Fecha de Ingreso" },
                    { data: "sector", title: "Sector" },
                    { data: "prioridad", title: "Prioridad" },
                    { data: "items", title: "Items" },
                    { data: "last_mod", title: "Última Modificación" },
                    { data: "creado_por", title: "Creado Por" },
                    { data: "calle", title: "Calle" },
                    { data: "num_calle", title: "Número de Calle" },
                    { data: "nombre", title: "Nombre" },
                    { data: "apaterno", title: "Apellido Paterno" },
                    { data: "amaterno", title: "Apellido Materno" },
                    { data: "rut", title: "RUT" },
                    { data: "observaciones", title: "Observaciones" },
                    { data: "fono", title: "Teléfono" },
                    { data: "mail", title: "Correo Electrónico" },
                    { data: "estado", title: "Estado" },
                ],
            });

        </script>
    </main>

    <?php require 'modal-logout.php'; ?>
    <?php require 'toast.php'; ?>

    <script src="public/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/toast.js"></script>




</body>

</html>