<?php
$edited_article = ( !empty( $cloned_articles ) && !empty( $cloned_articles[$article->ID] ) ) ? $cloned_articles[$article->ID] : 0;
$modified_date  = !empty( $edited_article ) ? get_field( 'edited_date', $edited_article ) : '';
$modified_date  = !empty( $modified_date ) ? $modified_date : __( "Original", "dkng" );
?>
<tr class="item">
    <td>
        <a href="<?php echo get_permalink( $article->ID );?>">
            <img alt="img1"
                 src="<?php echo get_the_post_thumbnail_url( $article->ID, 'thumbnail' ); ?>" />
        </a>
    </td>
    <td>
        <a href="<?php echo get_permalink( $article->ID );?>">
            <?php echo $article->post_title; ?>
        </a>
        <p class="grey"><?php echo $article->post_except; ?></p>
    </td>
    <td> <?php echo get_the_date( 'Y/m/d', $article->ID );?> </td>
    <td colspan="1"> <?php echo $cats_string; ?>  </td>
    <td colspan="1"> <?php echo $modified_date; ?> </td>
    <td>
        <p class="type-title type-title--no-margin title-icon title-icon--<?php echo $article_type;?>">
            <?php echo ucfirst( $article_type );?>
        </p>
    </td>
    <td>
        <a class="btn btn-line finra" disabled="">
            <span><?php echo __( 'FINRA', 'dkng');?>: <?php echo $approve_status;?></span>
            <?php if ( $approve_status == 'Reviewed' ) { ?>
                <span class="checkmark" style="color:green; font-size: 14px;"></span>
            <?php } ?>
        </a>
    </td>
    <td>
        <a class="btn btn-view read-article" data-post-id="<?php echo $article->ID;?>"
           href="<?php echo get_permalink( $article->ID );?>">
            <?php echo __( 'View', 'dkng' );?>
        </a>
    </td>
</tr>