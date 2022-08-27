<?php

get_header('custom');
$vacancies = get_field( 'vacancies', get_the_ID() );

?>
<div class="super_container vacancies_block">
    <div class="container content  ">

        <!-- Bread Crumbs -->
        <div class="row bread_menu">
            <?php custom_breadcrumbs( );  ?>
        </div>
        <!-- Bread Crumbs -->

        <div class="row1">
            <div class="block">
                <div class="container">
                    <h2 class="aligncenter"><?php echo get_the_title();?>:</h2>

                    <?php  echo apply_filters('the_content', get_the_content() ); ?>

                    <div class="table ">
                        <table >
                            <thead>
                                <th><?php echo get_field('thead_label1', get_the_ID() );?></th>
                                <th><?php echo get_field('thead_label2', get_the_ID() );?></th>
                            </thead>
                            <tbody>
                                <?php if ( !empty( $vacancies ) ) {
                                    foreach ( $vacancies as $vacancy ) { ?>
                                        <tr>
                                            <td><?php echo $vacancy['vacancy'];?></td>
                                            <td><?php echo $vacancy['count_hours'];?></td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="2"><?php echo get_field('no_vacancies', get_the_ID() );?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>


                </div>

            </div>
        </div>

    </div>
</div>
<?php get_footer('custom');
