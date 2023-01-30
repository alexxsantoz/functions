<?php
/**
 * Twenty Twenty functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

/**
 * Table of Contents:
 * Theme Support
 * Required Files
 * Register Styles
 * Register Scripts
 * Register Menus
 * Custom Logo
 * WP Body Open
 * Register Sidebars
 * Enqueue Block Editor Assets
 * Enqueue Classic Editor Styles
 * Block Editor Settings
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */

function twentytwenty_theme_support() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Custom background color.
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'f5efe0',
		)
	);

	// Set content-width.
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 580;
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Set post thumbnail size.
	set_post_thumbnail_size( 1200, 9999 );

	// Add custom image size used in Cover Template.
	add_image_size( 'twentytwenty-fullscreen', 1980, 9999 );

	// Custom logo.
	$logo_width  = 120;
	$logo_height = 90;

	// If the retina setting is active, double the recommended width and height.
	if ( get_theme_mod( 'retina_logo', false ) ) {
		$logo_width  = floor( $logo_width * 2 );
		$logo_height = floor( $logo_height * 2 );
	}


	add_theme_support(
		'custom-logo',
		array(
			'height'      => $logo_height,
			'width'       => $logo_width,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
		)
	);

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Twenty Twenty, use a find and replace
	 * to change 'twentytwenty' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentytwenty' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	/*
	 * Adds starter content to highlight the theme on fresh sites.
	 * This is done conditionally to avoid loading the starter content on every
	 * page load, as it is a one-off operation only needed once in the customizer.
	 */
	if ( is_customize_preview() ) {
		require get_template_directory() . '/inc/starter-content.php';
		add_theme_support( 'starter-content', twentytwenty_get_starter_content() );
	}

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Adds `async` and `defer` support for scripts registered or enqueued
	 * by the theme.
	 */
	$loader = new TwentyTwenty_Script_Loader();
	add_filter( 'script_loader_tag', array( $loader, 'filter_script_loader_tag' ), 10, 2 );

}

add_action( 'after_setup_theme', 'twentytwenty_theme_support' );


/**
 * REQUIRED FILES
 * Include required files.
 */
require get_template_directory() . '/inc/template-tags.php';

// Handle SVG icons.
require get_template_directory() . '/classes/class-twentytwenty-svg-icons.php';
require get_template_directory() . '/inc/svg-icons.php';

// Handle Customizer settings.
require get_template_directory() . '/classes/class-twentytwenty-customize.php';

// Require Separator Control class.
require get_template_directory() . '/classes/class-twentytwenty-separator-control.php';

// Custom comment walker.
require get_template_directory() . '/classes/class-twentytwenty-walker-comment.php';

// Custom page walker.
require get_template_directory() . '/classes/class-twentytwenty-walker-page.php';

// Custom script loader class.
require get_template_directory() . '/classes/class-twentytwenty-script-loader.php';

// Non-latin language handling.
require get_template_directory() . '/classes/class-twentytwenty-non-latin-languages.php';

// Custom CSS.
require get_template_directory() . '/inc/custom-css.php';

/**
 * Register and Enqueue Styles.
 */
function twentytwenty_register_styles() {

	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'twentytwenty-style', get_stylesheet_uri(), array(), $theme_version );
	wp_style_add_data( 'twentytwenty-style', 'rtl', 'replace' );

	// Add output of Customizer settings as inline style.
	wp_add_inline_style( 'twentytwenty-style', twentytwenty_get_customizer_css( 'front-end' ) );

	// Add print CSS.
	wp_enqueue_style( 'twentytwenty-print-style', get_template_directory_uri() . '/print.css', null, $theme_version, 'print' );


	wp_enqueue_script( 'jquery-js', get_template_directory_uri()."/assets/js/jquery-3.3.1.slim.min.js", array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );

	wp_enqueue_script( 'popper-js', get_template_directory_uri()."/js/popper.min.js", array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );

	wp_enqueue_script( 'bootstrap-js', home_url()."/js/bootstrap.min.js", array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );


	wp_enqueue_script( 'countdown-js', get_template_directory_uri()."/assets/js/jquery.countdown.min.js", array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );

	wp_enqueue_script( 'countdown_bootstrap-js', get_template_directory_uri()."/assets/js/countdown_bootstrap.js", array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );

	wp_enqueue_script( 'waterecon-js', get_template_directory_uri()."/assets/js/waterecon.js", array( 'jquery' ), time(), true );

	
	wp_enqueue_style( 'bootstrap-css', home_url().'/css/bootstrap.min.css' );
	
	wp_enqueue_style( 'cocoen-css', home_url().'/css/cocoen.min.css' ); 
	

	?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script>
var wp,acf ="";
  window.dataLayer = window.dataLayer || [];

</script>
<style>#acf-hidden-wp-editor{display:none}</style>
	<?php
	
	

}

add_action( 'wp_enqueue_scripts', 'twentytwenty_register_styles' );

	
function remove_scripts_styles_footer() {
	//----- CSS
	wp_deregister_style( 'dashicons-css' );
	wp_dequeue_style( 'dashicons-css' );
	wp_deregister_style( 'editor-buttons-css' );
	wp_dequeue_style( 'editor-buttons-css' );
	wp_deregister_script( 'wp-tinymce-root-js' );
	wp_dequeue_script( 'wp-tinymce-root-js' );
	
}

add_action('wp_enqueue_scripts', 'remove_scripts_styles_footer');






function add_logo_menu_admin(){

if(is_user_logged_in()){

			global $menu;

			$user = wp_get_current_user();

			$user_role = $user->roles;

			
		$url = home_url("/");

		$img = "<img id='image-preview' src='".wp_get_attachment_url( get_option( 'logo_attachment_id' ) )."' width='100%' >";

		$menu[0] = array($img,"read",$url,"shomtek-logo","shomtek-logo");

		$frontpage_id = get_option( 'page_on_front' );

		
	?>
		<style type="text/css">
			.wp-first-item .wp-menu-image.dashicons-before,.bookmify_be_header{
				display: none !important;
			}
			#adminmenu{
				margin-top: 0px !important;
			}
			.wp-first-item .wp-menu-name{
				padding: 0px !important;
				background-color: #fff;
			}

			

			 #toplevel_page_agenda ul.wp-submenu{
    		    position: relative;
				    top: 0px;
				    left: 0px;
				    box-shadow: none;
    		}
    		#adminmenu .wp-submenu li:hover{
    			background-color: #20202020 !important;
    		}

    		#wpadminbar #wp-admin-bar-menu-toggle .ab-icon:before{
    			color:#fff;
    		}



		</style>
		<?php
	}
}





if(( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ){
	add_action( 'admin_menu', 'add_logo_menu_admin' );
}






function meta_tag(){

	echo '<meta name="robots" content="index,follow"/>' . "\n";
	echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">';
	echo '<meta name="publisher" content="'.home_url().'">';


		$nome 		= get_option( 'blogname' );
		$descricao 	= get_option( 'blogdescription' );
		$sobre 		= get_option( 'sobre' );
		$redes 		= get_option( 'bookmify_be_company_redes' );
		$logo 		= get_option( 'logo_attachment_id' );
    	$url 		= home_url("/");


		#echo '<link rel="canonical" href="'.$url.'">';
		echo '<meta name="og:author" content="'.$nome .'">';
		echo '<meta name="author" content="'.$nome .'">';
		echo '<meta name="og:image" content="' . $logo . '" />' . "\n";
		echo '<meta name="og:url" content="' . $url . '" />' . "\n";
		echo '<meta name="og:type" content="webpage" />' . "\n";
        echo '<meta name="og:description" content="'.$descricao.'" />' . "\n";
        echo '<meta name="description" content="'.$descricao.'" />' . "\n";



}


add_action( 'wp_head', 'meta_tag' );




function da_bp_set_title_tag(){

		$title 	= get_option( 'blogdescription' );
    	//$title = get_option("bookmify_be_company_info_name");
    	//if(isset($_POST["terms"])){
    	//	 $title .= " - " . $_POST["terms"]->name;
    	//}
    	return $title;

}


add_filter( 'pre_get_document_title', 'da_bp_set_title_tag', 999, 1);

/**
 * Register and Enqueue Scripts.
 */
function twentytwenty_register_scripts() {

	$theme_version = wp_get_theme()->get( 'Version' );

	if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'twentytwenty-js', get_template_directory_uri() . '/assets/js/index.js', array(), $theme_version, false );
	wp_script_add_data( 'twentytwenty-js', 'async', true );

	?>
<!-- ManyChat -->

	<?php

}

