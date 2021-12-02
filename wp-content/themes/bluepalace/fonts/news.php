<?php 
/*
*	template part news
*/
?>

<div class="news">
<div class="vid_wrap">
			<a href="#"><h5>Test news</h5></a>
			<p>Lorem ipsum dolor sit amet, modo eripuit rationibus id sed, duo an scaevola intellegam. Ludus dicant dolore at nam. Mel veri zril at, est choro deseruisse ne, recteque intellegebat at vix. Eu his porro sapientem...</p>
		</div>
	<?php 
	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	$args = array(
		'posts_per_page' => 6,
		'post_type' => 'post',
		'category_name' => 'news',
		'order' => 'desc',
		'paged' => $paged
		);
	query_posts($args);
	?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php 
		$videoLink = get_the_content();
		$imageForVideo = explode("=",$videoLink);
		?>

	<?php endwhile; ?>
	<?php ct_numeric_pagination(); ?>

	<div class="clear"></div>

<?php else : ?>

	<div class="col span_12 row no-listings">
		<h4 class="marB20"><?php esc_html_e('You don\'t have any news yet...', 'contempo'); ?></h4>
	</div>

<?php endif; wp_reset_postdata(); ?>
</div>