<?php
/**
 * Plugin Name: SP Tour Pages
 * Description: Create and display bus tour pages with modern design.
 * Version: 1.0.0
 * Author: Codex
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'SPTP_PATH', plugin_dir_path( __FILE__ ) );
define( 'SPTP_URL', plugin_dir_url( __FILE__ ) );

require_once SPTP_PATH . 'includes/class-sp-tour-cpt.php';
require_once SPTP_PATH . 'includes/class-sp-tour-meta.php';
require_once SPTP_PATH . 'includes/class-sp-tour-hooks.php';
require_once SPTP_PATH . 'includes/class-sp-tour-telegram.php';

register_activation_hook( __FILE__, function () {
    SP_Tour_CPT::register();
    flush_rewrite_rules();
} );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );

SP_Tour_CPT::init();
SP_Tour_Meta::init();
SP_Tour_Hooks::init();
SP_Tour_Telegram::init();
