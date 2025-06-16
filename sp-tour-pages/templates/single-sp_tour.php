<?php
get_header();
$data = get_post_meta( get_the_ID(), SP_Tour_Meta::META_KEY, true );
$calendar_icon = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjZmY2YjAwIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+PHJlY3QgeD0iMyIgeT0iNCIgd2lkdGg9IjEwIiBoZWlnaHQ9IjkiIHJ4PSIyIi8+PHBhdGggZD0iTTMgN2gxME04IDJ2Mm0wIDh2MiIvPjwvc3ZnPg==';
$phone_icon = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjZmY2YjAwIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+PHBhdGggZD0iTTIgMmgzbDIgNS0yIDFhMTEgMTEgMCAwMDYgNmwxLTIgNSAydjNhMiAyIDAgMDEtMiAyQTEyIDEyIDAgMDEyIDRhMiAyIDAgMDEyLTJ6Ii8+PC9zdmc+';
?>
<main class="sptp-page">
    <div class="sptp-top-images">
        <?php foreach ( $data['images'] as $img ) : ?>
            <img src="<?php echo wp_get_attachment_image_url( $img, 'medium' ); ?>" />
        <?php endforeach; ?>
    </div>
    <h1><?php the_title(); ?></h1>
    <p class="sptp-short"><?php echo esc_html( $data['short'] ); ?></p>
    <div class="sptp-program-list">
        <?php foreach ( $data['program'] as $i => $day ) : ?>
            <div class="sptp-acc-item">
                <button class="sptp-acc-btn">День <?php echo $i+1; ?></button>
                <div class="sptp-acc-panel"><p><?php echo nl2br( esc_html( $day ) ); ?></p></div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="sptp-prices">
        <?php foreach ( $data['dates'] as $d ) : ?>
            <div class="sptp-price-item">
                <img src="<?php echo $calendar_icon; ?>" alt="" />
                <span><?php echo date_i18n( 'd.m.Y', strtotime( $d['date'] ) ); ?></span>
                <span class="price"><?php echo esc_html( $d['price'] ); ?></span>
                <?php if ( ! empty( $d['hot'] ) ) : ?><span class="hot">🔥</span><?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="sptp-info">
        <p><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjNGNhZjUwIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+PHBhdGggZD0iTTIgOWw0IDQgOC04Ii8+PC9zdmc+" alt="" /> <strong>Что включено:</strong> <?php echo esc_html( $data['included'] ); ?></p>
        <p><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjNGNhZjUwIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+PHBhdGggZD0iTTIgOWw0IDQgOC04Ii8+PC9zdmc+" alt="" /> <strong>Дополнительные расходы:</strong> <?php echo esc_html( $data['extra'] ); ?></p>
        <p><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjNGNhZjUwIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+PHBhdGggZD0iTTIgOWw0IDQgOC04Ii8+PC9zdmc+" alt="" /> <strong>Отправление:</strong> <?php echo esc_html( $data['depart'] ); ?></p>
        <p><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjNGNhZjUwIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+PHBhdGggZD0iTTIgOWw0IDQgOC04Ii8+PC9zdmc+" alt="" /> <strong>Возвращение:</strong> <?php echo esc_html( $data['return'] ); ?></p>
    </div>
    <div class="sptp-gallery-scroll">
        <?php foreach ( $data['gallery'] as $img ) : ?>
            <img src="<?php echo wp_get_attachment_image_url( $img, 'medium' ); ?>" />
        <?php endforeach; ?>
    </div>
    <form class="sptp-form" id="sptp-form">
        <input type="hidden" name="tour_id" value="<?php echo get_the_ID(); ?>" />
        <p class="sptp-field"><input type="text" name="name" placeholder="Имя" required></p>
        <p class="sptp-field"><img src="<?php echo $phone_icon; ?>" class="icon" alt="" /><input type="tel" name="phone" placeholder="Телефон" required></p>
        <p><label><input type="checkbox" required> Согласен на обработку персональных данных</label></p>
        <p><button type="submit">Отправить</button></p>
    </form>
    <p class="sptp-disclaimer">*Программа тура может отличаться...</p>
    <div class="sptp-action-bar"><a href="#sptp-form" class="sptp-book-btn">Забронировать</a></div>
</main>
<?php
get_footer();
