<?php
/*
Plugin Name: SP Tour Pages
Description: Adds tour pages and cards with Telegram integration.
Version: 1.0.0
Author: Your Name
*/

if ( ! defined( 'ABSPATH' ) ) exit;

// Define plugin constants
if ( ! defined( 'SP_TOUR_PAGES_DIR' ) ) {
    define( 'SP_TOUR_PAGES_DIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'SP_TOUR_PAGES_URL' ) ) {
    define( 'SP_TOUR_PAGES_URL', plugin_dir_url( __FILE__ ) );
}

// Load files
require_once SP_TOUR_PAGES_DIR . 'includes/post-types.php';
require_once SP_TOUR_PAGES_DIR . 'includes/meta-boxes.php';
require_once SP_TOUR_PAGES_DIR . 'includes/render.php';
require_once SP_TOUR_PAGES_DIR . 'includes/telegram.php';
require_once SP_TOUR_PAGES_DIR . 'includes/hooks.php';

// Enqueue frontend styles
function sp_tour_pages_enqueue() {
    wp_enqueue_style( 'sp-layout', SP_TOUR_PAGES_URL . 'assets/css/layout.css' );
    wp_enqueue_style( 'sp-typography', SP_TOUR_PAGES_URL . 'assets/css/typography.css' );
    wp_enqueue_style( 'sp-tour-page', SP_TOUR_PAGES_URL . 'assets/css/tour-page.css' );
    wp_enqueue_style( 'sp-tour-card', SP_TOUR_PAGES_URL . 'assets/css/tour-card.css' );
    wp_enqueue_style( 'sp-form', SP_TOUR_PAGES_URL . 'assets/css/form.css' );
}
add_action( 'wp_enqueue_scripts', 'sp_tour_pages_enqueue' );

// Enqueue admin styles
function sp_tour_pages_admin_styles() {
    wp_enqueue_style( 'sp-admin-meta', SP_TOUR_PAGES_URL . 'assets/css/admin-meta.css' );
}
add_action( 'admin_enqueue_scripts', 'sp_tour_pages_admin_styles' );

?>
