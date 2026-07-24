<?php
/**
 * footer.php — подвал + модальная форма + lightbox
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$phone       = rezka_field( 'phone', '8 (981) 723-89-79' );
$phone_raw   = rezka_field( 'phone_raw', '+79817238979' );
$wa          = rezka_field( 'whatsapp', '79500031953' );
$wa_label    = rezka_field( 'whatsapp_label', '+7 950 003-19-53' );
$tg          = rezka_field( 'telegram', '+79500031953' );
$tg_label    = rezka_field( 'telegram_label', '+7 950 003-19-53' );
$email       = rezka_field( 'email', 's7238979@mail.ru' );
$address     = rezka_field( 'address', 'Россия, ЛО, М.Р-Н Волосовский, С.П. Бегуницкое, д. Бегуницы, д. 74, часть помещ. 9' );
$privacy_url = get_privacy_policy_url() ?: '#';
?>

<!-- ==================== ПОДВАЛ ==================== -->
<footer class="footer">
    <div class="container footer__inner">
        <div class="footer__col footer__about">
            <div class="logo logo--footer">
                <img src="<?php echo rezka_asset( 'icons-dark/logo-mark.svg' ); ?>" alt="" class="logo__mark" width="52" height="35">
                <span class="logo__text">
                    <span class="logo__line1">ООО «ЭКСПЕРТ</span>
                    <span class="logo__line2">КАНАТНОЙ РЕЗКИ»</span>
                </span>
            </div>
            <p class="footer__desc">Демонтажные работы методом канатной резки любой сложности.</p>
            <p class="footer__region">
                <img src="<?php echo rezka_asset( 'icons-dark/stat-russia-pin.svg' ); ?>" alt="" width="20" height="20" aria-hidden="true">
                Работаем по всей России
            </p>
        </div>

        <nav class="footer__col footer__nav" aria-label="Навигация в подвале">
            <h3 class="footer__title">Навигация</h3>
            <ul>
                <li><a href="#services">Виды работ</a></li>
                <li><a href="#advantages">Наши преимущества</a></li>
                <li><a href="#technologies">Технологии</a></li>
                <li><a href="#objects">Опыт работы</a></li>
                <li><a href="#contacts">Контакты</a></li>
            </ul>
        </nav>

        <div class="footer__col footer__contacts">
            <h3 class="footer__title">Контакты</h3>
            <ul>
                <li><a href="tel:<?php echo esc_attr( $phone_raw ); ?>"><img src="<?php echo rezka_asset( 'icons-dark/contact-phone.svg' ); ?>" alt="" width="18" height="18" aria-hidden="true"><?php echo esc_html( $phone ); ?></a></li>
                <li><a href="https://wa.me/<?php echo esc_attr( $wa ); ?>" target="_blank" rel="noopener"><img src="<?php echo rezka_asset( 'icons-dark/contact-whatsapp.svg' ); ?>" alt="" width="18" height="18" aria-hidden="true">WhatsApp: <?php echo esc_html( $wa_label ); ?></a></li>
                <li><a href="https://t.me/<?php echo esc_attr( ltrim( $tg, '+' ) ); ?>" target="_blank" rel="noopener"><img src="<?php echo rezka_asset( 'icons-dark/contact-telegram.svg' ); ?>" alt="" width="18" height="18" aria-hidden="true">Telegram: <?php echo esc_html( $tg_label ); ?></a></li>
                <li><a href="mailto:<?php echo esc_attr( $email ); ?>"><img src="<?php echo rezka_asset( 'icons-dark/contact-email.svg' ); ?>" alt="" width="18" height="18" aria-hidden="true"><?php echo esc_html( $email ); ?></a></li>
                <li class="footer__address"><img src="<?php echo rezka_asset( 'icons-dark/contact-address.svg' ); ?>" alt="" width="18" height="18" aria-hidden="true"><?php echo esc_html( $address ); ?></li>
            </ul>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="container footer__bottom-inner">
            <p>© <span id="year"><?php echo esc_html( date( 'Y' ) ); ?></span> ООО «Эксперт канатной резки». Все права защищены.</p>
            <a href="<?php echo esc_url( $privacy_url ); ?>" target="_blank" rel="noopener">Политика конфиденциальности</a>
        </div>
    </div>
</footer>

<button type="button" class="to-top" id="toTop" aria-label="Наверх" hidden>
    <img src="<?php echo rezka_asset( 'icons/chevron-left.svg' ); ?>" alt="" width="22" height="22" aria-hidden="true">
</button>

<!-- ==================== МОДАЛЬНАЯ ФОРМА ==================== -->
<div class="modal" id="modal" hidden>
    <div class="modal__overlay" data-close-modal></div>
    <div class="modal__dialog" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <button type="button" class="modal__close" aria-label="Закрыть форму" data-close-modal>
            <img src="<?php echo rezka_asset( 'icons/close.svg' ); ?>" alt="" width="24" height="24" aria-hidden="true">
        </button>
        <h2 class="modal__title" id="modalTitle">Получить консультацию</h2>
        <p class="modal__subtitle">Оставьте заявку — перезвоним и ответим на все вопросы по вашему объекту.</p>

        <?php
        /**
         * На этапе интеграции сюда вставляется форма Contact Form 7:
         * echo do_shortcode('[contact-form-7 id="XXX" title="Заявка"]');
         * Пока — HTML-форма из верстки (валидация/маска телефона работают через main.js).
         */
        ?>
        <form class="form" id="requestForm" novalidate>
            <div class="form__field">
                <label for="fName">Имя <span aria-hidden="true">*</span></label>
                <input type="text" id="fName" name="name" required autocomplete="name" placeholder="Ваше имя">
                <span class="form__error" data-error-for="fName"></span>
            </div>
            <div class="form__field">
                <label for="fPhone">Телефон <span aria-hidden="true">*</span></label>
                <input type="tel" id="fPhone" name="phone" required autocomplete="tel" placeholder="+7 (___) ___-__-__" inputmode="tel">
                <span class="form__error" data-error-for="fPhone"></span>
            </div>
            <div class="form__field">
                <label for="fComment">Комментарий / описание задачи</label>
                <textarea id="fComment" name="comment" rows="3" placeholder="Коротко опишите объект и задачу"></textarea>
            </div>
            <div class="form__hp" aria-hidden="true">
                <label for="fCompany">Не заполняйте это поле</label>
                <input type="text" id="fCompany" name="company" tabindex="-1" autocomplete="off">
            </div>
            <label class="form__checkbox">
                <input type="checkbox" id="fAgree" name="agree" required>
                <span>Я соглашаюсь с <a href="<?php echo esc_url( $privacy_url ); ?>" target="_blank" rel="noopener">политикой конфиденциальности</a> и обработкой персональных данных.</span>
            </label>
            <span class="form__error" data-error-for="fAgree"></span>
            <button type="submit" class="btn btn--primary btn--lg btn--block">Отправить заявку</button>
            <p class="form__success" id="formSuccess" hidden>Спасибо! Ваша заявка отправлена. Мы свяжемся с вами в ближайшее время.</p>
        </form>
    </div>
</div>

<!-- ==================== LIGHTBOX ==================== -->
<div class="lightbox" id="lightbox" hidden>
    <button type="button" class="lightbox__close" aria-label="Закрыть просмотр" id="lbClose">
        <img src="<?php echo rezka_asset( 'icons-dark/close.svg' ); ?>" alt="" width="30" height="30" aria-hidden="true">
    </button>
    <button type="button" class="lightbox__arrow lightbox__arrow--prev" aria-label="Предыдущее фото" id="lbPrev">
        <img src="<?php echo rezka_asset( 'icons-dark/chevron-left.svg' ); ?>" alt="" width="34" height="34" aria-hidden="true">
    </button>
    <figure class="lightbox__figure">
        <img src="" alt="" id="lbImage">
    </figure>
    <button type="button" class="lightbox__arrow lightbox__arrow--next" aria-label="Следующее фото" id="lbNext">
        <img src="<?php echo rezka_asset( 'icons-dark/chevron-right.svg' ); ?>" alt="" width="34" height="34" aria-hidden="true">
    </button>
    <span class="lightbox__counter" id="lbCounter"></span>
</div>

<?php wp_footer(); ?>
</body>
</html>
