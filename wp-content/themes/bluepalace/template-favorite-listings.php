<?php
/**
 * Template Name: Favorite Listings
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

get_header();

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);

while ( have_posts() ) : the_post();

if($inside_page_title == "Yes") { 
	// Custom Page Header Background Image
	if(get_post_meta($post->ID, '_ct_page_header_bg_image', true) != '') {
		echo'<style type="text/css">';
		echo '#single-header { background: url(';
		echo get_post_meta($post->ID, '_ct_page_header_bg_image', true);
		echo ') no-repeat center center; background-size: cover;}';
		echo '</style>';
	} ?>

	<!-- Single Header -->
	<div id="single-header">
		<div class="dark-overlay">
			<div class="container">
				<h1 class="marT0 marB0"><?php the_title(); ?></h1>
				<?php if(get_post_meta($post->ID, '_ct_page_sub_title', true) != '') { ?>
					<h2 class="marT0 marB0"><?php echo get_post_meta($post->ID, "_ct_page_sub_title", true); ?></h2>
				<?php } ?>
			</div>
		</div>
	</div>
	<!-- //Single Header -->
<?php } ?>

	<!-- Container -->
	<div class="container marT60 padB60">

		<!-- Page Content -->
		<div class="content col span_12 first">
			<?php the_content(); ?>
                
            <?php endwhile; wp_reset_query(); ?>

            <?php
                  global $favorite_post_ids;
            if ( !empty($user) ) {
                if ( wpfp_is_user_favlist_public($user) )
                    $favorite_post_ids = wpfp_get_users_favorites($user);

            } else {
                $favorite_post_ids = wpfp_get_users_favorites();
            }
            $wpfp_before = "";
            echo "<div class='wpfp-span'>";
            if (!empty($user)) {
                if (wpfp_is_user_favlist_public($user)) {
                    $wpfp_before = "$user's Favorite Posts.";
                } else {
                    $wpfp_before = "$user's list is not public.";
                }
            }

            if ($wpfp_before):
                echo '<div class="wpfp-page-before">'.$wpfp_before.'</div>';
            endif;

            echo '<!-- Saved Listings -->';
            echo '<ul class="saved-listings">';
            if ($favorite_post_ids) {
                $favorite_post_ids = array_reverse($favorite_post_ids);
                $post_per_page = wpfp_get_option("post_per_page");
                $page = intval(get_query_var('paged'));

                $qry = array('post__in' => $favorite_post_ids, 'posts_per_page'=> $post_per_page, 'orderby' => 'post__in', 'paged' => $page);
                // custom post type support can easily be added with a line of code like below.
                $qry['post_type'] = 'listings';
                query_posts($qry);

                while ( have_posts() ) : the_post(); ?>

                <li class="fav-listing listing col span_12 first">

                            <figure class="col span_4 first">
                                <?php ct_status(); ?>
                                <?php ct_first_image_linked(); ?>
                            </figure>
                            <div class="col span_8 listing-info muted">
                                <h3 class="marT0 marB0"><?php ct_listing_title(); ?></h3>
                                <div class="location muted marB10"><?php city(); ?>, <?php state(); ?> <?php zipcode(); ?></div>
                                <p class="price marB10"><?php ct_listing_price(); ?></p>
                                <p class="excerpt marB0">
                                    <?php echo ct_excerpt(20); ?>
                                </p>
                            </div>
                            <div class="col span_12 first listing-tools">
                                <div class="col span_12 first">
                                    <ul class="edit-view-delete marT0 marB0 right">
                                        <li><a class="btn view-listing" href="<?php the_permalink(); ?>"><i class="fa fa-eye"></i></a></li>
                                        <li><?php wpfp_remove_favorite_link(get_the_ID()); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </li>

                            <div class="clear"></div>

                        <?php endwhile;

                echo '<div class="navigation">';
                    if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
                    <div class="alignleft"><?php next_posts_link( __( 'Previous Entries', 'contempo' ) ) ?></div>
                    <div class="alignright"><?php previous_posts_link( __( 'Next Entries', 'contempo' ) ) ?></div>
                    <?php }
                echo '</div>';

                wp_reset_query();
            } else {
                $wpfp_options = wpfp_get_options();
                echo '<li class="favorite-empty">';
                    echo '<h4>' . $wpfp_options['favorites_empty'] . '</h4>';
                echo '</li>';
            }
            echo "</ul>";
            echo '<!-- //Saved Listings -->';

            if ($favorite_post_ids) {
                echo '<p class="clear-saved">';
                        wpfp_clear_list_link();
                echo '</p>';
                echo "</div>";
            }
            wpfp_cookie_warning(); ?>
                
                    <div class="clear"></div>
		</div>
		<!-- //Page Content -->
	</div>
	<!-- //Container -->

<?php get_footer(); ?>