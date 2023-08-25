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

//
// function loginWithModal() {
//     $('button[name=login]').on('click', function () {
//         let t = $(this);
//         let form = t.parent().parent();
//         let text = t.text();
//
//         t.css('background', '#dee2e6').html(loadingImage);
//         $.ajax({
//             url: form.attr('action'),
//             method: form.attr('method'),
//             data: {
//                 '_token': form.find('input:hidden[name=_token]').val(),
//                 'phone': form.find('input[name=phone]').val(),
//             },
//             processData: true,
//             dataType: 'json',
//             success: function (response) {
//                 setTimeout(function () {
//                     t.html(loadingSuccess).fadeOut();
//                 }, 1000);
//                 setTimeout(function () {
//                     t.css('background', textPrimary).html('Verify').fadeIn();
//                 }, 1200);
//
//                 $('button#verify-tab').click();
//                 liveToast(response['message'], successIconClass, 'success')
//                 let data = {
//                     'phone': form.find('input[name=phone]').val(),
//                     'token': response['token']
//                 }
//                 localStorage.clear();
//                 localStorage.setItem('data', JSON.stringify(data));
//             },
//             error: function(jqXHR) {
//                 form.find('svg#false').removeClass('d-none').parent().addClass('bg-danger');
//                 form.find('svg#true').addClass('d-none');
//
//                 form.find('input').on('keyup', function () {
//                     form.find('svg#false').addClass('d-none').parent().removeClass('bg-danger')
//                     form.find('svg#true').removeClass('d-none');
//                 })
//                 liveToast(jqXHR['responseJSON']['message'], errorIconClass, 'danger');
//                 setTimeout(function () {
//                     t.html(loadingError).fadeOut();
//                 }, 1000);
//                 setTimeout(function () {
//                     t.css('background', textPrimary).html(text).fadeIn();
//                 }, 1200);
//             }
//         });
//     })
// }
// loginWithModal()
// verifyWithModal()
//
// function verifyWithModal() {
//     let storedData = JSON.parse(localStorage.getItem('data'));
//     con('storedData: ' + localStorage.getItem('data'))
//
//     if (storedData['phone']) {
//         let p = $('form#verify').find('input[name=phone]');
//         p.val(storedData['phone']).prop('disabled', true);
//         p.parent().find('.form-lct-icon').addClass('bg-success');
//     }
//     $('button[name=verify]').on('click', function () {
//         let t = $(this);
//         let form = t.parent();
//         let phoneAccess = null;
//
//         if (storedData['phone']) {phoneAccess = storedData['phone'];} else {phoneAccess = form.find('input[name=phone]').val();}
//         t.css('background', '#dee2e6').html(loadingImage);
//
//         $.ajax({
//             url: form.attr('action'),
//             method: form.attr('method'),
//             data: {
//                 '_token': form.find('input:hidden[name=_token]').val(),
//                 'token': storedData['token'],
//                 'name': storedData['name'],
//                 'phone': phoneAccess,
//                 'code': form.find('input[name=code]').val()
//             },
//             processData: true,
//             dataType: 'json',
//             success: function (response) {
//                 $.each(response, function (k, v) {
//                     con(k + ': ' + v)
//                 })
//
//                 // form.html(loadingSuccessXXL).fadeIn();
//                 // setTimeout(function () {
//                 //     $('.modal').fadeOut().after(function () {
//                 //         location.reload();
//                 //     });
//                 // }, 2000);
//                 // liveToast(response['message'], successIconClass, 'success')
//             },
//             error: function(jqXHR) {
//                 // $.each(jqXHR['responseJSON'], function (k, v) {
//                 //     con(k + ': ' + v)
//                 // })
//
//                 liveToast(jqXHR['responseJSON']['message'], errorIconClass, 'danger')
//                 setTimeout(function () {
//                     t.html(loadingError).fadeOut();
//                 }, 1000);
//                 setTimeout(function () {
//                     t.css('background', textPrimary).html('Verify').fadeIn();
//                 }, 1200);
//             }
//         });
//     });
// }
//
//
// function registerWithModal() {
//     $('button[name=register]').on('click', function () {
//         let t = $(this);
//         let text = $(this).text();
//         let form = $(this).parent();
//
//         $.ajax({
//             url: form.attr('action'),
//             method: form.attr('method'),
//             data: {
//                 '_token': form.find('input:hidden[name=_token]').val(),
//                 'name': form.find('input[name=name]').val(),
//                 'phone': form.find('input[name=phone]').val(),
//             },
//             processData: true,
//             dataType: 'json',
//             success: function (response) {
//                 $.each(response, (k, v) => {
//                     con(k + ': ' + v)
//                 })
//                 setTimeout(function () {
//                     t.html(loadingSuccess).fadeOut();
//                 }, 1000);
//                 setTimeout(function () {
//                     t.css('background', textPrimary).html('Verify').fadeIn();
//                 }, 1200);
//
//                 $('button#verify-tab').click();
//                 liveToast(response['message'], successIconClass, 'success')
//                 let data = {
//                     'phone': form.find('input[name=phone]').val(),
//                     'name': form.find('input[name=name]').val(),
//                 }
//                 localStorage.clear();
//                 localStorage.setItem('data', JSON.stringify(data));
//             },
//             error: function(jqXHR) {
//                 $.each(jqXHR, (k, v) => {
//                     con(k + ': ' + v)
//                 })
//                 liveToast(jqXHR['responseJSON']['message'], errorIconClass, 'danger');
//                 setTimeout(function () {
//                     t.html(loadingError).fadeOut();
//                 }, 1000);
//                 setTimeout(function () {
//                     t.css('background', textPrimary).html(text).fadeIn();
//                 }, 1200);
//             }
//         })
//     })
// }
// registerWithModal()
