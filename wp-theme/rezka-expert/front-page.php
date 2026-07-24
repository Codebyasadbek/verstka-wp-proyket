<?php
/**
 * front-page.php — главная страница.
 * Каждый блок берёт данные из ACF (страница «Контент сайта»).
 * Если поле пустое или ACF выключен — показывается содержимое по умолчанию.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

/* ---- значения по умолчанию (если ACF ещё не заполнен) ---- */
$def_hero_features = array(
    array( 'icon' => rezka_asset('icons-dark/hero-no-impact.svg'),  'text' => 'Без ударного воздействия на конструкции' ),
    array( 'icon' => rezka_asset('icons-dark/hero-precision.svg'),  'text' => 'Точная резка любой сложности' ),
    array( 'icon' => rezka_asset('icons-dark/hero-hard-access.svg'),'text' => 'Работа в труднодоступных местах и под водой' ),
    array( 'icon' => rezka_asset('icons-dark/hero-equipment.svg'),  'text' => 'Современное профессиональное оборудование' ),
);
$def_stats = array(
    array( 'icon' => rezka_asset('icons-dark/stat-experience-20.svg'),  'number' => '20+ лет',      'label' => 'опыта работы' ),
    array( 'icon' => rezka_asset('icons-dark/stat-volume-cube.svg'),    'number' => '1000+ м³',     'label' => 'демонтировано железобетона' ),
    array( 'icon' => rezka_asset('icons-dark/stat-projects-factory.svg'),'number' => '500+ объектов','label' => 'промышленного масштаба' ),
    array( 'icon' => rezka_asset('icons-dark/stat-russia-pin.svg'),     'number' => 'Работаем',     'label' => 'по всей России' ),
);
$def_services_left = array(
    array( 'icon' => rezka_asset('icons/service-concrete-blocks.svg'),   'text' => 'Канатная резка бетона, железобетона, кирпича, камня и других материалов.' ),
    array( 'icon' => rezka_asset('icons/service-bridge.svg'),            'text' => 'Канатная резка мостовых сооружений, причалов.' ),
    array( 'icon' => rezka_asset('icons/service-industrial-factory.svg'),'text' => 'Канатная резка промышленных сооружений на ТЭЦ, АЭС, ГЭС, ЦБК, заводах.' ),
    array( 'icon' => rezka_asset('icons/service-complex-target.svg'),    'text' => 'Канатная резка объектов повышенной сложности.' ),
);
$def_services_right = array(
    array( 'icon' => rezka_asset('icons/service-building.svg'),  'text' => 'Канатная резка нежилых зданий.' ),
    array( 'icon' => rezka_asset('icons/service-demolition.svg'),'text' => 'Частичный демонтаж зданий.' ),
    array( 'icon' => rezka_asset('icons/service-opening.svg'),   'text' => 'Канатная резка проемов.' ),
    array( 'icon' => rezka_asset('icons/service-drilling.svg'),  'text' => 'Бурение проемов под вентиляцию.' ),
);
$def_adv = array(
    array('icon'=>rezka_asset('icons-dark/adv-shield-experience.svg'),'text'=>'Опыт работы более 20 лет.'),
    array('icon'=>rezka_asset('icons-dark/adv-equipment.svg'),'text'=>'Профессиональное оборудование.'),
    array('icon'=>rezka_asset('icons-dark/adv-independence.svg'),'text'=>'Технологическая и техническая независимость.'),
    array('icon'=>rezka_asset('icons-dark/adv-specialists.svg'),'text'=>'Специалисты высокого уровня подготовки.'),
    array('icon'=>rezka_asset('icons-dark/adv-personal.svg'),'text'=>'Индивидуальный подход к каждому заказчику.'),
    array('icon'=>rezka_asset('icons-dark/adv-complexity.svg'),'text'=>'Выполнение работы любой сложности.'),
    array('icon'=>rezka_asset('icons-dark/adv-fast.svg'),'text'=>'Работу выполняем за максимально быстрые сроки.'),
    array('icon'=>rezka_asset('icons-dark/adv-site-visit.svg'),'text'=>'Оперативно выезжаем на объект.'),
    array('icon'=>rezka_asset('icons-dark/adv-speed.svg'),'text'=>'Скорость канатной резки значительно выше по сравнению с другими видами резки.'),
    array('icon'=>rezka_asset('icons-dark/adv-no-impact.svg'),'text'=>'При резке канатом исключается ударное воздействие на несущие конструкции здания.'),
    array('icon'=>rezka_asset('icons-dark/adv-hard-access.svg'),'text'=>'Канатная резка возможна в труднодоступных местах.'),
    array('icon'=>rezka_asset('icons-dark/adv-underwater.svg'),'text'=>'Возможно выполнение резки канатом даже под водой.'),
    array('icon'=>rezka_asset('icons-dark/adv-no-overcuts.svg'),'text'=>'При резке проемов канатом исключены перепилы.'),
);
$def_tech = array(
    array('number'=>'01','title'=>'Резка алмазным канатом.','image'=>rezka_asset('img/tech-wire.jpg')),
    array('number'=>'02','title'=>'Резка алмазным диском.','image'=>rezka_asset('img/tech-disk.jpg')),
    array('number'=>'03','title'=>'Подводная резка алмазным канатом.','image'=>rezka_asset('img/tech-underwater.jpg')),
    array('number'=>'04','title'=>'Бурение алмазной коронкой.','image'=>rezka_asset('img/tech-drilling.jpg')),
);
$def_gallery = array();
for ( $i = 1; $i <= 8; $i++ ) {
    $def_gallery[] = array( 'image' => rezka_asset( 'img/gallery-' . sprintf('%02d',$i) . '.jpg' ), 'alt' => 'Фото процесса работы по канатной резке' );
}
$def_objects = array(
    array('number'=>'01','title'=>'ПАО «Сокольский ЦБК»','text'=>'Реконструкция здания, выработано 10 м³ железобетона.'),
    array('number'=>'02','title'=>'НПАО «Светогорский ЦБК»','text'=>'Реконструкция здания, выработано 15 м³ железобетона.'),
    array('number'=>'03','title'=>'АО «Каменская БКФ»','text'=>'Демонтаж, выработано 10 м³ железобетона.'),
    array('number'=>'04','title'=>'ОАО «Маяк»','text'=>'Демонтажные работы, объём 24 м³ железобетона.'),
    array('number'=>'05','title'=>'ОАО «Северсталь»','text'=>'Реконструкция здания, выработано 40 м³ железобетона.'),
    array('number'=>'06','title'=>'Нововоронежская АЭС-2','text'=>'Выработано 200 м³ железобетона, демонтаж фундамента.'),
    array('number'=>'07','title'=>'Кольская АЭС','text'=>'Реконструкция, выработано 30 м³, демонтаж стен.'),
    array('number'=>'08','title'=>'ПАО «Звезда»','text'=>'Реконструкция кирпичного здания, выработано 50 м³, частичный демонтаж стены.'),
    array('number'=>'09','title'=>'Морской порт Санкт-Петербург, ЗАО «Контейнерный терминал Санкт-Петербург»','text'=>'Демонтировано 3 причала.'),
    array('number'=>'10','title'=>'ПАО «Т Плюс», Новокуйбышевская ТЭЦ-1','text'=>'Демонтаж фундаментов турбин методом канатной резки.'),
    array('number'=>'11','title'=>'АО «Невский завод»','text'=>'Демонтировано 400 м³ железобетона.'),
    array('number'=>'12','title'=>'АО «Волга», г. Балахна','text'=>'Демонтаж фундамента.'),
    array('number'=>'13','title'=>'Корпорация развития строительства и инфраструктурных проектов Ульяновской области «Дом.73»','text'=>'Частичный демонтаж повреждённых жилых зданий в г. Мариуполь. Здание 9 этажей разрезано за один заход каната.'),
    array('number'=>'14','title'=>'ОАО «Проектный институт №1»','text'=>'Частичный демонтаж кирпичных сооружений, общий объём выработки 1000 м³.'),
);

