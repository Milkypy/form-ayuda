<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'controller/ctrl-solicitudes.php';
    $solicitudCtrl = new SolicitudCtrl();
    $data_solicitud = array(
        'prioridad' => $_POST['prioridad'],
        'nombre' => $_POST['nombre'],
        'apaterno' => $_POST['apaterno'],
        'amaterno' => $_POST['amaterno'],
        'rut' => $_POST['rut'],
        'calle' => $_POST['calle'],
        'num_calle' => $_POST['num_calle'],
        'sector' => $_POST['sector'],
        'observaciones' => $_POST['observaciones'],
        'fono' => $_POST['telefono'],
        'mail' => $_POST['email'],
    );
    //obtener items 
    $items = $_POST['items'];
    $solicitud = $solicitudCtrl->createSolicitudCtrl($data_solicitud, $items);
    echo '<script>console.log(' . json_encode($solicitud) . ')</script>';
}

// otbener sectores
require_once 'common/utils.php';
$utils = new Utils();
$sectores = $utils->getSectores();
$items = $utils->getItems();
$title = 'Formulario Solicitud de Ayuda';
?>
<!DOCTYPE html>
<html lang="es">

<?php require 'views/head.php'; ?>

<body style="height:100svh">

    <?php require 'views/nav-bar.php'; ?>
    <main class="container d-flex flex-column flex-lg-row gap-4">
        <div class="flex-grow-1 d-flex flex-column align-items-top">
            <h1 class="pb-2">Buscar Dirección</h1>
            <p>Busca una dirección almacenada en los registros de solicitudes para corroborar si la dirección a
                ingresar
                ya se le ha asignado una ayuda</p>
            <input type="text" name="direccion" class="form-control" id="direccion" style="width: 100% !important;">
        </div>
        <form action="" method="post" class="" style="max-width:45em;">
            <h1 class="pb-2">Formulario Solicitud de Ayuda</h1>
            <div class="row">

                <!-- direccion -->
                <div class="form-group col-lg-6">
                    <label for="calle">Calle</label>
                    <input type="text" class="form-control" id="calle" name="calle" required>
                </div>

                <!-- num_calle -->
                <div class="form-group col-lg-6 col-12">
                    <label for="num_calle">Número</label>
                    <input type="text" class="form-control" id="num_calle" name="num_calle" required>
                </div>

            </div>
            <div class="row mb-3">

                <!-- sector -->
                <div class="form-group col-lg-6 col-12">
                    <label for="sector">Sector</label>
                    <select name="sector" class="form-select" id="sector">
                        <?php foreach ($sectores as $sector): ?>
                            <option value="<?php echo $sector['sector_id'] ?>"><?php echo $sector['sector'] ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <!-- prioridad -->
                <div class="form-group col-lg-6 col-12">
                    <label for="prioridad">Prioridad</label>
                    <select name="prioridad" class="form-select" id="prioridad">
                        <option value="1">Común</option>
                        <option value="2">Adultos mayores / Menores de edad</option>
                    </select>
                </div>
            </div>
            <div class="d-flex flex-lg-row flex-column gap-3 align-items-center">

                <h6 class="flex-grow-1">📄 Items requeridos</h6>
                <div class="d-flex flex-wrap gap-3 group">
                    <?php foreach ($items as $item): ?>
                        <input class="btn-check" type="checkbox" value="<?php echo $item['item_id'] ?>"
                            id="<?php echo $item['item'] ?>" name="items[]">
                        <label class="btn btn-outline-secondary text-nowrap" for="<?php echo $item['item'] ?>">
                            <?php echo $item['item'] ?>
                        </label>
                    <?php endforeach; ?>
                </div>

            </div>
            <hr>
            <div class="row g-3">
                <!-- nombre -->
                <div class="form-group col-lg-4 col-12">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>

                <!-- apaterno -->
                <div class="form-group col-lg-4 col-12">
                    <label for="apaterno">Apellido Paterno</label>
                    <input type="text" class="form-control" id="apaterno" name="apaterno" required>
                </div>

                <!-- amaterno -->
                <div class="form-group col-lg-4 col-12">
                    <label for="amaterno">Apellido Materno</label>
                    <input type="text" class="form-control" id="amaterno" name="amaterno" required>
                </div>

                <!-- rut -->
                <div class="form-group col-lg-4 col-12">
                    <label for="rut">Rut</label>
                    <input type="text" class="form-control" id="rut" name="rut" required>
                </div>

                <!-- telefono -->
                <div class="form-group col-lg-4 col-12">
                    <label for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                </div>

                <!-- email -->
                <div class="form-group col-lg-4 col-12">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

            </div>
            <hr>
            <!-- observaciones -->
            <div class="form-group col-12 mb-3">
                <label for="observaciones">Observaciones</label>
                <textarea name="observaciones" id="observaciones" class="form-control" rows="3"></textarea>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <button type="submit" class="btn btn-success btn-lg">Enviar</button>
                <!--loader-->
                <div class="spinner-border text-success d-none" role="status" id="loader">
                    <span class="visually-hidden">Enviando, por favor espere...</span>
                </div>
            </div>


        </form>
    </main>

    <?php require 'toast.php'; ?>
    <?php require 'modal-logout.php'; ?>


    <script src="public/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/buscar-direccion.js"></script>
    <script src="public/js/toast.js"></script>

    <?php if (isset($solicitud)) {
        if (is_array($solicitud) && array_key_exists('success', $solicitud) && $solicitud['success']) {
            echo '<script>showToast("Solicitud Folio N°' . $solicitud['folio_id'] . ' creada con éxito","success")</script>';
        } else if (is_array($solicitud) && array_key_exists('success', $solicitud) && !$solicitud['success']) {
            echo '<script>showToast("Error al crear solicitud")</script>';
        } else {
            echo '<script>showToast("' . $solicitud . '")</script>';
        }
    }
    ?>

    <script>
        const form = document.querySelector('form');
        form.addEventListener('submit', () => {
            document.querySelector('#loader').classList.remove('d-none');
            document.querySelector('button[type="submit"]').disabled = true;
        });

        // Verificar si el formulario se ha enviado
        if (window.history.replaceState) {
            // Reemplazar la URL actual en el historial del navegador
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

</body>

</html>