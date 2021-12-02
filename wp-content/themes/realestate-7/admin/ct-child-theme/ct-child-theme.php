<?php /*
**************************************************************************

Description: Contempo Child Theme Generator
Date Created: 8-19-2011
Author: Based on the work of the One-Click Child Theme plugin by http://terrychay.com/.

**************************************************************************/

class ct_ChildTheme {
	private $plugin_dir = '';
	function __construct() {
		$this->plugin_dir = dirname(__FILE__);
		// it has to be buried like this or you get an error "You do not have sufficient permissions to access this page"
		add_filter( 'admin_menu', array( $this, 'createMenu' ) );
	}
	function createMenu() {
		add_theme_page( 'Make a Child Theme', 'Create Child Theme', 'install_themes', 'ct-child-theme-page', array( $this, 'showThemePage' ) );
	}

    function create_blank($file) {
        if ($file == 'functions.php') {
            $file_tpl = BUFF_EOF;

            $file_tpl = '<?php' . "\n" . $file_tpl . "\n\n"; // no need to close php

            $file = $this->target_dir_path . $file;
            file_put_contents($file, $file_tpl, LOCK_EX);
        }
	}

	/**
	 * Show the theme page which has a form allowing you to child theme currently selected theme.
	 */

	function showThemePage() {
		$parent_theme_name = wp_get_theme();
		$parent_template = get_template(); //Doesn't play nice with the grandkids
		$parent_theme = get_stylesheet();
		$parent_version = $parent_theme_name->get( 'Version' );

		if ( !empty($_POST['theme_name']) ) {
			$theme_name = $_POST['theme_name'];
			$description = ( empty($_POST['description']) )
				? ''
				: $_POST['description'];
			$author_name = ( empty($_POST['author_name']) )
				? ''
				: $_POST['author_name'];
			// Turn a theme name into a directory name
			$theme_dir = sanitize_title( $theme_name );
			$theme_root = get_theme_root();
			// Validate theme name
			$theme_path = $theme_root.'/'.$theme_dir;
			if ( file_exists( $theme_path ) ) {
				$error = 'Theme directory already exists!';
			} else {
				mkdir( $theme_path );

				// Create Child Theme StyleSheet
				ob_start();
				require $this->plugin_dir.'/child-theme-css.php';
				$css = ob_get_clean();
				file_put_contents( $theme_path.'/style.css', $css );

				// Create functions file
	            $file_tpl = '<?php';
	            $file_tpl .= "\n" . '/**';
	            $file_tpl .= "\n" . ' * Child theme functions';
	            $file_tpl .= "\n" . ' *';
	            $file_tpl .= "\n" . ' * When using a child theme please review the following helpful links';
	            $file_tpl .= "\n" . ' * http://contempothemes.com/wp-real-estate-7/documentation/#childthemes';
	            $file_tpl .= "\n" . ' * http://contempothemes.com/wp-real-estate-7/documentation/#advdev';
	            $file_tpl .= "\n" . ' * http://codex.wordpress.org/Child_Themes';
	            $file_tpl .= "\n" . ' *';
	            $file_tpl .= "\n" . ' * Text Domain: contempo';
	            $file_tpl .= "\n" . ' *';
	            $file_tpl .= "\n" . ' */';
	            $file_tpl .= "\n\n";
	            $file_tpl .= '/**';
	            $file_tpl .= "\n" . ' * Load the parent theme style.css file';
	            $file_tpl .= "\n" . ' */';
	            $file_tpl .= "\n";
	            $file_tpl .= 'function ct_child_enqueue_parent_theme_style() {';
	            $file_tpl .= "\n";
	            $file_tpl .= "	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );";
	            $file_tpl .= "\n";
	            $file_tpl .= '}';
	            $file_tpl .= "\n";
	            $file_tpl .= "add_action('wp_enqueue_scripts', 'ct_child_enqueue_parent_theme_style');";
	            $file_tpl .= "\n\n";
	            $file_tpl .= '/**';
	            $file_tpl .= "\n" . ' * Add your custom code below this comment';
	            $file_tpl .= "\n" . ' */';
	            $file_tpl .= "\n\n";
	            $file_tpl .= '?>';
	            file_put_contents($theme_path.'/functions.php', $file_tpl, LOCK_EX);
				
				// Copy Parent Screenshot into Child directory
				$screenshot = $theme_root.'/'.$parent_theme.'/screenshot.png';
				$child_screenshot = $theme_path.'/screenshot.png';
				copy ($screenshot, $child_screenshot);

				// RTL support
				$rtl_theme = ( file_exists( $theme_root.'/'.$parent_theme.'/rtl.css' ) )
					? $parent_theme
					: 'twentyeleven'; //use the latest default theme rtl file
				ob_start();
				require $this->plugin_dir.'/rtl-css.php';
				$css = ob_get_clean();
				file_put_contents( $theme_path.'/rtl.css', $css );

				switch_theme( $parent_template, $theme_dir );
				echo '<div class="wrap">';
				printf( __('<h2>Theme Switched</h2>', 'contempo'));
				printf( __('<p><strong>Your new child theme has been created!</strong> You can now start customizing <a href="%s">here</a>.</p>', 'contempo'), admin_url( 'theme-editor.php' ) );
				//wp_redirect( admin_url('themes.php') ); //buffer issue :-(
				echo '</div>';
				exit;
			}
		}
		if ( !isset($theme_name) ) { $theme_name = ''; }
		if ( !isset($description) ) { $description = ''; }
		if ( empty($author) ) {
			global $current_user;
			wp_get_current_user();
			$author = $current_user->display_name;
		}
		require $this->plugin_dir.'/panel.php';
	}

}

new ct_ChildTheme();
?>
