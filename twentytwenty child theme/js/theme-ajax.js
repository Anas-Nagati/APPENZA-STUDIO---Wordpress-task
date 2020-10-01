jQuery(document).ready(function($) {
    // for user login form
    $("form#rsUserLogin").submit(function(){
        var submit = $(".userLogin #submit"),
            preloader = $(".userLogin #preloader"),
            message	= $(".userLogin #message"),
            contents = {
                action: 		'user_login',
                nonce: 			this.rs_user_login_nonce.value,
                log:			  this.log.value,
                pwd:			  this.pwd.value,
                remember:		this.remember.value,
                redirection_url:	this.redirection_url.value
            };

        // disable button onsubmit to avoid double submision
        submit.attr("disabled", "disabled").addClass('disabled');

        // Display our pre-loading
        preloader.css({'visibility':'visible'});

        // on my previous tutorial it just simply returned HTML but this time I decided to use JSON type so we can check for data success and redirection url.
        $.post( theme_ajax.url, contents, function( data ){
            submit.removeAttr("disabled").removeClass('disabled');

            // hide pre-loader
            preloader.css({'visibility':'hidden'});

            // check response data
            if( 1 == data.success ) {
                // redirect to home page
                window.location = data.redirection_url;
            } else {
                // display return data
                message.html( '<p class="error">' + data + '</p>' );
            }

        }, 'json');

        return false;
    });
});
