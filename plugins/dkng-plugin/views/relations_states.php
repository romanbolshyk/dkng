<?php
    foreach ($states as $k => $v) {
        $get_rate = \Dkng\Wp\Table::get_relation( $current, $v['state_short_name'] );
        $relations = json_decode(json_encode($get_rate), true);
        $rate = $relations[0]['rate'];
        if ($v['state_short_name'] != $current) {  ?>

            <div class="form-block<?php echo $k?>" style="padding:10px;border: 1px solid black;">
                <form method="post" action=""  class="form_relation_states"
                      data-state1 = "<?php echo $current;?>"
                      data-state2 = "<?php echo $v['state_short_name'];?>" >
                    <p style="display: inline-block;width:10%;">
                        <a href = "<?php echo $_SERVER["SCRIPT_URI"]?>?page=rate_settings&state=<?php echo $v['state_short_name'];?>" >
                            <?php echo $v['state_name']; ?>
                        </a>
                    </p>
                    <p style="display: inline-block;width:20%;">
                        <input type="text"
                               placeholder="Rate price (5.45; 5;...)"
                               name="rate"
                               class="rate_value"
                               value="<?php echo $rate; ?>"
                        >
                        <span style="color: red; display: none;"   class="error">Error</span>
                        <span style="color: green; display: none;" class="success">Success</span>
                    </p>
                    <p style="display: inline-block;width:10%;text-align: right;">
                        <input type="submit" value="Submit">
                    </p>
                </form>
            </div>

            <?php
        }
    }
?>