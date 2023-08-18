$(document).ready(function () {
    $('input, textarea').addClass('bordered');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        }
    });

    $('[data-bs-toggle="tooltip"]').tooltip({
        html: true
    });


    $('table.dataTable').each(function () {
        initDatatables('#' + $(this).attr('id'), $(this).attr('searchable'));
    })

    (() => {
        'use strict'
        $('#navbarSideCollapse').on('click', () => {
            $('.offcanvas-collapse').classList.toggle('open')
        })
    })()
});


function swiperSlider() {
    let swiper = new Swiper(".swiperSlider", {
        pagination: {
            el: ".swiper-pagination",
            // dynamicBullets: true,
            type: "progressbar",
            clickable: true,
            // renderBullet: function (index, className) {
            //     return '<span class="' + className + '">' + (index + 1) + "</span>";
            // },
        },
        autoplay: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
} swiperSlider();

function swiperMain() {
    $('.swiperContent').each(function () {
        let swiper = $(this).attr('id');
        new Swiper('#' + swiper, {
            slidesPerView: 5,
            spaceBetween: 30,
            grabCursor: true,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                dynamicBullets: true,
                renderBullet: function (index, className) {
                    return '<span class="' + className + '">' + (index + 1) + "</span>";
                },
            },
            navigation: {
                nextEl: ".custom-swiper-button-prev",
                prevEl: ".custom-swiper-button-next",
            },
            autoplay: true,
        });
    });
} swiperMain();

function swiperAuthors() {
    new Swiper('.swiperAuthors', {
        loop: true,
        slidesPerView: 8,
        spaceBetween: 5,
        navigation: {
            nextEl: ".custom-swiper-button-prev",
            prevEl: ".custom-swiper-button-next",
        },
        autoplay: true,
    })
} swiperAuthors();

function rate() {
    $('input:radio[name=rate]').on('click', function () {
        let rating = $(this).val();
        let id = $('input:hidden[name=bookID]').val();
        $.ajax({
            url: 'http://127.0.0.1:8000/books/' + id + '/' + rating,
            method: 'GET',
            dataType: 'JSON',
            processData: false,
            success: function (response) {
                location.reload();
                console.log(response);
            },
            error: function (response, error) {
                if (response.statusText === 'Forbidden') {
                    location.replace('http://127.0.0.1:8000/0auth1');
                }
                console.log(response.statusText);
            }
        });
    })
}
rate()

function collapse() {
    let collapse = $('a[data-bs-toggle="collapse"]');
    // collapse.text(collapse.text() + '(Show)');
    collapse.on('click', function () {
        // let text = $(this).text();
        let caret = $(this).find('span#caret');
        caret.addClass('bi-caret-down-fill');
        if ($(this).attr('aria-expanded') === 'false') {
            caret.addClass('bi-caret-down-fill');
            caret.removeClass('bi-caret-up-fill');
        } else if ($(this).attr('aria-expanded') === 'true') {
            caret.addClass('bi-caret-up-fill');
            caret.removeClass('bi-caret-down-fill');
        }
    })
} collapse();


function like() {
    $('a[content=like]').on('click', function () {
        let a = $(this);
        let id = a.attr('id');
        let span = $(this).find('span');
        let totalLikes = $('span#book' + id);

        span.html('<img src="http://127.0.0.1:8000/img/loading.gif" width="16" height="16">');

        $.ajax({
            url: '/book/' + id + '/like',
            method: 'GET',
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response, textStatus, jqXHR) {
                $.each(response, function (key, value) {
                    console.log(key + ': ' + value)
                })
                setTimeout(function () {
                    if (response['key'] === 'liked') {
                        span.removeClass('text-dark').addClass('text-danger').html('<i class="bi-hand-thumbs-up-fill"></i>');
                        totalLikes.text(parseInt(totalLikes.text()) + 1);
                    } else if (response['key'] === 'disliked') {
                        span.removeClass('text-danger').addClass('text-dark').html('<i class="bi-hand-thumbs-up-fill"></i>');
                        totalLikes.text(parseInt(totalLikes.text()) - 1);
                    }
                }, 100);
                liveToast(response['message'], 'bi-check-circle-fill', 'success')
            },
            error: function(jqXHR, textStatus, errorThrown){
                liveToast(jqXHR['responseJSON']['message'], 'bi-exclamation-triangle-fill', 'danger')
            }
        });
    });
} like();


