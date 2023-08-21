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

// function login() {
//     $('button[name=login]').on('click', function () {
//         let t = $(this);
//         let form = t.parent();
//         con(form.find('input[name=phone]').val())
//
//         t.css('background', '#dee2e6').html(loadingImage);
//         setTimeout(function () {
//             t.html(loadingSuccess).fadeOut();
//         }, 1000)
//         setTimeout(function () {
//             t.css('background', textPrimary).html('Verify').fadeIn();
//         }, 1200)
//
//     })
// }
// login()

function loginWithModal() {
    $('button[name=login]').on('click', function () {
        let t = $(this);
        let form = t.parent();
        let text = t.text();
        t.css('background', '#dee2e6').html(loadingImage);
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: {
                '_token': form.find('input[type=hidden][name=_token]').val(),
                'phone': form.find('input[name=phone]').val(),
            },
            processData: true,
            dataType: 'json',
            success: function (response, textStatus, jqXHR) {

                setTimeout(function () {
                    t.html(loadingSuccess).fadeOut();
                }, 1000);
                setTimeout(function () {
                    t.css('background', textPrimary).html('Verify').fadeIn();
                }, 1200);

                liveToast(response['message'], 'bi-check-circle-fill', 'success')

                $('button#verify-tab').click();
                // form.parent().removeClass('show active').after(function () {
                //     $('button#login-tab').removeClass('active').attr('aria-selected', false);
                // });
                // $('.tab-pane#verify').addClass('show active').after(function () {
                //     $('button#verify-tab').addClass('active').attr('aria-selected', true);
                // });
                verifyWithModal(form.find('input[name=phone]').val());
            },
            error: function(response, textStatus, errorThrown){
                $.each(response, function (k, v) {
                    con(k + ': ' + v)
                })
                con('textStatus: ' + textStatus)
                con('errorThrown: ' + errorThrown)
                liveToast(response['responseJSON']['message'], loadingError, 'danger');
                setTimeout(function () {
                    t.html(loadingError).fadeOut();
                }, 1000);
                setTimeout(function () {
                    t.css('background', textPrimary).html(text).fadeIn();
                }, 1200);
            }
        });
    })
}
loginWithModal()

function verifyWithModal(phone) {
    if (phone) {
        let p = $('form#verify').find('input[name=phone]');
        p.val(phone).prop('disabled', true);
        p.parent().find('.form-lct-icon').addClass('bg-success');
    }
    $('button[name=verify]').on('click', function () {
        let t = $(this);
        let form = t.parent();
        t.css('background', '#dee2e6').html(loadingImage);

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: {
                'phone': phone ? phone : form.find('input[name=phone]').val(),
                'code': form.find('input[name=code]').val()
            },
            processData: true,
            dataType: 'json',
            success: function (response, textStatus, jqXHR) {
                form.html(loadingSuccessXXL).fadeIn();
                setTimeout(function () {
                    $('.modal').fadeOut().after(function () {
                        location.reload();
                    });
                }, 2000);
                liveToast(response['message'], 'bi-check-circle-fill', 'success')
            },
            error: function(jqXHR, textStatus, errorThrown) {
                liveToast(jqXHR['responseJSON']['message'], loadingError, 'danger')
                let text = t.text();
                setTimeout(function () {
                    t.html(loadingError).fadeOut();
                }, 1000);
                setTimeout(function () {
                    t.css('background', textPrimary).html(text).fadeIn();
                }, 1200);
            }
        });
    });
}

// function iHaveCode() {
//     $('a#i_have_code').on('click', function () {
//         $('.tab-pane#login').removeClass('show active').after(function () {
//             $('.tab-pane#verify').addClass('show active');
//         });
//     })
// } iHaveCode()
// function login() {
//     $('button[name=login]').on('click', function () {
//         let t = $(this);
//         let form = t.parent();
//         con(form.find('input[name=phone]').val())
//         t.css('background', '#dee2e6').html(loadingImage);
//
//         $.ajax({
//             url: form.attr('action'),
//             method: form.attr('method'),
//             data: {
//                 '_token': form.find('input[name=_token]').val(),
//                 'phone': form.find('input[name=phone]').val()
//             },
//             processData: true,
//             dataType: 'json',
//             success: function (response, textStatus, jqXHR) {
//
//                 setTimeout(function () {
//                     t.html(loadingSuccess).fadeOut();
//                 }, 1000);
//                 setTimeout(function () {
//                     t.css('background', textPrimary).html('Verify').fadeIn();
//                 }, 1200);
//
//                 $('.lct.d-none#code').removeClass('d-none');
//                 form.attr('action', `http://127.0.0.1:8000/0auth2/${response['token']}`)
//                 form.append(`<input type="hidden" name="token" value="${response['token']}" />`);
//                 form.find('div#step-content-`').addClass('step-active');
//                 form.find('input#phone').prop('disabled', true);
//                 t.attr('name', 'verify')
//                 liveToast(response['message'], 'bi-check-circle-fill', 'success')
//
//                 verify();
//             },
//             error: function(jqXHR, textStatus, errorThrown){
//                 liveToast(jqXHR['responseJSON']['message'], 'bi-exclamation-triangle-fill', 'danger')
//                 setTimeout(function () {
//                     t.html(loadingError).fadeOut();
//                 }, 1000);
//                 setTimeout(function () {
//                     t.css('background', textPrimary).html('Verify').fadeIn();
//                 }, 1200);
//             }
//         });
//     })
// }
// login()

// function verify() {
//     $('button[name=verify]').on('click', function () {
//         let t = $(this);
//         let form = t.parent();
//         con(form.find('input[name=code]').val())
//         t.css('background', '#dee2e6').html(loadingImage);
//
//         $.ajax({
//             url: form.attr('action'),
//             method: form.attr('method'),
//             data: {
//                 // '_token': form.find('input[name=_token]').val(),
//                 'phone': form.find('input[name=phone]').val(),
//                 'token': form.find('input[name=token]').val(),
//                 'code': form.find('input[name=code]').val()
//             },
//             processData: true,
//             dataType: 'json',
//             success: function (response, textStatus, jqXHR) {
//
//                 setTimeout(function () {
//                     t.parent().html(loadingSuccessXXL).fadeOut();
//                 }, 1000);
//
//                 liveToast(response['message'], 'bi-check-circle-fill', 'success')
//             },
//             error: function(jqXHR, textStatus, errorThrown){
//                 liveToast(jqXHR['responseJSON']['message'], 'bi-exclamation-triangle-fill', 'danger')
//                 setTimeout(function () {
//                     t.html(loadingError).fadeOut();
//                 }, 1000);
//                 setTimeout(function () {
//                     t.css('background', textPrimary).html('Verify').fadeIn();
//                 }, 1200);
//             }
//         });
//     })
// }
