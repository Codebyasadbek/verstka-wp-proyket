<?php
/**
 * page.php — Шаблон обычных страниц WordPress (Согласие на обработку, Политика конфиденциальности и др.)
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<main class="page-main section">
    <div class="container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post(); ?>
                <article class="page-card">
                    <h1 class="section__title page-card__title"><?php the_title(); ?></h1>
                    <div class="page-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile;
        else : ?>
            <article class="page-card" style="text-align:center;padding:60px 30px;">
                <h1 class="section__title" style="margin-bottom:16px;">Ничего не найдено</h1>
                <p style="color:var(--text-2);margin-bottom:24px;">Запрашиваемая страница не существует или была перемещена.</p>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--primary">
                    Вернуться на главную
                </a>
            </article>
        <?php endif; ?>
    </div>
</main>
<?php get_footer();
