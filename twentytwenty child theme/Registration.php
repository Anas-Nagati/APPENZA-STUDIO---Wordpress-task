<?php
/*
 * Template Name: registration Template
 */

get_header();
?>
<div class="container form-container">
    <div class="bd-example">
        <img class="form-image" src="http://localhost/wordpress/wp-content/uploads/2020/10/65-651790_user-icon-login-logo.png">

        <H1> Register Your account now </H1>

        <p class="register-message" style="display:none"></p>
<form action="#" method="POST" name="register-form" class="register-form form-group">

	<fieldset>

        <div class="form-group">

        <div class="form-group">
                <label><i class="fa fa-file-text-o"></i> First Name</label>
                <input  type="text"  name="new_first_name" placeholder="firstname" id="new-firstname">
        </div>

        <div class="form-group">
                <label><i class="fa fa-file-text-o"></i> Last Name</label>
                <input  type="text"  name="new_last_name" placeholder="lastname" id="new-lastname">
        </div>

        <div class="form-group">
                <label><i class="fa fa-file-text-o"></i> User name</label>
		        <input  type="text"  name="new_user_name" placeholder="Username" id="new-username">
        </div>

        <div class="form-group">
                <label><i class="fa fa-file-text-o"></i> Email</label>
                <input  type="email"  name="new_user_email" placeholder="Email address" id="new-useremail">
        </div>

        <div class="form-group">
                <label><i class="fa fa-file-text-o"></i> Gender</label>
                <input  type="text"  name="new_user_gender" placeholder="Gender" id="new-usergender">
        </div>

        <div class="form-group">
                <label><i class="fa fa-file-text-o"></i> Age</label>
                <input  type="number"  name="new_user_age" placeholder="Age" id="new_userage">
        </div>

         <div class="form-group">
                <label><i class="fa fa-file-text-o"></i> Password</label>
                <input  type="password"  name="new_user_password" placeholder="Password" id="new-userpassword">
        </div>

        <div class="form-group">
                <label><i class="fa fa-file-text-o"></i> Re-enter Password</label>
                <input  type="password"  name="re-pwd" placeholder="Re-enter Password" id="re-pwd">

                <input type="hidden" name="register_url" id="register_url" value="<?php  $register_url = 'http://localhost/wordpress/?page_id=37';
		        echo wp_redirect( $register_url );
		        ?>" />

        </div>


        <div class="form-group form-button">
                <input type="submit"  class="button" id="register-button" value="Register" >
        </div>

	</fieldset>
</form>
    </div>
</div>


<script type="text/javascript" >
    let jQuery1 = jQuery('#register-button').on('click', function (e) {
        e.preventDefault();

        var newUserGender = jQuery('#new-usergender').val();
        var newUserAge = jQuery('#new_userage').val();
        var newFirstName = jQuery('#new-firstname').val();
        var newLastName = jQuery('#new-lastname').val();
        var newUserName = jQuery('#new-username').val();
        var newUserEmail = jQuery('#new-useremail').val();
        var newUserPassword = jQuery('#new-userpassword').val();

        jQuery.ajax({
            type: "POST",
            url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
            data: {
                action: "register_user_front_end",
                new_first_name: newFirstName,
                new_last_name: newLastName,
                new_user_name: newUserName,
                new_user_email: newUserEmail,
                new_user_password: newUserPassword,
                new_user_age: newUserAge,
                new_user_gender: newUserGender,
            },

            success: function (results){
                console.log(results);
                jQuery('.register-message').text(results).show();
            },

        error: function (results) {
                console.log(results);
            }
        });
    });
</script>
