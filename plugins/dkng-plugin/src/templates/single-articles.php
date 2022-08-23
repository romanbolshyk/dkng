<?php
if ( !is_user_logged_in() ) {
//	wp_redirect(get_site_url() . '/advisorlogin');
//	exit;
}

$id               = get_the_ID();
$user             = wp_get_current_user();
$cloned_articles  = get_user_meta( $user->ID, 'user_cloned_articles', true );
$cloned_articles  = !empty( $cloned_articles ) ? $cloned_articles : array();
$author_id        = get_post_field( 'post_author', $id );

$postcat          = get_the_terms( $id, 'articles-types' );
$postcat          = $postcat[0]->name;
$cloned_article   = ( $postcat == 'Cloned' ) ? true : false;

/* Redirect if cloned user and not logged in user */
if ( !is_user_logged_in() && !empty( $cloned_article ) ) {
	wp_redirect( get_site_url() . '/advisorlogin' );
	exit;
}

/* Redirect to cloned article if current original article id has cloned for current user  */
if ( array_key_exists( $id, $cloned_articles ) && !$cloned_article ) {
    $link = get_permalink( $cloned_articles[$id]);
    wp_redirect( $link, 302);
    exit;
}

/* Redirect if cloned user and logged in user id != as author id of cloned article */
if ( is_user_logged_in() && !empty( $cloned_article ) && ( $user->ID != $author_id ) ) {
    wp_redirect( get_site_url() . '/admin-content' );
    exit;
}

if ( is_user_logged_in() ) {
    get_header();
} else {
    get_header('custom');
}
?>
<?php while ( have_posts() ) : the_post();

	$id                      = get_the_ID();
    $article_actions_obj     = new \Dkng\Wp\ArticlesActions();
    $preparing_articles_arr  = $article_actions_obj->preparing_articles_objects();
    $post_not_in             = array_merge( $preparing_articles_arr['excluded_articles'], array( $id ) );

    $articles_arr            = array( 'post_type' => 'articles', 'posts_per_page' => 5, 'post__not_in' => $post_not_in );
    $articles_arr            = array_merge( $articles_arr, $preparing_articles_arr['original_articles_arr'] );

	$articles                = new WP_Query( $articles_arr );
	$user_published_articles = get_user_meta( $user->ID, 'published_articles', true );

	$article_type  = get_field('article_type', $id);
	$article_type  = empty( $article_type ) ? 'article' : $article_type;
	$acf_type_name = $article_type . '_group';
	$info_articles = get_field($acf_type_name, 'option');
	$info_download = $info_articles['download'];
	$info_share    = $info_articles['share'];

    $popup_form_class = !empty( $cloned_article ) ? 'edit_cloned_article_form' : 'clone_article';

	ob_start();
	foreach ( $articles->posts as $article ) { ?>
		<div class="useful-holder">
			<div class="row">
				<div class="col-5">
					<div class="user-img" style="background-image: url(<?php echo get_the_post_thumbnail_url($article->ID, 'thumbnail'); ?>);"></div>
				</div>
				<div class="col-7 pl-0  flex-row justify-content-start align-items-center">
					<p>
						<a href="<?php echo get_the_permalink($article->ID); ?>" class="read-article"
						   data-post-id="<?php echo $article->ID; ?>">
							<?php echo $article->post_title; ?>
						</a>
					</p>
					<p><?php echo $article->post_excerpt; ?></p>
				</div>
			</div>
		</div>
	<?php }
	$other_posts = ob_get_clean();

	$related     = get_post_meta( $id, 'related_edited_article', true );
	if ( !empty( $cloned_article ) ) {

        $parent_id   = get_field('original_post', $id);
        $pdf_file    = get_field('pdf_file', $parent_id);
        $word_file   = get_field('word_file', $parent_id);
        $video_file  = get_field('video_file', $parent_id);
        $article_id  = $parent_id;
    }
    else {
        $pdf_file    = get_field('pdf_file', $id);
        $word_file   = get_field('word_file', $id);
        $video_file  = get_field('video_file', $id);
        $article_id  = $id;
    }

    if ( !empty( $cloned_article ) ) {
        $modified_date = get_field( 'edited_date', $id );
        $user_name     = $user->user_firstname . ' ' . $user->last_name;
        $modified_text = "Edited By User $user_name On: $modified_date";

        $show_custom_link_message = get_field( 'show_custom_link_message', $id );
    }

	?>
	<div class="container content content_popup sv-content-detail article_single_block">
		<div class="row">
            <?php if ( is_user_logged_in() ) {
                require_once 'template-parts/articles/logged_in_template.php';
            } else {
                require_once 'template-parts/articles/not_logged_in_template.php';
            }
            ?>
		</div>

	</div>
<?php endwhile;
wp_reset_postdata(); ?>
<?php
get_footer();
