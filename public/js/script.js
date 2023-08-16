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

});
(() => {
    'use strict'
    $('#navbarSideCollapse').on('click', () => {
        $('.offcanvas-collapse').classList.toggle('open')
    })
})()


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
}

swiperSlider();

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
}

swiperMain();

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
}
swiperAuthors();


$('button#searchbar').on('click', function () {
    let q = $('input#searchbar').val();
    let form = $('form#bookFilter');
    let input = '<input type="hidden" name="q" value="' + q + '">';
    form.append(input);
    form.submit();
});

// function bookRating() {
//     $("#rating").rating({
//         min: 0,
//         max: 5,
//         step: 0.1,
//         stars: 5,
//         // showCaption:false,
//         starCaptions: function (val) {
//             if (val < 3) {
//                 return "Low: " + val + " stars";
//             } else {
//                 return "High: " + val + " stars";
//             }
//         }
//     });
// }
// bookRating();

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
}
collapse();


function like() {
    let likeButton = $('a[content=like]');
    likeButton.on('click', function () {
        let a = $(this);
        let id = a.attr('id');
        let span = $(this).find('span');
        let totalLikes = $('span#book' + id);

        span.html('<img src="http://127.0.0.1:8000/img/loading.gif" width="16" height="16">')

        $.ajax({
            method: 'GET',
            url: '/book/' + id + '/like',
            success: function (response) {
                setTimeout(function () {
                    if (response === 'liked') {
                        span.removeClass('text-dark');
                        span.addClass('text-danger');
                        span.html('<i class="bi-hand-thumbs-up-fill"></i>')
                        totalLikes.text(parseInt(totalLikes.text()) + 1);

                    } else if (response === 'disliked') {
                        span.removeClass('text-danger');
                        span.addClass('text-dark');
                        span.html('<i class="bi-hand-thumbs-up-fill"></i>')
                        totalLikes.text(parseInt(totalLikes.text()) - 1);

                    }
                }, 100);

                // Live toast
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance($('#liveToast'))
                $('#liveToast .toast-body').addClass('toast-body bg-success-subtle text-success-emphasis rounded');
                $('#liveToast .toast-body span#content').text(response);
                toastBootstrap.show()
                // Live toast

            },
            error: function (jqXHR, textStatus, response) {
                /* some function */
            }
        });
    });
}
like();


function addToCart() {
    let addToCartButton = $('a[content=cart]');

    if (window.location.href !== '/') {
        addToCartButton.on('click', function () {
            let a = $(this);
            let id = a.attr('id');
            let option = a.attr('option');
            let remove = a.attr('remove');
            let span = $(this).find('span');

            span.html('<img src="http://127.0.0.1:8000/img/loading.gif" width="16" height="16">')

            $.ajax({
                method: 'GET',
                data: {
                    'id': id,
                    'option': option,
                    'remove': remove,
                },
                url: '/cart',
                success: function (response) {
                    setTimeout(function () {
                        if (response === 'added') {
                            span.removeClass('text-dark');
                            span.addClass('text-success');
                            span.html('<i class="bi-cart-check-fill"></i>')
                        } else if (response === 'removed') {
                            span.removeClass('text-success');
                            span.addClass('text-dark');
                            span.html('<i class="bi-cart-plus-fill"></i>')
                        }
                    }, 100);

                    // Live toast
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance($('#liveToast'))
                    $('#liveToast .toast-body').addClass('toast-body bg-success-subtle text-success-emphasis rounded');
                    $('#liveToast .toast-body span#content').text(response);
                    toastBootstrap.show()
                    // Live toast

                },
                error: function (jqXHR, textStatus, response) {
                    /* some function */
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
}
hideAlertToast();

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


$('td a[content=dislike]').on('click', function () {
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
})
