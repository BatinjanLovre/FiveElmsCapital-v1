<?php

class Navigation_Walker_Class_Mobile extends Walker_Nav_Menu {

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';


		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		
		if ( $args->walker->has_children && $depth == 0 ) {
			$attributes .= ' class="submenuOpen"';
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

}



class Navigation_Walker_Submenu extends Walker_Nav_Menu {

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';


		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';

		if( in_array("store-menu", $classes) ) {

			$categories = get_terms( array(
			    'taxonomy' => 'store_category',
			    'orderby' => 'menu_order',
			    'hide_empty' => false,
			));
			$item_output .= '<ul class="sub-menu">';
				// $item_output .= '<li class="menu-item-has-children"><a href="#">'.__('Sve', 'max').'</a>';
				// 	$stores = new WP_Query( array( 'posts_per_page' => -1, 'post_type' => 'store', 'order' => 'ASC' ) ); 
				// 	if( $stores->have_posts() ) : 
				// 		$item_output .= '<ul class="sub-menu all-stores-menu">';
				// 		while( $stores->have_posts() ) : $stores->the_post();
				// 			$item_output .= '<li class="menu-item"><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
				// 		endwhile; 
				// 		$item_output .= '</ul>';
				// 	endif; wp_reset_postdata();
				// $item_output .= '</li>';

				foreach ($categories as $category) {
					$item_output .= '<li class="menu-item-has-children"><a href="#">'.$category->name.'</a>';
						$related_stores = new WP_Query(
						    array( 'post_type' => 'store',  'posts_per_page' => -1, 
						    	'tax_query' => array(
				                    array(
				                        'taxonomy'    => 'store_category',
				                        'field'       => 'term_id',
				                        'terms'       => $category->term_id
				                    )
				                )
						    )
						);
						if( $related_stores->have_posts() ) : 
							$item_output .= '<ul class="sub-menu">';
							while( $related_stores->have_posts() ) : $related_stores->the_post();
								$item_output .= '<li class="menu-item"><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
							endwhile; 
							$item_output .= '</ul>';
						endif; wp_reset_postdata();
					$item_output .= '</li>';
				}
			$item_output .= '</ul>';

		}

		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

}