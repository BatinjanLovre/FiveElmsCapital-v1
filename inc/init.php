<?php 

function load($files){
	if( !is_array( $files ) ) {
		require( get_template_directory() . "/inc/$files.php" );
	}
	if( is_array( $files ) ) {
		foreach( $files as $file ) {
			require( get_template_directory() . "/inc/$file.php" );
		}
	}
}

function load_class( $files ) {
	if( !is_array( $files ) ) {
		require( get_template_directory() . "/inc/$files/$files.php" );
	}
	if( is_array( $files ) ) {
		foreach( $files as $file ) {
			require( get_template_directory() . "/inc/$file/$file.php" );
		}
	}
}


// Funkcija za pozivanje login stilova za REDNECK
function add_redneck_login()
{
	require_once( get_template_directory() . '/inc/redneck-login/login.php' ); 
}

// Funkcija za pozivanje REDNECK admin stilova i funkcionalnosti
function add_redneck_admin()
{
	require_once( get_template_directory() . '/inc/redneck-admin/admin.php' ); 	
}