<?php
/**
 * index.php — запасной шаблон.
 * Главная страница выводится через front-page.php.
 * Здесь — простая обёртка для остальных запросов.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<main class="section">
    <div class="container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                echo '<article style="max-width:820px;margin:0 auto 40px;">';
                echo '<h1 class="section__title">' . get_the_title() . '</h1>';
                echo '<div>'; the_content(); echo '</div>';
                echo '</article>';
            endwhile;
        else :
            echo '<h1 class="section__title">Ничего не найдено</h1>';
        endif;
        ?>
    </div>
</main>
<?php get_footer();
