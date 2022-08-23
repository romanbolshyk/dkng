<?php

get_header('custom');

$user              = wp_get_current_user();

$wealthbox_api_key = get_field( 'wealthbox_api_key', 'user_' . $user->ID );
$wealthbox_api_key = ( !empty( $wealthbox_api_key ) ) ? $wealthbox_api_key : "";


$article_actions_obj    = new \Dkng\Wp\ArticlesActions();
$preparing_articles_arr = $article_actions_obj->preparing_articles_objects();

$count_per_page = 20;
$arr = array (
    'post_type'      => 'articles',
    'posts_per_page' => $count_per_page,
    'post__not_in'   => $preparing_articles_arr['excluded_articles'],
);
$arr      = array_merge( $arr, $preparing_articles_arr['original_articles_arr'] );
$articles = new WP_Query( $arr );

$count_all      = count( $articles->posts );
$count_all      = $articles->found_posts;
$categories     = get_categories( array ( "taxonomy" => "articles-category" ) );

$current_time   = current_time('Y-m');
$current_month  = current_time('M');
$get_downloads  = get_user_meta( $user->ID, $current_time, true );
$get_downloads  = ( !empty( $get_downloads ) ) ? $get_downloads : array();
$downloads      = count( $get_downloads );

/*
$filter_group   = get_field( 'main_filter', 'option' );
$topic_text     = $filter_group['topic'];
$download_text  = $filter_group['downloads'];
$type_text      = $filter_group['type'];
$new_vs_text    = $filter_group['new'];
*/

$cloned_articles  = get_user_meta( $user->ID, 'user_cloned_articles', true );
$cloned_articles  = !empty( $cloned_articles ) ? $cloned_articles : array();

$query = array (
    'post_type'      => 'cemijkoledzh',
    'posts_per_page' => -1
);
$vidguky        = new WP_Query( $query );
$count          = $vidguky->found_posts;
?>
<div class="super_container">
    <div class="container content ">

        <div class="white-element mb-100 page-template-podcast">
                <div class="row">
                    <div class="podcast_block-list">
                        <div class="container">
                            <h2>Список Відгуків:</h2>
                            <?php foreach ( $vidguky->posts as $vidguk ) {
                                $excerpt = get_the_excerpt( $vidguk );
                                $original_thumbnail = get_the_post_thumbnail_url( $vidguk );

                                $grupa = get_field( 'grupa', $vidguk );
                                ?>
                                <div class="podcast_block-item" data-num="1">
                                    <div class="podcast_block-item-image">
                                        <a href="<?php echo get_permalink( $vidguk )?>">
                                            <img src="<?php echo $original_thumbnail;?>" alt="logo of people" style="height: 100%;">
                                        </a>
                                    </div>
                                    <div class="podcast_block-item-text">
                                        <div class="podcast_block-item-top-text">
                                            <?php echo $grupa;?>
                                        </div>
                                        <h4 class="podcast_block-item-t">
                                            <a href="<?php echo get_permalink( $vidguk )?>">
                                                <?php echo get_the_title( $vidguk );?>
                                            </a>
                                        </h4>

                                        <div class="podcast_block-item-desc">
                                            <p><?php echo $excerpt;?></p>
                                        </div>

                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
    </div>
</div>
<?php get_footer('custom');
