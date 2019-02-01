jQuery(document).ready(function($) {
    //for build page
    if ($('#summary').length && $('.save-pdf-btn').length) {
        var submitBtn = $('.save-pdf-btn');

        submitBtn.on('click', function (e) {
            e.preventDefault();
            $('#ajax-pdf-content').html('<span class="ajax-pdf-loader is-active"></span>');

            var summary = {},
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
                        thisPrice = input.data('optionPrice');

                    summary[thisParentGroup] = {
                        [thisGroup] : {
                            [thisId] : {
                                name: thisName,
                                price: thisPrice,
                            }
                        }
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

            // console.log('click');
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
        $('.swiper-inner-images-box img').on('click', function () {
            var currentImg = $(this),
                floorplanId = currentImg.data('floorplanId'),
                parentBox = currentImg.closest('.swiper-slide').find('.swiper-main-img-box'),
                img = parentBox.find('img');

            parentBox.append('<div class="holder"><div class="preloader"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');

            data = {
                'action': 'generate_img',
                'floorplan_id' : floorplanId
            };

            $.ajax({
                url: ajaxurl,
                data: data,
                type: 'POST',
                success: function(data) {
                    if( data ) {
                        parentBox.html(data);
                    }
                }
            });


        });
    }
});