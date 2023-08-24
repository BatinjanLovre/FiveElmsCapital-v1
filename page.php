<?php get_header(); ?>

<?php 

if ( have_posts() ) {
  while ( have_posts() ) {
    the_post();
    the_title();
    the_content();
  }

  require locate_template( 'inc/components/google-rich-snippets.php' );
}

?>

<?php get_footer(); ?>