add_action( 'wp_enqueue_scripts', 'twentytwenty_register_scripts' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function twentytwenty_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.

	acf_enqueue_uploader();

	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>


<script type="text/javascript">

	jQuery(".accordion-button").on("click",function(a){
		var accord  = jQuery(this)[0].dataset["acname"];
			console.log(accord);
		//jQuery(".accordion-collapse").removeClass("show")
		jQuery("#"+accord).toggleClass("collapse").toggleClass("show")
		
	})

</script>


	<?php
}
add_action( 'wp_print_footer_scripts', 'twentytwenty_skip_link_focus_fix' );

/** Enqueue non-latin language styles
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function twentytwenty_non_latin_languages() {
	$custom_css = TwentyTwenty_Non_Latin_Languages::get_non_latin_css( 'front-end' );

	if ( $custom_css ) {
		wp_add_inline_style( 'twentytwenty-style', $custom_css );
	}
}

add_action( 'wp_enqueue_scripts', 'twentytwenty_non_latin_languages' );

/**
 * Register navigation menus uses wp_nav_menu in five places.
 */
function twentytwenty_menus() {

	$locations = array(
		'primary'  => __( 'Desktop Horizontal Menu', 'twentytwenty' ),
		'expanded' => __( 'Desktop Expanded Menu', 'twentytwenty' ),
		'mobile'   => __( 'Mobile Menu', 'twentytwenty' ),
		'footer'   => __( 'Footer Menu', 'twentytwenty' ),
		'social'   => __( 'Social Menu', 'twentytwenty' ),
	);

	register_nav_menus( $locations );
}

add_action( 'init', 'twentytwenty_menus' );

/**
 * Get the information about the logo.
 *
 * @param string $html The HTML output from get_custom_logo (core function).
 * @return string
 */
function twentytwenty_get_custom_logo( $html ) {

	$logo_id = get_theme_mod( 'custom_logo' );

	if ( ! $logo_id ) {
		return $html;
	}

	$logo = wp_get_attachment_image_src( $logo_id, 'full' );

	if ( $logo ) {
		// For clarity.
		$logo_width  = esc_attr( $logo[1] );
		$logo_height = esc_attr( $logo[2] );

		// If the retina logo setting is active, reduce the width/height by half.
		if ( get_theme_mod( 'retina_logo', false ) ) {
			$logo_width  = floor( $logo_width / 2 );
			$logo_height = floor( $logo_height / 2 );

			$search = array(
				'/width=\"\d+\"/iU',
				'/height=\"\d+\"/iU',
			);

			$replace = array(
				"width=\"{$logo_width}\"",
				"height=\"{$logo_height}\"",
			);

			// Add a style attribute with the height, or append the height to the style attribute if the style attribute already exists.
			if ( strpos( $html, ' style=' ) === false ) {
				$search[]  = '/(src=)/';
				$replace[] = "style=\"height: {$logo_height}px;\" src=";
			} else {
				$search[]  = '/(style="[^"]*)/';
				$replace[] = "$1 height: {$logo_height}px;";
			}

			$html = preg_replace( $search, $replace, $html );

		}
	}

	return $html;

}

add_filter( 'get_custom_logo', 'twentytwenty_get_custom_logo' );

if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 * Shim for wp_body_open, ensuring backward compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

/**
 * Include a skip to content link at the top of the page so that users can bypass the menu.
 */
function twentytwenty_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#site-content">' . __( 'Skip to the content', 'twentytwenty' ) . '</a>';
}

add_action( 'wp_body_open', 'twentytwenty_skip_link', 5 );

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentytwenty_sidebar_registration() {

	// Arguments used in all register_sidebar() calls.
	$shared_args = array(
		'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
		'after_title'   => '</h2>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></div>',
	);

	// Footer #1.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer #1', 'twentytwenty' ),
				'id'          => 'sidebar-1',
				'description' => __( 'Widgets in this area will be displayed in the first column in the footer.', 'twentytwenty' ),
			)
		)
	);

	// Footer #2.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer #2', 'twentytwenty' ),
				'id'          => 'sidebar-2',
				'description' => __( 'Widgets in this area will be displayed in the second column in the footer.', 'twentytwenty' ),
			)
		)
	);

}

add_action( 'widgets_init', 'twentytwenty_sidebar_registration' );

/**
 * Enqueue supplemental block editor styles.
 */
function twentytwenty_block_editor_styles() {

	// Enqueue the editor styles.
	wp_enqueue_style( 'twentytwenty-block-editor-styles', get_theme_file_uri( '/assets/css/editor-style-block.css' ), array(), wp_get_theme()->get( 'Version' ), 'all' );
	wp_style_add_data( 'twentytwenty-block-editor-styles', 'rtl', 'replace' );

	// Add inline style from the Customizer.
	wp_add_inline_style( 'twentytwenty-block-editor-styles', twentytwenty_get_customizer_css( 'block-editor' ) );

	// Add inline style for non-latin fonts.
	wp_add_inline_style( 'twentytwenty-block-editor-styles', TwentyTwenty_Non_Latin_Languages::get_non_latin_css( 'block-editor' ) );

	// Enqueue the editor script.
	wp_enqueue_script( 'twentytwenty-block-editor-script', get_theme_file_uri( '/assets/js/editor-script-block.js' ), array( 'wp-blocks', 'wp-dom' ), wp_get_theme()->get( 'Version' ), true );
}

add_action( 'enqueue_block_editor_assets', 'twentytwenty_block_editor_styles', 1, 1 );

/**
 * Enqueue classic editor styles.
 */
function twentytwenty_classic_editor_styles() {

	$classic_editor_styles = array(
		'/assets/css/editor-style-classic.css',
	);

	add_editor_style( $classic_editor_styles );

}

add_action( 'init', 'twentytwenty_classic_editor_styles' );

/**
 * Output Customizer settings in the classic editor.
 * Adds styles to the head of the TinyMCE iframe. Kudos to @Otto42 for the original solution.
 *
 * @param array $mce_init TinyMCE styles.
 * @return array TinyMCE styles.
 */
function twentytwenty_add_classic_editor_customizer_styles( $mce_init ) {

	$styles = twentytwenty_get_customizer_css( 'classic-editor' );

	if ( ! isset( $mce_init['content_style'] ) ) {
		$mce_init['content_style'] = $styles . ' ';
	} else {
		$mce_init['content_style'] .= ' ' . $styles . ' ';
	}

	return $mce_init;

}

add_filter( 'tiny_mce_before_init', 'twentytwenty_add_classic_editor_customizer_styles' );

/**
 * Output non-latin font styles in the classic editor.
 * Adds styles to the head of the TinyMCE iframe. Kudos to @Otto42 for the original solution.
 *
 * @param array $mce_init TinyMCE styles.
 * @return array TinyMCE styles.
 */
function twentytwenty_add_classic_editor_non_latin_styles( $mce_init ) {

	$styles = TwentyTwenty_Non_Latin_Languages::get_non_latin_css( 'classic-editor' );

	// Return if there are no styles to add.
	if ( ! $styles ) {
		return $mce_init;
	}

	if ( ! isset( $mce_init['content_style'] ) ) {
		$mce_init['content_style'] = $styles . ' ';
	} else {
		$mce_init['content_style'] .= ' ' . $styles . ' ';
	}

	return $mce_init;

}

add_filter( 'tiny_mce_before_init', 'twentytwenty_add_classic_editor_non_latin_styles' );

/**
 * Block Editor Settings.
 * Add custom colors and font sizes to the block editor.
 */
function twentytwenty_block_editor_settings() {

	// Block Editor Palette.
	$editor_color_palette = array(
		array(
			'name'  => __( 'Accent Color', 'twentytwenty' ),
			'slug'  => 'accent',
			'color' => twentytwenty_get_color_for_area( 'content', 'accent' ),
		),
		array(
			'name'  => __( 'Primary', 'twentytwenty' ),
			'slug'  => 'primary',
			'color' => twentytwenty_get_color_for_area( 'content', 'text' ),
		),
		array(
			'name'  => __( 'Secondary', 'twentytwenty' ),
			'slug'  => 'secondary',
			'color' => twentytwenty_get_color_for_area( 'content', 'secondary' ),
		),
		array(
			'name'  => __( 'Subtle Background', 'twentytwenty' ),
			'slug'  => 'subtle-background',
			'color' => twentytwenty_get_color_for_area( 'content', 'borders' ),
		),
	);

	// Add the background option.
	$background_color = get_theme_mod( 'background_color' );
	if ( ! $background_color ) {
		$background_color_arr = get_theme_support( 'custom-background' );
		$background_color     = $background_color_arr[0]['default-color'];
	}
	$editor_color_palette[] = array(
		'name'  => __( 'Background Color', 'twentytwenty' ),
		'slug'  => 'background',
		'color' => '#' . $background_color,
	);

	// If we have accent colors, add them to the block editor palette.
	if ( $editor_color_palette ) {
		add_theme_support( 'editor-color-palette', $editor_color_palette );
	}

	// Block Editor Font Sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => _x( 'Small', 'Name of the small font size in the block editor', 'twentytwenty' ),
				'shortName' => _x( 'S', 'Short name of the small font size in the block editor.', 'twentytwenty' ),
				'size'      => 18,
				'slug'      => 'small',
			),
			array(
				'name'      => _x( 'Regular', 'Name of the regular font size in the block editor', 'twentytwenty' ),
				'shortName' => _x( 'M', 'Short name of the regular font size in the block editor.', 'twentytwenty' ),
				'size'      => 21,
				'slug'      => 'normal',
			),
			array(
				'name'      => _x( 'Large', 'Name of the large font size in the block editor', 'twentytwenty' ),
				'shortName' => _x( 'L', 'Short name of the large font size in the block editor.', 'twentytwenty' ),
				'size'      => 26.25,
				'slug'      => 'large',
			),
			array(
				'name'      => _x( 'Larger', 'Name of the larger font size in the block editor', 'twentytwenty' ),
				'shortName' => _x( 'XL', 'Short name of the larger font size in the block editor.', 'twentytwenty' ),
				'size'      => 32,
				'slug'      => 'larger',
			),
		)
	);

	add_theme_support( 'editor-styles' );

	// If we have a dark background color then add support for dark editor style.
	// We can determine if the background color is dark by checking if the text-color is white.
	if ( '#ffffff' === strtolower( twentytwenty_get_color_for_area( 'content', 'text' ) ) ) {
		add_theme_support( 'dark-editor-style' );
	}

}

