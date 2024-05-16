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
        'mail' => $_POST['email']

    );
    $solicitud = $solicitudCtrl->createSolicitudCtrl($data_solicitud);

    if (is_array($solicitud)) {
        echo '<div class="alert alert-success" role="alert">Solicitud creada con el folio: ' . $solicitud['folio_id'] . '</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">' . $solicitud . '</div>';
    }

}

// otbener sectores
require_once 'common/utils.php';
$utils = new Utils();
$sectores = $utils->getSectores();


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Ayuda</title>
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/autoComplete.min.css">
    <script src="public/js/autoComplete.js"></script>
    <!-- axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>

<body class="h-100">
    <main class="container d-flex flex-column justify-content-center flex-lg-row align-items-center gap-5"
        style="height:100svh">
        <div>
            <input type="text" name="direccion" id="direccion">
        </div>
        <form action="" method="post" class="px-3">
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
            <hr>
            <!-- observaciones -->
            <div class="form-group col-12 mb-3">
                <label for="observaciones">Observaciones</label>
                <textarea name="observaciones" id="observaciones" class="form-control" rows="3"></textarea>
            </div>
            <div>
                <button type="submit" class="btn btn-success btn-lg">Enviar</button>
            </div>


        </form>
    </main>
    <script>

        const autoCompletejs = new autoComplete({
            selector: '#direccion',
            placeHolder: 'Buscar direcciones registradas en solicitudes...',
            msgNoResults: 'No se encontraron resultados',
            maxResults: 20,
            data: {
                src: async () => {
                    const query = document.querySelector('#direccion').value;
                    const source = await axios.get('api/api-direccion.php', {
                        params: {
                            q: query,
                            limit: 20
                        }
                    }).then(res => {
                        // console.log(res.data);
                        if (typeof res.data === 'string') return [res.data];
                        arr = res.data.map(item => `Folio ${item.folio_id} - ${item.calle} - #${item.num_calle}`);
                        // console.log(arr);
                        return arr;
                    }).catch(err => {
                        console.error(err);
                        return [];
                    });
                    //si source es solo un string, retornar un array con ese string
                    if (typeof source === 'string') {
                        return Array[source];
                    }
                    return source;
                },
                cache: false
            },

            resultsList: {
                element: (list, data) => {
                    if (!data.results.length) {
                        // Create "No Results" message element
                        const message = document.createElement("div");
                        // Add class to the created element
                        message.setAttribute("class", "no_result");
                        message.style.padding = "10px";
                        message.style.border = "1px solid #ccc";
                        message.style.backgroundColor = "#fff";
                        message.style.borderRadius = "5px";
                        // Add message text content
                        message.innerHTML = `<span> ✅ No se encontraron registros para: "${data.query}"</span>`;
                        // Append message element to the results list
                        list.prepend(message);
                    }
                },
                noResults: true,
            },
            resultItem: {
                element: (item, data) => {
                    // Modify Results Item Style
                    item.style = "display: flex; justify-content: space-between;";
                    // Modify Results Item Content
                    item.innerHTML = `<span style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                    ${data.value}</span>`;
                },
                highlight: true
            },
        });
    </script>

    <script src="public/js/bootstrap.min.js"></script>

</body>

</html>