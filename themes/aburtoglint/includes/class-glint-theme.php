<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Core theme setup: supports, image sizes, menus
 */
class Glint_Theme {

    /**
     * Register WordPress theme hooks
     */
    public function register(): void {
        add_action('after_setup_theme', [$this, 'add_theme_supports']);
        add_action('after_setup_theme', [$this, 'register_menus']);
        $this->add_meta_description();
         // Excluir del sitemap lo que no se quiere indexar
     
        $this->filter_sitemaps();
    }

    /**
     * Enable theme features
     */
    public function add_theme_supports(): void {
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
        add_theme_support('custom-logo');
        add_theme_support('automatic-feed-links');

    }

    /**
     * Register navigation menus
     */
    public function register_menus(): void {
        register_nav_menus([
            'header_menu' => __('Header Menu', 'glint'),
            'footer_menu' => __('Footer Menu', 'glint'),
        ]);
    }

    /**
     * Add meta description tag to <head>
     */
    public function add_meta_description(): void {
        add_action('wp_head', function () {
            global $post;
    
            $description = '';
    
            // Blog page
            if (is_home()) {
                $page_for_posts_id = get_option('page_for_posts');
                if ($page_for_posts_id) {
                    $manual = get_post_meta($page_for_posts_id, 'glint_meta_description', true);
                    if (!empty($manual)) {
                        $description = $manual;
                    }
                }
            }
    
            // home
            elseif (is_front_page()) {
                $front_page_id = get_option('page_on_front');
                if ($front_page_id) {
                    $manual = get_post_meta($front_page_id, 'glint_meta_description', true);
                    if (!empty($manual)) {
                        $description = $manual;
                    }
                }
            }
    
            // Othe rPages
            elseif (is_page()) {
                if ($post instanceof WP_Post) {
                    $manual = get_post_meta($post->ID, 'glint_meta_description', true);
                    if (!empty($manual)) {
                        $description = $manual;
                    }
                }
            }
    
            // 4. Post (single)
            elseif (is_single()) {
                if ($post instanceof WP_Post) {
                    $rendered = apply_filters('the_content', $post->post_content);
                    if (preg_match('/<h1[^>]*>(.*?)<\/h1>/is', $rendered, $matches)) {
                        $description = $matches[1];
                    } else {
                        // fallback title if there is no  <h1>
                        $description = get_the_title($post);
                    }
                }
            }
    
            // print meta is theere is no content
            if (!empty($description)) {
                echo '<meta name="description" content="' . esc_attr(wp_strip_all_tags($description)) . '">' . "\n";
            }
        }, 1);
    }


 /**
     * Remove specific post types, taxonomies, and users from WordPress native sitemap
     */
    public function filter_sitemaps(): void {
        add_filter('wp_sitemaps_post_types', function ($post_types) {
            unset($post_types['testimonial']);
            return $post_types;
        });

        add_filter('wp_sitemaps_taxonomies', function ($taxonomies) {
            unset($taxonomies['category']);
            unset($taxonomies['project_category']);
            return $taxonomies;
        });

    }
 


}
