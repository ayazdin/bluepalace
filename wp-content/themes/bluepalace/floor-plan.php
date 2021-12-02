<?php
/*
*	template part news
*/
?>

<div class="floor_plan">
    <!-- <?php //do_action('before_archive_content'); ?> -->

    <!-- Main Content Container -->
    <div class="container archive marT60 padB60">

        <!-- Posts Loop -->
        <?php
        $post_type = 'floorplan';

        // Get all the taxonomies for this post type
        $taxonomies = get_object_taxonomies((object)array('post_type' => $post_type));
        $i = 0;
        foreach ($taxonomies as $taxonomy) :
            // Gets every "category" (term) in this taxonomy to get the respective posts
            $terms = get_terms($taxonomy);
            foreach ($terms as $term) :

                $the_category_id = $term->term_id;
                //$posts = new WP_Query("taxonomy=$taxonomy&term=$term->slug&posts_per_page=2&category=$term->term_id");
                $posts = new WP_Query( array(
                        'post_type'     => $post_type,
                        'post_status'   => 'publish',
                        'tax_query'     => array(
                            array(
                                'taxonomy'          => $taxonomy,
                                'terms'             => array( $the_category_id ),
                                'field'             => 'term_id',
                                'operator'          => 'AND',
                                'include_children'  => false
                            )
                        )
                    )

                );
                $tempPosition = ($i % 2 == 0) ? 'first' : '';
                echo ($i % 2 == 0 && $i != 0) ? '<div style="clear:both;"></div>' : '';
                if($term->parent==0){
                    ?>
                    <div class="col span_6 <?= $tempPosition; ?> standard listYourPropertyListing">
                        <h5><?= $term->name; ?></h5>
                        <ul>
                            <?php
                            /*sub Category*/
                            $subtaxanomies = get_object_taxonomies((object)array('post_type' => $post_type));
                            foreach($subtaxanomies as $subtaxanomy):
                                $args = array(
                                    'parent'         => $term->term_id,
                                    // 'child_of'      => $parent_term_id,
                                );
                                $subterms = get_terms($subtaxanomy,$args);

                                foreach($subterms as $subterm):

                                    ?>
                                    <li>
                                        <?php echo $subterm->name;?>
                                        <ul>
                                            <!--third child-->
                                            <?php
                                            $thirdtaxanomies = get_object_taxonomies((object)array('post_type' => $post_type));
                                            foreach($thirdtaxanomies as $thirdtaxanomy):
                                                $thirdterms = get_terms($thirdtaxanomies, array('child_of' => $subterm->term_taxonomy_id));
                                                foreach($thirdterms as $thirdterm):?>
                                                    <li><?php echo $thirdterm->name;?>
                                                        <ul>
                                                            <?php $thirdposts = new WP_Query("taxonomy=$thirdtaxanomy&term=$thirdterm->slug&posts_per_page=2");
                                                            if ($thirdposts->have_posts()): while ($thirdposts->have_posts()) : $thirdposts->the_post();?>
                                                                <li>
                                                                    <a href="<?= the_permalink(); ?>">
                                                                        <?= the_title(); ?>
                                                                    </a>
                                                                </li>
                                                            <?php endwhile; endif;
                                                            ?>
                                                        </ul>
                                                    </li>
                                                <?php endforeach;
                                            endforeach;
                                            ?>
                                            <!--third child-->



                                            <?php //$subposts = new WP_Query("taxonomy=$subtaxanomy&term=$subterm->slug&posts_per_page=2");
                                            $the_sub_category_id = $subterm->term_id;
                                            //$posts = new WP_Query("taxonomy=$taxonomy&term=$term->slug&posts_per_page=2&category=$term->term_id");
                                            $subposts = new WP_Query( array(
                                                    'post_type'     => $post_type,
                                                    'post_status'   => 'publish',
                                                    'tax_query'     => array(
                                                        array(
                                                            'taxonomy'          => $subtaxanomy,
                                                            'terms'             => array( $the_sub_category_id ),
                                                            'field'             => 'term_id',
                                                            'operator'          => 'AND',
                                                            'include_children'  => false
                                                        )
                                                    )
                                                )

                                            );
                                            if ($subposts->have_posts()): while ($subposts->have_posts()) : $subposts->the_post();?>
                                                <li>
                                                    <a href="<?= the_permalink(); ?>">
                                                        <?= the_title(); ?>
                                                    </a>
                                                </li>
                                            <?php endwhile; endif;
                                            ?>
                                        </ul>
                                    </li>

                                <?php endforeach;
                            endforeach;
                            /*sub Category*/
                            ?>
                            <?php
                            if ($posts->have_posts()): while ($posts->have_posts()) : $posts->the_post();
//                            print_r($posts);
                                ?>
                                <li>
                                    <a href="<?= the_permalink(); ?>">
                                        <?= the_title(); ?>
                                    </a>
                                </li>
                                <?php
                            endwhile; endif;
                            ?>
                        </ul>
                    </div>
                <?php }
                $i++;
            endforeach;

        endforeach;
        ?>
    </div>
    <style type="text/css">
        #main-content article {
            margin-top: -45px;
        }

        .listYourPropertyListing h5 {
            height: 22px;
            padding: 8px 0 25px 15px;
            margin: 20px 0 10px;
            background: #f1f1f1;
            font-size: 14px;
        }
    </style>

