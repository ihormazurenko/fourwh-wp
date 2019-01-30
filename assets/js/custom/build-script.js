function number_format(number, decimals, dec_point, separator ) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');

    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof separator === 'undefined') ? ',' : separator ,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',

        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k)
                .toFixed(prec);
        };

    // fix bug IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
        .split('.');

    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }

    if ((s[1] || '')

        .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1)
            .join('0');
    }

    return s.join(dec);
}


jQuery(document).ready(function($) {

    //for change color
    $(function() {
        if ($('.color-box input').length) {
            $('.color-box input').on('change', function () {
                var parentBox = $(this).parents('.color-selector-box'),
                    parentInnerBox = parentBox.find('.group-img-wrap'),
                    parentInnerBoxClass = $(this).data('imgMediumLargeClass'),
                    url = $(this).data('imgFull'),
                    urlMediumLarge = $(this).data('imgMediumLarge'),
                    previewType = $(this).data('preview'),
                    alt = $(this).next('label').find('img').attr('alt'),
                    zoomLink = parentBox.find('.zoom-img'),
                    image = parentInnerBox.find('img.active');

                zoomLink.attr('href', url).attr('title', alt);
                image.attr('src', urlMediumLarge).attr('alt', alt);


                if (parentInnerBoxClass == 'wider') {
                    if (!(parentInnerBox.hasClass('wider'))) {
                        parentInnerBox.addClass('wider');
                    }
                } else {
                    if (parentInnerBox.hasClass('wider')) {
                        parentInnerBox.removeClass('wider');
                    }
                }

                if (previewType == 'interior') {
                    $('[data-interior-preview]').attr('href', url).attr('title', alt).find('img')
                        .attr('src', url).attr('alt', alt);
                } else if (previewType == 'exterior') {
                    $('[data-exterior-preview]').attr('href', url).attr('title', alt).find('img')
                        .attr('src', url).attr('alt', alt);
                }
            })
        }
    });

    //for tooltip
    if (typeof tippy !== 'undefined') {
        if ($('.color-box label').length) {
            var tip = tippy('.color-box label', {
                delay: 50,
                arrow: true,
                arrowType: 'round',
                size: 'large',
                duration: 350,
                animation: 'scale'
            });
        }
    }


    //for customizer form
    $(function() {
        if ($('.customizer-form input').length) {

            var productInput = $('.customizer-form input[name="model_id"]'),
                productPrice = productInput.data('modelPrice'),
                productWeight = productInput.data('modelWeight'),
                totalPriceBox = $('.total-camper-box .price, .total-price-box .price.value, .total .price.value, .subtotal .price.value'),
                totalWeightBox = $('.total-camper-box .weight, .total-price-box .weight.value, .subtotal .weight.value'),
                totalPriceInput = $('.customizer-form input[name="total-price"]'),
                totalWeightInput = $('.customizer-form input[name="total-weight"]');

            var cf7Form = $('.form-quote-box'),
                optionsInput = cf7Form.find('[name="your-options"]'),
                priceInput = cf7Form.find('[name="your-total-price"]'),
                weightInput = cf7Form.find('[name="your-total-weight"]');


            $('.customizer-form input').on('click', function () {
                var price = productPrice,
                    weight = productWeight,
                    optionsString = '';


                if ($(this).data('checked') == 'selected') {
                    $(this).prop('checked', false);
                    $(this).data('checked', 'unselect');
                }

                $('.customizer-form input[data-option]').each(function () {
                    var input = $(this);

                    if (input.prop('checked') == true && input.data('standard') != 'standard') {
                        price += parseInt(input.data('price'));
                        weight += parseInt(input.data('weight'));
                    }

                    if (input.prop('checked') == false && input.data('standard') == 'standard') {
                        price -= parseInt(input.data('price'));
                        weight -= parseInt(input.data('weight'));
                    }

                    if (input.prop('checked') == true) {
                        var thisID = $(this).attr('id'),
                            thisParentGroup = input.data('optionParentGroup'),
                            thisGroup = $(this).data('optionGroup'),
                            thisName = input.data('optionName');

                        $('[data-option-parent-resume-group="' + thisParentGroup + '"]').show(0);
                        $('[data-option-resume-group="' + thisGroup + '"]').show(0).find('tr').hide(0);
                        $('[data-option-id="' + thisID + '"]').show(0);

                        optionsString += ' – ' + thisName + '\n';
                        input.data('checked', 'selected');
                    } else {
                        input.data('checked', 'unselect');
                    }
                });

                //remove pdf link
                $('#ajax-pdf-content').html('');

                if (productWeight == 0) {
                    if (weight > 0) {
                        totalWeightBox.text('+' + number_format(weight, 0, '.', ',') + 'lbs');
                    } else {
                        totalWeightBox.text(number_format(weight, 0, '.', ',') + 'lbs');
                    }
                } else {
                    totalWeightBox.text(number_format(weight, 0, '.', ',') + 'lbs');
                }


                if (productPrice == 0) {
                    if (price > 0) {
                        totalPriceBox.text('+ $' + number_format(price, 2, '.', ','));
                    } else {
                        totalPriceBox.text(number_format(price, 2, '.', ','));
                    }
                } else {
                    totalPriceBox.text('$' + number_format(price, 2, '.', ','));
                }


                totalPriceInput.val(price);
                totalWeightInput.val(weight);

                optionsInput.val(optionsString);
                priceInput.val('$' + number_format(price, 2, '.', ','));
                weightInput.val(number_format(weight, 0, '.', ',') + 'lbs');
            });

            $(window).on('load', function () {
                $('.customizer-form input[data-option]').each(function () {
                    var input = $(this);
                    if (input.prop('checked') == true) {
                        var thisID = input.attr('id'),
                            thisParentGroup = input.data('optionParentGroup'),
                            thisGroup = input.data('optionGroup'),
                            thisName = input.data('optionName');

                        $('[data-option-parent-resume-group="' + thisParentGroup + '"]').show(0);
                        $('[data-option-resume-group="' + thisGroup + '"]').show(0).find('tr').hide(0);
                        $('[data-option-id="' + thisID + '"]').show(0);

                        input.attr('data-checked', 'selected');
                    } else {
                        input.attr('data-checked', 'unselect');
                    }
                });

                $('.color-box input').each(function () {
                    var input = $(this);
                    if (input.prop('checked') == true) {
                        var parentBox = input.parents('.color-selector-box'),
                            parentInnerBox = parentBox.find('.group-img-wrap'),
                            parentInnerBoxClass = $(this).data('imgMediumLargeClass'),
                            url = input.data('imgFull'),
                            alt = input.next('label').find('img').attr('alt'),
                            previewType = input.data('preview');

                        if (parentInnerBoxClass == 'wider') {
                            if (!(parentInnerBox.hasClass('wider'))) {
                                parentInnerBox.addClass('wider');
                            }
                        } else {
                            if (parentInnerBox.hasClass('wider')) {
                                parentInnerBox.removeClass('wider');
                            }
                        }

                        if (previewType == 'interior') {
                            $('[data-interior-preview]').attr('href', url).attr('title', alt).find('img')
                                .attr('src', url).attr('alt', alt);
                        } else if (previewType == 'exterior') {
                            $('[data-exterior-preview]').attr('href', url).attr('title', alt).find('img')
                                .attr('src', url).attr('alt', alt);
                        }
                    }
                });

                if ($('.form-quote-box').length) {
                    var cf7Form = $('.form-quote-box'),
                        customizerForm = $('.customizer-form'),
                        modelInput = cf7Form.find('[name="your-model"]'),
                        optionsInput = cf7Form.find('[name="your-options"]'),
                        priceInput = cf7Form.find('[name="your-total-price"]'),
                        weightInput = cf7Form.find('[name="your-total-weight"]'),
                        modelName = customizerForm.find('[data-model]').data('model'),
                        modelPrice = customizerForm.find('[data-model-price]').data('modelPrice'),
                        modelWeight = customizerForm.find('[data-model-weight]').data('modelWeight'),
                        optionsString = '';

                    modelInput.val(modelName);
                    priceInput.val(modelPrice);
                    weightInput.val(modelWeight);

                    $('.customizer-form input[data-option]').each(function () {
                        var input = $(this);

                        if (input.prop('checked') == true) {
                            var thisName = input.data('optionName');

                            optionsString += ' – ' + thisName + '\n';
                        }
                    });

                    optionsInput.val(optionsString);

                }
                ;
            });
        }
    });
});

