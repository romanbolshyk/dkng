<?php
/*
Template Name: Search Page
*/

$search_query = !empty( get_search_query() ) ? get_search_query() : $_GET['s'];
$search_query = !empty( get_search_query() ) ? $search_query : '';

if ( !empty( $search_query ) ) {
    $search_limit = 100;
    if ( $search_limit ) {
        $wp_query->posts_per_page = 100;
    }

    $max_num_pages = ( $search_limit ) ? ceil( $wp_query->found_posts / $search_limit ) : $wp_query->max_num_pages;
    $pagination = paginate_links([ 'total' => $max_num_pages ]);
    $pagination = false;
    $i     = 0;
    $count = 6;
}

$tpl = new Dkng\Wp\Templates();

get_header();
?>

    <div class="container search_page">

        <h1 class="hm-search-title">
            <?php printf( '%s "%s"', __( 'Search Results for', 'hudson' ), $search_query ); ?>
        </h1>

        <?php if ( have_posts() && !empty( $search_query ) ) { ?>
            <div class="hm-search-wrap" >
                <?php while( have_posts() ) :
                    the_post();
                    $i++;
                    $post_type_labels = get_post_type( get_the_ID() );
                    $post_type_label = ( $post_type_labels == 'svn_tpl' ) ? 'Template' : ucfirst( substr($post_type_labels, 0, -1 ) );

                    $style = ( $i > $count ) ? "hidden" : "";
                    ?>
                    <div class="search-item <?php echo $style;?>" style="margin: 20px 10px;">
                        <h4 class="post_type"><?php echo $post_type_label; ?></h4>
                        <?php if ( ( $post_type_labels == 'svn_tpl' ) ) { ?>
                            <div class="template">
                                <?php include( SVN_PLUGIN_TPLS . 'template-parts/cpt-templates/template-item.php' ); ?>
                            </div>
                        <?php } else { ?>
                            <?php the_title('<h4><a href='. get_permalink() .'>', '</a></h4>'); ?>
                            <div class="desc">
                                <?php the_excerpt(); ?>
                            </div>
                            <div class="item-btn-wrap">
                                <a href="<?php echo get_permalink();?>" class="btn btn-view">
                                    <?php _e( 'View', 'dkng' ); ?>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                <?php endwhile; ?>

                <div class="template-modal">
                    <div class="template-modal-close-wrap">
                        <span class="template-modal-close"></span>
                    </div>
                    <div class="template-modal-container">

                    </div>
                </div>
            </div>

            <?php if ( $pagination ) : ?>
                <div class="hm-pagination">
                    <?php echo $pagination; ?>
                </div>
            <?php  endif;  ?>

            <div class="">
                <a id="search_load_more_button"><?php echo __( "Load More", "dkng" );?></a>
            </div>

        <?php } else { ?>
            <div class="hm-search-wrap no-results">
                <h3><?php echo  __( 'No results', 'hudson' ); ?></h3>
            </div>
        <?php } ?>

    </div>

<?php get_footer();