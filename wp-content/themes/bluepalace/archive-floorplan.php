<?php
/**
 * Template Name: FloorPlan
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

get_header();

//do_action('before_single_listing_header');

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
?>
<div class="breadcrumb breadcrumbs ct-breadcrumbs right muted">
<div class="breadcrumb-trail">
<span class="trail-before"><span class="breadcrumb-title"></span></span> 
<a id="bread-home" href="<?php echo get_site_url()?>" title="New Routes" rel="home" class="trail-begin">Home</a>  
<span class="sep"><i class="fa fa-angle-right"></i></span> <span class="trail-end">Floor Plan</span>
</div>
</div>
<?php
echo '<div class="clear"></div>';
echo '</div>';
echo '</header>';

do_action('before_single_listing_content'); ?>
<?php
echo '<div class="container">';    ?>

<article class="col <?php if($ct_listing_single_content_layout == 'full-width') { echo 'span_12'; } else { echo 'span_12'; } ?> marB60">

	<?php do_action('before_single_listing_location'); ?>

	<?php get_template_part('floor-plan');?>

</article>

<?php do_action('before_single_listing_sidebar'); ?>


<?php do_action('after_single_listing_sidebar'); ?>

</div>

<?php get_footer(); ?>