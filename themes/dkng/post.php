<?php
/**
 * Custom Page Template
 */

get_header();

while ( have_posts() ) : the_post();

    the_title( '<h1 class="outsourceo-blog--single__title text-center">', '</h1>' );
    the_content();

endwhile;

get_footer();
