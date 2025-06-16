<?php
class SP_Tour_Meta {
    const META_KEY = '_sp_tour_data';

    public static function init() {
        add_action( 'add_meta_boxes', [ __CLASS__, 'meta_box' ] );
        add_action( 'save_post_sp_tour', [ __CLASS__, 'save' ] );
        add_action( 'admin_enqueue_scripts', [ __CLASS__, 'admin_assets' ] );
    }

    public static function admin_assets( $hook ) {
        if ( $hook === 'post.php' || $hook === 'post-new.php' ) {
            wp_enqueue_media();
            wp_enqueue_style( 'sptp-admin-meta', SPTP_URL . 'assets/css/admin-meta.css', [], '1.0' );
            wp_enqueue_script( 'sptp-admin', SPTP_URL . 'assets/js/admin.js', [], '1.0', true );
        }
    }

    public static function meta_box() {
        add_meta_box( 'sp_tour_meta', 'Данные тура', [ __CLASS__, 'render' ], 'sp_tour', 'normal', 'high' );
    }

    public static function render( $post ) {
        $data = get_post_meta( $post->ID, self::META_KEY, true );
        $data = wp_parse_args( $data, [
            'type' => '',
            'short' => '',
            'images' => [],
            'program' => [],
            'dates' => [],
            'included' => '',
            'extra' => '',
            'depart' => '',
            'return' => '',
            'gallery' => [],
            'badges' => [],
            'pages' => []
        ] );
        wp_nonce_field( 'sp_tour_save', 'sp_tour_nonce' );
        include SPTP_PATH . 'templates/admin-meta.php';
    }

    public static function save( $post_id ) {
        if ( ! isset( $_POST['sp_tour_nonce'] ) || ! wp_verify_nonce( $_POST['sp_tour_nonce'], 'sp_tour_save' ) ) {
            return;
        }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        $fields = [
            'type', 'short', 'included', 'extra', 'depart', 'return',
        ];
        $data = [];
        foreach ( $fields as $field ) {
            $data[ $field ] = sanitize_text_field( $_POST['sp_' . $field] ?? '' );
        }
        $data['images'] = array_map( 'absint', $_POST['sp_images'] ?? [] );
        $data['program'] = array_map( 'sanitize_textarea_field', $_POST['sp_program'] ?? [] );
        if ( isset( $_POST['sp_dates'] ) ) {
            $dates = [];
            foreach ( (array) $_POST['sp_dates'] as $d ) {
                if ( empty( $d['date'] ) ) continue;
                $dates[] = [
                    'date' => sanitize_text_field( $d['date'] ),
                    'price' => sanitize_text_field( $d['price'] ),
                    'hot' => ! empty( $d['hot'] ) ? 1 : 0,
                ];
            }
            $data['dates'] = $dates;
        }
        $data['gallery'] = array_map( 'absint', $_POST['sp_gallery'] ?? [] );
        $data['badges'] = array_map( 'sanitize_text_field', $_POST['sp_badges'] ?? [] );
        $data['pages'] = array_map( 'absint', $_POST['sp_pages'] ?? [] );
        update_post_meta( $post_id, self::META_KEY, $data );
    }
}
