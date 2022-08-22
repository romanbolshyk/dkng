<div class="row">

    <div class="col-12">
        <h3><?php echo $user->user_nicename; ?>: <?php if ( !empty( $crushing_text ) ) echo $crushing_text; ?></h3>
    </div>
    <div class="col-12 col-md-4 border-r">
        <div class="general-holder d-flex flex-column justify-content-center align-items-center">
            <p><?php _e('You’ve read', 'dkng');?></p>
            <label><?php echo $count_read;?></label>
            <p><?php _e('next-level insights', 'dkng');?></p>
        </div>
    </div>
    <div class="col-12 col-md-4 border-r">
        <div class="general-holder d-flex flex-column justify-content-center align-items-center">
            <p><?php _e('You’ve taken', 'dkng');?></p>
            <label><?php echo $count_completed; ?></label>
            <p><?php _e('lessons', 'dkng');?></p>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="general-holder d-flex flex-column justify-content-center align-items-center">
            <p><?php _e('You’ve shared', 'dkng');?></p>
            <label><?php echo $count_shared;?></label>
            <p><?php _e('items with clients', 'dkng');?></p>
        </div>
    </div>
</div>
<?php if ( !empty( $last_iteraction ) ) { ?>
    <div class="row">
        <div class="col-12 col-md-12">
            <h4><?php _e('Care to pick up where you left off?:', 'dkng');?>
                <a href="<?php echo $link_iteraction;?>"><?php echo $title_iteraction;?></a>
            </h4>
        </div>
    </div>
<?php } ?>