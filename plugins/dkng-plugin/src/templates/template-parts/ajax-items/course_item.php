<tr>
    <td>
        <a href="<?php echo get_permalink( $course->ID );?>" >
            <img src="<?php echo get_the_post_thumbnail_url( $course->ID, 'thumbnail' ); ?>" alt="img1"/>
        </a>
    </td>
    <td>
        <a href="<?php echo get_permalink( $course->ID );?>" ><?php echo $course->post_title; ?></a>
        <p class="grey"><?php echo $course->post_excerpt; ?></p>
    </td>
    <td><?php echo $number_lessons;?></td>
    <td><?php echo $status; ?></td>
    <td><?php echo get_the_date( 'Y/m/d', $course->ID ); ?></td>
    <td>
        <?php echo $cats_string; ?>
    </td>
    <td>
        <a class="btn btn-view read-course" data-course-id="<?php echo $course->ID;?>" href="<?php echo get_permalink( $course->ID );?>">
            <?php echo __( "View", "dkng" ); ?>
        </a>
    </td>
</tr>