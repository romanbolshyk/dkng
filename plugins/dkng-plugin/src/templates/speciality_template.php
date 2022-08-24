<?php

get_header('custom');

$obj = new \Dkng\Wp\Specialities();
$categories = $obj->get_terms_by_custom_post_type( 'speciality_detail', 'speciality_detail-category');

wp_reset_postdata();
global $post;

?>
<div class="super_container specialities_block">
    <div class="container content ">

        <div class="white-element mb-100 page-template-announces">
            <div class="row">
                <div class="announces_block-list">
                    <div class="container">
                        <h2>Перелік спеціальностей та освітніх програм:</h2>

                        <?php foreach ( $categories as $category ) { ?>
                            <?php  $programs = $obj->get_programs( $category ); ?>

                            <div class="block" style="margin-top: 30px;">
                                <h3 class="sv-title"><b><?php echo $category->name;?></b></h3>

                                <div class="sv-container">
                                    <table class="sv-table">
                                    <thead>
                                        <tr>
                                            <th style="border-right: 5px solid #fff !important;">Шифр та назва спеціальності</th>
                                            <th>Назва освітньо-професійної програми</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ( $programs as $program ) {
                                            $speciality = get_field( 'speciality', $program );
                                        ?>
                                            <tr>
                                                <td style="border-right: 5px solid #fff !important;">
                                                    <?php echo get_the_title( $speciality );?>
                                                </td>
                                                <td >
                                                    <a href="<?php echo get_permalink( $program );?>">
                                                        <?php echo get_the_title( $program );?>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>

                        <?php  } ?>

                        <hr/>
                        <p style="margin-top: 20px;">
                            <a href="<?php echo get_permalink( get_field( 'page_link', $post->ID ) );?>">
                                <?php echo get_field( 'page_text', $post->ID );?>
                            </a>
                        </p>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<?php get_footer('custom');
