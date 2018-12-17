 jQuery(function($) {

    // Accordion
    $(function() {
        var accordion = $('.relationship-accordion .accordion');

        accordion.on('click', function() {
            $(this).toggleClass('active');
            var panel = $(this).next();

            // $('.panel').not(panel).slideUp();
            // $('.accordion').not($(this)).removeClass('active');


            if(panel.is(':visible')) {
                panel.slideUp();
            } else {
                panel.slideDown();
            }

        });

    });

});


