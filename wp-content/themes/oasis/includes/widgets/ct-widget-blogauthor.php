<?php
/**
 * Blog Author Info
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */
 
class ct_BlogAuthorInfo extends WP_Widget {

   function __construct() {
	   $widget_ops = array('description' => 'This is a Blog Author Info widget.' );
	   parent::__construct(false, __('CT Blog Author Info', 'contempo'),$widget_ops);      
   }

   function widget($args, $instance) {  
	extract( $args );
	$title = $instance['title'];
	$bio = $instance['bio'];
	$custom_email = $instance['custom_email'];
	$avatar_size = $instance['avatar_size']; if ( !$avatar_size ) $avatar_size = 48;
	$avatar_align = $instance['avatar_align']; if ( !$avatar_align ) $avatar_align = 'left';
	$read_more_text = $instance['read_more_text'];
	$read_more_url = $instance['read_more_url'];
	$page = $instance['page'];
	if ( ( $page == "home" && is_home() ) || ( $page == "single" && is_single() ) || $page == "all" ) {
	?>
		<?php echo $before_widget; ?>
		<?php if ($title) { echo $before_title . $title . $after_title; }

		echo '<div class="widget-inner">'; ?>
		
			<span class="<?php echo esc_html($avatar_align); ?>"><?php if ( $custom_email ) echo get_avatar( $custom_email, $size = $avatar_size ); ?></span>
			<p><?php echo esc_html($bio); ?></p>
			<?php if ( $read_more_url ) echo '<p class="right"><a class="read-more" href="' . esc_url($read_more_url) . '">' . esc_html($read_more_text) . '<em>&rarr;</em></a></p>'; ?>

			<?php echo '</div>'; ?>
		<?php echo $after_widget; ?>   
    <?php
	}
   }

   function update($new_instance, $old_instance) {                
	   return $new_instance;
   }

   function form($instance) {
	   
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$bio = isset( $instance['bio'] ) ? esc_attr( $instance['bio'] ) : '';
		$custom_email = isset( $instance['custom_email'] ) ? esc_attr( $instance['custom_email'] ) : '';
		$avatar_size = isset( $instance['avatar_size'] ) ? esc_attr( $instance['avatar_size'] ) : '';
		$avatar_align = isset( $instance['avatar_align'] ) ? esc_attr( $instance['avatar_align'] ) : '';
		$read_more_text = isset( $instance['read_more_text'] ) ? esc_attr( $instance['read_more_text'] ) : '';
		$read_more_url = isset( $instance['read_more_url'] ) ? esc_attr( $instance['read_more_url'] ) : '';
		$page = isset( $instance['page'] ) ? esc_attr( $instance['page'] ) : '';

		?>
		<p>
		   <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('bio'); ?>"><?php esc_html_e('Bio:','contempo'); ?></label>
			<textarea name="<?php echo $this->get_field_name('bio'); ?>" class="widefat" id="<?php echo $this->get_field_id('bio'); ?>"><?php echo $bio; ?></textarea>
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('custom_email'); ?>"><?php esc_html_e('<a href="http://www.gravatar.com/">Gravatar</a> E-mail:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('custom_email'); ?>"  value="<?php echo $custom_email; ?>" class="widefat" id="<?php echo $this->get_field_id('custom_email'); ?>" />
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('avatar_size'); ?>"><?php esc_html_e('Gravatar Size:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('avatar_size'); ?>"  value="<?php echo $avatar_size; ?>" class="widefat" id="<?php echo $this->get_field_id('avatar_size'); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('avatar_align'); ?>"><?php esc_html_e('Gravatar Alignment:','contempo'); ?></label>
			<select name="<?php echo $this->get_field_name('avatar_align'); ?>" class="widefat" id="<?php echo $this->get_field_id('avatar_align'); ?>">
				<option value="left" <?php if($avatar_align == "left"){ echo "selected='selected'";} ?>><?php esc_html_e('Left', 'contempo'); ?></option>
				<option value="right" <?php if($avatar_align == "right"){ echo "selected='selected'";} ?>><?php esc_html_e('Right', 'contempo'); ?></option>            
			</select>
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('read_more_text'); ?>"><?php esc_html_e('Read More Text (optional):','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('read_more_text'); ?>"  value="<?php echo $read_more_text; ?>" class="widefat" id="<?php echo $this->get_field_id('read_more_text'); ?>" />
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('read_more_url'); ?>"><?php esc_html_e('Read More URL (optional):','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('read_more_url'); ?>"  value="<?php echo $read_more_url; ?>" class="widefat" id="<?php echo $this->get_field_id('read_more_url'); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('page'); ?>"><?php esc_html_e('Visible Pages:','contempo'); ?></label>
			<select name="<?php echo $this->get_field_name('page'); ?>" class="widefat" id="<?php echo $this->get_field_id('page'); ?>">
				<option value="all" <?php if($page == "all"){ echo "selected='selected'";} ?>><?php esc_html_e('All', 'contempo'); ?></option>
				<option value="home" <?php if($page == "home"){ echo "selected='selected'";} ?>><?php esc_html_e('Home only', 'contempo'); ?></option>            
				<option value="single" <?php if($page == "single"){ echo "selected='selected'";} ?>><?php esc_html_e('Single only', 'contempo'); ?></option>            
			</select>
		</p>
		<?php
	}
} 

register_widget('ct_BlogAuthorInfo');
?>