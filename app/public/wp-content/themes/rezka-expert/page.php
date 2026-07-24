<?php

/**
 * page.php — шаблон для отображения обычных страниц WordPress (например, Согласие на обработку).
 */
if (! defined('ABSPATH')) exit;
get_header();
?>
<main class="section" style="padding: 60px 0;">
    <div class="container">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post(); ?>
                <article class="page-article" style="max-width: 820px; margin: 0 auto;">
                    <h1 class="section__title" style="margin-bottom: 30px;"><?php the_title(); ?></h1>
                    <div class="page-content" style="font-size: 16px; line-height: 1.6; color: #2d3748;">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile;
        else : ?>
            <div style="text-align: center; padding: 40px 0;">
                <h1 class="section__title">Ничего не найдено</h1>
                <p>Запрашиваемая страница не существует или была перемещена.</p>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php get_footer();
