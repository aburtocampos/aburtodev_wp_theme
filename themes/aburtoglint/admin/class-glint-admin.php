<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Admin logic for the Glint Theme
 */
class Glint_Admin {

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
     * Enqueue admin styles
     */
    public function enqueue_styles(): void {
        wp_enqueue_style(
            $this->theme_name . '-admin-style',
            GLINT_DIR_URI . 'admin/css/admin.css',
            [],
            $this->version
        );
    }

    /**
     * Enqueue admin scripts
     */
    public function enqueue_scripts(): void {
        wp_enqueue_script(
            $this->theme_name . '-admin-script',
            GLINT_DIR_URI . 'admin/js/admin.js',
            ['jquery'],
            $this->version,
            true
        );
    }

    /**
     * Optional: Setup theme support or admin-specific actions
     */
    public function theme_support(): void {
        // Future admin-specific features (e.g., post types, editor config)



    }

    /**
     * Optional: Register admin menus or pages
     */
    public function register_admin_menu(): void {
        // add_menu_page(...);
    }
}
