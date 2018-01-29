<div class="clear"></div>
<div class="postbox rpespcontainer" id="dashboard_right_now" >
    <h3 class="hndle"><?php echo __('Import Delivery Date Settings For Product', 'rpesp') ?></h3>
    <div class="inside">
        <div class="main">
            <div style="color:green;"><?php echo $message; ?></div>
            <form action="" name="import_shipping" method="post" enctype="multipart/form-data" >
                <table class="rp_table" >
                    <tr>
                        <td width="20%"><b><?php echo __('Upload File', 'rpesp') ?></b></td>
                        <td>
                            <input type="file" name="shipping_time"/>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">&nbsp;</td>
                        <td>
                            <input type="submit" name="import" class="button" value="<?php echo __('Import','rpesp') ?>"/>&nbsp;
                            <a href="<?php echo self::$plugin_url ?>assets/sample.csv" class="button"><?php echo __('Download Sample CSV' ,'rpesp') ?></a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>