function addToCart() {
    if (window.location.href !== '/') {
        $('a[content=cart]').on('click', function () {
            let a = $(this);
            let span = $(this).find('span');

            span.html('<img src="http://127.0.0.1:8000/img/loading.gif" width="16" height="16">')

            $.ajax({
                url: '/cart',
                method: 'GET',
                processData: true,
                contentType: false,
                dataType: 'json',
                data: {
                    'id': a.attr('id'),
                    'option': a.attr('option'),
                    'remove': a.attr('remove'),
                },
                success: function (response, textStatus, jqXHR) {
                    setTimeout(function () {
                        if (response['key'] === 'added') {
                            span.removeClass('text-dark').addClass('text-success').html('<i class="bi-cart-check-fill"></i>')
                        } else if (response['key'] === 'removed') {
                            span.removeClass('text-success').addClass('text-dark').html('<i class="bi-cart-plus-fill"></i>')
                        }
                    }, 100);

                    liveToast(response['message'], 'bi-check-circle-fill', 'success')
                },
                error: function(jqXHR, textStatus, errorThrown){
                    liveToast(jqXHR['responseJSON']['message'], 'bi-exclamation-triangle-fill', 'danger')
                }
            });
        });
    }
}
addToCart();

function hideAlertToast() {
    if ($(document).has('#toast')) {
        setTimeout(function () {
            $('#toast').fadeOut();
        }, 3000)
    }
} hideAlertToast();

function liveSearch() {
    /* Starts live search */
    $('.scrollbar').each(function () {
        var search = 'search_' + $(this).attr('content');
        var scroll = $(this).attr('content') + 'Scroll';

        $('#' + search).keyup(function () {

            // Retrieve the input field text and reset the count to zero
            var filter = $(this).val();
            // Loop through the comment list
            $("div.scrollbar#" + scroll + " div#filterContent").each(function () {


                // If the list item does not contain the text phrase fade it out
                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                    $(this).fadeOut();

                    // Show the list item if the phrase matches and increase the count by 1
                } else {
                    $(this).show();
                }
            });

        });
    });
    /* End live search */
} liveSearch()

function initDatatables(selector, searchable = false) {
    if (searchable) {
        $(selector + " tfoot th").each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" class="form-control form-control-sm bordered" placeholder="Search ' + title + '" />');
        });

        var table = $(selector).DataTable({
            dom: '<"dt-buttons"Bf><"clear">lirtp',
            paging: true,
            autoWidth: true,
            buttons: [
                "colvis",
                "copyHtml5",
                "csvHtml5",
                "excelHtml5",
                "pdfHtml5",
                "print"
            ],
            initComplete: function (settings, json) {
                var footer = $(selector + " tfoot tr");
                $(selector + " thead").append(footer);
            }
        });

        $(selector + " thead").on("keyup", "input", function () {
            table.column($(this).parent().index())
                .search(this.value)
                .draw();
        });
    } else {
        $(selector).DataTable();
    }
}

function removeFromCart() {
    $('td a[content=removeFromCart]').on('click', function () {
        $(this).closest('tr').fadeOut();
        $.ajax({
            method: 'GET',
            data: {
                'id': $(this).attr('id'),
                'option': $(this).attr('option'),
                'remove': true,
            },
            url: '/cart',
        });
    });
} removeFromCart()

