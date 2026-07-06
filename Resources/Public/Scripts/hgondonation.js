jQuery(document).ready(function(){
    jQuery(document).on('submit', '#moneyAmount', function (event) {
        jQuery.ajax
        ({
             url: jQuery(this).attr('action'),
             data: jQuery(this).serialize(),
             type: 'post',
             success: function (json) {
                 var result = JSON.parse(json);
                 var keyIdArray = Object.keys(result.html);
                 var keyId = keyIdArray[0];
                 jQuery('.featherlight-content #' + keyIdArray).html(result.html[keyId].replace);
             }
         });
        event.preventDefault();
    });

    jQuery(document).on('click', '.js-donation-project-filter', function (event) {
        event.preventDefault();

        var category = jQuery(this).data('category').toString();
        var $filter = jQuery(this).closest('.donation-project-filter');
        var $items = $filter.next('.donation-project-list').find('.donation-project-list__item');

        $filter.find('.js-donation-project-filter').removeClass('is-active');
        jQuery(this).addClass('is-active');

        if (category === 'all') {
            $items.show();
            return;
        }

        $items.each(function () {
            var $item = jQuery(this);
            var hasCategory = $item.find('.js-donation-project-category[data-category="' + category + '"]').length > 0;
            $item.toggle(hasCategory);
        });
    });
});
