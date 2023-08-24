<?php

class Mobile_Walker_Class extends Walker_Nav_Menu {

	public $db;
	public $posts_table;
	private $file_path;
	private $num_li = 0;

	public $content_group_stuff = array();

	public function __construct() {
		global $wpdb;
		$this->db = $wpdb;
		$this->posts_table = $wpdb->posts;
		$this->file_path = (__DIR__);
	}


	private function has_children($item) {
		if( in_array( 'menu-item-has-children', $item->classes ) ) {
			return true;
		} else {
			return false;
		}
	}

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		if( $depth != 0 ) {
			$this->content_group_stuff[$item->ID] = $item; 
		}

		$has_children = $this->has_children($item);
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		// print_r( $item );

		if( $depth == 0 ) {
			$output .= $indent . '<li' . $id . $value . $class_names .'>';
		} else {
			$output .= $indent . '<li>';
		}
		$this->num_li++;


		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = $args->before;

		if( $depth == 0 ) {
			$item_output .= '<a href="#" class="sub-menu-trigger" data-method="subMenuTrigger">';
		} else {
			$item_output .= '<a'. $attributes .'>';
		}

		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

	}


}