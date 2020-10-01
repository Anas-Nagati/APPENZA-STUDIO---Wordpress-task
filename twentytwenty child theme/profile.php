<?php
/*
 * Template Name: Profile Template
 */
get_header();
// Function to edit User Meta
?>
<div class="container">
<?php


	if( is_user_logged_in() ) {
		/* Get user info. */
		global $current_user, $wp_roles;
		wp_get_current_user();?>
        <div class="container">
        <form id="user-profile-frontend">

            <div class="form-group">
            <label>
                <span>Email:</span>
                <input type="text" name="user_email_update" id="user_email" value="<?php echo $current_user->user_email ?>" />
            </label>
            </div>

                <div class="form-group">
            <label>
                <span>First Name:</span>
                <input type="text" name="first-name" id="first-name" value="<?php echo $current_user->first_name ?>" />
            </label>
                </div>

                    <div class="form-group">
            <label>
                <span>Last Name:</span>
                <input type="text" name="last-name" id="last-name" value="<?php echo $current_user->last_name ?>" />
            </label>
                    </div>

                        <div class="form-group">
            <label>
                <span>User name:</span>
                <input type="text" name="display-name" id="display-name" value="<?php echo $current_user->user_login ?>" />
            </label>
                        </div>
            <div class="form-group">
                <label>
                    <span>Age:</span>
                    <input type="text" name="display-name" id="display-name" value="<?php echo $current_user->User_Age ?>" />
                </label>
            </div>

            <div class="form-group">
                <label>
                    <span>Gender:</span>
                    <input type="text" name="display-name" id="display-name" value="<?php echo $current_user->User_Gender ?>" />
                </label>
            </div>


            <div class="form-group">
            <input type="submit" id="submit_update" value="Update Profile" />
                            </div>
        </form>

		<?php
	}else{
		echo '<h2>'.'You are not logged in please '.'<a href="http://localhost/wordpress/?page_id=37">Login</a>' . ' first'.'</h2>' ;


   }
	?>
            <?php
the_content();
get_footer();
?>
        </div>
<script type="text/javascript" >
    jQuery('#submit_update').on('click',function(e){
        e.preventDefault();
        var newUserName = jQuery('#new-username').val();
        var newUserEmail = jQuery('#user_email').val();
        var newUserPassword = jQuery('#new-userpassword').val();
        jQuery.ajax({
            type:"POST",
            url:"<?php echo admin_url('admin-ajax.php'); ?>",
            data: {
                action: "register_user_front_end",
                new_user_name : newUserName,
                user_email : newUserEmail,
                new_user_password : newUserPassword
            },
            success: function(results){
                console.log(results);
                jQuery('.register-message').text(results).show();
                window.location = 'localhost/wordpress/?page_id=44';
            },
            error: function(results) {

            }
        });
    });
</script>