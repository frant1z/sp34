<?php
$nearest = '';
$price = '';
$calendar_icon = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjZmY2YjAwIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+PHJlY3QgeD0iMyIgeT0iNCIgd2lkdGg9IjEwIiBoZWlnaHQ9IjkiIHJ4PSIyIi8+PHBhdGggZD0iTTMgN2gxME04IDJ2Mm0wIDh2MiIvPjwvc3ZnPg==';
$arrow_icon = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+PHBhdGggZD0iTTUgMTJsNS00LTUtNCIvPjwvc3ZnPg==';
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
        <div class="sptp-card-img">
            <?php echo get_the_post_thumbnail( $post_id, 'medium' ); ?>
            <div class="sptp-card-badges">
                <?php if ( in_array( 'hot', $badges ) || ! empty( $hot ) ) : ?><span class="badge hot">🔥 Горящая цена</span><?php endif; ?>
                <?php if ( in_array( 'new', $badges ) ) : ?><span class="badge new">Новый тур</span><?php endif; ?>
            </div>
            <?php if ( $nearest ) : ?>
                <div class="sptp-card-overlay"><span><?php echo esc_html( $nearest ); ?></span><span class="price"><?php echo esc_html( $price ); ?></span></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="sptp-card-body">
        <h3 class="sptp-card-title"><?php echo get_the_title( $post_id ); ?></h3>
        <?php if ( $nearest ) : ?>
            <div class="sptp-card-date"><img src="<?php echo $calendar_icon; ?>" class="icon" alt="" /><?php echo esc_html( $nearest ); ?> — <span class="sptp-card-price"><?php echo esc_html( $price ); ?></span></div>
        <?php endif; ?>
        <a href="<?php echo get_permalink( $post_id ); ?>" class="sptp-card-link">Подробнее <img src="<?php echo $arrow_icon; ?>" class="icon" alt="" /></a>
    </div>
</div>
