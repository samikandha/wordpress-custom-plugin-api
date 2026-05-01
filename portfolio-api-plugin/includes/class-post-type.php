<?php
/**
 * Handles the registration of the Portfolio Custom Post Type.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Portfolio_Post_Type {

    /**
     * Post type slug.
     *
     * @var string
     */
    private $post_type = 'portfolio';

    /**
     * Register hooks.
     */
    public function register() {
        add_action( 'init', array( $this, 'register_post_type' ) );
    }

    /**
     * Register the custom post type.
     */
    public function register_post_type() {
        $labels = array(
            'name'                  => _x( 'Portfolios', 'Post Type General Name', 'portfolio-api-plugin' ),
            'singular_name'         => _x( 'Portfolio', 'Post Type Singular Name', 'portfolio-api-plugin' ),
            'menu_name'             => __( 'Portfolios', 'portfolio-api-plugin' ),
            'name_admin_bar'        => __( 'Portfolio', 'portfolio-api-plugin' ),
            'archives'              => __( 'Portfolio Archives', 'portfolio-api-plugin' ),
            'attributes'            => __( 'Portfolio Attributes', 'portfolio-api-plugin' ),
            'parent_item_colon'     => __( 'Parent Portfolio:', 'portfolio-api-plugin' ),
            'all_items'             => __( 'All Portfolios', 'portfolio-api-plugin' ),
            'add_new_item'          => __( 'Add New Portfolio', 'portfolio-api-plugin' ),
            'add_new'               => __( 'Add New', 'portfolio-api-plugin' ),
            'new_item'              => __( 'New Portfolio', 'portfolio-api-plugin' ),
            'edit_item'             => __( 'Edit Portfolio', 'portfolio-api-plugin' ),
            'update_item'           => __( 'Update Portfolio', 'portfolio-api-plugin' ),
            'view_item'             => __( 'View Portfolio', 'portfolio-api-plugin' ),
            'view_items'            => __( 'View Portfolios', 'portfolio-api-plugin' ),
            'search_items'          => __( 'Search Portfolio', 'portfolio-api-plugin' ),
            'not_found'             => __( 'Not found', 'portfolio-api-plugin' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'portfolio-api-plugin' ),
            'featured_image'        => __( 'Featured Image', 'portfolio-api-plugin' ),
            'set_featured_image'    => __( 'Set featured image', 'portfolio-api-plugin' ),
            'remove_featured_image' => __( 'Remove featured image', 'portfolio-api-plugin' ),
            'use_featured_image'    => __( 'Use as featured image', 'portfolio-api-plugin' ),
            'insert_into_item'      => __( 'Insert into portfolio', 'portfolio-api-plugin' ),
            'uploaded_to_this_item' => __( 'Uploaded to this portfolio', 'portfolio-api-plugin' ),
            'items_list'            => __( 'Portfolios list', 'portfolio-api-plugin' ),
            'items_list_navigation' => __( 'Portfolios list navigation', 'portfolio-api-plugin' ),
            'filter_items_list'     => __( 'Filter portfolios list', 'portfolio-api-plugin' ),
        );
        $args = array(
            'label'                 => __( 'Portfolio', 'portfolio-api-plugin' ),
            'description'           => __( 'Portfolio items showcase', 'portfolio-api-plugin' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
            'taxonomies'            => array( 'category', 'post_tag' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-portfolio',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true, // Enables Gutenberg and default REST API
        );
        register_post_type( $this->post_type, $args );
    }
}
