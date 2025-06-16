<?php
get_header();
$tour_id = get_the_ID();
$short = get_post_meta( $tour_id, 'sp_short_desc', true );
$images = sp_tour_get_images( get_post_meta( $tour_id, 'sp_images', true ) );
$program = get_post_meta( $tour_id, 'sp_program', true );
$dates = get_post_meta( $tour_id, 'sp_dates', true );
$includes = get_post_meta( $tour_id, 'sp_includes', true );
$departure = get_post_meta( $tour_id, 'sp_departure', true );
$disclaimer = get_post_meta( $tour_id, 'sp_disclaimer', true );
$gallery = $images; // reuse images for gallery
?>
<div class="sp-tour-page">
    <h1><?php the_title(); ?></h1>
    <p><?php echo esc_html( $short ); ?></p>
    <div class="sp-image-grid">
        <?php foreach ( array_slice($images,0,6) as $img ) : ?>
            <img src="<?php echo esc_url($img); ?>" alt="" />
        <?php endforeach; ?>
    </div>
    <h2>Program</h2>
    <div class="sp-program">
        <?php foreach ( array_filter( array_map( 'trim', explode("\n", $program) ) ) as $idx => $line ) : ?>
            <div class="sp-acc-item">
                <button class="sp-acc-btn">Day <?php echo $idx+1; ?></button>
                <div class="sp-acc-content"><p><?php echo esc_html($line); ?></p></div>
            </div>
        <?php endforeach; ?>
    </div>
    <h2>Prices</h2>
    <ul class="sp-prices">
        <?php foreach ( array_filter( array_map('trim', explode("\n", $dates) ) ) as $line ) : list($d,$p,$h)=array_pad(explode('|',$line),3,''); ?>
            <li><?php echo esc_html($d); ?> - <?php echo esc_html($p); ?> <?php if($h==='hot'):?><span class="hot">🔥</span><?php endif; ?></li>
        <?php endforeach; ?>
    </ul>
    <div class="sp-gallery">
        <?php foreach ( $gallery as $img ) : ?>
            <img src="<?php echo esc_url($img); ?>" alt="" />
        <?php endforeach; ?>
    </div>
    <form method="post" class="sp-form">
        <input type="text" name="sp_name" placeholder="Your name" required />
        <input type="text" name="sp_phone" placeholder="Phone" required />
        <textarea name="sp_message" placeholder="Message"></textarea>
        <label><input type="checkbox" required /> I agree to data processing</label>
        <input type="hidden" name="sp_tour_form" value="1" />
        <button type="submit">Book</button>
    </form>
    <?php if ( $disclaimer ) : ?><p class="sp-disclaimer"><?php echo esc_html($disclaimer); ?></p><?php endif; ?>
</div>
<script>
document.querySelectorAll('.sp-acc-btn').forEach(btn=>{
    btn.addEventListener('click',()=>{
        const c = btn.nextElementSibling; c.style.display=c.style.display==='block'?'none':'block';
    });
});
</script>
<?php get_footer(); ?>
