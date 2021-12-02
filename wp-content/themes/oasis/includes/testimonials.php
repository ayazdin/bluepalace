<?php
/**
 * Testimonials
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
global $ct_options;

$ct_home_testimonials_style = isset( $ct_options['ct_home_testimonials_style'] ) ? esc_html( $ct_options['ct_home_testimonials_style'] ) : '';
$ct_home_testimonials = isset( $ct_options['ct_home_testimonials'] ) ? $ct_options['ct_home_testimonials'] : '';
 
echo '<div class="aq-block-aq_testimonial_block">';
	echo '<div class="flexslider">';
		echo '<ul class="slides">';
		if($ct_home_testimonials > 1) {
			foreach ($ct_home_testimonials as $testimonial => $value) {
	            if (!empty ($value['title'])) {
		            $link = $value['url'];
		            $imgURL = $value['image'];
		            $title = $value['title'];
		            $desc = $value['description'];
	                echo '<li>';
	                	if(!empty($link)) {
		                	echo '<a href="' . esc_url($link) . '">';
			                	if(!empty($imgURL)) {
			                		if($ct_home_testimonials_style == 'testimonials-style-two') {
						                echo '<figure>';
							            	echo '<img src="' . esc_url($imgURL) .'" />';
						            	echo '</figure>';
						            } else {
						            	echo '<img src="' . esc_url($imgURL) .'" />';
						            }
					            }
				                echo '<div class="testimonial-quote ';
				                	if(empty($imgURL)) {
				                		echo 'no-image';
				                	}
				                	echo '">';
									echo '<p class="marB10">' . esc_html($desc) . '</p>';
									echo '<h5 class="marB0">' . esc_html($title) . '</h5>';
								echo '</div>';
			                echo '</a>';
			            } else {
			            	if(!empty($imgURL)) {
			            		if($ct_home_testimonials_style == 'testimonials-style-two') {
						                echo '<figure>';
							            	echo '<img src="' . esc_url($imgURL) .'" />';
						            	echo '</figure>';
						            } else {
						            	echo '<img src="' . esc_url($imgURL) .'" />';
						            }
				            }
			                echo '<div class="testimonial-quote ';
			                	if(empty($imgURL)) {
			                		echo 'no-image';
			                	}
			                	echo '">';
								echo '<p class="marB10">' . esc_html($desc) . '</p>';
								echo '<h5 class="marB0">' . esc_html($title) . '</h5>';
							echo '</div>';
			            }
	                echo '</li>';
	            }
            }
        }
		echo '</ul>';
	echo '</div>';
echo '</div>';
?>