$('select').on('click', function (event) {
    let select = $(this);
    event.preventDefault();

    async function fetchLocations(url) {
        const locations = await $.ajax(url);

        $.each(locations, function (k, v) {
            console.log(k+': '+v)
            select.append(`<option>${k['name']}</option>`)
        })
    }
})
