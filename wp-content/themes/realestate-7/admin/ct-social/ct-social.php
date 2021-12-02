<?php
/*
Plugin Name: Contempo Social Widget
Plugin URI: http://contemporealestatethemes.com
Description: A simple social profile widget
Version: 1.0.0
Author: Chris Robinson
Author URI: http://contemporealestatethemes.com
*/

/*-----------------------------------------------------------------------------------*/
/* Include CSS */
/*-----------------------------------------------------------------------------------*/
 
function ct_social_css() {		
	wp_enqueue_style( 'ct_social_css', get_template_directory_uri() . '/admin/ct-social/assets/style.css', false, '1.0' );
}
add_action( 'wp_enqueue_scripts', 'ct_social_css' );

/*-----------------------------------------------------------------------------------*/
/* Register Widget */
/*-----------------------------------------------------------------------------------*/

class ct_Social extends WP_Widget {

	function __construct() {
	   $widget_ops = array('description' => 'Use this widget to display your social profiles.' );
	   parent::__construct(false, __('CT Social', 'contempo'),$widget_ops);      
	}
	
	function widget($args, $instance) {  
	
		extract( $args );
		global $ct_options;
		
		$title = $instance['title'];
		$dribbble = $instance['dribbble'];
		$email = $instance['email'];
		$facebook = $instance['facebook'];
		$flickr = $instance['flickr'];
		$foursquare = $instance['foursquare'];
		$github = $instance['github'];
		$googleplus = $instance['googleplus'];
		$instagram = $instance['instagram'];
		$linkedin = $instance['linkedin'];
		$medium = $instance['medium'];
		$pinterest = $instance['pinterest'];
		$skype = $instance['skype'];
		$twitter = $instance['twitter'];
		$youtube = $instance['youtube'];
		$links = $instance['links'];
	
	?>
		<?php echo $before_widget; ?>
		<?php if ($title) { echo $before_title . $title . $after_title; } ?>
        <ul>
			<?php if($dribbble) { ?>
                <li class="dribbble"><a href="<?php echo esc_url($dribbble); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-dribbble"></i></a></li>
            <?php } ?>
            <?php if($facebook) { ?>
                <li class="facebook"><a href="<?php echo esc_url($facebook); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-facebook"></i></a></li>
            <?php } ?>
            <?php if($twitter) { ?>
                <li class="twitter"><a href="<?php echo esc_url($twitter); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-twitter"></i></a></li>
            <?php } ?>
            <?php if($linkedin) { ?>
                <li class="linkedin"><a href="<?php echo esc_url($linkedin); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-linkedin"></i></a></li>
            <?php } ?>
            <?php if($googleplus) { ?>
                <li class="gplus"><a href="<?php echo esc_url($googleplus); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-google-plus"></i></a></li>
            <?php } ?>
            <?php if($instagram) { ?>
                <li class="instagram"><a href="<?php echo esc_url($instagram); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-instagram"></i></a></li>
            <?php } ?>
            <?php if($flickr) { ?>
                <li class="flickr"><a href="<?php echo esc_url($flickr); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-flickr"></i></a></li>
            <?php } ?>
            <?php if($foursquare) { ?>
                <li class="foursquare"><a href="<?php echo esc_url($foursquare); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-foursquare"></i></a></li>
            <?php } ?>
            <?php if($github) { ?>
                <li class="github"><a href="<?php echo esc_url($github); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-github"></i></a></li>
            <?php } ?>
            <?php if($medium) { ?>
                <li class="medium"><a href="<?php echo esc_url($medium); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-medium"></i></a></li>
            <?php } ?>
            <?php if($pinterest) { ?>
                <li class="pinterest"><a href="<?php echo esc_url($pinterest); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-pinterest"></i></a></li>
            <?php } ?>
            <?php if($skype) { ?>
                <li class="skype"><a href="<?php echo esc_url($skype); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-skype"></i></a></li>
            <?php } ?>
            <?php if($youtube) { ?>
                <li class="youtube"><a href="<?php echo esc_url($youtube); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-youtube"></i></a></li>
            <?php } ?>
             <?php if($email) { ?>
                <li class="email"><a href="mailto:<?php echo esc_html($email); ?>"><i class="fa fa-envelope"></i></a></li>
            <?php } ?>
        </ul>	
		<?php echo $after_widget; ?>   
    <?php
   }

   function update($new_instance, $old_instance) {                
	   return $new_instance;
   }

