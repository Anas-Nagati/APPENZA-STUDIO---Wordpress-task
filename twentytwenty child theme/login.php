<?php
/*
 * Template Name: LOginTemplate
 */

get_header();
?>
    <div class="container">
<?php
//Simple Ajax Login Form
//Source: http://natko.com/wordpress-ajax-login-without-a-plugin-the-right-way/
?>


<div class="container form-container">
    <div class="bd-example">

<div class="userLogin">
	<?php
	// check if the user already login
	if( is_user_logged_in() ) { ?>
		<p>It seems that you're already loggedin, <a href="<?php echo wp_logout_url( get_permalink() ); ?>">logout</a> to login with different account or register new account</p>
	<?php } else { ?>

		<!--message wrapper-->
		<div id="message" class="alert-box"></div>
        <img class="form-image" src="http://localhost/wordpress/wp-content/uploads/2020/10/65-651790_user-icon-login-logo.png">
        <h1>LOGIN</h1>
        <form method="post" id="rsUserLogin">
			<?php
			// this prevent automated script for unwanted spam
			if ( function_exists( 'wp_nonce_field' ) )
				wp_nonce_field( 'rs_user_login_action', 'rs_user_login_nonce' );
			?>
            <div class="form-group">
			<p>
				<label for="log">Username or email</label>
				<input type="text" name="log" id="log" placeholder="Username" />
			</p>
            </div>
            <div class="form-group">
            <p>
				<label for="password">Password</label>
				<input type="password" name="pwd" id="pwd" placeholder="Password" />
			</p>
            </div>
                <div class="form-group">
                <p>
				<label>
					<input type="checkbox" name="remember" id="remember" value="true" /> Remember Me
				</label>
			</p>
                </div>
                    <div class="form-group form-button">
                    <p>
				<input type="submit" id="submit" class="button btn-outline" value="Login" />
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/loading.gif" id="preloader" style="visibility:hidden;" alt="Preloader" />

                        <!-- where you’d like your user after logged in?, this set to current page-->
                        <input type="hidden" name="redirection_url" id="redirection_url" value="<?php

	                    $final_url = 'http://localhost/wordpress/';
	                    echo wp_redirect( $final_url );
	                    ?>" />

			</p>
                    </div>
		</form>
	<?php } ?>
</div>
    </div>
</div>
    </div>
<?php
get_footer();