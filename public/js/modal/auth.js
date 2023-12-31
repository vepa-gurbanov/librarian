const loginButton = $('button[name=login]');
const registerButton = $('button[name=register]');
const verifyButton = $('button[name=verify]');
const resendButton = $('a#resend');
const pTextForVerification = $('p#verifyHelpText');

fetchAuth()
login()
register()
verify()
resend()

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
                fetchAuth()
                setTimeout(function () {
                    t.addClass('btn-sm btn-primary').html(loadingSuccess).fadeOut();
                }, 1000);
                setTimeout(function () {
                    t.css('background', textPrimary).html('Verify').fadeIn();
                }, 1200);

                $('button[name=verifyModal]').click();
                liveToast(response['message'], successIconClass, 'success')
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
                fetchAuth()
                setTimeout(function () {
                    t.html(loadingSuccess).fadeOut();
                }, 1000);
                setTimeout(function () {
                    t.css('background', textPrimary).html('Verify').fadeIn();
                }, 1200);

                $('button[name=verifyModal]').click();
                liveToast(response['message'], successIconClass, 'success')
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
            },
        });
    })
}


function verify() {
    verifyButton.on('click', function () {
        let t = $(this);
        let form = t.parent().parent();

        t.html(loadingImage);

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: {
                'code': form.find('input[name=code]').val(),
            },
            // processData: true,
            // contentType: 'application/json',
            // dataType: 'json',
            success: function (response) {
                location.reload();
                if (response['status'] === 'success') {
                    form.html(loadingSuccessXXL).fadeIn();
                    $('.modal').fadeOut()
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
    resendButton.on('click', function () {
        let t = $(this).parent();

        t.append(loadingImageSM);

        $.ajax({
            url: 'oauth2r',
            method: 'POST',
            processData: true,
            dataType: 'json',
            success: function (response) {
                fetchAuth()
                t.find('img').remove();
                liveToast(response['message'], successIconClass, 'success')
            },
            error: function(jqXHR) {
                showFeedback(jqXHR['responseJSON']['message'], "danger", $('form#verify'))
                liveToast(jqXHR['responseJSON']['message'], errorIconClass, 'danger');
                t.find('img').fadeOut();
            }
        });
    })
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


function fetchAuth() {
    $.ajax({
        url: '/oauth-fetch',
        method: 'GET',
        contentType: "application/json",
        dataType: 'json',
        processData: true,
        success: function (res) {
            $.each(res, (k,v) => {
                console.log('fetch response => '+k+': '+v)
            })

            if (res['expired'] === 0) {
                countdownTimer(res)
                // pTextForVerification.html('Your code was sent to <b>+993 ' + res['phone']+'</b><br>Expires in <span id="countdownTimer"></span>')
            } else {
                pTextForVerification.html(
                    '<a href="javascript:void(0);" data-bs-target="#registerModal" data-bs-toggle="modal">Sign up</a> or '+
                    '<a href="javascript:void(0);" data-bs-target="#loginModal" data-bs-toggle="modal">Log in</a> to request code.'
                )
            }

        }
    })
}


function countdownTimer(res) {
    if (!res['expired']) {

        const phone = res['phone'];
        const expiry = res['expiry'];

        pTextForVerification.html('Your code was sent to <b>+993 ' + phone +'</b><br>Expires in <span></span>');

        var countDownDate = new Date(expiry).getTime();
        var x = setInterval(function() {

            console.log('phone: '+phone)
            console.log('expiry: '+expiry)

            var now = new Date().getTime();
            // Get today's date and time

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            pTextForVerification.find('span').text(minutes + ':' + seconds + ' seconds')
            // document.getElementById("countdownTimer").innerHTML = minutes + ":" + seconds + " seconds";

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                pTextForVerification.html(
                    '<a href="javascript:void(0);" data-bs-target="#registerModal" data-bs-toggle="modal">Sign up</a> or '+
                    '<a href="javascript:void(0);" data-bs-target="#loginModal" data-bs-toggle="modal">Log in</a> to request code.'
                )
            }
        }, 1000);
    } else {
        pTextForVerification.html(
            '<a href="javascript:void(0);" data-bs-target="#registerModal" data-bs-toggle="modal">Sign up</a> or '+
            '<a href="javascript:void(0);" data-bs-target="#loginModal" data-bs-toggle="modal">Log in</a> to request code.'
        )
    }
}
