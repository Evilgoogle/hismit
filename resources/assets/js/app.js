require('./bootstrap');
// import Swiper from  'swiper/dist/js/swiper';
// require('./SmoothScroll');
require('./jquery.inputmask.bundle');
// import Swal from 'sweetalert2/dist/sweetalert2';
// require('./selectize.min');
// var WOW = require('./wow.js');
// require('../../../public/js/jquery.plate');
// require('./TweenMax.min.js');
// require('./jquery-parallax');
// require('hc-offcanvas-nav/src/js/hc-offcanvas-nav');
// require('./jquery-ui.min');

// -------------------------------

// new WOW().init();

// Ширина и высота экрана
const $displayWidht = screen.width;
const $displayHeight = screen.height;
console.log("Ширина экрана: " + $displayWidht + " / Высота экрана: " + $displayHeight);

// Ширина и высота браузера клиента
const $clientWidht = window.innerWidth;
const $clientHeight = window.innerHeight;
console.log("Ширина браузера: " + $clientWidht + " / Высота браузера: " + $clientHeight);

const $user_agent = navigator.userAgent.toLowerCase(); // detect the user agent
const $ios_devices = $user_agent.match(/(iphone|ipad)/) ? "touchstart" : "click"; //check ios devices

$('input.phone').inputmask("+7 (999) 999 9999");

// поиск активной ссылки в меню
/*var url = location.hostname+location.pathname;
if (location.hostname+'/' !== url) {
    var $this = $('nav ul li a[href="/' + location.pathname.split("/")[1] +'"]');
    $this.closest('.li-first').addClass('active');
}*/

/*$('#mobile_nav').hcOffcanvasNav({
    maxWidth: 1023,
    position: 'right',
    insertClose: false,
    insertBack: false,
    customToggle: '#mobile_button',
});*/

$(document).ready(function () {

    // swiper-slider automatic script
/*    $(".swiper-slider:not(.not)").each(function () {
        var $this = $(this),
            lgPerView = $this.data("lg-perview"),
            mdPerView = $this.data("md-perview"),
            smPerView = $this.data("sm-perview"),
            xsPerView = $this.data("xs-perview"),
            lgSpaceBetween = $this.data("lg-spacebetween"),
            mdSpaceBetween = $this.data("md-spacebetween"),
            smSpaceBetween = $this.data("sm-spacebetween"),
            xsSpaceBetween = $this.data("xs-spacebetween"),
            loop = $this.data("loop"),
            direction = $this.data("direction"),
            centered = $this.data("centered"),
            pagination = $this.data("pagination"),
            speed = $this.data("speed");

        if (typeof loop == "undefined")
            loop = false;
        if (typeof direction == "undefined")
            direction = "horizontal";
        if (typeof centered == "undefined")
            centered = false;
        if (typeof pagination == "undefined")
            pagination = false;
        if (typeof speed == "undefined")
            speed = 300;

        if (typeof lgPerView == "undefined")
            lgPerView = 1;
        if (typeof mdPerView == "undefined")
            mdPerView = lgPerView;
        if (typeof smPerView == "undefined")
            smPerView = mdPerView;
        if (typeof xsPerView == "undefined")
            xsPerView = smPerView;

        if (typeof lgSpaceBetween == "undefined")
            lgSpaceBetween = 1;
        if (typeof mdSpaceBetween == "undefined")
            mdSpaceBetween = lgSpaceBetween;
        if (typeof smSpaceBetween == "undefined")
            smSpaceBetween = mdSpaceBetween;
        if (typeof xsSpaceBetween == "undefined")
            xsSpaceBetween = smSpaceBetween;

        new Swiper($('.swiper-container', this), {
            slidesPerView: lgPerView,
            spaceBetween: lgSpaceBetween,
            direction: direction,
            centeredSlides: centered,
            speed: speed,
            navigation: {
                nextEl: $(".swiper-button-next", this),
                prevEl: $(".swiper-button-prev", this),
            },
            loop: loop,
            pagination: {
                el: $(".swiper-pagination", this),
                clickable: true,
            },
            parallax: true,
            breakpoints: {
                1920: {
                    slidesPerView: lgPerView,
                    spaceBetween: lgSpaceBetween
                },
                1600: {
                    slidesPerView: mdPerView,
                    spaceBetween: mdSpaceBetween
                },
                1000: {
                    slidesPerView: smPerView,
                    spaceBetween: smSpaceBetween
                },
                640: {
                    slidesPerView: xsPerView,
                    spaceBetween: xsSpaceBetween
                }
            }
        });
    });*/

    // Google Maps
    if (typeof google != "undefined" && google != null) {

        var zoom = 15;
        if ($clientWidht < 1024) {
            var zoom = 14;
        }
        if ($('div').hasClass('map_item')) {
            $(".map_item").each(function () {
                var $this = $(this),
                    latLng = {
                        lat: parseFloat($this.data('latitude')),
                        lng: parseFloat($this.data('longitude'))
                    },
                    styles = [],
                    style = {
                        center: latLng,
                        draggable: !0,
                        zoom: zoom,
                        styles: styles,
                        scrollwheel: !1,
                        disableDefaultUI: !0,
                        zoomControl: true,
                    };

                var map = new google.maps.Map(document.getElementById($this.data('mapkey')), style);

                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    icon: "/images/map-marker.png",
                });
            });
        }
    }

});

// -------------------------------

if ($clientWidht > 1024) {


}

var formRequest = $("#formRequest");
formRequest.submit(function(e){
    e.preventDefault();
    var formData = formRequest.serialize();
    $("button", formRequest).prop("disabled", true);

    $.ajax({
        url: '/request',
        type: 'POST',
        data: formData,
        dataType: 'json',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if (data.status == 'ok') {
                Swal.fire({
                    position: 'center',
                    type: 'success',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 2500
                });

                $('.form-input input', formRequest).val('');
                $("button", formRequest).prop('disabled', false);
            }
        },
    });
});
