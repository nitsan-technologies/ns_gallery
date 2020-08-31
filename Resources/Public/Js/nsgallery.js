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
    // code for general gallery
    // $('.nsGallery').lightGallery({
    //     selector: '.ns-gallery-item',
    //     // for thumbnail 
    //     thumbnail: true,
    //     // for fullScreen
    //     fullScreen: true,
    //     // add custom class like 
    //     addClass: 'ns-gallery-arrow--icon-circle',
    //     //if dark theme is true then class add like 
    //     //addClass: 'ns-gallery-dark-theme ns-gallery-arrow--icon-circle',
    //     youtubePlayerParams: {
    //         modestbranding: 1,
    //         showinfo: 0,
    //         rel: 0,
    //         controls: 0
    //     },
    //     vimeoPlayerParams: {
    //         byline: 0,
    //         portrait: 0,
    //         color: 'A90707'
    //     }
    // });
    
    //local hosted video gallery setting
    // $('#nsGalleryLocalVideos').lightGallery({
    //     thumbnail: false,
    //     // autoplay option
    //     autoplay: false,
    //     fourceAutoplay: false,
    //     // if include videojs then enable following option
    //     //videojs: true,
    //     addClass: 'ns-gallery-video-icon--video-plus'
    // });

    //Youtube/vimeo video gallery setting
    // $('.nsGalleryPlayer').lightGallery({
    //     youtubePlayerParams: {
    //         modestbranding: 1,
    //         showinfo: 0,
    //         rel: 0,
    //         controls: 0
    //     },
    //     vimeoPlayerParams: {
    //         byline: 0,
    //         portrait: 0,
    //         color: 'A90707'
    //     }
    // });

    //slider gallery setting 
    // if ($('.ns-gallery-thumb-slider-wrap').length) {
    //     $('.ns-gallery-slider-init').slick({
    //         slidesToShow: 1,
    //         slidesToScroll: 1,
    //         dots: false,
    //         fade: true,
    //         asNavFor: '.ns-gallery-thumb-slider-init'
    //     });
    //     $('.ns-gallery-thumb-slider-init').slick({
    //         slidesToShow: 6,
    //         slidesToScroll: 1,
    //         asNavFor: '.ns-gallery-slider-init',
    //         dots: false,
    //         focusOnSelect: true,
    //         responsive: [
    //             {
    //                 breakpoint: 993,
    //                 settings: {
    //                     slidesToShow: 6,
    //                 }
    //             },
    //             {
    //                 breakpoint: 600,
    //                 settings: {
    //                     slidesToShow: 4,
    //                 }
    //             },
    //             {
    //                 breakpoint: 480,
    //                 settings: {
    //                     slidesToShow: 3,
    //                 }
    //             }
    //         ]
    //     });
    // }
    //Carousel gallery setting
    // if ($('.ns-gallery-carousel-init').length){
    //     $('.ns-gallery-carousel-init').slick({
    //         slidesToShow: 3,
    //         slidesToScroll: 1,
    //         arrows: true,
    //         dots: false,
    //         centerMode: true,
    //         variableWidth: true,
    //         infinite: true,
    //         focusOnSelect: true,
    //         cssEase: 'linear',
    //         touchMove: true,
    //     });
    //     var imgs = $('.ns-gallery-carousel-slide img');
    //         imgs.each(function(){
    //         var item = $(this).closest('.ns-gallery-carousel-slide');
    //         item.css({
    //             'background-image': 'url(' + $(this).attr('src') + ')', 
    //             'background-position': 'center',            
    //             '-webkit-background-size': 'cover',
    //             'background-size': 'cover', 
    //         });
    //         $(this).hide();
    //     });
    // }

    // code for Google Search view Gallery settings 
    // if ($('.ns-gallery-google-view').length){
    //     var initialHeight = 500;
    //     $('.GITheWall').GITheWall({
    //         nextButtonClass: 'nsgallery-icon nsgallery-next-icon',
    //         prevButtonClass: 'nsgallery-icon nsgallery-prev-icon',
    //         closeButtonClass: 'nsgallery-icon nsgallery-close-icon',
    //         dynamicHeight: false,
    //         initialWrapperHeight: initialHeight
    //     });
    // }
   
    // code for Zoom Gallery Setting
    // if($('.ns-gallery-zoom').length){
    //     // $('#nsGalleryZoomImgSingle').ezPlus({
    //     //     responsive: true,
    //     //     respond: [
    //     //         {
    //     //             range: '0-767',
    //     //             zoomWindowHeight: 230,
    //     //             zoomWindowWidth: 230,
    //     //             zoomWindowPosition: 6,
    //     //         },
    //     //         {
    //     //             range: '768-1199',
    //     //             zoomWindowHeight: 300,
    //     //             zoomWindowWidth: 300
    //     //         }
    //     //     ]
    //     // });
    //     // $("#nsGalleryZoomImg").ezPlus({
    //     //     lensSize: 100,
    //     //     gallery: 'nsGalleryZoom',
    //     //     cursor: 'pointer',
    //     //     galleryActiveClass: "active",
    //     //     imageCrossfade: true,
    //     //     loadingIcon: "images/spinner.gif",
    //     //     responsive: true,
    //     //     respond: [
    //     //         {
    //     //             range: '0-767',
    //     //             zoomWindowHeight: 230,
    //     //             zoomWindowWidth: 230,
    //     //             zoomWindowPosition: 5,
    //     //         },
    //     //         {
    //     //             range: '768-1199',
    //     //             zoomWindowHeight: 300,
    //     //             zoomWindowWidth: 300
    //     //         }
    //     //     ]
    //     // });
    // }

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

$(window).on('load', function () {
    // code for Masonry & Isotope Gallery Settings
    if ($('.ns-gallery-masonry-view').length) {
        var $grid = $('.grid');
        var $img = $('img');
        $grid.isotope({
            itemSelector: '.grid-item',
        });
        var $flexGrid = $('.ns-gallery-masonry-flex .grid');
        $flexGrid.isotope({
            itemSelector: '.grid-item',
            percentPosition: true,
            masonry: {
                columnWidth: '.grid-sizer'
            }
        });
        $grid.imagesLoaded(function () {
            $img.load(function () {
                $grid.isotope('layout');
            });
        });
        $('.ns-gallery-isotope-filters').on('click', 'button', function () {
            var filterValue = $(this).attr('data-filter');
            var $isotopGrid = $(this).parents('.ns-gallery-isotope-wrap').find('.grid');
            $isotopGrid.isotope({
                filter: filterValue
            });
            $(this).parents('.ns-gallery-isotope-wrap').find('.ns-gallery-isotope-filters button').removeClass('active');
            $(this).addClass('active');
        });
    }
    if ($('.ns-gallery-mosaic-view').length) {
        var $mosaicGrid = $('.ns-gallery-mosaic-view');
        var $img = $('img');
        $mosaicGrid.isotope({
            itemSelector: '.ns-gallery-mosaic-item',
            percentPosition: true,
            masonry: {
                columnWidth: '.grid-sizer'
            }
        });
        $mosaicGrid.imagesLoaded(function () {
            $img.load(function () {
                $mosaicGrid.isotope('layout');
            });
        });
    }
});

