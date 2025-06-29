<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
    wp_body_open();
?>
   <header class="header-menu" >
        <div class="header-inner container">
              <!-- Logo -->
            <div class="logo-container">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="">
                        <?php bloginfo('name'); ?>
                    </a>
                <?php endif; ?>
            </div>
            <nav class="nav-header-menu" id="main-nav">
              <?php
                wp_nav_menu([
                  'theme_location' => 'header_menu',
                  'menu_class' => 'menu-navigation',
                  'container' => false,
                  'fallback_cb' => false,
                  'items_wrap' => '<ul class="%2$s">%3$s</ul>',
               ]);
              ?>

            </nav>
            <button class="hamburger" id="hamburger" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
        </div>
    </header>