add_action( 'after_setup_theme', 'twentytwenty_block_editor_settings' );

/**
 * Overwrite default more tag with styling and screen reader markup.
 *
 * @param string $html The default output HTML for the more tag.
 * @return string
 */
function twentytwenty_read_more_tag( $html ) {
	return preg_replace( '/<a(.*)>(.*)<\/a>/iU', sprintf( '<div class="read-more-button-wrap"><a$1><span class="faux-button">$2</span> <span class="screen-reader-text">"%1$s"</span></a></div>', get_the_title( get_the_ID() ) ), $html );
}

add_filter( 'the_content_more_link', 'twentytwenty_read_more_tag' );

/**
 * Enqueues scripts for customizer controls & settings.
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function twentytwenty_customize_controls_enqueue_scripts() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// Add main customizer js file.
	wp_enqueue_script( 'twentytwenty-customize', get_template_directory_uri() . '/assets/js/customize.js', array( 'jquery' ), $theme_version, false );

	// Add script for color calculations.
	wp_enqueue_script( 'twentytwenty-color-calculations', get_template_directory_uri() . '/assets/js/color-calculations.js', array( 'wp-color-picker' ), $theme_version, false );

	// Add script for controls.
	wp_enqueue_script( 'twentytwenty-customize-controls', get_template_directory_uri() . '/assets/js/customize-controls.js', array( 'twentytwenty-color-calculations', 'customize-controls', 'underscore', 'jquery' ), $theme_version, false );
	wp_localize_script( 'twentytwenty-customize-controls', 'twentyTwentyBgColors', twentytwenty_get_customizer_color_vars() );
	
}

add_action( 'customize_controls_enqueue_scripts', 'twentytwenty_customize_controls_enqueue_scripts' );

/**
 * Enqueue scripts for the customizer preview.
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function twentytwenty_customize_preview_init() {
	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_script( 'twentytwenty-customize-preview', get_theme_file_uri( '/assets/js/customize-preview.js' ), array( 'customize-preview', 'customize-selective-refresh', 'jquery' ), $theme_version, true );
	wp_localize_script( 'twentytwenty-customize-preview', 'twentyTwentyBgColors', twentytwenty_get_customizer_color_vars() );
	wp_localize_script( 'twentytwenty-customize-preview', 'twentyTwentyPreviewEls', twentytwenty_get_elements_array() );

	wp_add_inline_script(
		'twentytwenty-customize-preview',
		sprintf(
			'wp.customize.selectiveRefresh.partialConstructor[ %1$s ].prototype.attrs = %2$s;',
			wp_json_encode( 'cover_opacity' ),
			wp_json_encode( twentytwenty_customize_opacity_range() )
		)
	);
}

add_action( 'customize_preview_init', 'twentytwenty_customize_preview_init' );

/**
 * Get accessible color for an area.
 *
 * @since Twenty Twenty 1.0
 *
 * @param string $area The area we want to get the colors for.
 * @param string $context Can be 'text' or 'accent'.
 * @return string Returns a HEX color.
 */
function twentytwenty_get_color_for_area( $area = 'content', $context = 'text' ) {

	// Get the value from the theme-mod.
	$settings = get_theme_mod(
		'accent_accessible_colors',
		array(
			'content'       => array(
				'text'      => '#000000',
				'accent'    => '#cd2653',
				'secondary' => '#6d6d6d',
				'borders'   => '#dcd7ca',
			),
			'header-footer' => array(
				'text'      => '#000000',
				'accent'    => '#cd2653',
				'secondary' => '#6d6d6d',
				'borders'   => '#dcd7ca',
			),
		)
	);

	// If we have a value return it.
	if ( isset( $settings[ $area ] ) && isset( $settings[ $area ][ $context ] ) ) {
		return $settings[ $area ][ $context ];
	}

	// Return false if the option doesn't exist.
	return false;
}

/**
 * Returns an array of variables for the customizer preview.
 *
 * @since Twenty Twenty 1.0
 *
 * @return array
 */
function twentytwenty_get_customizer_color_vars() {
	$colors = array(
		'content'       => array(
			'setting' => 'background_color',
		),
		'header-footer' => array(
			'setting' => 'header_footer_background_color',
		),
	);
	return $colors;
}

/**
 * Get an array of elements.
 *
 * @since Twenty Twenty 1.0
 *
 * @return array
 */
function twentytwenty_get_elements_array() {

	// The array is formatted like this:
	// [key-in-saved-setting][sub-key-in-setting][css-property] = [elements].
	$elements = array(
		'content'       => array(
			'accent'     => array(
				'color'            => array( '.color-accent', '.color-accent-hover:hover', '.color-accent-hover:focus', ':root .has-accent-color', '.has-drop-cap:not(:focus):first-letter', '.wp-block-button.is-style-outline', 'a' ),
				'border-color'     => array( 'blockquote', '.border-color-accent', '.border-color-accent-hover:hover', '.border-color-accent-hover:focus' ),
				'background-color' => array( 'button', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file .wp-block-file__button', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]', '.bg-accent', '.bg-accent-hover:hover', '.bg-accent-hover:focus', ':root .has-accent-background-color', '.comment-reply-link' ),
				'fill'             => array( '.fill-children-accent', '.fill-children-accent *' ),
			),
			'background' => array(
				'color'            => array( ':root .has-background-color', 'button', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file__button', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]', '.wp-block-button', '.comment-reply-link', '.has-background.has-primary-background-color:not(.has-text-color)', '.has-background.has-primary-background-color *:not(.has-text-color)', '.has-background.has-accent-background-color:not(.has-text-color)', '.has-background.has-accent-background-color *:not(.has-text-color)' ),
				'background-color' => array( ':root .has-background-background-color' ),
			),
			'text'       => array(
				'color'            => array( 'body', '.entry-title a', ':root .has-primary-color' ),
				'background-color' => array( ':root .has-primary-background-color' ),
			),
			'secondary'  => array(
				'color'            => array( 'cite', 'figcaption', '.wp-caption-text', '.post-meta', '.entry-content .wp-block-archives li', '.entry-content .wp-block-categories li', '.entry-content .wp-block-latest-posts li', '.wp-block-latest-comments__comment-date', '.wp-block-latest-posts__post-date', '.wp-block-embed figcaption', '.wp-block-image figcaption', '.wp-block-pullquote cite', '.comment-metadata', '.comment-respond .comment-notes', '.comment-respond .logged-in-as', '.pagination .dots', '.entry-content hr:not(.has-background)', 'hr.styled-separator', ':root .has-secondary-color' ),
				'background-color' => array( ':root .has-secondary-background-color' ),
			),
			'borders'    => array(
				'border-color'        => array( 'pre', 'fieldset', 'input', 'textarea', 'table', 'table *', 'hr' ),
				'background-color'    => array( 'caption', 'code', 'code', 'kbd', 'samp', '.wp-block-table.is-style-stripes tbody tr:nth-child(odd)', ':root .has-subtle-background-background-color' ),
				'border-bottom-color' => array( '.wp-block-table.is-style-stripes' ),
				'border-top-color'    => array( '.wp-block-latest-posts.is-grid li' ),
				'color'               => array( ':root .has-subtle-background-color' ),
			),
		),
		'header-footer' => array(
			'accent'     => array(
				'color'            => array( 'body:not(.overlay-header) .primary-menu > li > a', 'body:not(.overlay-header) .primary-menu > li > .icon', '.modal-menu a', '.footer-menu a, .footer-widgets a', '#site-footer .wp-block-button.is-style-outline', '.wp-block-pullquote:before', '.singular:not(.overlay-header) .entry-header a', '.archive-header a', '.header-footer-group .color-accent', '.header-footer-group .color-accent-hover:hover' ),
				'background-color' => array( '.social-icons a', '#site-footer button:not(.toggle)', '#site-footer .button', '#site-footer .faux-button', '#site-footer .wp-block-button__link', '#site-footer .wp-block-file__button', '#site-footer input[type="button"]', '#site-footer input[type="reset"]', '#site-footer input[type="submit"]' ),
			),
			'background' => array(
				'color'            => array( '.social-icons a', 'body:not(.overlay-header) .primary-menu ul', '.header-footer-group button', '.header-footer-group .button', '.header-footer-group .faux-button', '.header-footer-group .wp-block-button:not(.is-style-outline) .wp-block-button__link', '.header-footer-group .wp-block-file__button', '.header-footer-group input[type="button"]', '.header-footer-group input[type="reset"]', '.header-footer-group input[type="submit"]' ),
				'background-color' => array( '#site-header', '.footer-nav-widgets-wrapper', '#site-footer', '.menu-modal', '.menu-modal-inner', '.search-modal-inner', '.archive-header', '.singular .entry-header', '.singular .featured-media:before', '.wp-block-pullquote:before' ),
			),
			'text'       => array(
				'color'               => array( '.header-footer-group', 'body:not(.overlay-header) #site-header .toggle', '.menu-modal .toggle' ),
				'background-color'    => array( 'body:not(.overlay-header) .primary-menu ul' ),
				'border-bottom-color' => array( 'body:not(.overlay-header) .primary-menu > li > ul:after' ),
				'border-left-color'   => array( 'body:not(.overlay-header) .primary-menu ul ul:after' ),
			),
			'secondary'  => array(
				'color' => array( '.site-description', 'body:not(.overlay-header) .toggle-inner .toggle-text', '.widget .post-date', '.widget .rss-date', '.widget_archive li', '.widget_categories li', '.widget cite', '.widget_pages li', '.widget_meta li', '.widget_nav_menu li', '.powered-by-wordpress', '.to-the-top', '.singular .entry-header .post-meta', '.singular:not(.overlay-header) .entry-header .post-meta a' ),
			),
			'borders'    => array(
				'border-color'     => array( '.header-footer-group pre', '.header-footer-group fieldset', '.header-footer-group input', '.header-footer-group textarea', '.header-footer-group table', '.header-footer-group table *', '.footer-nav-widgets-wrapper', '#site-footer', '.menu-modal nav *', '.footer-widgets-outer-wrapper', '.footer-top' ),
				'background-color' => array( '.header-footer-group table caption', 'body:not(.overlay-header) .header-inner .toggle-wrapper::before' ),
			),
		),
	);

	/**
	* Filters Twenty Twenty theme elements
	*
	* @since Twenty Twenty 1.0
	*
	* @param array Array of elements
	*/
	return apply_filters( 'twentytwenty_get_elements_array', $elements );
}



