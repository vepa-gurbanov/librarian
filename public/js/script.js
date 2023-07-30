const $ = jQuery;
$(document).ready(function () {
    $.noConflict();
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
    $('.swiperLiked').each(function(){
        let swiper = $(this).attr('id');
        new Swiper( '#' + swiper, {
            slidesPerView: 4,
            spaceBetween: 30,
            grabCursor: true,
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
