const autoCompletejs = new autoComplete({
    selector: '#direccion',
    placeHolder: 'Buscar direcciones registradas en solicitudes...',
    msgNoResults: 'No se encontraron resultados',
    wrapInput: true,
    searchEngine: "loose",
    highlight: true,
    debounce: 200,
    threshold: 3,
    // wrapper: false,
    data: {
        src: async () => {
            const query = document.querySelector('#direccion').value;
            const source = await axios.get('api/api-direcciones.php', {
                params: {
                    q: query,
                    limit: 20
                }
            }).then(res => {
                // console.log(res.data);
                if (typeof res.data === 'string') return [res.data];
                arr = res.data.map(item => `📄 Folio ${item.folio_id} - ${item.calle} - #${item.num_calle} (${item.sector}) - Estado:
                ${item.estado} - fecha de ingreso: ${moment(item.fecha_ingreso, 'YYYY-MM-DD').format('dddd, D [de] MMMM, YYYY. [a las] HH:mm[hrs]')}`);
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

            } else {
                //crea un elemento para cada resultado de la lista


                //agrega un evento onclick a cada elemento de la lista para mostrar un modal con la información
                data.results.forEach(result => {
                    const resultItem = document.createElement('div');
                    resultItem.classList.add('autoComplete_result');
                    console.log(result.value);
                    resultItem.innerHTML = result.value.display;
                    resultItem.addEventListener('click', () => {
                        showModal(result.value.data);
                    });
                    list.appendChild(resultItem);
                });
            }
        },
        noResults: true,
        maxResults: 20,
    }
});

function showModal(data) {
    console.log(data);
    const modalBody = document.getElementById('modal-body');
    modalBody.innerHTML = `
        <p>Folio: ${data.folio_id}</p>
        <p>Calle: ${data.calle}</p>
        <p>Número: ${data.num_calle}</p>
        <p>Sector: ${data.sector}</p>
        <p>Estado: ${data.estado}</p>
        <p>Fecha de ingreso: ${moment(data.fecha_ingreso, 'YYYY-MM-DD').format('dddd, D [de] MMMM, YYYY. [a las] HH:mm[hrs]')}</p>
    `;
    const infoModal = new bootstrap.Modal(document.getElementById('infoModal'));
    infoModal.show();
}