<?php
/**
 * Handles the REST API endpoints for the Portfolio plugin.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Portfolio_API {

    /**
     * API Namespace
     *
     * @var string
     */
    private $namespace = 'portfolio/v1';

    /**
     * API Route
     *
     * @var string
     */
    private $route = '/items';

    /**
     * Register hooks.
     */
    public function register() {
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }

    /**
     * Register the REST API route.
     */
    public function register_routes() {
        register_rest_route( $this->namespace, $this->route, array(
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => array( $this, 'get_items' ),
            'permission_callback' => array( $this, 'get_items_permissions_check' ),
            'args'                => $this->get_collection_params(),
        ) );
    }

    /**
     * Check if a given request has access to read items.
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access, WP_Error object otherwise.
     */
    public function get_items_permissions_check( $request ) {
        // Publicly accessible read endpoint
        return true;
    }

    /**
     * Retrieve portfolio items.
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_items( $request ) {
        try {
            $per_page = $request->get_param( 'per_page' );
            $page     = $request->get_param( 'page' );

            $args = array(
                'post_type'      => 'portfolio',
                'post_status'    => 'publish',
                'posts_per_page' => $per_page ? absint( $per_page ) : 10,
                'paged'          => $page ? absint( $page ) : 1,
                'orderby'        => 'date',
                'order'          => 'DESC',
            );

            $query = new WP_Query( $args );

            if ( empty( $query->posts ) ) {
                return $this->format_response( false, 'No portfolio items found.', array(), 404 );
            }

            $data = array();

            foreach ( $query->posts as $post ) {
                $data[] = $this->prepare_item_for_response( $post, $request );
            }

            // Prepare pagination headers
            $total_posts = $query->found_posts;
            $max_pages   = $query->max_num_pages;

            $response = $this->format_response( true, 'Portfolio items retrieved successfully.', $data, 200 );
            $response->header( 'X-WP-Total', $total_posts );
            $response->header( 'X-WP-TotalPages', $max_pages );

            return $response;

        } catch ( Exception $e ) {
            return $this->format_response( false, 'An error occurred processing the request.', array( 'error' => $e->getMessage() ), 500 );
        }
    }

    /**
     * Prepare the item for the REST response.
     *
     * @param WP_Post         $post    Post object.
     * @param WP_REST_Request $request Request object.
     * @return array
     */
    private function prepare_item_for_response( $post, $request ) {
        $thumbnail_id = get_post_thumbnail_id( $post->ID );
        $thumbnail_url = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'full' ) : null;

        return array(
            'id'           => $post->ID,
            'title'        => get_the_title( $post->ID ),
            'slug'         => $post->post_name,
            'excerpt'      => get_the_excerpt( $post->ID ),
            'content'      => apply_filters( 'the_content', $post->post_content ),
            'thumbnail'    => $thumbnail_url,
            'date'         => get_the_date( 'c', $post->ID ),
            'modified'     => get_the_modified_date( 'c', $post->ID ),
            'link'         => get_permalink( $post->ID ),
            'technologies' => wp_get_post_terms( $post->ID, 'post_tag', array( 'fields' => 'names' ) ),
        );
    }

    /**
     * Format the standard JSON response.
     *
     * @param bool   $success HTTP status indicator.
     * @param string $message User-friendly message.
     * @param array  $data    The payload.
     * @param int    $status  HTTP status code.
     * @return WP_REST_Response
     */
    private function format_response( $success, $message, $data = array(), $status = 200 ) {
        $response_data = array(
            'success' => $success,
            'message' => $message,
            'data'    => $data,
        );

        return rest_ensure_response( new WP_REST_Response( $response_data, $status ) );
    }

    /**
     * Get collection parameters for validation.
     *
     * @return array
     */
    public function get_collection_params() {
        return array(
            'page'     => array(
                'description'       => 'Current page of the collection.',
                'type'              => 'integer',
                'default'           => 1,
                'sanitize_callback' => 'absint',
                'validate_callback' => 'rest_validate_request_arg',
                'minimum'           => 1,
            ),
            'per_page' => array(
                'description'       => 'Maximum number of items to be returned in result set.',
                'type'              => 'integer',
                'default'           => 10,
                'sanitize_callback' => 'absint',
                'validate_callback' => 'rest_validate_request_arg',
                'minimum'           => 1,
                'maximum'           => 100,
            ),
        );
    }
}
