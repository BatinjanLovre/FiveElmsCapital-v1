<?php
/**
 * @package WordPress
 * @subpackage wp_starter
 * @since v2.0
 **/

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release, to remove cache problems
	define( '_S_VERSION', '1.0.0' );
}

// Check if the user is Admin, and install plugins & add functionality
$the_user =  wp_get_current_user();
if( $the_user->ID == 1 ) {
	require( get_template_directory() . '/inc/plugin-activation/plugins.php' );
} else {
	add_filter('acf/settings/show_admin', '__return_false');
}

if ( ! function_exists( 'redneck_setup' ) ) {

	function redneck_setup() {

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
		add_theme_support( 'woocommerce' );

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
				'style',
				'script',
			)
		);

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Add new classes, CPT type and so on
		load_class( array( 
			'class-admin', 
			'class-front',
			'class-navigation',
			'class-work'
		) );

		load( array( 
			'ajax-calls'
		) );

		add_redneck_login();
		add_redneck_admin();

		/********************
		* CUSTOM IMAGE SIZES *
		********************/
		
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'slider', 1920, 830, true );

	}
}
add_action( 'after_setup_theme', 'redneck_setup' );


/********************
* REDNECK SCRIPTS & STYLES *
********************/
function redneck_scripts() {
	// Styles
	wp_enqueue_style('redneck-style', get_template_directory_uri() . '/assets/css/style.min.css', array(), _S_VERSION, false);

	// Scripts
	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'jquery', '//code.jquery.com/jquery-3.6.0.min.js', array(), '3.6.0', true );
	wp_enqueue_script( 'gsap', get_template_directory_uri() . '/src/js/external/gsap.min.js', array(), '3.10.4', true );
	wp_enqueue_script( 'gsap-split-text', get_template_directory_uri() . '/src/js/external/SplitText.min.js', array(), '3.10.4', true );
	wp_enqueue_script( 'scroll-trigger', get_template_directory_uri() . '/src/js/external/ScrollTrigger.min.js', array(), '3.10.4', true );
	wp_enqueue_script( 'scroll-to', get_template_directory_uri() . '/src/js/external/ScrollToPlugin.min.js', array(), '3.10.4', true );
	wp_enqueue_script( 'scroll-smoother', get_template_directory_uri() . '/src/js/external/ScrollSmoother.min.js', array(), '3.10.4', true );
	wp_enqueue_script( 'custom-ease', get_template_directory_uri() . '/src/js/external/CustomEase.min.js', array(), '3.10.4', true );
	wp_enqueue_script( 'redneck-script', get_template_directory_uri() . '/assets/js/script.min.js', array(), _S_VERSION, true );
	// wp_enqueue_script( "social-share", get_template_directory_uri().'/inc/theme-addons/social-share/social-share-kit.js', array(), '1.0', true );
}
if( !is_admin() ){
	add_action('wp_enqueue_scripts', 'redneck_scripts');
}


/********************
* EXCERPT CONTROL *
********************/

function wp_starter_excerpt_length( $length ) {
	return 38;
}
add_filter( 'excerpt_length', 'wp_starter_excerpt_length' );

function wp_starter_continue_reading_link() {
	return "";
}

function wp_starter_auto_excerpt_more( $more ) {
	return ' &hellip;' . wp_starter_continue_reading_link();
}
add_filter( 'excerpt_more', 'wp_starter_auto_excerpt_more' );

function wp_starter_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= wp_starter_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'wp_starter_custom_excerpt_more' );

// dodajemo excerpt support i u page
function my_add_excerpts_to_pages() {
    add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'my_add_excerpts_to_pages' );

function add_short_box() {
	add_meta_box( 'postexcerpt', __( 'Short text' ), 'post_excerpt_meta_box', 'press', 'normal', 'core' );
}
add_action( 'admin_menu', 'add_short_box' );


/********************
* BODY CLASSES *
********************/

function redneck_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) ) {
		$classes[] = 'singular';
	}

	return $classes;
}
add_filter( 'body_class', 'redneck_body_classes' );

/********************
* MISC *
********************/

function strleft($s1, $s2) {
	return substr($s1, 0, strpos($s1, $s2));
}

function current_url(){
    if(!isset($_SERVER['REQUEST_URI'])){
        $serverrequri = $_SERVER['PHP_SELF'];
    }else{
        $serverrequri =    $_SERVER['REQUEST_URI'];
    }
    $s = empty($_SERVER["HTTPS"]) ? '' : (($_SERVER["HTTPS"] == "on") ? "s" : "");
    $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    return $protocol."://".$_SERVER['SERVER_NAME'].$port.$serverrequri;   
}

