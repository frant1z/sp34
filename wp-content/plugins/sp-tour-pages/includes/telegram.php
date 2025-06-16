<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function sp_send_telegram( $text ) {
    if ( ! defined('SP_TG_BOT_TOKEN') || ! defined('SP_TG_CHAT_ID') ) return;
    $url = 'https://api.telegram.org/bot' . SP_TG_BOT_TOKEN . '/sendMessage';
    $args = array(
        'body' => array(
            'chat_id' => SP_TG_CHAT_ID,
            'text' => $text,
            'parse_mode' => 'HTML'
        )
    );
    wp_remote_post( $url, $args );
}
?>
