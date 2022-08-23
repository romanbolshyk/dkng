<?php

get_header('custom');

$kerivnyky = get_field( 'bosses', get_the_ID() );
?>
<div class="super_container">
    <div class="container content ">

        <div class="white-element mb-100 page-template-podcast">
                <div class="row">
                    <div class="podcast_block-list">
                        <div class="container">
                            <h2>Список Керівників:</h2>
                            <?php foreach ( $kerivnyky as $boss ) {  ?>
                                <div class="podcast_block-item" data-num="1">
                                    <div class="podcast_block-item-image">
                                        <img src="<?php echo $boss['photo'];?>" alt="керівник" style="height: 100%;">
                                    </div>
                                    <div class="podcast_block-item-text">
                                        <div class="podcast_block-item-top-text">
                                            <h3><?php echo $boss['position'];?></h3>
                                        </div>
                                        <h4 class="podcast_block-item-t">
                                            <?php echo $boss['pib'];?>
                                        </h4>
                                        <div class="podcast_block-item-desc" style="margin-top: 10px;">
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