function date() {
    $.each(['receive', 'return'], function (k, v) {
        $('input[name=' + v + '_date_input]').on('change', function () {
            let a = $(this);

            $.ajax({
                url: '/date',
                method: 'GET',
                processData: true,
                contentType: false,
                dataType: 'json',
                data: {
                    'receive_date_input': $('input#' + a.attr('id') + '[name=receive_date_input]').val(),
                    'return_date_input': $('input#' + a.attr('id') + '[name=return_date_input]').val(),
                    'price_per_day': $('span#price_per_day_' + a.attr('id')).text(),
                },
                success: function (response, textStatus, jqXHR) {
                    $('input#' + a.attr('id') + '[name=total_date_input]').val(response['total_days']);
                    $('span#total_price_' + a.attr('id')).text(response['price_per_day']);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    liveToast(jqXHR['responseJSON']['message'], 'bi-exclamation-triangle-fill', 'danger');
                },
                complete : function(){
                    // $.unblockUI();
                }
            });
        });
    })

    $('input[name=total_date_input]').on('change', function () {
        let a = $(this);
        $.ajax({
            url: '/date',
            method: 'GET',
            processData: true,
            contentType: false,
            dataType: 'json',
            data: {
                'total_date_input': a.val(),
                'receive_date_input': $('input#'+a.attr('id')+'[name=receive_date_input]').val(),
                'price_per_day': $('span#price_per_day_' + a.attr('id')).text(),
            },
            success: function (response, textStatus, jqXHR) {
                $('input#' + a.attr('id') + '[name=return_date_input]').val(response['return_date'])
                $('span#total_price_' + a.attr('id')).text(response['price_per_day']);
            },
            error: function(jqXHR, textStatus, errorThrown){
                liveToast(jqXHR['responseJSON']['message'], 'bi-exclamation-triangle-fill', 'danger')
            },
            complete : function(){
                // $.unblockUI();
            }
        });
    });
} date()

function liveToast(response, icon, textStatus) {
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance($('#liveToast'))
    let toastBody = $('#liveToast .toast-body');
    toastBody.addClass(`toast-body bg-${textStatus}-subtle text-${textStatus}-emphasis rounded`);
    toastBody.find('span#icon').addClass(icon);
    toastBody.find('span#content').text(response);
    toastBootstrap.show()
}

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
        if ($(this).attr('type') === 'password') {
            $(this).attr('type', 'text').text('Hide').closest('.lct').find('.form-lct-input').attr('type', 'text');
        } else {
            $(this).attr('type', 'password').text('Show').closest('.lct').find('.form-lct-input').attr('type', 'password');
        }
    })

} lctInputInit()

// $('input[name=total_date_input]').on('change', function () {
//     let totalRentDaysCount = parseInt($(this).val());
//
//     let receiveDateInput = $('input#'+$(this).attr('id')+'[name=receive_date_input]');
//     let returnDateInput = $('input#'+$(this).attr('id')+'[name=return_date_input]');
//
//     let receiveDate = new Date(receiveDateInput.val());
//     // let returnDate = new Date(returnDateInput.val());
//
//     let currentYear = receiveDate.getFullYear();
//     let currentMonth = receiveDate.getMonth();
//     let currentDate = receiveDate.getDate();
//
//     // let firstDayOfCurrentMonth = new Date(currentYear, currentMonth, 1).getDate();
//     let lastDayOfCurrentMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
//     let returnDateUpdated = currentDate + totalRentDaysCount;
//
//
//     if (lastDayOfCurrentMonth < returnDateUpdated) {
//         let date = new Date();
//
//         let currentYear = date.getFullYear();
//         let currentMonth = date.getMonth();
//         let currentDate = date.getDate();
//     }
//
//
//
//     if (lastDayOfCurrentMonth >= returnDateUpdated) {
//         if (currentMonth <= 9) {
//             currentMonth = '0' + currentMonth;
//         }
//         let returnDate = new Date(currentYear + '-' + currentMonth + '-' + returnDateUpdated);
//         returnDateInput.val(returnDate.getFullYear() + '-' + returnDate.getMonth() + '-' + returnDate.getDate());
//         console.log('returnDate: ' + returnDate)
//     } else {
//         let returnDate = new Date(currentYear + '-' + (currentMonth+1) + '-' + (returnDateUpdated - lastDayOfCurrentMonth));
//         if (currentMonth <= 8) {
//             currentMonth = '0' + currentMonth;
//         }
//         returnDateInput.val(returnDate.getFullYear() + '-' + currentMonth + '-' + returnDate.getDate() - lastDayOfCurrentMonth);
//         console.log('returnDate: ' + returnDate)
//     }
//
//
//     // let formatted = receive_date.getFullYear()+'-'+receive_date.getMonth()+'-'+(receive_date.getDate()+parseInt(num));
//     // let date = date.setDate(return_date.getDate()+parseInt(num));
// })
//
//
// function GFG_Fun() {
//     let date = new Date();
//     let firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
//     let lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
//     console.log("First day=" + firstDay)
//     console.log("Last day = " + lastDay);
// }
