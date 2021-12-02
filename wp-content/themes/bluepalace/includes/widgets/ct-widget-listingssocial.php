<?php
/**
 * Adspace
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

class ct_ListingsSocial extends WP_Widget {

	function __construct() {
		$widget_ops = array('description' => 'Social sharing links, only to be used in the Listing Single sidebar.' );
		parent::__construct(false, __('CT Listings Social', 'contempo'),$widget_ops);      
	}

	function widget($args, $instance) { 
		extract( $args ); 
		$title = $instance['title'];

        echo $before_widget;

		if($title != '')
			echo $before_title .$title. $after_title;
		?>

		<div class="widget-inner">

			<ul class="social marB0">
		        <li class="twitter"><a href="javascript:void(0);" onclick="popup('http://twitter.com/home/?status=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?> &mdash; <?php the_permalink(); ?>', 'twitter',500,260);"><i class="fa fa-twitter"></i></a></li>
		        <li class="facebook"><a href="javascript:void(0);" onclick="popup('http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>', 'facebook',658,225);"><i class="fa fa-facebook"></i></a></li>
		        <li class="linkedin"><a href="javascript:void(0);" onclick="popup('http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>&title=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>&summary=&source=<?php bloginfo('name'); ?>', 'linkedin',560,400);"><i class="fa fa-linkedin"></i></a></li>
		        <li class="google"><a href="javascript:void(0);" onclick="popup('https://plusone.google.com/_/+1/confirm?hl=en&url=<?php the_permalink(); ?>', 'google',500,275);"><i class="fa fa-google-plus"></i></a></a></li>
		    </ul>

		</div>

		<?php echo $after_widget;

	}

	function update($new_instance, $old_instance) {                
		return $new_instance;
	}

	function form($instance) {  
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title (optional):','contempo'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>
        <?php
	}
} 

register_widget('ct_ListingsSocial');
?>