<?php

get_header('custom');

$kerivnyky = get_field( 'bosses', get_the_ID() );
?>
<div class="inner_container">
    <div class="container content ">

        <div class="row">
            <?php
            $ingredients = array(
                'offset' => -3,
                'length' => 3,
                'root' => array(
                    'slug' => 'home',
                    'url' => get_home_url(),
                ),
            );
            the_bread( $ingredients );
            ?>
        </div>

        <div class="white-element page-template-announces">
            <div class="row">
                <div class="announces_block-list ">
                    <div class="container">
                        <h2>Список Керівників:</h2>
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
    </div>
</div>
<?php get_footer('custom');
