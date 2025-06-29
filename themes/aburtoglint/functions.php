<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit; 
/**
 * Glint Theme Functions
 */

// Define path and URL constants
define('GLINT_VERSION', '1.0.0');
define('GLINT_THEME_NAME', 'glint');

define('GLINT_DIR_PATH', trailingslashit(get_template_directory()));
define('GLINT_DIR_URI', trailingslashit(get_template_directory_uri()));

// Define regex pattern for URL matching
define('GLINT_REGEX_LINK_MATCHING', "@(https?://([-\\w\\.]+[-\\w])+(:\\d+)?(/([\\w/_\\.#-]*(\\?\\S+)?[^\\.\\s])?)?)@");


// Load the main Glint class
require_once GLINT_DIR_PATH . 'includes/class-glint.php';

// Autoload includes
/*foreach (glob(GLINT_DIR_PATH . 'includes/*.php') as $file) {
    if (is_file($file)) require_once $file;
}*/

// Run theme core class-glint.php
(new Glint())->run();

/*if (class_exists('Glint')) {
    (new Glint())->run();
}*/

// Debug helper
if (!function_exists('glint_debug')) {
    function glint_debug($var, $exit = false) {
        echo '<pre>';
        print_r($var ?: 'This var is empty');
        echo '</pre>';
        if ($exit) die();
    }
}


       
     