/* ---- helper: вернуть строки ACF-репитера как массив, иначе — defaults ---- */
function rezka_get_rows( $field, $defaults, $keys ) {
    $out = array();
    $pid = rezka_content_id();
    if ( $pid && function_exists('have_rows') && have_rows( $field, $pid ) ) {
        while ( have_rows( $field, $pid ) ) { the_row();
            $row = array();
            foreach ( $keys as $k ) $row[$k] = get_sub_field( $k );
            $out[] = $row;
        }
    }
    return empty( $out ) ? $defaults : $out;
}

$hero_features = rezka_get_rows( 'hero_features', $def_hero_features, array('icon','text') );
$stats         = rezka_get_rows( 'stats', $def_stats, array('icon','number','label') );
$services_left = rezka_get_rows( 'services_left', $def_services_left, array('icon','text') );
$services_right= rezka_get_rows( 'services_right', $def_services_right, array('icon','text') );
$advantages    = rezka_get_rows( 'advantages', $def_adv, array('icon','text') );
$tech          = rezka_get_rows( 'tech', $def_tech, array('number','title','image') );
$gallery       = rezka_get_rows( 'gallery', $def_gallery, array('image','alt') );
$objects       = rezka_get_rows( 'objects', $def_objects, array('number','title','text') );

$hero_image = rezka_field( 'hero_image', rezka_asset('img/hero-machine.jpg') );
$scheme_img = rezka_field( 'services_scheme', rezka_asset('icons/decor-industrial-object-scheme.svg') );
$map_img    = rezka_field( 'objects_map', rezka_asset('icons/decor-russia-map.svg') );
?>

