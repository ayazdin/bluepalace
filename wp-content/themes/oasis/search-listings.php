<?php
/**
 * Search Listings Template
 *
 * @package Royal Oasis
 * @subpackage Template
 */

global $ct_options;
$ct_home_adv_search_style = isset( $ct_options['ct_home_adv_search_style'] ) ? $ct_options['ct_home_adv_search_style'] : '';
$ct_disable_listing_search_results_adv_search = isset( $ct_options['ct_disable_listing_search_results_adv_search'] ) ? $ct_options['ct_disable_listing_search_results_adv_search'] : '';
$ct_search_results_layout = isset( $ct_options['ct_search_results_layout'] ) ? $ct_options['ct_search_results_layout'] : '';
$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';
$ct_header_listing_search = isset( $ct_options['ct_header_listing_search'] ) ? esc_html( $ct_options['ct_header_listing_search'] ) : '';

$taxonomies_to_search = array(
    'beds' => 'Bedrooms',
    'baths' => 'Bathrooms',
    'property_type' => 'Property Type',
    'ct_status' => 'Status',
    'state' => 'State',
    'zipcode' => 'Zipcode',
    'city' => 'City',
    'country' => 'Country',
    'community' => 'Community',
    'additional_features' => 'Additional Features',
    'furnished_unfurnished' => 'Furnished/Unfurnished'
);
$search_values = array();
foreach ($taxonomies_to_search as $t => $l) {
    $var_name = 'ct_'. $t;

    if (!empty($_GET[$var_name])) {
        $search_values[$t] = utf8_encode($_GET[$var_name]);
    }
}
$search_values['post_type'] = 'listings';
$search_values['paged'] = ct_currentPage();
$search_num = $ct_options['ct_listing_search_num'];
$search_values['showposts'] = $search_num;

/*-----------------------------------------------------------------------------------*/
/* Exclude Ghost Status */
/*-----------------------------------------------------------------------------------*/

$search_values['tax_query'] = array (
    array(
        'taxonomy'  => 'ct_status',
        'field'     => 'slug',
        'terms'     => 'ghost', // exclude media posts in the news-cat custom taxonomy
        'operator'  => 'NOT IN'
    ),
);

/*-----------------------------------------------------------------------------------*/
/* Keyword Search on Title and Content */
/*-----------------------------------------------------------------------------------*/

add_action( 'pre_get_posts', function( $q ) {
    if($title = $q->get('_meta_or_title')) {
        add_filter( 'get_meta_sql', function($sql) use ($title) {
            global $wpdb;

            // Only run once:
            static $nr = 0;
            if(0 != $nr++) return $sql;

            // Modify WHERE part:
            $sql['where'] = sprintf(
                " AND ( %s OR %s ) ",
                $wpdb->prepare("{$wpdb->posts}.post_title like '%%%s%%'", $title),
                $wpdb->prepare("{$wpdb->posts}.post_content like '%%%s%%'", $title),
                mb_substr( $sql['where'], 5, mb_strlen( $sql['where'] ) )
            );
            return $sql;
        });
    }
});

if (!empty($_GET['ct_keyword'])) {

    $ct_keyword = $_GET['ct_keyword'];
    $search_values['_meta_or_title'] = $ct_keyword;

    $search_values['meta_query'] = array(
        array(
            'meta_key' => 'keywords',
            'value' => $ct_keyword,
            'compare' => 'LIKE'
        )
    );

}

// Order by Price
if (!empty($_GET['ct_orderby_price'])) {

    $order = utf8_encode($_GET['ct_orderby_price']);

    $search_values['orderby'] = 'meta_value';
    $search_values['meta_key'] = '_ct_price';
    $search_values['meta_type'] = 'numeric';
    $search_values['order'] = $order;

}

/*-----------------------------------------------------------------------------------*/
/* Order by (Title, Price or upload date) */
/*-----------------------------------------------------------------------------------*/

if (!empty($_GET['ct_orderby'])) {
    $orderBy = $_GET['ct_orderby'];

    if ($orderBy == 'priceASC') {
        $search_values['orderby'] = 'meta_value';
        $search_values['meta_key'] = '_ct_price';
        $search_values['meta_type'] = 'numeric';
        $search_values['order'] = 'ASC';
    } elseif ($orderBy == 'priceDESC') {
        $search_values['orderby'] = 'meta_value';
        $search_values['meta_key'] = '_ct_price';
        $search_values['meta_type'] = 'numeric';
        $search_values['order'] = 'DESC';
    } elseif ($orderBy == 'dateDESC') {
        $search_values['orderby'] = 'date';
        $search_values['order'] = 'DESC';
    }elseif ($orderBy == 'dateASC') {
        $search_values['orderby'] = 'date';
        $search_values['order'] = 'ASC';
    } else { //	titleASC
        $search_values['orderby'] = 'title';
        $search_values['order'] = 'ASC';
    }
}

