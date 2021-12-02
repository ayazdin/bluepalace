<?php
    /**
     * Theme Options Config
     *
     * @package WP Pro Real Estate 7
     * @subpackage Admin
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "ct_options";

    // This line is only for altering the demo. Can be easily removed.
    $opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );

    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';
    if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
    }

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();

    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'Real Estate 7 Options', 'contempo' ),
        'page_title'           => __( 'Real Estate 7 Options', 'contempo' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => false,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    /*--------------------------------------*/
    /* FontAwesome
    /*--------------------------------------*/

    function newIconFont() {
        wp_deregister_style( 'redux-elusive-icon' );
        wp_deregister_style( 'redux-elusive-icon-ie7' );
     
        wp_register_style(
            'redux-font-awesome',
            '//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css',
            array(),
            time(),
            'all'
        );  
        wp_enqueue_style( 'redux-font-awesome' );
    }
    // This example assumes the opt_name is set to redux_demo.  Please replace it with your opt_name value.
    add_action( 'redux/page/ct_options/enqueue', 'newIconFont' );

    /*--------------------------------------*/
    /* Custom CSS
    /*--------------------------------------*/

    function ctCustomCSS() {
     
        wp_register_style(
            'ct-redux-custom-css',
            get_template_directory_uri() . '/admin/ReduxFramework/theme-options/custom.css',
            array(),
            time(),
            'all'
        );  
        wp_enqueue_style( 'ct-redux-custom-css' );

        wp_register_style(
            'ct-changelog-custom-css',
            get_template_directory_uri() . '/admin/ReduxFramework/theme-changelog/custom.css',
            array(),
            time(),
            'all'
        );  
        wp_enqueue_style( 'ct-changelog-custom-css' );

        wp_register_style(
            'ct-documentation-custom-css',
            get_template_directory_uri() . '/admin/ReduxFramework/theme-documentation/custom.css',
            array(),
            time(),
            'all'
        );  
        wp_enqueue_style( 'ct-documentation-custom-css' );
    }
    add_action( 'redux/page/ct_options/enqueue', 'ctCustomCSS' );

    /*--------------------------------------*/
    /* Font Awesome
    /*--------------------------------------*/

    function ct_font_awesome() {
        $font_awesome_icons = array( 'fa-500px' => '500px', 'fa-adjust' => 'Adjust', 'fa-adn' => 'Adn', 'fa-align-center' => 'Align center', 'fa-align-justify' => 'Align justify', 'fa-align-left' => 'Align left', 'fa-align-right' => 'Align right', 'fa-amazon' => 'Amazon', 'fa-ambulance' => 'Ambulance', 'fa-anchor' => 'Anchor', 'fa-android' => 'Android', 'fa-angellist' => 'Angellist', 'fa-angle-double-down' => 'Angle double down', 'fa-angle-double-left' => 'Angle double left', 'fa-angle-double-right' => 'Angle double right', 'fa-angle-double-up' => 'Angle double up', 'fa-angle-down' => 'Angle down', 'fa-angle-left' => 'Angle left', 'fa-angle-right' => 'Angle right', 'fa-angle-up' => 'Angle up', 'fa-apple' => 'Apple', 'fa-archive' => 'Archive', 'fa-area-chart' => 'Area chart', 'fa-arrow-circle-down' => 'Arrow circle down', 'fa-arrow-circle-left' => 'Arrow circle left', 'fa-arrow-circle-o-down' => 'Arrow circle o down', 'fa-arrow-circle-o-left' => 'Arrow circle o left', 'fa-arrow-circle-o-right' => 'Arrow circle o right', 'fa-arrow-circle-o-up' => 'Arrow circle o up', 'fa-arrow-circle-right' => 'Arrow circle right', 'fa-arrow-circle-up' => 'Arrow circle up', 'fa-arrow-down' => 'Arrow down', 'fa-arrow-left' => 'Arrow left', 'fa-arrow-right' => 'Arrow right', 'fa-arrow-up' => 'Arrow up', 'fa-arrows' => 'Arrows', 'fa-arrows-alt' => 'Arrows alt', 'fa-arrows-h' => 'Arrows h', 'fa-arrows-v' => 'Arrows v', 'fa-asterisk' => 'Asterisk', 'fa-at' => 'At', 'fa-backward' => 'Backward', 'fa-balance-scale' => 'Balance scale', 'fa-ban' => 'Ban', 'fa-bar-chart' => 'Bar chart', 'fa-barcode' => 'Barcode', 'fa-bars' => 'Bars', 'fa-battery-empty' => 'Battery empty', 'fa-battery-full' => 'Battery full', 'fa-battery-half' => 'Battery half', 'fa-battery-quarter' => 'Battery quarter', 'fa-battery-three-quarters' => 'Battery three quarters', 'fa-bed' => 'Bed', 'fa-beer' => 'Beer', 'fa-behance' => 'Behance', 'fa-behance-square' => 'Behance square', 'fa-bell' => 'Bell', 'fa-bell-o' => 'Bell o', 'fa-bell-slash' => 'Bell slash', 'fa-bell-slash-o' => 'Bell slash o', 'fa-bicycle' => 'Bicycle', 'fa-binoculars' => 'Binoculars', 'fa-birthday-cake' => 'Birthday cake', 'fa-bitbucket' => 'Bitbucket', 'fa-bitbucket-square' => 'Bitbucket square', 'fa-black-tie' => 'Black tie', 'fa-bold' => 'Bold', 'fa-bolt' => 'Bolt', 'fa-bomb' => 'Bomb', 'fa-book' => 'Book', 'fa-bookmark' => 'Bookmark', 'fa-bookmark-o' => 'Bookmark o', 'fa-briefcase' => 'Briefcase', 'fa-btc' => 'Btc', 'fa-bug' => 'Bug', 'fa-building' => 'Building', 'fa-building-o' => 'Building o', 'fa-bullhorn' => 'Bullhorn', 'fa-bullseye' => 'Bullseye', 'fa-bus' => 'Bus', 'fa-buysellads' => 'Buysellads', 'fa-calculator' => 'Calculator', 'fa-calendar' => 'Calendar', 'fa-calendar-check-o' => 'Calendar check o', 'fa-calendar-minus-o' => 'Calendar minus o', 'fa-calendar-o' => 'Calendar o', 'fa-calendar-plus-o' => 'Calendar plus o', 'fa-calendar-times-o' => 'Calendar times o', 'fa-camera' => 'Camera', 'fa-camera-retro' => 'Camera retro', 'fa-car' => 'Car', 'fa-caret-down' => 'Caret down', 'fa-caret-left' => 'Caret left', 'fa-caret-right' => 'Caret right', 'fa-caret-square-o-down' => 'Caret square o down', 'fa-caret-square-o-left' => 'Caret square o left', 'fa-caret-square-o-right' => 'Caret square o right', 'fa-caret-square-o-up' => 'Caret square o up', 'fa-caret-up' => 'Caret up', 'fa-cart-arrow-down' => 'Cart arrow down', 'fa-cart-plus' => 'Cart plus', 'fa-cc' => 'Cc', 'fa-cc-amex' => 'Cc amex', 'fa-cc-diners-club' => 'Cc diners club', 'fa-cc-discover' => 'Cc discover', 'fa-cc-jcb' => 'Cc jcb', 'fa-cc-mastercard' => 'Cc mastercard', 'fa-cc-paypal' => 'Cc paypal', 'fa-cc-stripe' => 'Cc stripe', 'fa-cc-visa' => 'Cc visa', 'fa-certificate' => 'Certificate', 'fa-chain-broken' => 'Chain broken', 'fa-check' => 'Check', 'fa-check-circle' => 'Check circle', 'fa-check-circle-o' => 'Check circle o', 'fa-check-square' => 'Check square', 'fa-check-square-o' => 'Check square o', 'fa-chevron-circle-down' => 'Chevron circle down', 'fa-chevron-circle-left' => 'Chevron circle left', 'fa-chevron-circle-right' => 'Chevron circle right', 'fa-chevron-circle-up' => 'Chevron circle up', 'fa-chevron-down' => 'Chevron down', 'fa-chevron-left' => 'Chevron left', 'fa-chevron-right' => 'Chevron right', 'fa-chevron-up' => 'Chevron up', 'fa-child' => 'Child', 'fa-chrome' => 'Chrome', 'fa-circle' => 'Circle', 'fa-circle-o' => 'Circle o', 'fa-circle-o-notch' => 'Circle o notch', 'fa-circle-thin' => 'Circle thin', 'fa-clipboard' => 'Clipboard', 'fa-clock-o' => 'Clock o', 'fa-clone' => 'Clone', 'fa-cloud' => 'Cloud', 'fa-cloud-download' => 'Cloud download', 'fa-cloud-upload' => 'Cloud upload', 'fa-code' => 'Code', 'fa-code-fork' => 'Code fork', 'fa-codepen' => 'Codepen', 'fa-coffee' => 'Coffee', 'fa-cog' => 'Cog', 'fa-cogs' => 'Cogs', 'fa-columns' => 'Columns', 'fa-comment' => 'Comment', 'fa-comment-o' => 'Comment o', 'fa-commenting' => 'Commenting', 'fa-commenting-o' => 'Commenting o', 'fa-comments' => 'Comments', 'fa-comments-o' => 'Comments o', 'fa-compass' => 'Compass', 'fa-compress' => 'Compress', 'fa-connectdevelop' => 'Connectdevelop', 'fa-contao' => 'Contao', 'fa-copyright' => 'Copyright', 'fa-creative-commons' => 'Creative commons', 'fa-credit-card' => 'Credit card', 'fa-crop' => 'Crop', 'fa-crosshairs' => 'Crosshairs', 'fa-css3' => 'Css3', 'fa-cube' => 'Cube', 'fa-cubes' => 'Cubes', 'fa-cutlery' => 'Cutlery', 'fa-dashcube' => 'Dashcube', 'fa-database' => 'Database', 'fa-delicious' => 'Delicious', 'fa-desktop' => 'Desktop', 'fa-deviantart' => 'Deviantart', 'fa-diamond' => 'Diamond', 'fa-digg' => 'Digg', 'fa-dot-circle-o' => 'Dot circle o', 'fa-download' => 'Download', 'fa-dribbble' => 'Dribbble', 'fa-dropbox' => 'Dropbox', 'fa-drupal' => 'Drupal', 'fa-eject' => 'Eject', 'fa-ellipsis-h' => 'Ellipsis h', 'fa-ellipsis-v' => 'Ellipsis v', 'fa-empire' => 'Empire', 'fa-envelope' => 'Envelope', 'fa-envelope-o' => 'Envelope o', 'fa-envelope-square' => 'Envelope square', 'fa-eraser' => 'Eraser', 'fa-eur' => 'Eur', 'fa-exchange' => 'Exchange', 'fa-exclamation' => 'Exclamation', 'fa-exclamation-circle' => 'Exclamation circle', 'fa-exclamation-triangle' => 'Exclamation triangle', 'fa-expand' => 'Expand', 'fa-expeditedssl' => 'Expeditedssl', 'fa-external-link' => 'External link', 'fa-external-link-square' => 'External link square', 'fa-eye' => 'Eye', 'fa-eye-slash' => 'Eye slash', 'fa-eyedropper' => 'Eyedropper', 'fa-facebook' => 'Facebook', 'fa-facebook-official' => 'Facebook official', 'fa-facebook-square' => 'Facebook square', 'fa-fast-backward' => 'Fast backward', 'fa-fast-forward' => 'Fast forward', 'fa-fax' => 'Fax', 'fa-female' => 'Female', 'fa-fighter-jet' => 'Fighter jet', 'fa-file' => 'File', 'fa-file-archive-o' => 'File archive o', 'fa-file-audio-o' => 'File audio o', 'fa-file-code-o' => 'File code o', 'fa-file-excel-o' => 'File excel o', 'fa-file-image-o' => 'File image o', 'fa-file-o' => 'File o', 'fa-file-pdf-o' => 'File pdf o', 'fa-file-powerpoint-o' => 'File powerpoint o', 'fa-file-text' => 'File text', 'fa-file-text-o' => 'File text o', 'fa-file-video-o' => 'File video o', 'fa-file-word-o' => 'File word o', 'fa-files-o' => 'Files o', 'fa-film' => 'Film', 'fa-filter' => 'Filter', 'fa-fire' => 'Fire', 'fa-fire-extinguisher' => 'Fire extinguisher', 'fa-firefox' => 'Firefox', 'fa-flag' => 'Flag', 'fa-flag-checkered' => 'Flag checkered', 'fa-flag-o' => 'Flag o', 'fa-flask' => 'Flask', 'fa-flickr' => 'Flickr', 'fa-floppy-o' => 'Floppy o', 'fa-folder' => 'Folder', 'fa-folder-o' => 'Folder o', 'fa-folder-open' => 'Folder open', 'fa-folder-open-o' => 'Folder open o', 'fa-font' => 'Font', 'fa-fonticons' => 'Fonticons', 'fa-forumbee' => 'Forumbee', 'fa-forward' => 'Forward', 'fa-foursquare' => 'Foursquare', 'fa-frown-o' => 'Frown o', 'fa-futbol-o' => 'Futbol o', 'fa-gamepad' => 'Gamepad', 'fa-gavel' => 'Gavel', 'fa-gbp' => 'Gbp', 'fa-genderless' => 'Genderless', 'fa-get-pocket' => 'Get pocket', 'fa-gg' => 'Gg', 'fa-gg-circle' => 'Gg circle', 'fa-gift' => 'Gift', 'fa-git' => 'Git', 'fa-git-square' => 'Git square', 'fa-github' => 'Github', 'fa-github-alt' => 'Github alt', 'fa-github-square' => 'Github square', 'fa-glass' => 'Glass', 'fa-globe' => 'Globe', 'fa-google' => 'Google', 'fa-google-plus' => 'Google plus', 'fa-google-plus-square' => 'Google plus square', 'fa-google-wallet' => 'Google wallet', 'fa-graduation-cap' => 'Graduation cap', 'fa-gratipay' => 'Gratipay', 'fa-h-square' => 'H square', 'fa-hacker-news' => 'Hacker news', 'fa-hand-lizard-o' => 'Hand lizard o', 'fa-hand-o-down' => 'Hand o down', 'fa-hand-o-left' => 'Hand o left', 'fa-hand-o-right' => 'Hand o right', 'fa-hand-o-up' => 'Hand o up', 'fa-hand-paper-o' => 'Hand paper o', 'fa-hand-peace-o' => 'Hand peace o', 'fa-hand-pointer-o' => 'Hand pointer o', 'fa-hand-rock-o' => 'Hand rock o', 'fa-hand-scissors-o' => 'Hand scissors o', 'fa-hand-spock-o' => 'Hand spock o', 'fa-hdd-o' => 'Hdd o', 'fa-header' => 'Header', 'fa-headphones' => 'Headphones', 'fa-heart' => 'Heart', 'fa-heart-o' => 'Heart o', 'fa-heartbeat' => 'Heartbeat', 'fa-history' => 'History', 'fa-home' => 'Home', 'fa-hospital-o' => 'Hospital o', 'fa-hourglass' => 'Hourglass', 'fa-hourglass-end' => 'Hourglass end', 'fa-hourglass-half' => 'Hourglass half', 'fa-hourglass-o' => 'Hourglass o', 'fa-hourglass-start' => 'Hourglass start', 'fa-houzz' => 'Houzz', 'fa-html5' => 'Html5', 'fa-i-cursor' => 'I cursor', 'fa-ils' => 'Ils', 'fa-inbox' => 'Inbox', 'fa-indent' => 'Indent', 'fa-industry' => 'Industry', 'fa-info' => 'Info', 'fa-info-circle' => 'Info circle', 'fa-inr' => 'Inr', 'fa-instagram' => 'Instagram', 'fa-internet-explorer' => 'Internet explorer', 'fa-ioxhost' => 'Ioxhost', 'fa-italic' => 'Italic', 'fa-joomla' => 'Joomla', 'fa-jpy' => 'Jpy', 'fa-jsfiddle' => 'Jsfiddle', 'fa-key' => 'Key', 'fa-keyboard-o' => 'Keyboard o', 'fa-krw' => 'Krw', 'fa-language' => 'Language', 'fa-laptop' => 'Laptop', 'fa-lastfm' => 'Lastfm', 'fa-lastfm-square' => 'Lastfm square', 'fa-leaf' => 'Leaf', 'fa-leanpub' => 'Leanpub', 'fa-lemon-o' => 'Lemon o', 'fa-level-down' => 'Level down', 'fa-level-up' => 'Level up', 'fa-life-ring' => 'Life ring', 'fa-lightbulb-o' => 'Lightbulb o', 'fa-line-chart' => 'Line chart', 'fa-link' => 'Link', 'fa-linkedin' => 'Linkedin', 'fa-linkedin-square' => 'Linkedin square', 'fa-linux' => 'Linux', 'fa-list' => 'List', 'fa-list-alt' => 'List alt', 'fa-list-ol' => 'List ol', 'fa-list-ul' => 'List ul', 'fa-location-arrow' => 'Location arrow', 'fa-lock' => 'Lock', 'fa-long-arrow-down' => 'Long arrow down', 'fa-long-arrow-left' => 'Long arrow left', 'fa-long-arrow-right' => 'Long arrow right', 'fa-long-arrow-up' => 'Long arrow up', 'fa-magic' => 'Magic', 'fa-magnet' => 'Magnet', 'fa-male' => 'Male', 'fa-map' => 'Map', 'fa-map-marker' => 'Map marker', 'fa-map-o' => 'Map o', 'fa-map-pin' => 'Map pin', 'fa-map-signs' => 'Map signs', 'fa-mars' => 'Mars', 'fa-mars-double' => 'Mars double', 'fa-mars-stroke' => 'Mars stroke', 'fa-mars-stroke-h' => 'Mars stroke h', 'fa-mars-stroke-v' => 'Mars stroke v', 'fa-maxcdn' => 'Maxcdn', 'fa-meanpath' => 'Meanpath', 'fa-medium' => 'Medium', 'fa-medkit' => 'Medkit', 'fa-meh-o' => 'Meh o', 'fa-mercury' => 'Mercury', 'fa-microphone' => 'Microphone', 'fa-microphone-slash' => 'Microphone slash', 'fa-minus' => 'Minus', 'fa-minus-circle' => 'Minus circle', 'fa-minus-square' => 'Minus square', 'fa-minus-square-o' => 'Minus square o', 'fa-mobile' => 'Mobile', 'fa-money' => 'Money', 'fa-moon-o' => 'Moon o', 'fa-motorcycle' => 'Motorcycle', 'fa-mouse-pointer' => 'Mouse pointer', 'fa-music' => 'Music', 'fa-neuter' => 'Neuter', 'fa-newspaper-o' => 'Newspaper o', 'fa-object-group' => 'Object group', 'fa-object-ungroup' => 'Object ungroup', 'fa-odnoklassniki' => 'Odnoklassniki', 'fa-odnoklassniki-square' => 'Odnoklassniki square', 'fa-opencart' => 'Opencart', 'fa-openid' => 'Openid', 'fa-opera' => 'Opera', 'fa-optin-monster' => 'Optin monster', 'fa-outdent' => 'Outdent', 'fa-pagelines' => 'Pagelines', 'fa-paint-brush' => 'Paint brush', 'fa-paper-plane' => 'Paper plane', 'fa-paper-plane-o' => 'Paper plane o', 'fa-paperclip' => 'Paperclip', 'fa-paragraph' => 'Paragraph', 'fa-pause' => 'Pause', 'fa-paw' => 'Paw', 'fa-paypal' => 'Paypal', 'fa-pencil' => 'Pencil', 'fa-pencil-square' => 'Pencil square', 'fa-pencil-square-o' => 'Pencil square o', 'fa-phone' => 'Phone', 'fa-phone-square' => 'Phone square', 'fa-picture-o' => 'Picture o', 'fa-pie-chart' => 'Pie chart', 'fa-pied-piper' => 'Pied piper', 'fa-pied-piper-alt' => 'Pied piper alt', 'fa-pinterest' => 'Pinterest', 'fa-pinterest-p' => 'Pinterest p', 'fa-pinterest-square' => 'Pinterest square', 'fa-plane' => 'Plane', 'fa-play' => 'Play', 'fa-play-circle' => 'Play circle', 'fa-play-circle-o' => 'Play circle o', 'fa-plug' => 'Plug', 'fa-plus' => 'Plus', 'fa-plus-circle' => 'Plus circle', 'fa-plus-square' => 'Plus square', 'fa-plus-square-o' => 'Plus square o', 'fa-power-off' => 'Power off', 'fa-print' => 'Print', 'fa-puzzle-piece' => 'Puzzle piece', 'fa-qq' => 'Qq', 'fa-qrcode' => 'Qrcode', 'fa-question' => 'Question', 'fa-question-circle' => 'Question circle', 'fa-quote-left' => 'Quote left', 'fa-quote-right' => 'Quote right', 'fa-random' => 'Random', 'fa-rebel' => 'Rebel', 'fa-recycle' => 'Recycle', 'fa-reddit' => 'Reddit', 'fa-reddit-square' => 'Reddit square', 'fa-refresh' => 'Refresh', 'fa-registered' => 'Registered', 'fa-renren' => 'Renren', 'fa-repeat' => 'Repeat', 'fa-reply' => 'Reply', 'fa-reply-all' => 'Reply all', 'fa-retweet' => 'Retweet', 'fa-road' => 'Road', 'fa-rocket' => 'Rocket', 'fa-rss' => 'Rss', 'fa-rss-square' => 'Rss square', 'fa-rub' => 'Rub', 'fa-safari' => 'Safari', 'fa-scissors' => 'Scissors', 'fa-search' => 'Search', 'fa-search-minus' => 'Search minus', 'fa-search-plus' => 'Search plus', 'fa-sellsy' => 'Sellsy', 'fa-server' => 'Server', 'fa-share' => 'Share', 'fa-share-alt' => 'Share alt', 'fa-share-alt-square' => 'Share alt square', 'fa-share-square' => 'Share square', 'fa-share-square-o' => 'Share square o', 'fa-shield' => 'Shield', 'fa-ship' => 'Ship', 'fa-shirtsinbulk' => 'Shirtsinbulk', 'fa-shopping-cart' => 'Shopping cart', 'fa-sign-in' => 'Sign in', 'fa-sign-out' => 'Sign out', 'fa-signal' => 'Signal', 'fa-simplybuilt' => 'Simplybuilt', 'fa-sitemap' => 'Sitemap', 'fa-skyatlas' => 'Skyatlas', 'fa-skype' => 'Skype', 'fa-slack' => 'Slack', 'fa-sliders' => 'Sliders', 'fa-slideshare' => 'Slideshare', 'fa-smile-o' => 'Smile o', 'fa-sort' => 'Sort', 'fa-sort-alpha-asc' => 'Sort alpha asc', 'fa-sort-alpha-desc' => 'Sort alpha desc', 'fa-sort-amount-asc' => 'Sort amount asc', 'fa-sort-amount-desc' => 'Sort amount desc', 'fa-sort-asc' => 'Sort asc', 'fa-sort-desc' => 'Sort desc', 'fa-sort-numeric-asc' => 'Sort numeric asc', 'fa-sort-numeric-desc' => 'Sort numeric desc', 'fa-soundcloud' => 'Soundcloud', 'fa-space-shuttle' => 'Space shuttle', 'fa-spinner' => 'Spinner', 'fa-spoon' => 'Spoon', 'fa-spotify' => 'Spotify', 'fa-square' => 'Square', 'fa-square-o' => 'Square o', 'fa-stack-exchange' => 'Stack exchange', 'fa-stack-overflow' => 'Stack overflow', 'fa-star' => 'Star', 'fa-star-half' => 'Star half', 'fa-star-half-o' => 'Star half o', 'fa-star-o' => 'Star o', 'fa-steam' => 'Steam', 'fa-steam-square' => 'Steam square', 'fa-step-backward' => 'Step backward', 'fa-step-forward' => 'Step forward', 'fa-stethoscope' => 'Stethoscope', 'fa-sticky-note' => 'Sticky note', 'fa-sticky-note-o' => 'Sticky note o', 'fa-stop' => 'Stop', 'fa-street-view' => 'Street view', 'fa-strikethrough' => 'Strikethrough', 'fa-stumbleupon' => 'Stumbleupon', 'fa-stumbleupon-circle' => 'Stumbleupon circle', 'fa-subscript' => 'Subscript', 'fa-subway' => 'Subway', 'fa-suitcase' => 'Suitcase', 'fa-sun-o' => 'Sun o', 'fa-superscript' => 'Superscript', 'fa-table' => 'Table', 'fa-tablet' => 'Tablet', 'fa-tachometer' => 'Tachometer', 'fa-tag' => 'Tag', 'fa-tags' => 'Tags', 'fa-tasks' => 'Tasks', 'fa-taxi' => 'Taxi', 'fa-television' => 'Television', 'fa-tencent-weibo' => 'Tencent weibo', 'fa-terminal' => 'Terminal', 'fa-text-height' => 'Text height', 'fa-text-width' => 'Text width', 'fa-th' => 'Th', 'fa-th-large' => 'Th large', 'fa-th-list' => 'Th list', 'fa-thumb-tack' => 'Thumb tack', 'fa-thumbs-down' => 'Thumbs down', 'fa-thumbs-o-down' => 'Thumbs o down', 'fa-thumbs-o-up' => 'Thumbs o up', 'fa-thumbs-up' => 'Thumbs up', 'fa-ticket' => 'Ticket', 'fa-times' => 'Times', 'fa-times-circle' => 'Times circle', 'fa-times-circle-o' => 'Times circle o', 'fa-tint' => 'Tint', 'fa-toggle-off' => 'Toggle off', 'fa-toggle-on' => 'Toggle on', 'fa-trademark' => 'Trademark', 'fa-train' => 'Train', 'fa-transgender' => 'Transgender', 'fa-transgender-alt' => 'Transgender alt', 'fa-trash' => 'Trash', 'fa-trash-o' => 'Trash o', 'fa-tree' => 'Tree', 'fa-trello' => 'Trello', 'fa-tripadvisor' => 'Tripadvisor', 'fa-trophy' => 'Trophy', 'fa-truck' => 'Truck', 'fa-try' => 'Try', 'fa-tty' => 'Tty', 'fa-tumblr' => 'Tumblr', 'fa-tumblr-square' => 'Tumblr square', 'fa-twitch' => 'Twitch', 'fa-twitter' => 'Twitter', 'fa-twitter-square' => 'Twitter square', 'fa-umbrella' => 'Umbrella', 'fa-underline' => 'Underline', 'fa-undo' => 'Undo', 'fa-university' => 'University', 'fa-unlock' => 'Unlock', 'fa-unlock-alt' => 'Unlock alt', 'fa-upload' => 'Upload', 'fa-usd' => 'Usd', 'fa-user' => 'User', 'fa-user-md' => 'User md', 'fa-user-plus' => 'User plus', 'fa-user-secret' => 'User secret', 'fa-user-times' => 'User times', 'fa-users' => 'Users', 'fa-venus' => 'Venus', 'fa-venus-double' => 'Venus double', 'fa-venus-mars' => 'Venus mars', 'fa-viacoin' => 'Viacoin', 'fa-video-camera' => 'Video camera', 'fa-vimeo' => 'Vimeo', 'fa-vimeo-square' => 'Vimeo square', 'fa-vine' => 'Vine', 'fa-vk' => 'Vk', 'fa-volume-down' => 'Volume down', 'fa-volume-off' => 'Volume off', 'fa-volume-up' => 'Volume up', 'fa-weibo' => 'Weibo', 'fa-weixin' => 'Weixin', 'fa-whatsapp' => 'Whatsapp', 'fa-wheelchair' => 'Wheelchair', 'fa-wifi' => 'Wifi', 'fa-wikipedia-w' => 'Wikipedia w', 'fa-windows' => 'Windows', 'fa-wordpress' => 'Wordpress', 'fa-wrench' => 'Wrench', 'fa-xing' => 'Xing', 'fa-xing-square' => 'Xing square', 'fa-y-combinator' => 'Y combinator', 'fa-yahoo' => 'Yahoo', 'fa-yelp' => 'Yelp', 'fa-youtube' => 'Youtube', 'fa-youtube-play' => 'Youtube play', 'fa-youtube-square' => 'Youtube square', );

        return apply_filters('ct_font_awesome', $font_awesome_icons);
    }

    /*--------------------------------------*/
    /* Google Fonts
    /*--------------------------------------*/

    function ct_get_fonts() {
        
        //define array
        $custom_fonts = array( 'Abel' => 'Abel','Abril Fatface' => 'Abril Fatface','Aclonica' => 'Aclonica','Actor' => 'Actor','Adamina' => 'Adamina','Aguafina Script' => 'Aguafina Script','Aladin' => 'Aladin','Aldrich' => 'Aldrich','Alice' => 'Alice','Alike Angular' => 'Alike Angular','Alike' => 'Alike','Allan' => 'Allan','Allerta Stencil' => 'Allerta Stencil','Allerta' => 'Allerta','Amaranth' => 'Amaranth','Amatic SC' => 'Amatic SC','Andada' => 'Andada','Andika' => 'Andika','Annie Use Your Telescope' => 'Annie Use Your Telescope','Anonymous Pro' => 'Anonymous Pro','Antic' => 'Antic','Anton' => 'Anton','Arapey' => 'Arapey','Architects Daughter' => 'Architects Daughter','Arimo' => 'Arimo','Artifika' => 'Artifika','Arvo' => 'Arvo','Asset' => 'Asset','Astloch' => 'Astloch','Atomic Age' => 'Atomic Age','Aubrey' => 'Aubrey','Bangers' => 'Bangers','Bentham' => 'Bentham','Bevan' => 'Bevan','Bigshot One' => 'Bigshot One','Bitter' => 'Bitter','Black Ops One' => 'Black Ops One','Bowlby One SC' => 'Bowlby One SC','Bowlby One' => 'Bowlby One','Brawler' => 'Brawler','Bubblegum Sans' => 'Bubblegum Sans','Buda' => 'Buda','Butcherman Caps' => 'Butcherman Caps','Cabin Condensed' => 'Cabin Condensed','Cabin Sketch' => 'Cabin Sketch','Cabin' => 'Cabin','Cagliostro' => 'Cagliostro','Calligraffitti' => 'Calligraffitti','Candal' => 'Candal','Cantarell' => 'Cantarell','Cardo' => 'Cardo','Carme' => 'Carme','Carter One' => 'Carter One','Caudex' => 'Caudex','Cedarville' => 'Cedarville','Changa One' => 'Changa One','Cherry Cream Soda' => 'Cherry Cream Soda','Chewy' => 'Chewy','Chicle' => 'Chicle','Chivo' => 'Chivo','Coda Caption' => 'Coda Caption','Coda' => 'Coda','Comfortaa' => 'Comfortaa','Coming Soon' => 'Coming Soon','Contrail One' => 'Contrail One','Convergence' => 'Convergence','Cookie' => 'Cookie','Copse' => 'Copse','Corben' => 'Corben','Cousine' => 'Cousine','Coustard' => 'Coustard','Covered By Your Grace' => 'Covered By Your Grace','Crafty Girls' => 'Crafty Girls','Creepster Caps' => 'Creepster Caps','Crimson Text' => 'Crimson Text','Crushed' => 'Crushed','Cuprum' => 'Cuprum','Damion' => 'Damion','Dancing Script' => 'Dancing Script','Dawning of a New Day' => 'Dawning of a New Day','Days One' => 'Days One','Delius Swash Caps' => 'Delius Swash Caps','Delius Unicase' => 'Delius Unicase','Delius' => 'Delius','Devonshire' => 'Devonshire','Didact Gothic' => 'Didact Gothic','Dorsa' => 'Dorsa','Dr Sugiyama' => 'Dr Sugiyama','Droid Sans Mono' => 'Droid Sans Mono','Droid Sans' => 'Droid Sans','Droid Serif' => 'Droid Serif','EB Garamond' => 'EB Garamond','Eater Caps' => 'Eater Caps','Expletus Sans' => 'Expletus Sans','Fanwood Text' => 'Fanwood Text','Federant' => 'Federant','Federo' => 'Federo','Fjord One' => 'Fjord One','Fondamento' => 'Fondamento','Fontdiner Swanky' => 'Fontdiner Swanky','Forum' => 'Forum','Francois One' => 'Francois One','Gentium Basic' => 'Gentium Basic','Gentium Book Basic' => 'Gentium Book Basic','Geo' => 'Geo','Geostar Fill' => 'Geostar Fill','Geostar' => 'Geostar','Give You Glory' => 'Give You Glory','Gloria Hallelujah' => 'Gloria Hallelujah','Goblin One' => 'Goblin One','Gochi Hand' => 'Gochi Hand','Goudy Bookletter 1911' => 'Goudy Bookletter 1911','Gravitas One' => 'Gravitas One','Gruppo' => 'Gruppo','Hammersmith One' => 'Hammersmith One','Herr Von Muellerhoff' => 'Herr Von Muellerhoff','Holtwood One SC' => 'Holtwood One SC','Homemade Apple' => 'Homemade Apple','IM Fell DW Pica SC' => 'IM Fell DW Pica SC','IM Fell DW Pica' => 'IM Fell DW Pica','IM Fell Double Pica SC' => 'IM Fell Double Pica SC','IM Fell Double Pica' => 'IM Fell Double Pica','IM Fell English SC' => 'IM Fell English SC','IM Fell English' => 'IM Fell English','IM Fell French Canon SC' => 'IM Fell French Canon SC','IM Fell French Canon' => 'IM Fell French Canon','IM Fell Great Primer SC' => 'IM Fell Great Primer SC','IM Fell Great Primer' => 'IM Fell Great Primer','Iceland' => 'Iceland','Inconsolata' => 'Inconsolata','Indie Flower' => 'Indie Flower','Irish Grover' => 'Irish Grover','Istok Web' => 'Istok Web','Jockey One' => 'Jockey One','Josefin Sans' => 'Josefin Sans','Josefin Slab' => 'Josefin Slab','Judson' => 'Judson','Julee' => 'Julee','Jura' => 'Jura','Just Another Hand' => 'Just Another Hand','Just Me Again Down Here' => 'Just Me Again Down Here','Kameron' => 'Kameron','Kelly Slab' => 'Kelly Slab','Kenia' => 'Kenia','Knewave' => 'Knewave','Kranky' => 'Kranky','Kreon' => 'Kreon','Kristi' => 'Kristi','La Belle Aurore' => 'La Belle Aurore','Lancelot' => 'Lancelot','Lato' => 'Lato','League Script' => 'League Script','Leckerli One' => 'Leckerli One','Lekton' => 'Lekton','Lemon' => 'Lemon','Limelight' => 'Limelight','Linden Hill' => 'Linden Hill','Lobster Two' => 'Lobster Two','Lobster' => 'Lobster','Lora' => 'Lora','Love Ya Like A Sister' => 'Love Ya Like A Sister','Loved by the King' => 'Loved by the King','Luckiest Guy' => 'Luckiest Guy','Maiden Orange' => 'Maiden Orange','Mako' => 'Mako','Marck Script' => 'Marck Script','Marvel' => 'Marvel','Mate SC' => 'Mate SC','Mate' => 'Mate','Maven Pro' => 'Maven Pro','Meddon' => 'Meddon','MedievalSharp' => 'MedievalSharp','Megrim' => 'Megrim','Merienda One' => 'Merienda One','Merriweather' => 'Merriweather','Metrophobic' => 'Metrophobic','Michroma' => 'Michroma','Miltonian Tattoo' => 'Miltonian Tattoo','Miltonian' => 'Miltonian','Miss Fajardose' => 'Miss Fajardose','Miss Saint Delafield' => 'Miss Saint Delafield','Modern Antiqua' => 'Modern Antiqua','Molengo' => 'Molengo','Monofett' => 'Monofett','Monoton' => 'Monoton','Monsieur La Doulaise' => 'Monsieur La Doulaise','Montez' => 'Montez','Montserrat' => 'Montserrat','Mountains of Christmas' => 'Mountains of Christmas','Mr Bedford' => 'Mr Bedford','Mr Dafoe' => 'Mr Dafoe','Mr De Haviland' => 'Mr De Haviland','Mrs Sheppards' => 'Mrs Sheppards','Muli' => 'Muli','Neucha' => 'Neucha','Neuton' => 'Neuton','News Cycle' => 'News Cycle','Niconne' => 'Niconne','Nixie One' => 'Nixie One','Nobile' => 'Nobile','Nosifer Caps' => 'Nosifer Caps','Nothing You Could Do' => 'Nothing You Could Do','Nova Cut' => 'Nova Cut','Nova Flat' => 'Nova Flat','Nova Mono' => 'Nova Mono','Nova Oval' => 'Nova Oval','Nova Round' => 'Nova Round','Nova Script' => 'Nova Script','Nova Slim' => 'Nova Slim','Nova Square' => 'Nova Square','Numans' => 'Numans','Nunito' => 'Nunito','Old Standard TT' => 'Old Standard TT','Open Sans Condensed' => 'Open Sans Condensed','Open Sans' => 'Open Sans','Orbitron' => 'Orbitron','Oswald' => 'Oswald','Over the Rainbow' => 'Over the Rainbow','Ovo' => 'Ovo','PT Sans Caption' => 'PT Sans Caption','PT Sans Narrow' => 'PT Sans Narrow','PT Sans' => 'PT Sans','PT Serif Caption' => 'PT Serif Caption','PT Serif' => 'PT Serif','Pacifico' => 'Pacifico','Passero One' => 'Passero One','Patrick Hand' => 'Patrick Hand','Paytone One' => 'Paytone One','Permanent Marker' => 'Permanent Marker','Petrona' => 'Petrona','Philosopher' => 'Philosopher','Piedra' => 'Piedra','Pinyon Script' => 'Pinyon Script','Play' => 'Play','Playfair Display' => 'Playfair Display','Podkova' => 'Podkova','Poller One' => 'Poller One','Poly' => 'Poly','Pompiere' => 'Pompiere','Prata' => 'Prata','Prociono' => 'Prociono','Puritan' => 'Puritan','Quattrocento Sans' => 'Quattrocento Sans','Quattrocento' => 'Quattrocento','Questrial' => 'Questrial','Quicksand' => 'Quicksand','Radley' => 'Radley','Raleway' => 'Raleway','Rammetto One' => 'Rammetto One','Rancho' => 'Rancho','Rationale' => 'Rationale','Redressed' => 'Redressed','Reenie Beanie' => 'Reenie Beanie','Ribeye Marrow' => 'Ribeye Marrow','Ribeye' => 'Ribeye','Righteous' => 'Righteous','Rochester' => 'Rochester','Rock Salt' => 'Rock Salt','Rokkitt' => 'Rokkitt','Rosario' => 'Rosario','Ruslan Display' => 'Ruslan Display','Salsa' => 'Salsa','Sancreek' => 'Sancreek','Sansita One' => 'Sansita One','Satisfy' => 'Satisfy','Schoolbell' => 'Schoolbell','Shadows Into Light' => 'Shadows Into Light','Shanti' => 'Shanti','Short Stack' => 'Short Stack','Sigmar One' => 'Sigmar One','Signika Negative' => 'Signika Negative','Signika' => 'Signika','Six Caps' => 'Six Caps','Slackey' => 'Slackey','Smokum' => 'Smokum','Smythe' => 'Smythe','Sniglet' => 'Sniglet','Snippet' => 'Snippet','Sorts Mill Goudy' => 'Sorts Mill Goudy','Source Sans Pro' => 'Source Sans Pro','Special Elite' => 'Special Elite','Spinnaker' => 'Spinnaker','Spirax' => 'Spirax','Stardos Stencil' => 'Stardos Stencil','Sue Ellen Francisco' => 'Sue Ellen Francisco','Sunshiney' => 'Sunshiney','Supermercado One' => 'Supermercado One','Swanky and Moo Moo' => 'Swanky and Moo Moo','Syncopate' => 'Syncopate','Tangerine' => 'Tangerine','Tenor Sans' => 'Tenor Sans','Terminal Dosis' => 'Terminal Dosis','The Girl Next Door' => 'The Girl Next Door','Tienne' => 'Tienne','Tinos' => 'Tinos','Tulpen One' => 'Tulpen One','Ubuntu Condensed' => 'Ubuntu Condensed','Ubuntu Mono' => 'Ubuntu Mono','Ubuntu' => 'Ubuntu','Ultra' => 'Ultra','UnifrakturCook' => 'UnifrakturCook','UnifrakturMaguntia' => 'UnifrakturMaguntia','Unkempt' => 'Unkempt','Unlock' => 'Unlock','Unna' => 'Unna','VT323' => 'VT323','Varela Round' => 'Varela Round','Varela' => 'Varela','Vast Shadow' => 'Vast Shadow','Vibur' => 'Vibur','Vidaloka' => 'Vidaloka','Volkhov' => 'Volkhov','Vollkorn' => 'Vollkorn','Voltaire' => 'Voltaire','Waiting for the Sunrise' => 'Waiting for the Sunrise','Wallpoet' => 'Wallpoet','Walter Turncoat' => 'Walter Turncoat','Wire One' => 'Wire One','Yanone Kaffeesatz' => 'Yanone Kaffeesatz','Yellowtail' => 'Yellowtail','Yeseva One' => 'Yeseva One','Zeyada' => 'Zeyada');
        
        //return array
        return apply_filters('ct_get_fonts', $custom_fonts);

    }

    /*--------------------------------------*/
    /* Currency Codes
    /*--------------------------------------*/

    function ct_currency_codes_w_symbol() {
        $ct_currency_codes_w_symbol = array(
            'AED'=> array('United Arab Emirates Dirham', 'hex'=>'&#x62f;'),
            'ANG'=> array('NL Antillian Guilder', 'hex'=>'&#x192;'),
            'ARS'=> array('Argentine Peso', 'hex'=>'&#x24;'),
            'AUD'=> array('Australian Dollar', 'hex'=>'&#x41;&#x24;'),
            'BRL'=> array('Brazilian Real', 'hex'=>'&#x52;&#x24;'),
            'BSD'=> array('Bahamian Dollar', 'hex'=>'&#x42;&#x24;'),
            'CAD'=> array('Canadian Dollar', 'hex'=>'&#x24;'),
            'CHF'=> array('Swiss Franc', 'hex'=>'&#x43;&#x48;&#x46;'),
            'CLP'=> array('Chilean Peso', 'hex'=>'&#x24;'),
            'CNY'=> array('Chinese Yuan Renminbi', 'hex'=>'&#xa5;'),
            'COP'=> array('Colombian Peso', 'hex'=>'&#x24;'),
            'CZK'=> array('Czech Koruna', 'hex'=>'&#x4b;&#x10d;'),
            'DKK'=> array('Danish Krone', 'hex'=>'&#x6b;&#x72;'),
            'EUR'=> array('Euro', 'hex'=>'&#x20ac;'),
            'FJD'=> array('Fiji Dollar', 'hex'=>'&#x46;&#x4a;&#x24;'),
            'GBP'=> array('British Pound', 'hex'=>'&#xa3;'),
            'GHS'=> array('Ghanaian New Cedi', 'hex'=>'&#x47;&#x48;&#x20b5;'),
            'GTQ'=> array('Guatemalan Quetzal', 'hex'=>'&#x51;'),
            'HKD'=> array('Hong Kong Dollar', 'hex'=>'&#x24;'),
            'HNL'=> array('Honduran Lempira', 'hex'=>'&#x4c;'),
            'HRK'=> array('Croatian Kuna', 'hex'=>'&#x6b;&#x6e;'),
            'HUF'=> array('Hungarian Forint', 'hex'=>'&#x46;&#x74;'),
            'IDR'=> array('Indonesian Rupiah', 'hex'=>'&#x52;&#x70;'),
            'ILS'=> array('Israeli New Shekel', 'hex'=>'&#x20aa;'),
            'INR'=> array('Indian Rupee', 'hex'=>'&#x20b9;'),
            'ISK'=> array('Iceland Krona', 'hex'=>'&#x6b;&#x72;'),
            'JMD'=> array('Jamaican Dollar', 'hex'=>'&#x4a;&#x24;'),
            'JPY'=> array('Japanese Yen', 'hex'=>'&#xa5;'),
            'KRW'=> array('South-Korean Won', 'hex'=>'&#x20a9;'),
            'LKR'=> array('Sri Lanka Rupee', 'hex'=>'&#x20a8;'),
            'MAD'=> array('Moroccan Dirham', 'hex'=>'&#x2e;&#x62f;&#x2e;&#x645;'),
            'MMK'=> array('Myanmar Kyat', 'hex'=>'&#x4b;'),
            'MXN'=> array('Mexican Peso', 'hex'=>'&#x24;'),
            'MYR'=> array('Malaysian Ringgit', 'hex'=>'&#x52;&#x4d;'),
            'NOK'=> array('Norwegian Kroner', 'hex'=>'&#x6b;&#x72;'),
            'NZD'=> array('New Zealand Dollar', 'hex'=>'&#x24;'),
            'PAB'=> array('Panamanian Balboa', 'hex'=>'&#x42;&#x2f;&#x2e;'),
            'PEN'=> array('Peruvian Nuevo Sol', 'hex'=>'&#x53;&#x2f;&#x2e;'),
            'PHP'=> array('Philippine Peso', 'hex'=>'&#x20b1;'),
            'PKR'=> array('Pakistan Rupee', 'hex'=>'&#x20a8;'),
            'PLN'=> array('Polish Zloty', 'hex'=>'&#x7a;&#x142;'),
            'RON'=> array('Romanian New Lei', 'hex'=>'&#x6c;&#x65;&#x69;'),
            'RSD'=> array('Serbian Dinar', 'hex'=>'&#x52;&#x53;&#x44;'),
            'RUB'=> array('Russian Rouble', 'hex'=>'&#x440;&#x443;&#x431;'),
            'SEK'=> array('Swedish Krona', 'hex'=>'&#x6b;&#x72;'),
            'SGD'=> array('Singapore Dollar', 'hex'=>'&#x53;&#x24;'),
            'THB'=> array('Thai Baht', 'hex'=>'&#xe3f;'),
            'TND'=> array('Tunisian Dinar', 'hex'=>'&#x44;&#x54;'),
            'TRY'=> array('Turkish Lira', 'hex'=>'&#x54;&#x4c;'),
            'TTD'=> array('Trinidad/Tobago Dollar', 'hex'=>'&#x24;'),
            'TWD'=> array('Taiwan Dollar', 'hex'=>'&#x4e;&#x54;&#x24;'),
            'USD'=> array('US Dollar', 'symbol'=>'$', 'hex'=>'&#x24;'),
            'VEF'=> array('Venezuelan Bolivar Fuerte', 'hex'=>'&#x42;&#x73;'),
            'VND'=> array('Vietnamese Dong', 'hex'=>'&#x20ab;'),
            'XAF'=> array('CFA Franc BEAC', 'hex'=>'&#x46;&#x43;&#x46;&#x41;'),
            'XCD'=> array('East Caribbean Dollar', 'hex'=>'&#x24;'),
            'XPF'=> array('CFP Franc', 'hex'=>'&#x46;'),
            'ZAR'=> array('South African Rand', 'hex'=>'&#x52;')
        );
        //return array
        return apply_filters('ct_currency_codes_w_symbol', $ct_currency_codes_w_symbol);
    }

    /*--------------------------------------*/
    /* Country Codes
    /*--------------------------------------*/

    function ct_country_codes() {

        $ct_countries = array(
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua And Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia And Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros',
            'CG' => 'Congo',
            'CD' => 'Congo, Democratic Republic',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote D\'Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FK' => 'Falkland Islands (Malvinas)',
            'FO' => 'Faroe Islands',
            'FJ' => 'Fiji',
            'FI' => 'Finland',
            'FR' => 'France',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island & Mcdonald Islands',
            'VA' => 'Holy See (Vatican City State)',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran, Islamic Republic Of',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle Of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => 'Lao People\'s Democratic Republic',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libyan Arab Jamahiriya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia, Federated States Of',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NL' => 'Netherlands',
            'AN' => 'Netherlands Antilles',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory, Occupied',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts And Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre And Miquelon',
            'VC' => 'Saint Vincent And Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome And Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia And Sandwich Isl.',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard And Jan Mayen',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad And Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks And Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'UM' => 'United States Outlying Islands',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Viet Nam',
            'VG' => 'Virgin Islands, British',
            'VI' => 'Virgin Islands, U.S.',
            'WF' => 'Wallis And Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe',
        );
        //return array
        return apply_filters('ct_country_codes', $ct_countries);
    }

    /*--------------------------------------*/
    /* Country Codes
    /*--------------------------------------*/

    function ct_currency_codes() {

        $ct_currency_codes = array (
            'ALL' => 'Albania Lek',
            'AFN' => 'Afghanistan Afghani',
            'ARS' => 'Argentina Peso',
            'AWG' => 'Aruba Guilder',
            'AUD' => 'Australia Dollar',
            'AZN' => 'Azerbaijan New Manat',
            'BSD' => 'Bahamas Dollar',
            'BBD' => 'Barbados Dollar',
            'BDT' => 'Bangladeshi taka',
            'BYR' => 'Belarus Ruble',
            'BZD' => 'Belize Dollar',
            'BMD' => 'Bermuda Dollar',
            'BOB' => 'Bolivia Boliviano',
            'BAM' => 'Bosnia and Herzegovina Convertible Marka',
            'BWP' => 'Botswana Pula',
            'BGN' => 'Bulgaria Lev',
            'BRL' => 'Brazil Real',
            'BND' => 'Brunei Darussalam Dollar',
            'KHR' => 'Cambodia Riel',
            'CAD' => 'Canada Dollar',
            'KYD' => 'Cayman Islands Dollar',
            'CLP' => 'Chile Peso',
            'CNY' => 'China Yuan Renminbi',
            'COP' => 'Colombia Peso',
            'CRC' => 'Costa Rica Colon',
            'HRK' => 'Croatia Kuna',
            'CUP' => 'Cuba Peso',
            'CZK' => 'Czech Republic Koruna',
            'DKK' => 'Denmark Krone',
            'DOP' => 'Dominican Republic Peso',
            'XCD' => 'East Caribbean Dollar',
            'EGP' => 'Egypt Pound',
            'SVC' => 'El Salvador Colon',
            'EUR' => 'Euro Member Countries',
            'FKP' => 'Falkland Islands (Malvinas) Pound',
            'FJD' => 'Fiji Dollar',
            'GHC' => 'Ghana Cedis',
            'GIP' => 'Gibraltar Pound',
            'GTQ' => 'Guatemala Quetzal',
            'GGP' => 'Guernsey Pound',
            'GYD' => 'Guyana Dollar',
            'HNL' => 'Honduras Lempira',
            'HKD' => 'Hong Kong Dollar',
            'HUF' => 'Hungary Forint',
            'ISK' => 'Iceland Krona',
            'INR' => 'India Rupee',
            'IDR' => 'Indonesia Rupiah',
            'IRR' => 'Iran Rial',
            'IMP' => 'Isle of Man Pound',
            'ILS' => 'Israel Shekel',
            'JMD' => 'Jamaica Dollar',
            'JPY' => 'Japan Yen',
            'JEP' => 'Jersey Pound',
            'KZT' => 'Kazakhstan Tenge',
            'KPW' => 'Korea (North) Won',
            'KRW' => 'Korea (South) Won',
            'KGS' => 'Kyrgyzstan Som',
            'LAK' => 'Laos Kip',
            'LBP' => 'Lebanon Pound',
            'LRD' => 'Liberia Dollar',
            'MKD' => 'Macedonia Denar',
            'MYR' => 'Malaysia Ringgit',
            'MUR' => 'Mauritius Rupee',
            'MXN' => 'Mexico Peso',
            'MNT' => 'Mongolia Tughrik',
            'MZN' => 'Mozambique Metical',
            'NAD' => 'Namibia Dollar',
            'NPR' => 'Nepal Rupee',
            'ANG' => 'Netherlands Antilles Guilder',
            'NZD' => 'New Zealand Dollar',
            'NIO' => 'Nicaragua Cordoba',
            'NGN' => 'Nigeria Naira',
            'NOK' => 'Norway Krone',
            'OMR' => 'Oman Rial',
            'PKR' => 'Pakistan Rupee',
            'PAB' => 'Panama Balboa',
            'PYG' => 'Paraguay Guarani',
            'PEN' => 'Peru Nuevo Sol',
            'PHP' => 'Philippines Peso',
            'PLN' => 'Poland Zloty',
            'QAR' => 'Qatar Riyal',
            'RON' => 'Romania New Leu',
            'RUB' => 'Russia Ruble',
            'SHP' => 'Saint Helena Pound',
            'SAR' => 'Saudi Arabia Riyal',
            'RSD' => 'Serbia Dinar',
            'SCR' => 'Seychelles Rupee',
            'SGD' => 'Singapore Dollar',
            'SBD' => 'Solomon Islands Dollar',
            'SOS' => 'Somalia Shilling',
            'ZAR' => 'South Africa Rand',
            'LKR' => 'Sri Lanka Rupee',
            'SEK' => 'Sweden Krona',
            'CHF' => 'Switzerland Franc',
            'SRD' => 'Suriname Dollar',
            'SYP' => 'Syria Pound',
            'TWD' => 'Taiwan New Dollar',
            'THB' => 'Thailand Baht',
            'TTD' => 'Trinidad and Tobago Dollar',
            'TRY' => 'Turkey Lira',
            'TRL' => 'Turkey Lira',
            'TVD' => 'Tuvalu Dollar',
            'UAH' => 'Ukraine Hryvna',
            'GBP' => 'United Kingdom Pound',
            'UGX' => 'Uganda Shilling',
            'USD' => 'United States Dollar',
            'UYU' => 'Uruguay Peso',
            'UZS' => 'Uzbekistan Som',
            'VEF' => 'Venezuela Bolivar',
            'VND' => 'Viet Nam Dong',
            'YER' => 'Yemen Rial',
            'ZWD' => 'Zimbabwe Dollar'
        );
        //return array
        return apply_filters('ct_currency_codes', $ct_currency_codes);
    }

    // Background Images Reader
    $bg_images_path = get_stylesheet_directory() . '/images/skins/'; // change this to where you store your bg images
    $bg_images_url = get_template_directory_uri() . '/images/skins/'; // change this to where you store your bg images
    $bg_images = array();
    
    if ( is_dir($bg_images_path) ) {
        if ($bg_images_dir = opendir($bg_images_path) ) { 
            while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
                if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
                    $bg_images[] = $bg_images_url . $bg_images_file;
                }
            }    
        }
    }



    // Panel Intro text -> before the form
    //$args['intro_text'] = __( '<p><a href="#">Help &amp; Documentation</a> <a href="#">Changelog</a></p>', 'contempo' );

    // Add content after the form.
    //$args['footer_text'] = __( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'contempo' );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => __( 'Theme Information 1', 'contempo' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'contempo' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => __( 'Theme Information 2', 'contempo' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'contempo' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'contempo' );
    Redux::setHelpSidebar( $opt_name, $content );

    // -> START Basic Fields

    Redux::setSection( $opt_name, array(
        'title'            => __( 'General Settings', 'contempo' ),
        'id'               => 'general-settings',
        'icon'             => 'fa fa-cogs',
        'customizer_width' => '450px',
        'fields'           => array(
            array (
                'desc' => 'Choose if you would like to use the multi-listing or single listing layout mode. Multi is for sites that list multiple listings, Single is useful for a landing page type site featuring one listing on the homepage (no navigation, or other pages are used).',
                'id' => 'ct_mode',
                'type' => 'select',
                'options' => array (
                    'multi-listing' => 'Multi-Listing',
                    'single-listing' => 'Single Listing',
                ),
                'title' => 'Multi-Listing or Single Listing Mode?',
                'default' => 'multi-listing',
            ),
            array (
                'desc' => 'Choose if you would like to a full width or boxed layout.',
                'id' => 'ct_boxed',
                'type' => 'select',
                'options' => array (
                    'full-width' => 'Full Width',
                    'boxed' => 'Boxed',
                ),
                'title' => 'Full Width or Boxed Layout?',
                'default' => 'full-width',
            ),
            array (
                    'desc' => 'Select an alternative font.',
                    'id' => 'ct_heading_font',
                    'type' => 'select',
                    'options' => ct_get_fonts(),
                    'title' => 'Choose a heading font',
                    'default' => 'Montserrat',
                ),
            array (
                'desc' => 'Select an alternative font.',
                'id' => 'ct_body_font',
                'type' => 'select',
                'options' => ct_get_fonts(),
                'title' => 'Choose a body font',
                'default' => 'Lato',
            ),
            array (
                'desc' => 'Choose if you would like to enable RTL layout.',
                'id' => 'ct_rtl',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Enable RTL',
                'default' => 'no',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Header', 'contempo' ),
        'id'               => 'header',
        'icon'             => 'fa fa-columns',
        'customizer_width' => '450px',
        'fields'           => array(
            array (
                'desc' => 'Choose if you would like the header to stick to the top of the browser when a user scrolls your site.',
                'id' => 'ct_sticky_header',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Sticky Header?',
                'default' => 'yes',
            ),
            array (
                'desc' => 'Choose if you would like the header to be transparent this applies to the homepage and normal pages with image header backgrounds.',
                'id' => 'ct_trans_header',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Transparent Header?',
                'default' => 'no',
            ),
            array (
                    //'desc' => 'Select left, center, right logo alignment or none.',
                    'id' => 'ct_header_style',
                    'type' => 'image_select',
                    'options' => array (
                        'one' => get_template_directory_uri() . '/admin/images/header-one.png',
                        'two' => get_template_directory_uri() . '/admin/images/header-two.png',
                        //'right' => get_template_directory_uri() . '/admin/images/header-right.png',
                        //'none' => get_template_directory_uri() . '/admin/images/header-none.png',
                    ),
                    'title' => 'Header Style',
                    'default' => 'left',
            ),
            array (
                    'desc' => 'Select left, center, right logo alignment or none. <strong>NOTE:</strong> This only applies to Header Style One.',
                    'id' => 'ct_header_layout',
                    'type' => 'image_select',
                    'options' => array (
                        'left' => get_template_directory_uri() . '/admin/images/header-left.png',
                        'center' => get_template_directory_uri() . '/admin/images/header-center.png',
                        'right' => get_template_directory_uri() . '/admin/images/header-right.png',
                        'none' => get_template_directory_uri() . '/admin/images/header-none.png',
                    ),
                    'title' => 'Header Layout',
                    'default' => 'left',
            ),
            array (
                'desc' => 'Choose if you would like to enable the header listing search.',
                'id' => 'ct_header_listing_search',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Header Listing Search?',
                'default' => 'no',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Custom Logo', 'contempo' ),
        'id'               => 'custom-logo',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            
            array (
                'desc' => 'Upload a logo, or specify the image address of your online logo. (http://yoursite.com/logo.png)',
                'id' => 'ct_logo',
                'type' => 'media',
                'title' => 'Custom Logo',
                'url' => true,
            ),
            array (
                'desc' => 'Upload a @2x logo for high resolution displays, or specify the image address of your online logo. (http://yoursite.com/logo@2x.png). <a href="http://line25.com/tutorials/how-to-create-retina-graphics-for-your-web-designs">More Information on Creating @2x Images</a>',
                'id' => 'ct_logo_highres',
                'type' => 'media',
                'title' => 'Custom Logo @2x',
                'url' => true,
            ),
            array (
                'desc' => 'Choose if you would like to use the Blog Title in place of an image logo. Text can be setup in WP Settings > General.',
                'id' => 'ct_text_logo',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Use Text Logo?',
                'default' => 'no',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
    'title'            => __( 'Top Bar', 'contempo' ),
    'id'               => 'top-bar',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(

            array (
                'desc' => 'Choose if you would like to display the top bar.',
                'id' => 'ct_top_bar',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Display Top Bar?',
                'default' => 'yes',
            ),
        )
    ) );
    
    Redux::setSection( $opt_name, array(
    'title'            => __( 'Contact Phone', 'contempo' ),
    'id'               => 'contact-phone',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
            array (
                'desc' => 'Enter your Contact Phone Number Here.',
                'id' => 'ct_contact_phone_header',
                'type' => 'text',
                'title' => 'Contact Phone',
                'default' => 'Call Us Today: 1-888-999-5454',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
    'title'            => __( 'Currency Switcher', 'contempo' ),
    'id'               => 'currency-switcher',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
            array (
                'desc' => 'Select whether or not you\'d like to display the currency switcher.',
                'id' => 'ct_header_currency_switcher',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Display Currency Switcher?',
                'default' => 'no',
            ),
            /*array(
                'id'=>'ct_header_currency_switcher_codes',
                'type' => 'select', 
                'multi'    => true,
                //'required' => array('switch-fold','equals','0'),   
                'title' => __('Currency Codes', 'contempo'),
                'desc'  => __('', 'contempo'),
                'default'     => array('USD','EUR','CAD'),
                'options' => ct_currency_codes_w_symbol(),
            ),*/
        )
    ) );

    Redux::setSection( $opt_name, array(
    'title'            => __( 'Social Links', 'contempo' ),
    'id'               => 'social-links',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
            array (
                'desc' => 'Select whether or not you\'d like to display the social links.',
                'id' => 'ct_header_social',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Display Social Links?',
                'default' => 'yes',
            ),
            array (
                'desc' => 'Choose if you would like the social links to open in a new tab.',
                'id' => 'ct_social_new_tab',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Open in New Tab?',
                'default' => 'no',
            ),
            array (
                'desc' => 'Enter your Facebook URL.',
                'id' => 'ct_fb_url',
                'type' => 'text',
                'title' => 'Facebook',
            ),
            array (
                'desc' => 'Enter your Twitter URL.',
                'id' => 'ct_twitter_url',
                'type' => 'text',
                'title' => 'Twitter',
            ),
            array (
                'desc' => 'Enter your LinkedIn URL.',
                'id' => 'ct_linkedin_url',
                'type' => 'text',
                'title' => 'LinkedIn',
            ),
            array (
                'desc' => 'Enter your Google+ URL.',
                'id' => 'ct_googleplus_url',
                'type' => 'text',
                'title' => 'Google+',
            ),
            array (
                'desc' => 'Enter your YouTube URL.',
                'id' => 'ct_youtube_url',
                'type' => 'text',
                'title' => 'YouTube',
            ),
            array (
                'desc' => 'Enter your Dribbble URL.',
                'id' => 'ct_dribbble_url',
                'type' => 'text',
                'title' => 'Dribbble',
            ),
            array (
                'desc' => 'Enter your Pinterest URL.',
                'id' => 'ct_pinterest_url',
                'type' => 'text',
                'title' => 'Pinterest',
            ),
            array (
                'desc' => 'Enter your Instagram URL.',
                'id' => 'ct_instagram_url',
                'type' => 'text',
                'title' => 'Instagram',
            ),
            array (
                'desc' => 'Enter your Github URL.',
                'id' => 'ct_github_url',
                'type' => 'text',
                'title' => 'Github',
            ),
            array (
                'desc' => 'Enter your Contact Page URL.',
                'id' => 'ct_contact_url',
                'type' => 'text',
                'title' => 'Contact Page',
            )
        )
    ) );

    Redux::setSection( $opt_name, array(
    'title'            => __( 'Header Info Columns', 'contempo' ),
    'id'               => 'header-info',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
            $fields = array(
               'id' => 'section-header-info-one',
               'type' => 'section',
               'title' => __('Column One', 'contempo'),
               'subtitle' => __('', 'contempo'),
               //'required' => array('ct_contact_multiple_locations','equals','on'),
               'indent' => true 
            ),
            array (
                'desc' => '',
                'id' => 'ct_header_info_one_title',
                'type' => 'text',
                'title' => 'Title',
                'default' => 'Contact Us',
            ),
            array (
                'desc' => '',
                'id' => 'ct_header_info_one_text',
                'type' => 'text',
                'title' => 'Text',
                'default' => '1-888-555-7896',
            ),
            array(
                'id'=>'ct_header_info_one_icon',
                'type' => 'select', 
                //'required' => array('switch-fold','equals','0'),   
                'title' => __('Icon', 'contempo'),
                'subtitle'  => __('Select an icon.', 'contempo'),
                'default'     => 'fa-phone',
                'options' => ct_font_awesome(),
            ),
            $fields = array(
               'id' => 'section-header-info-two',
               'type' => 'section',
               'title' => __('Column Two', 'contempo'),
               'subtitle' => __('', 'contempo'),
               //'required' => array('ct_contact_multiple_locations','equals','on'),
               'indent' => true 
            ),
            array (
                'desc' => '',
                'id' => 'ct_header_info_two_title',
                'type' => 'text',
                'title' => 'Title',
                'default' => '101 First Ave',
            ),
            array (
                'desc' => '',
                'id' => 'ct_header_info_two_text',
                'type' => 'text',
                'title' => 'Text',
                'default' => 'San Diego, CA',
            ),
            array(
                'id'=>'ct_header_info_two_icon',
                'type' => 'select', 
                //'required' => array('switch-fold','equals','0'),   
                'title' => __('Icon', 'contempo'),
                'subtitle'  => __('Select an icon.', 'contempo'),
                'default'     => 'fa-map-marker',
                'options' => ct_font_awesome(),
            ),
            $fields = array(
               'id' => 'section-header-info-three',
               'type' => 'section',
               'title' => __('Column Three', 'contempo'),
               'subtitle' => __('', 'contempo'),
               //'required' => array('ct_contact_multiple_locations','equals','on'),
               'indent' => true 
            ),
            array (
                'desc' => '',
                'id' => 'ct_header_info_three_title',
                'type' => 'text',
                'title' => 'Title',
                'default' => '8AM-5PM',
            ),
            array (
                'desc' => '',
                'id' => 'ct_header_info_three_text',
                'type' => 'text',
                'title' => 'Text',
                'default' => 'Monday-Friday',
            ),
            array(
                'id'=>'ct_header_info_three_icon',
                'type' => 'select', 
                //'required' => array('switch-fold','equals','0'),   
                'title' => __('Icon', 'contempo'),
                'subtitle'  => __('Select an icon.', 'contempo'),
                'default'     => 'fa-clock-o',
                'options' => ct_font_awesome(),
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Homepage', 'contempo' ),
        'id'               => 'homepage',
        'icon'             => 'fa fa-home',
        'customizer_width' => '450px',
        'fields'           => array(
 
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Layout Manager', 'contempo' ),
        'id'               => 'layout-manager',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(

            array (
                'desc' => 'Drag and drop layout manager, to quickly organize your homepage contents. If you\re using the dsIDXPress plugin you can use the dsIDXpress block to replace the homepage search, this can also be used for IDX plugin although it might require some custom CSS styling to get the form to display properly. Keep in mind that it will only search IDX listings not manually entered listings. If you\'re using the Single Listing layout only the following blocks are available Call to Action, Testimonials, Partners, Page Builder & Page Builder Two.',
                'id' => 'ct_home_layout',
                'type' => 'sorter',
                'title' => 'Layout Manager',
                'options' => array (
                    'disabled' => array (
                        'hero_search' => 'Hero w/Search',
                        'slider' => 'FlexSlider',
                        'builder' => 'Page Builder 1',
                        'page_builder_two' => 'Page Builder 2',
                        'page_builder_three' => 'Page Builder 3',
                        'page_builder_four' => 'Page Builder 4',
                        'map' => 'Featured Map',
                        'dsidxpress_search' => 'IDX Search',
                        'widgets' => 'Four Column Widgets',
                    ),
                    'enabled' => array (
                        'revslider' => 'Revolution Slider',
                        'listings_search' => 'Listings Search',
                        'cta' => 'Call To Action',
                        'featured_listings' => 'Featured Listings',
                        'testimonials' => 'Testimonials',
                        'partners' => 'Partners',
                    ),
                ),
            ),
            
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Advanced Search', 'contempo' ),
        'id'               => 'advanced-search',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(

            array (
                    'desc' => '',
                    'id' => 'ct_home_adv_search_style',
                    'type' => 'image_select',
                    'options' => array (
                        'search-style-one' => get_template_directory_uri() . '/admin/images/search-one.png',
                        'search-style-two' => get_template_directory_uri() . '/admin/images/search-two.png',
                        //'search-style-three' => get_template_directory_uri() . '/admin/images/search-three.png',
                    ),
                    'title' => 'Select a style',
                    'default' => 'search-style-one',
            ),

            array (
                'desc' => 'Enter the title for the advanced search area. Search Style Two looks best when this field is left blank',
                'id' => 'ct_home_adv_search_title',
                'type' => 'text',
                'title' => 'Advanced Search Title',
                'default' => 'Find your new home',
            ),

            array (
                'desc' => 'Drag and drop manager, to quickly organize your homepage advanced search fields.',
                'id' => 'ct_home_adv_search_fields',
                'type' => 'sorter',
                'title' => 'Listings Search Field Manager',
                'options' => array (
                    'disabled' => array (
                        'placebo' => 'placebo',
                        'keyword' => 'Keyword',
                        'additional_features' => 'Additional Features',
                        'country' => 'Country',
                        'community' => 'Community',
                        'mls' => 'Property ID',
                        'numguests' => 'Num of Guests',
                        'sqft_from' => 'Size From',
                        'sqft_to' => 'Size To',
                        'lotsize_from' => 'Lot Size From',
                        'lotsize_to' => 'Lot Size To',
                    ),
                    'enabled' => array (
                        'placebo' => 'placebo',
                        'type' => 'Type',
                        'city' => 'City',
                        'state' => 'State',
                        'zipcode' => 'Zipcode',
                        'beds' => 'Beds',
                        'baths' => 'Baths',
                        'status' => 'Status',
                        'price_from' => 'Price From',
                        'price_to' => 'Price To',
                    ),
                ),
            ),
            array (
                'desc' => 'Select whether or not you\'d like to enable the Advanced Search page which shows all search fields no matter what is chosen above in the layout manager <a href="http://cl.ly/3w091l1B1i0d">Example Screenshot</a>.',
                'id' => 'ct_enable_adv_search_page',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Enable Separate Advanced Search Page?',
                'default' => 'no',
                //'required' => array('ct_walkscore_apikey','!=','')
            ),
            array (
                'desc' => 'Select the page you\'ve created and applied the "Advanced Search" page template to.',
                'id' => 'ct_adv_search_page',
                'type' => 'select',
                'data' => 'pages',
                'title' => 'Advanced Search Page',
                'required' => array('ct_enable_adv_search_page','equals','yes'),
                'default' => '',
            ),
            
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Revolution Slider', 'contempo' ),
        'id'               => 'slider-revolution',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(

            array (
                'desc' => 'If you\'ve enabled the Slider Revolution block above enter your slider alias here (e.g. home)',
                'id' => 'ct_home_rev_slider_alias',
                'type' => 'text',
                'title' => 'Slider Revolution Alias',
            ),
            
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'FlexSlider', 'contempo' ),
        'id'               => 'flexslider-slides',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(

            array (
                'desc' => 'Unlimited slider with drag and drop sorting, supports images or video.',
                'id' => 'ct_flex_slider',
                'type' => 'slides',
                'title' => 'Slides',
                'default' => array (
                    array (
                        'order' => '',
                        'title' => '',
                        'url' => '',
                        'link' => '',
                        'description' => '',
                    ),
                ),
            ),
            
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Hero w/Search', 'contempo' ),
        'id'               => 'hero-search',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(

            array (
                'desc' => 'Upload a background image for the hero search section, or specify the image address of your online image. (http://yoursite.com/some/path/to/background/image.jpg)',
                'id' => 'ct_hero_search_bg',
                'type' => 'media',
                'title' => 'Background Image',
                'url' => true,
            ),

            array (
                'desc' => 'Example: Find Your New Home',
                'id' => 'ct_hero_search_heading',
                'type' => 'text',
                'title' => 'Lead Heading',
            ),
            array (
                'desc' => 'Example: Its just a few clicks away',
                'id' => 'ct_hero_search_sub_heading',
                'type' => 'text',
                'title' => 'Sub Heading',
            ),

            array(
                'id'       => 'ct_hero_search_top_pad',
                'type'     => 'spinner', 
                'title'    => __('Top Padding', 'contempo'),
                //'subtitle' => __('No validation can be done on this field type','redux-framework-demo'),
                'desc'     => __('Set the top padding in percentage.', 'contempo'),
                'default'  => '15',
                //'min'      => '20',
                'step'     => '5',
                'max'      => '100',
            ),

            array(
                'id'       => 'ct_hero_search_btm_pad',
                'type'     => 'spinner', 
                'title'    => __('Bottom Padding', 'contempo'),
                //'subtitle' => __('No validation can be done on this field type','redux-framework-demo'),
                'desc'     => __('Set the bottom padding in percentage.', 'contempo'),
                'default'  => '15',
                //'min'      => '20',
                'step'     => '5',
                'max'      => '100',
            ),
            
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Call To Action', 'contempo' ),
        'id'               => 'call-to-action',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(

            array (
                'desc' => 'Your call to action verbiage, ex: Feature rich and affordable, you can\'t afford to pass this up!',
                'id' => 'ct_cta',
                'type' => 'textarea',
                'title' => 'Call To Action Text',
                'default' => '<h3 class="marT0 marB10">A Responsive & Feature Rich Real Estate Theme for WordPress!</h3><p class="lead muted">Chock full of awesomeness, this is one you can\'t afford to pass up, <a href="#">Buy It Today</a>!</p>',
            ),
            array (
                'desc' => 'Upload a custom background image.',
                'id' => 'ct_cta_bg_img',
                'type' => 'media',
                'title' => 'Call To Action Background Image',
                'url' => true,
            ),
            array (
                'desc' => 'Pick a background color for the call to action, if not using a background image.',
                'id' => 'ct_cta_bg_color',
                'type' => 'color',
                'title' => 'Call To Action Background Color',
            ),
            
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Featured Listings', 'contempo' ),
        'id'               => 'featured-listings',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(

            array (
                'desc' => 'Enter the title for the featured listings area.',
                'id' => 'ct_home_featured_title',
                'type' => 'text',
                'title' => 'Featured Listings Title',
                'default' => 'Featured Listings',
            ),

            array (
                'desc' => 'If you\'ve enabled the Featured Listings block enter the number of listings you\'d like displayed here, recommend multiples of three.',
                'id' => 'ct_home_featured_num',
                'type' => 'text',
                'title' => 'Number of Featured Listings',
                'default' => '3',
            ),

            array (
                'desc' => 'Select whether or not you\'d like to display the view all button. This links to all "Featured" listings.',
                'id' => 'ct_home_featured_btn',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Display View All Button?',
                'default' => 'yes',
            ),

            array (
                'desc' => 'Select whether or not you\'d like to manually order featured listings on the homepage, if Yes then an order number needs to be set by Listings > Homepage Featured Listing Order > 1, 2, 3&hellip; <a href="http://cl.ly/0v1q1Z1Y0L2N" target="_blank">Screenshot</a>.',
                'id' => 'ct_home_featured_order',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Manually Order Featured Listings?',
                'default' => 'no',
            ),
            
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Testimonials', 'contempo' ),
        'id'               => 'testimonials',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(

            array (
                    'desc' => 'Style One is a Full Background Image, and Style Two is a Cropped Circular Image aligned to the left.',
                    'id' => 'ct_home_testimonials_style',
                    'type' => 'image_select',
                    'options' => array (
                        'testimonials-style-one' => get_template_directory_uri() . '/admin/images/testimonials-one.png',
                        'testimonials-style-two' => get_template_directory_uri() . '/admin/images/testimonials-two.png',
                    ),
                    'title' => 'Select a style',
                    'default' => 'testimonials-style-one',
            ),

            array(
                'id'       => 'ct_home_testimonials',
                'type'     => 'slides',
                'title'    => __('Add/Edit Testimonials', 'contempo'),
                'subtitle' => __('Add your testimonials to be displayed on the homepage.', 'contempo'),
                'placeholder' => array(
                    'title'           => __('Company or Person', 'contempo'),
                    'description'     => __('Testimonial Here', 'contempo'),
                    'url'             => __('Link', 'contempo'),
                ),
            ),
            
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Partners', 'contempo' ),
        'id'               => 'partners',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(

            array (
                'desc' => 'If you\'ve enabled the Partners block enter the title you\'d like displayed here.',
                'id' => 'ct_partner_title',
                'type' => 'text',
                'title' => 'Partner Title',
                'default' => 'Partners',
            ),

            array(
                'id'       => 'ct_partner_logos',
                'type'     => 'slides',
                'title'    => __('Add/Edit Partner Logos', 'contempo'),
                'subtitle' => __('Add your partner logos to be displayed on the homepage.', 'contempo'),
                'placeholder' => array(
                    'title'           => __('Partner Title', 'contempo'),
                    'description'     => __('Description Here (not used)', 'contempo'),
                    'url'             => __('Link', 'contempo'),
                ),
            )
                        
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Page Builder', 'contempo' ),
        'id'               => 'page-builder',
        'subsection'       => true,
        'desc'             => 'Create a page > add your content with Visual Composer > Publish > set the page in one of the options below. Make sure you\'ve enabled either Page Builder block from the Layout Manager as well.',
        'customizer_width' => '450px',
        'fields'           => array(

            array (
                'desc' => 'Select a page.',
                'id' => 'ct_home_page_builder_id',
                'type' => 'select',
                'data' => 'pages',
                'title' => 'Page Builder 1 Page',
                'default' => '',
            ),
            array (
                'desc' => 'Select a page.',
                'id' => 'ct_home_page_builder_two_id',
                'type' => 'select',
                'data' => 'pages',
                'title' => 'Page Builder 2 Page',
                'default' => '',
            ),
            array (
                'desc' => 'Select a page.',
                'id' => 'ct_home_page_builder_three_id',
                'type' => 'select',
                'data' => 'pages',
                'title' => 'Page Builder 3 Page',
                'default' => '',
            ),
            array (
                'desc' => 'Select a page.',
                'id' => 'ct_home_page_builder_four_id',
                'type' => 'select',
                'data' => 'pages',
                'title' => 'Page Builder 4 Page',
                'default' => '',
            ),
            
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Four Column Widget Area', 'contempo' ),
        'id'               => 'four-col-widget-area',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(

            array (
                'id' => 'ct_homepage_widget_area',
                'type' => 'info',
                'raw' => 'The Widget Area can be controlled via Appearance > Widgets > Homepage.',
            ),
            
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'FlexSlider', 'contempo' ),
        'id'               => 'flexslider',
        'icon'             => 'fa fa-bars',
        'customizer_width' => '450px',
        'fields'           => array(
            array (
                'desc' => 'Select your animation type.',
                'id' => 'ct_flex_animation',
                'type' => 'select',
                'options' => array (
                    'fade' => 'Fade',
                    'slide' => 'Slide',
                ),
                'title' => 'Animation',
                'default' => 'fade',
            ),
            array (
                'desc' => 'Select sliding direction.',
                'id' => 'ct_flex_direction',
                'type' => 'select',
                'options' => array (
                    'horizontal' => 'Horizontal',
                    'vertical' => 'Vertical',
                ),
                'title' => 'Slide Direction',
                'default' => 'horizontal',
            ),
            array (
                'desc' => 'Set the speed of the slideshow cycling, in milliseconds.',
                'id' => 'ct_flex_speed',
                'type' => 'text',
                'title' => 'Slideshow Speed',
                'default' => '7000',
            ),
            array (
                'desc' => 'Set the speed of animations, in milliseconds.',
                'id' => 'ct_flex_duration',
                'type' => 'text',
                'title' => 'Animation Duration',
                'default' => '600',
            ),
            array (
                'desc' => 'Randomize slide order.',
                'id' => 'ct_flex_randomize',
                'type' => 'select',
                'options' => array (
                    'false' => 'False',
                    'true' => 'True',
                ),
                'title' => 'Randomize Slides?',
                'default' => 'false',
            ),
            array (
                'desc' => 'Allows for smooth height transitions between slides, useful if you have both landscape and portrait style images. ',
                'id' => 'ct_enable_smootheight',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Enable Smootheight?',
                'default' => 'yes',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Create a Skin', 'contempo' ),
        'id'               => 'create-a-skin',
        'icon'             => 'fa fa-paint-brush',
        'customizer_width' => '450px',
        'fields'           => array(

            array (
                'desc' => 'Select whether or not you\'d like to use these custom styles.',
                'id' => 'ct_use_styles',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Use Custom Styles?',
                'default' => 'no',
            ),

            $fields = array(
                'id' => 'info_critical',
                'type' => 'info',
                'style' => 'critical',
                'icon' => 'el-icon-info-sign',
                'title' => __('NOTE!', 'redux-framework-demo'),
                'desc' => __('If this isn\'t set to Yes NONE of the Styles will be Applied.', 'contempo')
            ),
 
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Typography', 'contempo' ),
        'id'               => 'typography',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'          => array(

            array (
                'desc' => 'Select whether or not you\'d like to turn on custom typography styles.',
                'id' => 'ct_use_typostyles',
                'type' => 'select',
                'options' => array (
                    'on' => 'On',
                    'off' => 'Off',
                ),
                'title' => 'Turn On Custom Typography?',
                'default' => 'off',
            ),
            array (
                'id'          => 'ct_body_typography',
                'type'        => 'typography', 
                'title'       => __('Body', 'contempo'),
                'google'      => true, 
                'font-backup' => true,
                'output'      => array('body'),
                'units'       =>'px',
                //'subtitle'    => __('Typography option with each property can be called individually.', 'contempo'),
                'default'     => array(
                    'color'       => '#191919', 
                    'font-style'  => 'Normal', 
                    'font-family' => 'Lato', 
                    'google'      => true,
                    'font-size'   => '16px', 
                    'line-height' => '30px'
                ),
                'required' => array('ct_use_typostyles','!=','off')
            ),
            array (
                'id'          => 'ct_heading_typography',
                'type'        => 'typography', 
                'title'       => __('Headings', 'contempo'),
                'google'      => true, 
                'font-backup' => true,
                'font-size'   => false,
                'line-height' => false,
                'output'      => array('h1,h2,h2,h4,h5,h6'),
                'units'       =>'px',
                //'subtitle'    => __('Typography option with each property can be called individually.', 'contempo'),
                'default'     => array(
                    'color'       => '#191919', 
                    'font-style'  => 'Normal', 
                    'font-family' => 'Montserrat', 
                    'google'      => true,
                ),
                'required' => array('ct_use_typostyles','!=','off')
            ),
            array (
                'id'          => 'ct_heading_one_size',
                'type'        => 'typography', 
                'title'       => __('H1', 'contempo'),
                'google'      => false, 
                'font-backup' => false,
                'font-family' => false,
                'font-size'   => true,
                'font-style'   => false,
                'font-weight'   => false,
                'output'      => array('h1'),
                'units'       =>'em',
                //'subtitle'    => __('Typography option with each property can be called individually.', 'contempo'),
                'default'     => array(
                    'color'       => '#191919', 
                    'font-size'   => '2.875em', 
                    'line-height' => '1.25em'
                ),
                'required' => array('ct_use_typostyles','!=','off')
            ),
            array (
                'id'          => 'ct_heading_two_size',
                'type'        => 'typography', 
                'title'       => __('H2', 'contempo'),
                'google'      => false, 
                'font-backup' => false,
                'font-family' => false,
                'font-size'   => true,
                'font-style'   => false,
                'font-weight'   => false,
                'output'      => array('h2'),
                'units'       =>'em',
                //'subtitle'    => __('Typography option with each property can be called individually.', 'contempo'),
                'default'     => array(
                    'color'       => '#191919', 
                    'font-size'   => '2.1875em', 
                    'line-height' => '1.25em'
                ),
                'required' => array('ct_use_typostyles','!=','off')
            ),
            array (
                'id'          => 'ct_heading_three_size',
                'type'        => 'typography', 
                'title'       => __('H3', 'contempo'),
                'google'      => false, 
                'font-backup' => false,
                'font-family' => false,
                'font-size'   => true,
                'font-style'   => false,
                'font-weight'   => false,
                'output'      => array('h3'),
                'units'       =>'em',
                //'subtitle'    => __('Typography option with each property can be called individually.', 'contempo'),
                'default'     => array(
                    'color'       => '#191919', 
                    'font-size'   => '1.75em', 
                    'line-height' => '1.25em'
                ),
                'required' => array('ct_use_typostyles','!=','off')
            ),
            array (
                'id'          => 'ct_heading_four_size',
                'type'        => 'typography', 
                'title'       => __('H4', 'contempo'),
                'google'      => false, 
                'font-backup' => false,
                'font-family' => false,
                'font-size'   => true,
                'font-style'   => false,
                'font-weight'   => false,
                'output'      => array('h4'),
                'units'       =>'em',
                //'subtitle'    => __('Typography option with each property can be called individually.', 'contempo'),
                'default'     => array(
                    'color'       => '#191919', 
                    'font-size'   => '1.3125em', 
                    'line-height' => '1.25em'
                ),
                'required' => array('ct_use_typostyles','!=','off')
            ),
            array (
                'id'          => 'ct_heading_five_size',
                'type'        => 'typography', 
                'title'       => __('H5', 'contempo'),
                'google'      => false, 
                'font-backup' => false,
                'font-family' => false,
                'font-size'   => true,
                'font-style'   => false,
                'font-weight'   => false,
                'output'      => array('h5'),
                'units'       =>'em',
                //'subtitle'    => __('Typography option with each property can be called individually.', 'contempo'),
                'default'     => array(
                    'color'       => '#191919', 
                    'font-size'   => '1.0625em', 
                    'line-height' => '1.25em'
                ),
                'required' => array('ct_use_typostyles','!=','off')
            ),
            array (
                'id'          => 'ct_heading_six_size',
                'type'        => 'typography', 
                'title'       => __('H6', 'contempo'),
                'google'      => false, 
                'font-backup' => false,
                'font-family' => false,
                'font-size'   => true,
                'font-style'   => false,
                'font-weight'   => false,
                'output'      => array('h6'),
                'units'       =>'em',
                //'subtitle'    => __('Typography option with each property can be called individually.', 'contempo'),
                'default'     => array(
                    'color'       => '#191919', 
                    'font-size'   => '0.875em', 
                    'line-height' => '1.25em'
                ),
                'required' => array('ct_use_typostyles','!=','off')
            )
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Body Background', 'contempo' ),
        'id'               => 'create-a-skin-body-background',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
             array (
                'desc' => 'Pick a background color, image, etc&hellip;.',
                'id' => 'ct_background',
                'type' => 'background',
                'title' => 'Body Background',
            ),
            
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Header', 'contempo' ),
        'id'               => 'create-a-skin-header',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(

            $fields = array(
                'id' => 'info_critical_header',
                'type' => 'info',
                'style' => 'critical',
                'icon' => 'el-icon-info-sign',
                'title' => __('NOTE!', 'redux-framework-demo'),
                'desc' => __('You must set Create a Skin > Use Custom Styles > Yes, if this isn\'t set NONE of the Styles will be Applied.', 'contempo')
            ),

            array (
                'desc' => 'Pick a background color for the header top bar.',
                'id' => 'ct_header_bar_color',
                'type' => 'color',
                'title' => 'Header Top Bar Background Color',
            ),
            array (
                'desc' => 'Pick a border color for the header top bar links.',
                'id' => 'ct_header_bar_border_color',
                'type' => 'color',
                'title' => 'Header Top Bar Border Color',
            ),
            array (
                'desc' => 'Pick a text color for the header top bar.',
                'id' => 'ct_header_bar_text_color',
                'type' => 'color',
                'title' => 'Header Top Bar Text Color',
            ),
            array (
                'desc' => 'Pick a background color for the header top bar user login.',
                'id' => 'ct_header_bar_user_bg_color',
                'type' => 'color',
                'title' => 'Header Top Bar User Login Background Color',
            ),
            array (
                'desc' => 'Pick a link color for the header top bar user login.',
                'id' => 'ct_header_bar_user_link_color',
                'type' => 'color',
                'title' => 'Header Top Bar User Login Link Color',
            ),
            array (
                'desc' => 'Pick a link bottom border color for the header top bar user login.',
                'id' => 'ct_header_bar_user_btm_border_color',
                'type' => 'color',
                'title' => 'Header Top Bar User Login Link Bottom Border Color',
            ),
            array (
                'desc' => 'Pick a background color for the header.',
                'id' => 'ct_header_background',
                'type' => 'color_rgba',
                'output' => array(
                    'background-color' => '#header-wrap',
                    'border-top-color' => '.cbp-tm-menu > li > a'
                ),
                'title' => 'Header Background Color',
            ),
            array (
                'desc' => 'Pick a top border color for the current nav item.',
                'id' => 'ct_header_nav_current_bg',
                'type' => 'color',
                'title' => 'Header Nav Current Top Border Color',
            ),
            array (
                'desc' => 'Pick a font color for the nav.',
                'id' => 'ct_header_nav_font_color',
                'type' => 'color',
                'title' => 'Header Nav Font Color',
            ),
            
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Secondary Colors', 'contempo' ),
        'id'               => 'create-a-skin-secondary-colors',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(

            $fields = array(
                'id' => 'info_critical_secondary',
                'type' => 'info',
                'style' => 'critical',
                'icon' => 'el-icon-info-sign',
                'title' => __('NOTE!', 'redux-framework-demo'),
                'desc' => __('You must set Create a Skin > Use Custom Styles > Yes, if this isn\'t set NONE of the Styles will be Applied.', 'contempo')
            ),

            array (
                'desc' => 'Pick a the secondary background color, e.g. advanced search, slider, agents, etc.',
                'id' => 'ct_secondary_bg_color',
                'type' => 'color',
                'title' => 'Secondary Background Color',
            ),
            array (
                'desc' => 'Pick a background color make sure to use some transparency (.95 is default) so the background image shows through this is used in the Call to Action, Header Images for Pages, Categories, Posts &amp; Footer Widget Area.',
                'id' => 'ct_dark_overlay_background',
                'type' => 'color_rgba',
                'output' => array(
                    'background-color' => '.dark-overlay, #footer-widgets .dark-overlay'
                ),
                'title' => 'Dark Overlay Background Color',
            ),
            array (
                'desc' => 'Pick a font color for listings single heading.',
                'id' => 'ct_listing_heading_font_color',
                'type' => 'color',
                'title' => 'Listings Single Heading Font Color',
            ),
            array (
                'desc' => 'Pick a font color for listings property info area.',
                'id' => 'ct_listing_font_color',
                'type' => 'color',
                'title' => 'Listings Property Info Font Color',
            ),
            array (
                'desc' => 'Pick a bottom border color for listings property info area.',
                'id' => 'ct_listing_border_bottom_color',
                'type' => 'color',
                'title' => 'Listings Property Info Bottom Border Color',
            ),
            array (
                'desc' => 'Pick a background color for the listings property info area.',
                'id' => 'ct_listing_background_color',
                'type' => 'color',
                'title' => 'Listings Property Info Background Color',
            ),
            array (
                'desc' => 'Pick a background color for the price.',
                'id' => 'ct_price_bg',
                'type' => 'color',
                'title' => 'Price Background Color',
            ),
            array (
                'desc' => 'Pick a background color for the search results map toggle and frontend listings tools butttons.',
                'id' => 'ct_map_toggle',
                'type' => 'color',
                'title' => 'Search Results Map Toggle &amp; Frontend Listing Tools buttons',
            ),
            array (
                'desc' => 'Pick a background color for the featured listings view all button on the homepage.',
                'id' => 'ct_featured_view_all',
                'type' => 'color',
                'title' => 'Featured Listings View All Button Background color',
            ),
            array (
                'desc' => 'Pick a font color for listings request more info area.',
                'id' => 'ct_listing_more_info_font_color',
                'type' => 'color',
                'title' => 'Listings Single Request More Info Font Color',
            ),
            array (
                'desc' => 'Pick a header background color for sidebar widgets.',
                'id' => 'ct_widget_header_bg_color',
                'type' => 'color',
                'title' => 'Widget Header Background Color',
            ),
            
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Links', 'contempo' ),
        'id'               => 'create-a-skin-links',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(

            $fields = array(
                'id' => 'info_critical_links',
                'type' => 'info',
                'style' => 'critical',
                'icon' => 'el-icon-info-sign',
                'title' => __('NOTE!', 'redux-framework-demo'),
                'desc' => __('You must set Create a Skin > Use Custom Styles > Yes, if this isn\'t set NONE of the Styles will be Applied.', 'contempo')
            ),

            array (
                'id' => 'ct_link_color',
                'type' => 'color',
                'title' => 'Link Color',
            ),
            array (
                'id' => 'ct_visited_color',
                'type' => 'color',
                'title' => 'Visited Link Color',
            ),
            array (
                'id' => 'ct_hover_color',
                'type' => 'color',
                'title' => 'Hover Link Color',
            ),
            array (
                'id' => 'ct_active_color',
                'type' => 'color',
                'title' => 'Active Link Color',
            ),
            
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Footer', 'contempo' ),
        'id'               => 'create-a-skin-footer',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(

            $fields = array(
                'id' => 'info_critical_footer',
                'type' => 'info',
                'style' => 'critical',
                'icon' => 'el-icon-info-sign',
                'title' => __('NOTE!', 'redux-framework-demo'),
                'desc' => __('You must set Create a Skin > Use Custom Styles > Yes, if this isn\'t set NONE of the Styles will be Applied.', 'contempo')
            ),

            array (
                'desc' => 'Pick a background color for the footer top border).',
                'id' => 'ct_footer_border_top_color',
                'type' => 'color',
                'title' => 'Footer Top Border Color',
            ),
            array (
                'desc' => 'Pick a background color for the footer widget area.',
                'id' => 'ct_footer_widget_background',
                'type' => 'color',
                'title' => 'Footer Widget Area Background Color',
            ),
            array (
                'desc' => 'Pick a font color for the footer widget headings.',
                'id' => 'ct_footer_widget_heading_color',
                'type' => 'color',
                'title' => 'Footer Widget Heading Color',
            ),
            array (
                'desc' => 'Pick a font color for the footer widgets.',
                'id' => 'ct_footer_widget_font_color',
                'type' => 'color',
                'title' => 'Footer Widget Font Color',
            ),
            array (
                'desc' => 'Pick a background color for the footer.',
                'id' => 'ct_footer_background',
                'type' => 'color',
                'title' => 'Footer Background Color',
            ),
            array (
                'desc' => 'Upload a background image for the footer.',
                'id' => 'ct_footer_background_img',
                'type' => 'media',
                'title' => 'Footer Background Image',
                'url' => true,
            ),
            array (
                'desc' => 'Upload a background image for the footer.',
                'id' => 'ct_footer_bg_img',
                'type' => 'media',
                'title' => 'Footer Background Image',
                'url' => true,
            ),
            array (
                'desc' => 'Pick a font color for the footer nav links.',
                'id' => 'ct_footer_link_color',
                'type' => 'color',
                'title' => 'Footer Nav Link Color',
            ),
            
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Agents', 'contempo' ),
        'id'               => 'agents',
        'icon'             => 'fa fa-users',
        'customizer_width' => '450px',
        'fields'           => array(
            array (
                'desc' => 'Select Yes if you\'d only like admins to be able to assign a user as an agent via their user profile, otherwise the user can manage this setting themseleves. Useful for sites that have open registration.',
                'id' => 'ct_agents_assign',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Only Admin Level can assign User as Agent?',
                'default' => 'no',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to manually order agents when using the Agents page template, if Yes then an order number needs to be set by Users > Profile > Agent Order > 1, 2, 3&hellip; <a href="http://cl.ly/3a0C3H2p1Y0u" target="_blank">Screenshot</a>.',
                'id' => 'ct_agents_ordering',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Manually Order Agents?',
                'default' => 'no',
            ),
            array (
                'desc' => '',
                'id' => 'ct_agent_layout',
                'type' => 'image_select',
                'options' => array (
                    'agent-wide' => get_template_directory_uri() . '/admin/images/agent-wide.png',
                    'agent-grid' => get_template_directory_uri() . '/admin/images/agent-grid.png',
                ),
                'title' => 'Select a layout',
                'default' => 'agent-wide',
            ),
        )
   ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Brokerages', 'contempo' ),
        'id'               => 'brokerages',
        'icon'             => 'fa fa-building',
        'customizer_width' => '450px',
        'fields'           => array(
            array (
                'desc' => '',
                'id' => 'ct_brokerage_layout',
                'type' => 'image_select',
                'options' => array (
                    'brokerage-wide' => get_template_directory_uri() . '/admin/images/brokerage-wide.png',
                    'brokerage-grid' => get_template_directory_uri() . '/admin/images/brokerage-grid.png',
                ),
                'title' => 'Select a layout',
                'default' => 'brokerage-wide',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to enable brokerage reviews. NOTE: This requires the "Comments Ratings" plugin, please refer to the <a href="http://contempothemes.com/wp-real-estate-7/documentation/#reviews">documentation</a>.',
                'id' => 'ct_brokerage_reviews',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Enable Brokerage Reviews?',
                'default' => 'no',
            ),
        )
   ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Google Maps', 'contempo' ),
        'id'               => 'google-maps',
        'icon'             => 'fa fa-map-o',
        'customizer_width' => '450px',
        'fields'           => array(
            array (
                'desc' => 'As of June 22, 2016 Google Maps is now requiring all new sites to use an API Key, which you can get for free <a href="https://developers.google.com/maps/documentation/javascript/">here</a> > click "Get Key" in the upper right (<a href="https://cl.ly/3L0a141I1k0W">screenshot</a>). All existing sites are grandfathered in however it is still recommended.',
                'id' => 'ct_google_maps_api_key',
                'type' => 'text',
                'title' => 'Google Maps API Key',
                'default' => '',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Listings', 'contempo' ),
        'id'               => 'listings',
        'icon'             => 'fa fa-newspaper-o',
        'customizer_width' => '450px',
        'fields'           => array(
            array (
                'desc' => 'Select which listing style you\'d like to use, standard or minimal.',
                'id' => 'ct_search_results_listing_style',
                'type' => 'select',
                'options' => array (
                    'standard' => 'Standard Grid',
                    'minimal' => 'Minimal Grid',
                    'list' => 'List',
                ),
                'title' => 'Listing Layout Style',
                'default' => 'standard',
            ),
            array (
                'desc' => 'The first layout features a content width slider and carousel, while the second features a full width carousel both with clickable large lightbox images. <strong>NOTE:</strong> The second layout option really only <em>works best if your listings ALL have Multiple images</em> otherwise you\'ll get one large single image displayed full screen which doesn\'t work well for usability. If this is the case the first option works great for single image or multi-image listings.',
                'id' => 'ct_listing_single_layout',
                'type' => 'image_select',
                'options' => array (
                    'listings-one' => get_template_directory_uri() . '/admin/images/listings-one.png',
                    'listings-two' => get_template_directory_uri() . '/admin/images/listings-two.png',
                ),
                'title' => 'Listings Single layout',
                'default' => 'listings-one',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to make it so users have to login/register to see full listing content.',
                'id' => 'ct_listings_login_register',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Only Logged In Users Can View Listings?',
                'default' => 'no',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to enable the vacation rentals/booking fields and capabilities.',
                'id' => 'ct_rentals_booking',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Enable Vacation Rentals/Booking Fields',
                'default' => 'no',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to enable the Multi-Floorplan fields and capabilities. Includes repeatable fields for floorplans, pricing &amp; descriptions commonly used for apartment buildings, condo sales, housing development sites, etc&hellip;',
                'id' => 'ct_multi_floorplan',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Enable Multi-Floorplan &amp; Pricing Fields?',
                'default' => 'no',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to enable listing reviews. NOTE: This requires the "Comments Ratings" plugin, please refer to the <a href="http://contempothemes.com/wp-real-estate-7/documentation/#reviews">documentation</a>.',
                'id' => 'ct_listing_reviews',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Enable Listing Reviews?',
                'default' => 'no',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to disable the advanced search area on listing search results pages, best used in conjunction with the Header Listing Search option, under Header > Header Listing Search? > set to Yes.',
                'id' => 'ct_disable_listing_search_results_adv_search',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Disable Advanced Search on Listing Search Results?',
                'default' => 'no',
            ),
            array (
                'desc' => 'Select which search results layout you\'d like to use, stacked map and results or side by side map and results.',
                'id' => 'ct_search_results_layout',
                'type' => 'select',
                'options' => array (
                    'stacked' => 'Stacked',
                    'sidebyside' => 'Side by Side',
                ),
                'title' => 'Search Results Layout',
                'default' => 'stacked',
            ),
            array (
                'desc' => 'Enter the amount of listings you want displayed per page when searching.',
                'id' => 'ct_listing_search_num',
                'type' => 'text',
                'title' => 'Listing Search Results Per Page',
                'default' => '6',
            ),
            array (
                'desc' => 'Enter the listing description excerpt length used on search results. If "0" then no excerpt will be shown.',
                'id' => 'ct_excerpt_length',
                'type' => 'text',
                'title' => 'Listing Excerpt Length',
                'default' => '25',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to display the brokerage name on listing search results, uses the "Brokerage Name" field under Users > User > Edit Profile.',
                'id' => 'ct_listing_brokerage_name',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Enable Listing Brokerage Name?',
                'default' => 'no',
            ),
            array (
                'desc' => 'Enter your currency symbol here, US dollars is default.',
                'id' => 'ct_currency',
                'type' => 'text',
                'title' => 'Currency',
                'default' => '$',
            ),
            array (
                'desc' => 'Select whether you\'d like the currency symbol to appear before the price or after.',
                'id' => 'ct_currency_placement',
                'type' => 'select',
                'options' => array (
                    'before' => 'Before',
                    'after' => 'After',
                ),
                'title' => 'Currency Placement',
                'default' => 'before',
            ),
            array (
                'desc' => 'Leave this on, unless you need to manually enter lat/long for your listings.',
                'id' => 'ct_listing_lat_long',
                'type' => 'select',
                'options' => array (
                    'on' => 'On',
                    'off' => 'Off',
                ),
                'title' => 'Automatic latitude & longitude based on listing address',
                'default' => 'off',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to use icons or text for listing features (beds, baths, guests, etc&hellip;).',
                'id' => 'ct_use_propinfo_icons',
                'type' => 'select',
                'options' => array (
                    'icons' => 'Icons',
                    'text' => 'Text',
                ),
                'title' => 'Use Icons or Text for Listing Info?',
                'default' => 'text',
            ),
            array (
                'desc' => 'Select if you would like to use Sq Ft, Sq Meters or Area for the dwelling size.',
                'id' => 'ct_sq',
                'type' => 'select',
                'options' => array (
                    'sqft' => 'Sq Ft',
                    'sqmeters' => 'Sq Meters',
                    'area' => 'Area',
                ),
                'title' => 'Sq Ft, Sq Meters or Area?',
                'default' => 'sqft',
            ),
            array (
                'desc' => 'Select if you would like to use Acres, Sq Ft, Sq Meters or Area for the lot size.',
                'id' => 'ct_acres',
                'type' => 'select',
                'options' => array (
                    'acres' => 'Acres',
                    'sqft' => 'Sq Ft',
                    'sqmeters' => 'Sq Meters',
                    'area' => 'Area',
                ),
                'title' => 'Acres, Sq Ft, Sq Meters or Area?',
                'default' => 'acres',
            ),
            array (
                'desc' => 'Select whether you\'d like to use State, Area, Suburb or Province.',
                'id' => 'ct_state_or_area',
                'type' => 'select',
                'options' => array (
                    'state' => 'State',
                    'area' => 'Area',
                    'suburb' => 'Suburb',
                    'province' => 'Province',
                ),
                'title' => 'State, Area, Suburb or Province?',
                'default' => 'state',
            ),
            array (
                'desc' => 'Select whether you\'d like to use Zipcode, Postcode or Postal Code.',
                'id' => 'ct_zip_or_post',
                'type' => 'select',
                'options' => array (
                    'zipcode' => 'Zipcode',
                    'postcode' => 'Postcode',
                    'postalcode' => 'Postal Code',
                ),
                'title' => 'Zipcode, Postcode or Postal Code?',
                'default' => 'zipcode',
            ),
            array (
                'desc' => 'Select whether you\'d like to use Community, Neighborhood, Suburb, District or Building.',
                'id' => 'ct_community_neighborhood_or_district',
                'type' => 'select',
                'options' => array (
                    'community' => 'Community',
                    'neighborhood' => 'Neighborhood',
                    'suburb' => 'Suburb',
                    'district' => 'District',
                    'building' => 'Building',
                ),
                'title' => 'Community, Neighborhood, Suburb, District or Building?',
                'default' => 'community',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to disable Google Maps on Search Results.',
                'id' => 'ct_disable_google_maps_search',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Disable Google Maps on Search Results?',
                'default' => 'no',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to disable Google Maps on Listing Single.',
                'id' => 'ct_disable_google_maps_listing',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Disable Google Maps on Listing Single?',
                'default' => 'no',
            ),
            array (
                'desc' => 'Select whether you\'d like to use custom map styles or default sitewide.',
                'id' => 'ct_google_maps_style',
                'type' => 'select',
                'options' => array (
                    'custom' => 'Custom',
                    'default' => 'Default',
                ),
                'title' => 'Custom or Default Google Maps Styles',
                'default' => 'custom',
            ),
            array (
                'desc' => 'Select whether you\'d like the listing single content with a sidebar or full width.',
                'id' => 'ct_listing_single_content_layout',
                'type' => 'select',
                'options' => array (
                    'sidebar' => 'w/Sidebar',
                    'full-width' => 'Full Width',
                ),
                'title' => 'Listing Single Content w/Sidebar or Full Width?',
                'default' => 'sidebar',
            ),
            array (
                'desc' => 'Select whether you\'d like to show the listing info (beds, baths, etc&hellip;) above or below the main image.',
                'id' => 'ct_listing_propinfo',
                'type' => 'select',
                'options' => array (
                    'above' => 'Above',
                    'below' => 'Below',
                ),
                'title' => 'Show Listing Info Above or Below Main Image?',
                'default' => 'above',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to show the listing section navigation with smooth scroll.',
                'id' => 'ct_listing_section_nav',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Show Listing Section Navigation?',
                'default' => 'yes',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to show the listing tools (social share, print, etc&hellip;) on single listing view.',
                'id' => 'ct_listing_tools',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Show Listing Tools?',
                'default' => 'yes',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to show the agent details &amp; contact form area.',
                'id' => 'ct_listing_agent_info',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Show Agent Details &amp; Request More Info Form?',
                'default' => 'yes',
            ),
            
            array (
                'desc' => '',
                'id' => 'ct_listing_agent_contact_cc',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Do you want to receive a copy of the email sent to the agent?',
                'default' => 'no',
            ),
            array (
                'desc' => 'Enter the email address you\'d like the copy sent to.',
                'id' => 'ct_listing_agent_contact_cc_email_address',
                'type' => 'text',
                'title' => 'CC Email Address',
                'placeholder' => 'email@somedomain.com',
                'required' => array('ct_listing_agent_contact_cc','equals','yes'),
            ),
            array (
                'desc' => 'Select whether or not you\'d like to enable the vacation rentals/booking fields and capabilities.',
                'id' => 'ct_rentals_booking',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Enable Vacation Rentals/Booking Fields',
                'default' => 'no',
            ),
            array (
                'desc' => 'Set the slug for listings here to whatever you\'d like (all lowercase, no spaces, dashes are allowed). <strong>IMPORTANT:</strong> Once you done that save > then go to Settings > Permalinks > Save Settings, and you\'ll be good to go, <strong><em>if you don\'t you\'ll get 404 errors for all your listings</em></strong>.',
                'id' => 'ct_listings_slug',
                'type' => 'text',
                'title' => 'Listings Custom Slug',
                'default' => 'listings',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Walk Score', 'contempo' ),
        'id'               => 'walkscore',
        'icon'             => 'fa fa-male',
        'desc'   => __( 'Walk Score is the only international measure of walkability and the leading provider of neighborhood maps to the real estate industry. More than 30,000 websites use the Walk Score Neighborhood Map and we serve over 20 million scores each day. <a href="https://www.walkscore.com/professional/api-sign-up.php" target="_blank">Get your API Key</a>!.', 'framework' ),
        'customizer_width' => '450px',
        'fields'           => array(
            array (
                'desc' => 'Select whether or not you\'d like to enable Walk Score for listings.',
                'id' => 'ct_enable_walkscore',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Enable Walk Score for Listings?',
                'default' => 'no',
                'required' => array('ct_walkscore_apikey','!=','')
            ),
            array (
                'desc' => 'Enter your Walk Score API Key here, don\'t have one get one <a href="https://www.walkscore.com/professional/api-sign-up.php" target="_blank">here</a>.',
                'id' => 'ct_walkscore_apikey',
                'type' => 'text',
                'title' => 'Walk Score API Key',
                'required' => array('ct_listing_lat_long','equals','on'),
                'default' => '',
            ),
            array (
                'desc' => '<strong>Walk Score depends on latitude and longitude to work properly</strong>, turn this On unless you want to manually enter lat/long for your listings.',
                'id' => 'ct_listing_lat_long',
                'type' => 'select',
                'options' => array (
                    'on' => 'On',
                    'off' => 'Off',
                ),
                'title' => 'Automatic latitude & longitude',
                'default' => 'off',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Yelp', 'contempo' ),
        'id'               => 'yelp',
        'icon'             => 'fa fa-yelp',
        'desc'   => __( 'Set this up if you\'d like to display "What\'s Nearby?" information on your listings such as restaurants, grocery stores, schools, coffee shops, etc&hellip;. <a href="http://www.yelp.com/developers/getting_started/api_access" target="_blank">Get your API Key</a>!.', 'framework' ),
        'customizer_width' => '450px',
        'fields'           => array(
            array (
                'desc' => 'Select whether or not you\'d like to enable Yelp "What\'s Nearby" Information for listings.',
                'id' => 'ct_enable_yelp_nearby',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Enable Yelp "What\'s Nearby?" for Listings?',
                'default' => 'no',
                'required' => array('ct_yelp_consumer_key','!=','')
            ),
            array (
                'desc' => 'Enter your Yelp Consumer Key here, don\'t have one get one <a href="http://www.yelp.com/developers/getting_started/api_access" target="_blank">here</a>.',
                'id' => 'ct_yelp_consumer_key',
                'type' => 'text',
                'title' => 'Yelp Consumer Key',
                'default' => '',
            ),
            array (
                'desc' => 'Enter your Yelp Consumer Secret Key here, don\'t have one get one <a href="http://www.yelp.com/developers/getting_started/api_access" target="_blank">here</a>.',
                'id' => 'ct_yelp_consumer_secret_key',
                'type' => 'text',
                'title' => 'Yelp Consumer Secret Key',
                'default' => '',
            ),
            array (
                'desc' => 'Enter your Yelp Token Key here, don\'t have one get one <a href="http://www.yelp.com/developers/getting_started/api_access" target="_blank">here</a>.',
                'id' => 'ct_yelp_token_key',
                'type' => 'text',
                'title' => 'Yelp Token Key',
                'default' => '',
            ),
            array (
                'desc' => 'Enter your Yelp Token Secret Key here, don\'t have one get one <a href="http://www.yelp.com/developers/getting_started/api_access" target="_blank">here</a>.',
                'id' => 'ct_yelp_token_secret_key',
                'type' => 'text',
                'title' => 'Yelp Token Secret Key',
                'default' => '',
            ),
            array (
                'desc' => 'Drag and drop manager, to quickly organize the nearby amenities you\'d like to display.',
                'id' => 'ct_yelp_amenities',
                'type' => 'sorter',
                'title' => 'Nearby Amenities Manager',
                //'required' => array('ct_enable_yelp_nearby','==','Yes'),
                'options' => array (
                    'disabled' => array (
                        'placebo' => 'placebo',
                        'banks' => 'Banks',
                        'bars' => 'Bars',
                        'gas_station' => 'Gas Station',
                        'hospitals' => 'Hospitals',
                    ),
                    'enabled' => array (
                        'placebo' => 'placebo',
                        'restaurant' => 'Restaurants',
                        'coffee_shops' => 'Coffee Shops',
                        'grocery' => 'Grocery',
                        'schools' => 'Schools',
                    ),
                ),
            ),
            array (
                'desc' => 'Enter the number of results you\'d like to show per amenity.',
                'id' => 'ct_yelp_limit',
                'type' => 'text',
                'title' => 'Yelp Number of Results',
                'default' => '3',
            ),
            array (
                'desc' => 'Select whether you\'d like to use miles or kilometers for the distance.',
                'id' => 'ct_yelp_miles_kilometers',
                'type' => 'select',
                'options' => array (
                    'mi' => 'Miles',
                    'km' => 'Kilometers',
                ),
                'title' => 'Miles or Kilometers?',
                'default' => 'miles',
            ),
            array (
                'desc' => 'Select whether you\'d like for amenity links to open in a new tab or not.',
                'id' => 'ct_yelp_links',
                'type' => 'select',
                'options' => array (
                    '_self' => 'No',
                    '_blank' => 'Yes',
                ),
                'title' => 'Open links in new tab?',
                'default' => '_self',
            ),
            array (
                'desc' => 'Select your sites country here so that linked content is localized in your language.',
                'id' => 'ct_yelp_cc',
                'type' => 'select',
                'options' => ct_country_codes(),
                'title' => 'Country',
                'default' => 'EN',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Front End Submission', 'contempo' ),
        'id'               => 'front-end-submission',
        'icon'             => 'fa fa-file-text-o',
        'customizer_width' => '450px',
        'fields'           => array(
            array (
                'desc' => 'Select whether or not you\'d like to enable users to submit listings from the front end of your site.',
                'id' => 'ct_enable_front_end',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Enable Front End Submission?',
                'default' => 'yes',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to auto approve listings users submit from the front end of your site. If set to No an admin will need to review and publish the listing from the admin.',
                'id' => 'ct_auto_publish',
                'type' => 'select',
                'options' => array (
                    'pending' => 'No',
                    'publish' => 'Yes',
                ),
                'title' => 'Auto Post Subimssions?',
                'default' => 'pending',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to show the optional Rental Information fields on the Submit &amp; Edit Listing pages? NOTE: You must also have the Booking Calendar plugin installed and enabled to use this feature.',
                'id' => 'ct_submit_rental_info',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Show Rental Information Fields on Submit &amp; Edit Listing pages?',
                'default' => 'no',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to enable users to pay for submissions.',
                'id' => 'ct_enable_front_end_paid',
                'type' => 'select',
                'options' => array (
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'title' => 'Enable Paid Submission?',
                'default' => 'no',
            ),
            array (
                'id' => 'paid-submission-info',
                'type' => 'info',
                'raw' => 'If you\'ve enabled Paid Submissions that requires entering your PayPal API information into the "PayPal Settings" sub menu item on the left.',
                'required' => array('ct_enable_front_end_paid','equals','yes'),
            ),
            array (
                'desc' => 'Enter the currency you\'d like to accept paid submissions in.',
                'id' => 'ct_submission_currency',
                'type' => 'text',
                'title' => 'Currency Symbol for Paid Submission',
                'required' => array('ct_enable_front_end_paid','equals','yes'),
            ),
            array (
                'desc' => 'Select the currency country.',
                'id' => 'ct_currency_code',
                'type' => 'select',
                'options' => ct_currency_codes(),
                'title' => 'Currency Country &amp; Type for Paid Submission',
                'default' => 'USD',
                'required' => array('ct_enable_front_end_paid','equals','yes'),
            ),
            array (
                'desc' => 'Enter the price for each submission here, no currency.',
                'id' => 'ct_price',
                'type' => 'text',
                'validate' => 'numeric',
                'title' => 'Price Per Submission',
                'required' => array('ct_enable_front_end_paid','equals','yes'),
            ),
            array (
                'desc' => 'Enter the featured price for each submission here, no currency.',
                'id' => 'ct_price_featured',
                'type' => 'text',
                'validate' => 'numeric',
                'title' => 'Price to Make Listing Featured',
                'required' => array('ct_enable_front_end_paid','equals','yes'),
            ),
            array (
                'desc' => 'Enter the amount of days you\'d like a listing to expire after. Leave empty if no expiration.',
                'id' => 'ct_listing_expiration',
                'type' => 'text',
                'validate' => 'numeric',
                'title' => 'Listing Expiration in X Days?',
            ),
            array (
                'id' => 'login-register-info',
                'type' => 'info',
                'raw' => 'Set the Page IDs below for the front end submission system, the Login/Register modal is automatic.',
            ),
            array (
                'desc' => 'Enter your edit profile page ID here.',
                'id' => 'ct_profile',
                'type' => 'text',
                'title' => 'Edit User Profile Page',
                'default' => '614',
            ),
            array (
                'desc' => 'Enter your submit page ID here.',
                'id' => 'ct_submit',
                'type' => 'text',
                'title' => 'Listing Submit Page',
                'default' => '623',
            ),
            array (
                'desc' => 'Enter your edit page ID here.',
                'id' => 'ct_edit',
                'type' => 'text',
                'title' => 'Listing Edit Page',
                'default' => '626',
            ),
            array (
                'desc' => 'Enter your view page ID here, e.g. "My Listings".',
                'id' => 'ct_view',
                'type' => 'text',
                'title' => 'Listings View Page',
                'default' => '629',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'PayPal Settings', 'contempo' ),
        'id'               => 'paypal',
        'icon'             => 'fa fa-paypal',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array (
                'id' => 'paypal-api-info',
                'type' => 'info',
                'raw' => 'In order to use the PayPal API you\'ll first need to signup for free at <a href="https://developer.paypal.com/">https://developer.paypal.com/</a>.',
            ),
            array (
                //'desc' => '',
                'id' => 'ct_paypal_merchant_ID',
                'type' => 'text',
                'title' => 'PayPal Merchant ID',
            ),
            array (
                //'desc' => '',
                'id' => 'ct_client_secret_key',
                'type' => 'text',
                'title' => 'PayPal Client Secret Key',
            ),
            array (
                'desc' => 'Select Sandbox for Testing or Live when you\'re ready to start accepting payments.',
                'id' => 'ct_paypal_mode',
                'type' => 'select',
                'options' => array (
                    'sandbox' => 'Sandbox',
                    'live' => 'Live',
                ),
                'title' => 'PayPal API',
                'default' => 'sandbox',
            ),
            array (
                //'desc' => '',
                'id' => 'ct_paypal_api_username',
                'type' => 'text',
                'title' => 'PayPal API Username',
            ),
            array (
                //'desc' => '',
                'id' => 'ct_paypal_api_password',
                'type' => 'text',
                'title' => 'PayPal API Password',
            ),
            array (
                //'desc' => '',
                'id' => 'ct_paypal_api_signature',
                'type' => 'text',
                'title' => 'PayPal API Signature',
            ),
            array (
                'desc' => 'Enter the email you\'d like to use to be notified after each transaction is processed.',
                'id' => 'ct_paypal_email',
                'type' => 'text',
                'title' => 'PayPal Receiving Email',
            ),
        )
    ) );

    if (function_exists('wpfp_link')) { 

        Redux::setSection( $opt_name, array(
            'title'            => __( 'WP Favorite Posts', 'contempo' ),
            'id'               => 'wp-favorite-posts',
            'icon'             => 'fa fa-heart',
            'customizer_width' => '450px',
            'fields'           => array(
                array (
                    'desc' => 'Select whether or not you\'d like to only let registered users to favorite listings.',
                    'id' => 'ct_fav_only_reg_users',
                    'type' => 'select',
                    'options' => array (
                        'yes' => 'Yes',
                        'no' => 'No',
                    ),
                    'title' => 'Only Allow Registered Users to Favorite?',
                    'default' => 'no',
                ),
                array (
                        'id' => 'saved-listings-info',
                        'type' => 'info',
                        'raw' => 'Create a Page > Select the Favorite Listings Page Template > Publish > Copy the ID of that Page and paste it below, once thats complete a link will appear in the top bar of the site.',
                    ),
                array (
                    'desc' => 'Enter your saved listings page ID here.',
                    'id' => 'ct_saved_listings',
                    'type' => 'text',
                    'title' => 'Saved Listings Page',
                    'default' => '632',
                ),
            )
        ) );

    }

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Blog Archive', 'contempo' ),
        'id'               => 'blog-archive',
        'icon'             => 'fa fa-archive',
        'customizer_width' => '450px',
        'fields'           => array(
           array (
                'desc' => 'Select whether or not you\'d like to display a sidebar or have the archive full width.',
                'id' => 'ct_archive_layout',
                'type' => 'select',
                'options' => array (
                    'sidebar' => 'Sidebar',
                    'full-width' => 'Full Width',
                ),
                'title' => 'Sidebar or Full Width?',
                'default' => 'sidebar',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Single Post', 'contempo' ),
        'id'               => 'single-post',
        'icon'             => 'fa fa-file-o',
        'customizer_width' => '450px',
        'fields'           => array(
           array (
                'desc' => 'Select whether or not you\'d like to display a sidebar or have the post full width.',
                'id' => 'ct_post_layout',
                'type' => 'select',
                'options' => array (
                    'sidebar' => 'Sidebar',
                    'full-width' => 'Full Width',
                ),
                'title' => 'Sidebar or Full Width?',
                'default' => 'sidebar',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to display the author image/avatar. The author image can be added in the users profile area, if one isn\'t uploaded the users gravatar is displayed. If you don\'t have a gravatar get one <a href="http://gravatar.com">here</a>.',
                'id' => 'ct_author_img',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Display Author Image?',
                'default' => 'yes',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to display the post meta.',
                'id' => 'ct_post_meta',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Display Post Meta?',
                'default' => 'yes',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to display the social links at the end of your posts.',
                'id' => 'ct_post_social',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Display Social Links?',
                'default' => 'yes',
            ),
            array (
                'desc' => 'Select wheter or not you\'d like to display tags at the end of your posts.',
                'id' => 'ct_post_tags',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Display Tags?',
                'default' => 'yes',
            ),
            array (
                'desc' => 'Select wheter or not you\'d like to display the "About the Author" info at the end of your posts.',
                'id' => 'ct_author_info',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Display "About the Author" info?',
                'default' => 'yes',
            ),
            array (
                'desc' => 'Select wheter or not you\'d like to display related posts.',
                'id' => 'ct_related_posts',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Display Related Posts?',
                'default' => 'yes',
            ),
            array (
                'desc' => 'Select wheter or not you\'d like to display post navigation at the end of your posts.',
                'id' => 'ct_post_nav',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Display Post Navigation?',
                'default' => 'yes',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to display comments globally for posts.',
                'id' => 'ct_post_comments',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Display Comments?',
                'default' => 'yes',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Contact', 'contempo' ),
        'id'               => 'contact',
        'icon'             => 'fa fa-envelope',
        'customizer_width' => '450px',
        'fields'           => array(
            array (
                'desc' => 'The email address you would like your form submissions sent to (e.g. youremail@yourdomain.com).',
                'id' => 'ct_contact_email',
                'type' => 'text',
                'validate' => 'email',
                'msg' => 'Invalid email address.',
                'title' => 'Email Address',
                'placeholder' => 'contact@yourcompany.com',
            ),
            /*array (
                'desc' => 'Subject of the email sent by the contact form.',
                'id' => 'ct_contact_subject',
                'type' => 'text',
                'title' => 'Subject',
                'placeholder' => 'Inquiry from Your Website',
            ),*/
            array (
                'desc' => 'This is the text displayed if the form submission has been successful.',
                'id' => 'ct_contact_success',
                'type' => 'textarea',
                'title' => 'Success Message',
                'placeholder' => 'Thanks, we\'ll be getting back to you shortly!',
            ),
            array (
                'desc' => 'Select whether or not you\'d like to display a Google map of your location.',
                'id' => 'ct_contact_map',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Display Google Map?',
                'default' => 'yes',
            ),
            array (
                'desc' => 'Choose your map display type. NOTE: Only applies to single location map.',
                'id' => 'ct_contact_map_type',
                'type' => 'select',
                'options' => array (
                    'ROADMAP' => 'Roadmap',
                    'SATELLITE' => 'Satellite',
                    'HYBRID' => 'Hybrid',
                    'TERRAIN' => 'Terrain',
                ),
                'title' => 'Google Map Type?',
                'default' => 'ROADMAP',
            ),
            array (
                'desc' => '',
                'id' => 'ct_contact_map_location',
                'type' => 'text',
                'title' => 'Address',
                'default' => '849 West Harbor Dr. San Diego, CA 92101',
            ),
            array (
                'desc' => 'Turn this on to add multiple locations.',
                'id' => 'ct_contact_multiple_locations',
                'type' => 'select',
                'options' => array (
                    'on' => 'On',
                    'off' => 'Off',
                ),
                'title' => 'Multiple Locations',
                'default' => 'off',
            ),
            $fields = array(
               'id' => 'section-map-addresses',
               'type' => 'section',
               'title' => __('Map Addresses', 'contempo'),
               'subtitle' => __('Enter the address of your locations to be used in the Google Map, needs to be entered in this format for each entry: 849 West Harbor Dr. San Diego, CA 92101', 'contempo'),
               'required' => array('ct_contact_multiple_locations','equals','on'),
               'indent' => true 
            ),
            array (
                'desc' => '',
                'id' => 'ct_contact_map_location_one',
                'type' => 'text',
                'title' => 'Address One',
                'default' => '849 West Harbor Dr. San Diego, CA 92101',
            ),
            array (
                'desc' => 'Upload an image for address one.',
                'id' => 'ct_contact_map_location_image',
                'type' => 'media',
                'title' => 'Address One Image',
                'url' => true,
            ),
            array (
                'desc' => '',
                'id' => 'ct_contact_map_location_two',
                'type' => 'text',
                'title' => 'Address Two',
                'placeholder' => '700 Prospect St, La Jolla, CA 92037',
            ),
            array (
                'desc' => 'Upload an image for address two.',
                'id' => 'ct_contact_map_location_two_image',
                'type' => 'media',
                'title' => 'Address Two Image',
                'url' => true,
            ),
            array (
                'desc' => '',
                'id' => 'ct_contact_map_location_three',
                'type' => 'text',
                'title' => 'Address Three',
                'placeholder' => '3115 Ocean Front Walk, San Diego, CA 92109',
            ),
            array (
                'desc' => 'Upload an image for address three.',
                'id' => 'ct_contact_map_location_three_image',
                'type' => 'media',
                'title' => 'Address Three Image',
                'url' => true,
            ),
            array (
                'desc' => '',
                'id' => 'ct_contact_map_location_four',
                'type' => 'text',
                'title' => 'Address Four',
                'placeholder' => '7510 Hazard Center Dr, San Diego, CA 92108',
            ),
            array (
                'desc' => 'Upload an image for address four.',
                'id' => 'ct_contact_map_location_four_image',
                'type' => 'media',
                'title' => 'Address Four Image',
                'url' => true,
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Custom CSS', 'contempo' ),
        'id'               => 'custom-css',
        'icon'             => 'fa fa-css3',
        'customizer_width' => '450px',
        'fields'           => array(
            array (
                'desc' => 'Quickly add some CSS to your theme by adding it to this block.',
                'id' => 'ct_custom_css',
                'type' => 'textarea',
                'title' => 'Custom CSS',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Custom JS', 'contempo' ),
        'id'               => 'custom-js',
        'icon'             => 'fa fa-file-code-o',
        'customizer_width' => '450px',
        'fields'           => array(
            array (
                'desc' => 'Recommended for Advanced Users only, one small hiccup in this code can bring your site down.',
                'id' => 'ct_custom_js',
                'type' => 'textarea',
                'title' => 'Custom JS',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Footer', 'contempo' ),
        'id'               => 'footer',
        'icon'             => 'fa fa-th',
        'customizer_width' => '450px',
        'fields'           => array(
            array (
                'desc' => 'Select whether or not you\'d like to display the widget ready area.',
                'id' => 'ct_footer_widget',
                'type' => 'select',
                'options' => array (
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'title' => 'Display Widget Area?',
                'default' => 'yes',
            ),
            array (
                'desc' => 'Upload a background image for the footer.',
                'id' => 'ct_footer_background_img',
                'type' => 'media',
                'title' => 'Footer Background Image',
                'url' => true,
            ),
            array (
                'desc' => 'Enter your custom footer text here.',
                'id' => 'ct_footer_text',
                'type' => 'textarea',
                'title' => 'Footer Text',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Import/Export', 'contempo' ),
        'id'               => 'import-export',
        'icon'             => 'fa fa-refresh',
        'customizer_width' => '450px',
        'fields'           => array(

            array(
                'id'            => 'opt-import-export',
                'type'          => 'import_export',
                'title'         => 'Import Export',
                'subtitle'      => 'Save and restore your Redux options',
                'full_width'    => false,
            ),

        )
    ) );

    if ( file_exists( dirname( __FILE__ ) . '/../theme-documentation/index.html' ) ) {
        $section = array(
            'icon'   => 'fa fa-institution',
            'title'  => __( 'Documentation', 'redux-framework-demo' ),
            'fields' => array(
                array(
                    'id'       => 'documentation',
                    'type'     => 'raw',
                    'markdown' => false,
                    'content_path' => dirname( __FILE__ ) . '/../theme-documentation/index.html', // FULL PATH, not relative please
                    //'content' => 'Raw content here',
                ),
            ),
        );
        Redux::setSection( $opt_name, $section );
    }

    if ( file_exists( dirname( __FILE__ ) . '/../theme-changelog/index.html' ) ) {
        $section = array(
            'icon'   => 'fa fa-code',
            'title'  => __( 'Changelog', 'redux-framework-demo' ),
            'fields' => array(
                array(
                    'id'       => 'changelog',
                    'type'     => 'raw',
                    'markdown' => false,
                    'content_path' => dirname( __FILE__ ) . '/../theme-changelog/index.html', // FULL PATH, not relative please
                    //'content' => 'Raw content here',
                ),
            ),
        );
        Redux::setSection( $opt_name, $section );
    }

    Redux::setSection( $opt_name, array(
        'id' => 'wbc_importer_section',
        'title'  => esc_html__( 'Demo Importer', 'framework' ),
        'desc'   => __( 'Works best to import on a new install of WordPress. Recommend using the <a href="https://wordpress.org/plugins/wordpress-reset/" target="_blank">WordPress Reset plugin</a> before switching between demos. <strong>If the progress bar hangs, don\'t fear the worst its a simple fix please see this <a href="https://contempo.ticksy.com/article/5952/">KB article</a></strong>.', 'framework' ),
        'icon'   => 'fa fa-cloud-download',
        'fields' => array(
            array(
                'id'   => 'wbc_demo_importer',
                'type' => 'wbc_importer'
            )
        )
    ) );

    /*
     * <--- END SECTIONS
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    //add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $return['error'] = $field;
                $field['msg']    = 'your custom error message';
            }

            if ( $warning == true ) {
                $return['warning'] = $field;
                $field['msg']      = 'your custom warning message';
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => __( 'Section via hook', 'contempo' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'contempo' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }

    if ( !function_exists( 'wbc_filter_title' ) ) {
        /**
         * Filter for changing demo title in options panel so it's not folder name.
         *
         * @param [string] $title name of demo data folder
         *
         * @return [string] return title for demo name.
         */
        function wbc_filter_title( $title ) {
            return trim( ucfirst( str_replace( "-", " ", $title ) ) );
        }
        // Uncomment the below
        add_filter( 'wbc_importer_directory_title', 'wbc_filter_title', 10 );
    }

    if ( !function_exists( 'wbc_extended_example' ) ) {
        function wbc_extended_example( $demo_active_import , $demo_directory_path ) {
            reset( $demo_active_import );
            $current_key = key( $demo_active_import );
            /************************************************************************
            * Import slider(s) for the current demo being imported
            *************************************************************************/
            if ( class_exists( 'RevSlider' ) ) {
                //If it's demo3 or demo5
                $wbc_sliders_array = array(
                    'multi-listing' => 'home-realestate.zip', //Set slider zip name
                    'vacation-rentals' => 'home-vacation.zip', //Set slider zip name
                );
                if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_sliders_array ) ) {
                    $wbc_slider_import = $wbc_sliders_array[$demo_active_import[$current_key]['directory']];
                    if ( file_exists( $demo_directory_path.$wbc_slider_import ) ) {
                        $slider = new RevSlider();
                        $slider->importSliderFromPost( true, true, $demo_directory_path.$wbc_slider_import );
                    }
                }
            }
            /************************************************************************
            * Setting Menus
            *************************************************************************/
            // If it's demo1 - demo6
            $wbc_menu_array = array( 'landing-page', 'multi-listing', 'vacation-rentals');
            if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && in_array( $demo_active_import[$current_key]['directory'], $wbc_menu_array ) ) {
                $primary = get_term_by( 'name', 'Primary', 'nav_menu' );
                $footer = get_term_by( 'name', 'Footer', 'nav_menu' );
                if ( isset( $primary->term_id ) ) {
                    set_theme_mod( 'nav_menu_locations', array(
                            'primary_left' => $primary->term_id,
                            'primary_right'  => $primary->term_id,
                            'footer'  => $footer->term_id
                        )
                    );
                }
            }
            /************************************************************************
            * Set HomePage
            *************************************************************************/
            // array of demos/homepages to check/select from
            $wbc_home_pages = array(
                'landing-page' => 'Home',
                'multi-listing' => 'Home',
                'vacation-rentals' => 'Home'
            );
            if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
                $page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
                if ( isset( $page->ID ) ) {
                    update_option( 'page_on_front', $page->ID );
                    update_option( 'show_on_front', 'page' );
                }
            }
        }
        add_action( 'wbc_importer_after_content_import', 'wbc_extended_example', 10, 2 );
    }
