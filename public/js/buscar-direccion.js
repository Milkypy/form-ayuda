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
                arr = res.data.map(item => `📄 Folio ${item.folio_id} - ${item.calle} - #${item.num_calle} (${item.sector})`);
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
        maxResults: 20,
    }
});