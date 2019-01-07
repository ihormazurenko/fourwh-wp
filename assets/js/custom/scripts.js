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
                var heroSlider = new Swiper('.slider-hero .swiper-container', {
                    effect: 'fade',
                    autoHeight: true,
                    loop: true,
                    autoplay: {
                        delay: 5000,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    },
                });
            }

            //for video slider
            if ($('.slider-video .swiper-container').length) {
                var videoSlider = new Swiper('.slider-video .swiper-container', {
                    spaceBetween: 30,
                    navigation: {
                        nextEl: '.swiper-custom-button-next',
                        prevEl: '.swiper-custom-button-prev',
                    }
                });
            }


            //for social slider
            if ($('.social-slider').length) {
                var socilaSlider = new Swiper('.social-slider', {
                    slidesPerView: 3,
                    spaceBetween: 30,
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
                        }
                    }
                });
            }

            //for plan slider
            if ($('.slider-plan .gallery-thumbs').length && $('.slider-plan .gallery-top').length) {
                var planGalleryThumbs = new Swiper('.slider-plan .gallery-thumbs', {
                    spaceBetween: 20,
                    slidesPerView: 3,
                });

                var planGalleryTop = new Swiper('.slider-plan .gallery-top', {
                    spaceBetween: 10,
                    centeredSlides: true,
                    thumbs: {
                        swiper: planGalleryThumbs
                    }
                });
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
                var heroSlider = new Swiper('.slider-swatch .swiper-container', {
                    slidesPerView: 3,
                    spaceBetween: 30,
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

                dealerSliders.each(function () {
                    new Swiper($(this), {
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
                    fixedBgPos: true
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
        }

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

                            if ( urlType == 'single' ) {
                                btnBuild.attr('href', url + 'build');
                            } else if (  urlType == 'multiple' ) {
                                btnBuild.attr('href', url + '?type=build');
                            } else {
                                btnBuild.attr('href', url);
                            }

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
                                anchorNavOffset = stickyNav.offset().top
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
                lastScrollTop = 0;

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
                                    if (!(body.hasClass('direction-up'))) {
                                        body.removeClass('direction-down').addClass('direction-up');
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
                                    if (!(body.hasClass('direction-up'))) {
                                        body.removeClass('direction-down').addClass('direction-up');
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

                            lastScrollTop = top;
                        });
                    }
                }, 50);
            });
        }

        scrollEffects();

        // Accordion
        $(function() {
            var accordion = $('.accordion');

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

    });

});


