<?php

get_header('custom');

$kerivnyky = get_field( 'bosses', get_the_ID() );

$obj = new \Dkng\Wp\Specialities();

$categories = $obj->get_terms_by_custom_post_type( 'speciality_detail', 'speciality_detail-category');

?>
<div class="super_container specialities_block">
    <div class="container content ">

        <div class="white-element page-template-announces">
            <div class="row">
                <div class="announces_block-list">
                    <div class="container">
                        <h2>Перелік спеціальностей та освітніх програм:</h2>

                        <?php foreach ( $categories as $category ) { ?>

                            <?php
                            $programs = $obj->get_programs( $category );
                            //require 'template-parts/specialities/perelik_specialnostey.php';
                            ?>

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
                                                <td data-th="Campaign Title">
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

                        <?php foreach ( $kerivnyky as $boss ) {  ?>
                            <div class="announces_block-item" data-num="1">
                                <div class="announces_block-item-image">
                                    <img src="<?php echo $boss['photo'];?>" alt="керівник" style="height: 100%;">
                                </div>
                                <div class="announces_block-item-text">
                                    <div class="announces_block-item-top-text">
                                        <h3><?php echo $boss['position'];?></h3>
                                    </div>
                                    <h4 class="announces_block-item-t">
                                        <?php echo $boss['pib'];?>
                                    </h4>
                                    <div class="announces_block-item-desc" style="margin-top: 10px;">
                                        <p><?php echo $boss['position2'];?></p>
                                        <p><?php echo $boss['phone'];?></p>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>

        <div class="white-element mb-100 vypysknyky_rows">
            <div class="row">

                <?php foreach ( $kerivnyky as $boss ) {  ?>
                    <div class="col-12 col-md-6 col-xl-3  item">
                        <div class="white-element grey-bg-sect strategies-holder status-new d-flex flex-column justify-content-start align-items-center"
                        >
                            <img src="<?php echo $boss['photo'];?>" alt="icon-hands" class="photo" >
                            <div class="point-holder d-flex flex-row justify-content-center align-items-center">
                                <div class="point-dot"></div>
                                <div class="point-dot"></div>
                                <div class="point-dot"></div>
                                <div class="point-dot"></div>
                                <div class="point-dot"></div>
                                <div class="point-dot"></div>
                            </div>
                            <p>
                                <b><?php echo $boss['pib'];?></b>
                            </p>
                            <p class="grey" style="font-size: 80%;">
                                <?php echo $boss['position'];?>
                            </p>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
<?php get_footer('custom');
