<?php
/**
 * Plugin Name: Portfolio API Plugin
 * Plugin URI: https://github.com/yourusername/portfolio-api-plugin
 * Description: A robust, OOP-based WordPress plugin to manage a Portfolio Custom Post Type and expose it via a clean REST API endpoint. Built for performance and extensibility.
 * Version: 1.0.0
 * Author: Senior WordPress Developer
 * Author URI: https://yourportfolio.com
 * Text Domain: portfolio-api-plugin
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants
define( 'PORTFOLIO_API_VERSION', '1.0.0' );
define( 'PORTFOLIO_API_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Main Plugin Class
 */
final class Portfolio_API_Plugin {

    /**
     * Instance of this class.
     *
     * @var object
     */
    private static $instance = null;

    /**
     * Return an instance of this class.
     *
     * @return Portfolio_API_Plugin A single instance of this class.
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        $this->includes();
        $this->init_classes();
    }

    /**
     * Include required files
     */
    private function includes() {
        require_once PORTFOLIO_API_PLUGIN_DIR . 'includes/class-post-type.php';
        require_once PORTFOLIO_API_PLUGIN_DIR . 'includes/class-api.php';
    }

    /**
     * Initialize classes
     */
    private function init_classes() {
        // Initialize Post Type
        $post_type = new Portfolio_Post_Type();
        $post_type->register();

        // Initialize API
        $api = new Portfolio_API();
        $api->register();
    }
}

// Initialize the plugin
function run_portfolio_api_plugin() {
    Portfolio_API_Plugin::get_instance();
}
add_action( 'plugins_loaded', 'run_portfolio_api_plugin' );
