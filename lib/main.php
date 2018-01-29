<?php
if (!class_exists('RpEestimatedDeliveryDate')) {

    class RpEestimatedDeliveryDate {

        private static $plugin_url;
        private static $plugin_dir;
        private static $plugin_title = "Product Est Date";
        private static $plugin_slug = "rpesp-setting";
        private static $rpesp_option_key = "rpesp-setting";
        private static $meta_key = "rpesp-meta-setting";
        private static $order_item_meta_key = "_rpesp-item-deliverydate";
        private static $order_variation_enable_meta_key = "_rpesp-enable-datevariation";
        private static $day;
        private static $month;
        private $rpesp_settings;
        public static $default_setting = array(
            "text_pos" => "1",
            "estimate_text" => "Delivery on {date}",
            "text_order" => "Delivery on {date}",
            "date_format" => "d, F Y",
            "text_color" => "#000000",
            "text_size" => "12",
        );

        public function __construct()
        {
            global $rpesp_plugin_dir, $rpesp_plugin_url;

            /* plugin url and directory variable */
            self::$plugin_dir = $rpesp_plugin_dir;
            self::$plugin_url = $rpesp_plugin_url;
            self::$day = array(
                '0' => __("Sunday", "rpesp"),
                '1' => __("Monday", "rpesp"),
                '2' => __("Tuesday", "rpesp"),
                '3' => __("Wednesday", "rpesp"),
                '4' => __("Thursday", "rpesp"),
                '5' => __("Friday", "rpesp"),
                '6' => __("Saturday", "rpesp"),
            );
            self::$month = array(
                '01' => __('January', 'rpesp'),
                '02' => __('February', 'rpesp'),
                '03' => __('March', 'rpesp'),
                '04' => __('April', 'rpesp'),
                '05' => __('May', 'rpesp'),
                '06' => __('June', 'rpesp'),
                '07' => __('July', 'rpesp'),
                '08' => __('August', 'rpesp'),
                '09' => __('September', 'rpesp'),
                '10' => __('October', 'rpesp'),
                '11' => __('November', 'rpesp'),
                '12' => __('December', 'rpesp'),
            );

            /* load delivery date  setting */
            $this->rpesp_settings = get_option(self::$rpesp_option_key);


            /* admin menu for delivery date */
            add_action("admin_menu", array($this, "adminMenu"));
            add_action("init", array($this, "initAction"));
            add_action("admin_init", array($this, "adminInit"));
            add_action("wp_enqueue_scripts", array($this, "Init"),100);

            add_filter('woocommerce_product_write_panel_tabs', array($this, 'addTabOnAdminProductPage'));
            add_filter('woocommerce_product_data_panels', array($this, 'settingOnProductPage'));
            add_action('woocommerce_process_product_meta', array($this, 'saveMeta'));
            add_filter('woocommerce_hidden_order_itemmeta', array($this, 'hideDateMeta'), 10, 1);


            $this->initHook();
        }

        public function initAction()
        {
            if (version_compare(WOOCOMMERCE_VERSION, "3.0") <= 0) {
                add_action('woocommerce_order_item_meta_start', array($this, 'displayOrderItemMetaForCustomer'), 10, 2);
            }
        }

        public function Init()
        {
            wp_enqueue_script('rp-delivery-date-front', self::$plugin_url . "assets/js/product-delivery.js",array('jquery'),false,true);
        }

        public function initHook()
        {
            if ($this->get_setting("enable_delivery_date") != 1) {
                return;
            }

            if ($this->get_setting("text_pos") == 1) {
                add_action('woocommerce_single_product_summary', array($this, 'dispalyDateOnProductPage'), 30);
            } elseif ($this->get_setting("text_pos") == 2) {
                add_action('woocommerce_single_product_summary', array($this, 'dispalyDateOnProductPage'), 20);
            } elseif ($this->get_setting("text_pos") == 3) {
                add_action('woocommerce_single_product_summary', array($this, 'dispalyDateOnProductPage'), 40);
            } else {
                add_action('woocommerce_single_product_summary', array($this, 'dispalyDateOnProductPage'), 8);
            }
            add_action('wp_head', array($this, "wpHead"));
            add_filter('woocommerce_cart_item_name', array($this, 'displayOnCart'), 10, 2);
            add_action('woocommerce_add_order_item_meta', array($this, 'saveItemMeta'), 10, 2);

            add_filter('woocommerce_before_order_itemmeta', array($this, 'displayOrderItemMeta'), 10, 2);
            add_action('woocommerce_product_after_variable_attributes', array($this, 'variable_pricefields'), 10, 3);
            add_action('woocommerce_save_product_variation', array($this, 'save_price_fields_for_variation'), 10, 1);
            add_action('woocommerce_order_item_meta_start', array($this, 'send_estimationdate_inemail'), 10, 1);

            add_action('woocommerce_product_bulk_edit_end', array($this, 'output_bulk_product_delivery_fields'));
            add_action('woocommerce_product_bulk_edit_save', array($this, 'save_bulk_product_delivery_fields'));


            add_action('manage_product_posts_custom_column', array($this, 'output_quick_product_delivery_values'));
            add_action('woocommerce_product_quick_edit_end', array($this, 'output_quick_product_delivery_fields'));
            add_action('woocommerce_product_quick_edit_save', array($this, 'save_quick_product_delivery_fields'));
        }

        public function save_quick_product_delivery_fields($product)
        {
            $product_id = $product->id;

            if ($product_id > 0) {
                $enable_for_variation = isset($_REQUEST['enable_delivery_date_variation']) ? 1 : 0;
                $enable = isset($_REQUEST['enable_delivery_date']) ? 1 : 0;
                update_post_meta($product_id, self::$meta_key, array('enable_for_variation' => $enable_for_variation, 'esttime' => $_REQUEST['est_delivery_time'], 'esttext' => $_REQUEST['est_delivery_text'], 'enable' => $enable));
            }
        }

        public function output_quick_product_delivery_fields()
        {
            include self::$plugin_dir . "view/quick-product-settings.php";
        }

        public function output_quick_product_delivery_values($column)
        {
            global $post;

            $product_id = $post->ID;
            $estMeta = get_post_meta($product_id, self::$meta_key, true);
            if ($column == 'name') {
                ?>
                <div class="hidden" id="rpwoo_product_delivery_inline_<?php echo $product_id; ?>">
                    <div class="_delivery_enable"><?php echo isset($estMeta['enable']) ? $estMeta['enable'] : ""; ?></div>
                    <div class="_delivery_enable_for_variation"><?php echo isset($estMeta['enable_for_variation']) ? $estMeta['enable_for_variation'] : ""; ?></div>
                    <div class="_delivery_esttime"><?php echo isset($estMeta['esttime']) ? $estMeta['esttime'] : ""; ?></div>
                    <div class="_delivery_esttext"><?php echo isset($estMeta['esttext']) ? $estMeta['esttext'] : ""; ?></div>
                </div>
                <?php
            }
        }

        public function output_bulk_product_delivery_fields()
        {
            include self::$plugin_dir . "view/bulk-product-settings.php";
        }

        public function save_bulk_product_delivery_fields($product)
        {
            $product_id = $product->id;
            if ($product_id > 0) {
                $enable_for_variation = isset($_REQUEST['enable_delivery_date_variation']) ? 1 : 0;
                $enable = isset($_REQUEST['enable_delivery_date']) ? 1 : 0;
                update_post_meta($product_id, self::$meta_key, array('enable_for_variation' => $enable_for_variation, 'esttime' => $_REQUEST['est_delivery_time'], 'esttext' => $_REQUEST['est_delivery_text'], 'enable' => $enable));
            }
        }

        public function send_estimationdate_inemail($item_id)
        {
            if ($this->get_setting('enable_on_orderpage') != 1) {
                return;
            }

            $dateMeta = wc_get_order_item_meta($item_id, self::$order_item_meta_key, true);
            if (!empty($dateMeta)) {
                echo "<br>" . $this->getEstimaedTextForEmail($dateMeta);
            }
        }

        function variable_pricefields($loop, $variation_data, $variation)
        {
            include self::$plugin_dir . 'view/product-variation-settings.php';
        }

        function save_price_fields_for_variation($post_id)
        {

            if (isset($_POST['esttime_shipping'][$post_id]) && trim($_POST['esttime_shipping'][$post_id]) != "") {
                $enable = isset($_POST['enable_shipping'][$post_id]) ? 1 : 0;
                update_post_meta($post_id, self::$meta_key, array('esttime' => $_POST['esttime_shipping'][$post_id], 'esttext' => $_POST['esttext_shipping'][$post_id], 'enable' => $enable));
            }
        }

        public function importShippingTime()
        {
            if (isset($_POST['import'])) {
                $temp = explode(".", $_FILES["shipping_time"]["name"]);
                $extension = strtolower(end($temp));
                if ($extension == "csv") {
                    $file_handle = fopen($_FILES["shipping_time"]["tmp_name"], "r");
                    while (!feof($file_handle)) {
                        $line_of_text = fgetcsv($file_handle, 0);
                        if (!isset($line_of_text[0]) || !is_numeric($line_of_text[0]) || !isset($line_of_text[1]) || !is_numeric($line_of_text[1]) || !isset($line_of_text[2]) || !is_numeric($line_of_text[2])) {
                            continue;
                        }
                        $enable_for_variation = isset($line_of_text[3]) ? $line_of_text[3] : 0;
                        update_post_meta($line_of_text[0], self::$meta_key, array('enable_for_variation' => $enable_for_variation, 'esttime' => $line_of_text[2], 'esttext' => $line_of_text[4], 'enable' => $line_of_text[1]));
                    }
                    fclose($file_handle);
                    $message = "Imported successfully.";
                } else {
                    $message = "Invalid file formate.";
                }
            }
            include_once self::$plugin_dir . 'view/import.php';
        }

        public function wpHead()
        {
            ?>
            <style type="text/css">
                .rp_estimated_date{
                    color:<?php echo $this->get_setting('text_color'); ?>;
                    font-size:<?php echo $this->get_setting('text_size'); ?>px;
                }
                .date_for_variation{display:none;}
            </style>
            <?php
        }

        public function displayOrderItemMetaForCustomer($item_id, $item)
        {
            if ($this->get_setting('enable_on_orderemail') != 1) {
                return;
            }

            $dateMeta = wc_get_order_item_meta($item_id, self::$order_item_meta_key, true);
            if (!empty($dateMeta)) {
                echo $this->getEstimaedTextForOrderPage($dateMeta);
            }
        }

        public function displayOrderItemMeta($item_id, $item)
        {

            $dateMeta = wc_get_order_item_meta($item_id, self::$order_item_meta_key, true);
            if (!empty($dateMeta)) {
                echo $this->getEstimaedTextForOrderPage($dateMeta);
            }
        }

        public function hideDateMeta($arr)
        {
            $arr[] = self::$order_item_meta_key;
            $arr[] = self::$order_variation_enable_meta_key;
            return $arr;
        }

        function saveItemMeta($item_id, $cart_item)
        {

            $product_item_id = $cart_item['product_id'];
            $estSetting = get_post_meta($product_item_id, self::$meta_key, true);

            if (isset($cart_item['variation_id']) && $cart_item['variation_id'] > 0 && isset($estSetting['enable_for_variation']) && $estSetting['enable_for_variation'] == 1) {
                $product_item_id = $cart_item['variation_id'];
            }
            $estDay = $this->getEstimatedDateForProduct($product_item_id);
            woocommerce_add_order_item_meta($item_id, self::$order_item_meta_key, $estDay);
        }

        public function displayOnCart($title, $values)
        {
            if ($this->get_setting('enable_on_cart') != 1) {
                return $title;
            }

            if (!$values || !$values['data']) {
                return $title;
            }

            $_product = $values['data'];
            if (version_compare(WOOCOMMERCE_VERSION, "3.0") >= 0 && $_product->get_parent_id()) {
                $product_id = $_product->get_parent_id();
            } else {
                $product_id = $_product->get_id();
            }

            $estSetting = get_post_meta($product_id, self::$meta_key, true);
            if (version_compare(WOOCOMMERCE_VERSION, "3.0") <= 0) {
                if ($_product->variation_id && isset($estSetting['enable_for_variation']) && $estSetting['enable_for_variation'] == 1) {
                    $product_id = $_product->variation_id;
                }
            } else {
                if (isset($estSetting['enable_for_variation']) && $estSetting['enable_for_variation'] == 1) {
                    $product_id = $_product->get_id();
                }
            }


            $estDay = $this->getEstimatedDateForProduct($product_id);

            if ($estDay !== false) {
                return $title . $this->getEstimaedText($estDay, $product_id);
            }

            return $title;
        }

        public function getEstTimeSetting($estTime)
        {

            $endHours = $this->get_setting('hours');
            $endMinute = $this->get_setting('minute');
            if ($endHours == "") {
                return $estTime + 1;
            }

            $endDeliveryTime = strtotime(date("Y-m-d") . " " . $endHours . ":" . $endMinute . ":00");
            $currentDay = time();
            if ($currentDay > $endDeliveryTime) {
                $estTime = $estTime + 2;
            } else {
                $estTime = $estTime + 1;
            }
            return $estTime;
        }

        public function dispalyDateOnProductPage()
        {

            global $product;
            $estSetting = get_post_meta($product->get_id(), self::$meta_key, true);
            
            if ($product->is_type('variable') && isset($estSetting['enable_for_variation']) && $estSetting['enable_for_variation'] == 1) {
                $chidData = $product->get_children();
                
                if (count($chidData) > 0) {
                    foreach ($chidData as $variation_id) {
                        $variation_obj = new WC_Product_variation($variation_id);
                        if ($this->get_setting("hide_out_of_stock") == 1 && !$variation_obj->is_in_stock()) {
                            continue;
                        }
                        $estDay = $this->getEstimatedDateForProduct($variation_id);
                        if ($estDay !== false) {
                            echo $this->getEstimaedTextForVariableProduct($estDay, $variation_id);
                        }
                    }
                }
            } else {
                if ($this->get_setting("hide_out_of_stock") == 1 && !$product->is_in_stock()) {
                    return;
                }
                $estDay = $this->getEstimatedDateForProduct($product->get_id());
                if ($estDay !== false) {
                    echo $this->getEstimaedText($estDay, $product->get_id());
                }
            }
        }

        public function getDateDiff($estDay)
        {
            $date1 = date_create(date('Y-m-d'));
            $date2 = date_create(date('Y-m-d', $estDay));
            $diff = date_diff($date1, $date2);
            return $diff->format("%a");
        }

        public function getEstimaedText($estDay, $product_id)
        {
            $estSetting = get_post_meta($product_id, self::$meta_key, true);
            $settingText = (isset($estSetting['esttext']) && trim($estSetting['esttext']) != "") ? $estSetting['esttext'] : $this->get_setting('estimate_text');

            $numberOfDay = $this->getDateDiff($estDay);
            $response = str_replace(array('{d}', '{date}'), array($numberOfDay, date_i18n($this->get_setting('date_format'), $estDay)), $settingText);
            $response = $this->pregReplaceDate($estDay, $response);
            return '<div class="rp_estimated_date">' . $response . '</div>';
        }

        public function pregReplaceDate($estDay, $response)
        {
            $this->estDay = $estDay;
            $response = preg_replace_callback("/{(.*?)([+-])(.*?)}/", array($this, 'callbackPregReplace'), $response);
            return $response;
        }

        public function callbackPregReplace($matches)
        {
            if (!isset($matches[1]) || !isset($matches[2]) || !isset($matches[3])) {
                return $matches[0];
            }

            if (!in_array(trim($matches[1]), array('d', 'date'))) {
                return $matches[0];
            }

            if (!in_array(trim($matches[2]), array('+', '-'))) {
                return $matches[0];
            }


            if (trim($matches[2]) == "-") {
                $estDay = $this->estDay - (trim($matches[3]) * 86400);
            } else {
                $estDay = $this->estDay + (trim($matches[3]) * 86400);
            }

            $this->estDay = $this->isOffDay($estDay);



            if (trim($matches[1]) == "date") {
                return date($this->get_setting('date_format'), $this->estDay);
            } else {
                $numberOfDay = $this->getDateDiff($this->estDay);
                return $numberOfDay;
            }

            return $matches[0];
        }

        public function isOffDay($estDay)
        {
            $blockDate = $this->getBlockDates();
            $blockWeekday = $this->get_block_weekday();
            $weekDay = date('w', $estDay);
            if (in_array($estDay, $blockDate) || in_array($weekDay, $blockWeekday)) {
                $estDay = $estDay + 86400;
                $estDay = $this->isOffDay($estDay);
            }
            return $estDay;
        }

        public function getEstimaedTextForVariableProduct($estDay, $product_id)
        {
            $estSetting = get_post_meta($product_id, self::$meta_key, true);
            $settingText = (isset($estSetting['esttext']) && trim($estSetting['esttext']) != "") ? $estSetting['esttext'] : $this->get_setting('estimate_text');
            $numberOfDay = $this->getDateDiff($estDay);
            $response = str_replace(array('{d}', '{date}'), array($numberOfDay, date_i18n($this->get_setting('date_format'), $estDay)), $settingText);
            $response = $this->pregReplaceDate($estDay, $response);
            return '<div class="rp_estimated_date date_variation_' . $product_id . ' date_for_variation">' . $response . '</div>';
        }

        public function getEstimaedTextForOrderPage($estDay)
        {
            $settingText = $this->get_setting('text_order');
            $response = str_replace('{date}', date_i18n($this->get_setting('date_format'), $estDay), $settingText);
            $response = $this->pregReplaceDate($estDay, $response);
            return '<div class="rp_estimated_date">' . $response . '</div>';
        }

        public function getEstimaedTextForEmail($estDay)
        {
            $settingText = $this->get_setting('text_order');
            $response = str_replace('{date}', date_i18n($this->get_setting('date_format'), $estDay), $settingText);
            $response = $this->pregReplaceDate($estDay, $response);
            return '<small>' . $response . '</small>';
        }

        public function getEstimatedDateForProduct($product_id)
        {

            $estSetting = get_post_meta($product_id, self::$meta_key, true);

            if (empty($estSetting)) {
                return false;
            }

            if (!isset($estSetting['enable']) || $estSetting['enable'] != 1) {
                return false;
            }

            if (!isset($estSetting['esttime']) || $estSetting['esttime'] == "" || !is_numeric($estSetting['esttime'])) {
                return false;
            }

            $estTime = $this->getEstTimeSetting($estSetting['esttime']);
            $blockDate = $this->getBlockDates();
            $blockWeekday = $this->get_block_weekday();
            $estDateCount = 0;
            $totalDayCount = 0;
            $currentDay = strtotime(date('Y-m-d'));
            while ($estTime > $estDateCount) {
                $estDay = strtotime('+' . $totalDayCount . ' day', $currentDay);
                $weekDay = date('w', $estDay);
                if (!in_array($estDay, $blockDate) && !in_array($weekDay, $blockWeekday)) {
                    $estDateCount++;
                }
                $totalDayCount++;
            }
            return $estDay;
        }

        public function getBlockDates()
        {
            $specificBlockDate = $this->get_specific_blockday();
            $periodBlockDate = $this->get_period_blockday();
            $blockDate = array_merge($specificBlockDate, $periodBlockDate);
            return $blockDate;
        }

        public function settingOnProductPage()
        {

            global $thepostid, $post;

            if (!$thepostid)
                $thepostid = $post->ID;


            include_once self::$plugin_dir . "view/product-settings.php";
        }

        /**
         * Updating post meta.
         *
         * @param $post_id
         */
        public function saveMeta($post_id)
        {
            if (isset($_POST['esttime'])) {
                $enable = isset($_POST['enable']) ? 1 : 0;
                $enable_for_variation = isset($_POST['enable_for_variation']) ? 1 : 0;
                update_post_meta($post_id, self::$meta_key, array('enable_for_variation' => $enable_for_variation, 'esttime' => $_POST['esttime'], 'esttext' => $_POST['esttext'], 'enable' => $enable));
            }
        }

        public function addTabOnAdminProductPage()
        {

            $style = '';

            if (version_compare(WOOCOMMERCE_VERSION, "2.1.0") >= 0) {
                $style = 'style = "padding: 10px !important"';
            }

            echo '<li class="rpesp_tab rpestimation_options"><a href="#rpesp_product_data" ' . $style . '>' . __('Product EST Date', 'wc_rpesp_setting') . '</a></li>';
        }

        /**
         * get block days
         *
         * @return Mixed
         */
        public function get_block_weekday()
        {
            $weekday_block = array();
            $weekday = $this->get_setting('weekdayoff');
            if ($weekday && !empty($weekday)) {
                foreach ($weekday as $bday):
                    $weekday_block[] = intval($bday);
                endforeach;
            }
            return $weekday_block;
        }

        public function get_specific_blockday()
        {
            $specificday_block = array();

            $blockday = $this->get_setting('specific_day');

            if ($blockday && !empty($blockday['day']) && count($blockday['day']) > 0) {
                for ($i = 0; $i < count($blockday['day']); $i++):
                    if ($blockday['day'][$i] == 0)
                        continue;
                    if ($blockday['month'][$i] == 0)
                        continue;
                    if ($blockday['year'][$i] == 0)
                        continue;
                    $date = $blockday['year'][$i] . "-" . $blockday['month'][$i] . "-" . $blockday['day'][$i];

                    $specificday_block[] = strtotime($date);
                endfor;
            }

            return $specificday_block;
        }

        /* return period block day */

        public function get_period_blockday()
        {
            $blockDates = array();
            $blockPeriod = $this->get_setting('specific_period');
            if ($blockPeriod && !empty($blockPeriod['fday']) && count($blockPeriod['fday']) > 0) {
                for ($i = 0; $i < count($blockPeriod['fday']); $i++):
                    if ($blockPeriod['fday'][$i] == 0 || $blockPeriod['fmonth'][$i] == 0 || $blockPeriod['fyear'][$i] == 0 || $blockPeriod['tday'][$i] == 0 || $blockPeriod['tmonth'][$i] == 0 || $blockPeriod['tyear'][$i] == 0) {
                        continue;
                    }
                    $fromDate = $blockPeriod['fyear'][$i] . "-" . $blockPeriod['fmonth'][$i] . "-" . $blockPeriod['fday'][$i];
                    $toDate = $blockPeriod['tyear'][$i] . "-" . $blockPeriod['tmonth'][$i] . "-" . $blockPeriod['tday'][$i];
                    $fromTimeDate = strtotime($fromDate);
                    $toTimeDate = strtotime($toDate);

                    if ($fromTimeDate > $toTimeDate) {
                        continue;
                    }

                    while ($fromTimeDate <= $toTimeDate) {
                        $blockDates[] = $fromTimeDate;
                        $fromTimeDate = strtotime('+1 day', $fromTimeDate);
                    }
                endfor;
            }
            return $blockDates;
        }

        public function adminInit()
        {
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('rpesp-admin', self::$plugin_url . "assets/js/admin.js", array('wp-color-picker'));
            wp_enqueue_style('rpesp-admin', self::$plugin_url . "assets/css/admin.css");
        }

        public function adminMenu()
        {
            $wc_page = 'woocommerce';
            add_submenu_page($wc_page, self::$plugin_title, self::$plugin_title, "install_plugins", self::$plugin_slug, array($this, "settingDeliveryDate"));
            add_submenu_page('', 'Import', '', 'install_plugins', 'rpesp-import-shipping', array($this, 'importShippingTime'));
        }

        public function settingDeliveryDate()
        {
            /* save delivery date setting */
            if (isset($_POST[self::$plugin_slug])) {
                $this->saveSetting();
            }

            /* include admin  delivery date setting file */
            include_once self::$plugin_dir . "view/delivery-date-setting.php";
        }

        public function saveSetting()
        {
            $arrayRemove = array(self::$plugin_slug, "btn-rpesp-submit");
            $saveData = array();
            foreach ($_POST as $key => $value):
                if (in_array($key, $arrayRemove))
                    continue;
                $saveData[$key] = $value;
            endforeach;
            $this->rpesp_settings = $saveData;
            update_option(self::$rpesp_option_key, $saveData);
        }

        public function get_setting($key)
        {

            if (!$key || $key == "")
                return;

            if (isset($this->rpesp_settings[$key]))
                return $this->rpesp_settings[$key];

            if (isset(self::$default_setting[$key]))
                return self::$default_setting[$key];
        }

    }

}
/* load plugin if woocommerce plugin is activated */
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    /* load shipping calculator plugin code */
    new RpEestimatedDeliveryDate();
}