$mode = 'search';

/*-----------------------------------------------------------------------------------*/
/* Check Price From/To */
/*-----------------------------------------------------------------------------------*/

if (!empty($_GET['ct_price_from']) && !empty($_GET['ct_price_to'])) {
    $ct_price_from = str_replace(',', '', $_GET['ct_price_from']);
    $ct_price_to = str_replace(',', '', $_GET['ct_price_to']);
    $search_values['meta_query'] = array(
        array(
            'key' => '_ct_price',
            'value' => array( $ct_price_from, $ct_price_to ),
            'type' => 'NUMERIC',
            'compare' => 'BETWEEN'
        )
    );
}
else if (!empty($_GET['ct_price_from'])) {
    $ct_price_from = str_replace(',', '', $_GET['ct_price_from']);
    $search_values['meta_query'] = array(
        array(
            'key' => '_ct_price',
            'value' => $ct_price_from,
            'type' => 'NUMERIC',
            'compare' => '>='
        )
    );
}
else if (!empty($_GET['ct_price_to'])) {
    $ct_price_to = str_replace(',', '', $_GET['ct_price_to']);
    $search_values['meta_query'] = array(
        array(
            'key' => '_ct_price',
            'value' => $_GET['ct_price_to'],
            'type' => 'NUMERIC',
            'compare' => '<='
        )
    );
}

/*-----------------------------------------------------------------------------------*/
/* Check Dwelling Size From/To */
/*-----------------------------------------------------------------------------------*/

if (!empty($_GET['ct_sqft_from']) && !empty($_GET['ct_sqft_to'])) {
    $ct_sqft_from = str_replace(',', '', $_GET['ct_sqft_from']);
    $ct_sqft_to = str_replace(',', '', $_GET['ct_sqft_to']);
    $search_values['meta_query'] = array(
        array(
            'key' => '_ct_sqft',
            'value' => array( $ct_sqft_from, $ct_sqft_to ),
            'type' => 'NUMERIC',
            'compare' => 'BETWEEN'
        )
    );
}
else if (!empty($_GET['ct_sqft_from'])) {
    $ct_sqft_from = str_replace(',', '', $_GET['ct_sqft_from']);
    $search_values['meta_query'] = array(
        array(
            'key' => '_ct_sqft',
            'value' => $ct_sqft_from,
            'type' => 'NUMERIC',
            'compare' => '>='
        )
    );
}
else if (!empty($_GET['ct_sqft_to'])) {
    $ct_sqft_to = str_replace(',', '', $_GET['ct_sqft_to']);
    $search_values['meta_query'] = array(
        array(
            'key' => '_ct_sqft',
            'value' => $ct_sqft_to,
            'type' => 'NUMERIC',
            'compare' => '<='
        )
    );
}

/*-----------------------------------------------------------------------------------*/
/* Check Lot Size From/To */
/*-----------------------------------------------------------------------------------*/

if (!empty($_GET['ct_lotsize_from']) && !empty($_GET['ct_sqft_to'])) {
    $ct_lotsize_from = str_replace(',', '', $_GET['ct_lotsize_from']);
    $ct_lotsize_to = str_replace(',', '', $_GET['ct_lotsize_to']);
    $search_values['meta_query'] = array(
        array(
            'key' => '_ct_lotsize',
            'value' => array( $ct_sqft_from, $ct_sqft_to ),
            'type' => 'NUMERIC',
            'compare' => 'BETWEEN'
        )
    );
}
else if (!empty($_GET['ct_lotsize_from'])) {
    $ct_lotsize_from = str_replace(',', '', $_GET['ct_lotsize_from']);
    $search_values['meta_query'] = array(
        array(
            'key' => '_ct_lotsize',
            'value' => $ct_lotsize_from,
            'type' => 'NUMERIC',
            'compare' => '>='
        )
    );
}
else if (!empty($_GET['ct_lotsize_to'])) {
    $ct_lotsize_to = str_replace(',', '', $_GET['ct_lotsize_to']);
    $search_values['meta_query'] = array(
        array(
            'key' => '_ct_lotsize',
            'value' => $ct_lotsize_to,
            'type' => 'NUMERIC',
            'compare' => '<='
        )
    );
}

/*-----------------------------------------------------------------------------------*/
/* Check if pet friendly */
/*-----------------------------------------------------------------------------------*/

