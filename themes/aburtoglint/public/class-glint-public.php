<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Public logic for the Glint Theme
 */
class Glint_Public {

    /**
     * Theme name and version
     */
    protected string $theme_name;
    protected string $version;

    /**
     * Constructor
     */
    public function __construct(string $theme_name, string $version) {
        $this->theme_name = $theme_name;
        $this->version = $version;
    }

    /**
     * Enqueue public styles
     */
    public function enqueue_styles(): void {
        wp_enqueue_style(
            $this->theme_name . '-main-style',
            GLINT_DIR_URI . '/style.css',
            [],
           filemtime(GLINT_DIR_PATH . '/style.css') 
        );
    }



    
    /**
     * Enqueue public scripts
     */
    public function enqueue_scripts(): void {
        wp_enqueue_script(
            $this->theme_name . '-main-js',
            GLINT_DIR_URI . 'public/js/main.js',
            ['jquery'],
            $this->version,
            true
        );
          // Enqueue AJAX pagination for project grid block
        wp_enqueue_script(
            $this->theme_name . '-project-grid-pagination',
            GLINT_DIR_URI . 'public/js/project-grid-pagination.js',
            [],
            filemtime(GLINT_DIR_PATH . 'public/js/project-grid-pagination.js'),
            true
        );
              //marquee
        wp_enqueue_script(
            $this->theme_name . '-marquee',
            GLINT_DIR_URI . 'public/js/marquee.js',
            [], 
            filemtime(GLINT_DIR_PATH . 'public/js/marquee.js'), 
            true
        );

        wp_enqueue_script('glint-blog-js', trailingslashit(GLINT_DIR_URI) . 'public/js/blog.js' , [], null, true);
        
        wp_localize_script('glint-blog-js', 'glint_ajax', [
            'ajax_url' => admin_url('admin-ajax.php')
        ]);


    }

}
