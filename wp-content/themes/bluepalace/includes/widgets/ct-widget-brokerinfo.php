<?php
/**
 * Broker Info
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */
 
class ct_BrokerInfo extends WP_Widget {

   function __construct() {
	   $widget_ops = array('description' => 'Use this widget to display your brokers information.' );
	   parent::__construct(false, __('CT Brokers Info', 'contempo'),$widget_ops);      
   }

   function widget($args, $instance) {  
	extract( $args );

	$title = $instance['title'];
	$logo = $instance['logo'];
	$company = $instance['company'];
	$office_phone = $instance['office_phone'];
	$office_email = $instance['office_email'];
	$website = $instance['website'];
	
	?>
		<?php
        
		echo $before_widget;
		
		if ($title) {
			echo $before_title . $title . $after_title;
		}

		echo '<div class="widget-inner">';
        
			if($logo) {
				echo '<figure class="col span_3">';
				if(!empty($website)) {
					echo '<a href="' . $website . '" target="_blank">';
					echo '<img class="left marR10" src="' . $logo . '" />';
					echo '</a>';
				} else {
					 echo '<img class="left marR10" src="' . $logo . '" />';
				}
				echo '</figure>';
			} ?>
	        
	        <div class="details col span_8">
				<?php if($company != "") {
					echo '<h5 class="author marB5">' . esc_html($company) . '</h5>';
	            } ?>
				<?php if($office_phone != "") { ?><p class="marB0"><?php echo esc_html($office_phone); ?></p><?php } ?>
	            <?php if($office_email != "") { ?><p class="marT3 marB0"><a href="mailto:<?php echo esc_html($office_email); ?>"><?php esc_html_e('Email Office', 'contempo'); ?></a></p><?php } ?>
	            <?php if($website != "") { ?><p class="marT3 marB0"><a href="<?php echo esc_url($website); ?>" target="_blank"><?php esc_html_e('Visit Brokers Website', 'contempo'); ?></a></p><?php } ?>
	        </div>
	        
        </div>
		<?php echo $after_widget; ?>   
    <?php
   }

   function update($new_instance, $old_instance) {                
	   return $new_instance;
   }

   function form($instance) { 

		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$logo = isset( $instance['logo'] ) ? esc_attr( $instance['logo'] ) : '';
		$company = isset( $instance['company'] ) ? esc_attr( $instance['company'] ) : '';
		$office_phone = isset( $instance['office_phone'] ) ? esc_attr( $instance['office_phone'] ) : '';
		$office_email = isset( $instance['office_email'] ) ? esc_attr( $instance['office_email'] ) : '';
		$website = isset( $instance['website'] ) ? esc_attr( $instance['website'] ) : '';
		
		?>
        <p>
		   <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('logo'); ?>"><?php esc_html_e('Logo URL:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('logo'); ?>"  value="<?php echo $logo; ?>" class="widefat" id="<?php echo $this->get_field_id('logo'); ?>" />
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('company'); ?>"><?php esc_html_e('Company:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('company'); ?>"  value="<?php echo $company; ?>" class="widefat" id="<?php echo $this->get_field_id('company'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('office_phone'); ?>"><?php esc_html_e('Office Phone:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('office_phone'); ?>"  value="<?php echo $office_phone; ?>" class="widefat" id="<?php echo $this->get_field_id('office_phone'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('office_email'); ?>"><?php esc_html_e('Office Email:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('office_email'); ?>"  value="<?php echo $office_email; ?>" class="widefat" id="<?php echo $this->get_field_id('office_email'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('website'); ?>"><?php esc_html_e('Website:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('website'); ?>"  value="<?php echo $website; ?>" class="widefat" id="<?php echo $this->get_field_id('website'); ?>" />
		</p>
	<?php }
} 

register_widget('ct_BrokerInfo');
?>