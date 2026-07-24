<?php
/**
 * Регистрация полей ACF и страницы настроек — прямо в коде.
 * Ничего импортировать не нужно: активируйте ACF — поля появятся сами.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ==================================================================
 * Страница настроек в админке: «Контент сайта»
 * ================================================================== */
add_action( 'acf/init', 'rezka_acf_options_page' );
function rezka_acf_options_page() {
    if ( function_exists( 'acf_add_options_page' ) ) {
        acf_add_options_page( array(
            'page_title' => 'Контент сайта',
            'menu_title' => 'Контент сайта',
            'menu_slug'  => 'rezka-content',
            'capability' => 'edit_posts',
            'position'   => 2,
            'icon_url'   => 'dashicons-admin-customizer',
            'redirect'   => false,
        ) );
    }
}

/* ==================================================================
 * Поля
 * ================================================================== */
add_action( 'acf/init', 'rezka_acf_register_fields' );
function rezka_acf_register_fields() {

    if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

    // Заготовка поля-изображения (возвращаем URL)
    $img = function( $key, $label, $name ) {
        return array(
            'key' => $key, 'label' => $label, 'name' => $name,
            'type' => 'image', 'return_format' => 'url',
            'preview_size' => 'thumbnail', 'library' => 'all',
        );
    };
    $text = function( $key, $label, $name, $default = '' ) {
        return array(
            'key' => $key, 'label' => $label, 'name' => $name,
            'type' => 'text', 'default_value' => $default,
        );
    };
    $textarea = function( $key, $label, $name, $default = '' ) {
        return array(
            'key' => $key, 'label' => $label, 'name' => $name,
            'type' => 'textarea', 'rows' => 3, 'default_value' => $default,
        );
    };
    $tab = function( $key, $label ) {
        return array( 'key' => $key, 'label' => $label, 'type' => 'tab', 'placement' => 'top' );
    };

    acf_add_local_field_group( array(
        'key' => 'group_rezka_content',
        'title' => 'Контент главной страницы',
        'fields' => array(

            /* ---------- КОНТАКТЫ ---------- */
            $tab( 'tab_contacts', 'Контакты' ),
            $text( 'field_phone', 'Телефон (для показа)', 'phone', '8 (981) 723-89-79' ),
            $text( 'field_phone_raw', 'Телефон (для ссылки tel:)', 'phone_raw', '+79817238979' ),
            $text( 'field_wa', 'WhatsApp (номер для ссылки)', 'whatsapp', '79500031953' ),
            $text( 'field_wa_label', 'WhatsApp (для показа)', 'whatsapp_label', '+7 950 003-19-53' ),
            $text( 'field_tg', 'Telegram (номер для ссылки)', 'telegram', '+79500031953' ),
            $text( 'field_tg_label', 'Telegram (для показа)', 'telegram_label', '+7 950 003-19-53' ),
            $text( 'field_email', 'Email', 'email', 's7238979@mail.ru' ),
            $textarea( 'field_address', 'Адрес офиса', 'address', 'Россия, ЛО, М.Р-Н Волосовский, С.П. Бегуницкое, д. Бегуницы, д. 74, часть помещ. 9' ),

            /* ---------- ПЕРВЫЙ ЭКРАН ---------- */
            $tab( 'tab_hero', 'Первый экран' ),
            $text( 'field_hero_region', 'Метка «регион»', 'hero_region', 'Работаем по всей России' ),
            $text( 'field_hero_title1', 'Заголовок (тёмная строка)', 'hero_title1', 'ТОЧНОСТЬ.' ),
            $text( 'field_hero_title2', 'Заголовок (жёлтая строка)', 'hero_title2', 'БЕЗ УДАРА.' ),
            $textarea( 'field_hero_subtitle', 'Подзаголовок', 'hero_subtitle', 'Демонтажные работы методом канатной резки любой сложности.' ),
            $text( 'field_hero_btn1', 'Кнопка 1', 'hero_btn1', 'Связаться с нами' ),
            $text( 'field_hero_btn2', 'Кнопка 2', 'hero_btn2', 'Смотреть виды работ' ),
            $img( 'field_hero_image', 'Фото оборудования', 'hero_image' ),
            array(
                'key' => 'field_hero_features', 'label' => 'Преимущества (справа)', 'name' => 'hero_features',
                'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Добавить',
                'sub_fields' => array(
                    $img( 'field_hf_icon', 'Иконка (жёлтая)', 'icon' ),
                    $text( 'field_hf_text', 'Текст', 'text' ),
                ),
            ),

            /* ---------- КЛЮЧЕВЫЕ ЦИФРЫ ---------- */
            $tab( 'tab_stats', 'Цифры' ),
            array(
                'key' => 'field_stats', 'label' => 'Показатели', 'name' => 'stats',
                'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Добавить',
                'sub_fields' => array(
                    $img( 'field_stat_icon', 'Иконка (жёлтая)', 'icon' ),
                    $text( 'field_stat_num', 'Число', 'number' ),
                    $text( 'field_stat_label', 'Подпись', 'label' ),
                ),
            ),

            /* ---------- ВИДЫ РАБОТ ---------- */
            $tab( 'tab_services', 'Виды работ' ),
            $text( 'field_services_title', 'Заголовок', 'services_title', 'Виды работ и сфера применения канатной резки' ),
            $textarea( 'field_services_text', 'Описание', 'services_text', 'Канатная резка позволяет выполнять работы любой сложности с максимальной точностью и минимальным воздействием на конструкции.' ),
            $img( 'field_services_scheme', 'Изображение схемы', 'services_scheme' ),
            array(
                'key' => 'field_services_left', 'label' => 'Пункты (левая колонка)', 'name' => 'services_left',
                'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Добавить',
                'sub_fields' => array( $img( 'field_sl_icon', 'Иконка', 'icon' ), $textarea( 'field_sl_text', 'Текст', 'text' ) ),
            ),
            array(
                'key' => 'field_services_right', 'label' => 'Пункты (правая колонка)', 'name' => 'services_right',
                'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Добавить',
                'sub_fields' => array( $img( 'field_sr_icon', 'Иконка', 'icon' ), $textarea( 'field_sr_text', 'Текст', 'text' ) ),
            ),

            /* ---------- ПРЕИМУЩЕСТВА ---------- */
            $tab( 'tab_adv', 'Преимущества' ),
            $text( 'field_adv_title', 'Заголовок', 'advantages_title', 'Наши преимущества' ),
            array(
                'key' => 'field_advantages', 'label' => 'Преимущества', 'name' => 'advantages',
                'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Добавить',
                'sub_fields' => array( $img( 'field_adv_icon', 'Иконка (жёлтая)', 'icon' ), $textarea( 'field_adv_text', 'Текст', 'text' ) ),
            ),

            /* ---------- ТЕХНОЛОГИИ ---------- */
            $tab( 'tab_tech', 'Технологии' ),
            $text( 'field_tech_title', 'Заголовок', 'tech_title', 'Технологии' ),
            array(
                'key' => 'field_tech', 'label' => 'Карточки', 'name' => 'tech',
                'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Добавить',
                'sub_fields' => array(
                    $text( 'field_tech_num', 'Номер', 'number' ),
                    $text( 'field_tech_name', 'Название', 'title' ),
                    $img( 'field_tech_img', 'Фото', 'image' ),
                ),
            ),

            /* ---------- ГАЛЕРЕЯ ---------- */
            $tab( 'tab_gallery', 'Галерея' ),
            $text( 'field_gallery_title', 'Заголовок', 'gallery_title', 'Фото процесса работы' ),
            array(
                'key' => 'field_gallery', 'label' => 'Фотографии', 'name' => 'gallery',
                'type' => 'repeater', 'layout' => 'table', 'button_label' => 'Добавить фото',
                'sub_fields' => array( $img( 'field_gallery_img', 'Фото', 'image' ), $text( 'field_gallery_alt', 'Описание (alt)', 'alt' ) ),
            ),

            /* ---------- ОБЪЕКТЫ ---------- */
            $tab( 'tab_objects', 'Объекты' ),
            $text( 'field_objects_title', 'Заголовок', 'objects_title', 'Мы принимали участие на объектах' ),
            $img( 'field_objects_map', 'Карта России', 'objects_map' ),
            $textarea( 'field_objects_badge', 'Текст на плашке', 'objects_badge', 'Работаем на объектах по всей России' ),
            array(
                'key' => 'field_objects', 'label' => 'Объекты', 'name' => 'objects',
                'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Добавить объект',
                'sub_fields' => array(
                    $text( 'field_obj_num', 'Номер', 'number' ),
                    $text( 'field_obj_title', 'Название', 'title' ),
                    $textarea( 'field_obj_text', 'Описание', 'text' ),
                ),
            ),

            /* ---------- КОНТАКТНЫЙ БЛОК ---------- */
            $tab( 'tab_contact_block', 'Блок «Свяжитесь»' ),
            $text( 'field_contacts_title', 'Заголовок', 'contacts_title', 'Свяжитесь с нами' ),
            $textarea( 'field_contacts_text', 'Текст', 'contacts_text', 'Готовы проконсультировать по вашему объекту и подобрать оптимальное решение.' ),
            $text( 'field_contacts_btn', 'Текст кнопки', 'contacts_btn', 'Получить консультацию' ),
        ),
        'location' => array(
            array(
                array( 'param' => 'options_page', 'operator' => '==', 'value' => 'rezka-content' ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'active' => true,
    ) );
}
