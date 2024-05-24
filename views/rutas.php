<?php

// $rutas= RutasCtrl::getRutasCtrl();

require 'views/templates/head.php';
require 'views/templates/nav-bar.php';

?>

<body>
    <style>
        #map-container {
            width: 80%;
            height: 80%;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        #map {
            width: 100%;
            height: 100%;
        }
    </style>

    <div id="map-container">
        <div id="map"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <!--leaflet css-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script>
        // Inicializar el mapa
        const map = L.map('map').setView([51.505, -0.09], 13);

        // Añadir capa de mapa de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Lista de destinos
        const destinations = [
            'Las Orizas 300,Sindempart, Coquimbo',
            'Varela 1112, Coquimbo',
        ];

        /// Convertir direcciones a coordenadas
        const geocode = async (address) => {
            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`);
            const data = await response.json();
            if (data.length > 0) {
                return [parseFloat(data[0].lat), parseFloat(data[0].lon)];
            } else {
                throw new Error('No se encontraron resultados para la dirección proporcionada.');
            }
        };

        // Función para inicializar la ruta en el mapa
        const initRoute = async () => {
            try {
                const destinationCoords = await Promise.all(destinations.map(geocode));

                // Añadir la ruta al mapa
                L.Routing.control({
                    waypoints: destinationCoords.map(coord => L.latLng(coord[0], coord[1])),
                    router: L.routing.osrmv1({
                        serviceUrl: 'https://router.project-osrm.org/route/v1/'
                    }),
                    createMarker: function (i, waypoint, n) {
                        var marker = L.marker(waypoint.latLng, {
                            draggable: true
                        });
                        return marker;
                    }
                }).addTo(map);
            } catch (error) {
                console.error('Error al generar la ruta:', error);
                alert('Error al generar la ruta: ' + error.message);
            }
        };

        // Inicializar la ruta
        initRoute();
    </script>
</body>