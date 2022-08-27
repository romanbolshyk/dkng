<?php

get_header('custom');

$paged      = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$object1    = new \Dkng\Wp\Novyny();
$count      = 9;
$novyny     = $object1->get_news( $count, $paged );

$found_posts = $novyny->found_posts;
$max_num     = ceil( $found_posts / $count );
$novyny      = $novyny->posts;

$i = 0;
?>
<div class="inner_container novyny_template ">
    <div class="container template">

        <!-- Bread Crumbs -->
        <div class="row bread_menu">
            <?php custom_breadcrumbs( );  ?>
        </div>
        <!-- Bread Crumbs -->

        <div class="sv-filter" style="display: none;">
            <div class="sv-filter__top">
                <h3 class="sv-filter__title">
                    <?php echo __( "Архів Новин", "dkng" ); ?>
                </h3>
                <p class="sv-filter__description">
                    <?php echo __( "Форма фільтрації буде тут.", "dkng" ); ?>
                </p>
            </div>

            <form action="#" method="post" class="sv-filter__form" id="js_svTplFilter">

                <input type="hidden" name="action" value="svnGetTemplates" />
                <input type="hidden" name="page" value="1" />

                <div class="sv-filter__item">
                    <label for="sv-filter-topic" class="sv-tooltip-container">
                        <?php echo __( "Фільтр 1", "dkng" ); ?>
                    </label>
                    <span class="select-wrapper">
                        <select name="topic" id="sv-filter-topic">
                            <option value="0">
                                <?php echo __( "All", "dkng" ); ?>
                            </option>
                        </select>
                    </span>
                </div>

                <div class="sv-filter__item">
                    <label for="sv-filter-type" class="sv-tooltip-container">
                        <?php echo __( "Фільтр 2", "dkng" ); ?>
                    </label>
                    <span class="select-wrapper">
                        <select name="tpasst" id="sv-filter-type">
                            <option value="0">
                                <?php echo __( "All", "dkng" ); ?>
                            </option>
                        </select>
                    </span>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-12">

                <?php if ( !empty( $novyny ) ) { ?>
                    <div class="template-items ">
                        <?php foreach ( $novyny as $novyna ) {
                            $i++; ?>

                            <div class="item">

                                <div class="item-image ">
                                    <a href="<?php echo get_permalink( $novyna );?>" >
                                        <img src="<?php echo get_the_post_thumbnail_url( $novyna ); ?>" alt="image">
                                    </a>
                                </div>

                                <div class="item-content">
                                    <span class="item-topic">
                                        Новина № <?php echo $i;?>
                                    </span>

                                    <h4 class="item-title">
                                        <?php echo get_the_title( $novyna ); ?>
                                    </h4>

                                    <p class="item-topic">
                                       <?php echo get_the_excerpt( $novyna );?>
                                    </p>

                                    <div class="item-btn-wrap">
                                        <a href="<?php echo get_permalink( $novyna );?>" class="btn btn-view">
                                            <?php _e( 'Дивитись', 'dkng' ); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </div>

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

                <?php } ?>

            </div>
        </div>

    </div>
</div>

<?php get_footer('custom'); ?>