function printArray($array){
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}


# pasta - /template-parts/content.php
function montaHome(){

	//printArray(get_field("block",get_the_ID()));
$qtd = 1;

	foreach(get_field("block",get_the_ID()) as $block){

		

		$header   	= $block["header"];
		$conteudo  	= $block["conteudo"];
		
//echo "a";
		montaSection($header,$conteudo,$qtd);
		
		$qtd++;
	}




}


function montaSection($header,$conteudo,$qtd){

	$class	 	= "";
	$titulo 	= "";
	$descricao 	= "";

	foreach ($header as $key => $value) {
		# code...
			$$key = $value;
			#echo $key ."=". $value;
	}

	$p = "";

	if($qtd>1){
		//$p = " pt-4 pb-4 padd";
	}

	//echo $conteudo["botao"];

	?>

	<div id="<?php echo sanitize_title($menu) ?>"></div>
		<section id="<?php echo $id ?>" class="sections <?php echo $class; echo $p?> col-12 text-center" style="background-image:url(<?php echo $conteudo["fundo"]["url"] ?>); background-color:<?php echo $conteudo["cor"] ?>; ">
			
				<div class="container p-0">
					<div class="row m-0 p-0">

						
						<div class="col-12 p-0 m-0 cabeca">

							<?php if(!empty($titulo)): ?>
								<div class="titulo h3">
									<?php echo $titulo ?>
								</div>
							<?php endif; ?>
								
								<?php if(!empty($descricao)): ?>
									<div class="desc cite">
										<?php echo $descricao ?>
									</div> 
								<?php endif; ?>
							
							<?php #echo $conteudo["categoria"]; ?>
								
								

						</div>
						
							<?php 
	
								if($conteudo["categoria"] != "Contador" ):
									montaConteudo($conteudo); 
								endif;
							 ?>
						<div class="col-12 p-0 m-0">
						<?php if($conteudo["categoria"] == "Botoes"): ?>

									<?php if(is_array($conteudo["botao"]) && isset($conteudo["botao"][0]) ): ?>
										<?php echo montaBotao($conteudo["botao"]); ?>
									<?php endif; ?>

								<?php endif; ?>

							<?php 
								if($conteudo["categoria"] == "Contador" && !empty($header["contador"])):
									echo montaContador($header["contador"]);
								endif;
							?>
						</div>
					</div>
				</div>

		</section>


	<?php

	#if(!empty($block["header"]["class"])) 		$class 		= 	$block["header"]["class"];
	#if(!empty($block["header"]["titulo"])) 		$titulo 	= 	$block["header"]["titulo"];
	#if(!empty($block["header"]["descricao"])) 	$descricao	= 	$block["header"]["descricao"];
		

}


function montaFormulario($form){
	
	
	acf_form(array(
        'post_id'       => 'new_post',
        'post_title'    => false,
        'post_content'  => false,
        'new_post'      => array(
            'post_type'     => $form,
            'post_status'   => 'publish'
        ),
        'post_title'  => true,
        'submit_value'  => 'enviar'
    )); 
	
	
}



function montaConteudo($conteudo){

	foreach ($conteudo as $key => $value) {
		# code...
			$$key = $value;
	}

	$contMid = "";
	$col=" col-sm-12 col-md-12 col-lg-6 ";
	
	if($midia=="Imagem"){

		$contMid = $imagem;

	}else if($midia=="Vídeo" ){

		$contMid = $video;
		
		
	}
	
		$ord = ' order-1 ';
		$ord_2 = ' order-12 ';


		if($categoria=="Banners") {
			
			$ord = " order-12 ";
			$ord_2 = " order-1 ";
			
		}

		 
		if($midia=="Vídeo" && $posicao == "centro"){
			
			$col="col-sm-12 col-md-10 col-lg-8 mx-auto ";
			
		}	
		if($midia=="Imagem" && $posicao == "centro"){
			
			$col="col-sm-12 col-md-10 col-lg-12 mx-auto ";
			
		}	
	
		if($midia=="Nenhum"){
			$col="col-sm-12 col-md-12 col-lg-12 ";
		}
	

	?>

		<div class="row col-12 m-0 p-0">
			
			<div class="<?php echo $col; echo $ord; ?>">
				
					<?php if(!empty($conteudo['titulo'])): ?>
						<div class="m-0 p-0 tituloMidia">
							<p> <?php echo $conteudo['titulo'] ?> </p>
						</div>
					<?php endif; ?>
				
				<?php echo montaMidia($midia,$contMid) ?>
				
				<?php if(!empty($conteudo['texto']) && $categoria != "Banners" ): ?>
					<div class="m-0 p-0 textoMidia">
						<p> <?php echo $conteudo['texto'] ?> </p>
					</div>
				<?php endif; ?>
				
			</div>
			
				<?php if(!empty($midia) && $midia =="Formulario"): ?>
					<?php montaFormulario($formulario) ?>
				<?php endif; ?>
			
			
			<?php if(!empty($categoria) && $categoria != "Banners"): ?>
				<div class="<?php echo $col; echo $ord_2; ?> m-0 p-0">
					
					<?php if(!empty($conteudo['titulo_posts'])): ?>
						<div class="m-0 p-0 tituloMidia">
							<p> <?php echo $conteudo['titulo_posts'] ?> </p>
						</div>
					<?php endif; 
						
						
						if(is_string($categ)){$cat=[]; $cat["a"] = $categoria; $cat["b"] = $categ; $categoria = $cat; };
						//printArray($categoria);
						?>
					
						<?php montaPosts($categoria,$tipo_de_post);   ?>
				</div>
			<?php endif; ?>
			
			
			<?php if($categoria == "Listas"): ?>
				<div class="accordion accordion-flush" id="accordionFlushExample">
					<?php montaLista($Lista) ?>
				</div>
			<?php endif; ?>
		
			<?php if(($categoria == "Texto" || $categoria == "Botoes") && !empty($conteudo['texto'])): ?>
				<div class="<?php echo $col; echo $ord_2; ?> m-0 p-0 textoBox">
					<p> <?php echo $conteudo['texto'] ?> </p>
				</div>
			<?php endif; ?>
			
			<?php if($categoria == "Banners" && !empty($conteudo['texto'])): ?>
				<div class="<?php echo $col; echo $ord_2; ?> m-0 p-0 textoBox">
					<p> <?php echo $conteudo['texto'] ?> </p>
				</div>
			<?php endif; ?>
			
				
			
		</div>

	<?php

	



}



