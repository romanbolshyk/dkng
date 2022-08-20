<?php ob_start(); ?>
    <html>
        <head>
        </head>
        <body>
            <?php
            /**
             * The template for displaying all single posts and attachments
             *
             * @package FoundationPress
             * @since FoundationPress 1.0.0
             */
            $post = get_post( $post_id ); ?>
            <div class="body">
                <img src="<?php echo get_the_post_thumbnail_url( $post_id, 'thumbnail' ); ?>">
                <h3><?php echo $post->post_title;?></h3>
                <div class="content">
                   <?php echo $post->post_content;?>
                </div>
            </div>
            <?php wp_reset_query(); ?>
        </body>
    </html>
<?php $pdf_content = ob_get_clean(); ?>