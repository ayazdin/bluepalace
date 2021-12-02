<?php
/**
 * Template Name: Floor Plan
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

get_header();

do_action('before_single_listing_header');

// Header
echo '<header id="title-header"';
if($ct_listing_single_layout == 'listings-two') { echo 'class="marB0"'; }
echo '>';
echo '<div class="container">';
echo '<div class="left">';
echo '<h5 class="marT0 marB0">';
esc_html_e('Floor Plan', 'contempo');
echo '</h5>';
echo '</div>';
echo ct_breadcrumbs();
echo '<div class="clear"></div>';
echo '</div>';
echo '</header>';

do_action('before_single_listing_content'); ?>
<?php
//echo "Template Name: FloorPlan";
echo '<div class="container">';    ?>

<article class="col <?php if($ct_listing_single_content_layout == 'full-width') { echo 'span_12'; } else { echo 'span_12'; } ?> marB60">

	<?php //do_action('before_single_listing_location'); ?>

	<?php get_template_part('floor-plan');?>

</article>

<?php //do_action('before_single_listing_sidebar'); ?>


<?php //do_action('after_single_listing_sidebar'); ?>

</div>

<?php get_footer(); ?>