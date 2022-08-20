<h3><?php echo __( 'Adjustment options', 'amerifreight' );?></h3>
<form action="" method="post" id="adjustment-form">
    <p><?php echo __( 'Action:', 'amerifreight' );?></p>
    <select name="action">
        <option value="plus">+</option>
        <option value="minus">-</option>
    </select>

    <p><?php echo __( 'Price:', 'amerifreight' );?></p>
    <input type="text" required name="price" placeholder="Price (5.55)">

    <p><?php echo __( 'Operation:', 'amerifreight' );?></p>
    <select name="operation">
        <option value="value">Value</option>
        <option value="percent">%</option>
    </select>

    <p><?php echo __( 'States:', 'amerifreight' );?></p>
    <p>
        <input type="radio" name="type_state" class="type_state" value="all" id="all" checked>
        <label for="all"><?php echo __( 'All states', 'amerifreight' );?></label>
        <input type="radio" name="type_state" class="type_state" value="states" id="states" >
        <label for="states"><?php echo __( 'Choose by state', 'amerifreight' );?></label>
    </p>
    <div class="states_from_to_block" style="display: none;">
        <p><?php echo __( 'State1:', 'amerifreight' );?></p>
        <select name="state_from">
            <option value="" selected>Choose state</option>
            <?php
            foreach ( $states as $v ) { ?>
                <option value="<?php echo $v['state_short_name'];?>">
                    <?php echo $v['state_name'];?>
                </option>
                <?php
            } ?>
        </select>
        <p><?php echo __( 'State2:', 'amerifreight' );?></p>
        <select name="state_to">
            <option value="" selected>Choose state</option>
            <?php
            foreach ( $states as $v ) { ?>
                <option value="<?php echo $v['state_short_name'];?>">
                    <?php echo $v['state_name'];?>
                </option>
                <?php
            } ?>
        </select>
    </div>

    <div class="tables">
        <p><?php echo __( 'Choose by table:', 'amerifreight' );?></p>
        <select name="table_name" required>
            <option value="" selected>Choose table</option>
            <?php  foreach ( $tables as $table ) {
                $disabled = ( $user_role == 'superadmin' ) ? "" : "disabled"; ?>
                <option value="<?php echo $table['name'];?>" <?php if ( $table['name'] == 'origin' ) echo $disabled; ?> >
                    <?php echo $table['name'];?>
                </option>
            <?php } ?>
        </select>
    </div>
    <p><input type="submit" value="Update"></p>
</form>
<p class="green" style="display: none;"></p>
<img src="<?php echo AMERI_T_URI;?>/assets/images/AjaxLoader.gif" alt="loader"
     style="width: 30px; height: auto; position: absolute; top: 10%; left: 44%; display: none;"
     id="loader-pic"
/>