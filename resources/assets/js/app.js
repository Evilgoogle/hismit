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

var $mobile = false;
if ($clientWidht <= 640) {
    $mobile = true;
}

// $('input.phone').inputmask("+7 (999) 999 9999");

// поиск активной ссылки в меню
/*var url = location.hostname+location.pathname;
if (location.hostname+'/' !== url) {
    var $this = $('nav ul li a[href="/' + location.pathname.split("/")[1] +'"]');
    $this.closest('.li-first').addClass('active');
}*/

// new WOW().init();

$(document).ready(function () {

    // Yandex Maps
    if ($('div').hasClass('map_item')) {
        if (typeof ymaps != "undefined" && ymaps != null) {
            ymaps.ready(init);

            function init() {
                $(".map_item").each(function () {
                    getYandexMap($(this), ymaps);
                });
            }
        }
    }

});

// -------------------------------

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


// Яндекс Карта
function getYandexMap($this, ymaps) {
    var $id = $this.data('mapkey');
    $('#'+ $id).empty();

    var latLng = [
        parseFloat($this.data('latitude')),
        parseFloat($this.data('longitude'))
    ];

    var $icon_size = [50, 50];

    var myMap = new ymaps.Map(
        $id, {
            center: latLng,
            zoom: 16
        }, {
            searchControlProvider: 'yandex#search'
        });

    var myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
        hintContent: ''
    }, {
        // Опции.
        // Необходимо указать данный тип макета.
        iconLayout: 'default#image',
        // Своё изображение иконки метки.
        iconImageHref: '/images/map-marker.png',
        // Размеры метки.
        iconImageSize: $icon_size,
        // Смещение левого верхнего угла иконки относительно
        // её "ножки" (точки привязки).
        iconImageOffset: [0, 0]
    });

    myMap.geoObjects.add(myPlacemark);
}
