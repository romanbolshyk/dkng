<?php

get_header('custom');

$obj        = new \Dkng\Wp\Specialities();
$categories = get_terms([
    'taxonomy'   => 'speciality_detail-category',
    'orderby'    => 'id',
    'hide_empty' => false,
]);

$post_id = ( get_queried_object_id() );

?>
<div class="super_container specialities_block">
    <div class="container content ">

        <!-- Bread Crumbs -->
        <div class="row bread_menu">
            <?php custom_breadcrumbs( );  ?>
        </div>
        <!-- Bread Crumbs -->

        <div class="white-element page-template-announces">
            <div class="row">
                <div class="announces_block-list inner_container w-100">
                    <div class="container">
                        <h2>Перелік спеціальностей та освітніх програм:</h2>

                        <?php foreach ( $categories as $category ) { ?>
                            <?php  $programs = $obj->get_programs( $category, -1 ); ?>

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
                                            $programs_array = [];
                                            foreach ( $programs as $program ) {
                                                $speciality = get_field('speciality', $program);
                                                $programs_array[$speciality][] = $program;
                                            }

                                            foreach ( $programs_array as $k => $v ) { ?>
                                                <tr>
                                                    <td style="border-right: 5px solid #fff !important;">
                                                        <?php echo get_the_title( $k );?>
                                                    </td>
                                                    <td>
                                                        <?php foreach ( $v as $v1 ) { ?>
                                                            <p >
                                                                <a href="<?php echo get_permalink( $v1 );?>">
                                                                    <?php echo get_the_title( $v1 );?>
                                                                </a>
                                                            </p>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr/>
                        <?php  } ?>


                        <p style="margin-top: 20px;">
                            <a href="<?php echo get_permalink( get_field( 'spec_page_link', $post_id ) );?>">
                                <?php echo get_field( 'spec_page_text',  $post_id );?>
                            </a>
                        </p>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<?php get_footer('custom');
