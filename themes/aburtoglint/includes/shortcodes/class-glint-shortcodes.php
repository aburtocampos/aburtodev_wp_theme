<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Glint Shortcodes Loader
 *
 * Register all individual shortcodes here.
 */
class Glint_Shortcodes {

    /**
     * Register all shortcodes
     */
    public function register(): void {
        $shortcodes = [
            'testimonial/class-glint-shortcode-testimonial.php' => 'Glint_Shortcode_Testimonial',
            'contactform/class-glint-shortcode-contactform.php' => 'Glint_Shortcode_ContactForm',
            // Add more shortcodes here as needed
        ];

        foreach ($shortcodes as $relative_path => $class_name) {
            $path = GLINT_DIR_PATH . 'includes/shortcodes/' . $relative_path;

            if (file_exists($path)) {
                require_once $path;

                if (class_exists($class_name)) {
                    (new $class_name())->register();
                }
            } else {
                error_log("Glint Shortcodes: Missing file $relative_path");
            }
        }
    }
}
