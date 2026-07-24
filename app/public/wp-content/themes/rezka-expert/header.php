<?php
/**
 * header.php — <head> + шапка сайта
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$phone_raw = rezka_field( 'phone_raw', '+79817238979' );
$phone     = rezka_field( 'phone', '8 (981) 723-89-79' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- ==================== ШАПКА ==================== -->
<header class="header" id="top">
    <div class="container header__inner">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" aria-label="ООО «Эксперт канатной резки» — на главную">
            <img src="<?php echo rezka_asset( 'icons/logo-mark.svg' ); ?>" alt="" class="logo__mark" width="52" height="35">
            <span class="logo__text">
                <span class="logo__line1">ООО «ЭКСПЕРТ</span>
                <span class="logo__line2">КАНАТНОЙ РЕЗКИ»</span>
            </span>
        </a>

        <nav class="nav" id="mainNav" aria-label="Основная навигация">
            <ul class="nav__list">
                <li><a href="#services" class="nav__link">Виды работ</a></li>
                <li><a href="#advantages" class="nav__link">Наши преимущества</a></li>
                <li><a href="#technologies" class="nav__link">Технологии</a></li>
                <li><a href="#objects" class="nav__link">Опыт работы</a></li>
                <li><a href="#contacts" class="nav__link">Контакты</a></li>
            </ul>
        </nav>

        <div class="header__actions">
            <a href="tel:<?php echo esc_attr( $phone_raw ); ?>" class="header__phone">
                <img src="<?php echo rezka_asset( 'icons-dark/contact-phone.svg' ); ?>" alt="" width="20" height="20" aria-hidden="true">
                <span><?php echo esc_html( $phone ); ?></span>
            </a>
            <button type="button" class="btn btn--primary header__cta" data-open-modal>Получить консультацию</button>
            <button type="button" class="burger" id="burger" aria-label="Открыть меню" aria-expanded="false" aria-controls="mainNav">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</header>
<div class="nav-overlay" id="navOverlay" hidden></div>
