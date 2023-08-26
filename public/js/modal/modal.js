$(document).ready(function () {
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = $('.needs-validation')

        // Loop over them and prevent submission
        $.each(forms, function () {
            let form = $(this);
            form.on('submit', function (e) {
                if (!form.checkValidity()) {
                    e.preventDefault()
                    e.stopPropagation()
                }

                form.addClass('was-validated')
            }, false)
        })
    })()
})
