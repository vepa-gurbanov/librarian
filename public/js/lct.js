function lctInputInit() {
    $('input.form-lct-input').on('keyup', function () {
        let regex = new RegExp('[a-z0-9]+@[a-z]+\\.[a-z]{2,3}');
        console.log('target: ' + $(this).val().length)

        if ($(this).val().length > 0 && $(this).attr('type') !== 'email') {
            $(this).closest('.lct').find('.form-lct-icon').addClass('bg-primary')
        } else if ($(this).val().length > 0 && $(this).attr('type') === 'email') {

            if (regex.test($(this).val())) {
                $(this).closest('.lct').find('.form-lct-icon').addClass('bg-primary')
            } else {
                $(this).closest('.lct').find('.form-lct-icon').removeClass('bg-primary')
            }

        } else {
            $(this).closest('.lct').find('.form-lct-icon').removeClass('bg-primary')
        }
    })

    $('.lct-password-visible').on('click', function () {
        let input = $(this).closest('.lct').find('.form-lct-input');
        if (input.attr('type') === 'password') {
            $(this).text('Hide');
            input.attr('type', 'text');
        } else {
            $(this).text('Show');
            input.attr('type', 'password');
        }
    })

} lctInputInit()


function liveSearch(selector, content) {
    $('#' + selector).keyup(function () {
        let filter = $(this).val();
        $("#" + content).each(function () {
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();
            } else {
                $(this).show();
            }
        });
    });
} liveSearch()
