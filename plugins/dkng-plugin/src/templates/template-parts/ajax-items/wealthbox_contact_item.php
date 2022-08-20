<?php
$i++;
$contact_tags = array_column( $contact['tags'], 'name' );
$contact_tags = implode( ", ", $contact_tags );
?>
<tr>
    <td>
        <div class="sv-filter-table__td name_td">
            <input type="text" name="name-<?php echo $i;?>" value="<?php echo $contact['first_name'];?>" placeholder="">
        </div>
    </td>
    <td>
        <div class="sv-filter-table__td name_td">
            <input type="text" name="last_name-<?php echo $i;?>" value="<?php echo $contact['last_name'];?>" placeholder="">
        </div>
    </td>
    <td>
        <div class="sv-filter-table__td name_td">
            <div class="sv-filter-table__td email_td">
                <input type="email" name="email-<?php echo $i;?>" value="<?php echo $email;?>" placeholder="Email">
            </div>
        </div>
    </td>
    <td>
        <div class="sv-filter-table__td">
<!--            <input type="text" name="date---><?php //echo $i;?><!--" value="--><?php //echo date( 'm/d/Y');?><!--" readonly=""> -> Commented it for smaller request because data is default-current date-->
            <input type="text" value="<?php echo date( 'm/d/Y');?>" readonly="">
        </div>
    </td>
    <td>
        <div class="sv-filter-table__td">
            <span><?php echo $contact_tags;?></span>
        </div>
    </td>
    <td >
        <div class="sv-filter-table__td sv-filter-table__td text-right" style="min-height: 43px;">
            <span class="sv-checkbox sv-checkbox--empty">
                <input type="checkbox" id="contact-<?php echo $i;?>">
                <label for="contact-<?php echo $i;?>"></label>
                <input type="hidden" class="row-id" name="contact-<?php echo $i;?>">
            </span>
        </div>
    </td>
</tr>