<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Glint Custom Post Types Loader
 */
class Glint_CPT {

    /**
     * Register all custom post types
     */
    public function register(): void {
        $cpts = [
            'class-glint-cpt-projects.php' => 'Glint_CPT_Projects',
            'class-glint-cpt-testimonial.php' => 'Glint_CPT_Testimonial',
            // Agrega más aquí
        ];

        foreach ($cpts as $file => $class) {
            $path = GLINT_DIR_PATH . 'includes/custom-post-types/' . $file;

            if (file_exists($path)) {
                require_once $path;

                if (class_exists($class)) {
                    new $class(); // usando constructor directamente
                }
            } else {
                error_log("Glint CPT Loader: missing file $file");
            }
        }
    }
}