<main>

<!-- ==================== ПЕРВЫЙ ЭКРАН ==================== -->
<section class="hero" id="hero">
    <div class="hero__panel" aria-hidden="true"></div>
    <img src="<?php echo rezka_asset('icons/decor-technical-lines.svg'); ?>" alt="" class="hero__decor hero__decor--lines" aria-hidden="true">
    <div class="container hero__inner">
        <div class="hero__content">
            <p class="hero__region">
                <img src="<?php echo rezka_asset('icons/stat-russia-pin.svg'); ?>" alt="" width="22" height="22" aria-hidden="true">
                <?php echo esc_html( rezka_field('hero_region','Работаем по всей России') ); ?>
            </p>
            <h1 class="hero__title">
                <span class="hero__title-dark"><?php echo esc_html( rezka_field('hero_title1','ТОЧНОСТЬ.') ); ?></span>
                <span class="hero__title-accent"><?php echo esc_html( rezka_field('hero_title2','БЕЗ УДАРА.') ); ?></span>
            </h1>
            <p class="hero__subtitle"><?php echo esc_html( rezka_field('hero_subtitle','Демонтажные работы методом канатной резки любой сложности.') ); ?></p>
            <div class="hero__buttons">
                <button type="button" class="btn btn--primary btn--lg" data-open-modal>
                    <?php echo esc_html( rezka_field('hero_btn1','Связаться с нами') ); ?>
                    <img src="<?php echo rezka_asset('icons/arrow-right.svg'); ?>" alt="" width="22" height="22" aria-hidden="true">
                </button>
                <a href="#services" class="btn btn--outline btn--lg"><?php echo esc_html( rezka_field('hero_btn2','Смотреть виды работ') ); ?></a>
            </div>
        </div>

        <div class="hero__right">
            <div class="hero__visual">
                <img src="<?php echo esc_url( $hero_image ); ?>" alt="Установка канатной резки бетона на объекте" class="hero__photo" width="720" height="540" fetchpriority="high">
            </div>
            <ul class="hero__features">
                <?php foreach ( $hero_features as $f ) : ?>
                <li class="hero-feature">
                    <img src="<?php echo esc_url( $f['icon'] ); ?>" alt="" width="40" height="40" aria-hidden="true">
                    <span><?php echo esc_html( $f['text'] ); ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<!-- ==================== КЛЮЧЕВЫЕ ЦИФРЫ ==================== -->
<section class="stats" aria-label="Ключевые показатели">
    <div class="container stats__inner">
        <?php foreach ( $stats as $s ) : ?>
        <div class="stat">
            <img src="<?php echo esc_url( $s['icon'] ); ?>" alt="" width="46" height="46" aria-hidden="true">
            <div class="stat__body"><span class="stat__num"><?php echo esc_html( $s['number'] ); ?></span><span class="stat__label"><?php echo esc_html( $s['label'] ); ?></span></div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ==================== ВИДЫ РАБОТ ==================== -->
