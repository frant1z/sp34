<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function sp_register_tour_post_type() {
    $labels = array(
        'name' => 'Tours',
        'singular_name' => 'Tour',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Tour',
        'edit_item' => 'Edit Tour',
        'new_item' => 'New Tour',
        'view_item' => 'View Tour',
        'search_items' => 'Search Tours',
        'not_found' => 'No Tours found',
        'not_found_in_trash' => 'No Tours found in Trash',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'tours' ),
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'show_in_rest' => false,
    );

    register_post_type( 'sp_tour', $args );
}
add_action( 'init', 'sp_register_tour_post_type' );
?>
