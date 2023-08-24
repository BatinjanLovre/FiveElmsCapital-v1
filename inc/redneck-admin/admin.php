<?php
// Custom admin style and functinalities for redneck

// Add redneck Siganture into footer
function redneck_admin_copy($content){
	$content = ' Developed and maintaned by: <a href="https://www.redneck.media" traget="_blank">REDNECK</a>. Powered by <a href="http://www.wordpress.org">WordPress.</a>';
	return $content;
}
add_filter('admin_footer_text', 'redneck_admin_copy');

// custom redneck styles
function redneck_admin_styles()
{
	wp_register_style('redneck-style', get_template_directory_uri() . '/inc/redneck-admin/admin-style.css');
	wp_enqueue_style('redneck-style');
}
add_action( 'admin_enqueue_scripts', 'redneck_admin_styles' );

function change_logo_url()
{
?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			jQuery('#wp-admin-bar-wp-logo').find('a').attr('href', '<?php echo admin_url(); ?>');
		});

		var postsRND = jQuery('#dashboard_right_now').find('.b-posts a').text();
		var postsRNDTxt = jQuery('#dashboard_right_now').find('.posts a');
		
		if( postsRND > 1 ) {
			postsRNDTxt.text('Articles');
		} else {
			postsRNDTxt.text('Article');
		}
	</script>
<?php
}

add_action('admin_footer', 'change_logo_url');

/**
* add excerpt to pages and change text to shortTxT
*
* @since 1.0
*/	
function mytheme_addbox() {
	add_meta_box('postexcerpt', __('Short Text'), 'post_excerpt_meta_box', 'page', 'normal', 'core');
	add_meta_box('postexcerpt', __('Short Text'), 'post_excerpt_meta_box', 'post', 'normal', 'core');
	//add_meta_box('postexcerpt', __('Short Text'), 'post_excerpt_meta_box', 'product', 'normal', 'core');
}
add_action( 'admin_menu', 'mytheme_addbox' );

/**
* add redneck DASHBOARD WIDGET
*
* @since 1.0
*/	
// Create the function to output the contents of our Dashboard Widget
function example_dashboard_widget_function() {
	// Display whatever it is you want to show
	echo '<p>Need a support?<br> Give us a call: <strong>+385 98 1701 895</strong>.<br>Mail us: <a href="#">info@redneck.media</a></p>';
} 
// Create the function use in the action hook
function example_add_dashboard_widgets() {
	wp_add_dashboard_widget('example_dashboard_widget', 'Welcome to REDNECK.WP', 'example_dashboard_widget_function');	
} 

// Hook into the 'wp_dashboard_setup' action to register our other functions
add_action('wp_dashboard_setup', 'example_add_dashboard_widgets' ); // Hint: For Multisite Network Admin Dashboard use wp_network_dashboard_setup instead of wp_dashboard_setup.

