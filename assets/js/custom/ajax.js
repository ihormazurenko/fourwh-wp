// function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

jQuery(document).ready(function($) {
    //for build page
    if ($('#summary').length && $('.save-pdf-btn').length) {
        var submitBtn = $('.save-pdf-btn');

        submitBtn.on('click', function (e) {
            e.preventDefault();
            $('#ajax-pdf-content').html('<span class="ajax-pdf-loader is-active"></span>');

            var summary = [],
                model = $('[data-model]').data('model'),
                totalPrice = $('[name="total-price"]').val(),
                totalWeight = $('[name="total-weight"]').val();

            $('.customizer-form input[data-option]').each(function () {
                var input = $(this);

                if( input.prop('checked') == true) {
                    var thisId = $(this).attr('id'),
                        thisParentGroup = input.data('optionParentGroup'),
                        thisGroup = $(this).data('groupName'),
                        thisName = input.data('optionName'),
                        thisPrice = parseFloat(input.data('price')) || 0;

                    var currentItem = {
                        id: thisId,
                        name: thisName,
                        price: thisPrice
                    };

                    var currentGroup = {
                        groupName: thisGroup,
                        items: [currentItem]
                    };

                    var currentParentGroup = {
                        parentName: thisParentGroup,
                        groups: [currentGroup]
                    };


                    function fwcCheckIndex(arr, value, prop) {
                        var status = -1;

                        if (!arr.length && !value && !prop) {
                          return status;
                        }

                        for (var i = 0; i < arr.length; i++) {
                            if (arr[i][prop] === value) {
                                status = i;
                            }
                        }

                        return status;
                    }


                    if (summary.length > 0) {
                        var parentGroupId = fwcCheckIndex(summary, thisParentGroup, 'parentName');

                        //check parent group
                        if ( parentGroupId === -1) {
                            summary.push(currentParentGroup);
                        } else {
                            var groupId = fwcCheckIndex(summary[parentGroupId].groups, thisGroup, 'groupName');

                            // check child group
                            if (groupId === -1) {
                                summary[parentGroupId].groups.push(currentGroup);
                            } else {
                                var itemId = fwcCheckIndex(summary[parentGroupId].groups[groupId].items, thisId, 'id');

                                //check items group
                                if (itemId === -1) {
                                    summary[parentGroupId].groups[groupId].items.push(currentItem);
                                }
                            }
                        }
                    } else {
                        summary.push(currentParentGroup);
                    }
                }
            });

            data = {
                'action': 'save_pdf',
                'model_name': model,
                'summary': summary,
                'total_price': totalPrice,
                'total_weight': totalWeight,
                'exterior': '',
            };

;
            $.ajax({
                url: ajaxurl,
                data: data,
                type: 'POST',
                success: function(data) {
                    if( data ) {
                        $('#ajax-pdf-content').html(data);
                    } else {
                        $('#ajax-pdf-content').html('<p>Sorry, there was a failure! Please try again.</p>');
                    }
                },
                error: function () {
                    // $('#ajax-pdf-content').html('<p>Sorry, there was a failure! Please try again.</p>');
                }
            });
        });
    }


    //for floorplan slider
    if ($('.swiper-inner-images-box img').length) {
        $(function () {
            $('.swiper-inner-images-box img').on('click', function () {
                var currentImg = $(this),
                    currentSlide = currentImg.closest('.swiper-slide-active'),
                    floorplanId = currentImg.data('floorplanId'),
                    parentBox = currentSlide.find('.swiper-main-img-box'),
                    allImages = currentSlide.find('.plan-slide-img');


                parentBox.append('<div class="holder"><div class="preloader"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
                allImages.removeClass('active');

                setTimeout(function () {
                    currentImg.addClass('active');
                },100);

                data = {
                    'action': 'generate_img',
                    'floorplan_id': floorplanId
                };

                $.ajax({
                    url: ajaxurl,
                    data: data,
                    type: 'POST',
                    success: function (data) {
                        if (data) {
                            parentBox.html(data);
                        }
                    }
                });


            });
        });

        $(function () {
            if ($('.swiper-inner-nav-btn').length) {
                $('.swiper-inner-nav-btn').on('click', function () {
                    var currentSlide = $('.slider-plan .gallery-top .swiper-slide-active'),
                        innerImg = currentSlide.find('.swiper-inner-images-box').find('.plan-slide-img'),
                        innerCurrentImg = currentSlide.find('.swiper-inner-images-box').find('.plan-slide-img.active'),
                        innerCurrentImgId = innerCurrentImg.attr('data-floorplan-id'),
                        num = 0,
                        idArr = [];

                    innerImg.each(function (i) {
                        idArr.push(innerImg.eq(i).attr('data-floorplan-id'));
                    });

                    var indexInArray = idArr.indexOf(innerCurrentImgId),
                        lengthArr = idArr.length - 1;


                    if ($(this).hasClass('inner-next')) {
                        num = 1;
                    } else if ($(this).hasClass('inner-prev')) {
                        num = -1;
                    }

                    var nextIndex = indexInArray + num,
                        floorplanIndex = 0;

                    if (nextIndex >= 0 && nextIndex <= lengthArr) {
                        floorplanIndex = nextIndex;
                    } else if (nextIndex < 0) {
                        floorplanIndex = lengthArr;
                    } else {
                        floorplanIndex = 0;
                    }

                    var floorplanId = idArr[floorplanIndex],
                        parentBox = currentSlide.find('.swiper-main-img-box');


                    parentBox.append('<div class="holder"><div class="preloader"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
                    innerImg.removeClass('active');

                    setTimeout(function () {
                        innerImg.eq(floorplanIndex).addClass('active');
                    }, 100);

                    data = {
                        'action': 'generate_img',
                        'floorplan_id': floorplanId
                    };

                    $.ajax({
                        url: ajaxurl,
                        data: data,
                        type: 'POST',
                        success: function (data) {
                            if (data) {
                                parentBox.html(data);
                            }
                        }
                    });

                });
            }
        });
    }
});
