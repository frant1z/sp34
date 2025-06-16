<?php
$nearest = '';
$price = '';
if ( ! empty( $data['dates'] ) ) {
    usort( $data['dates'], function( $a, $b ){ return strcmp( $a['date'], $b['date'] ); } );
    foreach ( $data['dates'] as $d ) {
        if ( strtotime( $d['date'] ) >= strtotime( 'today' ) ) {
            $nearest = date_i18n( 'd.m.Y', strtotime( $d['date'] ) );
            $price = $d['price'];
            $hot = $d['hot'];
            break;
        }
    }
}
$badges = $data['badges'];
?>
<div class="sptp-card">
    <?php if ( has_post_thumbnail( $post_id ) ) : ?>
        <div class="sptp-card-img"><?php echo get_the_post_thumbnail( $post_id, 'medium' ); ?></div>
    <?php endif; ?>
    <div class="sptp-card-body">
        <h3 class="sptp-card-title"><?php echo get_the_title( $post_id ); ?></h3>
        <?php if ( $nearest ) : ?>
            <div class="sptp-card-date"><?php echo esc_html( $nearest ); ?> — <span class="sptp-card-price"><?php echo esc_html( $price ); ?></span></div>
        <?php endif; ?>
        <div class="sptp-card-badges">
            <?php if ( in_array( 'hot', $badges ) || ! empty( $hot ) ) : ?><span class="badge hot">🔥 Горящая цена</span><?php endif; ?>
            <?php if ( in_array( 'new', $badges ) ) : ?><span class="badge new">Новый тур</span><?php endif; ?>
        </div>
        <a href="<?php echo get_permalink( $post_id ); ?>" class="sptp-card-link">Подробнее</a>
    </div>
</div>
