<?php
class SP_Tour_CPT {
    public static function init() {
        add_action( 'init', [ __CLASS__, 'register' ] );
    }

    public static function register() {
        $labels = [
            'name'               => 'Туры',
            'singular_name'      => 'Тур',
            'add_new'            => 'Добавить тур',
            'add_new_item'       => 'Новый тур',
            'edit_item'          => 'Редактировать тур',
            'new_item'           => 'Новый тур',
            'all_items'          => 'Все туры',
            'view_item'          => 'Просмотр тура',
            'search_items'       => 'Поиск туров',
            'not_found'          => 'Туры не найдены',
            'not_found_in_trash' => 'В корзине туры не найдены',
            'menu_name'          => 'Туры'
        ];

        register_post_type( 'sp_tour', [
            'labels'      => $labels,
            'public'      => true,
            'has_archive' => false,
            'rewrite'     => [ 'slug' => 'tours' ],
            'supports'    => [ 'title', 'thumbnail' ],
            'menu_icon'   => 'dashicons-tickets-alt',
            'show_in_rest' => true,
        ] );
    }
}
