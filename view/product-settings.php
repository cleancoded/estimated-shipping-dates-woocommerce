<?php
$estMeta = get_post_meta($thepostid, self::$meta_key, true);
?>
<style>
    #rpesp_product_data td{padding:10px;}
</style>
<div id="rpesp_product_data" class="panel woocommerce_options_panel">
    <table style="width:90%;">
        <tr>
            <td width="30%">
                <?php echo __('Enable for this product?', 'rpesp'); ?>
            </td>
            <td>
                <input type="checkbox" <?php echo (isset($estMeta['enable']) && $estMeta['enable'] == 1) ? 'checked=checked' : ""; ?> value="1" name="enable"><br>
            </td>
        </tr>
        <tr class="show_if_variable">
            <td>
                <?php echo __('Enable for each variation?', 'rpesp'); ?>
            </td>
            <td>
                <input type="checkbox" <?php echo (isset($estMeta['enable_for_variation']) && $estMeta['enable_for_variation'] == 1) ? 'checked=checked' : ""; ?> value="1" name="enable_for_variation"><br>
            </td>
        </tr>
        <tr valign="top">
            <td>
                <?php echo __('Estimation Time :', 'rpesp'); ?>
            </td>
            <td>
                <input type="text" value="<?php echo isset($estMeta['esttime']) ? $estMeta['esttime'] : ""; ?>" name="esttime"><small><i>&nbsp;In Day</i></small><br>
            </td>
        </tr>
        <tr valign="top">
            <td>
                <?php echo __('Estimated date text :', 'rpesp'); ?>
            </td>
            <td>
                <input type="text" value="<?php echo isset($estMeta['esttext']) ? $estMeta['esttext'] : ""; ?>" name="esttext"><br><br><small><i>&nbsp;Leave blank if you want to use global setting text.</i></small><br>
            </td>
        </tr>
    </table>
</div>