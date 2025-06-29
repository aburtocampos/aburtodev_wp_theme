<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Shortcode: [testimonial_slider]
 */
class Glint_Shortcode_Testimonial {

    public function register(): void {
        add_shortcode('testimonial_slider', [$this, 'render']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function enqueue_assets(): void {
    // Defer Slick CSS  print + onload
    add_action('wp_head', function () {
            echo '<link rel="stylesheet" href="' . esc_url(GLINT_DIR_URI . '/public/vendor/slick/slick.css') . '" media="print" onload="this.media=\'all\'">';
            echo '<link rel="stylesheet" href="' . esc_url(GLINT_DIR_URI . '/public/vendor/slick/slick-theme.css') . '" media="print" onload="this.media=\'all\'">';
        });

        // Slick JS + script footer
        wp_enqueue_script('slick-js', GLINT_DIR_URI . '/public/vendor/slick/slick.min.js', ['jquery'], '1.8.1', true);
        wp_enqueue_script('glint-testimonial-slider', GLINT_DIR_URI . '/public/js/testimonial-slider.js', ['slick-js'], '1.0', true);
    }

   /* public function enqueue_assets(): void {
        // Slick CSS
        wp_enqueue_style('slick-css', GLINT_DIR_URI . '/public/vendor/slick/slick.css', [], '1.8.1');
        wp_enqueue_style('slick-theme-css', GLINT_DIR_URI . '/public/vendor/slick/slick-theme.css', [], '1.8.1');

        // Slick JS + custom
        wp_enqueue_script('slick-js', GLINT_DIR_URI . '/public/vendor/slick/slick.min.js', ['jquery'], '1.8.1', true);
        wp_enqueue_script('glint-testimonial-slider', GLINT_DIR_URI . '/public/js/testimonial-slider.js', ['slick-js'], '1.0', true);
    }*/

    public function render($atts): string {
        $query = new WP_Query([
            'post_type'      => 'testimonial',
            'posts_per_page' => 10,
        ]);

        ob_start();

        if ($query->have_posts()) :
            echo '<div class="glint-testimonial-slider container">';
            while ($query->have_posts()) : $query->the_post();
                echo '<div class="testimonial-slide">';

                if (has_post_thumbnail()) {
                    echo '<div class="testimonial-image">' . get_the_post_thumbnail(null, 'medium') . '</div>';
                }

                echo '<blockquote>' . get_the_content() . '</blockquote>';
                echo '<p class="author">— ' . get_the_title() . '</p>';
                echo '<div class="testimonial-rating">★★★★★</div>';
                echo '</div>';
            endwhile;
            echo '</div>';
            wp_reset_postdata();
        else :
            echo '<p>No testimonials found.</p>';
        endif;

        return ob_get_clean();
    }
}
