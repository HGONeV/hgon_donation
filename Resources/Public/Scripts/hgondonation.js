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
});
