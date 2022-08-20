<div class="sv-blog-post col-lg-6 col-sm-12 col-xs-12">
    <div class="one-card">
        <?php
        $thumb_url = get_the_post_thumbnail_url($post->ID);
        $thumb_url_id = get_image_id($thumb_url);
        $thumb_url_alt = get_post_meta($thumb_url_id, '_wp_attachment_image_alt', TRUE);
        ?>
        <div class="blog-top-card">
            <a href="<?php echo get_permalink( $post->ID );?>">
                <img src="<?php echo $thumb_url; ?>" alt="<?php echo esc_attr( $thumb_url_alt ); ?>"/>
            </a>
        </div>
        <div class="card-content blog_list">
            <h3><a href="<?php echo get_permalink( $post->ID );?>"><?php echo $post->post_title;?></a></h3>
            <a href="<?php echo get_permalink( $post->ID );?>">Read article</a>
        </div>
    </div>
</div>