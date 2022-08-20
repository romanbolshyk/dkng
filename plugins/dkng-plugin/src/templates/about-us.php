<?php
get_header('custom');

$first_block      = get_field( 'first_block');
$story_block      = get_field( 'story_block');
$beliefs_block    = get_field( 'beliefs_block');
$speciality_block = get_field( 'speciality_block');
$problem_solvers  = get_field( 'problem_solvers');
$work_block       = get_field( 'work_block');
?>

        <div class="inner_container about_block">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="inner_content">
                            <div class="row">
                                <div class="col-lg-8 col-sm-12">
                                    <h4><?php if ( $first_block['title'] ) echo $first_block['title']; ?></h4>

                                    <h1><?php if ( $first_block['text'] ) echo $first_block['text']; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ( $story_block ) { ?>
        <div class="smaller-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <?php
                        $story_img_id = get_image_id( $story_block['image'] );
                        $story_img_alt = get_post_meta($story_img_id, '_wp_attachment_image_alt', TRUE);
                        ?>
                        <img src="<?php if ( $story_block['image'] ) echo $story_block['image'];?>" alt="<?php echo esc_attr( $story_img_alt ); ?>"/>

                        <div class="our-story">
                            <h2><?php if ( $story_block['title'] ) echo $story_block['title'];?></h2>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <p class="bigger"><?php if ( $story_block['text']) echo $story_block['text'];?> </p>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ( $beliefs_block ) { ?>
        <div class="smaller-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h2><?php if ( $beliefs_block['title'] ) echo $beliefs_block['title'];?></h2>
                    </div>
                </div>

                <?php if ( !empty( $beliefs_block['beliefs'] ) ) {
                    $i == 0; ?>
                    <?php foreach ( $beliefs_block['beliefs'] as $beliefs ) {
                        $i++; ?>
                        <?php if ( ( $i == 1 ) || ( $i == 4 ) || ( $i == 7 )  ) { ?>
                            <div class="row">
                        <?php  } ?>

                            <div class="col-lg-4">
                                <div class="box">
                                    <h4><?php if ( $beliefs['title'] ) echo $beliefs['title'];?></h4>
                                    <p><?php if ( $beliefs['text'] ) echo $beliefs['text'];?></p>
                                </div>
                            </div>

                        <?php if ( ( $i % 3 ) == 0  ) { ?>
                            </div>
                        <?php } ?>

                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <?php if ( $speciality_block ) { ?>
        <div class="default-padding our-philosophy">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <h2><?php if ( $speciality_block['title'] ) echo $speciality_block['title'];?></h2>
                    </div>
                    <div class="col-lg-8">
                        <p class="bigger"><?php if ( $speciality_block['text'] ) echo $speciality_block['text'];?></p>
                    </div>
                </div>

                <?php if ( !empty( $speciality_block['specialities'] ) ) { ?>
                    <?php foreach ( $speciality_block['specialities'] as $i => $specialities ) { ?>
                        <?php if ( ( $i % 2 ) == 0 )  { ?>
                            <div class="row">
                        <?php  } ?>

                            <div class="col-lg-6 d-flex ">
                                <div class="left-icon">
                                    <?php
                                    $specialities_img_id = get_image_id( $specialities['image'] );
                                    $specialities_img_alt = get_post_meta($specialities_img_id, '_wp_attachment_image_alt', TRUE);
                                    ?>
                                    <img src="<?php if ( $specialities['image'] ) echo $specialities['image'];?>" alt="<?php echo esc_attr( $specialities_img_alt ); ?>"/>
                                </div>
                                <div>
                                    <h3><?php if ( $specialities['title'] ) echo $specialities['title'];?></h3>
                                    <p><?php if ( $specialities['text'] )   echo $specialities['text'];?></p>
                                </div>
                            </div>

                        <?php if ( ( $i % 2 ) != 0 ) { ?>
                            </div>
                        <?php } ?>

                    <?php } ?>
                <?php } ?>

                <?php if ( $problem_solvers ) { ?>
                    <div class="row">
                        <div class="box big">
                            <h2 class="h1">
                                <?php if ( $problem_solvers['text'] ) echo $problem_solvers['text'];?>
                                <span><?php if ( $problem_solvers['main_text'] ) echo $problem_solvers['main_text'];?></span>
                            </h2>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    <?php } ?>
    <?php if ( $work_block ) { ?>
        <div class="smaller-padding smaller-padding--bottom-0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 d-flex flex-column justify-content-center">
                        <h2><?php if ( $work_block['title'] ) echo $work_block['title'];?></h2>
                        <p class="bigger"><?php if ( $work_block['text'] ) echo $work_block['text'];?></p>
                    </div>
                    <div class="col-lg-6 offset-lg-1 left-border-with-circles">
                        <?php if ( !empty( $work_block['items'] ) ) { ?>
                            <?php foreach ( $work_block['items'] as $i => $item ) { ?>
                                <div class="d-flex">
                                    <div class="left-icon">
                                        <?php
                                        $item_img_id = get_image_id( $item['image'] );
                                        $item_img_alt = get_post_meta($item_img_id, '_wp_attachment_image_alt', TRUE);
                                        ?>
                                        <img src="<?php if ( $item['image'] ) echo $item['image'];?>" alt="<?php echo  esc_attr( $item_img_alt ); ?>"/>
                                    </div>
                                    <div>
                                        <h3><?php if ( $item['text'] ) echo $item['text'];?></h3>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php
get_footer('custom');
//get_footer();
wp_footer();