if (!empty($_GET['pet_friendly'])) {
    $pet_friendly = $_GET['pet_friendly'];
    $search_values['meta_query'] = array(
        array(
            'key' => 'pet_friendly',
            'value' => $pet_friendly,
            'type' => 'char',
            'compare' => '='
        )
    );
}

/*-----------------------------------------------------------------------------------*/
/* Check to see if reference number matches */
/*-----------------------------------------------------------------------------------*/

if (!empty($_GET['ct_mls'])) {
    $ct_mls = $_GET['ct_mls'];
    $search_values['meta_query'] = array(
        array(
            'key' => '_ct_mls',
            'value' => $ct_mls,
            'type' => 'char',
            'compare' => '='
        )
    );
}

/*-----------------------------------------------------------------------------------*/
/* Check to see if number of guests matches */
/*-----------------------------------------------------------------------------------*/

if (!empty($_GET['ct_rental_guests'])) {
    $ct_rental_guests = $_GET['ct_rental_guests'];
    $search_values['meta_query'] = array(
        array(
            'key' => '_ct_rental_guests',
            'value' => $ct_rental_guests,
            'type' => 'num',
            'compare' => '<='
        )
    );
}

global $wp_query;

/*-----------------------------------------------------------------------------------*/
/* Save the existing query */
/*-----------------------------------------------------------------------------------*/

$existing_query_obj = $wp_query;

$wp_query = new WP_Query( $search_values );
$total_results = $wp_query->found_posts;
unset($search_values['post_type']);
unset($search_values['paged']);
unset($search_values['showposts']);

/*-----------------------------------------------------------------------------------*/
/* Prepare the title string by looping through all
/* the values we're going to query and put them together
/*-----------------------------------------------------------------------------------*/

$search_params = array();
$loop = 0;

foreach ($search_values as $t => $s) {
    $term = get_term_by('slug',$s,$t);
    if($term != '0') {
        $search_params[] = $term->name;
    }
}
$search_params[] = $_GET['ct_keyword'];
$search_params = implode(', ', $search_params);
get_header();?>

    <main class="page-content archive-listing">
        <section class="bg-gray-lighter">
            <div class="shell text-left">
                <ol class="breadcrumb">
                    <li><a href="<?php echo home_url();?>">Home</a></li>
                    <li class="active">Listings
                    </li>
                </ol>
            </div>
        </section>

        <section class="section-top-70 section-bottom-80">
            <div class="shell">
            <?php
            if($ct_header_listing_search != 'yes') {
                echo '<!-- Title Header -->';

                echo '<h3 >';
                echo esc_html($total_results);
                echo ' ';
                if($total_results != '1') { esc_html_e('listings found', 'contempo'); } else { esc_html_e('listing found', 'contempo'); }
                echo '</h3>';

                echo '<!-- //Title Header -->';
            }
            ?>
            </div>
            <div class="row offset-top-40">
                <!-- Isotope Filters-->

                <!-- Isotope Content-->
                <div class="col-lg-12 offset-top-30">
                    <?php
                    // Reset Query for Listings
                    wp_reset_query();
                    wp_reset_postdata();

                    $search_values['post_type'] = 'listings';
                    $search_values['paged'] = ct_currentPage();
                    $search_values['showposts'] = $search_num;
                    $wp_query = new wp_query( $search_values );




                    if(have_posts()):?>
                        <div data-isotope-layout="fitRows" data-isotope-group="gallery" class="isotope">
                            <div class="row row-no-gutter">
                                <?php
                                while(have_posts()):the_post();?>
                                    <div  class="col-xs-12 col-sm-6 col-lg-4 isotope-item">
                                        <!-- Thumbnail-->
                                        <div class="thumbnail">
                                            <?php
                                            if(has_post_thumbnail()){
                                                $img = get_the_post_thumbnail_url();
                                            }
                                            else{
                                                $img  = get_template_directory_uri().'/images/post-04.jpg';
                                            }
                                            ?>
                                            <img src="<?php echo $img?>" width="640" height="483" alt="" class="img-responsive center-block">
                                            <div class="caption">
                                                <div class="caption-inner">
                                                    <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
                                                </div>
                                                <div><a href="<?php the_permalink() ?>" class="btn"></a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                endwhile;
                                ?>
                            </div>
                        </div>
                        <div class="offset-top-30">
                            <!-- Bootstrap Pagination-->
                            <nav>
                                <?php ct_numeric_pagination(); ?>
                            </nav>
                        </div>
                        <?php
                    endif;
                    ?>

                </div>
            </div>
        </section>
    </main>
<?php
get_footer(); ?>