const loginButton = $('button[name=login]');
const registerButton = $('button[name=register]');
const verifyButton = $('button[name=verify]');
const authData = JSON.parse(localStorage.getItem('auth'));

login()
register()
verify()

function login() {
    loginButton.on('click', function () {
        let t = $(this);
        let form = t.parent().parent();
        let text = t.text();

        t.html(loadingImageSM);

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: {
                'phone': form.find('input[name=phone]').val(),
            },
            processData: true,
            dataType: 'json',
            success: function (response) {
                setTimeout(function () {
                    t.addClass('btn-sm btn-primary').html(loadingSuccess).fadeOut();
                }, 1000);
                setTimeout(function () {
                    t.css('background', textPrimary).html('Verify').fadeIn();
                }, 1200);

                $('button[name=verifyModal]').click();
                liveToast(response['message'], successIconClass, 'success')
                let data = {
                    'phone': form.find('input[name=phone]').val(),
                    'token': response['token']
                }
                localStorage.removeItem('auth');
                localStorage.setItem('auth', JSON.stringify(data));
            },
            error: function(jqXHR) {
                liveToast(jqXHR['responseJSON']['message'], errorIconClass, 'danger');
                setTimeout(function () {
                    t.html(loadingError).fadeOut();
                }, 1000);
                setTimeout(function () {
                    t.html(text).fadeIn();
                }, 1200);
            }
        });
    })
}


function register() {
    registerButton.on('click', function () {
        let t = $(this);
        let form = t.parent().parent();
        let text = t.text();

        t.html(loadingImage);

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: {
                'name': form.find('input[name=name]').val(),
                'phone': form.find('input[name=phone]').val(),
            },
            processData: true,
            dataType: 'json',
            success: function (response) {
                setTimeout(function () {
                    t.html(loadingSuccess).fadeOut();
                }, 1000);
                setTimeout(function () {
                    t.css('background', textPrimary).html('Verify').fadeIn();
                }, 1200);

                $('button[name=verifyModal]').click();
                liveToast(response['message'], successIconClass, 'success')
                let data = {
                    'name': form.find('input[name=name]').val(),
                    'phone': form.find('input[name=phone]').val(),
                    'token': response['token']
                }
                localStorage.removeItem('auth');
                localStorage.setItem('auth', JSON.stringify(data));
            },
            error: function(jqXHR) {
                liveToast(jqXHR['responseJSON']['message'], errorIconClass, 'danger');
                setTimeout(function () {
                    t.html(loadingError).fadeOut();
                }, 1000);
                setTimeout(function () {
                    t.html(text).fadeIn();
                }, 1200);
            }
        });
    })
}


function verify() {
    verifyButton.on('click', function () {
        let t = $(this);
        let form = t.parent();
        let code = '';

        t.html(loadingImage);

        $.each(form.find('input.otp-input'), (k, v) => {
            code += v.value.toString()
            console.log(k + ' : ' + v.value)
        })

        let formField;
        if (authData['name']) {
            formField = {
                'name': authData['name'],
                'phone': authData['phone'],
                'token': authData['token'],
                'code': parseInt(code),
            }
        } else {
            formField = {
                'phone': authData['phone'],
                'token': authData['token'],
                'code': parseInt(code),
            }
        }

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: formField,
            // processData: true,
            // contentType: 'application/json',
            // dataType: 'json',
            success: function (response) {
                if (response['status'] === 'success') {
                    localStorage.removeItem('auth')
                    form.html(loadingSuccessXXL).fadeIn();
                    setTimeout(function () {
                        $('.modal').fadeOut().after(function () {
                            location.reload();
                        });
                    }, 2000);
                    liveToast(response['message'], successIconClass, 'success')
                } else {
                    t.html('Verify').fadeIn();
                    liveToast(response['message'], errorIconClass, 'danger')
                }
            },
            error: function(jqXHR) {
                liveToast(jqXHR['responseJSON']['message'], errorIconClass, 'danger')
                setTimeout(function () {
                    t.html(loadingError).fadeOut();
                }, 1000);
                setTimeout(function () {
                    t.html('Verify').fadeIn();
                }, 1200);
            }
        });
    })
}
