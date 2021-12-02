<?php
/**
 * Contact Info
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */
 
class ct_ContactInfo extends WP_Widget {

   function __construct() {
	   $widget_ops = array('description' => 'Use this widget to display your contact information.' );
	   parent::__construct(false, __('CT Contact Info', 'contempo'),$widget_ops);      
   }

   function widget($args, $instance) {  
	extract( $args );
	global $ct_options;
	$title = $instance['title'];
	$logo = $instance['logo'];
	$ct_logo = isset( $ct_options['ct_logo']['url'] ) ? esc_html( $ct_options['ct_logo']['url'] ) : '';
	$ct_logo_highres = isset( $ct_options['ct_logo_highres']['url'] ) ? esc_html( $ct_options['ct_logo_highres']['url'] ) : '';
	$blurb = $instance['blurb'];
	$company = $instance['company'];
	$street = $instance['street'];
	$city = $instance['city'];
	$state = $instance['state'];
	$postal = $instance['postal'];
	$country = $instance['country'];
	$phone = $instance['phone'];
	$fax = $instance['fax'];
	$email = $instance['email'];
	$facebook = $instance['facebook'];
	$twitter = $instance['twitter'];
	$googleplus = $instance['googleplus'];
	$linkedin = $instance['linkedin'];
	$instagram = $instance['instagram'];
	$pinterest = $instance['pinterest'];

	global $ct_options;
	?>

		<?php echo $before_widget; ?>
		<?php if ($title) { echo $before_title . $title . $after_title; }
		echo '<div class="widget-inner">';
			/*if($logo == "Yes") { ?>
				<?php if(!empty($ct_options['ct_logo']['url'])) { ?>
					<a href="<?php echo home_url(); ?>"><img class="widget-logo marB30" src="<?php echo esc_url($ct_logo); ?>" <?php if(!empty($ct_logo_highres)) { ?>srcset="<?php echo esc_url($ct_logo_highres); ?> 2x"<?php } ?> alt="<?php bloginfo('name'); ?>" /></a>
				<?php } else { ?>
					<a href="<?php echo home_url(); ?>"><img class="widget-logo marB30" src="<?php echo get_template_directory_uri(); ?>/images/re7-logo.png" srcset="<?php echo get_template_directory_uri(); ?>/images/re7-logo@2x.png 2x" alt="WP Pro Real Estate 7" /></a>
				<?php } ?>
			<?php } */?>
			<h5>Contact Us</h5>
	        <?php /*if($blurb) { ?><p class="marB15"><?php echo esc_html($blurb); ?></p><?php }*/ ?>

	        <ul class="contact-info">
	            <?php if($street) { ?><li><i class="fa fa-home"></i> <?php echo esc_html($street); ?><br> <?php echo esc_html($city); ?><br> <?php echo esc_html($state); ?> <?php echo esc_html($postal); ?>, <?php echo esc_html($country); ?></li><?php } ?>
	            <?php if($phone) { ?><li><i class="fa fa-phone"></i> <?php echo esc_html($phone); ?></li><?php } ?>
	            <?php if($fax) { ?><li><i class="fa fa-fax"></i> <?php echo esc_html($fax); ?></li><?php } ?>
	            <?php if($email) { ?><li id="company-email"><i class="fa fa-envelope-o"></i> <a href="mailto:<?php echo antispambot($email); ?>"><?php echo antispambot($email); ?></a></li><?php } ?>
	        </ul>

	        <ul class="contact-social">
				<?php if($facebook != '') { ?>
	                <li class="facebook"><a href="<?php echo esc_url($facebook); ?>"><i class="fa fa-facebook"></i></a></li>
	            <?php } ?>
	            <?php if($twitter != '') { ?>
	                <li class="twitter"><a href="<?php echo esc_url($twitter); ?>"><i class="fa fa-twitter"></i></a></li>
	            <?php } ?>
	            <?php if($linkedin != '') { ?>
	                <li class="linkedin"><a href="<?php echo esc_url($linkedin); ?>"><i class="fa fa-linkedin"></i></a></li>
	            <?php } ?>
	            <?php if($googleplus != '') { ?>
	                <li class="google"><a href="<?php echo esc_url($googleplus); ?>"><i class="fa fa-google-plus"></i></a></li>
	            <?php } ?>
	            <?php if($pinterest != '') { ?>
	                <li class="pinterest"><a href="<?php echo esc_url($pinterest); ?>"><i class="fa fa-pinterest"></i></a></li>
	            <?php } ?>
	            <?php if($instagram != '') { ?>
	                <li class="instagram"><a href="<?php echo esc_url($instagram); ?>"><i class="fa fa-instagram"></i></a></li>
	            <?php } ?>
	        </ul>
	    </div>
		<?php echo $after_widget; ?>   
    <?php
   }

   function update($new_instance, $old_instance) {                
	   return $new_instance;
   }

