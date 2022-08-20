<?php
/**
 * Custom Page Template
 */

get_header('custom');

while ( have_posts() ) : the_post();
    ?>

    <div class="inner_container ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="inner_content">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <h4><?php  the_title( '<h1 class="seven__title text-center">', '</h1>' ); ?></h4>

                                <p><?php the_content(); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
endwhile;

get_footer('custom');
wp_footer();
