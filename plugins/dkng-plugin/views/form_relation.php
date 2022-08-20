<?php
    $get_table_name = NULL;
    if ( $_GET['table'] ) {
        $get_table_name =  $_GET['table'];
    }

    $get_rate = \Dkng\Wp\Table::get_relation( $state['state_short_name'], $state1['state_short_name'], $get_table_name );
    $relations = json_decode( json_encode( $get_rate ), true );
    $rate = $relations[0]['rate'];
?>

<div class="show_form <?php echo $state['state_short_name'] . '-' . $state1['state_short_name'] ;?>" >
    <p class="rate_price"><?php echo $rate; ?></p>
    <div class="info"></div>
</div>

<div class="form_popup" data-class="<?php echo $state['state_short_name'] . '-' . $state1['state_short_name'] ;?>" >
    <h2>Matrix value:</h2>
    <h3>State1 = <?php echo $state['state_name']; // can be state_short_name ?>
    <br>
    State2 = <?php echo $state1['state_name']; // can be state_short_name ?></h3>
    <form method="post" action=""  class="form_relation_states"
          data-state1="<?php echo $state['state_short_name'];?>"
          data-state2="<?php echo $state1['state_short_name'];?>" >
        <p>
            <input type="text"
                   placeholder="Rate price (5.45; 5;...)"
                   name="rate"
                   class="rate_value"
                   value="<?php echo $rate; ?>"
            >
            <span class="error">Error</span>
            <span class="success">Success</span>
        </p>
        <p>
            <input type="submit" value="Submit">
        </p>
    </form>

    <div class="form_popup_close">Close</div>
</div>