jQuery(function($) {
    $('.js-catalog-product-container')
        .on('mouseenter', function() {
            $(this).find('.js-gallery').show();
        })
        .on('mouseleave', function() {
            $(this).find('.js-gallery').hide();

            var productImage = $(this).find('.product-image > img');
            $(productImage).attr('src', $(productImage).attr('data-origin'));
        });

    $('.js-product-gallery-item').on('mouseover', function() {
        var productImage = $(this).parent().next().find('img');

        if (!$(productImage).attr('data-origin')) {
            $(productImage).attr('data-origin', $(productImage).attr('src'));
        }

        $(productImage).attr('src', $(this).attr('data-origin'));
    });
});