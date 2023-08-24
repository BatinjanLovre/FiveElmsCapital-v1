<?php
/*
* Admin part for work
*/
class Work extends Admin {
    public static $post_type = 'work';
    /*
        Construstor
    */
    function __construct()
    {
        // register post types and taxonomies
        add_action( 'init', array( $this, 'register_post_type' ) );
        // add_action( 'init', array( $this, 'create_product_taxonomies' ) );
    }
    /*
    *Register post_type
    */
    public function register_post_type()
    {
         $labels = array(
        'name' => _x('Work', 'post type general name'),
        'singular_name' => _x('Work', 'post type singular name'),
        'add_new' => _x('Add New', 'Work'),
        'add_new_item' => __('Add New Work'),
        'edit_item' => __('Edit Work'),
        'new_item' => __('New Work'),
        'all_items' => __('All Works'),
        'view_item' => __('View Work'),
        'search_items' => __('Search Works'),
        'not_found' =>  __('No Works found'),
        'not_found_in_trash' => __('No Works found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Work'
      );
      $args = array(
        'menu_icon' => 'dashicons-products',
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'work' ),
        'has_archive' => false,
        'hierarchical' => true,
        'menu_position' => null,
        'supports' => array( 'title', 'thumbnail' )
      );
      register_post_type( self::$post_type, $args );
    }
    // create two taxonomies, genres and writers for the post type "Work"
    function create_work_taxonomies() {
        // Add new taxonomy, make it hierarchical (like categories)
        $labels = array(
            'name'              => _x( 'work Category', 'taxonomy general name' ),
            'singular_name'     => _x( 'work Category type', 'taxonomy singular name' ),
            'search_items'      => __( 'Search work Categories' ),
            'all_items'         => __( 'All work Categories' ),
            'parent_item'       => __( 'Parent work Category' ),
            'parent_item_colon' => __( 'Parent work Category:' ),
            'edit_item'         => __( 'Edit work Category' ),
            'update_item'       => __( 'Update work Category' ),
            'add_new_item'      => __( 'Add New work Category' ),
            'new_item_name'     => __( 'New work Category Name' ),
            'menu_name'         => __( 'work Category' ),
        );
        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'work-category' ),
        );
        register_taxonomy( 'work_category', array( 'work' ), $args );
    }
}
Work::get_instance();
/* End of file */
/* End of file class-Work.php */