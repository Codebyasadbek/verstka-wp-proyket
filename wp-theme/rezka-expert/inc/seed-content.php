<?php
/**
 * Разовое наполнение полей ACF содержимым по умолчанию.
 * Импортирует изображения темы в Медиатеку и заполняет поля страницы
 * «Контент сайта», чтобы всё содержимое было видно и редактируемо в админке
 * (галерея, технологии, преимущества, объекты и т.д. — с кнопками
 * редактировать/удалить/добавить/перетащить).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_init', 'rezka_seed_content_once', 20 );
function rezka_seed_content_once() {

    if ( get_option( 'rezka_content_seeded' ) ) return;      // уже наполнено
    if ( ! function_exists( 'update_field' ) ) return;        // ACF ещё не готов
    $pid = rezka_content_id();
    if ( ! $pid ) return;                                     // страница ещё не создана

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    // Импорт файла темы в Медиатеку → ID вложения (с кэшем повторов)
    $cache = array();
    $import = function( $rel ) use ( &$cache, $pid ) {
        if ( array_key_exists( $rel, $cache ) ) return $cache[ $rel ];
        $path = get_template_directory() . '/assets/' . $rel;
        if ( ! file_exists( $path ) ) return $cache[ $rel ] = 0;
        $upload = wp_upload_bits( basename( $path ), null, file_get_contents( $path ) );
        if ( ! empty( $upload['error'] ) ) return $cache[ $rel ] = 0;
        $ft = wp_check_filetype( $upload['file'] );
        $id = wp_insert_attachment( array(
            'post_mime_type' => $ft['type'] ? $ft['type'] : 'image/svg+xml',
            'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $path ) ),
            'post_status'    => 'inherit',
        ), $upload['file'], $pid );
        if ( ! is_wp_error( $id ) ) {
            @wp_update_attachment_metadata( $id, @wp_generate_attachment_metadata( $id, $upload['file'] ) );
            return $cache[ $rel ] = (int) $id;
        }
        return $cache[ $rel ] = 0;
    };

    /* ---------- Простые текстовые поля ---------- */
    $scalars = array(
        'phone' => '8 (981) 723-89-79', 'phone_raw' => '+79817238979',
        'whatsapp' => '79500031953', 'whatsapp_label' => '+7 950 003-19-53',
        'telegram' => '+79500031953', 'telegram_label' => '+7 950 003-19-53',
        'email' => 's7238979@mail.ru',
        'address' => 'Россия, ЛО, М.Р-Н Волосовский, С.П. Бегуницкое, д. Бегуницы, д. 74, часть помещ. 9',
        'hero_region' => 'Работаем по всей России',
        'hero_title1' => 'ТОЧНОСТЬ.', 'hero_title2' => 'БЕЗ УДАРА.',
        'hero_subtitle' => 'Демонтажные работы методом канатной резки любой сложности.',
        'hero_btn1' => 'Связаться с нами', 'hero_btn2' => 'Смотреть виды работ',
        'services_title' => 'Виды работ и сфера применения канатной резки',
        'services_text' => 'Канатная резка позволяет выполнять работы любой сложности с максимальной точностью и минимальным воздействием на конструкции.',
        'advantages_title' => 'Наши преимущества',
        'tech_title' => 'Технологии',
        'gallery_title' => 'Фото процесса работы',
        'objects_title' => 'Мы принимали участие на объектах',
        'objects_badge' => 'Работаем на объектах по всей России',
        'contacts_title' => 'Свяжитесь с нами',
        'contacts_text' => 'Готовы проконсультировать по вашему объекту и подобрать оптимальное решение.',
        'contacts_btn' => 'Получить консультацию',
    );
    foreach ( $scalars as $k => $v ) update_field( $k, $v, $pid );

    /* ---------- Одиночные изображения ---------- */
    update_field( 'hero_image', $import( 'img/hero-machine.jpg' ), $pid );
    update_field( 'services_scheme', $import( 'icons/decor-industrial-object-scheme.svg' ), $pid );
    update_field( 'objects_map', $import( 'icons/decor-russia-map.svg' ), $pid );

    /* ---------- Первый экран: преимущества ---------- */
    update_field( 'hero_features', array(
        array( 'icon' => $import('icons-dark/hero-no-impact.svg'),   'text' => 'Без ударного воздействия на конструкции' ),
        array( 'icon' => $import('icons-dark/hero-precision.svg'),   'text' => 'Точная резка любой сложности' ),
        array( 'icon' => $import('icons-dark/hero-hard-access.svg'), 'text' => 'Работа в труднодоступных местах и под водой' ),
        array( 'icon' => $import('icons-dark/hero-equipment.svg'),   'text' => 'Современное профессиональное оборудование' ),
    ), $pid );

    /* ---------- Цифры ---------- */
    update_field( 'stats', array(
        array( 'icon' => $import('icons-dark/stat-experience-20.svg'),   'number' => '20+ лет',       'label' => 'опыта работы' ),
        array( 'icon' => $import('icons-dark/stat-volume-cube.svg'),     'number' => '1000+ м³',      'label' => 'демонтировано железобетона' ),
        array( 'icon' => $import('icons-dark/stat-projects-factory.svg'),'number' => '500+ объектов', 'label' => 'промышленного масштаба' ),
        array( 'icon' => $import('icons-dark/stat-russia-pin.svg'),      'number' => 'Работаем',      'label' => 'по всей России' ),
    ), $pid );

    /* ---------- Виды работ ---------- */
    update_field( 'services_left', array(
        array( 'icon' => $import('icons/service-concrete-blocks.svg'),   'text' => 'Канатная резка бетона, железобетона, кирпича, камня и других материалов.' ),
        array( 'icon' => $import('icons/service-bridge.svg'),            'text' => 'Канатная резка мостовых сооружений, причалов.' ),
        array( 'icon' => $import('icons/service-industrial-factory.svg'),'text' => 'Канатная резка промышленных сооружений на ТЭЦ, АЭС, ГЭС, ЦБК, заводах.' ),
        array( 'icon' => $import('icons/service-complex-target.svg'),    'text' => 'Канатная резка объектов повышенной сложности.' ),
    ), $pid );
    update_field( 'services_right', array(
        array( 'icon' => $import('icons/service-building.svg'),  'text' => 'Канатная резка нежилых зданий.' ),
        array( 'icon' => $import('icons/service-demolition.svg'),'text' => 'Частичный демонтаж зданий.' ),
        array( 'icon' => $import('icons/service-opening.svg'),   'text' => 'Канатная резка проемов.' ),
        array( 'icon' => $import('icons/service-drilling.svg'),  'text' => 'Бурение проемов под вентиляцию.' ),
    ), $pid );

    /* ---------- Преимущества ---------- */
    update_field( 'advantages', array(
        array( 'icon' => $import('icons-dark/adv-shield-experience.svg'), 'text' => 'Опыт работы более 20 лет.' ),
        array( 'icon' => $import('icons-dark/adv-equipment.svg'),         'text' => 'Профессиональное оборудование.' ),
        array( 'icon' => $import('icons-dark/adv-independence.svg'),      'text' => 'Технологическая и техническая независимость.' ),
        array( 'icon' => $import('icons-dark/adv-specialists.svg'),       'text' => 'Специалисты высокого уровня подготовки.' ),
        array( 'icon' => $import('icons-dark/adv-personal.svg'),          'text' => 'Индивидуальный подход к каждому заказчику.' ),
        array( 'icon' => $import('icons-dark/adv-complexity.svg'),        'text' => 'Выполнение работы любой сложности.' ),
        array( 'icon' => $import('icons-dark/adv-fast.svg'),              'text' => 'Работу выполняем за максимально быстрые сроки.' ),
        array( 'icon' => $import('icons-dark/adv-site-visit.svg'),        'text' => 'Оперативно выезжаем на объект.' ),
        array( 'icon' => $import('icons-dark/adv-speed.svg'),             'text' => 'Скорость канатной резки значительно выше по сравнению с другими видами резки.' ),
        array( 'icon' => $import('icons-dark/adv-no-impact.svg'),         'text' => 'При резке канатом исключается ударное воздействие на несущие конструкции здания.' ),
        array( 'icon' => $import('icons-dark/adv-hard-access.svg'),       'text' => 'Канатная резка возможна в труднодоступных местах.' ),
        array( 'icon' => $import('icons-dark/adv-underwater.svg'),        'text' => 'Возможно выполнение резки канатом даже под водой.' ),
        array( 'icon' => $import('icons-dark/adv-no-overcuts.svg'),       'text' => 'При резке проемов канатом исключены перепилы.' ),
    ), $pid );

    /* ---------- Технологии ---------- */
    update_field( 'tech', array(
        array( 'number' => '01', 'title' => 'Резка алмазным канатом.',            'image' => $import('img/tech-wire.jpg') ),
        array( 'number' => '02', 'title' => 'Резка алмазным диском.',             'image' => $import('img/tech-disk.jpg') ),
        array( 'number' => '03', 'title' => 'Подводная резка алмазным канатом.',  'image' => $import('img/tech-underwater.jpg') ),
        array( 'number' => '04', 'title' => 'Бурение алмазной коронкой.',         'image' => $import('img/tech-drilling.jpg') ),
    ), $pid );

    /* ---------- Галерея ---------- */
    $gallery = array();
    for ( $i = 1; $i <= 8; $i++ ) {
        $gallery[] = array(
            'image' => $import( 'img/gallery-' . sprintf( '%02d', $i ) . '.jpg' ),
            'alt'   => 'Фото процесса работы по канатной резке',
        );
    }
    update_field( 'gallery', $gallery, $pid );

    /* ---------- Объекты ---------- */
    update_field( 'objects', array(
        array( 'number'=>'01','title'=>'ПАО «Сокольский ЦБК»','text'=>'Реконструкция здания, выработано 10 м³ железобетона.' ),
        array( 'number'=>'02','title'=>'НПАО «Светогорский ЦБК»','text'=>'Реконструкция здания, выработано 15 м³ железобетона.' ),
        array( 'number'=>'03','title'=>'АО «Каменская БКФ»','text'=>'Демонтаж, выработано 10 м³ железобетона.' ),
        array( 'number'=>'04','title'=>'ОАО «Маяк»','text'=>'Демонтажные работы, объём 24 м³ железобетона.' ),
        array( 'number'=>'05','title'=>'ОАО «Северсталь»','text'=>'Реконструкция здания, выработано 40 м³ железобетона.' ),
        array( 'number'=>'06','title'=>'Нововоронежская АЭС-2','text'=>'Выработано 200 м³ железобетона, демонтаж фундамента.' ),
        array( 'number'=>'07','title'=>'Кольская АЭС','text'=>'Реконструкция, выработано 30 м³, демонтаж стен.' ),
        array( 'number'=>'08','title'=>'ПАО «Звезда»','text'=>'Реконструкция кирпичного здания, выработано 50 м³, частичный демонтаж стены.' ),
        array( 'number'=>'09','title'=>'Морской порт Санкт-Петербург, ЗАО «Контейнерный терминал Санкт-Петербург»','text'=>'Демонтировано 3 причала.' ),
        array( 'number'=>'10','title'=>'ПАО «Т Плюс», Новокуйбышевская ТЭЦ-1','text'=>'Демонтаж фундаментов турбин методом канатной резки.' ),
        array( 'number'=>'11','title'=>'АО «Невский завод»','text'=>'Демонтировано 400 м³ железобетона.' ),
        array( 'number'=>'12','title'=>'АО «Волга», г. Балахна','text'=>'Демонтаж фундамента.' ),
        array( 'number'=>'13','title'=>'Корпорация развития строительства и инфраструктурных проектов Ульяновской области «Дом.73»','text'=>'Частичный демонтаж повреждённых жилых зданий в г. Мариуполь. Здание 9 этажей разрезано за один заход каната.' ),
        array( 'number'=>'14','title'=>'ОАО «Проектный институт №1»','text'=>'Частичный демонтаж кирпичных сооружений, общий объём выработки 1000 м³.' ),
    ), $pid );

    update_option( 'rezka_content_seeded', 1 );
}
