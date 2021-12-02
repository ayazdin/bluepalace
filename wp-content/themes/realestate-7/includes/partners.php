<?php
/**
 * Partners
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
global $ct_options;

$ct_partner_title = isset( $ct_options['ct_partner_title'] ) ? esc_html( $ct_options['ct_partner_title'] ) : '';
$ct_partner_logos = isset( $ct_options['ct_partner_logos'] ) ? $ct_options['ct_partner_logos'] : '';
$count = 0; 
 
echo '<h5 class="center"><span>' . $ct_partner_title . '</span></h5>';

if($ct_partner_logos > 1) {
    echo '<ul class="logos">';
        foreach ($ct_partner_logos as $logo => $value) {
            if (!empty ($value['image'])) {
                $logolink = $value['url'];
                $imgURL = $value['image'];
                echo '<li class="col span_2';
                        if($count % 6 == 0) { echo ' first'; }
                    echo '">';
                	if(!empty($logolink)) {
	                	echo '<a href="' . esc_url($logolink) . '">';
			                echo '<img src="' . esc_url($imgURL) .'" />';
		                echo '</a>';
		            } else {
		            	echo '<img src="' . esc_url($imgURL) .'" />';
		            }
                echo '</li>';
            }
            $count++;
        }
    echo '</ul>';
} ?>