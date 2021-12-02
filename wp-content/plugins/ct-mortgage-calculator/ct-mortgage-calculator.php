<?php
/*
Plugin Name: Contempo Mortgage Calculator Widget
Plugin URI: http://contemporealestatethemes.com
Description: A simple mortgage calculator widget
Version: 1.1.1
Author: Chris Robinson
Author URI: http://contemporealestatethemes.com
*/

/*-----------------------------------------------------------------------------------*/
/* Add meta links in Plugins table */
/*-----------------------------------------------------------------------------------*/
 
add_filter( 'plugin_row_meta', 'ct_mort_plugin_meta_links', 10, 2 );
function ct_mort_plugin_meta_links( $links, $file ) {

	$plugin = plugin_basename(__FILE__);
	
	// Create Link
	if ( $file == $plugin ) {
		return array_merge(
			$links,
			array( '<a href="http://twitter.com/contempoinc">Follow on Twitter</a>' )
		);
	}
	return $links;
}

/*-----------------------------------------------------------------------------------*/
/* Include CSS */
/*-----------------------------------------------------------------------------------*/
 
function ct_mortgage_calc_css() {		
	wp_enqueue_style( 'ct_mortgage_calc', plugins_url( 'assets/style.css', __FILE__ ), false, '1.0' );
}
add_action( 'wp_print_styles', 'ct_mortgage_calc_css' );

/*-----------------------------------------------------------------------------------*/
/* Include JS */
/*-----------------------------------------------------------------------------------*/

function ct_mortgage_calc_scripts() {
	wp_enqueue_script( 'calc', plugins_url( 'assets/calc.js', __FILE__ ), array('jquery'), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'ct_mortgage_calc_scripts' );

/*-----------------------------------------------------------------------------------*/
/* Register Widget */
/*-----------------------------------------------------------------------------------*/

class ct_MortgageCalculator extends WP_Widget {

	function __construct() {
	   $widget_ops = array('description' => 'Display a mortgage calculator.' );
	   parent::__construct(false, __('CT Mortgage Calculator', 'contempo'),$widget_ops);      
	}

	function widget($args, $instance) {  
		
		extract( $args );
		
		$title = $instance['title'];
		$currency = $instance['currency'];
		
	?>
		<?php echo $before_widget; ?>
		<?php if ($title) { echo $before_title . $title . $after_title; }
			global $ct_options; ?>

			<?php echo '<div class="widget-inner">'; ?>
        
	            <form id="loanCalc">
	                <fieldset>
	                  <input type="text" name="mcPrice" id="mcPrice" class="text-input" placeholder="<?php _e('Sale price (no separators)', 'contempo'); ?> (<?php echo $currency; ?>)" />
	                  <input type="text" name="mcRate" id="mcRate" class="text-input" placeholder="<?php _e('Interest Rate (%)', 'contempo'); ?>"/>
	                  <input type="text" name="mcTerm" id="mcTerm" class="text-input" placeholder="<?php _e('Term (years)', 'contempo'); ?>" />
	                  <input type="text" name="mcDown" id="mcDown" class="text-input" placeholder="<?php _e('Down payment (no separators)', 'contempo'); ?> (<?php echo $currency; ?>)" />
	                  
	                  <input class="btn marB10" type="submit" id="mortgageCalc" value="<?php _e('Calculate', 'contempo'); ?>" onclick="return false">
	                  <p class="muted monthly-payment"><?php _e('Monthly Payment:', 'contempo'); ?> <strong><?php echo $currency; ?><span id="mcPayment"></span></strong></p>
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
			$currency = isset( $instance['currency'] ) ? esc_attr( $instance['currency'] ) : '';

		?>
		<p>
		   <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
		   <label for="<?php echo $this->get_field_id('currency'); ?>"><?php _e('Currency:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('currency'); ?>"  value="<?php echo $currency; ?>" class="widefat" id="<?php echo $this->get_field_id('currency'); ?>" />
		</p>
		<?php
	}
} 

add_action( 'widgets_init', create_function( '', 'register_widget("ct_MortgageCalculator");' ) );

/*-----------------------------------------------------------------------------------*/
/* Register Shortcode */
/*-----------------------------------------------------------------------------------*/

function ct_mortgage_calc_shortcode($atts) { ?>
        <div class="clear"></div>
	<form id="loanCalc">
		<fieldset>
		  <input type="text" name="mcPrice" id="mcPrice" class="text-input" value="<?php _e('Sale price ($)', 'contempo'); ?>" onfocus="if(this.value=='<?php _e('Sale price ($)', 'contempo'); ?>')this.value = '';" onblur="if(this.value=='')this.value = '<?php _e('Sale price ($)', 'contempo'); ?>';" />
		  <input type="text" name="mcRate" id="mcRate" class="text-input" value="<?php _e('Interest Rate (%)', 'contempo'); ?>" onfocus="if(this.value=='<?php _e('Interest Rate (%)', 'contempo'); ?>')this.value = '';" onblur="if(this.value=='')this.value = '<?php _e('Interest Rate (%)', 'contempo'); ?>';" />
		  <input type="text" name="mcTerm" id="mcTerm" class="text-input" value="<?php _e('Term (years)', 'contempo'); ?>" onfocus="if(this.value=='<?php _e('Term (years)', 'contempo'); ?>')this.value = '';" onblur="if(this.value=='')this.value = '<?php _e('Term (years)', 'contempo'); ?>';" />
		  <input type="text" name="mcDown" id="mcDown" class="text-input" value="<?php _e('Down payment ($)', 'contempo'); ?>" onfocus="if(this.value=='<?php _e('Down payment ($)', 'contempo'); ?>')this.value = '';" onblur="if(this.value=='')this.value = '<?php _e('Down payment ($)', 'contempo'); ?>';" />
		  
		  <input class="btn marB10" type="submit" id="mortgageCalc" value="<?php _e('Calculate', 'contempo'); ?>" onclick="return false">
		  <input class="btn reset" type="button" value="Reset" onClick="this.form.reset()" />
		  <input type="text" name="mcPayment" id="mcPayment" class="text-input" value="<?php _e('Your Monthly Payment', 'contempo'); ?>" />
		</fieldset>
	</form>
        <div class="clear"></div>
<?php }
add_shortcode('mortgage_calc', 'ct_mortgage_calc_shortcode');

?>