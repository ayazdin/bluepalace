<?php
/**
 * Booking Modal
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

global $ct_options;

?>
    
<div id="overlay">
    <div id="modal">
    	<div id="modal-inner">
	        <a href="#" class="close"><i class="fa fa-close"></i></a>
	        
	        <div id="login">
		        <?php echo ct_login_form(); ?>
	        </div>
	        
	        <div id="register">
				<?php echo ct_registration_form(); ?>
	        </div>

	        <div id="lost-password">
				<?php echo ct_lost_password_fields(); ?>
	        </div>
        </div>
    </div>
</div>