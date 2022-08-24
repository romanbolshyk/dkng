<?php

foreach ( $programs as $program ) {
    $speciality = get_field( 'speciality', $program );
    ?>
    <div class="announces_block-item" data-num="1">
        <h4><?php echo get_the_title( $speciality );?></h4>


        <div class="announces_block-item-text">
            <div class="announces_block-item-top-text">
                <h4>
                    <a href="<?php echo get_permalink( $program );?>">
                        <?php echo get_the_title( $program );?>
                    </a>
                </h4>
            </div>
            <h4 class="announces_block-item-t">
                <?php echo $program['pib'];?>
            </h4>
            <div class="announces_block-item-desc" style="margin-top: 10px;">
                <p><?php echo $program['position2'];?></p>
                <p><?php echo $program['phone'];?></p>
            </div>

        </div>
    </div>
<?php } ?>