function pegaImagem($image){


	return $image["url"];

}





function montaLista($Lista){

	
	$i = 1;
	foreach($Lista as $key){
		
		//print_r($key);
		$titulo = $key["titulo"];
		$texto = $key["texto"];
		
		?>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading<?php echo $i ?>">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $i ?>" data-acName="flush-collapse<?php echo $i ?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $i ?>">
       <?php echo $titulo ?>
      </button>
    </h2>
    <div id="flush-collapse<?php echo $i ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?php echo $i ?>" data-bs-parent="#accordionFlushExample<?php echo $i ?>">
      <div class="accordion-body"><?php echo $texto ?></div>
    </div>
  </div>

<?php
		$i++;
	}

}

function montaBotao($botoes=""){

	$bt ="";

	if( is_array($botoes) && count($botoes)>0 ) {

		$bt = "<div class='botoes'>";

		foreach ($botoes as $botao){

			foreach ($botao as $key => $value){
				
				$$key = $value;

			}
			
			$titulo_alt = $titulo;
					$icon = "<i class='fa fa-cartbuy'></i>";
					$classBtn = "link";
				if(strpos($link,"phone")>1){
					$classBtn = "whats";
					$icon = "<img class='iconBtn' width='40px' src='data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGhlaWdodD0iNTEycHgiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiB3aWR0aD0iNTEycHgiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxnIGlkPSJfeDMzXzc1LXdoYXRzYXBwIj48Zz48cGF0aCBkPSJNNDE3LjEwMyw5Mi44NDVDMzc0LjA4LDQ5LjcyMSwzMTYuNzg3LDI2LjAwMSwyNTUuODk3LDI2LjAwMSAgICBjLTEyNS42NzgsMC0yMjcuOTQ2LDEwMi4yNjktMjI3Ljk0NiwyMjcuOTQ1YzAsNDAuMTQ2LDEwLjQ3NCw3OS4zNywzMC4zOTQsMTEzLjk3M2wtMzIuMzQzLDExOC4wOGwxMjAuODUyLTMxLjcyOCAgICBjMzMuMjY4LDE4LjE3Myw3MC43NDQsMjcuNzI0LDEwOC45NDEsMjcuNzI0aDAuMTAzYzEyNS41NzYsMCwyMzAuMTAxLTEwMi4yNjksMjMwLjEwMS0yMjcuOTQ1ICAgIEM0ODUuOTk4LDE5My4xNjEsNDYwLjEyNSwxMzUuOTcsNDE3LjEwMyw5Mi44NDV6IiBzdHlsZT0iZmlsbDojMkNCNzQyOyIvPjxwYXRoIGQ9Ik0yNTUuODk3LDQ0My41OTNjLTM0LjA4OSwwLTY3LjQ2LTkuMTM4LTk2LjUxOC0yNi4zODhsLTYuODc5LTQuMTA3bC03MS42NywxOC43ODlsMTkuMDk5LTY5LjkyNCAgICBsLTQuNTE4LTcuMTg3Yy0xOC45OTUtMzAuMTg4LTI4Ljk1Ni02NC45OTUtMjguOTU2LTEwMC44M2MwLTEwNC40MjQsODUuMDE4LTE4OS40NCwxODkuNTQ1LTE4OS40NCAgICBjNTAuNjE5LDAsOTguMTU4LDE5LjcxNCwxMzMuODkyLDU1LjU0OGMzNS43MzEsMzUuODM1LDU3LjcwNSw4My4zNzYsNTcuNjAzLDEzMy45OTYgICAgQzQ0Ny40OTUsMzU4LjU3OCwzNjAuMzE5LDQ0My41OTMsMjU1Ljg5Nyw0NDMuNTkzeiIgc3R5bGU9ImZpbGw6I0ZGRkZGRjsiLz48cGF0aCBkPSJNMzU5LjgwNywzMDEuNjkxYy01LjY0Ny0yLjg3Mi0zMy42NzctMTYuNjM1LTM4LjkxNC0xOC40OGMtNS4yMzctMS45NTItOS4wMzUtMi44NzUtMTIuODM0LDIuODc1ICAgIHMtMTQuNjgzLDE4LjQ4LTE4LjA3MywyMi4zODRjLTMuMjg1LDMuNzk5LTYuNjc0LDQuMzEyLTEyLjMyMSwxLjQzN2MtMzMuNDczLTE2LjczNS01NS40NDUtMjkuODc4LTc3LjUyMS02Ny43NjggICAgYy01Ljg1My0xMC4wNjIsNS44NTQtOS4zNDQsMTYuNzM2LTMxLjExYzEuODUtMy44MDEsMC45MjYtNy4wODYtMC41MTQtOS45NjFjLTEuNDM2LTIuODc1LTEyLjgzNC0zMC45MDYtMTcuNTU3LTQyLjMwNCAgICBjLTQuNjItMTEuMDg5LTkuMzQzLTkuNTQ5LTEyLjgzNS05Ljc1NGMtMy4yODUtMC4yMDYtNy4wODYtMC4yMDYtMTAuODgzLTAuMjA2Yy0zLjgsMC05Ljk2LDEuNDM4LTE1LjE5Nyw3LjA4NSAgICBjLTUuMjM2LDUuNzUtMTkuOTIsMTkuNTEtMTkuOTIsNDcuNTQxczIwLjQzMiw1NS4xMzksMjMuMjA1LDU4LjkzN2MyLjg3NCwzLjc5OCw0MC4xNDgsNjEuMjk5LDk3LjMzOCw4Ni4wNDUgICAgYzM2LjE0NCwxNS42MDcsNTAuMzE0LDE2Ljk0LDY4LjM4NiwxNC4yNzFjMTAuOTg1LTEuNjQzLDMzLjY3OS0xMy43NTksMzguNDAxLTI3LjEwN2M0LjcyMy0xMy4zNDcsNC43MjMtMjQuNzQzLDMuMjg1LTI3LjEwNSAgICBDMzY5LjI1NSwzMDUuOTAxLDM2NS40NTQsMzA0LjQ2NSwzNTkuODA3LDMwMS42OTF6IiBzdHlsZT0iZmlsbDojMkNCNzQyOyIvPjwvZz48L2c+PGcgaWQ9IkxheWVyXzEiLz48L3N2Zz4='/>";
				}

			
			if(is_array(explode('||',$titulo)) && count(explode('||',$titulo))>1){
				
				$partTit = explode('||',$titulo);
				$part1 = $partTit[0];
				$part2 = $partTit[1];
				
				$titulo_alt = $part1 . $part2;
				
				$titulo = $part1 . "<em>".$part2."</em>";
				
				$bt .= '<a href="'.$link.'" target="_blank" class=" btn btn-sm m-2 '.$classBtn.'" style="background:'.$cor.'">'.$titulo.$icon.'</a> ';
				#$bt .= '<a onclick="return false;" href="'.$link.'?checkoutMode=2" class="hotmart-fb hotmart__button-checkout btn btn-sm m-2" style="background:'.$cor.'">'.$titulo.'</a> ';
			}else{
				
				$bt .= "<a href='".$link."'  title='".$titulo_alt."' class='btn btn-sm m-2 ".$classBtn."' style='background-color:".$cor."' >".$titulo.$icon."</a>";

			}
			
			

		}

		$bt .="</div>";



	}

	return $bt;
}



function montaMidia($midia,$contMid){


	if(!empty($contMid)){

	if($midia == "Imagem"){
		
		$midia = "<img src='".pegaImagem($contMid)."' />";
		
	}else if($midia == "Vídeo"){
		
		$codigo = "";
		
		if(count(explode("embed/",$contMid))>=2){
			$codigo = explode("embed/",$contMid)[1];
		}else if(count(explode("v=",$contMid))>=2){
			$codigo = explode("v=",$contMid)[1];
		}
		
		$linkVideo = "https://www.youtube.com/embed/".$codigo."?controls=0&showinfo=0&rel=0";
		
		$midia = '<iframe width="100%" height="419" src="'.$linkVideo.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
	}

	return $midia;
	}
}



