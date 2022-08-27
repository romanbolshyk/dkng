<?php

get_header('custom');

$obj      = new \Dkng\Wp\Specialities();
$paged    = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

$programs = $obj->get_programs( false, 3, $paged );
$max_num  = $obj->get_all_programs( 3 );

?>
<div class="super_container specialities_details_block">
    <div class="container content ">

        <!-- Bread Crumbs -->
        <div class="row bread_menu">
            <?php custom_breadcrumbs( );  ?>
        </div>
        <!-- Bread Crumbs -->

        <div class="white-element mb-100 page-template-announces">
            <div class="row">
                <div class="announces_block-list">
                    <div class="container">
                        <h2>Спеціальності (деталі):</h2>

                        <?php foreach ( $programs as $program ) {
                            $post   = get_post( $program );
                            $content = $post->post_content;
                            $speciality = get_field( 'speciality', $program );
                            ?>
                            <div class="announces_block-item" data-num="1" >

                                <div class="announces_block-item-text" >
                                    <h3 class="announces_block-item-t">
                                        <a href="<?php echo get_permalink( $program );?>" >
                                            <?php echo get_the_title( $speciality ) . " ( " . get_the_title( $program ) . " ) ";?>
                                        </a>
                                    </h3>
                                    <hr/>
                                    <div class="announces_block-item-desc" style="margin-top: 10px;">
                                        <?php echo apply_filters('the_content',  $content);;?>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>

                        <div class="custom_pagination">
                            <?php
                            $var = is_page() ? 'page' : 'paged';
                            $big = 999999999;

                            echo paginate_links( array(
                                'base'     => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                'paged'    => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
                                'current'  => max( 1, get_query_var( 'paged' ) ),
                                'format'   => '?paged=%#%',
                                'total'    => $max_num
                            ) );
                            ?>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<?php get_footer('custom');
