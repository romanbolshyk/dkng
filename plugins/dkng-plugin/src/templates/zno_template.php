<?php

get_header('custom');

$repeater = get_field( 'repeater', get_the_ID() );
$i = 0;
?>
<div class="super_container specialities_block">
    <div class="container content ">

        <div class="white-element mb-100 page-template-announces">

            <!-- Bread Crumbs -->
            <div class="row bread_menu">
                <?php custom_breadcrumbs( );  ?>
            </div>
            <!-- Bread Crumbs -->

            <div>
                <div class="announces_block-list zno_templates" >
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <h2><?php echo get_the_title();?></h2>
                            </div>
                        </div>

                        <?php   foreach ( $repeater as $i => $val ) {
                            if ( ( $i == 0 ) || ( $i % 2 ) == 0 ) { ?>
                                <div class="row">
                            <?php  } ?>

                                <div class="col-lg-6">
                                    <div class="box">
                                        <h4>
                                            <a href="<?php echo $val['link'];?>"> <img src="<?php echo $val['photo'];?>" height="65"></a>
                                        </h4>
                                        <h5> <a href="<?php echo $val['link'];?>"><?php echo $val['text'];?></a></h5>
                                    </div>
                                </div>

                            <?php if ( ( $i % 2 ) != 0 ) { ?>
                                </div>
                            <?php
                            }
                        } ?>

                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<?php get_footer('custom');
