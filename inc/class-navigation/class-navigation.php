<?php 
include( 'class-walker.php' );

class Navigation extends Admin {

	function __construct(){
		add_action( 'init', array( $this, 'register_nav_menus' ) );
	}


	function register_nav_menus(){
		// This theme uses wp_nav_menu() in one location.
		register_nav_menu( 'primary_menu', __( 'Primary Menu' ) );
		register_nav_menu( 'secondary_menu', __( 'Secondary Menu') );

		register_nav_menu( 'mobile_menu', __( 'Mobile menu') );
		register_nav_menu( 'footer_2', __( 'Footer') );
		// register_nav_menu( 'footer_3', __( 'Footer 2') );
		// register_nav_menu( 'footer_4', __( 'Footer 3') );
	
	}

	public static function menu_args($menu){
		// class="%2$s"
		$primary_menu = array(
		  'theme_location'  => "primary_menu",
		  'menu'            => "",
		  'container'       => '',
		  'container_class' => 'menu-{menu slug}-container',
		  'container_id'    => "",
		  'menu_class'      => 'main-nav',
		  'menu_id'         => "primary_menu",
		  'echo'            => true,
		  'fallback_cb'     => 'no_menu',
		  'before'          => "",
		  'after'           => "",
		  'link_before'     => "",
		  'link_after'      => "",
		  'items_wrap'      => '<ul class="main-nav">%3$s</ul>',
		  'depth'           => 0,
		  'walker'          => new Navigation_Walker_Submenu()
		);
		
		$secondary_menu = array(
		  'theme_location'  => "secondary_menu",
		  'menu'            => "",
		  'container'       => '',
		  'container_class' => 'menu-{menu slug}-container',
		  'container_id'    => "",
		  'menu_class'      => 'grid-8 about-menu',
		  'menu_id'         => "additional-menu-ul",
		  'echo'            => true,
		  'fallback_cb'     => 'no_menu',
		  'before'          => "",
		  'after'           => "",
		  'link_before'     => "",
		  'link_after'      => "",
		  'items_wrap'      => '<ul id="%1$s">%3$s</ul>',
		  'depth'           => 0,
		  'walker'          => ''
		);


		$mobile_menu = array(
		  'theme_location'  => "mobile_menu",
		  'menu'            => "",
		  'container'       => '',
		  'container_class' => 'menu-{menu slug}-container',
		  'container_id'    => "",
		  'menu_class'      => 'main-nav',
		  'menu_id'         => "primary_menu",
		  'echo'            => true,
		  'fallback_cb'     => 'no_menu',
		  'before'          => "",
		  'after'           => "",
		  'link_before'     => "",
		  'link_after'      => "",
		  'items_wrap'      => '<ul class="main-menu">%3$s</ul>',
		  'depth'           => 0,
		  'walker'          => new Navigation_Walker_Class_Mobile()
		);

		$footer_2 = array(
		  'theme_location'  => "footer_2",
		  'menu'            => "",
		  'container'       => '',
		  'container_class' => 'menu-{menu slug}-container',
		  'container_id'    => "",
		  'menu_class'      => 'footer-navigation',
		  'menu_id'         => "footer_2",
		  'echo'            => true,
		  'fallback_cb'     => 'no_menu',
		  'before'          => "",
		  'after'           => "",
		  'link_before'     => "",
		  'link_after'      => "",
		  'items_wrap'      => '<ul>%3$s</ul>',
		  'depth'           => 0,
		  'walker'          => ""
		);

		$footer_3 = array(
		  'theme_location'  => "footer_3",
		  'menu'            => "",
		  'container'       => '',
		  'container_class' => 'menu-{menu slug}-container',
		  'container_id'    => "",
		  'menu_class'      => 'footer-navigation',
		  'menu_id'         => "footer_3",
		  'echo'            => true,
		  'fallback_cb'     => 'no_menu',
		  'before'          => "",
		  'after'           => "",
		  'link_before'     => "",
		  'link_after'      => "",
		  'items_wrap'      => '<ul>%3$s</ul>',
		  'depth'           => 0,
		  'walker'          => ""
		);

		$footer_4 = array(
		  'theme_location'  => "footer_4",
		  'menu'            => "",
		  'container'       => '',
		  'container_class' => 'menu-{menu slug}-container',
		  'container_id'    => "",
		  'menu_class'      => 'footer-navigation',
		  'menu_id'         => "footer_4",
		  'echo'            => true,
		  'fallback_cb'     => 'no_menu',
		  'before'          => "",
		  'after'           => "",
		  'link_before'     => "",
		  'link_after'      => "",
		  'items_wrap'      => '<ul>%3$s</ul>',
		  'depth'           => 0,
		  'walker'          => ""
		);



		return $$menu;
	}
}
Navigation::get_instance();
