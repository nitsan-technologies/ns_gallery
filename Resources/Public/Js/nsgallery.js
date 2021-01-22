// code for lazyload background img
var $body = $('body');

document.addEventListener('lazybeforeunveil', function (e) {
    var bg = e.target.getAttribute('data-bg');
    if (bg) {
        e.target.style.backgroundImage = 'url(' + bg + ')';
    }
});

$(document).ready(function () {

    //slider gallery setting 
    if ($('.ns-gallery-thumb-slider-wrap').length) {
        var nsGallerySlider = $('.ns-gallery-slider-init');
              
        nsGallerySlider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            $('.slick-current .ns-gallery-slide-video-wrap').removeClass('video-played');
            if ($('.slick-current .ns-gallery-slide-video-wrap').hasClass('video-internal')) {
                var $vid = $('.slick-current .ns-gallery-slide-video-wrap .video');
                $vid[0].pause();
                $vid[0].currentTime = 0;
            } else if ($('.slick-current .ns-gallery-slide-video-wrap').hasClass('video-external')) {
                var $vid = $('.slick-current .ns-gallery-slide-video-wrap iframe.video');
                $vid[0].src = '';
            }
        });
    }    

    // code for video play button
    $('.btn-video-play').on('click', function(){
        $(this).parents('.ns-gallery-slide-video-wrap').addClass('video-played');
        if ($(this).parents('.ns-gallery-slide-video-wrap').hasClass('video-internal')) {
            var $vid = $(this).parents('.ns-gallery-slide-video-wrap').find('.video');
            $vid.get(0).play();
        }else {
            var $extVideo = $(this).parents('.ns-gallery-slide-video-wrap').find('iframe.video').data('src');
            console.log($extVideo);
            $(this).parents('.ns-gallery-slide-video-wrap').find('iframe.video').attr('src', $extVideo+'?autoplay=1');
        }
    });
});
