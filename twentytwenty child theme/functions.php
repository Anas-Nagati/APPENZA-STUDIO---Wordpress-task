<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
	$parenthandle = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
	$theme = wp_get_theme();
	wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css',
		array(),  // if the parent theme code has a dependency, copy it to here
		$theme->parent()->get('Version')
	);
	wp_enqueue_style( 'child-style', get_stylesheet_uri(),
		array( $parenthandle ),
		$theme->get('Version') // this only works if you have Version in the style header
	);
}

function wpbootstrap_enqueue_styles() {
	wp_enqueue_style( 'bootstrap', '//stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' );
	wp_enqueue_style( 'my-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'wpbootstrap_enqueue_styles');



/**
 * Enqueue our Scripts and Styles Properly
 */
add_action( 'wp_ajax_nopriv_user_login', 'rs_user_login_callback' );
add_action( 'wp_ajax_user_login', 'rs_user_login_callback' );
/*
 *	@desc	Process theme login
 */
function rs_user_login_callback() {
	global $wpdb;

	$json = array();

	$error = '';
	$success = '';
	$nonce = $_POST['nonce'];

	if ( ! wp_verify_nonce( $nonce, 'rs_user_login_action' ) )
		die ( '<p class="error">Security checked!, Cheatn huh?</p>' );

	//We shall SQL escape all inputs to avoid sql injection.
	$username = $wpdb->escape($_POST['log']);
	$password = $wpdb->escape($_POST['pwd']);
	$remember = $wpdb->escape($_POST['remember']);
	$redirection_url = $wpdb->escape($_POST['redirection_url']);


	if( empty( $username ) ) {
		$json[] = 'Username field is required.';
	} else if( empty( $password ) ) {
		$json[] = 'Password field is required.';
	} else {

		$user_data = array();
		$user_data['user_login'] = $username;
		$user_data['user_password'] = $password;
		$user_data['remember'] = $remember;
		$user = wp_signon( $user_data, false );

		if ( is_wp_error($user) ) {
			$json[] = $user->get_error_message();
		} else {
			wp_set_current_user( $user->ID, $username );
			do_action('set_current_user');

			$json['success'] = 1;
			$json['redirection_url'] = $redirection_url;
		}
	}


	echo json_encode( $json );

	// return proper result
	die();
}


// localize wp-ajax, notice the path to our theme-ajax.js file
function scripts(){ wp_enqueue_script( 'wp_enqueue_scripts', get_stylesheet_directory_uri() . '/js/theme-ajax.js', array( 'jquery' ) );
wp_localize_script( 'wp_enqueue_scripts', 'theme_ajax', array(
	'url'        => admin_url( 'admin-ajax.php' ),
	'site_url'     => get_bloginfo('url'),
	'theme_url' => get_bloginfo('template_directory')
) );}

add_action('wp_enqueue_scripts' , 'scripts');


add_action('wp_ajax_register_user_front_end', 'register_user_front_end', 0);
add_action('wp_ajax_nopriv_register_user_front_end', 'register_user_front_end');
function register_user_front_end() {
	$new_first_name = stripcslashes($_POST['new_first_name']);
	$new_last_name = stripcslashes($_POST['new_last_name']);
	$new_user_name = stripcslashes($_POST['new_user_name']);
	$new_user_email = stripcslashes($_POST['new_user_email']);
	$new_user_password = $_POST['new_user_password'];
	$new_user_password_re = $_POST['re-pwd'];
	$user_nice_name = strtolower($_POST['new_user_email']);
	$user_age = $_POST['new_user_age'];
	$user_gender = $_POST['new_user_gender'];
	$user_data = array(
		'first_name' => $new_first_name,
		'last_name' => $new_last_name,
		'user_login' => $new_user_name,
		'user_email' => $new_user_email,
		'user_pass' => $new_user_password,
		'user_nicename' => $user_nice_name,
		'role' => 'subscriber'
	);
	if( empty($new_user_email) or !is_email($new_user_email) ){

		echo 'Email is required';

	}elseif( empty($new_user_password) && $new_user_password !== $new_user_password_re){

		echo 'Please enter a password and make sure it matches';

	}else{

	$user_id = wp_insert_user($user_data);

	$additional_data = array(
		'User_Age' => $user_age,
		'User_Gender' => $user_gender
	);
	if (!is_wp_error($user_id)) {
		echo 'we have Created an account for you.';
		foreach( $additional_data as $k => $v ) {
			update_user_meta( $user_id, $k, $v );
		}



		$to = 'anasnagati@gamil.com';
		$subject = 'New user registration';
		$message = 'This will be the message';
		wp_mail( $to, $subject, $message );
		wp_mail();


	} else {
		if (isset($user_id->errors['empty_user_login']) ) {
			$notice_key = 'User Name and Email are mandatory';
			echo $notice_key;
		} elseif (isset($user_id->errors['existing_user_login'])) {
			echo "This account is registered, go to login page to start using the website";

		}else
				{
			echo'Error Occured please fill up the sign up form carefully.';
		}
	}
		wp_redirect( home_url('/?page_id=44') );
}
}


function user_profile_enqueue() {

	// Register script for localization
	wp_register_script (
		'user-profile-mod',
		get_stylesheet_directory_uri() . '/js/user-profile-mod.js',
		array( 'jquery' ),
		'1.0',
		true
	);

	// Localize script so we can use $ajax_url
	wp_localize_script (
		'user-profile-mod',
		'user_meta_ajax',
		array(
			'ajaxurl'   => admin_url( 'admin-ajax.php' )
		)
	);

	// Enqueue script
	wp_enqueue_script( 'user-profile-mod' );
}
add_action( 'wp_enqueue_scripts', 'user_profile_enqueue' );

function user_meta_callback() {

	if ( !isset( $_POST) || empty($_POST) || !is_user_logged_in() ) {
		header( 'HTTP/1.1 400 Empty POST Values' );
		echo 'Could not verify POST values';
		exit;
	}

	$user_id = get_current_user_id();
	$user_meta_key = sanitize_text_field( $_POST['user_meta_key'] );
	$user_meta_val = sanitize_text_field( $_POST['user_meta_val'] );

	// Update single meta value
	update_user_meta( $user_id, $user_meta_key, $user_meta_val );

	 if (is_wp_error($user_id)) {
	    echo $user_id->get_error_message();
	 }
	 else {
	   echo 'Field updated!';
	}

	exit;
}
add_action( 'wp_ajax_user_meta_callback', 'user_meta_callback' );

