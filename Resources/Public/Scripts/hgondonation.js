jQuery(document).ready(function(){

    /*
        IMPORTANT: We do not use RkwBasics AjaxApi here. The form existing two times (lightbox featherlight creates a copy)
        -> So we manage it this way
     */
    jQuery(document).on('change', '#hgon-donation-project-search-form', function (event) {

        jQuery.ajax
        ({
             url: jQuery(this).attr('action'),
             data: jQuery(this).serialize(),
             type: 'post',
             success: function (json) {
                 var result = JSON.parse(json);
                 var keyIdArray = Object.keys(result.html);
                 var keyId = keyIdArray[0];
                 jQuery('.featherlight-content #donation-container').html(result.html[keyId].replace);
             }
         });
        event.preventDefault();
    });

    jQuery(document).on('submit', '#donation-time-form', function (event) {

        jQuery.ajax
        ({
             url: jQuery(this).attr('action'),
             data: jQuery(this).serialize(),
             type: 'post',
             success: function (json) {
                 var result = JSON.parse(json);
                 var keyIdArray = Object.keys(result.html);
                 var keyId = keyIdArray[0];
                 jQuery('.featherlight-content #donation-time-form').html(result.html[keyId].replace);
             }
         });
        event.preventDefault();
    });


    /*
     *  Donation
     */

    // Got AjaxApi problems on click (form is sending on select a radio button. Problem!)
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

    jQuery("#moneyAmount input[name='tx_hgondonation_listing[moneyAmount][permanent]']").on('click', function(){
        var radioValue = jQuery(this).val();
        if (radioValue == 1){
            jQuery('.option-sepa').show();
        } else {
            jQuery('.option-sepa').hide();
            jQuery('.option-data').hide();
            jQuery('input[name="tx_hgondonation_listing[moneyAmount][type]"][value="paypal"]').prop('checked', true);
        }
    });

    jQuery("#moneyAmount input[name='tx_hgondonation_listing[moneyAmount][type]']").on('click', function(){
        var radioValue = jQuery(this).val();
        if (radioValue == 'sepa'){
            jQuery('.option-data').show();
        } else {
            jQuery('.option-data').hide();
        }
    });



});
