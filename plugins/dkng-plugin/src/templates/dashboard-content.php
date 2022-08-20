<?php
//if ( !is_user_logged_in() ) {
//    wp_redirect( get_site_url() . '/advisorlogin', 307 );
//    exit;
//}

get_header();

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

$filter_group   = get_field( 'main_filter', 'option' );
$topic_text     = $filter_group['topic'];
$download_text  = $filter_group['downloads'];
$type_text      = $filter_group['type'];
$new_vs_text    = $filter_group['new'];

$cloned_articles  = get_user_meta( $user->ID, 'user_cloned_articles', true );
$cloned_articles  = !empty( $cloned_articles ) ? $cloned_articles : array();

?>
<div class="container content">

    <div class="sv-filter">

        <div class="sv-filter__top">
            <h3 class="sv-filter__title"><?php echo __( "Investor Approved Content", "dkng" );?></h3>
            <p class="sv-filter__description">
                <?php echo __( "Get started by exploring our content and determine what you could use with clients and prospects.", "dkng" );?>
            </p>
        </div>

        <p class="sv-filter__statistic sv-tooltip-container">
            <?php echo $downloads . ' ' . __( "Downloads for", "dkng" ) . ' ' . $current_month;?>
            <span class="sv-tooltip sv-tooltip--big" data-tooltip="<?php echo $download_text;?>"></span>
        </p>

        <form action="#" method="post" class="sv-filter__form">

            <div class="sv-filter__item">
                <label for="sv-filter-topic" class="sv-tooltip-container">
                    <?php echo __( "Topic", "dkng" );?>
                    <span class="sv-tooltip sv-tooltip--big sv-tooltip--in-line"
                        data-tooltip="<?php echo $topic_text;?>"></span>
                </label>
                <span class="select-wrapper">
                    <select name="topic" id="sv-filter-topic">
                        <option value="all"><?php echo __( "All", "dkng" );?></option>
                         <?php foreach ( $categories as $category ) { ?>
                             <option value="<?php echo $category->slug;?>"><?php echo $category->name;?></option>
                         <?php } ?>
                    </select>
                </span>
            </div>

            <div class="sv-filter__item d-none">
                <label for="sv-filter-type" class="sv-tooltip-container">
                    <?php echo __( "Type", "dkng" );?>
                    <span class="sv-tooltip sv-tooltip--big sv-tooltip--in-line"
                      data-tooltip="<?php echo $type_text;?>"></span>
                </label>
                <span class="select-wrapper">
                    <select name="type" id="sv-filter-type">
                        <option value="all" selected><?php echo __( "All", "dkng" );?></option>
                        <option value="article"><?php echo __( "Article", "dkng" );?></option>
                        <option value="email"><?php echo __( "Email", "dkng" );?></option>
                        <option value="video"><?php echo __( "Video", "dkng" );?></option>
                    </select>
                </span>
            </div>

            <?php  /*
            <div class="sv-filter__item">
                <label for="sv-filter-sort" class="sv-tooltip-container">
                    <?php echo __( "New vs. Archived", "dkng" );?>
                    <span class="sv-tooltip sv-tooltip--big sv-tooltip--in-line"
                      data-tooltip="<?php echo $new_vs_text;?>"></span>
                </label>
                <span class="select-wrapper">
                    <select name="sort" id="sv-filter-sort">
                        <option value="all"><?php echo __( "All", "dkng" );?></option>
                        <option value="new"><?php echo __( "New", "dkng" );?></option>
                        <option value="archived"><?php echo __( "Archived", "dkng" );?></option>
                    </select>
                </span>
            </div>
            */ ?>

            <div class="sv-filter__item">
                <label for="sv-filter-original-edited" class="sv-tooltip-container">
                    <?php echo __( "Original vs Edited", "dkng" );?>
                    <span class="sv-tooltip sv-tooltip--big sv-tooltip--in-line"
                          data-tooltip="<?php echo $new_vs_text;?>"></span>
                </label>
                <span class="select-wrapper">
                    <select name="filter_edited_original" id="sv-filter-original-edited">
                        <option value="all"><?php echo __( "All", "dkng" );?></option>
                        <option value="original"><?php echo __( "Original", "dkng" );?></option>
                        <option value="edited"><?php echo __( "Edited", "dkng" );?></option>
                    </select>
                </span>
            </div>
            <div class="sv-filter__item loader_block">
                <img src="./dist/img/loader.gif" alt="loader"  id="loader" />
            </div>
            <!--
            <div class="sv-filter__item">
                <input type="submit" class="submit btn btn-view" value="Filter">
            </div>
            -->
        </form>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="table-responsive video">
                <table class="table">
                    <thead>
                        <tr>
                            <th><?php echo __( 'Content', 'dkng' );?></th>
                            <th></th>
                            <th><?php echo __( 'Upload Date', 'dkng' );?></th>
                            <th><?php echo __( 'Categories', 'dkng' );?></th>
                            <th><?php echo __( 'Edited On', 'dkng' );?></th>
                            <th><?php echo __( 'Type', 'dkng' );?></th>
                            <th><?php echo __( 'Approval', 'dkng' );?></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody class="body-items" data-all="<?php echo $count_all;?>" data-getcat="all" data-cpt="articles"
                           data-gettype="all" data-getsort="all" data-get_article_type="all" data-page="1" >
                        <?php foreach ( $articles->posts as $article ) {
                            $article_type    = get_field( 'article_type', $article->ID );
                            $article_type    = empty( $article_type ) ? 'article' : $article_type;
                            $approval        = get_field_object('approval_post', $article->ID );
                            $key             = $approval['value'];
                            $approve_status  = $approval['choices'][$key];
                            $categories      = get_the_terms( $article->ID, "articles-category");
                            $post_status     = ( get_post_status( $article->ID ) == 'publish' ) ? 'Published' : 'Unpublished';

                            if ( !empty( $categories ) ) {
                                foreach ( $categories as $cat ) {
                                    $cat_list[$article->ID][] = $cat->name;
                                }
                            }
                            $cats_string =  ( $cat_list[$article->ID] ) ? implode( "<br/>", $cat_list[$article->ID] ) : '';

                            require  'template-parts/ajax-items/article_item.php'; ?>
                        <?php } ?>
                    </tbody>
                </table>
                <?php if ( count ( $articles->posts ) >= $count_per_page ) { ?>
                    <a id="load_more_button_filtering">
                        <?php echo __( 'Load More', 'dkng');?>
                        <img src="./dist/img/loader.gif" alt="loader_more"  id="loader_more" />
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer();
