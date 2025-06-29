<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Core Glint Theme Class
 */
class Glint {

    protected Glint_Loader $loader;
    protected Glint_Admin $admin;
    protected Glint_Public $public;
    protected Glint_Theme $theme;

    // Opcionales y escalables
    protected Glint_CPT $cpt;
    protected Glint_Shortcodes $shortcodes;
    protected Glint_Blocks $blocks;

    protected Glint_Ajax_Blog $ajax_blog;

    /**
     * Initialize the theme
     */
    public function __construct() {
        
        $this->load_dependencies();
        $this->init_instances();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->register_direct_modules(); // CPT, shortcodes, blocks
        
          
    }
    
     

    /**
     * Load required files
     */
    private function load_dependencies(): void {
        require_once GLINT_DIR_PATH . 'includes/class-glint-loader.php';
        require_once GLINT_DIR_PATH . 'admin/class-glint-admin.php';
        require_once GLINT_DIR_PATH . 'public/class-glint-public.php';
        require_once GLINT_DIR_PATH . 'includes/class-glint-theme.php';

        // Módulos opcionales
        require_once GLINT_DIR_PATH . 'includes/custom-post-types/class-glint-cpt.php';
        require_once GLINT_DIR_PATH . 'includes/shortcodes/class-glint-shortcodes.php';
        require_once GLINT_DIR_PATH . 'includes/blocks/class-glint-blocks.php';

        require_once GLINT_DIR_PATH . 'includes/ajax/class-glint-ajax-blog.php';

        $this->loader = new Glint_Loader();
    }

    /**
     * Create component instances
     */
    private function init_instances(): void {
        $this->admin       = new Glint_Admin(GLINT_THEME_NAME, GLINT_VERSION);
        $this->public      = new Glint_Public(GLINT_THEME_NAME, GLINT_VERSION);
        $this->cpt         = new Glint_CPT();
        $this->shortcodes  = new Glint_Shortcodes();
        $this->blocks      = new Glint_Blocks();
        $this->theme = new Glint_Theme();
        $this->ajax_blog = new Glint_Ajax_Blog();
    }

    /**
     * Admin hooks
     */
    private function define_admin_hooks(): void {
        $this->loader->add_action('admin_enqueue_scripts', $this->admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $this->admin, 'enqueue_scripts');

    }

    /**
     * Public hooks
     */
    private function define_public_hooks(): void {
        $this->loader->add_action('wp_enqueue_scripts', $this->public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $this->public, 'enqueue_scripts');

    }

    /**
     * Run modules that register themselves (no loader)
     */
    private function register_direct_modules(): void {
        $this->cpt->register();          // usa add_action internamente
        $this->shortcodes->register();   // usa add_shortcode
        $this->blocks->register();       // usa register_block_type
         $this->theme->register();
          $this->ajax_blog->register();
    }

    /**
     * Trigger WordPress hooks
     */
    public function run(): void {
        $this->loader->run();
    }

    public function get_loader(): Glint_Loader {
        return $this->loader;
    }
}
