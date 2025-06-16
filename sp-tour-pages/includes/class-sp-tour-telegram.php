<?php
class SP_Tour_Telegram {
    public static function init() {
        add_action( 'wp_ajax_sp_tour_send', [ __CLASS__, 'send' ] );
        add_action( 'wp_ajax_nopriv_sp_tour_send', [ __CLASS__, 'send' ] );
    }

    public static function send() {
        check_ajax_referer( 'sptp_form', 'nonce' );
        $name = sanitize_text_field( $_POST['name'] ?? '' );
        $phone = sanitize_text_field( $_POST['phone'] ?? '' );
        $tour = intval( $_POST['tour_id'] );
        $message = "\xF0\x9F\x9A\xA9 Новая заявка\n";
        $message .= "Тур: " . get_the_title( $tour ) . "\n";
        $message .= "Имя: $name\nТелефон: $phone";
        $token = defined('SP_TG_BOT_TOKEN') ? SP_TG_BOT_TOKEN : '';
        $chat = defined('SP_TG_CHAT_ID') ? SP_TG_CHAT_ID : '';
        if ( $token && $chat ) {
            wp_remote_post( "https://api.telegram.org/bot{$token}/sendMessage", [
                'body' => [
                    'chat_id' => $chat,
                    'text'    => $message
                ]
            ] );
        }
        wp_send_json_success();
    }
}
