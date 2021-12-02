<?php 
/*
*	template part news
*/
$count = 0;
$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';
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
<ul>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
	$tempPosition = ($i%3==0)?'first':'';
	?>
	
	<li class="listing col span_4 standard <?php if($count % 3 == 0) { echo 'first'; } ?> <?php echo $ct_search_results_listing_style; ?>">

		<figure>

			<?php 
			if ( has_post_thumbnail() ) {
				the_post_thumbnail();
			}
			else {
				echo '<img class="author-img" src="' . get_template_directory_uri() . '/images/user-default.png' . '" />';
			}
			?>
			
		</figure>
		<div class="grid-listing-info">
			<header>
				<h5 class="marB0"><a href="http://localhost/realstate/listings/3-bed-south-ridge-downtown/"><?php echo the_title();?></a></h5>
			</header>
			<div class="propinfo">
				<p><?php
					$content = strip_tags(get_the_content());
					echo mb_substr($content, 0, 180, 'utf-8');
					?></p>
					<ul class="shareBtns">
						<li><a href="https://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,
							'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-facebook"></i></a></li>
						<li><a href="https://twitter.com/share?url=<?php the_permalink(); ?>&related=twitterapi%2Ctwitter" class="hi-icon hi-icon-chat" onclick="javascript:window.open(this.href,
							'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-twitter"></i></a></li>
						<li><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,
							'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="hi-icon hi-icon-chat"><i class="fa fa-google-plus"></i></a></li>
						</ul>
					</div>
				</div>
			</li>
			

			<?php $count++;

			if($count % 3 == 0) {
				echo '<div class="clear"></div>';
			}
			endwhile; ?>
			<?php ct_numeric_pagination(); ?>
		</ul>


	<?php else : ?>

		<div class="col span_12 row no-listings">
			<h4 class="marB20"><?php esc_html_e('You don\'t have any news yet...', 'contempo'); ?></h4>
		</div>

	<?php endif; wp_reset_postdata(); ?>
	<div class="clear"></div>
	<style type="text/css">
		.shareBtns li{ display: inline-block; margin:5px; }
		.news_wrap{ min-height: 220px; }
	</style>