function montaPosts($type,$tipo_de_post){

global $wp_query;
$original_query = $wp_query;
$wp_query = null;
	$attr = array();
	if(is_array($type)){
		$args['post_type'] = $type["a"];
		$arq = $type["a"].$type["b"];;
	}else{
		$args['post_type'] = strtolower($type);
		$arq = strtolower($type);
	}
		
	if(isset($tipo_de_post) && !empty($tipo_de_post)){
		$args['cat'] = implode(",",$tipo_de_post);
	};
	if(isset($type["b"]) && !empty($type["b"])){
			$args['category_name'] = $type["b"];
		};
	$args['posts_per_page'] = -1;
	
	query_posts( $args );

	$wp_query = new WP_Query( $args );
	
	//printArray($wp_query);
	
	if (have_posts()):
		
		$args['author'] = '';
		$args['numberposts'] = -1;
	
		if(isset($tipo_de_post) && !empty($tipo_de_post)){
			$args['cat'] = implode(",",$tipo_de_post);
		};
	
		if(isset($type["b"]) && !empty($type["b"])){
			$args['category_name'] = $type["b"];
		};
	
		query_posts( $args );	
		$wp_query = new WP_Query( $args );

	endif;
 
?>

	<div class="row card-columns m-0 p-0"> 
 
		<?php 
	
		//printArray($wp_query);
	
		if (  have_posts() && $args['post_type'] != "leads" && $args['post_type'] != "banners" && $args['post_type'] != "depoimentos" ): 
			$i=0;
			while ( have_posts() ) : the_post();
			$attr = "card_".$i++;
				get_template_part( 'template-parts/content/content', $arq, $attr );
			endwhile;
		
		elseif($args['post_type'] == "leads" || $args['post_type'] == "depoimentos"):
				get_template_part( 'template-parts/content/content', $arq );
		else:

		endif;

		?> 

	</div>

<?php

$wp_query = null;
$wp_query = $original_query;
wp_reset_postdata();


}


function montaPostCont($classCard = ""){
	
	$icone = get_field("icone",get_the_ID());
	$titulo = get_field("titulo",get_the_ID());
	$descricao = get_field("descricao",get_the_ID());
	$lista = get_field("lista",get_the_ID());
	
	$link = get_the_permalink();
	
	$img_url = "";
	$img_url = get_the_post_thumbnail_url(get_the_ID());
	$img_bk_url = get_the_post_thumbnail_url(get_the_ID());
		
	$h = " min-height:180px ";
	$class = "";
	if(	empty($icone["url"]) && empty($img_url) ) {

		$h = " ";
		$class = "sotxt d-none";

	}else if( empty($icone["url"]) && !empty($img_url)  ){

		
		$class = "soimg";

	}else if( !empty($icone["url"]) && !empty($img_url)  ){

		
		$class = "imgicon";

	}else if( !empty($icone["url"]) && empty($img_url) ){

			$img_url = $icone["url"];
			$class = "soicon";
	}


	?>
	<div class="card border-0 p-4 <?php echo $classCard ?>">
		<div class="card-body p-0">	
			<!-- <a href="<?php echo $link ?>"> -->
				<div class="card-figure text-center w-100 col-12 mb-4 <?php echo $class; ?> " style="background-size:cover; background-image: url(<?php #echo $img_bk_url ?>);  <?php echo $h ?>"> 
					<img class="d-inline" src="<?php echo  $img_url; ?>" > </div>
				<div class="card-title text-center w-100 col-12 mb-2"> <?php echo $titulo; ?> </div>
			
				<?php if(!empty($descricao)): ?>
					<div class="card-descript text-center w-100 col-12"> 
					<?php echo $descricao; ?> 
					</div> 
				<?php endif; ?>
			
				<?php if(!empty($lista)): ?>
					<div class="card-accordion w-100 col-12"> 
						<div class='contAccord'>
							<?php echo $lista; ?> 
						</div> 
					</div> 
					
				<?php endif; ?>
			<!-- </a> -->
		</div>
	</div>
	

	<?php
}



function trataTexto($title){

	$txt = explode("(?)", $title);

	$txt = "<div class='bn'>".$txt[0]."</div> <div class='info'> <span class='text'>".$txt[1]."</span></div>";

	return $txt;

}

function trataPreco($preco){

	$val = explode(".", $preco);

	if(isset($val[1]) && !empty($val[1])){
		$cent = "<span class='cent top'>,".$val[1]."</span>";
	}else{
		$cent = "<span class='cent top'>,70</span>";
	}
	
	if(strlen($val[0])>=4 ){
		$val_1 = substr($val[0], 0,1);
		$val_2 = substr($val[0], 1);
		$val[0]="";
		$val[0] = $val_1 .".". $val_2;
	}
	return "<span class='cur top'>R$</span>".$val[0].$cent;


}
function montaPlanos(){


		$preco = get_field("preco",get_the_ID());

	//	$preco = trataPreco($preco);
		$nameTitle = sanitize_title(get_the_title());
		$parcelas = get_field("parcelas",get_the_ID());
		$desconto = get_field("desconto",get_the_ID());
		$cadastrados = get_field("cadastrados",get_the_ID());

		$relevancia = get_field("relevancia",get_the_ID());

		if(isset($relevancia[0]) && !empty($relevancia[0])){ 

			$relevancia = $relevancia[0];

		}else{

			$relevancia = "";
		}

		$feat = get_field("feat",get_the_ID());
		//printArray($feat);

		$li = "";

		foreach ($feat as $value) {

			$li .= "<li class=' m-0 p-2'>".$value["titulo"]."</li>";
		}

		$bonus = get_field("bonus",get_the_ID());

		$bns = "";
		$tt = 0;
	if(is_array($bonus)){
		foreach ($bonus as $value) {

			$bns .= "<li class=' m-0 bonus'>".trataTexto($value["titulo"])." <div class='valor'>".trataPreco($value["valor"])."</div></li>";
			$tt = $tt+$value["valor"];
			
		}	
	}	
		?>

	<div class="card <?php echo $relevancia;?> <?php echo $nameTitle ?>">

		<div class="card-title"><?php echo  get_the_title() ?></div>
		<div class="card-body">
			
			<div class="preco"><?php echo trataPreco($preco); ?></div>
			<!--div class="precoReal"><?php echo trataPreco($preco*$parcelas); ?></div-->
			<!--div class="preco"><?php echo $parcelas ?></div-->
			
			<div class="det mt-4 mb-4">em <strong><?php echo $parcelas ?>x</strong> sem juros de<strong> <?php echo trataPreco($preco/$parcelas)?></strong> 
			</div>
			
			<div class="cadastrados">
				<?php echo $cadastrados ?>
			</div>

			<ul class="list-unstyled m-0">
				<?php echo $li ?>
			</ul>
			
			<ul class="list-unstyled m-0 lista_bonus">
				<h2 class="h2_bonus">- BÔNUS -</h2>
				<?php echo $bns ?>
				<h2 class="h2_total">Bônus de <?php echo trataPreco($tt) ?></h2>
			</ul>
			
		</div>
		
		<a href="<?php echo home_url("/produto/").$nameTitle; ?>" class="btn btn-sell">Quero esse</a>

	</div>
	
		<?php




}


function montaContador($contador){

	
	$somaD = date("d")+1;
	$dia =	date("Y")."/". date("m")."/".$somaD;
	
	?>	
	
	 <div class="rounded  p-5 text-center mb-5">
			<div id="clock-c" data-time="<?php echo $contador; ?>" class="countdown py-4"></div>
          <!--      <div id="clock-c" data-time="<?php echo $dia ?>" class="countdown py-4"></div>-->
     </div>


	<?php
	



}



function montaMenu(){


	$frontpage_id = get_option( 'page_on_front' );

	$layout = get_field("block",$frontpage_id);
	$qtd =0;
	$li = "";

	foreach($layout as $block){

		$menu  	= $block["header"]["menu"];

		if(!empty($menu)){

			if(is_front_page()){

			$link = "#".sanitize_title($menu);

			}else{
				$link = home_url("/")."#".sanitize_title($menu);
			}


			$li .= '<li id="menu-item-'.$qtd.'" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-'.$qtd.'">
					<a href="'.$link.'" aria-current="page">'.$menu.'</a>
					</li>';
			$header   	= $block["header"];
			
			$qtd++;
			//montaSection($header,$conteudo,$qtd);

			//echo $conteudo;
		}
		
	}

	return $li;


}






