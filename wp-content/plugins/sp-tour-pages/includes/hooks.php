<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Inject tour cards into selected pages
function sp_inject_tour_cards( $content ) {
    if ( is_page() && in_the_loop() && is_main_query() ) {
        $page_id = get_the_ID();
        $args = array(
            'post_type' => 'sp_tour',
            'posts_per_page' => -1
        );
        $tours = get_posts( $args );
        foreach ( $tours as $tour ) {
            $pages = explode( ',', get_post_meta( $tour->ID, 'sp_pages', true ) );
            if ( in_array( $page_id, array_map('intval',$pages) ) ) {
                $content .= sp_render_tour_card( $tour->ID );
            }
        }
    }
    return $content;
}
add_filter( 'the_content', 'sp_inject_tour_cards' );

// Handle form submission
function sp_tour_form_submit() {
    if ( isset($_POST['sp_tour_form']) ) {
        $name = sanitize_text_field( $_POST['sp_name'] );
        $phone = sanitize_text_field( $_POST['sp_phone'] );
        $message = sanitize_textarea_field( $_POST['sp_message'] );
        $tour = get_the_title( get_the_ID() );
        $text = "New tour booking:\nTour: $tour\nName: $name\nPhone: $phone\n$message";
        sp_send_telegram( $text );
        wp_redirect( add_query_arg('sp_sent','1', get_permalink() ) );
        exit;
    }
}
add_action( 'template_redirect', 'sp_tour_form_submit' );
?>
