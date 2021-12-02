<?php
/**
 * Listings Contact Form
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

class ct_ListingsContact extends WP_Widget {

   function __construct() {
	   $widget_ops = array('description' => 'Display an agent contact form. Can only be used in the Listing Single sidebar as it relies on listing information for content.' );
	   parent::__construct(false, __('CT Listing Agent Contact', 'contempo'),$widget_ops);      
   }

   function widget($args, $instance) {  
	extract( $args );
	$title = $instance['title'];
	$subject = $instance['subject'];
	?>
		<?php echo $before_widget; ?>
		<?php if ($title) { echo $before_title . $title . $after_title; }
			global $ct_options;

		echo '<div class="widget-inner">'; ?>
        
            <form id="listingscontact" class="formular" method="post">
                <fieldset>
	                <select id="ctinquiry" name="ctinquiry">
						<option><?php esc_html_e('Tell me more about this property', 'contempo'); ?></option>
						<option><?php esc_html_e('Request a showing', 'contempo'); ?></option>
					</select>
						<div class="clear"></div>
                    <input type="text" name="name" id="name" class="validate[required] text-input" value="<?php esc_html_e('Name', 'contempo'); ?>" onfocus="if(this.value=='<?php esc_html_e('Name', 'contempo'); ?>')this.value = '';" onblur="if(this.value=='')this.value = '<?php esc_html_e('Name', 'contempo'); ?>';" />
                    
                    <input type="text" name="email" id="email" class="validate[required,custom[email]] text-input" value="<?php esc_html_e('Email', 'contempo'); ?>" onfocus="if(this.value=='<?php esc_html_e('Email', 'contempo'); ?>')this.value = '';" onblur="if(this.value=='')this.value = '<?php esc_html_e('Email', 'contempo'); ?>';" />
                    
                    <input type="text" name="ctphone" id="ctphone" class="text-input" value="<?php esc_html_e('Phone', 'contempo'); ?>" onfocus="if(this.value=='<?php esc_html_e('Phone', 'contempo'); ?>')this.value = '';" onblur="if(this.value=='')this.value = '<?php esc_html_e('Phone', 'contempo'); ?>';" />
                    
                    <textarea class="validate[required,length[2,500]] text-input" name="message" id="message" rows="5" cols="10"></textarea>
                    
                    <input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php the_author_meta('user_email'); ?>" />
                    <input type="hidden" id="ctproperty" name="ctproperty" value="<?php ct_listing_title(); ?>, <?php city(); ?>, <?php state(); ?> <?php zipcode(); ?>" />
                    <input type="hidden" id="ctpermalink" name="ctpermalink" value="<?php the_permalink(); ?>" />
                    <input type="hidden" id="ctsubject" name="ctsubject" value="<?php echo esc_html($subject); ?>" />
                    
                    <input type="submit" name="Submit" value="<?php esc_html_e('Submit', 'contempo'); ?>" id="submit" class="btn" />  
                </fieldset>
            </form>

        <?php echo '</div>'; ?>
		
		<?php echo $after_widget; ?>   
    <?php
   }

   function update($new_instance, $old_instance) {                
	   return $new_instance;
   }

   function form($instance) {
		
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$subject = isset( $instance['subject'] ) ? esc_attr( $instance['subject'] ) : '';
		
		?>
		<p>
		   <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('subject'); ?>"><?php esc_html_e('Subject:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('subject'); ?>"  value="<?php echo $subject; ?>" class="widefat" id="<?php echo $this->get_field_id('subject'); ?>" />
		</p>
		<?php
	}
} 

register_widget('ct_ListingsContact');
?>