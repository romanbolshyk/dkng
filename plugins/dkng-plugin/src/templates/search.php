<?php
/*
Template Name: Search Page
*/

$search_query = !empty( get_search_query() ) ? get_search_query() : $_GET['s'];
$search_query = !empty( get_search_query() ) ? $search_query : '';
global $wp_query;

$found_posts = $wp_query->found_posts;

$pagination = paginate_links([ 'total' => $wp_query->max_num_pages ]);
$i          = 0;

get_header('custom');
?>

    <div class="container search_page">

        <h1 class="hm-search-title">
            <?php printf( '%s "%s"', __( 'Результати пошуку для ', 'dkng' ), $search_query ); ?>
        </h1>

        <?php if ( have_posts() && !empty( $search_query ) ) { ?>
            <div class="hm-search-wrap" >
                <?php while( have_posts() ) :
                    the_post();
                    $i++;
                    $post_type_labels = get_post_type( get_the_ID() );
                    $pt   = get_post_type_object( $post_type_labels );
                    $name = $pt->labels->singular_name;
                    ?>
                    <div class="search-item" style="margin: 20px 10px;">
                        <h4 class="post_type"><?php echo $name; ?></h4>

                        <?php the_title('<h4><a href='. get_permalink() .'>', '</a></h4>'); ?>
                        <div class="desc">
                            <?php  the_excerpt(); ?>
                        </div>
                        <div class="item-btn-wrap">
                            <a href="<?php echo get_permalink();?>" class="btn btn-view">
                                <?php _e( 'Дивитись', 'dkng' ); ?>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>


                <?php if ( $pagination ) : ?>
                    <div class="custom_pagination">
                        <?php
                        $var = is_page() ? 'page' : 'paged';
                        $big = 999999999;

                        echo paginate_links( array(
                            'base'     => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                            'paged'    => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
                            'current'  => max( 1, get_query_var( 'paged' ) ),
                            'format'   => '?paged=%#%',
                            'total'    => $wp_query->max_num_pages
                        ) );
                        ?>
                    </div>
                <?php  endif;  ?>

            </div>

        <?php } else { ?>
            <div class="hm-search-wrap no-results">
                <h3><?php echo  __( 'Нажаль, нічого не знайдено', 'dkng' ); ?>.</h3>
            </div>
        <?php } ?>

    </div>

<?php get_footer('custom');