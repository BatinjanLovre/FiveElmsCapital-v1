<?php
/**
 * @package WordPress
 * @subpackage wp_starter
 * @since v1.0
 **/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">


    <style>
        body {
            opacity: 0;
            visibility: hidden;
        }

        body.loaded {
            transition: opacity 600ms ease, visibility 600ms ease;
            opacity: 1;
            visibility: visible;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/splidejs/4.1.4/css/splide-core.min.css" integrity="sha512-cSogJ0h5p3lhb//GYQRKsQAiwRku2tKOw/Rgvba47vg0+iOFrQ94iQbmAvRPF5+qkF8+gT7XBct233jFg1cBaQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/splidejs/4.1.4/js/splide.min.js"></script>

    <script type="text/javascript">
        var ADMIN_BAR_VISIBLE = false;
        var admin_url = '<?php echo admin_url("admin-ajax.php"); ?>';
    </script>
    <?php if (is_admin_bar_showing()): ?>
    <script type="text/javascript">
        var ADMIN_BAR_VISIBLE = true;
    </script>
    <?php endif; ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <div class="mobile-menu" data-method="menuControl">
        <div class="container">
            <div class="mobile-menu-links">
                <a href="#" class="header-mobile-links">About us</a>
                <a href="#" class="header-mobile-links">Portfolio</a>
                <a href="#" class="header-mobile-links">Team</a>
                <a href="#" class="header-mobile-links">Careers</a>
                <a href="#" class="header-mobile-links">News</a>
                <a href="#" class="header-mobile-links">Contact us</a>
            </div>
        </div>
    </div>


    <!-- Header -->
    <header class="header">
        
        <div class="header-container">
            
            <div class="header-inner">
                
                <div class="header-logo"></div>
                <div class="header-menu">
                    <a href="#" class="header-links">About us</a>
                    <a href="#" class="header-links">Portfolio</a>
                    <a href="#" class="header-links">Team</a>
                    <a href="#" class="header-links">Careers</a>
                    <a href="#" class="header-links">News</a>
                    <a href="#" class="action-link">Contact us</a>
                </div>

                <div class="mobile-menu-trigger">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>

            </div>
            
        </div>
    </header>


    <div id="smooth-wrapper">
        <div id="smooth-content">
            <main id="swup" class="transition-fade">