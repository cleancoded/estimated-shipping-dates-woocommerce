<?php
$estMeta = get_post_meta($variation->ID, self::$meta_key, true);
?>
<p class="form-row hide_if_variation_virtual form-row-full">
    <label style="width:50%;display: inline;"><?php echo __('Enable Shipping Date For This Variation?', 'rpesp'); ?></label>
    <input type="checkbox" <?php echo (isset($estMeta['enable']) && $estMeta['enable'] == 1) ? 'checked=checked' : ""; ?> value="1" name="enable_shipping[<?php echo $variation->ID ?>]">
</p>
<p class="form-row hide_if_variation_virtual form-row-full">
    <label style="width:40%;display: inline;"><?php echo __('Estimation Time :', 'rpesp'); ?></label>
    <input style="width:20%;" type="text" value="<?php echo isset($estMeta['esttime']) ? $estMeta['esttime'] : ""; ?>" name="esttime_shipping[<?php echo $variation->ID ?>]"><small><i>&nbsp;In Day</i></small>
</p>
<p class="form-row hide_if_variation_virtual form-row-full">
    <label style="width:40%;display: inline;"><?php echo __('Estimated date text :', 'rpesp'); ?></label>
    <input style="width:20%;" type="text" value="<?php echo isset($estMeta['esttext']) ? $estMeta['esttext'] : ""; ?>" name="esttext_shipping[<?php echo $variation->ID ?>]"><br><small><i>&nbsp;Leave blank if you want to use global setting text</i></small>
</p>
