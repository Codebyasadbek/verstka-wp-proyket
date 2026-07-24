<?php
/**
 * Разовое наполнение полей ACF содержимым по умолчанию.
 * Импортирует изображения темы в Медиатеку и заполняет поля страницы
 * «Контент сайта» — чтобы всё содержимое было видно и редактируемо в админке
 * (галерея, технологии, преимущества, объекты — с кнопками
 * редактировать/удалить/добавить/перетащить).
 *
 * ВАЖНО: используем КЛЮЧИ полей ACF (field_...), т.к. для страницы,
 * где значения ещё не сохранялись, обновление по имени не работает.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_init', 'rezka_seed_content_once', 20 );
function rezka_seed_content_once() {

    if ( get_option( 'rezka_content_seeded_v2' ) ) return;   // уже наполнено
    if ( ! function_exists( 'update_field' ) ) return;        // ACF не готов
    $pid = rezka_content_id();
    if ( ! $pid ) return;

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

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
        if ( is_wp_error( $id ) ) return $cache[ $rel ] = 0;
        @wp_update_attachment_metadata( $id, @wp_generate_attachment_metadata( $id, $upload['file'] ) );
        return $cache[ $rel ] = (int) $id;
    };

    /* ---------- Простые текстовые поля (ключ => значение) ---------- */
    $scalars = array(
        'field_phone' => '8 (981) 723-89-79', 'field_phone_raw' => '+79817238979',
        'field_wa' => '79500031953', 'field_wa_label' => '+7 950 003-19-53',
        'field_tg' => '+79500031953', 'field_tg_label' => '+7 950 003-19-53',
        'field_email' => 's7238979@mail.ru',
        'field_address' => 'Россия, ЛО, М.Р-Н Волосовский, С.П. Бегуницкое, д. Бегуницы, д. 74, часть помещ. 9',
        'field_hero_region' => 'Работаем по всей России',
        'field_hero_title1' => 'ТОЧНОСТЬ.', 'field_hero_title2' => 'БЕЗ УДАРА.',
        'field_hero_subtitle' => 'Демонтажные работы методом канатной резки любой сложности.',
        'field_hero_btn1' => 'Связаться с нами', 'field_hero_btn2' => 'Смотреть виды работ',
        'field_services_title' => 'Виды работ и сфера применения канатной резки',
        'field_services_text' => 'Канатная резка позволяет выполнять работы любой сложности с максимальной точностью и минимальным воздействием на конструкции.',
        'field_adv_title' => 'Наши преимущества',
        'field_tech_title' => 'Технологии',
        'field_gallery_title' => 'Фото процесса работы',
        'field_objects_title' => 'Мы принимали участие на объектах',
        'field_objects_badge' => 'Работаем на объектах по всей России',
        'field_contacts_title' => 'Свяжитесь с нами',
        'field_contacts_text' => 'Готовы проконсультировать по вашему объекту и подобрать оптимальное решение.',
        'field_contacts_btn' => 'Получить консультацию',
    );
    foreach ( $scalars as $key => $v ) update_field( $key, $v, $pid );

    /* ---------- Одиночные изображения ---------- */
    update_field( 'field_hero_image', $import( 'img/hero-machine.jpg' ), $pid );
    update_field( 'field_services_scheme', $import( 'icons/decor-industrial-object-scheme.svg' ), $pid );
    update_field( 'field_objects_map', $import( 'icons/decor-russia-map.svg' ), $pid );

    /* ---------- Первый экран: преимущества ---------- */
    update_field( 'field_hero_features', array(
        array( 'field_hf_icon' => $import('icons-dark/hero-no-impact.svg'),   'field_hf_text' => 'Без ударного воздействия на конструкции' ),
        array( 'field_hf_icon' => $import('icons-dark/hero-precision.svg'),   'field_hf_text' => 'Точная резка любой сложности' ),
        array( 'field_hf_icon' => $import('icons-dark/hero-hard-access.svg'), 'field_hf_text' => 'Работа в труднодоступных местах и под водой' ),
        array( 'field_hf_icon' => $import('icons-dark/hero-equipment.svg'),   'field_hf_text' => 'Современное профессиональное оборудование' ),
    ), $pid );

    /* ---------- Цифры ---------- */
    update_field( 'field_stats', array(
        array( 'field_stat_icon' => $import('icons-dark/stat-experience-20.svg'),    'field_stat_num' => '20+ лет',       'field_stat_label' => 'опыта работы' ),
        array( 'field_stat_icon' => $import('icons-dark/stat-volume-cube.svg'),      'field_stat_num' => '1000+ м³',      'field_stat_label' => 'демонтировано железобетона' ),
        array( 'field_stat_icon' => $import('icons-dark/stat-projects-factory.svg'), 'field_stat_num' => '500+ объектов', 'field_stat_label' => 'промышленного масштаба' ),
        array( 'field_stat_icon' => $import('icons-dark/stat-russia-pin.svg'),       'field_stat_num' => 'Работаем',      'field_stat_label' => 'по всей России' ),
    ), $pid );

    /* ---------- Виды работ ---------- */
    update_field( 'field_services_left', array(
        array( 'field_sl_icon' => $import('icons/service-concrete-blocks.svg'),   'field_sl_text' => 'Канатная резка бетона, железобетона, кирпича, камня и других материалов.' ),
        array( 'field_sl_icon' => $import('icons/service-bridge.svg'),            'field_sl_text' => 'Канатная резка мостовых сооружений, причалов.' ),
        array( 'field_sl_icon' => $import('icons/service-industrial-factory.svg'),'field_sl_text' => 'Канатная резка промышленных сооружений на ТЭЦ, АЭС, ГЭС, ЦБК, заводах.' ),
        array( 'field_sl_icon' => $import('icons/service-complex-target.svg'),    'field_sl_text' => 'Канатная резка объектов повышенной сложности.' ),
    ), $pid );
    update_field( 'field_services_right', array(
        array( 'field_sr_icon' => $import('icons/service-building.svg'),  'field_sr_text' => 'Канатная резка нежилых зданий.' ),
        array( 'field_sr_icon' => $import('icons/service-demolition.svg'),'field_sr_text' => 'Частичный демонтаж зданий.' ),
        array( 'field_sr_icon' => $import('icons/service-opening.svg'),   'field_sr_text' => 'Канатная резка проемов.' ),
        array( 'field_sr_icon' => $import('icons/service-drilling.svg'),  'field_sr_text' => 'Бурение проемов под вентиляцию.' ),
    ), $pid );

    /* ---------- Преимущества ---------- */
    update_field( 'field_advantages', array(
        array( 'field_adv_icon' => $import('icons-dark/adv-shield-experience.svg'), 'field_adv_text' => 'Опыт работы более 20 лет.' ),
        array( 'field_adv_icon' => $import('icons-dark/adv-equipment.svg'),         'field_adv_text' => 'Профессиональное оборудование.' ),
        array( 'field_adv_icon' => $import('icons-dark/adv-independence.svg'),      'field_adv_text' => 'Технологическая и техническая независимость.' ),
        array( 'field_adv_icon' => $import('icons-dark/adv-specialists.svg'),       'field_adv_text' => 'Специалисты высокого уровня подготовки.' ),
        array( 'field_adv_icon' => $import('icons-dark/adv-personal.svg'),          'field_adv_text' => 'Индивидуальный подход к каждому заказчику.' ),
        array( 'field_adv_icon' => $import('icons-dark/adv-complexity.svg'),        'field_adv_text' => 'Выполнение работы любой сложности.' ),
        array( 'field_adv_icon' => $import('icons-dark/adv-fast.svg'),              'field_adv_text' => 'Работу выполняем за максимально быстрые сроки.' ),
        array( 'field_adv_icon' => $import('icons-dark/adv-site-visit.svg'),        'field_adv_text' => 'Оперативно выезжаем на объект.' ),
        array( 'field_adv_icon' => $import('icons-dark/adv-speed.svg'),             'field_adv_text' => 'Скорость канатной резки значительно выше по сравнению с другими видами резки.' ),
        array( 'field_adv_icon' => $import('icons-dark/adv-no-impact.svg'),         'field_adv_text' => 'При резке канатом исключается ударное воздействие на несущие конструкции здания.' ),
        array( 'field_adv_icon' => $import('icons-dark/adv-hard-access.svg'),       'field_adv_text' => 'Канатная резка возможна в труднодоступных местах.' ),
        array( 'field_adv_icon' => $import('icons-dark/adv-underwater.svg'),        'field_adv_text' => 'Возможно выполнение резки канатом даже под водой.' ),
        array( 'field_adv_icon' => $import('icons-dark/adv-no-overcuts.svg'),       'field_adv_text' => 'При резке проемов канатом исключены перепилы.' ),
    ), $pid );

    /* ---------- Технологии ---------- */
    update_field( 'field_tech', array(
        array( 'field_tech_num' => '01', 'field_tech_name' => 'Резка алмазным канатом.',           'field_tech_img' => $import('img/tech-wire.jpg') ),
        array( 'field_tech_num' => '02', 'field_tech_name' => 'Резка алмазным диском.',            'field_tech_img' => $import('img/tech-disk.jpg') ),
        array( 'field_tech_num' => '03', 'field_tech_name' => 'Подводная резка алмазным канатом.', 'field_tech_img' => $import('img/tech-underwater.jpg') ),
        array( 'field_tech_num' => '04', 'field_tech_name' => 'Бурение алмазной коронкой.',        'field_tech_img' => $import('img/tech-drilling.jpg') ),
    ), $pid );

    /* ---------- Галерея ---------- */
    $gallery = array();
    for ( $i = 1; $i <= 8; $i++ ) {
        $gallery[] = array(
            'field_gallery_img' => $import( 'img/gallery-' . sprintf( '%02d', $i ) . '.jpg' ),
            'field_gallery_alt' => 'Фото процесса работы по канатной резке',
        );
    }
    update_field( 'field_gallery', $gallery, $pid );

    /* ---------- Объекты ---------- */
    $objects_data = array(
        array('01','ПАО «Сокольский ЦБК»','Реконструкция здания, выработано 10 м³ железобетона.'),
        array('02','НПАО «Светогорский ЦБК»','Реконструкция здания, выработано 15 м³ железобетона.'),
        array('03','АО «Каменская БКФ»','Демонтаж, выработано 10 м³ железобетона.'),
        array('04','ОАО «Маяк»','Демонтажные работы, объём 24 м³ железобетона.'),
        array('05','ОАО «Северсталь»','Реконструкция здания, выработано 40 м³ железобетона.'),
        array('06','Нововоронежская АЭС-2','Выработано 200 м³ железобетона, демонтаж фундамента.'),
        array('07','Кольская АЭС','Реконструкция, выработано 30 м³, демонтаж стен.'),
        array('08','ПАО «Звезда»','Реконструкция кирпичного здания, выработано 50 м³, частичный демонтаж стены.'),
        array('09','Морской порт Санкт-Петербург, ЗАО «Контейнерный терминал Санкт-Петербург»','Демонтировано 3 причала.'),
        array('10','ПАО «Т Плюс», Новокуйбышевская ТЭЦ-1','Демонтаж фундаментов турбин методом канатной резки.'),
        array('11','АО «Невский завод»','Демонтировано 400 м³ железобетона.'),
        array('12','АО «Волга», г. Балахна','Демонтаж фундамента.'),
        array('13','Корпорация развития строительства и инфраструктурных проектов Ульяновской области «Дом.73»','Частичный демонтаж повреждённых жилых зданий в г. Мариуполь. Здание 9 этажей разрезано за один заход каната.'),
        array('14','ОАО «Проектный институт №1»','Частичный демонтаж кирпичных сооружений, общий объём выработки 1000 м³.'),
    );
    $objects = array();
    foreach ( $objects_data as $o ) {
        $objects[] = array( 'field_obj_num' => $o[0], 'field_obj_title' => $o[1], 'field_obj_text' => $o[2] );
    }
    update_field( 'field_objects', $objects, $pid );

    update_option( 'rezka_content_seeded_v2', 1 );
}
