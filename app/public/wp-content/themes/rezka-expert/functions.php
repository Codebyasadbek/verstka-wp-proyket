<?php
/**
 * Rezka Expert — functions.php
 * Тема ООО «Эксперт канатной резки»
 */

if ( ! defined( 'ABSPATH' ) ) exit; // прямой доступ запрещён

/* ------------------------------------------------------------------
 * 1. Поддержка возможностей темы
 * ------------------------------------------------------------------ */
function rezka_theme_setup() {
    add_theme_support( 'title-tag' );          // <title> генерирует WP/SEO-плагин
    add_theme_support( 'post-thumbnails' );    // изображения записей
    add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'automatic-feed-links' );
}
add_action( 'after_setup_theme', 'rezka_theme_setup' );

/* ------------------------------------------------------------------
 * 2. Подключение стилей и скриптов
 * ------------------------------------------------------------------ */
function rezka_enqueue_assets() {
    $uri = get_template_directory_uri();
    $ver = '1.0.0';

    // Шрифты — локальные (self-hosted), не зависят от Google (важно для РФ)
    wp_enqueue_style( 'rezka-fonts', $uri . '/assets/fonts/fonts.css', array(), $ver );

    // Основные стили
    wp_enqueue_style( 'rezka-style', $uri . '/assets/css/style.css', array(), $ver );

    // Скрипт (в футере)
    wp_enqueue_script( 'rezka-main', $uri . '/assets/js/main.js', array(), $ver, true );
}
add_action( 'wp_enqueue_scripts', 'rezka_enqueue_assets' );

/* ------------------------------------------------------------------
 * 3. Хелпер: URL иконки/картинки из папки темы
 * ------------------------------------------------------------------ */
function rezka_asset( $path ) {
    return get_template_directory_uri() . '/assets/' . ltrim( $path, '/' );
}

/**
 * Хелпер вывода изображения ACF (возвращаем URL) с запасным значением.
 * $value — то, что вернул get_field/get_sub_field (URL, т.к. Return Format = URL)
 * $fallback — путь внутри assets/ на случай пустого поля.
 */
function rezka_img( $value, $fallback = '' ) {
    if ( ! empty( $value ) ) return esc_url( $value );
    return esc_url( rezka_asset( $fallback ) );
}

/**
 * ID страницы «Контент сайта», где хранятся все поля ACF.
 * Страница создаётся автоматически (см. ниже). Работает в бесплатной версии ACF.
 */
function rezka_content_id() {
    static $id = null;
    if ( $id !== null ) return $id;
    $page = get_page_by_path( 'rezka-content', OBJECT, 'page' );
    $id = $page ? (int) $page->ID : 0;
    return $id;
}

/**
 * Безопасное получение поля ACF с запасным значением.
 * По умолчанию читаем со страницы «Контент сайта».
 */
function rezka_field( $name, $fallback = '', $post_id = null ) {
    if ( $post_id === null ) $post_id = rezka_content_id();
    if ( $post_id && function_exists( 'get_field' ) ) {
        $v = get_field( $name, $post_id );
        if ( $v !== null && $v !== '' && $v !== false ) return $v;
    }
    return $fallback;
}

/**
 * Автоматически создаём страницу «Контент сайта» для полей ACF (один раз).
 */
function rezka_ensure_content_page() {
    if ( get_option( 'rezka_content_page_ready' ) ) return;
    $page = get_page_by_path( 'rezka-content', OBJECT, 'page' );
    if ( ! $page ) {
        wp_insert_post( array(
            'post_title'   => 'Контент сайта',
            'post_name'    => 'rezka-content',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => 'Служебная страница для редактирования содержимого главной. Не удалять.',
        ) );
    }
    update_option( 'rezka_content_page_ready', 1 );
}
add_action( 'after_setup_theme', 'rezka_ensure_content_page' );

/* ------------------------------------------------------------------
 * 4. ACF: регистрация полей и страницы настроек (в коде — импорт не нужен)
 * ------------------------------------------------------------------ */
require get_template_directory() . '/inc/acf-fields.php';

/* ------------------------------------------------------------------
 * 5. Если ACF не установлен — мягкое предупреждение в админке
 * ------------------------------------------------------------------ */
function rezka_acf_notice() {
    if ( ! class_exists( 'ACF' ) ) {
        echo '<div class="notice notice-warning"><p><strong>Rezka Expert:</strong> установите и активируйте плагин <em>Advanced Custom Fields</em>, чтобы редактировать содержимое сайта. Пока сайт показывает содержимое по умолчанию.</p></div>';
    }
}
add_action( 'admin_notices', 'rezka_acf_notice' );

/* ------------------------------------------------------------------
 * 6. Разрешаем загрузку SVG в медиатеку (иконки)
 * ------------------------------------------------------------------ */
function rezka_allow_svg( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'rezka_allow_svg' );
