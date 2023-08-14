$(document).ready(function () {
    $('input, textarea').addClass('bordered');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        }
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
    let text = collapse.text();
    collapse.on('click', function () {
        if (collapse.attr('aria-expanded') === 'false') {
            if (text !== 'Show more') {
                collapse.text(text + ' (Show)');
            } else {
                collapse.text('Show more');
            }
        } else if (collapse.attr('aria-expanded') === 'true') {
            if (text !== 'Show less') {
                collapse.text(text + ' (Hide)');
            } else {
                collapse.text('Show less');
            }
        }
    })
}
collapse();


function like() {
    let likeButton = $('a[content=like]');
    likeButton.on('click', function () {
        let a = $(this);
        let id = a.attr('id');
        let totalLikes = $('span#book' + id);
        $.ajax({
            method: 'GET',
            url: '/book/' + id + '/like',
            success: function (response) {
                if (response === 'liked') {
                    a.removeClass('text-dark');
                    a.addClass('text-danger');
                    totalLikes.text(parseInt(totalLikes.text()) + 1);
                } else if (response === 'disliked') {
                    a.removeClass('text-danger');
                    a.addClass('text-dark');
                    totalLikes.text(parseInt(totalLikes.text()) - 1);
                }

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


$('td a[content=like]').on('click', function () {
    $(this).closest('tr').fadeOut();
})
