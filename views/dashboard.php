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
        <div class="d-flex flex-column gap-4">
            <h3>Solicitudes de Ayuda</h3>
        </div>
        <div class="rounded">
            <table class="table text-center table-sm rounded table-bordered " style="font-size: smaller;">
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
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <?php
                    if (is_array($solicitudes)) {
                        foreach ($solicitudes as $solicitud) {
                            echo $solicitud['estado'] == 0 ? '<tr class="table-success">' : '<tr class="table-warning">';
                            echo '<td>' . $solicitud['folio_id'] . '</td>';
                            echo '<td>' . date('y-m-d H:i\h\r\s', strtotime($solicitud['fecha_ingreso'])) . '</td>';
                            echo '<td>' . $solicitud['sector'] . '</td>';
                            echo '<td>' . ($solicitud['prioridad'] == 1 ? 'Común' : 'Menores de Edad/Adulto Mayor') . '</td>';
                            // obtiene los items de la solicitud
                            echo '<td>';
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
                searchable: true,
                withUI: true,
                fixedHeight: true,
                sortable: true,
                fixedHeader: true,
                pagination: true,
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