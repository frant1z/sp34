<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function sp_tour_get_images( $ids ) {
    $ids = array_map( 'intval', explode( ',', $ids ) );
    $urls = array();
    foreach ( $ids as $id ) {
        $url = wp_get_attachment_image_url( $id, 'large' );
        if ( $url ) $urls[] = $url;
    }
    return $urls;
}

function sp_render_tour_card( $post_id ) {
    $title = get_the_title( $post_id );
    $short = get_post_meta( $post_id, 'sp_short_desc', true );
    $images = sp_tour_get_images( get_post_meta( $post_id, 'sp_images', true ) );
    $dates_raw = get_post_meta( $post_id, 'sp_dates', true );
    $badges = explode( ',', get_post_meta( $post_id, 'sp_badges', true ) );

    $next_date = '';
    $price = '';
    if ( $dates_raw ) {
        $lines = array_filter( array_map( 'trim', explode( "\n", $dates_raw ) ) );
        if ( $lines ) {
            list( $d, $p ) = array_pad( explode( '|', $lines[0] ), 2, '' );
            $next_date = esc_html( $d );
            $price = esc_html( $p );
        }
    }

    ob_start();
    ?>
    <div class="sp-tour-card">
        <?php if ( ! empty($images[0]) ) : ?><img src="<?php echo esc_url( $images[0] ); ?>" class="sp-tour-thumb" /><?php endif; ?>
        <h3 class="sp-tour-title"><?php echo esc_html( $title ); ?></h3>
        <?php if ( $next_date ) : ?><div class="sp-tour-date"><?php echo $next_date; ?> — <?php echo $price; ?></div><?php endif; ?>
        <?php if ( in_array( 'hot', $badges ) ) : ?><span class="sp-badge hot">🔥 Hot Price</span><?php endif; ?>
        <?php if ( in_array( 'new', $badges ) ) : ?><span class="sp-badge new">New Tour</span><?php endif; ?>
        <p><?php echo esc_html( $short ); ?></p>
        <a href="<?php echo get_permalink( $post_id ); ?>" class="sp-card-link">View</a>
    </div>
    <?php
    return ob_get_clean();
}

function sp_tour_single_template( $single ) {
    global $post;
    if ( $post->post_type === 'sp_tour' ) {
        return SP_TOUR_PAGES_DIR . 'templates/single-sp_tour.php';
    }
    return $single;
}
add_filter( 'single_template', 'sp_tour_single_template' );
?>
