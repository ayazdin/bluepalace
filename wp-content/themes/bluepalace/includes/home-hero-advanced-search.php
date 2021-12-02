<?php
/**
 * Header Advanced Search
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
global $ct_options;

?>

<!-- Header Search -->
<div id="hero-search-wrap">
	<div class="container">
        <form id="advanced_search" class="col span_12 first header-search" name="search-listings" action="<?php echo home_url(); ?>">
	        <div id="hero-search-inner">
	            <div class="col span_6">
	            	<div id="keyword-wrap">
			            <i class="fa fa-search"></i>
		                <input type="text" id="ct_keyword" class="number" name="ct_keyword" size="8" placeholder="<?php esc_html_e('Enter a street address or keyword', 'contempo'); ?>" />
	                </div>
	            </div>

	            <div class="col span_2">
					<?php ct_search_form_select('city'); ?>
				</div>

				 <div class="col span_2">
					<?php ct_search_form_select('state'); ?>
	            </div>

	            <input type="hidden" name="search-listings" value="true" />

	            <div class="col span_2">
		            <input id="submit" class="btn left" type="submit" value="<?php esc_html_e('Search', 'contempo'); ?>" />
	            </div>

		            <div class="clear"></div>
            </div>
        </form>
	        <div class="clear"></div>
    </div>
</div>
<!-- //Header Search -->