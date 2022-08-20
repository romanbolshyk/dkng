<?php
get_header('custom');

$title          = get_field( 'title');
$title_list     = get_field( 'text_of_list');

$count_per_page = 4;
$posts          = new WP_Query( array ( 'post_type' => 'post', 'posts_per_page' => $count_per_page ) );
$count_all      = $posts->found_posts;
$categories     = get_categories( array ( "taxonomy" => "category" ) );
?>

        <div class="inner_container blog_block"></div>
    </div>

    <div class="smaller-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h4><?php if ( $title ) echo $title;?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="small-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h1 class="d-none">Blog</h1>
                    <h2><?php if ( $title_list ) echo $title_list;?></h2>
                </div>
                <div class="col-lg-8">
                    <ul class="navbar topics-nav d-flex justify-content-start align-items-center all_posts_categories">
                        <li><a href="#" data-href="all" class="nav-link cat active" data-cat="ALL TOPICS"><?php echo __( "ALL TOPICS", "dkng" );?></a></li>
                        <?php if ( !empty( $categories ) ) {
                            foreach( $categories as $cat ) { ?>
                                <li><a href="#" data-href="<?php echo $cat->slug;?>" class="cat nav-link" data-cat="<?php echo strtoupper($cat->name);?>"><?php echo strtoupper($cat->name);?></a></li>
                            <?php }
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="default-padding case-studies">
        <div class="container">
            <div class="row d-flex justify-content-between all_posts" data-all="<?php echo $count_all;?>" data-getcat="all" data-cpt="post">

                <?php foreach ( $posts->posts as $post ) { ?>
                    <?php require 'template-parts/ajax-items/post_item.php';?>
                <?php } ?>

            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <?php if ( count ( $posts->posts ) >= $count_per_page ) { ?>
                        <a href="#" id="load_more_posts_button" class="btn btn-primary btn-load"><?php echo __( "Load More", "dkng" );?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer('custom');
//get_footer();
wp_footer();
