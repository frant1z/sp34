<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function sp_tour_add_meta_boxes() {
    add_meta_box( 'sp_tour_details', 'Tour Details', 'sp_tour_details_callback', 'sp_tour', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'sp_tour_add_meta_boxes' );

function sp_get_pages_options() {
    $pages = get_pages();
    $options = '';
    foreach ( $pages as $page ) {
        $options .= '<option value="' . $page->ID . '">' . esc_html( $page->post_title ) . '</option>';
    }
    return $options;
}

function sp_tour_details_callback( $post ) {
    wp_nonce_field( 'sp_tour_save_meta', 'sp_tour_meta_nonce' );
    $values = get_post_meta( $post->ID );
    $type = $values['sp_type'][0] ?? 'one';
    $short = $values['sp_short_desc'][0] ?? '';
    $program = $values['sp_program'][0] ?? '';
    $dates = $values['sp_dates'][0] ?? '';
    $includes = $values['sp_includes'][0] ?? '';
    $departure = $values['sp_departure'][0] ?? '';
    $disclaimer = $values['sp_disclaimer'][0] ?? '';
    $badges = $values['sp_badges'][0] ?? '';
    $pages = $values['sp_pages'][0] ?? '';
    ?>
    <table class="form-table">
        <tr>
            <th><label for="sp_type">Tour Type</label></th>
            <td>
                <select name="sp_type" id="sp_type">
                    <option value="one" <?php selected( $type, 'one' ); ?>>One Day</option>
                    <option value="multi" <?php selected( $type, 'multi' ); ?>>Multi Day</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="sp_short_desc">Short Description</label></th>
            <td><textarea name="sp_short_desc" id="sp_short_desc" rows="3" style="width:100%;"><?php echo esc_textarea( $short ); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="sp_images">Images (IDs comma separated)</label></th>
            <td><input type="text" name="sp_images" id="sp_images" value="<?php echo esc_attr( $values['sp_images'][0] ?? '' ); ?>" style="width:100%;" /></td>
        </tr>
        <tr>
            <th><label for="sp_program">Program (one per line)</label></th>
            <td><textarea name="sp_program" id="sp_program" rows="6" style="width:100%;"><?php echo esc_textarea( $program ); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="sp_dates">Dates and Prices (date|price|hot; one per line)</label></th>
            <td><textarea name="sp_dates" id="sp_dates" rows="5" style="width:100%;"><?php echo esc_textarea( $dates ); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="sp_includes">Includes / Extra</label></th>
            <td><textarea name="sp_includes" id="sp_includes" rows="3" style="width:100%;"><?php echo esc_textarea( $includes ); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="sp_departure">Departure / Return</label></th>
            <td><textarea name="sp_departure" id="sp_departure" rows="2" style="width:100%;"><?php echo esc_textarea( $departure ); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="sp_disclaimer">Disclaimer</label></th>
            <td><input type="text" name="sp_disclaimer" id="sp_disclaimer" value="<?php echo esc_attr( $disclaimer ); ?>" style="width:100%;" /></td>
        </tr>
        <tr>
            <th><label for="sp_badges">Badges</label></th>
            <td>
                <select name="sp_badges[]" id="sp_badges" multiple>
                    <option value="hot" <?php if ( strpos($badges,'hot')!==false ) echo 'selected'; ?>>Hot Price</option>
                    <option value="new" <?php if ( strpos($badges,'new')!==false ) echo 'selected'; ?>>New Tour</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="sp_pages">Show on Pages</label></th>
            <td>
                <select name="sp_pages[]" id="sp_pages" multiple style="height:120px;">
                    <?php echo sp_get_pages_options(); ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

function sp_tour_save_meta( $post_id ) {
    if ( ! isset( $_POST['sp_tour_meta_nonce'] ) || ! wp_verify_nonce( $_POST['sp_tour_meta_nonce'], 'sp_tour_save_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $fields = array( 'sp_type','sp_short_desc','sp_images','sp_program','sp_dates','sp_includes','sp_departure','sp_disclaimer' );
    foreach ( $fields as $field ) {
        if ( isset( $_POST[$field] ) ) {
            update_post_meta( $post_id, $field, sanitize_textarea_field( $_POST[$field] ) );
        }
    }

    // Save badges
    $badges = isset($_POST['sp_badges']) ? implode(',', array_map('sanitize_text_field', (array)$_POST['sp_badges'])) : '';
    update_post_meta( $post_id, 'sp_badges', $badges );

    // Save pages
    $pages = isset($_POST['sp_pages']) ? implode(',', array_map('intval', (array)$_POST['sp_pages'])) : '';
    update_post_meta( $post_id, 'sp_pages', $pages );
}
add_action( 'save_post_sp_tour', 'sp_tour_save_meta' );
?>
