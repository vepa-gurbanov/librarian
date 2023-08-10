const $ = jQuery;
$(document).ready(function () {
    $.noConflict();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        }
    });

});
(() => {
    'use strict'
    $('#navbarSideCollapse').on('click', () => {
        $('.offcanvas-collapse').classList.toggle('open')
    })
})()

$('a').on('click', function () {
    console.log('clicked');
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
}
swiperSlider();

function swiperMain() {
    $('.swiperContent').each(function(){
        let swiper = $(this).attr('id');
        new Swiper( '#' + swiper, {
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
    let input = '<input type="hidden" name="q" value="'+q+'">';
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
            url: 'http://127.0.0.1:8000/books/'+id+'/'+rating,
            method: 'GET',
            dataType: 'JSON',
            processData: false,
            success:function(response) {
                location.reload();
                console.log(response);
            },
            error:function (response, error) {
                if (response.statusText === 'Forbidden')
                {
                    location.replace('http://127.0.0.1:8000/0auth1');
                }
                console.log(response.statusText);
            }
        });
    })
}
rate()

function aCollapse() {
    let aCollapse = $('a[data-bs-toggle="collapse"]');
    aCollapse.on('click', function () {
        if (aCollapse.attr('aria-expanded') === 'false') {
            aCollapse.text('Show more');
        } else if (aCollapse.attr('aria-expanded') === 'true') {
            aCollapse.text('Show less');
        }
    })
}
aCollapse();