function action_acf_save_post( $post_id ) { 
	
	if(is_front_page()){
		
		
		$qtd_aptos = $_POST['qtd_aptos'];
$valor_conta = $_POST['valor_conta'];
$tem_poco_artesiano = $_POST['tem_poco_artesiano'];
$nome_do_consumidor_de_agua = $_POST['nome_do_consumidor_de_agua'];
$nome_do_representante = $_POST['nome_do_representante'];
$telefone = $_POST['telefone'];
$cidade = $_POST['cidade'];
		    
			$tableResidencial = "Tabela Residencial:\n\n";
$tableResidencial .= "Quantidade de apartamentos: $qtd_aptos\n";
$tableResidencial .= "Valor da conta: $valor_conta\n";
$tableResidencial .= "Tem poço artesiano: $tem_poco_artesiano\n";
$tableResidencial .= "Nome do consumidor de água: $nome_do_consumidor_de_agua\n";
$tableResidencial .= "Nome do representante: $nome_do_representante\n";
$tableResidencial .= "Telefone: $telefone\n";
$tableResidencial .= "Cidade: $cidade\n";

     $email   = "alex@famamedia.com"; //get_option( 'admin_email' );
        $subject = '[REVISAR NOVO Cadastro] ' . get_the_title( $post_id );
        $message = 'Existe um novo Cadastro para revisão: ' . get_the_title( $post_id ) . "\n";
        $message .= 'Revisar o Calculo: ' . admin_url( "post.php?post={$post_id}&action=edit" ) . "\n\n";
        $message .= 'Resultados:' . "\n";
		$message .= 'Comercial: ' . $tableComercial . "\n";
		$message .= 'Industrial: ' . $tableIndustrial . "\n";
		$message .= 'Residencial: ' . $tableResidencial . "\n";
		$headers = array(
  'From: webmaster@example.com',
  'Reply-To: webmaster@example.com',
  'X-Mailer: PHP/' . phpversion()
);
        
		
		
        if(wp_mail( $email, $subject, $message, $headers )){
			

			

      
	    
	
	         wp_redirect( 'resultado?cad='.$post_id );
        
            
        }
	exit();
		
	}
	
}; 
         
// add the action 
add_action( 'acf/save_post', 'action_acf_save_post', 10, 1 ); 


function montaResidencial($postId){
setlocale(LC_MONETARY,"pt_BR");

	$valores = get_fields($postId,false);
	//printArray($valores);
	$qtd_aptos = $valores["qtd_aptos"];
	
	$valor_conta = $valores["valor_conta"];
	
    $tem_poco_artesiano = $valores["tem_poco_artesiano"];
    
    $nome_do_consumidor_de_agua = $valores["nome_do_consumidor_de_agua"];
    $nome_do_representante = $valores["nome_do_representante"];
    $telefone = $valores["telefone"];
    $cidade = $valores["cidade"];
	
	
	
	//echo "precoRes=". $precoRes . "<br>";
	
	
	
	if($tem_poco_artesiano == "nao"){
		
		$precoRes = get_option('preco1');
		$econRes 	= get_option('econRes');
		$ConsumoEscrito = "Consumo";
		$consumo 	= $valores["consumo"];
		$pre10M 	= $precoRes/10;
		
		$cons_econ 	= round($consumo/$qtd_aptos,2);
		
		
		//echo "<br/>economias" . $economias;
		//echo "<br/>consumo" . $consumo;
		//echo "<br/>pre10M" . $pre10M;
		//echo "<br/>qtd_aptos" . $qtd_aptos;
		
		if($cons_econ <= 10 ){
			
			$val_devido	= round($cons_econ*($pre10M+$pre10M)*$qtd_aptos,2);
			
			//$val_devido = round($precoRes * $qtd_aptos,2);
			
		}elseif($cons_econ > 10 && $cons_econ <= 20  ){
			
			$val_devido	= round($cons_econ*($pre10M+$pre10M)*$qtd_aptos,2);

		}elseif($cons_econ > 20 && $cons_econ <= 50  ){
			
			$val_devido	= round($cons_econ*($pre10M+$pre10M)*$qtd_aptos,2);
			
		}elseif($cons_econ > 50  ){
			
		}
		
		$diferenca = $valor_conta - $val_devido;
		
	}else{
		
		$consumo 		= $valores["valor_poco"];
		$ConsumoEscrito = "Consumo Poço";
		//$econRes 	= get_option('econResPoco');
		
		$T1 	= get_option("tarRes1");
		$T2 	= get_option("tarRes2");
		$T3 	= get_option("tarRes3");
		$T4 	= get_option("tarRes4");
	
	
		$cons_econ 		= round($consumo/$qtd_aptos,2);
	
		//$val_devido 	= round($taRes[1]*$econRes,2);
		
		//echo $T1  . "<br/>";
		//echo $T2  . "<br/>";
		//echo $T3  . "<br/>";
		//echo $T4  . "<br/>";
		//echo $cons_econ . "<br/>";
		//echo $qtd_aptos . "<br/>";
		//$novaBase = $cons_econ;
		
		if($cons_econ <= 10 ){
			
			$val_devido	= round($T1*$qtd_aptos,2);
			//echo 'round($taRes[1]*$econRes,2)';
			
		}elseif($cons_econ > 20 && $cons_econ <= 50  ){
			
			$novaBase = $cons_econ-20;
			$calcT2 = round(10*$T2,2);
			$calcT3 = round($novaBase*$T3,2);
			
			$val_devido = round((($T1+$calcT2+$calcT3)*$qtd_aptos),2);

		}elseif($cons_econ>10 && $cons_econ<=20){
			
			//$val_devido = (($T1*2)*$qtdConj);
			$calcT2 = (($cons_econ-10)*$T2);
			$val_devido = round((($T1+$calcT2))*$qtd_aptos,2);

		}elseif($cons_econ>20 && $cons_econ<50){
			
			$novaBase = $cons_econ-20;
			$calcT2 = round(10*$T2,2);
			$calcT3 = round($novaBase*$T3,2);
			
			$val_devido = round((($T1+$calcT2+$calcT3))*$qtd_aptos,2);
	
		}elseif($cons_econ>50){
			
			$calcT2 = round(10*$T2,2);
			//$calcT3 = round($basCalc-20*$T3,2);
			$calcT3 = round(30*$T3,2);
			$calcT4 = round(($cons_econ-50)*$T4,2);
			
			$val_devido = round((($T1+$calcT2+$calcT3+$calcT4))*$qtd_aptos,2);
	
		} 
		
		
		
		
		
		
		
		$diferenca 	= $valor_conta - $val_devido;
	}
	
	
	
	return montaTabela($ConsumoEscrito,$consumo,$valor_conta,$val_devido,$diferenca);
	//printArray($valores);
	
}

function montaTabela($ConsumoEscrito,$consumo,$val_conta,$val_devido,$diferenca){
	
	$valorconta 	= number_format($val_conta,2,",",".");
	$valordevido 	= number_format($val_devido,2,",",".");
	$valorreal 		= number_format($diferenca,2,",",".");
	$valor_Anual 	= number_format($diferenca*12,2,",","."); 
	$valor_10anos 	= number_format($diferenca*120,2,",","."); 
	
	if(is_numeric($diferenca)){
		$porcento = round((($diferenca*100)/$val_conta),2)."%";
	}
	
	

	
	$table = "<div style='text-align:center;'><table style='text-align: center; margin-top:10px; width:300px; border-collapse: collapse; background: #edf5fd;' class='table' border:'1px'>
					<thead>
						<tr>
							<td style='background:#45546c;color:#fff;'><strong>{$ConsumoEscrito}</strong></td>
							<td style='background:#45546c;color:#fff;'><strong>Valor Pago</strong></td>
							<td style='background:#45546c;color:#fff;'><strong>Valor Real que deveria pagar</strong></td>
							<td style='background:#45546c;color:#fff;'><strong>Valor pago a mais em (R$)</strong></td>
							<td style='background:#45546c;color:#fff;'><strong>Valor pago a mais em (%)</strong></td>
						</tr>
					</thead>
					
					<tbody>
						<tr>
							<td>{$consumo}</td>
							<td>R$ {$valorconta}</td>
							<td>R$ {$valordevido}</td>
							<td>R$ {$valorreal}</td>
							<td><strong>{$porcento}</strong></td>
						</tr>
					</tbody>
					
					</table></div>";
	
	
	$table .= "<div style='text-align:center;'><table style='text-align: center; margin-top:10px; width:300px; border-collapse: collapse; background: #edf5fd;' class='table' border:'1px'>
					<thead>
						<tr>
							<td colspan='2' style='background:#45546c;color:#fff;'><strong> A analise abrange os últimos 120 meses (10 anos), sendo limitada a data de início da cobrança.</strong> </td>
						
							
						</tr>
						<tr>
							<td style='text-align:right'>Projeção de restituição para <strong>12 meses</strong> com base no histórico de faturamento:</td>
						
							<th style='background:#45546c;color:#fff;'>R$ {$valor_Anual}</th>
						</tr>
					</thead>
					
					<tbody>
						
						<tr>
							<td style='text-align:right'>Projeção de restituição para <strong>120 meses</strong> com base na média do faturamento:</td>
						
							<th style='background:#45546c;color:#fff;'>R$ {$valor_10anos}</th>
						</tr>
					</tbody>
					
					</table></div>";
	
	
	return $table;
	
	
}



