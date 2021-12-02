<?php
/**
 * Sidebar Template
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

?>

<?php do_action('before_sidebar'); ?>

<!-- Sidebar -->
<div id="sidebar" class="col span_3">
	<div id="sidebar-inner">
		<?php if (is_page()) {
            if (is_active_sidebar('right-sidebar-pages')) {
                dynamic_sidebar('Right Sidebar Pages');
            }
		} elseif(is_single()) {
            if (is_active_sidebar('right-sidebar-single')) {
                dynamic_sidebar('Right Sidebar Single');
            }
        } elseif(is_home() || is_archive() || is_search()) {
            if (is_active_sidebar('right-sidebar-blog')) {
                dynamic_sidebar('Right Sidebar Blog');
            }
		} ?>
		<div class="clear"></div>
	</div>
</div>
<!-- //Sidebar -->

<?php do_action('after_sidebar'); ?>