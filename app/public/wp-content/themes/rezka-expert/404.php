<?php

/**
 * 404.php — страница «Страница не найдена».
 */
if (! defined('ABSPATH')) exit;
get_header();
?>
<main class="error404" style="min-height:58vh;display:flex;align-items:center;padding:80px 0;background:linear-gradient(180deg,#FFFFFF 0%,var(--bg) 100%)">
    <div class="container" style="text-align:center;max-width:640px;margin:0 auto">
        <div style="font-family:'Montserrat',sans-serif;font-weight:900;font-size:clamp(90px,18vw,170px);line-height:1;color:var(--yellow)">404</div>
        <h1 style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:clamp(24px,4vw,34px);color:var(--navy);text-transform:uppercase;letter-spacing:.5px;margin:6px 0 14px">Страница не найдена</h1>
        <p style="color:var(--text-2);font-size:17px;line-height:1.6;margin:0 0 30px">К сожалению, запрашиваемая страница не существует или была перемещена. Вернитесь на главную страницу.</p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary btn--lg">
            Вернуться на главную
            <img src="<?php echo rezka_asset('icons/arrow-right.svg'); ?>" alt="" width="22" height="22" aria-hidden="true">
        </a>
    </div>
</main>
<?php get_footer();
