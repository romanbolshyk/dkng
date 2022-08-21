<?php
/**
 * The template for displaying 404 pages (Not Found)
 */
get_header('custom'); ?>

    <div id="content" class="row align-items-center justify-content-center page404" style="height: 100%;">
        <div class="container text-center">
            <h2 class="text-white">
                Такої сторінки не знайдено.
                <br>Ідіть назад  до <a href="<?php echo home_url();?>"> Головної сторінки</a> і знайдіть ту сторінку
                що ви шукали.
            </h2>
            </div>
        </div>
    </div>

<?php get_footer('custom');
wp_footer(); ?>