   function form($instance) {    
   
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';    
		$blurb = isset( $instance['blurb'] ) ? esc_attr( $instance['blurb'] ) : '';
		$company = isset( $instance['company'] ) ? esc_attr( $instance['company'] ) : '';
		$street = isset( $instance['street'] ) ? esc_attr( $instance['street'] ) : '';
		$city = isset( $instance['city'] ) ? esc_attr( $instance['city'] ) : '';
		$state = isset( $instance['state'] ) ? esc_attr( $instance['state'] ) : '';
		$postal = isset( $instance['postal'] ) ? esc_attr( $instance['postal'] ) : '';
		$country = isset( $instance['country'] ) ? esc_attr( $instance['country'] ) : '';
		$phone = isset( $instance['phone'] ) ? esc_attr( $instance['phone'] ) : '';
		$fax = isset( $instance['fax'] ) ? esc_attr( $instance['fax'] ) : '';
		$email = isset( $instance['email'] ) ? esc_attr( $instance['email'] ) : '';
		$facebook = isset( $instance['facebook'] ) ? esc_attr( $instance['facebook'] ) : '';
		$twitter = isset( $instance['twitter'] ) ? esc_attr( $instance['twitter'] ) : '';
		$linkedin = isset( $instance['linkedin'] ) ? esc_attr( $instance['linkedin'] ) : '';
		$googleplus = isset( $instance['googleplus'] ) ? esc_attr( $instance['googleplus'] ) : '';
		$instagram = isset( $instance['instagram'] ) ? esc_attr( $instance['instagram'] ) : '';
		$pinterest = isset( $instance['pinterest'] ) ? esc_attr( $instance['pinterest'] ) : '';

		$logo = isset( $instance['logo'] ) ? esc_attr( $instance['logo'] ) : '';

		?>
		<p>
            <label for="<?php echo $this->get_field_id('logo'); ?>"><?php esc_html_e('Show Logo:','contempo'); ?></label>
            <select name="<?php echo $this->get_field_name('logo'); ?>" class="widefat" id="<?php echo $this->get_field_id('logo'); ?>">
                <option value="Yes" <?php if($logo == 'Yes'){ echo "selected='selected'";} ?>><?php esc_html_e('Yes', 'contempo'); ?></option>
                <option value="No" <?php if($logo == 'No'){ echo "selected='selected'";} ?>><?php esc_html_e('No', 'contempo'); ?></option>
            </select>
        </p>
		<p>
		   <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('blurb'); ?>"><?php esc_html_e('Blurb:','contempo'); ?></label>
			<textarea name="<?php echo $this->get_field_name('blurb'); ?>" class="widefat" id="<?php echo $this->get_field_id('blurb'); ?>"><?php echo $blurb; ?></textarea>
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('company'); ?>"><?php esc_html_e('Company Name:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('company'); ?>"  value="<?php echo $company; ?>" class="widefat" id="<?php echo $this->get_field_id('company'); ?>" />
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('street'); ?>"><?php esc_html_e('Street Address:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('street'); ?>"  value="<?php echo $street; ?>" class="widefat" id="<?php echo $this->get_field_id('street'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('city'); ?>"><?php esc_html_e('City:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('city'); ?>"  value="<?php echo $city; ?>" class="widefat" id="<?php echo $this->get_field_id('city'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('state'); ?>"><?php esc_html_e('State:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('state'); ?>"  value="<?php echo $state; ?>" class="widefat" id="<?php echo $this->get_field_id('state'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('postal'); ?>"><?php esc_html_e('Postal:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('postal'); ?>"  value="<?php echo $postal; ?>" class="widefat" id="<?php echo $this->get_field_id('postal'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('country'); ?>"><?php esc_html_e('Country:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('country'); ?>"  value="<?php echo $country; ?>" class="widefat" id="<?php echo $this->get_field_id('country'); ?>" />
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('phone'); ?>"><?php esc_html_e('Phone:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('phone'); ?>"  value="<?php echo $phone; ?>" class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" />
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('fax'); ?>"><?php esc_html_e('Fax:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('fax'); ?>"  value="<?php echo $fax; ?>" class="widefat" id="<?php echo $this->get_field_id('fax'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('email'); ?>"><?php esc_html_e('Email:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('email'); ?>"  value="<?php echo $email; ?>" class="widefat" id="<?php echo $this->get_field_id('email'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php esc_html_e('Facebook:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('facebook'); ?>"  value="<?php echo $facebook; ?>" class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" />
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php esc_html_e('Twitter:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('twitter'); ?>"  value="<?php echo $twitter; ?>" class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" />
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('googleplus'); ?>"><?php esc_html_e('Google+:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('googleplus'); ?>"  value="<?php echo $googleplus; ?>" class="widefat" id="<?php echo $this->get_field_id('googleplus'); ?>" />
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php esc_html_e('LinkedIn:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('linkedin'); ?>"  value="<?php echo $linkedin; ?>" class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" />
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php esc_html_e('Pinterest:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('pinterest'); ?>"  value="<?php echo $pinterest; ?>" class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" />
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('instagram'); ?>"><?php esc_html_e('Instagram:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('instagram'); ?>"  value="<?php echo $instagram; ?>" class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" />
		</p>
		<?php
	}
} 

register_widget('ct_ContactInfo');
?>