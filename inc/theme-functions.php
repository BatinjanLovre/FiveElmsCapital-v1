<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package redneck
 */


function change_lang()
{
	if( defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE != "" ) 
	{
		$lang_str = ICL_LANGUAGE_CODE == 'hr' ? 'PROMIJENI JEZIK:' : 'Change Language:';
		$languages = icl_get_languages('skip_missing=0&orderby=id&order=ASC');
		if( !empty( $languages ) ) {
			echo ' <ul class="lang-nav">';
				foreach( $languages as $lang ) {
					$active = $lang['active'] == 1 ? " current" : "";
					$language_code = $lang['language_code'];
					$lang_txt = str_replace( 'en' , 'eng', $language_code );
					$lang_txt = str_replace( 'hr' , 'cro', $language_code );
					echo '<li class="' . $lang_txt . '' . $active. '"><span class="icon"></span><a href="' . $lang['url'] . '">'.$lang_txt.'</a></li>';
				}
			echo ' </ul>';
		}
	}
}

function wpml_id( $pid, $element_type = "" ){
	if( defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE != "" ) {
		global $wpdb;

		$elem_string = $element_type != "" ? " AND element_type = '". $element_type ."' " : "";

		$t_name = $wpdb->prefix.'icl_translations';
		$current_lang = ICL_LANGUAGE_CODE;
		$trid =  $wpdb->get_var("SELECT trid FROM $t_name WHERE element_id = $pid $elem_string LIMIT 1");
		$page_id = $wpdb->get_var("SELECT element_id FROM $t_name WHERE trid = $trid AND language_code = '$current_lang' LIMIT 1 ");

		return $page_id;
	} else {
		return $pid;
	}
}

function change_month_lang($custom_date) {
	$months_eng = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $months_cro = array( 'siječanja', 'veljače', 'ožujka', 'travnja', 'svibnja', 'lipnja', 'srpnja', 'kolovoza', 'rujna', 'listopada', 'studenog', 'prosinca');
    $newDate = str_ireplace($months_eng, $months_cro, $custom_date);
    return $newDate;
}

function title_span($string) {
	$title_output = preg_replace("/\*(.*?)\*/", "<span>$1</span>", $string);
    return $title_output;
}

function title_span_remove($string) {
	$title_output = preg_replace("/\*(.*?)\*/", "$1", $string);
    return $title_output;
}


function curl_get_contents($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

function num_pagination($pages = '', $range = 4)
{  
  	//koristena odličnu kriesi paginacija ali promjenjena kako bi odgovarala strukturi.
     $showitems = ($range * 2)+1;  

     global $paged, $wp_query;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
        echo '<div class="pagination">';
        echo '<ul>';
        echo '<li class="prev">'.get_previous_posts_link( __( '&larr; Prethodna', 'twentyeleven' ) ).'</li>';
         for ($i=1; $i <= $pages; $i++)
         {
           $first = $i == 1 ? ' class="first"' : "";
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                // echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
                 if( $paged == $i ) {
                  echo '<li'.$first.'><a href="'.get_pagenum_link($i).'" class="selected" >'.$i.'</a></li>';
                 } else {
                  echo '<li'.$first.'><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
                 }
             }
         }
         echo '<li class="next">'.get_next_posts_link( __( 'Sljedeća &rarr;', 'twentyeleven' ) ).'</li>';
         echo '</ul>';
         echo "</div>\n";
     }
}