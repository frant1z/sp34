<div class="sptp-meta">
    <p>
        <label for="sp_type">Тип тура</label><br>
        <select name="sp_type" id="sp_type">
            <option value="one" <?php selected( $data['type'], 'one' ); ?>>Однодневный</option>
            <option value="multi" <?php selected( $data['type'], 'multi' ); ?>>Многодневный</option>
        </select>
    </p>
    <p>
        <label for="sp_short">Краткое описание</label><br>
        <textarea name="sp_short" id="sp_short" rows="3" style="width:100%;"><?php echo esc_textarea( $data['short'] ); ?></textarea>
    </p>
    <h4>Изображения (6)</h4>
    <div class="sptp-images">
        <?php for ( $i = 0; $i < 6; $i++ ) : $img = $data['images'][ $i ] ?? ''; ?>
            <div class="sptp-img-item">
                <input type="hidden" name="sp_images[]" value="<?php echo esc_attr( $img ); ?>" />
                <img src="<?php echo $img ? wp_get_attachment_image_url( $img, 'thumbnail' ) : ''; ?>" />
                <button class="sptp-upload">Выбрать</button>
            </div>
        <?php endfor; ?>
    </div>
    <h4>Программа тура</h4>
    <div class="sptp-program" data-name="sp_program[]">
        <?php foreach ( $data['program'] as $day ) : ?>
            <div class="sptp-program-item">
                <textarea name="sp_program[]" rows="2" style="width:100%;"><?php echo esc_textarea( $day ); ?></textarea>
                <button class="sptp-remove">Удалить</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="sptp-add-program">Добавить день</button>
    <h4>Даты и цены</h4>
    <div class="sptp-dates">
        <?php foreach ( $data['dates'] as $d ) : ?>
            <div class="sptp-date-item">
                <input type="date" name="sp_dates[][date]" value="<?php echo esc_attr( $d['date'] ); ?>" />
                <input type="text" name="sp_dates[][price]" placeholder="Цена" value="<?php echo esc_attr( $d['price'] ); ?>" />
                <label><input type="checkbox" name="sp_dates[][hot]" <?php checked( $d['hot'], 1 ); ?> />🔥</label>
                <button class="sptp-remove">Удалить</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="sptp-add-date">Добавить дату</button>
    <p>
        <label for="sp_included">Что включено</label><br>
        <textarea name="sp_included" id="sp_included" rows="2" style="width:100%;"><?php echo esc_textarea( $data['included'] ); ?></textarea>
    </p>
    <p>
        <label for="sp_extra">Дополнительные расходы</label><br>
        <textarea name="sp_extra" id="sp_extra" rows="2" style="width:100%;"><?php echo esc_textarea( $data['extra'] ); ?></textarea>
    </p>
    <p>
        <label for="sp_depart">Отправление</label><br>
        <input type="text" name="sp_depart" id="sp_depart" value="<?php echo esc_attr( $data['depart'] ); ?>" style="width:100%;" />
    </p>
    <p>
        <label for="sp_return">Возвращение</label><br>
        <input type="text" name="sp_return" id="sp_return" value="<?php echo esc_attr( $data['return'] ); ?>" style="width:100%;" />
    </p>
    <h4>Галерея</h4>
    <div class="sptp-gallery" data-name="sp_gallery[]">
        <?php foreach ( $data['gallery'] as $img ) : ?>
            <div class="sptp-gallery-item">
                <input type="hidden" name="sp_gallery[]" value="<?php echo esc_attr( $img ); ?>" />
                <img src="<?php echo wp_get_attachment_image_url( $img, 'thumbnail' ); ?>" />
                <button class="sptp-remove">Удалить</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="sptp-add-gallery">Добавить изображение</button>
    <p>
        <label>Плашки</label><br>
        <label><input type="checkbox" name="sp_badges[]" value="hot" <?php checked( in_array( 'hot', $data['badges'] ) ); ?> /> Горящая цена</label>
        <label><input type="checkbox" name="sp_badges[]" value="new" <?php checked( in_array( 'new', $data['badges'] ) ); ?> /> Новый тур</label>
    </p>
    <p>
        <label>Показывать на страницах</label><br>
        <select name="sp_pages[]" multiple style="width:100%;max-height:150px;">
            <?php foreach ( get_pages() as $page ) : ?>
                <option value="<?php echo $page->ID; ?>" <?php selected( in_array( $page->ID, $data['pages'] ) ); ?>><?php echo esc_html( $page->post_title ); ?></option>
            <?php endforeach; ?>
        </select>
    </p>
</div>