<section class="services section" id="services">
    <span class="section__watermark" aria-hidden="true">01</span>
    <div class="container">
        <div class="services__head">
            <div class="services__intro">
                <h2 class="section__title"><?php echo esc_html( rezka_field('services_title','Виды работ и сфера применения канатной резки') ); ?></h2>
                <p class="services__text"><?php echo esc_html( rezka_field('services_text','Канатная резка позволяет выполнять работы любой сложности с максимальной точностью и минимальным воздействием на конструкции.') ); ?></p>
            </div>
        </div>
        <div class="services__scheme">
            <ul class="services__col services__col--left">
                <?php foreach ( $services_left as $it ) : ?>
                <li class="service-item">
                    <img src="<?php echo esc_url( $it['icon'] ); ?>" alt="" width="46" height="46" aria-hidden="true">
                    <p><?php echo esc_html( $it['text'] ); ?></p>
                </li>
                <?php endforeach; ?>
            </ul>
            <div class="services__center">
                <img src="<?php echo esc_url( $scheme_img ); ?>" alt="Схема промышленного объекта для канатной резки" class="services__scheme-img" width="512" height="330">
            </div>
            <ul class="services__col services__col--right">
                <?php foreach ( $services_right as $it ) : ?>
                <li class="service-item">
                    <img src="<?php echo esc_url( $it['icon'] ); ?>" alt="" width="46" height="46" aria-hidden="true">
                    <p><?php echo esc_html( $it['text'] ); ?></p>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<!-- ==================== НАШИ ПРЕИМУЩЕСТВА ==================== -->
<section class="advantages section" id="advantages">
    <span class="section__watermark section__watermark--light" aria-hidden="true">02</span>
    <div class="container">
        <h2 class="section__title section__title--light"><?php echo esc_html( rezka_field('advantages_title','Наши преимущества') ); ?></h2>
        <ul class="advantages__grid">
            <?php foreach ( $advantages as $a ) : ?>
            <li class="advantage"><img src="<?php echo esc_url( $a['icon'] ); ?>" alt="" width="42" height="42" aria-hidden="true"><span><?php echo esc_html( $a['text'] ); ?></span></li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<!-- ==================== ТЕХНОЛОГИИ ==================== -->
<section class="technologies section" id="technologies">
    <div class="container">
        <h2 class="section__title"><?php echo esc_html( rezka_field('tech_title','Технологии') ); ?></h2>
        <div class="tech__grid">
            <?php foreach ( $tech as $t ) :
                $bg = "linear-gradient(180deg,rgba(16,26,36,.20),rgba(16,26,36,.88)),url('" . esc_url( $t['image'] ) . "')"; ?>
            <article class="tech-card" style="background-image:<?php echo $bg; ?>">
                <span class="tech-card__num"><?php echo esc_html( $t['number'] ); ?></span>
                <h3 class="tech-card__title"><?php echo esc_html( $t['title'] ); ?></h3>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==================== ФОТО ПРОЦЕССА РАБОТЫ ==================== -->
<section class="gallery section" id="gallery">
    <div class="container">
        <h2 class="section__title"><?php echo esc_html( rezka_field('gallery_title','Фото процесса работы') ); ?></h2>
    </div>
    <div class="gallery__wrap">
        <button type="button" class="gallery__arrow gallery__arrow--prev" aria-label="Предыдущие фото" id="galPrev">
            <img src="<?php echo rezka_asset('icons/chevron-left.svg'); ?>" alt="" width="24" height="24" aria-hidden="true">
        </button>
        <div class="gallery__track" id="galleryTrack">
            <?php foreach ( $gallery as $i => $g ) : ?>
            <button type="button" class="gallery__item" data-index="<?php echo $i; ?>"><img src="<?php echo esc_url( $g['image'] ); ?>" alt="<?php echo esc_attr( $g['alt'] ?: 'Фото процесса работы' ); ?>" loading="lazy" width="380" height="285"></button>
            <?php endforeach; ?>
        </div>
        <button type="button" class="gallery__arrow gallery__arrow--next" aria-label="Следующие фото" id="galNext">
            <img src="<?php echo rezka_asset('icons/chevron-right.svg'); ?>" alt="" width="24" height="24" aria-hidden="true">
        </button>
    </div>
</section>

