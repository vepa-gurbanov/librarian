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
                localStorage.setItem('auth', JSON.stringify(data));
            },
            error: function(jqXHR) {
                showFeedback(jqXHR['responseJSON']['message'], "danger", form)
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
                localStorage.setItem('auth', JSON.stringify(data));
            },
            error: function(jqXHR) {
                showFeedback(jqXHR['responseJSON']['message'], "danger", form)
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
        let form = t.parent().parent();
        // let code = '';

        t.html(loadingImage);

        // $.each(form.find('input.otp-input'), (k, v) => {
        //     code += v.value.toString()
        //     console.log(k + ' : ' + v.value)
        // })

        // if (Object.is(authData, null)) {
        //     showFeedback("Error occurred! Try Request again!", "danger", form)
        //     liveToast('Error occurred! Try Request again!', errorIconClass, 'danger')
        //     setTimeout(function () {
        //         t.html(loadingError).fadeOut();
        //     }, 1000);
        //     setTimeout(function () {
        //         t.html('Verify').fadeIn();
        //     }, 1200);
        // }


        let formField;
        if (authData['name']) {
            formField = {
                'name': authData['name'],
                'phone': authData['phone'],
                'token': authData['token'],
                'code': form.find('input[name=code]').val(),
            }
        } else {
            formField = {
                'phone': authData['phone'],
                'token': authData['token'],
                'code': form.find('input[name=code]').val(),
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
                    form.html(loadingSuccessXXL).fadeIn();
                    setTimeout(function () {
                        $('.modal').fadeOut().after(function () {
                            location.reload();
                        });
                    }, 2000);
                    liveToast(response['message'], successIconClass, 'success')
                } else {
                    showFeedback(response['message'], "danger", form)
                    console.log(response['message'])
                    t.html('Verify').fadeIn();
                    liveToast(response['message'], errorIconClass, 'danger')
                }
            },
            error: function(jqXHR) {
                showFeedback(jqXHR['responseJSON']['message'], "danger", form)
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


function resend() {

}


function showFeedback(message, type, form) {
    let html = form.find('[name=feedback]').addClass('alert alert-'+ type +' alert-dismissible fade show py-1 text-start small').attr('role', 'alert')
    let div = document.createElement('div')
    if (typeof message === 'object') {
        $.each(message, (k, m) => {
            let li = document.createElement('li')
            div.append(li.innerHTML = m)
        })
    } else {
        div.innerHTML = message
    }
    form.find('[name=feedback]').html(html.innerHTML = div)
}