function montaTabelaFatorK($ConsumoEscrito,$consumo,$val_conta,$val_devido,$diferenca){
	
	$valorconta 	= number_format($val_conta,2,",",".");
	$valordevido 	= number_format($val_devido,2,",",".");
	$valorreal 		= number_format($diferenca,2,",",".");
	$valor_Anual 	= number_format($diferenca*24,2,",","."); 
	$valor_10anos 	= number_format($diferenca*120,2,",","."); 
	
	if(is_numeric($diferenca)){
		$porcento = round((($diferenca*100)/$val_conta),2)."%";
	}
	
	
	$table = "	<table style='margin-bottom:0px;' class='table' border:'1px'>
					<thead>
						<tr>
							<td><strong>{$ConsumoEscrito}</strong></td>
							<td><strong>Valor Pago com Fator K</strong></td>
							<td><strong>Valor devido sem Fator K</strong></td>
							<td><strong>Valor pago a mais</strong></td>
							
						</tr>
					</thead>
					
					<tbody>
						<tr>
							<td>{$consumo}</td>
							<td>R$ {$valorconta}</td>
							<td>R$ {$valordevido}</td>
							<td>R$ {$valorreal}</td>
						</tr>
					</tbody>
					
					</table>";
	
	
	$table .= "<table style='margin-top:10px;' class='table' border:'1px'>
					
					<thead>
					
						<tr>
							<td  colspan='2' style='text-align:center'><strong>A analise abrange os últimos 120 meses (10 anos), sendo limitada a data de início da cobrança.</strong> </td>							
						</tr>
						
						<tr>
							<td style='text-align:right'>Projeção de restituição para <strong>24 meses</strong> com base no histórico de faturamento:</td>
							<th>R$ {$valor_Anual}</th>
						</tr>
						
					</thead>
					
					
					</table>";
	
	
	return $table;
	
	
}


function montaComercial($postId,$type){
	
	$valores = get_fields($postId,false);
	//print_r($valores);
	if(isset($valores['sub_categorias'])){
		$sub_categorias = $valores['sub_categorias'];
	}else{
		$sub_categorias = "";
	}
	
		$consumo 		= $valores["consumo"];
	
	if($type=="comercial"){
		if(!empty($valores["valor_ultima_conta"])){
			$valor_conta 	= $valores["valor_ultima_conta"];
		}else{
			$valor_conta 	= $valores["valor_durante_construcao"];
		}
	}
	
	if($type=="industrial"){
		
		$val_agua = $valores['apenas_agua'];
		$val_esgoto = $valores['apenas_esgoto'];	
		
		$valor_conta = $val_esgoto + $val_agua;

	}
	
	if( isset($sub_categorias) && $sub_categorias=="condominios"){
		
		$qtdConj 	= $valores['quantos_conjuntos'];
		
		
	}else if($sub_categorias=="shoppings"){
		
		$val_agua = $valores['apenas_agua'];
		$val_esgoto = $valores['apenas_esgoto'];
		
		//$qtdConj = $valores["quantas_lojas_excluindo_os_quiosques"];
	
		$valor_conta = $val_esgoto + $val_agua;
		
	} 
	
	if($type=="comercial" && isset($sub_categorias) && ( $sub_categorias != "condominios" && $sub_categorias != "shoppings" ) || $type=="industrial"){
		
		$val_agua = $valores['apenas_agua'];
		$val_esgoto = $valores['apenas_esgoto'];
		
		//echo "<h2>valor esgoto = ".$val_esgoto."</br>";
		//echo "valor agua = ".$val_agua."</br></h2>";
		
		//echo "<h1> esgoto - agua = ".($val_esgoto - $val_agua) ."</h1>"; 
		
		$diffAe = ($val_esgoto - $val_agua);
		$devido = ($val_agua)*2;
		
		
		//echo "<h1>X24 = ".($val_esgoto - $val_agua) * 24 ."</h1>"; 
		
		$valor_conta = $val_esgoto + $val_agua;
		
		//echo "<h1>valor_conta = ".($valor_conta) ."</h1>"; 
		
		$porcento = round((($val_agua*100)/$val_esgoto),2)."%";
		
		//echo "<h1>porcento = ".($porcento) ."</h1>"; 
		
		return montaTabelaFatorK("Consumo",$consumo,$valor_conta,$devido,$diffAe);

		
	}else{	
	
		
		//$percentual_cobrado_de_adicional_de_poluicao = 	$valores["percentual_cobrado_de_adicional_de_poluicao"];
		//echo get_fields('quantos_conjuntos');
		
		$ecoComPoco 	= get_option('ecoComPoco');
		$multp 	= get_option('multp');
		
		$T1 	= get_option("tarCom1");
		$T2 	= get_option("tarCom2");
		$T3 	= get_option("tarCom3");
		$T4 	= get_option("tarCom4");
		$freaja 	= get_option("freaja");
		
		//$economia = round($consumo/$ecoComPoco,2);
	
		$basCalc = round($consumo/$qtdConj,2);
		
		//echo "Tarifa 1(T1)".$T1."</br>";
		//echo "Tarifa 2(T2)".$T2."</br>";
		//echo "Tarifa 3(T3)".$T3."</br>";
		//echo "Tarifa 4(T4)".$T4."</br>";
		

		if($basCalc<10){
			
			$val_devido = round((($T1*2)*$qtdConj),2);
			
			if($diffAe>0){
				
				//	$val_devido = round((($T1*($T1*.))*$qtdConj),2);
				
			}
			
		}elseif($basCalc>10 && $basCalc<=20){
			
			//$val_devido = (($T1*2)*$qtdConj);
			$calcT2 = (($basCalc-10)*$T2);			
			$val_devido = round((($T1+$calcT2)*2)*$qtdConj,2);

			
		}elseif($basCalc>20 && $basCalc<50){
			
			$novaBase = $basCalc-20;
			$calcT2 = round(10*$T2,2);
			$calcT3 = round($novaBase*$T3,2);
			
			$val_devido = round((($T1+$calcT2+$calcT3)*2)*$qtdConj,2);
	
		}elseif($basCalc>50){
			
			$calcT2 = round(10*$T2,2);
			//$calcT3 = round($basCalc-20*$T3,2);
			$calcT3 = round(30*$T3,2);
			$calcT4 = round(($basCalc-50)*$T4,2);
			
			$val_devido = round((($T1+$calcT2+$calcT3+$calcT4)*2)*$qtdConj,2);
	
		}
		
			//echo "val_devido= ".$basCalc."</br>";
			
	
		$diferenca = $valor_conta - $val_devido;
		
		return montaTabela("Consumo",$consumo,$valor_conta,$val_devido,$diferenca);
 }
	
}



function montaCalculo(){
	
	
	
	if(isset($_GET["cad"]) && !empty($_GET["cad"])){
		
		$postId = $_GET["cad"];
		$dadoPost = get_post($postId);
		$post_type = $dadoPost->post_type;
		
		
		
		switch($post_type){
				
			case "residencial":
				$table = montaResidencial($postId);
			break;
			case "comercial":
				$table = montaComercial($postId,$post_type);
			break;
			case "industrial":
				$table = montaComercial($postId,$post_type);
			break;
				
				
		}
		
		
	}//fimIf Check CAD

	
	
	?>

<section id="resultado" class="sections resultado col-12 text-center" style="background-image:url();">
			
	<div class="container p-0">
		<div class="row m-0 p-0">

						
						<div class="col-12 p-0 m-0 cabeca">

															
															
							<h3>Veja seu Cálculo abaixo: </h3>						
							<p></p>	

						</div>
						
							
			<div class="row col-12 m-0 p-0">

				



				<div class="col-sm-12 col-md-12 col-lg-12  order-12  m-0 p-0">

					 <div style="justify-content: center;" class="row card-columns m-0 p-0"> 
				<?php echo $table; ?>
					</div></br></br></br>
					<cite>* Essa simulação toma apenas a conta enviada como base para cálculo</cite></br>
					<cite>** A análise abrange os últimos 120 meses (10 anos), sendo limitada a data de início da cobrança</cite></br>
					<cite>*Valores estão sujeitos a altereção para mais ou para menos com base nas análises detalhadas do consumo de água</cite></br>
					</br>
					</br>
				<div class="botoes" style="text-align: center;"><h1>Dúvidas?</h1>
				<a class="btn btn-sm m-2 link" style="background-color: #1cc328;" title="WHATSAPP" href="https://api.whatsapp.com/send/?phone=551131429866" rel="noopener"><i class="fa-whatsapp">Fale com nossos consultores!</i></a></div>

				</div>

			</div>

			<div class="col-12 p-0 m-0"> 
		</div>
			
		</div>
		
	</div>

</section>
	
	<?php
	
	
}


















