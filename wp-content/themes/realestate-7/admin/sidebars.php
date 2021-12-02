<?php
/**
 * Register Sidebars
 *
 * @package WP Pro Real Estate 7
 * @subpackage Admin
 */

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Listing Single Right',
        'id' => 'listings-single-right',
        'description' => 'Widgets in this area will be shown in the right sidebar area on the listings single view.',
        'before_widget' => '<aside id="%1$s" class="widget %2$s left">',
        'after_widget' => '</aside>',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Left Sidebar Pages',
        'id' => 'left-sidebar-pages',
        'description' => 'Widgets in this area will be shown in the left sidebar area of pages with the left sidebar page template.',
        'before_widget' => '<aside id="%1$s" class="widget %2$s left">',
        'after_widget' => '</aside>',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Right Sidebar Pages',
        'id' => 'right-sidebar-pages',
        'description' => 'Widgets in this area will be shown in the right sidebar area of pages.',
        'before_widget' => '<aside id="%1$s" class="widget %2$s left">',
        'after_widget' => '</aside>',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
));
 
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Right Sidebar Blog',
        'id' => 'right-sidebar-blog',
        'description' => 'Widgets in this area will be shown in the right sidebar area of archives.',
        'before_widget' => '<aside id="%1$s" class="widget %2$s left">',
        'after_widget' => '</aside>',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
));
 
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Right Sidebar Single',
        'id' => 'right-sidebar-single',
        'description' => 'Widgets in this area will be shown in the right sidebar area of single posts.',
        'before_widget' => '<aside id="%1$s" class="widget %2$s left">',
        'after_widget' => '</aside>',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Right Sidebar Contact Page',
        'id' => 'right-sidebar-contact',
        'description' => 'Widgets in this area will be shown in the right sidebar area of the contact page template.',
        'before_widget' => '<aside id="%1$s" class="widget %2$s left">',
        'after_widget' => '</aside>',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'IDX Search Homepage',
        'id' => 'dsidxpress-homepage',
        'description' => 'This is meant to only be used with the dsIDXpress Search Widget, to replace the advanced search on the homepage. If the block has been enabled via WP Pro Real Estate 7 Options > Homepage > Layout Manager > dsIDXpress Search.',
        'before_widget' => '<aside id="%1$s" class="widget col span_12 %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Four Column Homepage',
        'id' => 'four-column-homepage',
        'description' => 'Widgets in this area will be shown in the homepage if the block has been enabled via WP Pro Real Estate 7 Options > Homepage > Layout Manager > Four Column Widgets.',
        'before_widget' => '<aside id="%1$s" class="widget col span_3 %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Footer',
        'id' => 'footer',
        'description' => 'Widgets in this area will be shown in the footer.',
        'before_widget' => '<aside id="%1$s" class="widget col span_3 %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
));

?>