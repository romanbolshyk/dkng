<?php
get_header('custom');

$project_type = ( isset( $_GET['realized'] ) ) ? true : false;

$project_database_text = get_field( 'projects_database_text', get_the_ID() );
$project_realized_text = get_field( 'projects_realized_text', get_the_ID() );

$project_type = ( isset( $_GET['realized'] ) ) ? true : false;

$projects     = empty( $project_type ) ? get_field( 'projects_database', get_the_ID() ) : get_field( 'projects_realized', get_the_ID() );
$projects_txt = "Список проєктів: ";
$projects_txt .= empty( $project_type ) ? $project_database_text : $project_realized_text;

?>

	<div class="inner_container  page-template-announces announces_block-banner-wrap">
		<div class="container">

            <!-- Bread Crumbs -->
            <div class="row bread_menu">
                <?php custom_breadcrumbs( );  ?>
            </div>
            <!-- Bread Crumbs -->

            <div class="row">
                <div class="announces_block-banner" >
                    <div class="announces_block-banner-center">
                        <h2 class="aligncenter"><?php  echo get_the_title(); ?></h2>
                        <h4>
                            <a href="<?php echo get_permalink( get_the_ID() );?>" style="padding: 10px;">
                                <?php  echo $project_database_text;?>
                            </a>

                            <a href="<?php echo get_permalink( get_the_ID() ) . "?realized";?>" style="padding: 10px;">
                                <?php  echo $project_realized_text; ?>
                            </a>
                        </h4>

                    </div>
                </div>
            </div>

		</div>

        <?php if ( !empty( $projects ) ) { ?>
            <div class="container announces_block-list" style="margin-top: 30px;">

                <div class="block">
                    <?php echo apply_filters('the_content', get_the_content() ); ?>
                </div>

                <div class="block" style="margin-top: 30px;">

                    <h3 class="aligncenter"><?php echo $projects_txt; ?></h3>

                    <?php foreach ( $projects as $project ) {
                        $project = $project['project'];
                        $img = get_the_post_thumbnail_url( $project );
                        $img = !empty( $img ) ? $img  : './dist/img/post.jpg';
                        ?>
                        <div class="announces_block-item" data-num="1">
                        <div class="announces_block-item-image">
                            <img src="<?php echo $img;?>" alt="announces image" style="height: 100%">
                        </div>
                        <div class="announces_block-item-text">
                            <div class="announces_block-item-top-text">
                                <?php echo get_the_date( 'Y-m-d', $project );?>
                            </div>
                            <h4 class="announces_block-item-title">
                                <a href="<?php echo get_permalink( $project )?>">
                                    <?php echo get_the_title( $project );?>
                                </a>
                            </h4>

                        </div>
                    </div>
                    <?php } ?>
                </div>

            </div>
        <?php  } ?>
	</div>

<?php
get_footer('custom');
wp_footer();