function contains_substr($substring, $string) {
	$pos = strpos($string, $substring);

	if($pos === false) {
	        // string needle NOT found in haystack
	        return false;
	}
	else {
	        // string needle found in haystack
	        return true;
	}
}

function add_no_follow(){	
	if( contains_substr( 'redneck.media', current_url() ) ) {
		echo "\n\r" . '<meta name="robots" content="nofollow" />'. "\n\r";
	}
}
add_action( 'wp_head', 'add_no_follow' );

function hide_front_end_wp_logo()
{
	if( is_user_logged_in() )
	{
		echo '<style type="text/css"> #wp-admin-bar-wp-logo, #wp-admin-bar-themes, #wp-admin-bar-customize, #wp-admin-bar-comments { display:none; } </style>';
	}
}
add_action( 'wp_head', 'hide_front_end_wp_logo' );


/********************
* ACF auto license - RUN ONCE *
********************/

function autolicense_acf() {
   // Check if ACF is running
   if ( is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {

     // Loads ACF plugin
     include_once( ABSPATH . 'wp-content/plugins/advanced-custom-fields-pro/acf.php');

     // connect
     $post = array(
       'acf_license'   => "b3JkZXJfaWQ9NzcyMTd8dHlwZT1kZXZlbG9wZXJ8ZGF0ZT0yMDE2LTAzLTEzIDE4OjA1OjQ3",
       'acf_version'   => acf_get_setting('version'),
       'wp_name'           => get_bloginfo('name'),
       'wp_url'            => home_url(),
       'wp_version'    => get_bloginfo('version'),
       'wp_language'   => get_bloginfo('language'),
       'wp_timezone'   => get_option('timezone_string'),
     );

     // connect
     $response = acf_updates()->request('v2/plugins/activate?p=pro', $post);

     // ensure response is expected JSON array (not string)
     if( is_string($response) ) {
       $response = new WP_Error( 'server_error', esc_html($response) );
     }

     // success
     if( $response['status'] == 1 ) {
       acf_pro_update_license( $response['license'] ); // update license
     }
     echo $response['message']; // show message

   
  }
}
// Uncomment to run the auto-license 
// add_action( 'admin_init', 'autolicense_acf' );



/********************
* ACF OPTIONS *
********************/

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Web Info',
		'menu_title'	=> 'Web Info',
		'menu_slug' 	=> 'page-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	// acf_add_options_sub_page(array(
	// 	'page_title' 	=> 'Children Menu',
	// 	'menu_title'	=> 'Children Menu',
	// 	'parent_slug'	=> 'page-general-settings',
	// ));
}


/********************
* PERFORMANCE STUFF *
********************/

// Mičemo nepotrebne stvari iz headera
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

/**
 * Disable the emoji's
 */
function disable_emojis() {
 remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
 remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
 remove_action( 'wp_print_styles', 'print_emoji_styles' );
 remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
 remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
 remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
 remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
 add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
 add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param array $plugins 
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
 if ( is_array( $plugins ) ) {
 return array_diff( $plugins, array( 'wpemoji' ) );
 } else {
 return array();
 }
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
 if ( 'dns-prefetch' == $relation_type ) {
 /** This filter is documented in wp-includes/formatting.php */
 $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

$urls = array_diff( $urls, array( $emoji_svg_url ) );
 }

return $urls;
}

/********************
* Remove gutenberg block CSS *
********************/
function smartwp_remove_wp_block_library_css(){
 wp_dequeue_style( 'wp-block-library' );
 wp_dequeue_style( 'wp-block-library-theme' );
 wp_deregister_style( 'wc-block-style' );
}
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css' );


/********************
* WOOCOMMERCE STUFF *
********************/

add_filter( 'woocommerce_enqueue_styles', 'eawoocommerce_dequeue_styles' );
function eawoocommerce_dequeue_styles( $enqueue_styles ) {
  unset( $enqueue_styles['woocommerce-general'] );  // Remove the gloss
  unset( $enqueue_styles['woocommerce-layout'] );    // Remove the layout
  unset( $enqueue_styles['woocommerce-smallscreen'] ); // Remove the smallscreen optimisation
  return $enqueue_styles;
}

/********************
* GRAVITY LOAD FOOTER *
********************/
add_filter( 'gform_init_scripts_footer', '__return_true' );
add_filter( 'gform_confirmation_anchor', '__return_true' );

