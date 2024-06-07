<?php

//dashboard.php
require_once __DIR__ . '../../controller/ctrl-solicitudes.php';
$solicitud = new SolicitudCtrl();
$solicitudes = $solicitud->getFullSolicitudesCtrl();

$title = 'Dashboard | Solicitudes de Ayuda';
?>

<!DOCTYPE html>
<html lang="es">

<?php require 'templates/head.php'; ?>

<body>

    <?php require 'templates/nav-bar.php'; ?>
    <main class="p-3 d-flex flex-column">
        <div class="d-flex flex-column flex-lg-row  gap-4">
            <h3 class="flex-grow-1">Solicitudes de Emergencia</h3>
        </div>
        <div class="rounded overflow-auto">
            <table class="table text-center table-sm rounded table-bordered table-striped w-100 " style="font-size: smaller;">
                <thead class="align-top">
                    <tr>
                        <th scope="col">Folio</th>
                        <th scope="col">Fecha Ingreso</th>
                        <th scope="col">Sector</th>
                        <th scope="col">Prioridad</th>
                        <th scope="col">Estado</th>
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
                            echo '<tr class="tex-center">';
                            echo '<td>' . $solicitud['folio_id'] . '</td>';
                            echo '<td>' . date('d-m-y H:i\h\r\s', strtotime($solicitud['fecha_ingreso'])) . '</td>';
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
            window.onload = function () {
                $('.table').DataTable({
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                    },
                    layout: {
                        topEnd: {
                            buttons:
                                [
                                    {
                                        extend: 'excel',
                                        text: function (dt) {
                                            return '<i class="bi bi-file-earmark-spreadsheet"></i> Excel';
                                        },
                                        className: 'btn btn-sm btn-success',
                                        filename: 'Registro de Solicitudes - ' + moment().format('DD-MM-YYYY HH:mm:ss'),
                                        title: function (dt) {
                                            return 'Registro de solicitudes';
                                        },
                                        messageBottom: function (dt) {
                                            const fecha = moment().format('dddd, D [de] MMMM, YYYY. [a las] HH:mm[hrs]');
                                            return 'Reporte generado: ' + fecha;
                                        },
                                    },
                                    {
                                        extend: 'pdf',
                                        text: function (dt) {
                                            return '<i class="bi bi-file-earmark-pdf"></i> PDF';
                                        },
                                        className: 'btn btn-sm btn-danger',
                                        filename: 'Registro de Solicitudes - ' + moment().format('DD-MM-YYYY HH:mm:ss'),
                                        orientation: 'landscape',
                                        title: function (dt) {
                                            return 'Registro de Solicitudes ';
                                        },
                                        messageTop: function (dt) {
                                            const fecha = moment().format('dddd, D [de] MMMM, YYYY. [a las] HH:mm[hrs]');
                                            return 'Reporte generado: ' + fecha;
                                        },
                                    },
                                    //print
                                    {
                                        extend: 'print',
                                        text: function (dt) {
                                            return '<i class="bi bi-printer"></i> Imprimir';
                                        },
                                        className: 'btn btn-sm btn-primary',
                                        orientation: 'landscape',
                                        title: function (dt) {
                                            return 'Registro de Solicitudes'
                                        },
                                        messageBottom: function (dt) {
                                            const fecha = moment().format('dddd, D [de] MMMM, YYYY. [a las] HH:mm[hrs]');
                                            return 'Reporte generado: ' + fecha;
                                        },
                                    },
                                ]
                        },
                        topEnd2: 'search',
                        initComplete: function () {
                            //aplicar estilos a la tabla
                            $('.table').addClass('w-100');
                        }
                    }
                });
            }
        </script>
    </main>

    <?php require 'modals/modal-logout.php'; ?>
    <?php require 'templates/toast.php'; ?>
    <?php require 'views/templates/footer.php'; ?>


    <script src="public/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/toast.js"></script>




</body>

</html>