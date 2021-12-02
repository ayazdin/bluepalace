<?php 
class PPL {

	/**
	 * PayPal integration version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 *
	 * Unique identifier for your integration.
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $paypal_listings_slug = 'paypal-for-listings';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	private $settings = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		global $ct_options;
		
		$this->settings = (array) $ct_options;

		add_action( 'after_switch_theme', array( $this, 'rewrite_flush' ) );
		add_action('init', array ($this, 'create_pages') );
		
	}

	public static function create_pages(){
		//create checkout page           
            $args = array(
                'post_type' => 'page'
            );
            $pages = get_pages($args);
            $checkout_page_id = '';
            foreach ($pages as $page) {
                if(strpos($page->post_content,'ppl_checkout') !== false){     
                    $checkout_page_id = $page->ID;
                }
            }
            if ($checkout_page_id == '') {
                $checkout_page_id = PPL::create_post('page', 'Checkout', 'ppl-checkout', '[ppl_checkout]');
                $checkout_page = get_post($checkout_page_id);
                $checkout_page_url = $checkout_page->guid;
                $ct_options = get_option('ct_options');
                if(!empty($ct_options)){
                    $ct_options['checkout_url'] = $checkout_page_url;
                    update_option('ct_options', $ct_options);
                }
            }
	}
	public static function create_post($postType, $title, $name, $content, $parentId = NULL)
        {
            $post = array(
                'post_title' => $title,
                'post_name' => $name,
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_content' => $content,
                'post_status' => 'publish',
                'post_type' => $postType
            );

            if ($parentId !== NULL){
                    $post['post_parent'] = $parentId;
            }        
            $postId = wp_insert_post($post);
            return $postId;
        }
		
	public function get_setting($field) {
		if(isset($this->settings[$field]))
			return $this->settings[$field];
		return false;
	}
	public function ct_paypal() {
		
		global $ct_options;
		$ct_currency_code = isset( $ct_options['ct_currency_code'] ) ? esc_attr( $ct_options['ct_currency_code'] ) : 'USD';
		?>
		<input type="submit" class="btn" name="submit" value="Pay with PayPal" alt="PayPal - The safer, easier way to pay online">
		<div class="payment-drop">
			<form class="paypalbutton marB0 left" action="<?php echo get_template_directory_uri() . '/admin/gateways/PayPal/expresscheckout.php'; ?>" method="post">
				<div class="submission-fee">
					<input type="hidden" name="submission" value="$10" />
					<?php _e('Cost:', 'contempo'); ?>
					<span class="cost right">$10</span>
				</div>
				<div class="featured-fee">
					<input type="checkbox" name="featured" />
					<?php _e('Featured?', 'contempo'); ?>
					<span class="cost right">$5</span>
				</div>
				<div class="total">
					<input type="hidden" name="total" />
					<?php _e('Total:', 'contempo'); ?>
					<span class="cost right">$15</span>
				</div>
				<input type="hidden" name="business" value="<?php echo esc_attr($ct_options['ct_paypal_addy']); ?>" />
				<input type="hidden" name="cmd" value="_xclick" />
				<input type="hidden" name="item_name" value="<?php the_title(); ?>" />
				<input type="hidden" name="url" value="<?php the_permalink(); ?>" />
				<input type="hidden" name="Payment_Amount" value="<?php echo esc_attr($ct_options['ct_price']); ?>" />
				<input type="hidden" name="currency_code" value="<?php echo esc_attr($ct_currency_code); ?>" />
				<input type="hidden" name="lc" value="US" />
				<input type="submit" class="btn" name="submit" value="<?php esc_html_e('Pay with PayPal', 'contempo'); ?>" alt="PayPal - The safer, easier way to pay online" />
			</form>
		</div>
	<?php 
	}

	/**
	 * Return the slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    slug variable.
	 */
	public function get_paypal_listings_slug() {
		return $this->paypal_listings_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * @since    init
	 */
	public function rewrite_flush()
	{
		flush_rewrite_rules();
	}

}