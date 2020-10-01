jQuery('document').ready(function(){

    jQuery('#user-profile-frontend').submit(function(e){

        e.preventDefault();

        var user_meta_val = jQuery( '#user_email' ).val();
        var user_meta_key = jQuery( '#user_email' ).attr('id');

        if ( jQuery('user_meta_val') ) {
            jQuery.ajax ({
                url: user_meta_ajax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'user_meta_callback',
                    'user_meta_val': user_meta_val,
                    'user_meta_key': user_meta_key
                }
            })
                .success( function(results) {
                    console.log( 'User Meta Updated' );
                })
                .fail ( function(data) {
                    console.log( data.responseText );
                    console.log( 'Request Failed' + data.statusText );
                })
        } else {
            console.log( 'Uh oh. User error message' );
        }

        return false;
    });

});