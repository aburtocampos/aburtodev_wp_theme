<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Custom Post Type: Projects
 */
class Glint_CPT_Projects {

    /**
     * Register hook + taxonomy
     */
     public function __construct() {
        add_action('init', [$this, 'register_post_type']); //register cpt
        add_action('init', [$this, 'register_taxonomy']); //register taxonomy
        add_action('add_meta_boxes', [$this, 'add_meta_box']); //register custom post meta for custom fields
        add_action('save_post', [$this, 'save_meta'], 10, 2); //register custom post meta for custom fields
    }

    /**
     * Register 'project' post type
     */
    public function register_post_type(): void {
        $labels = [
            'name'                  => __('Projects', 'glint'),
            'singular_name'         => __('Project', 'glint'),
            'menu_name'             => __('Projects', 'glint'),
            'name_admin_bar'        => __('Project', 'glint'),
            'add_new'               => __('Add New', 'glint'),
            'add_new_item'          => __('Add New Project', 'glint'),
            'new_item'              => __('New Project', 'glint'),
            'edit_item'             => __('Edit Project', 'glint'),
            'view_item'             => __('View Project', 'glint'),
            'all_items'             => __('All Projects', 'glint'),
            'search_items'          => __('Search Projects', 'glint'),
            'not_found'             => __('No projects found.', 'glint'),
            'not_found_in_trash'    => __('No projects found in Trash.', 'glint'),
            'featured_image'        => __('Project Image', 'glint'),
            'set_featured_image'    => __('Set project image', 'glint'),
            'remove_featured_image' => __('Remove project image', 'glint'),
            'use_featured_image'    => __('Use as project image', 'glint'),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-portfolio',
            'query_var'          => true,
            'rewrite'            => ['slug' => 'projects'],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 20,
            'supports'           => ['title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'],
            'show_in_rest'       => true, // Gutenberg / REST API support
        ];

        register_post_type('project', $args);
    }

/**
     * Register custom taxonomy: project_category
     */
    public function register_taxonomy(): void {
        $labels = [
            'name'              => __('Project Categories', 'glint'),
            'singular_name'     => __('Project Category', 'glint'),
            'search_items'      => __('Search Categories', 'glint'),
            'all_items'         => __('All Categories', 'glint'),
            'edit_item'         => __('Edit Category', 'glint'),
            'update_item'       => __('Update Category', 'glint'),
            'add_new_item'      => __('Add New Category', 'glint'),
            'new_item_name'     => __('New Category Name', 'glint'),
            'menu_name'         => __('Categories', 'glint'),
        ];

        register_taxonomy('project_category', ['project'], [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'project-category'],
            'show_in_rest'      => true,
        ]);
    }


 /**
     * Add custom meta box
     */
    public function add_meta_box(): void {
        add_meta_box(
            'project_url_site',
            __('Project Site URL', 'glint'),
            [$this, 'render_meta_box'],
            'project',
            'normal',
            'default'
        );
    }

    /**
     * Render meta box
     */
    public function render_meta_box(WP_Post $post): void {
        $value = get_post_meta($post->ID, '_project_url_site', true);
        ?>
        <label for="project_url_site"><?php _e('Enter the project site URL:', 'glint'); ?></label>
        <input
            type="url"
            name="project_url_site"
            id="project_url_site"
            value="<?php echo esc_attr($value); ?>"
            style="width:100%;"
        />
        <?php
    }

    /**
     * Save meta box value
     */
    public function save_meta(int $post_id, WP_Post $post): void {
        if ($post->post_type !== 'project') return;
        if (!current_user_can('edit_post', $post_id)) return;

        if (isset($_POST['project_url_site'])) {
            update_post_meta($post_id, '_project_url_site', esc_url_raw($_POST['project_url_site']));
        }
    }


    

}
