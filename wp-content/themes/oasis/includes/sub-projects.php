<?php
/**
 * Related sub listings dependant on tagged community for single-listings.php
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

global $ct_options;

$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';

wp_reset_postdata();

?>

<ul>
	<?php
	global $post;

	$terms = strip_tags( get_the_term_list( $wp_query->post->ID, 'community', '', ', ', '' ) );
	$args = array(
		'post_type' => 'projects',
		'post__not_in' => array($post->ID),
		'showposts'=> 3,
		'tax_query' => array(
			array(
				'taxonomy' => 'community',
				'field'    => 'slug',
				'terms'    => $terms,
			),
		)
	);
	$query = new WP_Query( $args );

	if( $query->have_posts() ) {

		$count = 0; while ($query->have_posts()) : $query->the_post(); ?>

			<div class="text-xs-left unit unit-xs-horizontal unit-sm-horizontal unit-md-vertical unit-lg-horizontal offset-top-40">
				<?php
				if(has_post_thumbnail()){?>
					<div class="unit-left">
						<a href="<?php the_permalink(); ?>" class="reveal-inline-block">
							<img src="<?php echo get_the_post_thumbnail_url($post->ID,'thumbnail')?>" width="139" height="139" alt="<?php the_title();?>" class="img-responsive center-block">
						</a>
					</div>
				<?php }
				?>


				<div class="unit-body">
					<h6><a href="<?php the_permalink(); ?>" class="text-base"><?php the_title();?></a></h6>
					<p class="text-primary text-sbold"><?php ct_listing_price(); ?></p>
					<!--<p class="offset-top-20">
						<?php /*echo get_the_content();*/?>
					</p>-->
					<div class="unit unit-horizontal unit-spacing-xs reveal-inline-flex text-left">
						<div class="unit-left"><span class="icon mdi mdi-map-marker text-primary"></span></div>
						<div class="unit-body">
							<div class="small">
								<?php
								$city = strip_tags( get_the_term_list( $query->post->ID, 'city', '', ', ', '' ) );
								$state = strip_tags( get_the_term_list( $query->post->ID, 'state', '', ', ', '' ) );
								$zipcode = strip_tags( get_the_term_list( $query->post->ID, 'zipcode', '', ', ', '' ) );
								$country = strip_tags( get_the_term_list( $query->post->ID, 'country', '', ', ', '' ) );
								if(!empty($count))
									echo $city.' , ';
								if(!empty($state))
									echo $state.' , ';
								if(!empty($zipcode))
									echo $zipcode.' , ';
								if(!empty($country))
									echo $country;
								?>

							</div>
						</div>
					</div><a href="<?php the_permalink(); ?>" class="offset-top-16 btn btn-primary">read more</a>
				</div>
			</div>
			<?php

			$count++;


		endwhile; wp_reset_postdata();
	} ?>
</ul>
<div class="clear"></div>