   function form($instance) {
	   
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$dribbble = isset( $instance['dribbble'] ) ? esc_attr( $instance['dribbble'] ) : '';
			$email = isset( $instance['email'] ) ? esc_attr( $instance['email'] ) : '';
			$facebook = isset( $instance['facebook'] ) ? esc_attr( $instance['facebook'] ) : '';
			$flickr = isset( $instance['flickr'] ) ? esc_attr( $instance['flickr'] ) : '';
			$foursquare = isset( $instance['foursquare'] ) ? esc_attr( $instance['foursquare'] ) : '';
			$github = isset( $instance['github'] ) ? esc_attr( $instance['github'] ) : '';
			$googleplus = isset( $instance['googleplus'] ) ? esc_attr( $instance['googleplus'] ) : '';
			$instagram = isset( $instance['instagram'] ) ? esc_attr( $instance['instagram'] ) : '';
			$linkedin = isset( $instance['linkedin'] ) ? esc_attr( $instance['linkedin'] ) : '';
			$medium = isset( $instance['medium'] ) ? esc_attr( $instance['medium'] ) : '';
			$pinterest = isset( $instance['pinterest'] ) ? esc_attr( $instance['pinterest'] ) : '';
			$skype = isset( $instance['skype'] ) ? esc_attr( $instance['skype'] ) : '';
			$twitter = isset( $instance['twitter'] ) ? esc_attr( $instance['twitter'] ) : '';
			$youtube = isset( $instance['youtube'] ) ? esc_attr( $instance['youtube'] ) : '';
			$links = isset( $instance['links'] ) ? esc_attr( $instance['links'] ) : '';
			$size = isset( $instance['size'] ) ? esc_attr( $instance['size'] ) : '';
		
		?>
        <p>
		   <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('dribbble'); ?>"><?php esc_html_e('Dribbble:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('dribbble'); ?>"  value="<?php echo esc_html($dribbble); ?>" class="widefat" id="<?php echo $this->get_field_id('dribbble'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('email'); ?>"><?php esc_html_e('Email:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('email'); ?>"  value="<?php echo esc_html($email); ?>" class="widefat" id="<?php echo $this->get_field_id('email'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php esc_html_e('Facebook:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('facebook'); ?>"  value="<?php echo esc_html($facebook); ?>" class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('flickr'); ?>"><?php esc_html_e('Flickr:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('flickr'); ?>"  value="<?php echo esc_html($flickr); ?>" class="widefat" id="<?php echo $this->get_field_id('flickr'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('foursquare'); ?>"><?php esc_html_e('Foursquare:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('foursquare'); ?>"  value="<?php echo esc_html($foursquare); ?>" class="widefat" id="<?php echo $this->get_field_id('foursquare'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('github'); ?>"><?php esc_html_e('GitHub:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('github'); ?>"  value="<?php echo esc_html($github); ?>" class="widefat" id="<?php echo $this->get_field_id('github'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('googleplus'); ?>"><?php esc_html_e('Google+:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('googleplus'); ?>"  value="<?php echo esc_html($googleplus); ?>" class="widefat" id="<?php echo $this->get_field_id('googleplus'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('instagram'); ?>"><?php esc_html_e('Instagram:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('instagram'); ?>"  value="<?php echo esc_html($instagram); ?>" class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php esc_html_e('LinkedIn:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('linkedin'); ?>"  value="<?php echo esc_html($linkedin); ?>" class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" />
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('medium'); ?>"><?php esc_html_e('Medium:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('medium'); ?>"  value="<?php echo esc_html($medium); ?>" class="widefat" id="<?php echo $this->get_field_id('medium'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php esc_html_e('Pinterest:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('pinterest'); ?>"  value="<?php echo esc_html($pinterest); ?>" class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('skype'); ?>"><?php esc_html_e('Skype:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('skype'); ?>"  value="<?php echo esc_html($skype); ?>" class="widefat" id="<?php echo $this->get_field_id('skype'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php esc_html_e('Twitter:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('twitter'); ?>"  value="<?php echo esc_html($twitter); ?>" class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('youtube'); ?>"><?php esc_html_e('YouTube:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('youtube'); ?>"  value="<?php echo esc_html($youtube); ?>" class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('links'); ?>"><?php esc_html_e('Links:', 'contempo'); ?></label> 
			<select id="<?php echo $this->get_field_id('links'); ?>" name="<?php echo $this->get_field_name('links'); ?>">
				<option value="_self"<?php if($links == '_self') echo ' selected="selected"'; ?>>Same Window</option>
				<option value="_blank"<?php if($links == '_blank') echo ' selected="selected"'; ?>>New Window</option>
			</select>
		</p>
		<?php
	}
} 

add_action( 'widgets_init', create_function( '', 'register_widget("ct_Social");' ) );

?>