<!-- ==================== ОБЪЕКТЫ ==================== -->
<section class="objects section" id="objects">
    <div class="container">
        <h2 class="section__title"><?php echo esc_html( rezka_field('objects_title','Мы принимали участие на объектах') ); ?></h2>
        <div class="objects__layout">
            <aside class="objects__map">
                <img src="<?php echo esc_url( $map_img ); ?>" alt="Карта России с объектами компании" class="objects__map-img" width="540" height="260">
                <div class="objects__badge">
                    <img src="<?php echo rezka_asset('icons/logo-mark.svg'); ?>" alt="" width="44" height="30" aria-hidden="true">
                    <span><?php echo nl2br( esc_html( rezka_field('objects_badge','Работаем на объектах по всей России') ) ); ?></span>
                </div>
            </aside>
            <ul class="objects__grid">
                <?php foreach ( $objects as $o ) : ?>
                <li class="object-card"><span class="object-card__num"><?php echo esc_html( $o['number'] ); ?></span><div><h3 class="object-card__title"><?php echo esc_html( $o['title'] ); ?></h3><p><?php echo esc_html( $o['text'] ); ?></p></div></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<!-- ==================== КОНТАКТЫ ==================== -->
<?php
$phone   = rezka_field('phone','8 (981) 723-89-79');
$phone_r = rezka_field('phone_raw','+79817238979');
$wa      = rezka_field('whatsapp','79500031953');
$wa_l    = rezka_field('whatsapp_label','+7 950 003-19-53');
$tg      = rezka_field('telegram','+79500031953');
$tg_l    = rezka_field('telegram_label','+7 950 003-19-53');
$email   = rezka_field('email','s7238979@mail.ru');
$address = rezka_field('address','Россия, ЛО, М.Р-Н Волосовский, С.П. Бегуницкое, д. Бегуницы, д. 74, часть помещ. 9');
?>
<section class="contacts section" id="contacts">
    <div class="container contacts__inner">
        <div class="contacts__lead">
            <h2 class="section__title"><?php echo esc_html( rezka_field('contacts_title','Свяжитесь с нами') ); ?></h2>
            <p class="contacts__text"><?php echo esc_html( rezka_field('contacts_text','Готовы проконсультировать по вашему объекту и подобрать оптимальное решение.') ); ?></p>
            <button type="button" class="btn btn--primary btn--lg" data-open-modal>
                <?php echo esc_html( rezka_field('contacts_btn','Получить консультацию') ); ?>
                <img src="<?php echo rezka_asset('icons/arrow-right.svg'); ?>" alt="" width="22" height="22" aria-hidden="true">
            </button>
        </div>
        <div class="contacts__cards">
            <div class="contact-card">
                <img src="<?php echo rezka_asset('icons-dark/contact-address.svg'); ?>" alt="" width="34" height="34" aria-hidden="true">
                <div><span class="contact-card__label">Адрес офиса</span><p class="contact-card__value"><?php echo esc_html( $address ); ?></p></div>
            </div>
            <a class="contact-card" href="tel:<?php echo esc_attr( $phone_r ); ?>">
                <img src="<?php echo rezka_asset('icons-dark/contact-phone.svg'); ?>" alt="" width="34" height="34" aria-hidden="true">
                <div><span class="contact-card__label">Телефон</span><p class="contact-card__value"><?php echo esc_html( $phone ); ?></p></div>
            </a>
            <a class="contact-card" href="https://wa.me/<?php echo esc_attr( $wa ); ?>" target="_blank" rel="noopener">
                <img src="<?php echo rezka_asset('icons-dark/contact-whatsapp.svg'); ?>" alt="" width="34" height="34" aria-hidden="true">
                <div><span class="contact-card__label">WhatsApp</span><p class="contact-card__value"><?php echo esc_html( $wa_l ); ?></p></div>
            </a>
            <a class="contact-card" href="https://t.me/+<?php echo esc_attr( ltrim($tg,'+') ); ?>" target="_blank" rel="noopener">
                <img src="<?php echo rezka_asset('icons-dark/contact-telegram.svg'); ?>" alt="" width="34" height="34" aria-hidden="true">
                <div><span class="contact-card__label">Telegram</span><p class="contact-card__value"><?php echo esc_html( $tg_l ); ?></p></div>
            </a>
            <a class="contact-card" href="mailto:<?php echo esc_attr( $email ); ?>">
                <img src="<?php echo rezka_asset('icons-dark/contact-email.svg'); ?>" alt="" width="34" height="34" aria-hidden="true">
                <div><span class="contact-card__label">Email</span><p class="contact-card__value"><?php echo esc_html( $email ); ?></p></div>
            </a>
        </div>
    </div>
</section>

</main>

<?php get_footer();
