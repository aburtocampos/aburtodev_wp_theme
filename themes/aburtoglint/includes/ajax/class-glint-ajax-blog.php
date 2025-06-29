<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class Glint_Ajax_Blog {
    public function register(): void {
        add_action('wp_ajax_glint_get_posts', [$this, 'handle']);
        add_action('wp_ajax_nopriv_glint_get_posts', [$this, 'handle']);
    }

public function handle(): void {
    // Verifica acción y método
    if (!defined('DOING_AJAX') || !DOING_AJAX || $_POST['action'] !== 'glint_get_posts') {
        wp_send_json_error('Invalid request');
    }

    $paged = isset($_POST['paged']) ? (int) $_POST['paged'] : 1;
    $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';

    $query = new WP_Query([
        'post_type' => 'post',
        'paged' => $paged,
        's' => $search,
    ]);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/content', 'excerpt');
        }
    } else {
        echo '<p>No posts found.</p>';
    }

    wp_reset_postdata();

    wp_send_json([
        'html' => ob_get_clean(),
        'max_pages' => $query->max_num_pages,
    ]);
}


}
