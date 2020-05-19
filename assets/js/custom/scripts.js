 jQuery(function($) {

    // header fade
    $(function () {
        var header = $('#header-main, #header-scrolling');
        setTimeout(function () {
            header.addClass('show');
        }, 800);
    });

    $(document).ready(function() {
        // for placeholder link
        function prevent(){
            $('.prevent, .btn-modal, a[href="#"]').on('click touch', function(event){
                event.preventDefault();
            });
        }

        // for empty link
        prevent();

        // for burger menu
        $(function () {
            function burgerMenu() {
                $('.mobile-menu-toggle').toggleClass('active');
                $('.mobile-menu-wrap').toggleClass('showing');
                $('#header-main').toggleClass('white-bg');
                $('body').toggleClass('overflow');

                if ($('.toggle-woo-category.active').length &&  $('.woo-sidebar.showing').length) {
                    $('.toggle-woo-category').removeClass('active');
                    $('.woo-sidebar').removeClass('showing');
                    $('body').addClass('overflow');
                }
            }

            $('.mobile-menu-toggle, .mobile-menu-overlay').on('click', function () {
                burgerMenu();
            });
            $(window).on('resize', function () {
                var windowWidth = $(window).width();
                if (windowWidth > 1024 && $('.mobile-menu-toggle').hasClass('active')) {
                    burgerMenu();
                }
            });
        });

        //for submenu
        $(function () {
            if ($('.mobile-menu .sub-menu').length) {

                $(window).on('load', function() {
                    var links = $('.mobile-menu .menu-item-has-children > a');

                    links.each(function (i) {
                        var link = links.eq(i),
                            linkText = link.text(),
                            icon = link.find('i');

                        if (!(icon.hasClass('fa-plus'))) {
                            link.html(linkText + '<i class="fas fa-plus"></i>')
                        }

                    });
                });

                $('.mobile-menu .menu-item-has-children > a').on('click', function (e) {
                    // e.stopPropagation();
                    if (e.target !== this) {
                        e.preventDefault();

                        var icon = $(this).children('.fas');

                        if (icon.hasClass('fa-plus')) {
                            icon.removeClass('fa-plus').addClass('fa-minus');
                        } else {
                            icon.removeClass('fa-minus').addClass('fa-plus');
                        }

                        var box = $(this).closest('.menu-item-has-children'),
                            subMenu = box.children('.sub-menu');

                        box.toggleClass('show');
                        subMenu.slideToggle(350);
                    }

                    // $('.mobile-menu-toggle').toggleClass('active');
                    // $('.mobile-menu-wrap').toggleClass('showing');
                    // $(document.body).toggleClass('overflow');
                });
            }
        });

        // for category menu
        $(function () {
            if ($('.toggle-woo-category').length && $('.woo-sidebar').length) {
                function categoryMenu() {
                    $('.toggle-woo-category').toggleClass('active');
                    $('.woo-sidebar').toggleClass('showing');
                    $('body').toggleClass('overflow');

                    if ($('.mobile-menu-toggle.active').length && $('.mobile-menu-wrap.showing').length) {
                        $('.mobile-menu-toggle').removeClass('active');
                        $('.mobile-menu-wrap').removeClass('showing');
                        $('body').addClass('overflow');
                    }
                }

                $('.toggle-woo-category, .mobile-menu-overlay').on('click', function () {
                    categoryMenu();
                });

                $(window).on('resize', function () {
                    var windowWidth = $(window).width();
                    if (windowWidth > 1024 && $('.toggle-woo-category').hasClass('active')) {
                        categoryMenu();
                    }
                });
            }
        });


        //for smooth-scroll
        if (typeof SmoothScroll !== 'undefined') {
            var scroll = new SmoothScroll('a[href*="#"]', {

                // Selectors
                ignore: 'a[href="#"]',
                header: null,
                topOnEmptyHash: false,

                // Speed & Duration
                speed: 1000,
                speedAsDuration: true,
                durationMax: null,
                durationMin: null,
                clip: true,
                offset: function (anchor, toggle) {

                    var myOffset = 15,
                        currentPos =  $(window).scrollTop(),
                        headerHeight = $('#header-scrolling').outerHeight() + myOffset,
                        anchorNavHeight = $('.anchor-nav-box').outerHeight() + myOffset;

                    if (currentPos > anchor.offsetTop) {
                        //up
                        return anchorNavHeight + headerHeight;
                    } else {
                        //down
                        return anchorNavHeight;
                    }

                },

                // Easing
                easing: 'easeInOutCubic',

                // History
                updateURL: false,
                popstate: true,

                // Custom Events
                emitEvents: true

            });
        }

        //for nicescroll
        if (typeof NiceScroll !== 'undefined') {
            if ($('.specifications-accordion .inner-box').length) {
                setTimeout(function () {
                    $('.specifications-accordion .inner-box').niceScroll({
                        cursoropacitymax: 0.8,
                        cursorcolor: "#62666a",
                        cursorwidth: "6px",
                    });
                }, 50);
            }

            if ($('.inventory-list .inner-content-wrap').length) {
                setTimeout(function () {
                    $('.inventory-list .inner-content-wrap').niceScroll({
                        cursoropacitymin: 0.5,
                        cursoropacitymax: 0.8,
                        cursorcolor: "#62666a",
                        cursorwidth: "6px",
                    });
                }, 50);
            }

            if ($('.model-wrap .model-inner-box').length) {
                setTimeout(function () {
                    $('.model-wrap .model-inner-box').niceScroll({
                        cursoropacitymin: 0.5,
                        cursoropacitymax: 0.8,
                        cursorcolor: "#62666a",
                        cursorwidth: "6px",
                    });
                }, 50);
            }

            // if ($('.build .anchor-nav ul').length) {
            //     setTimeout(function () {
            //         $('.build .anchor-nav ul').niceScroll({
            //             scrollbarid: 'anchor-hor',
            //             horizrailenabled: true,
            //             cursoropacitymin: 0,
            //             cursoropacitymax: 0.8,
            //             cursorcolor:"#62666a",
            //             cursorwidth:"6px",
            //         });
            //     }, 50);
            // }
        }

        //for sliders
        if (typeof Swiper !== 'undefined') {
            //for hero slider
            if ($('.slider-hero .swiper-container').length) {
                $(".section-hero").imagesLoaded().done( function( instance ) {
                    var heroSlider = new Swiper('.slider-hero .swiper-container', {
                        // init: 0,
                        effect: 'fade',
                        autoHeight: true,
                        loop: true,
                        autoplay: {
                            delay: 6000,
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true
                        },
                    });
                });
            }

            //for video slider
            if ($('.slider-video .swiper-container').length) {
                var videoSlider = new Swiper('.slider-video .swiper-container', {
                    spaceBetween: 30,
                    slidesPerView: 2.12,
                    navigation: {
                        nextEl: '.swiper-custom-button-next',
                        prevEl: '.swiper-custom-button-prev',
                    },
                    breakpoints: {
                        1210: {
                            spaceBetween: 20,
                            slidesPerView: 2.12,
                            centeredSlides: false,
                            loop: false,
                        },
                        768: {
                            slidesPerView: 1.2,
                            centeredSlides: true,
                            loop: true,
                            spaceBetween: 20
                        }
                    }
                });
            }


            //for Latest News slider
            if ($('.front-latest-news').length) {
                $('.front-latest-news').imagesLoaded().done( function( instance ) {
                    var newsSlider = new Swiper('.front-latest-news', {
                        slidesPerView: 4,
                        spaceBetween: 0,
                        centerInsufficientSlides: true,
                        watchOverflow: true,
                        freeMode: true,
                        watchSlidesVisibility: true,
                        watchSlidesProgress: true,
                        navigation: {
                            nextEl: '.swiper-news-button-next',
                            prevEl: '.swiper-news-button-prev',
                        },
                        breakpoints: {
                            540: {
                                slidesPerView: 1
                            },
                            767: {
                                slidesPerView: 2
                            },
                            1200: {
                                slidesPerView: 3
                            }
                        },
                    });
                });
            }


            //for social slider
            if ($('.social-slider').length) {
                $('.social-slider').imagesLoaded().done( function( instance ) {
                    var socilaSlider = new Swiper('.social-slider', {
                        slidesPerView: 4,
                        spaceBetween: 30,
                        watchOverflow: true,
                        navigation: {
                            nextEl: '.swiper-social-button-next',
                            prevEl: '.swiper-social-button-prev',
                        },
                        breakpoints: {
                            540: {
                                slidesPerView: 1
                            },
                            767: {
                                slidesPerView: 2
                            },
                            1200: {
                                slidesPerView: 3
                            }
                        },
                    });
                });
            }

            //for plan slider
            if ($('.slider-plan .gallery-thumbs').length && $('.slider-plan .gallery-top').length) {
                $('.slider-plan').imagesLoaded().done( function( instance ) {
                        var planGalleryThumbs = new Swiper('.slider-plan .gallery-thumbs', {
                            spaceBetween: 12,
                            slidesPerView: 5,
                            centerInsufficientSlides: true,
                            watchOverflow: true,
                            freeMode: true,
                            watchSlidesVisibility: true,
                            watchSlidesProgress: true,
                            navigation: {
                                nextEl: '.slider-plan .swiper-button-next',
                                prevEl: '.slider-plan .swiper-button-prev',
                            },
                            breakpoints: {
                                1440: {
                                    slidesPerView: 4
                                },
                                860: {
                                    slidesPerView: 3
                                },
                                540: {
                                    slidesPerView: 2
                                }
                            }
                        });

                        var planGalleryTop = new Swiper('.slider-plan .gallery-top', {
                            spaceBetween: 10,
                            effect: 'fade',
                            centeredSlides: true,
                            autoHeight: true,
                            thumbs: {
                                swiper: planGalleryThumbs
                            },
                            on: {
                                init: function () {
                                    toggleNavBtn();
                                },
                                slideChange: function () {
                                    toggleNavBtn();
                                }
                            }
                        });

                    setTimeout(function () {
                        planGalleryThumbs.update();
                        planGalleryTop.update();
                    }, 100);

                    function toggleNavBtn() {
                        setTimeout(function () {
                            var img = $('.slider-plan .gallery-top').find('.swiper-slide-active .swiper-inner-images-box').find('.plan-slide-img'),
                                btn =$('.slider-plan .gallery-top').find('.swiper-inner-nav-btn'),
                                imgCount = img.length;

                            if (imgCount > 1) {
                                btn.show(0)
                            } else {
                                btn.hide(0);
                            }
                        },50);
                    }
                });
            }

            //for virtual tour slider
            if ($('.slider-virtual-tour .gallery-thumbs').length && $('.slider-virtual-tour .gallery-top').length) {
                var slideList = $('.slider-virtual-tour .gallery-top .swiper-slide'),
                    vimeoFrames = slideList.find('[data-video]'),
                    jqueryPlayer = {};

                var virtualGalleryThumbs = new Swiper('.slider-virtual-tour .gallery-thumbs', {
                    spaceBetween: 20,
                    slidesPerView: 5,
                    centerInsufficientSlides: true,
                    watchOverflow: true,
                    freeMode: true,
                    watchSlidesVisibility: true,
                    watchSlidesProgress: true,
                    navigation: {
                        nextEl: '.slider-virtual-tour .swiper-button-next',
                        prevEl: '.slider-virtual-tour .swiper-button-prev',
                    },
                    breakpoints: {
                        1024: {
                            slidesPerView: 4
                        },
                        860: {
                            slidesPerView: 3
                        },
                        480: {
                            slidesPerView: 2
                        }
                    },
                     on: {
                        init: function () {
                            setTimeout(function () {
                                virtualGalleryThumbs.update();
                            },300);

                        }
                    },
                });

                var virtualGalleryTop = new Swiper('.slider-virtual-tour .gallery-top', {
                    spaceBetween: 10,
                    centeredSlides: true,
                    effect: 'fade',
                    thumbs: {
                        swiper: virtualGalleryThumbs
                    },
                    on: {
                        init: function () {
                            vimeoFrames.each(function (i) {
                                var videoType = $(this).data('video');
                                if (videoType == 'vimeo') {
                                    jqueryPlayer[i] = new Vimeo.Player($(this));
                                    setTimeout(function () {
                                        jqueryPlayer[i].pause();
                                    }, 50);
                                } else {
                                    // var youDivId = $(this).attr('id');
                                }

                            });

                            slideList.each(function (i) {
                                if ($(this).hasClass('swiper-slide-active')) {
                                    var videoType = $(this).find('iframe').data('video');
                                    setTimeout(function () {
                                        if (videoType == 'vimeo') {
                                            jqueryPlayer[i].play();
                                        } else {
                                            // jqueryPlayer[i].play();
                                            // console.log(jqueryPlayer[i])
                                        }
                                    }, 100);
                                }
                            });
                            // console.log(jqueryPlayer);
                            // console.log('swiper initialized');
                            setTimeout(function () {
                                virtualGalleryTop.update();
                            },300);
                        },
                        slideChangeTransitionEnd: function () {
                            stopVideo();
                            slideList.each(function (i) {
                                if ($(this).hasClass('swiper-slide-active')) {
                                    var videoType = $(this).find('iframe').data('video');
                                    setTimeout(function () {
                                        if (videoType == 'vimeo') {
                                            jqueryPlayer[i].play();
                                        } else {
                                            // jqueryPlayer[i].playVideo();
                                        }
                                    }, 100);
                                }
                            });

                            // console.log('play');
                        }
                    },
                });

                function stopVideo() {
                    vimeoFrames.each(function (i) {
                        var videoType = $(this).data('video');
                        if (videoType == 'vimeo') {
                            jqueryPlayer[i].pause();
                        } else {
                            // jqueryPlayer[i].stopVideo();
                        }
                    });
                }

                // setTimeout(function () {
                //     virtualGalleryTop.update();
                //     virtualGalleryThumbs.update();
                // }, 100);
            }

            //for vertical slider
            if ($('.slider-vertical .gallery-right').length && $('.slider-vertical .gallery-thumbs-left').length) {
                var verticalGalleryThumbs = new Swiper('.slider-vertical .gallery-thumbs-left', {
                    direction: 'vertical',
                    slidesPerView: 5,
                    spaceBetween: 20,
                    breakpoints: {
                        991: {
                            slidesPerView: 4
                        },
                        860: {
                            slidesPerView: 3
                        },
                        640: {
                            direction: 'horizontal',
                            slidesPerView: 3
                        }
                    }
                });

                var varticalGallery = new Swiper('.slider-vertical .gallery-right', {
                    spaceBetween: 20,
                    centeredSlides: true,
                    effect: 'fade',
                    thumbs: {
                        swiper: verticalGalleryThumbs,
                    },

                });
            }

            //for swatch slider
            if ($('.slider-swatch .swiper-container').length) {
                var swatchSlider = new Swiper('.slider-swatch .swiper-container', {
                    slidesPerView: 3,
                    spaceBetween: 30,
                    centerInsufficientSlides: true,
                    watchOverflow: true,
                    navigation: {
                        nextEl: '.swiper-swatch-button-next',
                        prevEl: '.swiper-swatch-button-prev',
                    },
                    breakpoints: {
                        767: {
                            slidesPerView: 2
                        },
                        480: {
                            slidesPerView: 1
                        }
                    }
                });
            }

            //for dealer slider
            if ($('.dealer-slider .swiper-container').length) {
                var dealerSliders = $('.dealer-slider .swiper-container');

                dealerSliders.each(function (i) {
                    dealerSliders.eq(i).imagesLoaded().done( function( instance ) {
                        new Swiper(dealerSliders.eq(i), {
                            effect: 'fade',
                            loop: true,
                            autoplay: {
                                delay: 5000,
                            },
                            pagination: {
                                el: '.swiper-pagination',
                                clickable: true
                            },
                        });
                    });
                });
            }
        }

        //for popup
        if (typeof $.fn.magnificPopup !== 'undefined') {
            if ($('.youtube-video').length && typeof $.fn.magnificPopup !== 'undefined') {
                $('.youtube-video').magnificPopup({
                    disableOn: 700,
                    type: 'iframe',
                    mainClass: 'mfp-fade',
                    removalDelay: 350,
                    preloader: false,
                    fixedContentPos: false,
                    fixedBgPos: true,
                    iframe: {
                        markup: '<div class="mfp-iframe-scaler">'+
                          '<div class="mfp-close"></div>'+
                          '<iframe class="mfp-iframe" frameborder="0" allow="autoplay" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'+
                          '</div>', // HTML markup of popup, `mfp-close` will be replaced by the close button
                    }
                });
            }
            if ($('.my-customized-view-list img').length) {
                $('.my-customized-view-list').magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    tLoading: 'Loading image #%curr%...',
                    mainClass: 'mfp-img-mobile',
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                    },
                    image: {
                        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                        titleSrc: function (item) {
                            return item.el.attr('title');
                        }
                    }
                });
            }
            if ($('.item-box img').length || $('.group-img-wrap img').length) {
                $('.item-box:not(.without-image), .group-img-wrap').magnificPopup({
                    delegate: 'a.icon-zoom',
                    type: 'image',
                    tLoading: 'Loading image #%curr%...',
                    mainClass: 'mfp-img-mobile',
                    image: {
                        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                        titleSrc: function (item) {
                            return item.el.attr('title');
                        }
                    }
                });
            }
            if ($('.group-box .zoom-img').length) {
                $('.group-box').magnificPopup({
                    delegate: 'a.zoom-img',
                    type: 'image',
                    tLoading: 'Loading image #%curr%...',
                    mainClass: 'mfp-img-mobile',
                    image: {
                        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                        titleSrc: function (item) {
                            return item.el.attr('title');
                        }
                    }
                });
            }
            if ($('.brochure-popup-form').length) {
                $('.brochure-popup-form').magnificPopup({
                    type: 'inline',
                    preloader: false,
                    focus: '#name',
                    fixedContentPos: false,
                    fixedBgPos: true,
                    // When elemened is focused, some mobile browsers in some cases zoom in
                    // It looks not nice, so we disable it:
                    callbacks: {
                        beforeOpen: function () {
                            if ($(window).width() < 700) {
                                this.st.focus = false;
                            } else {
                                this.st.focus = '#name';
                            }
                        }
                    }
                });
            }
            $('.virtual_tour').magnificPopup({
              type: 'iframe',
              mainClass: 'mfp_vtour_popup',

              iframe: {
                patterns: {
                  dailymotion: {

                    index: 'my.matterport.com',

                    id: function(url) {
                        var m = url;
                        if (m !== null) {

                            return m;
                        }
                        return null;
                    },

                    src: '%id%&play=1'

                  }
                }
              }


            });
                // $('.image-popup-no-margins').magnificPopup({
                //     type: 'image',
                //     closeOnContentClick: true,
                //     closeBtnInside: false,
                //     fixedContentPos: true,
                //     mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
                //     image: {
                //         verticalFit: true
                //     },
                //     zoom: {
                //         enabled: true,
                //         duration: 300 // don't foget to change the duration also in CSS
                //     }
                // });
        }

        //for vimeo video
        $(function () {
            if ( typeof Vimeo == 'object' ) {
                $(window).on('load', function () {
                    if ($('[data-vid-id]').length) {
                        var videoBoxes = $('[data-vid-id]');

                        videoBoxes.each(function (i) {
                            var singleVideo = videoBoxes.eq(i),
                                singleVideoID = singleVideo.attr('data-vid-id'),
                                singleVideoBoxID = singleVideo.attr('id');

                            var options = {
                                id: singleVideoID,
                                autoplay: 1,
                                loop: 1,
                                byline: 0,
                                controls: 0,
                                dnt: 1,
                                muted: 1,
                            };

                            var player = new Vimeo.Player(singleVideoBoxID, options);

                            player.setVolume(0);

                            player.on('play', function () {
                                // console.log('played the video!');
                                player.setVolume(0);
                                setTimeout(function () {
                                    $('body').addClass('video-loaded');
                                }, 50);
                            });
                        });
                    }
                    /*
                    if ($('.vimeo-iframe-wrap').length) {
                      var jqueryPlayer = new Vimeo.Player($('.vimeo-iframe-wrap'));

                      jqueryPlayer.on('play', function() {
                        console.log('Can Play');
                        jqueryPlayer.setVolume(0);
                        setTimeout(function () {
                          $('body').addClass('video-waves-loaded');
                        }, 50);
                      });
                    }
                     */
                });
            }
        });


        //insert Model url to Brochure Form
        $(function () {
           if ($('.brochure-popup-form').length && $('#brochure-form input.model-url-input').length) {
               $('.brochure-popup-form').on('click', function () {
                   var url = window.location.href;
                   $('#brochure-form input.model-url-input').val(url);
               });
           }
        });

        //fade in image onLoad
        $(function () {
           $('#main-content img');
            var allImg = $('#main-content img'),
                currentIndex = 0;

            $('#main-content').imagesLoaded().progress( function( instance, image ) {
                if (image.isLoaded) {
                    allImg.eq(currentIndex).addClass('fadein-style');
                }
                currentIndex++;
            });
        });

        //for More Info btn
        $(function() {
            if (($('.service-box').length || $('.item-box').length || $('.product-box').length || $('.inventory-detail-box').length) && $('.more-info-btn').length) {
                $('.more-info-btn').on('click', function (e) {
                    e.preventDefault();

                    if ($(this).hasClass('open')) {
                        $(this).removeClass('open').next('.more').slideUp(350);
                    } else {
                        $(this).addClass('open').next('.more').slideDown(350);
                    }
                });
            }
        });

        //for select truck
        $(function() {
            if ($('.section-select-truck').length && $('.select-truck-list').length) {
                $('.select-truck-list input').on('change', function () {
                    var listType = $(this).closest('ul.select-truck-list'),
                        parentBox = $(this).parents('.section-select-truck'),
                        bedLengthBoxes = parentBox.find('.choose-bed-length-box'),
                        btnBox = parentBox.find('.select-truck-btn-box'),
                        truckLengthList = parentBox.find('.select-truck-list.bed-length'),
                        input = $(this),
                        btnView = $('a[data-view-truck]'),
                        btnFind = $('a[data-find-truck]'),
                        btnBuild = $('a[data-build-truck]');

                    if (!(listType.hasClass('bed-length'))) {
                        //select truck
                        var type = $(this).data('truckType'),
                            currentLengthBox = $('.choose-bed-length-box[data-truck-group="' + type + '"]');

                        btnBox.fadeOut();
                        bedLengthBoxes.fadeOut();
                        truckLengthList.find('input').prop('checked', false);
                        // truckLengthList.fadeOut(350);

                        currentLengthBox.fadeIn(350);

                        setTimeout(function () {
                            $('html, body').animate({
                                scrollTop: currentLengthBox.offset().top - 300
                            }, 1000);
                        }, 350);


                    } else {
                        //select bed length
                        var url     = input.data('truckUrl'),
                            urlType = input.data('truckBtn');

                            btnFind.attr('href', url);
/*
                            if ( urlType == 'single' ) {
                                btnBuild.attr('href', url + 'build');
                            } else if (  urlType == 'multiple' ) {
                                btnBuild.attr('href', url + '?type=build');
                            }  else {
                                btnBuild.attr('href', url);
                            }



                            if ($(this).attr('data-truck-btn') == 'multiple_parent') {
                                btnBox.addClass('go-category');
                            } else {
                                btnBox.removeClass('go-category');
                            }
*/
                        btnBox.fadeIn(350);
                        setTimeout(function () {
                            $('html, body').animate({
                                scrollTop: btnBox.offset().top - 300
                            }, 1000);
                        }, 350);
                    }
                });
            }
        });

        // for anchor nav
        $(function() {
            var stickyNav = $('.anchor-nav-box');

            if (stickyNav && stickyNav.length) {
                var offset = stickyNav.offset().top,
                    stickyNavLinks = stickyNav.find('.anchor-nav').find('a');

                //Handle Active Link on Sroll
                function onScroll(event) {
                    if (stickyNavLinks && stickyNavLinks.length) {
                        var scrollPos = $(document).scrollTop();
                        stickyNav.find('a[href^="#"]').each(function () {
                            var currLink = $(this);
                            var refElement = $(currLink.attr("href")),
                                header = $('#header-main'),
                                // anchorNav = $('.anchor-nav-box'),
                                headerHeight = header.outerHeight(),
                                anchorNavHeight = stickyNav.outerHeight(),
                                anchorNavOffset = stickyNav.offset().top,
                            offset = 0;

                            if (refElement && refElement.length) {
                                if ($('body').hasClass('direction-up')) {
                                    offset = anchorNavHeight + headerHeight;
                                } else {
                                    offset = anchorNavHeight + 50;
                                }

                                var currSection = (refElement.offset().top <= (scrollPos + offset)) && (refElement.offset().top + refElement.outerHeight(true)) > (scrollPos + offset);


                                if (currSection) {
                                    stickyNavLinks.removeClass("active");
                                    currLink.addClass("active");
                                } else {
                                    currLink.removeClass("active");
                                }
                            }
                        });
                    }
                }

                $(document).on("scroll", onScroll);
            }
        });



        function scrollEffects() {
            var $window = $(window),
                html = $('html'),
                body = $('body'),
                header = $('#header-main'),
                anchorNav = $('.anchor-nav-box'),
                lastScrollTop = 0,
                delayHeight = 350,
                testCount = 0,
                workTrigger = 0;

            $window.on('load resize', function () {
                var currentPos = $window.scrollTop();

                body.removeClass('direction-up direction-down');
                header.removeClass('fixed');

                setTimeout(function () {
                    var windowWidth = $window.width(),
                        headerOffset = header.offset().top,
                        headerHeight = header.outerHeight(),
                        anchorNavHeight = anchorNav.outerHeight();

                    if (anchorNav.length) {
                        if (anchorNav.hasClass('.details')) {
                            var anchorNavOffset = anchorNav.offset().top - 40;
                        } else {
                            var anchorNavOffset = anchorNav.offset().top;
                        }
                    }

                    if (currentPos > anchorNavOffset) {
                        setTimeout(function () {
                            if (!(anchorNav.hasClass('affix'))) {
                                anchorNav.addClass('affix');
                                anchorNav.next().css('margin-top', anchorNavHeight);
                            }
                        }, 500);
                    }

                    if (windowWidth < 1025) {
                        // for mobile & tablet
                        var headerTrigger = headerOffset + headerHeight;

                        $window.unbind('scroll');
                        $window.on('scroll', function () {
                            var top = $window.scrollTop();

                            if (lastScrollTop > top) {
                                // scroll UP
                                if (top == 0 && top < 2 * headerTrigger) {
                                    if (body.hasClass('direction-up')) {
                                        body.removeClass('direction-up');
                                        header.removeClass('fixed');
                                    }
                                } else if (top != 0 && top > 2 * headerTrigger) {
                                    if (workTrigger == 1) {
                                        if (!(body.hasClass('direction-up'))) {
                                            body.removeClass('direction-down').addClass('direction-up');
                                        }
                                    }
                                }

                                //for anchor nav
                                if (anchorNav.length) {
                                    var anchorNavTrigger = anchorNavOffset - 65;

                                    if (top < anchorNavTrigger) {
                                        if (anchorNav.hasClass('affix')) {
                                            anchorNav.removeClass('affix');
                                            anchorNav.next().css('margin-top', '0');
                                        }
                                    }
                                }
                            } else {
                                // scroll DOWN
                                if (workTrigger == 1) {
                                    if (top > 2 * headerTrigger) {
                                        if (!(body.hasClass('direction-down'))) {
                                            body.removeClass('direction-up').addClass('direction-down');
                                        }
                                    }

                                    //for anchor nav
                                    if (anchorNav.length) {
                                        var anchorNavTrigger = anchorNavOffset;

                                        if (top > anchorNavTrigger) {
                                            if (!(anchorNav.hasClass('affix'))) {
                                                anchorNav.addClass('affix');
                                                anchorNav.next().css('margin-top', anchorNavHeight);
                                            }
                                        }
                                    }
                                }
                            }

                            if (testCount > delayHeight || testCount < -delayHeight) {
                                testCount = 0;
                                workTrigger = 1;
                            } else {
                                testCount = testCount + (top - lastScrollTop);
                                workTrigger = 0;
                            }

                            lastScrollTop = top;
                        });
                    } else {
                        //for desktop
                        var headerTrigger = headerOffset + headerHeight;

                        $window.unbind('scroll');
                        $window.on('scroll', function () {
                            var top = $window.scrollTop();

                            if (lastScrollTop > top) {
                                // scroll UP
                                //for main nav
                                if (top == 0 && top < 2 * headerTrigger) {
                                    if (body.hasClass('direction-up')) {
                                        body.removeClass('direction-up');
                                        header.removeClass('fixed');
                                    }
                                } else if (top != 0 && top > 2 * headerTrigger) {
                                    if (workTrigger == 1) {
                                        if (!(body.hasClass('direction-up'))) {
                                            body.removeClass('direction-down').addClass('direction-up');
                                        }
                                    }
                                }

                                //for anchor nav
                                if (anchorNav.length) {
                                    var anchorNavTrigger = anchorNavOffset;

                                    if (top < anchorNavTrigger) {
                                        if (anchorNav.hasClass('affix')) {
                                            anchorNav.removeClass('affix');
                                            anchorNav.next().css('margin-top', '0');
                                        }
                                    }
                                }
                            } else {
                                // scroll DOWN
                                if (workTrigger == 1) {
                                    //for main nav
                                    if (top > 2 * headerTrigger) {
                                        if (!(body.hasClass('direction-down'))) {
                                            body.removeClass('direction-up').addClass('direction-down');
                                        }
                                    }

                                    //for anchor nav
                                    if (anchorNav.length) {
                                        var anchorNavTrigger = anchorNavOffset;

                                        if (top > anchorNavTrigger) {
                                            if (!(anchorNav.hasClass('affix'))) {
                                                anchorNav.addClass('affix');
                                                anchorNav.next().css('margin-top', anchorNavHeight);
                                            }
                                        }
                                    }
                                }
                            }

                            if (testCount > delayHeight || testCount < -delayHeight) {
                                testCount = 0;
                                workTrigger = 1;
                            } else {
                                testCount = testCount + (top - lastScrollTop);
                                workTrigger = 0;
                            }

                            lastScrollTop = top;
                        });
                    }
                }, 50);
            });
        }

        scrollEffects();

        // Accordion
        $(function() {
            var accordion = $('.faq-questions .accordion, .specifications-accordion .accordion');

            accordion.on('click', function() {
                $(this).toggleClass('active');
                var panel = $(this).next();

                $('.panel').not(panel).slideUp();
                $('.accordion').not($(this)).removeClass('active');


                if(panel.is(':visible')) {
                    panel.slideUp();
                } else {
                    panel.slideDown();
                    if (panel.has('.inner-box')) {
                        if (typeof NiceScroll !== 'undefined') {
                            panel.find('.inner-box').niceScroll().resize();
                        }
                    }
                }

            });

        });

        function simulateBGCover(images, boxClass) {
            images.each(function (i) {

                var img = $(this),
                    box = img.closest(boxClass),
                    natWidth = img.context.naturalWidth,
                    natHeight = img.context.naturalHeight,
                    width = box[0].clientWidth,
                    height =box[0].clientHeight,
                    factorW = natWidth / natHeight,
                    factorH = natHeight / natWidth,
                    newWidth = 0,
                    newHeight = 0;


                if (width > height) {
                    // console.log('WIDER !!!!');
                    if (natWidth > natHeight) {
                        // console.log('wider image');

                        newWidth = factorW * height;
                        newHeight = height;

                        if (width > newWidth) {
                            // console.log(width + '   '+ newWidth);

                            newWidth = width;
                            newHeight = factorH * width;
                        }
                    } else {
                        // console.log('higher image');
                        newWidth = width;
                        newHeight = factorH * width;

                        if (height > newHeight) {
                            newHeight = height;
                            newWidth = factorW * height;
                        }
                    }
                } else {
                    // console.log('HIGHER');
                    if (natWidth > natHeight) {
                        // console.log('wider image');

                        newWidth = factorW * height;
                        newHeight = height;
                    } else {
                        // console.log('higher image');

                        newWidth = width;
                        newHeight = factorH * width;
                    }
                }

                img.css('width', newWidth);
                img.css('height', newHeight);
            });
        }

        $(function () {
            if ($('.isotope .centered-img img').length) {
                $(window).on('load lazyloaded resize hashchange', function () {
                    setTimeout(function () {
                        simulateBGCover($('.isotope .centered-img img'), '.centered-img');
                    },25);
                });
            }

            if ($('.section-my-life-details .wp-block-gallery img').length) {
                $(window).on('load lazyloaded resize hashchange', function () {
                    setTimeout(function () {
                        simulateBGCover($('.section-my-life-details .wp-block-gallery img'), 'figure');
                    },25);
                });
            }

            if ($('.section-my-life-details .centered-img img').length) {
                $(window).on('load lazyloaded resize hashchange', function () {
                    setTimeout(function () {
                        simulateBGCover($('.section-my-life-details .centered-img img'), '.centered-img');
                    },25);
                });
            }
        });


        //for isotope for My Life page
        $(function () {
            if (typeof $.fn.isotope !== 'undefined') {
                if ($('.section-life-grid .isotope').length) {

                    function getHashFilter() {
                        var hash = location.hash;
                        // get filter=filterName
                        var matches = location.hash.match( /filter=([^&]+)/i );
                        var hashFilter = matches && matches[1];
                        return hashFilter && decodeURIComponent( hashFilter );
                    }



                    var $grid = $('.section-life-grid .isotope');

                    // bind filter button click
                    var $filters = $('.button-group').on( 'click', 'a', function(e) {
                        e.preventDefault();

                        var filterAttr = $( this ).attr('data-filter');
                        // set filter in hash
                        location.hash = 'filter=' + encodeURIComponent( filterAttr );
                    });

                    var isIsotopeInit = false;

                    function onHashchange() {
                        var hashFilter = getHashFilter();
                        if ( !hashFilter && isIsotopeInit ) {
                            return;
                        }
                        isIsotopeInit = true;
                        // filter isotope
                        $grid.isotope({
                            itemSelector: '.grid-item',
                            layoutMode: 'masonry',
                            masonry: {
                                columnWidth: '.grid-sizer',
                                gutter: '.gutter-sizer'
                            },
                            filter: hashFilter
                        });
                        // set selected class on button
                        if ( hashFilter ) {
                            $filters.find('.active').removeClass('active').addClass('inverse');
                            $filters.find('[data-filter="' + hashFilter + '"]').removeClass('inverse').addClass('active');
                        }

                        if ($('.isotope .centered-img img').length) {
                            simulateBGCover($('.isotope .centered-img img'), '.centered-img');
                        }
                        // console.log('ISOTOPE Init');
                    }

                    $(window).on( 'hashchange', onHashchange );
                    // trigger event handler to init Isotope
                    onHashchange();


                    // var $grid = $('.section-life-grid .isotope').isotope({
                    //     // options
                    //     itemSelector: '.grid-item',
                    //     layoutMode: 'masonry',
                    //     // layoutMode: 'packery',
                    //     masonry: {
                    //         columnWidth: '.grid-sizer',
                    //         gutter: '.gutter-sizer'
                    //     },
                    // });
                    // console.log('ISOTOPE Init');
                }
            }
        });

        //for subscribe form
        $(function() {
            if ($('.dms_embeded_form').length) {
                var box = $('.dms_embeded_form'),
                    firstNameWrap = box.find('#first_name').closest('.form-group'),
                    emailWrap = box.find('.form-control.email').closest('.form-group'),
                    btnWrap = box.find('.dms_embeded_button').closest('.form-group');

                firstNameWrap.addClass('first-name-wrap');
                emailWrap.addClass('email-wrap');
                btnWrap.addClass('btn-box-wrap');
            }
        });

        $('.testimonial_item p').readmore();


        //for Mailchimp subscribe form
        $(function() {
            if ($('.subscribe-form').length) {
                var box = $('.subscribe-form'),
                    form = box.find('.mc4wp-form');

                form.on('submit', function () {
                    $(this).addClass('ajax-load');
                    $(this).find('.btn-wrap').html('<span class="ajax-loader"></span>');
                })

            }
        });

        //for select
        if ($('.select-wrap select').length) {
            $('.select-wrap select').change(function () {
                if (!($(this).hasClass('selected'))){
                    $(this).addClass('selected');
                }
            })
        }


        // $('.m_thumb_img').on('click', '.plan-slide-img', function() {
        //     $(this).parent().find('.plan-slide-img-modal').addClass('modal__activated')
        //     $(this).parent().find('.plan-slide-img-modal').show();
        // });


        $(function () {
           // $(window).on('load', function () {
               $('.plan-slide-img_carousel').magnificPopup({
                   type: 'image',
                   mainClass: 'mfp-fade',
                   removalDelay: 300,
                   easing: 'ease-in-out'
               });

               // setTimeout(function () {
                   $('.swiper-inner-images-box_carousel').owlCarousel({
                       items:2,
                       nav:true,
                       dots: false,
                       margin:2,
                       // autoHeight: true,
                   });
               // },25);
           // });
        });
        //hero image cover
        //$(".section-hero").imagesLoaded().done( function( instance ) {
            // console.log('imagesReady');
            // $(".section-hero img").cover({
            //     backgroundPosition:"bottom",
            //     checkWindowResize:true,
            //     loadHidden:true,
            //     callbacks: {
            //         "postLoading": function (data) {
            //             console.log('load');
            //             // console.log(data);
            //         }
            //     }
            // });
            //
            // if ($(".section-hero img").length) {
            //     var count = 0;
            //     function checkGreenishCover(){
            //         var heroBox = $('.section-hero'),
            //             boxes = heroBox.find('.swiper-slide'),
            //             boxesImgCount = boxes.find('img').length,
            //             trueCount = 0;
            //
            //         boxes.each(function (i) {
            //             // console.log(boxes.eq(i).find('img').css('visibility') == 'visible');
            //             var imgVisible = boxes.eq(i).find('img').css('visibility');
            //             console.log(imgVisible);
            //             if (boxes.eq(i).find('.greenishCover').length && imgVisible != 'hidden') {
            //                 trueCount++;
            //             } else {
            //                 trueCount = 0;
            //             }
            //         });
            //
            //         if (trueCount == boxesImgCount && trueCount != 0) {
            //             console.log('init slider');
            //             // console.log(heroSlider);
            //             // setTimeout(function () {
            //             // boxes.find('img').css('visibility', 'visible');
            //             // heroSlider.autoplay.start();
            //             heroSlider.init();
            //             // },500);
            //             stopInterval();
            //         } else {
            //             console.log('count - ' + count);
            //             if (count == 30) {
            //                 stopInterval();
            //             }
            //         }
            //         count++;
            //     }
            //
            //     var checker = setInterval(checkGreenishCover, 100);
            //
            //     function stopInterval() {
            //         clearInterval(checker);
            //         console.log('stop');
            //     }
            // }

      //  });

        // heroSlider.on('imagesReady', function () {

        // });



// console.log($(".section-hero img"));
        //for youtube and vimeo play
        // $(function() {
        //     if ($('.video-wrap').length) {
        //         // Find all YouTube videos
        //         var $allVideos = $("iframe[src^='//player.vimeo.com'], iframe[src^='//www.youtube.com']"),
        //
        //             // The element that is fluid width
        //             $fluidEl = $("body");
        //
        //         // Figure out and save aspect ratio for each video
        //         $allVideos.each(function () {
        //
        //             $(this)
        //                 .data('aspectRatio', this.height / this.width)
        //
        //                 // and remove the hard coded width/height
        //                 .removeAttr('height')
        //                 .removeAttr('width');
        //
        //         });
        //
        //         // When the window is resized
        //         $(window).resize(function () {
        //
        //             var newWidth = $fluidEl.width();
        //
        //             // Resize all videos according to their own aspect ratio
        //             $allVideos.each(function () {
        //
        //                 var $el = $(this);
        //                 $el
        //                     .width(newWidth)
        //                     .height(newWidth * $el.data('aspectRatio'));
        //
        //             });
        //
        //             // Kick off one resize to fix all videos on page load
        //         }).resize();
        //     }
        // });


        // for quantity box on details page
        var productDetailsQuantity = $('.woocommerce div.product form.cart div.quantity');
        if ( productDetailsQuantity.length ) {
            productDetailsQuantity.find('input').wrap(function() {
                return "<span class='nowrap'>Quantity:&nbsp;" + $(this).html() + "</span>";
            });
        }

    });
});


