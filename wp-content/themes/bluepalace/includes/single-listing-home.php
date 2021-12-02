<?php
/**
 * Single Listing Home
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
global $ct_options;
$ct_listing_agent_info = isset( $ct_options['ct_listing_agent_info'] ) ? esc_html( $ct_options['ct_listing_agent_info'] ) : '';

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
	$lang =  ICL_LANGUAGE_CODE;
}

?>

<?php 

	if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
        $args = array(
            'ct_status' => ct_get_taxo_translated(),
            'post_type' => 'listings',
            'posts_per_page' => 1
        );
    } else {
    	$args = array(
            'ct_status' => __('featured', 'contempo'),
            'post_type' => 'listings',
            'posts_per_page' => 1
        );
    }
    query_posts($args);
    
    if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <!-- Single Listing Home -->
    <section class="single-listing-home">

	    <!-- FPO Site name -->
	    <h4 id="sitename-for-print-only">
	        <?php bloginfo('name'); ?>
	    </h4>

	    <!-- Slider or Featured Image -->
		<figure>
			<?php
	        $attachments = get_children(
	            array(
	                'post_type' => 'attachment',
	                'post_mime_type' => 'image',
	                'post_parent' => $post->ID
	            ));
	        if(count($attachments) > 1) { ?>
	            <div id="slider" class="flexslider">
	                <?php ct_status(); ?>
	                <ul class="slides">
	                    <?php ct_sh_slider_images(); ?>
	                </ul>
	            </div>
	        <?php } else {
	            ct_first_image_lrg();
	        } ?>
	    </figure>
	    <!-- //Slider or Featured Image -->

        <!-- Container -->
        <div class="container main-listing">

        	<!-- Listing Address-->
	        <header class="listing-location">
		        <div class="snipe-wrap">
                    <?php if ( 2 == count( get_coauthors( get_the_id() ) ) ) { ?>
                    <h6 class="snipe co-listing"><span><?php esc_html_e('Co-listing', 'contempo'); ?></span></h6>
                    <?php } ?>
    		        <?php ct_status(); ?>
                        <div class="clear"></div>
                </div>
	            <h2 class="marT0 marB0"><?php ct_listing_title(); ?></h2>
	            <p class="location marB0"><?php city(); ?>, <?php state(); ?> <?php zipcode(); ?></p>
	        </header>
	        <!-- //Listing Address-->

	        <!-- Listing Content -->
	        <div class="listing-content single-listings">
	        
		        <!-- Listing Price-->
		        <h4 class="price marT0"><?php ct_listing_price(); ?></h4>
		        <!-- //Listing Price-->

		        <div id="carousel" class="flexslider">
                    <ul class="slides">
                        <?php ct_slider_carousel_images(); ?>
                    </ul>
                </div>
		        
		        <!-- Listing Info -->
	            <ul class="propinfo marB0">
					<?php ct_propinfo(); ?>
	            </ul> 
	            <!-- //Listing Info -->  

	            <!-- Listing Description -->
	            <div class="listing-description">
		            <?php the_content(); ?>
	            </div>
	            <!-- //Listing Description -->

	            <?php 
	            global $ct_options;
				$ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
				
                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                if($ct_rentals_booking == 'yes' || is_plugin_active('booking/wpdev-booking.php')) {

                    $checkin = get_post_meta($post->ID, "_ct_rental_checkin", true);
                    $checkout = get_post_meta($post->ID, "_ct_rental_checkout", true);
                    $extra_people = get_post_meta($post->ID, "_ct_rental_extra_people", true);
                    $cleaning = get_post_meta($post->ID, "_ct_rental_cleaning", true);
                    $cancellation = get_post_meta($post->ID, "_ct_rental_cancellation", true);
                    $deposit = get_post_meta($post->ID, "_ct_rental_deposit", true);

                    if( !empty($checkin) || !empty($checkout) || !empty($extra_people) || !empty($cleaning) || !empty($cancellation) || !empty($deposit) ) {

	                	echo '<!-- Listing Details -->';
			            echo '<div class="listing-details">';

		                    echo '<!-- Info -->';
		                    echo '<ul class="propinfo marB0 pad0">';
		                    		ct_rental_info();
		                    echo '</ul>';
		                    echo '<!-- //Info -->';

		                    if( !empty($extra_people) || !empty($cleaning) || !empty($cancellation) || !empty($deposit) ) {
			                    echo '<!-- Costs & Fees -->';
			                    echo '<h5 class="marT20">' . __('Prices', 'contempo') . '</h5>';
			                    echo '<ul class="propinfo marB0 pad0">';
			                    		ct_rental_costs();
			                    echo '</ul>';
			                    echo '<!-- //Costs & Fees -->';
		                    }

		                echo '</div>';
		                echo '<!-- Listing Details -->';
		            }

                } ?>      

	            <!-- Booking Calendar -->
	            <?php 
	            global $post;
                    $book_cal_shortcode = get_post_meta($post->ID, "_ct_booking_cal_shortcode", true);
                    if(!empty($book_cal_shortcode)) {
			            echo '<div class="booking-calendar">';
	                        echo '<div class="booking-form-calendar">';
	                            echo '<h4 class="border-bottom marB18">' . __('Book this listing', 'contempo') . '</h4>';
	                            echo do_shortcode($book_cal_shortcode);
	                            echo '<div class="clear"></div>';
	                        echo '</div>';
                        echo '</div>';
                    }
                ?>
                <!-- //Booking Calendar -->

                <!-- Features & Video -->
                <div class="listing-features-video">

	                <!-- Features List -->
		            <div class="col span_6 first">
			            <?php addfeatlist(); ?>
		            </div>
		            <!-- //Features List -->
			            
		            <!-- Video -->
		            <div class="col span_6">
		                <?php
		                $ct_video_url = get_post_meta($post->ID, "_ct_video", true);
		                $ct_embed_code = wp_oembed_get( $ct_video_url, $args );
		                if($ct_video_url) { ?>
		                <div class="videoplayer">
		                    <?php echo $ct_embed_code; ?>
		                </div>       
		                <?php } ?>
	                </div>
	                <!-- //Video -->
		                <div class="clear"></div>
                </div>
                <!-- //Features & Video -->
   
	            <!-- Listing Map-->
	            <?php if($ct_options['ct_disable_google_maps_listing'] == 'no') { ?>
	            <div id="location">
	                <?php ct_listing_map(); ?>
	            </div>  
	            <?php } ?>
	            <!-- //Listing Map-->

	            <!-- Nearby -->
                <?php

                	$ct_enable_yelp_nearby = isset( $ct_options['ct_enable_yelp_nearby'] ) ? esc_html( $ct_options['ct_enable_yelp_nearby'] ) : '';

                    if($ct_enable_yelp_nearby == 'yes') {

                        $ct_yelp_amenities = isset( $ct_options['ct_yelp_amenities']['enabled'] ) ? $ct_options['ct_yelp_amenities']['enabled'] : '';

                        echo '<div class="listing-nearby" id="listing-nearby">';
                            echo '<div class="right yelp-powered-by"><small class="muted left">' . __('powered by ', 'contempo') . '</small><img class="right yelp-logo" src="' . ct_theme_directory_uri() . '/images/yelp-logo-medium@2x.png" width="44" height="24" /></div>';
                            echo '<h4 class="border-bottom marB20">' . __('What\'s Nearby?', 'contempo') . '</h4>';
                            
                            $ct_listing_street_address = get_the_title();
                            $ct_listing_city = strip_tags( get_the_term_list( $wp_query->post->ID, 'city', '', ', ', '' ) );
                            $ct_listing_state = strip_tags( get_the_term_list( $wp_query->post->ID, 'state', '', ', ', '' ) );
                            $ct_listing_zip = strip_tags( get_the_term_list( $wp_query->post->ID, 'zipcode', '', ', ', '' ) );

                            $ct_listing_address = $ct_listing_street_address . ', ' . $ct_listing_city . ', ' . $ct_listing_state . ', ' . $ct_listing_zip;

                            if ($ct_yelp_amenities) :
    
                            foreach ($ct_yelp_amenities as $field=>$value) {
                            
                                switch($field) {
                                    
                                    // Restaurant            
                                    case 'restaurant' :

                                        ct_query_yelp_api('restaurant', $ct_listing_address, 'fa-cutlery');
                                        
                                    break;

                                    // Coffee Shops            
                                    case 'coffee_shops' :

                                        ct_query_yelp_api('coffee shop', $ct_listing_address, 'fa-coffee');
                                        
                                    break;

                                    // Coffee Shops            
                                    case 'grocery' :

                                        ct_query_yelp_api('grocery', $ct_listing_address, 'fa-shopping-basket');
                                        
                                    break;

                                    // Schools           
                                    case 'schools' :

                                        ct_query_yelp_api('schools', $ct_listing_address, 'fa-mortar-board');
                                        
                                    break;

                                    // Banks           
                                    case 'banks' :

                                        ct_query_yelp_api('banks', $ct_listing_address, 'fa-bank');
                                        
                                    break;

                                    // Bars           
                                    case 'bars' :

                                        ct_query_yelp_api('bars', $ct_listing_address, 'fa-beer');
                                        
                                    break;

                                    // Bars           
                                    case 'hospitals' :

                                        ct_query_yelp_api('hospitals', $ct_listing_address, 'fa-hospital-o');
                                        
                                    break;

                                    // Bars           
                                    case 'gas_station' :

                                        ct_query_yelp_api('gas stations', $ct_listing_address, 'fa-car');
                                        
                                    break;
  
                                }
    
                            } endif;

                        echo '</div>';
                    }
                ?>
                <!-- // Nearby -->

	            <?php if($ct_listing_agent_info != 'no') { ?>
	            <!-- Agent Contact -->
	            <div class="marb20 listing-agent-contact">
		            <?php 
	            		$first_name = get_the_author_meta('first_name');
						$last_name = get_the_author_meta('last_name');
						$author_id = get_the_author_meta('ID');
						$tagline = get_the_author_meta('tagline');
						$mobile = get_the_author_meta('mobile');
						$office = get_the_author_meta('office');
						$fax = get_the_author_meta('fax');
						$email = get_the_author_meta('email');
	                    $twitterhandle = get_the_author_meta('twitterhandle');
	                    $facebookurl = get_the_author_meta('facebookurl');
	                    $linkedinurl = get_the_author_meta('linkedinurl');
	                    $gplus = get_the_author_meta('gplus');
					?>
		            <h4 class="border-bottom marB20"><a href="<?php echo esc_url(home_url()); ?>/?author=<?php esc_html($author_id); ?>"><?php echo esc_html($first_name); ?> <?php echo esc_html($last_name); ?></a></h4>

	            	<div class="col span_4 first agent-info">
	    	            <?php
                        echo '<figure class="col span_12 first row">';
                            //echo '<a href="' . esc_url(home_url()) . '/?author=' . esc_html($author_id) . '">';
            	               if(get_the_author_meta('ct_profile_url')) {	
            						echo '<img class="authorimg" src="';
                						echo the_author_meta('ct_profile_url');
            						echo '" />';
                				} else {
                                    echo '<img class="author-img" src="' . get_template_directory_uri() . '/images/user-default.png' . '" />';
                                }
                            //echo '</a>';
                        echo '</figure>';
                        ?>

	    				<div class="details col span_12 first row">	        
	    			        <ul class="marB0">
	    			            <?php if($mobile) { ?>
	    				            <li class="marT3 marB0 row"><span class="left"><i class="fa fa-phone"></i></span><span class="right"><?php echo esc_html($mobile); ?></span></li>
	    			            <?php } ?>
	    			            <?php if($office) { ?>
	    				            <li class="marT3 marB0 row"><span class="left"><i class="fa fa-building"></i></span><span class="right"><?php echo esc_html($office); ?></span></li>
	    			            <?php } ?>
	    			            <?php if($fax) { ?>
	    				            <li class="marT3 marB0 row"><span class="left"><i class="fa fa-print"></i></span><span class="right"><?php echo esc_html($fax); ?></span></li>
	    				        <?php } ?>
	    			        	<?php if($email) { ?>
	    				        	<li class="marT3 marB0 row"><span class="left"><i class="fa fa-envelope"></i></span><span class="right"><a href="mailto:<?php echo antispambot($email,1) ?>"><?php esc_html_e('Email', 'contempo'); ?></a></span></li>
	    					    <?php } ?>
	    					</ul>
	                        <ul class="social marT15 marL0">
	                            <?php if ($twitterhandle) { ?><li class="twitter"><a href="http://twitter.com/#!/<?php echo esc_url($twitterhandle); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
	                            <?php if ($facebookurl) { ?><li class="facebook"><a href="<?php echo esc_url($facebookurl); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
	                            <?php if ($linkedinurl) { ?><li class="facebook"><a href="<?php echo esc_url($linkedinurl); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
	                            <?php if ($gplus) { ?><li class="google"><a href="<?php echo esc_url($gplus); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php } ?>
	                        </ul>
	    			    </div>
	                </div>
	                
	                <div class="col span_8 agent-contact">
	                	<h5 class="marT0 marB20"><?php esc_html_e('Request More Information', 'contempo'); ?></h5>
	                	 <form id="listingscontact" class="formular" method="post">
	    					<fieldset>
	    						<select id="ctsubject" name="ctsubject">
	    							<option><?php esc_html_e('Tell me more about this property', 'contempo'); ?></option>
	    							<option><?php esc_html_e('Request a showing', 'contempo'); ?></option>
	    						</select>
	    							<div class="clear"></div>
	    						<input type="text" name="name" id="name" class="validate[required,custom[onlyLetter]] text-input" placeholder="<?php esc_html_e('Name', 'contempo'); ?>" />

	    						<input type="text" name="email" id="email" class="validate[required,custom[email]] text-input" placeholder="<?php esc_html_e('Email', 'contempo'); ?>" />

	    						<input type="text" name="ctphone" id="ctphone" class="text-input" placeholder="<?php esc_html_e('Phone', 'contempo'); ?>" />

	    						<textarea class="validate[required,length[2,1000]] text-input" name="message" id="message" rows="6" cols="10"></textarea>

	    						<input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php the_author_meta('user_email'); ?>" />
	    						<input type="hidden" id="ctproperty" name="ctproperty" value="<?php the_title(); ?>, <?php city(); ?>, <?php state(); ?> <?php zipcode(); ?>" />
	    						<input type="hidden" id="ctpermalink" name="ctpermalink" value="<?php the_permalink(); ?>" />

	    						<input type="submit" name="Submit" value="<?php esc_html_e('Submit', 'contempo'); ?>" id="submit" class="btn" />  
	    					</fieldset>
	    				</form>
	                </div>
	                    <div class="clear"></div>

	                <?php
					
	                if ( 2 == count( get_coauthors( get_the_id() ) ) ) { ?>
	                <!-- Co Agent -->
	                <div class="co-list-agent col span_12 first marB20">
	                    <h5 class="border-bottom marB20"><?php esc_html_e('Co-listing Agent', 'contempo'); ?></h5>
	                    <?php

		                    $coauthors = get_coauthors();

	                        // remove the first author
	                        array_shift($coauthors);

	                        echo '<ul id="co-agent" class="marB0">';
	                            foreach( $coauthors as $coauthor ) {
	                                echo '<li class="agent">';
	                                    echo '<figure class="col span_3 first">';
                                            //echo '<a href="' . esc_url(home_url()) . '/?author=' . esc_html($coauthor->ID) . '" title="' . esc_html($coauthor->display_name) .'">';
                                            if($coauthor->ct_profile_url) {
                                                echo '<img class="author-img" src="' . esc_html($coauthor->ct_profile_url) . '" />';
                                            } else {
                                                 echo '<img class="author-img" src="' . get_template_directory_uri() . '/images/user-default.png' . '" />';
                                            }
                                           // echo '</a>';
                                        echo '</figure>';
	                                    echo '<div class="agent-info col span_9">';
	                                        echo '<h4 class="marT0 marB0">' . esc_html($coauthor->display_name) . '</h4>';
	                                        if ($coauthor->title) { 
	                                            echo '<h5 class="muted marB10">' . esc_html($coauthor->title) . '</h5>';
	                                        } ?>
	                                        <div class="agent-bio col span_8 first">
	                                           <?php if($coauthor->tagline) { ?>
	                                               <p class="tagline"><strong><?php echo esc_html($coauthor->tagline); ?></strong></p>
	                                           <?php } ?>
	                                           <ul class="col span_8 marT15 first">
	                                                <?php if($coauthor->mobile) { ?>
	                                                    <li class="row"><span class="muted left"><i class="fa fa-phone"></i></span> <span class="right"><?php echo esc_html($coauthor->mobile); ?></span></span></li>
	                                                <?php } ?>
	                                                <?php if($coauthor->office) { ?>
	                                                    <li class="row"><span class="muted left"><i class="fa fa-building"></i></span> <span class="right"><?php echo esc_html($coauthor->office); ?></span></li>
	                                                <?php } ?>
	                                                <?php if($coauthor->fax) { ?>
	                                                    <li class="row"><span class="muted left"><i class="fa fa-print"></i></span> <span class="right"><?php echo esc_html($coauthor->fax); ?></span></li>
	                                                <?php } ?>
	                                                <?php if($coauthor->user_email) { $email = $coauthor->user_email; ?>
	                                                    <li class="row"><span class="muted left"><i class="fa fa-envelope"></i></span> <span class="right"><a href="mailto:<?php echo antispambot($email,1 ) ?>"><?php esc_html_e('Email', 'contempo'); ?></a></span></li>
	                                                <?php } ?>
	                                                <?php if($coauthor->brokername) { ?><p class="marB3"><strong><?php echo esc_html($coauthor->brokername); ?></strong></p><?php } ?>
	                                                <?php if($coauthor->brokernum) { ?><p class="marB3"><?php echo esc_html($coauthor->brokernum); ?></p><?php } ?>
	                                            </ul>
	                                            
	                                        </div>
	                                        <ul class="social">
	                                            <?php if ($coauthor->twitterhandle) { ?><li class="twitter"><a href="http://twitter.com/#!/<?php echo esc_url($coauthor->twitterhandle); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
	                                            <?php if ($coauthor->facebookurl) { ?><li class="facebook"><a href="<?php echo esc_url($coauthor->facebookurl); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
	                                            <?php if ($coauthor->linkedinurl) { ?><li class="linkedin"><a href="<?php echo esc_url($coauthor->linkedinurl); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
	                                            <?php if ($coauthor->gplus) { ?><li class="google"><a href="<?php echo esc_url($coauthor->gplus); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php } ?>
	                                        </ul>
	                                    </div>
	                               <?php  echo '</li>';
	                            }
	                        echo '</ul>';
	                    ?>
	                </div>
	                    <div class="clear"></div>
	                <!-- //Co Agent -->
	                <?php } ?>

	            </div>
	            <!-- //Agent Contact -->
	            <?php } ?>

	            <!-- Share This Listing -->
	            <div class="share-this-listing col span_12 first">
		            <div class="pad60">
		            	<h2><?php esc_html_e('Share This Listing', 'contempo'); ?></h2>
			            <ul class="social marB0">
					        <li class="twitter"><a href="javascript:void(0);" onclick="popup('http://twitter.com/home/?status=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?> &mdash; <?php echo site_url(); ?>', 'twitter',500,260);"><i class="fa fa-twitter"></i></a></li>
					        <li class="facebook"><a href="javascript:void(0);" onclick="popup('http://www.facebook.com/sharer.php?u=<?php echo site_url(); ?>&t=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>', 'facebook',658,225);"><i class="fa fa-facebook"></i></a></li>
					        <li class="linkedin"><a href="javascript:void(0);" onclick="popup('http://www.linkedin.com/shareArticle?mini=true&url=<?php echo site_url(); ?>&title=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>&summary=&source=<?php bloginfo('name'); ?>', 'linkedin',560,400);"><i class="fa fa-linkedin"></i></a></li>
					        <li class="google"><a href="javascript:void(0);" onclick="popup('https://plusone.google.com/_/+1/confirm?hl=en&url=<?php echo site_url(); ?>', 'google',500,275);"><i class="fa fa-google-plus"></i></a></a></li>
					    </ul>
				    </div>
	            </div>
	            <!-- //Share This Listing -->

        </div>
        <!-- //Container -->

    </section>
    <!-- //Single Listing Home -->

<?php endwhile; endif; ?>