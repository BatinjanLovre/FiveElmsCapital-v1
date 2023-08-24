<?php  
/* REDNECK custom login options */
// function enqueue_login_styles()
// {
// 	wp_enqueue_style('redneck-login', get_template_directory_uri() . '/inc/redneck-login/login-style.css', false, '1'); 
// }
// add_action( 'login_enqueue_scripts', 'enqueue_login_styles' );

// Cutom URL for login page
add_filter( 'login_headerurl', 'redneck_login_url' );
function redneck_login_url($url) {
	return home_url();
}


/********************
* USE CUSTOMER LOGO FOR LOGIN *
********************/
function redneck_custom_login() { 

	$logo_img = get_field('logo', 'option');
	if( !$logo_img ) {
	  $logo_img = get_template_directory_uri().'/inc/redneck-login/img/redneck-logo.jpg';
	}

	?>
	<style type="text/css">
	body {
		background-color: #fff;
	}
	#login h1 a, .login h1 a {
		background-image: url(<?php echo $logo_img; ?>);
		height:200px;
		width:300px;
		background-size: contain;
		background-repeat: no-repeat;
		padding-bottom: 30px;
	}
	</style>
	<?php 
}
add_action( 'login_head', 'redneck_custom_login' );