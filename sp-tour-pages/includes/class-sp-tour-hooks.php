<?php
class SP_Tour_Hooks {
    public static function init() {
        add_filter( 'template_include', [ __CLASS__, 'template' ] );
        add_filter( 'the_content', [ __CLASS__, 'add_cards' ] );
        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'assets' ] );
    }

    public static function template( $template ) {
        if ( is_singular( 'sp_tour' ) ) {
            return SPTP_PATH . 'templates/single-sp_tour.php';
        }
        return $template;
    }

    public static function assets() {
        wp_enqueue_style( 'sptp-layout', SPTP_URL . 'assets/css/layout.css', [], '1.0' );
        wp_enqueue_style( 'sptp-typography', SPTP_URL . 'assets/css/typography.css', [], '1.0' );
        wp_enqueue_style( 'sptp-card', SPTP_URL . 'assets/css/tour-card.css', [], '1.0' );
        wp_enqueue_style( 'sptp-page', SPTP_URL . 'assets/css/tour-page.css', [], '1.0' );
        wp_enqueue_style( 'sptp-form', SPTP_URL . 'assets/css/form.css', [], '1.0' );
        wp_enqueue_script( 'sptp-front', SPTP_URL . 'assets/js/front.js', [], '1.0', true );
        wp_localize_script( 'sptp-front', 'sptpAjax', [
            'url' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'sptp_form' ),
        ] );
    }

    public static function add_cards( $content ) {
        if ( is_singular( 'page' ) && in_the_loop() && is_main_query() ) {
            $page_id = get_the_ID();
            $tours = get_posts( [
                'post_type' => 'sp_tour',
                'numberposts' => -1,
                'meta_query' => [
                    [
                        'key' => SP_Tour_Meta::META_KEY,
                        'value' => '"' . $page_id . '"',
                        'compare' => 'LIKE'
                    ]
                ]
            ] );
            foreach ( $tours as $tour ) {
                $content .= self::render_card( $tour->ID );
            }
        }
        return $content;
    }

    public static function render_card( $post_id ) {
        $data = get_post_meta( $post_id, SP_Tour_Meta::META_KEY, true );
        ob_start();
        include SPTP_PATH . 'templates/tour-card.php';
        return ob_get_clean();
    }
}
