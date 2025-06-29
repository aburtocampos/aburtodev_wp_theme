<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Glint Blocks Loader
 */
class Glint_Blocks {

    /**
     * Register all custom blocks
     */
    public function register(): void {
        add_action('init', [$this, 'register_blocks']);
    }

    /**
     * Loop and register each block via its block.json
     */
    public function register_blocks(): void {
        $blocks = ['project-grid']; // puedes agregar más luego

        foreach ($blocks as $block) {
            $path = GLINT_DIR_PATH . "includes/blocks/{$block}/block.json";

            if (file_exists($path)) {
                register_block_type($path);
            } else {
                error_log("Glint Blocks: missing block.json for {$block}");
            }
        }
    }
}
