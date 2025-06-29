<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Custom Post Type: Testimonials
 */
class Glint_CPT_Testimonial {

    /**
     * Hook
     */
   public function __construct() {
    add_action('init', [$this, 'register_post_type']);  
   }

    /**
     * Register 'testimonial' post type
     */
    public function register_post_type(): void {
        $labels = [
            'name'                  => __('Testimonials', 'glint'),
            'singular_name'         => __('Testimonial', 'glint'),
            'menu_name'             => __('Testimonials', 'glint'),
            'name_admin_bar'        => __('Testimonial', 'glint'),
            'add_new'               => __('Add New', 'glint'),
            'add_new_item'          => __('Add New Testimonial', 'glint'),
            'new_item'              => __('New Testimonial', 'glint'),
            'edit_item'             => __('Edit Testimonial', 'glint'),
            'view_item'             => __('View Testimonial', 'glint'),
            'all_items'             => __('All Testimonials', 'glint'),
            'search_items'          => __('Search Testimonials', 'glint'),
            'not_found'             => __('No testimonials found.', 'glint'),
            'not_found_in_trash'    => __('No testimonials found in Trash.', 'glint'),
            'featured_image'        => __('Client Image', 'glint'),
            'set_featured_image'    => __('Set client image', 'glint'),
            'remove_featured_image' => __('Remove client image', 'glint'),
            'use_featured_image'    => __('Use as client image', 'glint'),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-testimonial',
            'query_var'          => true,
            'rewrite'            => ['slug' => 'testimonials'],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 21,
            'supports'           => ['title', 'editor', 'thumbnail'],
            'show_in_rest'       => true, 
        ];

        register_post_type('testimonial', $args);
    }
}