<div class="campaign" id="<?php echo $campaign;?>">
    <a class="campaign__image d-block ribbon" href="<?php echo $link;?>" style="background-image: url(<?php echo $thumbnail;?>);">
        <span class="ribbon-target" style="<?php echo $ribbon_background; ?>"><?php echo $status; ?></span>
    </a>
    <div class="campaign__info">
        <span class="campaign__number"><?php echo __( "Campaign", "dkng" );?> #<?php echo $index;?></span>
        <h3 class="campaign__title"><a href="<?php echo $link;?>"><?php echo $title;?></a></h3>
        <div class="campaign__button"  style="display: initial;">
            <a href="<?php echo $link;?>" class="sv-button sv-button--green" ><?php echo __( "View Campaign", "dkng" );?></a>
        </div>
        <div class="campaign__button" style="display: initial;">
            <a href="<?php echo $link . '?report=1';?>" class="sv-button sv-button--green" ><?php echo __( "View Report", "dkng" );?></a>
        </div>
        <?php if ( !in_array( 'cloned', $post_terms )  ) { ?>
            <div class="campaign__button" style="display: initial;">
                <a href="" data-id="<?php echo $campaign;?>" class="sv-button sv-button--green clone_campaign_btn" ><?php echo __( "Clone Campaign", "dkng" );?></a>
            </div>
        <?php } ?>
        <?php if ( in_array( 'cloned', $post_terms )  ) { ?>
            <div class="campaign__button" style="display: initial;">
                <i class="fa fa-trash delete_cloned_campaign_btn sv-button" data-id="<?php echo $campaign;?>"></i>
            </div>
        <?php } ?>
    </div>
</div>